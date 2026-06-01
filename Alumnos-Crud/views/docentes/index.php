<h2>Lista de Docentes</h2>
<a href="index.php?c=Docente&a=Crud">Agregar Docente</a>
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
                <a href="index.php?c=Docente&a=Crud&id=<?= $d->id ?>">Editar</a>
                <a href="index.php?c=Docente&a=Eliminar&id=<?= $d->id ?>" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($totalPaginas > 1): ?>
<nav>
    <ul class="pagination">
        <?php for ($pagina = 1; $pagina <= $totalPaginas; $pagina++): ?>
            <li class="<?php echo $pagina === $paginaActual ? 'active' : ''; ?>">
                <a href="index.php?c=Docente&page=<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
