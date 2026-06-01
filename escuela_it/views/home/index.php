<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : array();
$role = isset($user['rol']) ? strtolower($user['rol']) : '';
$isProfesor = in_array($role, array('maestro', 'profesor'), true);
?>
<div class="jumbotron">
    <h2>Bienvenido a Escuela IT</h2>
    <?php if ($role === 'admin'): ?>
        <p>Como administrador puedes gestionar usuarios, perfiles, acciones y los registros principales.</p>
        <p><a class="btn btn-primary btn-lg" href="index.php?controller=users&action=index">Gestionar usuarios</a></p>
    <?php elseif ($isProfesor): ?>
        <p>Como profesor puedes ver tus alumnos, calificar matriculas y exportar la lista.</p>
        <p><a class="btn btn-primary btn-lg" href="index.php?controller=matriculas&action=index">Ver asignaciones</a></p>
    <?php else: ?>
        <p>Como alumno puedes inscribirte y revisar tus calificaciones.</p>
        <p><a class="btn btn-primary btn-lg" href="index.php?controller=matriculas&action=index">Ver mis matriculas</a></p>
    <?php endif; ?>
</div>
