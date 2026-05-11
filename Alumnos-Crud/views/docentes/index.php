<?php include '../includes/navbar.php'; ?>
<h2>Lista de Docentes</h2>
<a href="docentes.controller.php?action=nuevo">Agregar Docente</a>
<table border="1">
    <thead>
        <tr>
            <th>#</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Especialidad</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($docentes as $d): ?>
        <tr>
            <td><?= $d->id ?></td>
            <td><?= $d->nombre ?></td>
            <td><?= $d->apellido ?></td>
            <td><?= $d->email ?></td>
            <td><?= $d->especialidad ?></td>
            <td>
                <a href="docentes.controller.php?action=editar&id=<?= $d->id ?>">Editar</a>
                <a href="docentes.controller.php?action=eliminar&id=<?= $d->id ?>" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
