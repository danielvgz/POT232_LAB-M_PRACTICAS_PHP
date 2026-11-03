<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Crud de Alumnos</title>
        
        <meta charset="utf-8" />
        
        <link rel="stylesheet" href="<?php echo RUTA_HTTP; ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo RUTA_HTTP; ?>assets/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="<?php echo RUTA_HTTP; ?>assets/js/jquery-ui/jquery-ui.min.css" />
        <link rel="stylesheet" href="<?php echo RUTA_HTTP; ?>assets/js/jquery-ui/jquery-ui.theme.min.css" />
        <link rel="stylesheet" href="<?php echo RUTA_HTTP; ?>assets/css/style.css" />
        
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
	</head>
    <body>
        
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
                    <?php if (!empty($_SESSION['auth_user'])): ?>
                        <ul class="nav nav-pills" style="margin-top:15px; margin-bottom:15px;">
                            <li><a href="index.php?c=Alumno">Alumnos</a></li>
                            <li><a href="index.php?c=Docente">Docentes</a></li>
                            <li class="pull-right"><a href="logout.php">Cerrar sesión</a></li>
                        </ul>
                    <?php endif; ?>
