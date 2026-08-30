<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/MateriaModel.php';

class MateriasController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new MateriaModel();
    }

    public function index()
    {
        $this->requireAuth();
        $rows = $this->model->all();
        $this->view('materias/index', array('rows' => $rows));
    }

    public function form()
    {
        $this->requireAuth();
        $row = array('id' => '', 'nombre' => '', 'descripcion' => '');
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }
        $this->view('materias/form', array('row' => $row));
    }

    public function save()
    {
        $this->requireAuth();
        $data = array(
            'id' => $this->clean('id'),
            'nombre' => $this->clean('nombre'),
            'descripcion' => $this->clean('descripcion'),
        );
        $this->model->save($data);
        header('Location: index.php?controller=materias&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireAuth();
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
        }
        header('Location: index.php?controller=materias&action=index');
        exit;
    }
}
