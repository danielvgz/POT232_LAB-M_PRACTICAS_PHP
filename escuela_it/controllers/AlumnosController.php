<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/AlumnoModel.php';

class AlumnosController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new AlumnoModel();
    }

    public function index()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $rows = $this->paginateRows($this->model->all(), isset($_GET['page']) ? (int) $_GET['page'] : 1, 10);
        $this->view('alumnos/index', $rows);
    }

    public function form()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $row = array('id' => '', 'nombre' => '', 'apellido' => '', 'sexo' => '1', 'fecha_nacimiento' => '', 'fecha_registro' => date('Y-m-d'), 'foto' => '', 'correo' => '');
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }
        $this->view('alumnos/form', array('row' => $row));
    }

    public function save()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $data = array(
            'id' => $this->clean('id'),
            'nombre' => $this->clean('nombre'),
            'apellido' => $this->clean('apellido'),
            'sexo' => (int) $this->clean('sexo', 1),
            'fecha_nacimiento' => $this->clean('fecha_nacimiento', null),
            'fecha_registro' => $this->clean('fecha_registro', date('Y-m-d')),
            'foto' => $this->clean('foto', 'sin-foto.png'),
            'correo' => $this->clean('correo'),
        );
        $this->model->save($data);
        $this->logAction('update', 'alumnos', 'actualizo un alumno');
        header('Location: index.php?controller=alumnos&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
            $this->logAction('delete', 'alumnos', 'elimino un alumno');
        }
        header('Location: index.php?controller=alumnos&action=index');
        exit;
    }
}
