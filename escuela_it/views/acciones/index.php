<div class="page-header"><h3>Acciones registradas</h3></div>
<table class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Acción</th><th>Entidad</th><th>Detalle</th><th>Fecha</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['user_correo'] ?? '-'); ?></td>
            <td><?php echo htmlspecialchars($r['rol']); ?></td>
            <td><?php echo htmlspecialchars($r['accion']); ?></td>
            <td><?php echo htmlspecialchars($r['entidad']); ?></td>
            <td><?php echo htmlspecialchars($r['detalle']); ?></td>
            <td><?php echo htmlspecialchars($r['created_at']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (!empty($pages) && $pages > 1): ?>
    <nav>
        <ul class="pagination">
            <li class="<?php echo $page <= 1 ? 'disabled' : ''; ?>"><a href="index.php?controller=acciones&action=index&page=<?php echo max(1, $page - 1); ?>">«</a></li>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="<?php echo $i === (int) $page ? 'active' : ''; ?>"><a href="index.php?controller=acciones&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="<?php echo $page >= $pages ? 'disabled' : ''; ?>"><a href="index.php?controller=acciones&action=index&page=<?php echo min($pages, $page + 1); ?>">»</a></li>
        </ul>
    </nav>
<?php endif; ?>
