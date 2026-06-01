<?php
require_once 'models/alumno.entidad.php';
require_once 'models/alumno.model.php';
require_once 'models/usuario.model.php';

class AlumnoController{
    
    private $model;
    private $usuarioModel;
    
    public function __CONSTRUCT(){
        $this->model = new AlumnoModel();
        $this->usuarioModel = new UsuarioModel();
    }
    
    public function Index(){
        $rolActual = $_SESSION['usuario_rol'] ?? '';
        if ($rolActual === 'alumno') {
            header('Location: index.php?c=Alumno&a=Perfil');
            exit;
        }

        if (in_array($rolActual, ['profesor', 'docente'], true)) {
            $perfil = $this->usuarioModel->ObtenerPerfil((int)($_SESSION['usuario_id'] ?? 0));
            $idDocente = (int)($perfil->docente_id ?? 0);
            if (!$idDocente) {
                header('Location: index.php?c=Alumno&a=Perfil&msg=docente_no_encontrado');
                exit;
            }

            $idAsignacionDocente = (int)($_GET['matricula'] ?? 0);
            $paginaActual = max(1, (int)($_GET['page'] ?? 1));
            $porPagina = 10;
            $offset = ($paginaActual - 1) * $porPagina;

            $alumnos = $this->model->ListarPorDocente(
                $idDocente,
                $idAsignacionDocente > 0 ? $idAsignacionDocente : null,
                $porPagina,
                $offset
            );
            $totalRegistros = $this->model->ContarPorDocente(
                $idDocente,
                $idAsignacionDocente > 0 ? $idAsignacionDocente : null
            );
            $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
            $asignaciones = $this->model->ListarAsignacionesDeDocente($idDocente);

            require_once 'views/header.php';
            require_once 'views/alumno/alumno-docente.php';
            require_once 'views/footer.php';
            return;
        }

        $paginaActual = max(1, (int)($_GET['page'] ?? 1));
        $porPagina = 10;
        $offset = ($paginaActual - 1) * $porPagina;
        $alumnos = $this->model->ListarPaginado($porPagina, $offset);
        $totalRegistros = $this->model->Contar();
        $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
        $usuariosAlumno = $this->usuarioModel->ListarAlumnos();
        $esAdmin = true;
        $puedeExportar = true;

        require_once 'views/header.php';
        require_once 'views/alumno/alumno.php';
        require_once 'views/footer.php';
    }

    public function Perfil()
    {
        $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
        $perfil = $this->usuarioModel->ObtenerPerfil($idUsuario);

        if (!$perfil) {
            header('Location: index.php?action=login');
            exit;
        }

        $mensaje = '';
        if (!empty($_GET['msg'])) {
            $mensaje = $_GET['msg'] === 'guardado'
                ? 'Perfil actualizado correctamente.'
                : (string)$_GET['msg'];
        }

        require_once 'views/header.php';
        require_once 'views/alumno/perfil.php';
        require_once 'views/footer.php';
    }

    public function GuardarPerfil()
    {
        try {
            $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
            $datos = [
                'username' => $_POST['username'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'password' => $_POST['password'] ?? '',
                'nombre' => $_POST['nombre'] ?? '',
                'apellido' => $_POST['apellido'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'especialidad' => $_POST['especialidad'] ?? '',
            ];

            $this->usuarioModel->ActualizarPerfil($idUsuario, $datos);
            header('Location: index.php?c=Alumno&a=Perfil&msg=guardado');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?c=Alumno&a=Perfil&msg=' . urlencode($e->getMessage()));
            exit;
        }
    }
    
    public function Crud(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $alm = new Alumno();
        
        if(isset($_REQUEST['id'])){
            $alm = $this->model->Obtener($_REQUEST['id']);
        }
        
        require_once 'views/header.php';
        require_once 'views/alumno/alumno-editar.php';
        require_once 'views/footer.php';
    }
    
    public function Guardar(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $alm = new Alumno();
        
        $alm->__SET('id',              $_REQUEST['id']);
        $alm->__SET('Nombre',          $_REQUEST['Nombre']);
        $alm->__SET('Apellido',        $_REQUEST['Apellido']);
        $alm->__SET('Sexo',            $_REQUEST['Sexo']);
        $alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);
        $alm->__SET('Correo',          $_REQUEST['Correo']);
        $alm->__SET('Foto',            $_REQUEST['Foto']);
        
        if( !empty( $_FILES['Foto']['name'] ) ){
            $foto = date('ymdhis') . '-' . strtolower($_FILES['Foto']['name']);
            move_uploaded_file ($_FILES['Foto']['tmp_name'], 'uploads/' . $foto);
            
            $alm->__SET('Foto', $foto);
        }

        if($alm->__GET('id') != '' ? 
           $this->model->Actualizar($alm) : 
           $this->model->Registrar($alm));
        
        header('Location: index.php');
    }
    
    public function Excel(){
        $rolActual = $this->rolActual();
        if (!in_array($rolActual, ['admin', 'docente', 'profesor'], true)) {
            header('Location: index.php?c=Alumno&msg=sin_permiso_exportar');
            exit;
        }

        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=mi_archivo.xls");
        header("Pragma: no-cache");
        header("Expires: 0");    

        if ($rolActual === 'admin') {
            $alumnosExport = $this->model->Listar();
        } else {
            $perfil = $this->usuarioModel->ObtenerPerfil((int)($_SESSION['usuario_id'] ?? 0));
            $idDocente = (int)($perfil->docente_id ?? 0);
            $idAsignacionDocente = (int)($_GET['matricula'] ?? 0);
            $alumnosExport = $this->model->ListarPorDocente(
                $idDocente,
                $idAsignacionDocente > 0 ? $idAsignacionDocente : null
            );
        }
        
        require_once 'views/alumno/alumno-excel.php';
    }
    
    public function Eliminar(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php');
    }

    private function rolActual()
    {
        return $_SESSION['usuario_rol'] ?? '';
    }
}
