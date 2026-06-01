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

    protected function isAdmin()
    {
        return $this->currentRole() === 'admin';
    }

    protected function isProfesor()
    {
        return in_array($this->currentRole(), array('maestro', 'profesor'), true);
    }

    protected function isAlumno()
    {
        return $this->currentRole() === 'alumno';
    }

    protected function paginateRows(array $rows, $page = 1, $perPage = 10)
    {
        $page = max(1, (int) $page);
        $perPage = max(1, (int) $perPage);
        $total = count($rows);
        $pages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $pages);

        return array(
            'rows' => array_slice($rows, ($page - 1) * $perPage, $perPage),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'pages' => $pages,
        );
    }

    protected function logAction($accion, $entidad, $detalle = '')
    {
        if (!isset($_SESSION['user'])) {
            return;
        }

        require_once BASE_PATH . '/models/AccionModel.php';
        $model = new AccionModel();
        $user = $this->currentUser();
        $model->record(array(
            'user_id' => isset($user['id']) ? (int) $user['id'] : null,
            'rol' => isset($user['rol']) ? $user['rol'] : '',
            'accion' => $accion,
            'entidad' => $entidad,
            'detalle' => $detalle,
        ));
    }
}
