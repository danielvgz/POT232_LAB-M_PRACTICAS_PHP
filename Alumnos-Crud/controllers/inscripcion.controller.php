<?php
require_once 'models/inscripcion.model.php';

class InscripcionController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new InscripcionModel();
    }

    public function Index()
    {
        $rolActual = $_SESSION['usuario_rol'] ?? '';
        if ($rolActual !== 'alumno') {
            header('Location: index.php?c=Alumno&msg=sin_permiso_inscripcion');
            exit;
        }

        $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
        $correoUsuario = (string)($_SESSION['usuario_correo'] ?? '');
        $idAlumno = $this->model->ObtenerAlumnoIdPorUsuario($idUsuario, $correoUsuario);

        $mensaje = '';
        $inscripciones = [];
        $asignacionesDisponibles = [];
        $totalCreditos = 0;
        $paginaActual = max(1, (int)($_GET['page'] ?? 1));
        $porPagina = 10;
        $totalPaginas = 1;

        if ($idAlumno) {
            $totalRegistros = $this->model->ContarPorAlumno($idAlumno);
            $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
            $offset = ($paginaActual - 1) * $porPagina;
            $inscripciones = $this->model->ListarPorAlumnoPaginado($idAlumno, $porPagina, $offset);
            $asignacionesDisponibles = $this->model->ListarAsignacionesDisponibles($idAlumno);
            $totalCreditos = $this->model->ObtenerTotalCreditosPorAlumno($idAlumno);
        } else {
            $mensaje = 'No se encontró un alumno relacionado con su usuario.';
        }

        require_once 'views/header.php';
        require_once 'views/inscripcion/index.php';
        require_once 'views/footer.php';
    }

    public function Guardar()
    {
        $rolActual = $_SESSION['usuario_rol'] ?? '';
        if ($rolActual !== 'alumno') {
            header('Location: index.php?c=Inscripcion&msg=sin_permiso');
            exit;
        }

        $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
        $correoUsuario = (string)($_SESSION['usuario_correo'] ?? '');
        $idAlumno = $this->model->ObtenerAlumnoIdPorUsuario($idUsuario, $correoUsuario);
        if (!$idAlumno) {
            header('Location: index.php?c=Inscripcion&msg=alumno_no_encontrado');
            exit;
        }

        $idAsignacionDocente = (int)($_POST['id_asignacion_docente'] ?? 0);
        if ($idAsignacionDocente <= 0) {
            header('Location: index.php?c=Inscripcion&msg=matricula_invalida');
            exit;
        }

        $inscripcion = new Inscripcion();
        $inscripcion->__SET('id_alumno', $idAlumno);
        $inscripcion->__SET('id_asignacion_docente', $idAsignacionDocente);
        $inscripcion->__SET('fecha_inscripcion', date('Y-m-d'));

        try {
            $this->model->Registrar($inscripcion);
            header('Location: index.php?c=Inscripcion&msg=inscripcion_ok');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?c=Inscripcion&msg=' . urlencode($e->getMessage()));
            exit;
        }
    }
}
