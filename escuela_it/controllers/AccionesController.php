<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/AccionModel.php';

class AccionesController extends BaseCrudController
{
    private $model;

    public function __construct()
    {
        $this->model = new AccionModel();
    }

    public function index()
    {
        $this->requireRole(array('admin'));
        $rows = $this->paginateRows($this->model->all(), isset($_GET['page']) ? (int) $_GET['page'] : 1, 10);
        $this->view('acciones/index', $rows);
    }
}
