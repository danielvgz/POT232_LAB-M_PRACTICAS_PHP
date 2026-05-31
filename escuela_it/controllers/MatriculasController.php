<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/MatriculaModel.php';

class MatriculasController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new MatriculaModel();
    }

    public function index()
    {
        $this->requireAuth();
        $user = $this->currentUser();
        $role = isset($user['rol']) ? strtolower($user['rol']) : '';
        $isProfesor = in_array($role, array('maestro', 'profesor'), true);

        if ($role === 'alumno') {
            $rows = !empty($user['alumno_id']) ? $this->model->byAlumnoId((int) $user['alumno_id']) : array();
        } elseif ($isProfesor) {
            $rows = !empty($user['docente_id']) ? $this->model->byDocenteId((int) $user['docente_id']) : array();
        } else {
            $rows = array();
        }

        $this->view('matriculas/index', array(
            'rows' => $rows,
            'canManage' => $isProfesor,
            'title' => $isProfesor ? 'Asignaciones y alumnos inscritos' : 'Mis matriculas inscritas',
        ));
    }

    public function form()
    {
        $this->requireRole(array('maestro', 'profesor'));
        $user = $this->currentUser();
        $row = array('id' => '', 'alumno_id' => '', 'docente_id' => isset($user['docente_id']) ? (int) $user['docente_id'] : '', 'materia_id' => '', 'fecha_matricula' => date('Y-m-d'));
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found && (int) $found['docente_id'] === (int) $user['docente_id']) {
                $row = $found;
            } else {
                header('Location: index.php?controller=matriculas&action=index');
                exit;
            }
        }

        $this->view('matriculas/form', array(
            'row' => $row,
            'alumnos' => $this->model->alumnos(),
            'materias' => $this->model->materias(),
        ));
    }

    public function save()
    {
        $this->requireRole(array('maestro', 'profesor'));
        $user = $this->currentUser();
        $data = array(
            'id' => $this->clean('id'),
            'alumno_id' => (int) $this->clean('alumno_id'),
            'docente_id' => (int) $user['docente_id'],
            'materia_id' => (int) $this->clean('materia_id'),
            'fecha_matricula' => $this->clean('fecha_matricula', date('Y-m-d')),
        );

        $this->model->save($data);
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('maestro', 'profesor'));
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            $user = $this->currentUser();
            if ($found && (int) $found['docente_id'] === (int) $user['docente_id']) {
                $this->model->delete((int) $_GET['id']);
            }
        }
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }
}
