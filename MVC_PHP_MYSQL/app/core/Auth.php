<?php

declare(strict_types=1);

class Auth
{
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function user(): ?array
    {
        self::start();
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function login(string $identifier, string $password): bool
    {
        self::start();
        $stmt = Database::connection()->prepare('SELECT id, username, correo, password_hash, rol, alumno_id, docente_id FROM usuarios WHERE username = :identifier OR correo = :identifier LIMIT 1');
        $stmt->execute(['identifier' => $identifier]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        unset($user['password_hash']);
        $_SESSION['user'] = $user;
        return true;
    }

    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/index.php?c=Auth&a=login');
            exit;
        }
    }

    public static function requireRole(array $roles): void
    {
        $user = self::user();
        if (!$user || !in_array($user['rol'], $roles, true)) {
            header('Location: ' . BASE_URL . '/index.php?c=Dashboard&a=index');
            exit;
        }
    }
}
