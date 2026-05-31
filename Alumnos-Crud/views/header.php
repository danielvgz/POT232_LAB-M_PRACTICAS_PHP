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
            <?php if (!empty($_SESSION['usuario_username'])): ?>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <small>
                            Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario_username']); ?></strong>
                            (Rol: <?php echo htmlspecialchars(($_SESSION['usuario_rol'] ?? '') === 'docente' ? 'profesor' : ($_SESSION['usuario_rol'] ?? '')); ?>)
                        </small>
                        |
                        <a href="index.php?action=logout">Cerrar sesión</a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-12">
