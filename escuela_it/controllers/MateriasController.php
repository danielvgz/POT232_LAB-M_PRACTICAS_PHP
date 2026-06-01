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
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $rows = $this->paginateRows($this->model->all(), isset($_GET['page']) ? (int) $_GET['page'] : 1, 10);
        $this->view('materias/index', $rows);
    }

    public function form()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $row = array('id' => '', 'nombre' => '', 'descripcion' => '', 'creditos' => 3, 'docente_id' => '');
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }
        $this->view('materias/form', array('row' => $row, 'docentes' => $this->model->docentes()));
    }

    public function save()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $data = array(
            'id' => $this->clean('id'),
            'nombre' => $this->clean('nombre'),
            'descripcion' => $this->clean('descripcion'),
            'creditos' => $this->clean('creditos', 3),
            'docente_id' => $this->clean('docente_id'),
        );
        $this->model->save($data);
        $this->logAction('update', 'materias', 'actualizo una materia');
        header('Location: index.php?controller=materias&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
            $this->logAction('delete', 'materias', 'elimino una materia');
        }
        header('Location: index.php?controller=materias&action=index');
        exit;
    }
}
