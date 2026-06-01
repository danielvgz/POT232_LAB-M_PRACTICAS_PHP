<div class="page-header"><h3><?php echo isset($title) ? htmlspecialchars($title) : 'Matriculas'; ?></h3></div>
<?php if (!empty($_GET['error']) && $_GET['error'] === 'creditos'): ?>
    <div class="alert alert-warning">No puedes inscribirte porque superas el máximo de créditos.</div>
<?php elseif (!empty($_GET['error']) && $_GET['error'] === 'inscripcion'): ?>
    <div class="alert alert-warning">No se pudo completar la inscripción.</div>
<?php endif; ?>

<?php if (($role === 'maestro' || $role === 'profesor' || $role === 'admin') && !empty($canManage)): ?>
    <form class="form-inline" method="get" action="index.php">
        <input type="hidden" name="controller" value="matriculas">
        <input type="hidden" name="action" value="index">
        <?php if (!empty($materias)): ?>
            <div class="form-group">
                <label>Materia</label>
                <select class="form-control" name="materia_id">
                    <option value="">Todas</option>
                    <?php foreach ($materias as $m): ?>
                        <option value="<?php echo (int) $m['id']; ?>" <?php echo ((string) $materiaId === (string) $m['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($m['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <button class="btn btn-default" type="submit">Filtrar</button>
        <a class="btn btn-success" href="index.php?controller=matriculas&action=form">Nueva asignacion</a>
        <a class="btn btn-info" href="index.php?controller=matriculas&action=exportar<?php echo !empty($materiaId) ? '&materia_id=' . (int) $materiaId : ''; ?>">Exportar lista</a>
    </form>
    <br>
<?php endif; ?>

<?php if (!empty($canEnroll)): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Inscripción</strong></div>
        <div class="panel-body">
            <form method="post" action="index.php?controller=matriculas&action=inscribir">
                <div class="row">
                    <div class="col-sm-8 form-group">
                        <label>Materia disponible</label>
                        <select class="form-control" name="materia_id" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($materias as $m): ?>
                                <option value="<?php echo (int) $m['id']; ?>">
                                    <?php echo htmlspecialchars($m['nombre'] . ' (' . $m['creditos'] . ' UC)'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <label>Créditos máximos</label>
                        <input class="form-control" type="text" value="<?php echo (int) $maxCreditos; ?>" disabled>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Inscribirme</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Alumno</th>
        <th>Materia</th>
        <th>Docente</th>
        <th>Fecha</th>
        <th>Obj.1</th>
        <th>Obj.2</th>
        <th>Obj.3</th>
        <th>Obj.4</th>
        <?php if (!empty($canManage)): ?><th>Acciones</th><?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
        <tr><td colspan="<?php echo !empty($canManage) ? 10 : 9; ?>">No hay registros disponibles.</td></tr>
    <?php endif; ?>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo (int) $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['alumno_nombre'] . ' ' . $r['alumno_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['materia_nombre']); ?></td>
            <td><?php echo htmlspecialchars($r['docente_nombre'] . ' ' . $r['docente_apellido']); ?></td>
            <td><?php echo htmlspecialchars($r['fecha_matricula']); ?></td>
            <td><?php echo htmlspecialchars($r['obj1']); ?></td>
            <td><?php echo htmlspecialchars($r['obj2']); ?></td>
            <td><?php echo htmlspecialchars($r['obj3']); ?></td>
            <td><?php echo htmlspecialchars($r['obj4']); ?></td>
            <?php if (!empty($canManage)): ?>
                <td>
                    <a class="btn btn-primary btn-xs" href="index.php?controller=matriculas&action=form&id=<?php echo (int) $r['id']; ?>">Editar</a>
                    <a class="btn btn-danger btn-xs" href="index.php?controller=matriculas&action=delete&id=<?php echo (int) $r['id']; ?>" onclick="return confirm('¿Eliminar registro?');">Eliminar</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (!empty($pages) && $pages > 1): ?>
    <nav>
        <ul class="pagination">
            <li class="<?php echo $page <= 1 ? 'disabled' : ''; ?>"><a href="index.php?controller=matriculas&action=index&page=<?php echo max(1, $page - 1); ?>&materia_id=<?php echo (int) $materiaId; ?>">«</a></li>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="<?php echo $i === (int) $page ? 'active' : ''; ?>"><a href="index.php?controller=matriculas&action=index&page=<?php echo $i; ?>&materia_id=<?php echo (int) $materiaId; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="<?php echo $page >= $pages ? 'disabled' : ''; ?>"><a href="index.php?controller=matriculas&action=index&page=<?php echo min($pages, $page + 1); ?>&materia_id=<?php echo (int) $materiaId; ?>">»</a></li>
        </ul>
    </nav>
<?php endif; ?>
