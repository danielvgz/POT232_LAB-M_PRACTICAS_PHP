<?php
class BaseCrudController
{
    protected function requireAuth()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    protected function view($template, $data = array())
    {
        extract($data);
        require BASE_PATH . '/views/layout/header.php';
        require BASE_PATH . '/views/' . $template . '.php';
        require BASE_PATH . '/views/layout/footer.php';
    }

    protected function clean($key, $default = '')
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }
}
