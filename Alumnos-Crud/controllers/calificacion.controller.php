<?php
require_once 'models/calificacion.model.php';

class CalificacionController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new CalificacionModel();
    }

    public function Index()
    {
        $rolActual = $_SESSION['usuario_rol'] ?? '';
        $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
        $correoUsuario = (string)($_SESSION['usuario_correo'] ?? '');
        $mensaje = '';
        $registros = [];
        $vista = 'sin_permiso';
        $paginaActual = max(1, (int)($_GET['page'] ?? 1));
        $porPagina = 10;
        $totalPaginas = 1;

        if (in_array($rolActual, ['profesor', 'docente'], true)) {
            $idDocente = $this->model->ObtenerDocenteIdPorUsuario($idUsuario, $correoUsuario);
            if ($idDocente) {
                $totalRegistros = $this->model->ContarParaDocente($idDocente);
                $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
                $offset = ($paginaActual - 1) * $porPagina;
                $registros = $this->model->ListarParaDocentePaginado($idDocente, $porPagina, $offset);
                $vista = 'docente';
            } else {
                $mensaje = 'No se encontró un docente relacionado con su usuario.';
            }
        } elseif ($rolActual === 'admin') {
            $totalRegistros = $this->model->ContarTodos();
            $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
            $offset = ($paginaActual - 1) * $porPagina;
            $registros = $this->model->ListarTodosPaginado($porPagina, $offset);
            $vista = 'admin';
        } elseif ($rolActual === 'alumno') {
            $idAlumno = $this->model->ObtenerAlumnoIdPorUsuario($idUsuario, $correoUsuario);
            if ($idAlumno) {
                $totalRegistros = $this->model->ContarParaAlumno($idAlumno);
                $totalPaginas = max(1, (int)ceil($totalRegistros / $porPagina));
                $offset = ($paginaActual - 1) * $porPagina;
                $registros = $this->model->ListarParaAlumnoPaginado($idAlumno, $porPagina, $offset);
                $vista = 'alumno';
            } else {
                $mensaje = 'No se encontró un alumno relacionado con su usuario.';
            }
        }

        require_once 'views/header.php';
        require_once 'views/calificaciones/index.php';
        require_once 'views/footer.php';
    }

    public function Guardar()
    {
        $rolActual = $_SESSION['usuario_rol'] ?? '';
        if (!in_array($rolActual, ['profesor', 'docente'], true)) {
            header('Location: index.php?c=Calificacion&msg=sin_permiso');
            exit;
        }

        $idUsuario = (int)($_SESSION['usuario_id'] ?? 0);
        $correoUsuario = (string)($_SESSION['usuario_correo'] ?? '');
        $idDocente = $this->model->ObtenerDocenteIdPorUsuario($idUsuario, $correoUsuario);
        if (!$idDocente) {
            header('Location: index.php?c=Calificacion&msg=docente_no_encontrado');
            exit;
        }

        $idInscripcion = (int)($_POST['id_inscripcion'] ?? 0);
        if ($idInscripcion <= 0) {
            header('Location: index.php?c=Calificacion&msg=inscripcion_invalida');
            exit;
        }

        try {
            $evaluaciones = [
                'evaluacion1' => $this->normalizarNota($_POST['evaluacion1'] ?? null),
                'evaluacion2' => $this->normalizarNota($_POST['evaluacion2'] ?? null),
                'evaluacion3' => $this->normalizarNota($_POST['evaluacion3'] ?? null),
                'evaluacion4' => $this->normalizarNota($_POST['evaluacion4'] ?? null),
            ];

            $this->model->GuardarParaDocente($idInscripcion, $idDocente, $evaluaciones);
            header('Location: index.php?c=Calificacion&msg=guardado');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?c=Calificacion&msg=error_validacion');
            exit;
        }
    }

    private function normalizarNota($valor)
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        $valor = str_replace(',', '.', (string)$valor);
        if (!is_numeric($valor)) {
            throw new Exception('Nota inválida');
        }

        $nota = round((float)$valor, 2);
        if ($nota < 0 || $nota > 10) {
            throw new Exception('Nota fuera de rango');
        }

        return $nota;
    }
}
