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
        $rows = $this->model->all();
        $this->view('matriculas/index', array('rows' => $rows));
    }

    public function form()
    {
        $this->requireAuth();
        $row = array('id' => '', 'alumno_id' => '', 'docente_id' => '', 'materia_id' => '', 'fecha_matricula' => date('Y-m-d'));
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }

        $this->view('matriculas/form', array(
            'row' => $row,
            'alumnos' => $this->model->alumnos(),
            'docentes' => $this->model->docentes(),
            'materias' => $this->model->materias(),
        ));
    }

    public function save()
    {
        $this->requireAuth();
        $data = array(
            'id' => $this->clean('id'),
            'alumno_id' => (int) $this->clean('alumno_id'),
            'docente_id' => (int) $this->clean('docente_id'),
            'materia_id' => (int) $this->clean('materia_id'),
            'fecha_matricula' => $this->clean('fecha_matricula', date('Y-m-d')),
        );

        $this->model->save($data);
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireAuth();
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
        }
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }
}
