<h2>Lista de Docentes</h2>
<a href="docente.controller.php?action=Crud">Agregar Docente</a>
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
                <a href="docente.controller.php?action=Crud&id=<?= $d->id ?>">Editar</a>
                <a href="docente.controller.php?action=Eliminar&id=<?= $d->id ?>" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
