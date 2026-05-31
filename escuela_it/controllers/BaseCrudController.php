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

    protected function currentUser()
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    protected function currentRole()
    {
        $user = $this->currentUser();
        return isset($user['rol']) ? strtolower($user['rol']) : '';
    }

    protected function requireRole($roles)
    {
        $this->requireAuth();
        $role = $this->currentRole();
        $allowed = array_map('strtolower', (array) $roles);
        if (!in_array($role, $allowed, true)) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }
    }

    protected function clean($key, $default = '')
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }
}
