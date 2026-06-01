<?php
require_once 'models/docentes.entidad.php';
require_once 'models/docentes.model.php';

class DocenteController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new DocenteModel();
    }

    public function Index(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $paginaActual = max(1, (int)($_GET['page'] ?? 1));
        $porPagina = 10;
        $offset = ($paginaActual - 1) * $porPagina;
        $docentes = $this->model->ListarPaginado($porPagina, $offset);
        $totalRegistros = $this->model->Contar();
        $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
        require_once 'views/header.php';
        require_once 'views/docentes/index.php';
        require_once 'views/footer.php';
    }

    public function Crud(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $docente = new Docente();

        if(isset($_REQUEST['id'])){
            $docente = $this->model->Obtener($_REQUEST['id']);
        }

        require_once 'views/header.php';
        require_once 'views/docentes/editar.php';
        require_once 'views/footer.php';
    }

    public function Guardar(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $docente = new Docente();

        $docente->id           = $_REQUEST['id'];
        $docente->nombre       = $_REQUEST['nombre'];
        $docente->apellido     = $_REQUEST['apellido'];
        $docente->email        = $_REQUEST['email'];
        $docente->especialidad = $_REQUEST['especialidad'];

        if($docente->id != '' ? 
            $this->model->Actualizar($docente) : 
            $this->model->Registrar($docente));

        header('Location: index.php?c=Docente');
    }

    public function Eliminar(){
        if (($this->rolActual() !== 'admin')) {
            header('Location: index.php?c=Alumno&msg=sin_permiso');
            exit;
        }

        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php?c=Docente');
    }

    private function rolActual()
    {
        return $_SESSION['usuario_rol'] ?? '';
    }
}
