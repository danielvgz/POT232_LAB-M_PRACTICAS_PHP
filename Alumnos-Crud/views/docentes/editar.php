<?php include '../includes/navbar.php'; ?>
<h2><?= isset($docente->id) && $docente->id ? 'Editar' : 'Agregar' ?> Docente</h2>
<form method="post" action="docentes.controller.php?action=<?= isset($docente->id) && $docente->id ? 'actualizar' : 'registrar' ?>">
    <?php if (isset($docente->id) && $docente->id): ?>
        <input type="hidden" name="id" value="<?= $docente->id ?>">
    <?php endif; ?>
    <label>Nombre: <input type="text" name="nombre" value="<?= $docente->nombre ?? '' ?>" required></label><br>
    <label>Apellido: <input type="text" name="apellido" value="<?= $docente->apellido ?? '' ?>" required></label><br>
    <label>Email: <input type="email" name="email" value="<?= $docente->email ?? '' ?>" required></label><br>
    <label>Especialidad: <input type="text" name="especialidad" value="<?= $docente->especialidad ?? '' ?>" required></label><br>
    <button type="submit">Guardar</button>
    <a href="docentes.controller.php">Cancelar</a>
</form>
