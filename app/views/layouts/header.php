<?php $currentUser = Auth::user(); ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POT232 MVC</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/bootstrap-3.3.17/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php?c=Dashboard&a=index">POT232 MVC</a>
        </div>
        <?php if ($currentUser): ?>
            <ul class="nav navbar-nav">
                <?php if ($currentUser['rol'] === 'admin'): ?>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Alumnos&a=index">Alumnos</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Docentes&a=index">Docentes</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Usuarios&a=index">Usuarios</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Asignaciones&a=index">Asignaciones</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=AsignacionesDocente&a=index">Asignación Docente</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=index">Inscripciones</a></li>
                <?php endif; ?>
                <?php if ($currentUser['rol'] === 'docente'): ?>
                    <li><a href="<?= BASE_URL ?>/index.php?c=AsignacionesDocente&a=index">Mis asignaciones</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=index">Alumnos inscritos</a></li>
                <?php endif; ?>
                <?php if ($currentUser['rol'] === 'alumno'): ?>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=available">Inscribirme</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?c=Inscripciones&a=myEnrollments">Mis inscripciones</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Rol: <?= htmlspecialchars((string)$currentUser['rol']) ?></a></li>
                <li><a href="<?= BASE_URL ?>/index.php?c=Auth&a=logout">Salir</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
    <?php if (!empty($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
        <div class="alert alert-<?= htmlspecialchars((string)$flash['type']) ?>"><?= htmlspecialchars((string)$flash['message']) ?></div>
    <?php endif; ?>
