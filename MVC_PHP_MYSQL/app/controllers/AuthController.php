<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('Dashboard', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim((string)($_POST['identifier'] ?? ''));
            $password = (string)($_POST['password'] ?? '');

            if (Auth::login($identifier, $password)) {
                $this->setFlash('success', 'Bienvenido al sistema.');
                $this->redirect('Dashboard', 'index');
            }

            $this->setFlash('danger', 'Credenciales inválidas.');
        }

        $this->render('auth/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('Auth', 'login');
    }
}
