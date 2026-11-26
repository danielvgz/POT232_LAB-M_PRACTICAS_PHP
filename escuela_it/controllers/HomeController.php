<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';

class HomeController extends BaseCrudController
{
    public function index()
    {
        $this->requireAuth();
        $this->view('home/index');
    }
}
