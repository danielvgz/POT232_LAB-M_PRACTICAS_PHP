<?php $user = isset($_SESSION['user']) ? $_SESSION['user'] : null; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Escuela IT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.17/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.17/css/bootstrap-theme.min.css">
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?controller=home&action=index">Escuela IT</a>
        </div>
        <?php if ($user): ?>
            <ul class="nav navbar-nav">
                <li><a href="index.php?controller=alumnos&action=index">Alumnos</a></li>
                <li><a href="index.php?controller=docentes&action=index">Docentes</a></li>
                <li><a href="index.php?controller=materias&action=index">Materias</a></li>
                <li><a href="index.php?controller=matriculas&action=index">Matriculas</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><?php echo htmlspecialchars($user['correo']); ?> (<?php echo htmlspecialchars($user['rol']); ?>)</a></li>
                <li><a href="index.php?controller=auth&action=logout">Salir</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
