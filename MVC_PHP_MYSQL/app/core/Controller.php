<?php

declare(strict_types=1);

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require ROOT_PATH . '/app/views/layouts/header.php';
        require ROOT_PATH . '/app/views/' . $view . '.php';
        require ROOT_PATH . '/app/views/layouts/footer.php';
    }

    protected function redirect(string $controller, string $action = 'index', array $params = []): void
    {
        $query = array_merge(['c' => $controller, 'a' => $action], $params);
        header('Location: ' . BASE_URL . '/index.php?' . http_build_query($query));
        exit;
    }

    protected function setFlash(string $type, string $message): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
