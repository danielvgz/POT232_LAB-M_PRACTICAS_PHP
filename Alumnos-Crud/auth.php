<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_correo'])) {
    header('Location: index.php?action=login');
    exit;
}
