<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : array();
$role = isset($user['rol']) ? strtolower($user['rol']) : '';
$isProfesor = in_array($role, array('maestro', 'profesor'), true);
?>
<div class="jumbotron">
    <h2>Bienvenido a Escuela IT</h2>
    <?php if ($isProfesor): ?>
        <p>Como profesor, puedes gestionar asignaciones y ver los alumnos inscritos en tus materias.</p>
        <p><a class="btn btn-primary btn-lg" href="index.php?controller=matriculas&action=index">Ver asignaciones</a></p>
    <?php else: ?>
        <p>Como alumno, aqui solo veras tus matriculas inscritas.</p>
        <p><a class="btn btn-primary btn-lg" href="index.php?controller=matriculas&action=index">Ver mis matriculas</a></p>
    <?php endif; ?>
</div>
