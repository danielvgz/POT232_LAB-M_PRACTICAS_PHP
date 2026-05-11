<?php
require_once 'models/Home.model.php';

class HomeController {

    private $model;

    public function __CONSTRUCT() {
        $this->model = new HomeModel();
    }

    public function Index() {
        $bienvenida = $this->model->getBienvenida();
        require_once 'views/header.php';
        require_once 'views/Home/dashboard.php';
        require_once 'views/footer.php';
    }
}
