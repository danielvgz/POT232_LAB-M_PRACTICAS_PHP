<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userRole = $user && isset($user['rol']) ? strtolower($user['rol']) : '';
$isAdmin = $userRole === 'admin';
$isProfesor = in_array($userRole, array('maestro', 'profesor'), true);
$roleLabel = $isProfesor ? 'profesor' : $userRole;
$localAssetsBase = rtrim(BASE_URL, '/\\') . '/../Alumnos-Crud/assets';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Escuela IT</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($localAssetsBase . '/css/bootstrap.min.css'); ?>" onerror="this.onerror=null;this.href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($localAssetsBase . '/css/bootstrap-theme.min.css'); ?>" onerror="this.onerror=null;this.href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css';">
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?controller=home&action=index">Escuela IT</a>
        </div>
        <?php if ($user): ?>
            <ul class="nav navbar-nav">
                <li><a href="index.php?controller=home&action=index">Inicio</a></li>
                <li><a href="index.php?controller=profile&action=index">Mi perfil</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="index.php?controller=alumnos&action=index">Alumnos</a></li>
                    <li><a href="index.php?controller=docentes&action=index">Docentes</a></li>
                    <li><a href="index.php?controller=materias&action=index">Materias</a></li>
                <?php endif; ?>
                <?php if ($isProfesor || $isAdmin): ?>
                    <li><a href="index.php?controller=matriculas&action=index">Asignaciones</a></li>
                <?php endif; ?>
                <?php if ($userRole === 'alumno'): ?>
                    <li><a href="index.php?controller=matriculas&action=index">Matriculas inscritas</a></li>
                <?php endif; ?>
                <?php if ($userRole === 'admin'): ?>
                    <li><a href="index.php?controller=users&action=index">Usuarios</a></li>
                    <li><a href="index.php?controller=acciones&action=index">Acciones</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><?php echo htmlspecialchars($user['correo']); ?> (<?php echo htmlspecialchars($roleLabel); ?>)</a></li>
                <li><a href="index.php?controller=auth&action=logout">Salir</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
