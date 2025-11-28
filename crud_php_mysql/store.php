<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$cedula = trim($_POST['cedula'] ?? '');
$fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');

if ($nombre === '' || $email === '') {
    header('Location: create.php?msg=' . urlencode('Nombre y email son obligatorios'));
    exit;
}

$st = $pdo->prepare('INSERT INTO users (nombre, email, telefono, cedula, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)');
$st->execute([$nombre, $email, $telefono, $cedula, $fecha_nacimiento]);

header('Location: index.php?msg=' . urlencode('Usuario creado correctamente'));
exit;
