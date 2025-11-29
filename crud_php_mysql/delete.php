<?php
require_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php?msg=' . urlencode('ID inválido'));
    exit;
}

$st = $pdo->prepare('DELETE FROM personas WHERE id = ?');
$st->execute([$id]);

header('Location: index.php?msg=' . urlencode('Usuario eliminado'));
exit;
