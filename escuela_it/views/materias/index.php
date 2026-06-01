<div class="page-header"><h3>Materias</h3></div>
<a class="btn btn-success" href="index.php?controller=materias&action=form">Nueva materia</a>
<br><br>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Créditos</th><th>Docente</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['descripcion']); ?></td>
            <td><?php echo htmlspecialchars($r['creditos']); ?></td>
            <td><?php echo htmlspecialchars(($r['docente_nombre'] ?? '') . ' ' . ($r['docente_apellido'] ?? '')); ?></td>
            <td>
                <a class="btn btn-primary btn-xs" href="index.php?controller=materias&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                <a class="btn btn-danger btn-xs" href="index.php?controller=materias&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php if (!empty($pages) && $pages > 1): ?>
    <nav>
        <ul class="pagination">
            <li class="<?php echo $page <= 1 ? 'disabled' : ''; ?>"><a href="index.php?controller=materias&action=index&page=<?php echo max(1, $page - 1); ?>">«</a></li>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="<?php echo $i === (int) $page ? 'active' : ''; ?>"><a href="index.php?controller=materias&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="<?php echo $page >= $pages ? 'disabled' : ''; ?>"><a href="index.php?controller=materias&action=index&page=<?php echo min($pages, $page + 1); ?>">»</a></li>
        </ul>
    </nav>
<?php endif; ?>
