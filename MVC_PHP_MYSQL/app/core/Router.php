<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $paths = [
        ROOT_PATH . '/app/core/' . $class . '.php',
        ROOT_PATH . '/app/controllers/' . $class . '.php',
        ROOT_PATH . '/app/models/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

class Router
{
    public function dispatch(): void
    {
        Auth::start();

        $controller = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['c'] ?? 'Auth');
        $action = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['a'] ?? 'login');

        $controller = $controller !== '' ? ucfirst($controller) : 'Auth';
        $action = $action !== '' ? $action : 'login';

        $controllerClass = $controller . 'Controller';

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo 'Controlador no encontrado';
            return;
        }

        $instance = new $controllerClass();
        if (!method_exists($instance, $action)) {
            http_response_code(404);
            echo 'Acción no encontrada';
            return;
        }

        try {
            $instance->{$action}();
        } catch (Throwable $exception) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash'] = ['type' => 'danger', 'message' => $exception->getMessage()];
            $fallback = Auth::check() ? 'Dashboard' : 'Auth';
            $fallbackAction = Auth::check() ? 'index' : 'login';
            header('Location: ' . BASE_URL . '/index.php?c=' . $fallback . '&a=' . $fallbackAction);
            exit;
        }
    }
}
