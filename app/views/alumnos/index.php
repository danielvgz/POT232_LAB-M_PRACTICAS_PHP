<div class="clearfix">
    <h3 class="pull-left">Alumnos</h3>
    <a class="btn btn-primary pull-right" href="<?= BASE_URL ?>/index.php?c=Alumnos&a=create">Nuevo</a>
</div><hr>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Foto</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars((string)$r['nombre'] . ' ' . $r['apellido']) ?></td>
            <td><?= htmlspecialchars((string)$r['correo']) ?></td>
            <td><?php if (!empty($r['foto'])): ?><img src="<?= BASE_URL ?>/public/uploads/alumnos/<?= rawurlencode((string)$r['foto']) ?>" style="max-width:50px;max-height:50px"><?php endif; ?></td>
            <td>
                <a class="btn btn-xs btn-info" href="<?= BASE_URL ?>/index.php?c=Alumnos&a=edit&id=<?= (int)$r['id'] ?>">Editar</a>
                <a class="btn btn-xs btn-danger" href="<?= BASE_URL ?>/index.php?c=Alumnos&a=delete&id=<?= (int)$r['id'] ?>" onclick="return confirm('¿Eliminar?');">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="5">Sin registros.</td></tr><?php endif; ?>
    </tbody>
</table>
