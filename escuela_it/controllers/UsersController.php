<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/UserModel.php';

class UsersController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $this->requireRole(array('admin'));
        $rows = $this->paginateRows($this->model->all(), isset($_GET['page']) ? (int) $_GET['page'] : 1, 10);
        $this->view('users/index', $rows);
    }

    public function form()
    {
        $this->requireRole(array('admin'));
        $row = array('id' => '', 'correo' => '', 'rol' => 'alumno', 'alumno_id' => '', 'docente_id' => '');
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found) {
                $row = $found;
            }
        }

        $this->view('users/form', array(
            'row' => $row,
            'profiles' => $this->model->profiles(),
        ));
    }

    public function save()
    {
        $this->requireRole(array('admin'));
        $this->model->save(array(
            'id' => $this->clean('id'),
            'correo' => $this->clean('correo'),
            'password' => $this->clean('password'),
            'rol' => $this->clean('rol'),
            'alumno_id' => $this->clean('alumno_id'),
            'docente_id' => $this->clean('docente_id'),
        ));
        $this->logAction('update', 'usuarios', 'admin gestiono usuarios');
        header('Location: index.php?controller=users&action=index');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('admin'));
        if (!empty($_GET['id'])) {
            $this->model->delete((int) $_GET['id']);
            $this->logAction('delete', 'usuarios', 'elimino un usuario');
        }
        header('Location: index.php?controller=users&action=index');
        exit;
    }
}
