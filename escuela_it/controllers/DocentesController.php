<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/DocenteModel.php';

class DocentesController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new DocenteModel();
    }

    public function index()
    {
        $this->requireRole(array('admin'));
        $rows = $this->paginateRows($this->model->all(), isset($_GET['page']) ? (int) $_GET['page'] : 1, 10);
        $this->view('docentes/index', $rows);
    }

    public function form()
    {
        $this->requireRole(array('admin'));
        $row = array('id' => '', 'nombre' => '', 'apellido' => '', 'sexo' => '1', 'fecha_nacimiento' => '', 'fecha_registro' => date('Y-m-d'), 'foto' => '', 'correo' => '');
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }
        $this->view('docentes/form', array('row' => $row));
    }

    public function save()
    {
        $this->requireRole(array('admin'));
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
        $this->logAction('update', 'docentes', 'actualizo un docente');
        header('Location: index.php?controller=docentes&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('admin'));
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
            $this->logAction('delete', 'docentes', 'elimino un docente');
        }
        header('Location: index.php?controller=docentes&action=index');
        exit;
    }
}
