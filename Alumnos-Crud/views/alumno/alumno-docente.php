<h1 class="page-header">Mis alumnos</h1>

<div class="well well-sm">
    <form method="get" class="form-inline">
        <input type="hidden" name="c" value="Alumno">
        <div class="form-group">
            <label for="matricula">Filtrar por matrícula</label>
            <select id="matricula" name="matricula" class="form-control">
                <option value="0">Todas</option>
                <?php foreach ($asignaciones as $asignacion): ?>
                    <option value="<?php echo (int)$asignacion->id; ?>" <?php echo (int)($asignacion->id) === (int)($_GET['matricula'] ?? 0) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($asignacion->nombre_asignacion . ' (' . (int)$asignacion->creditos . ' créditos)'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aplicar filtro</button>
        <a class="btn btn-success" href="?c=Alumno&a=Excel<?php echo !empty($_GET['matricula']) ? '&matricula=' . (int)$_GET['matricula'] : ''; ?>">Exportar</a>
    </form>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Matrícula</th>
            <th>Docente</th>
            <th>Créditos</th>
            <th>Fecha inscripción</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($alumnos)): ?>
            <tr>
                <td colspan="6">No hay alumnos para mostrar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($alumnos as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r->apellido_alumno . ', ' . $r->nombre_alumno); ?></td>
                    <td><?php echo htmlspecialchars($r->correo_alumno); ?></td>
                    <td><?php echo htmlspecialchars($r->nombre_asignacion); ?></td>
                    <td><?php echo htmlspecialchars(($r->nombre_docente ?? '') . ' ' . ($r->apellido_docente ?? '')); ?></td>
                    <td><?php echo (int)$r->creditos; ?></td>
                    <td><?php echo htmlspecialchars((string)$r->fecha_inscripcion); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($totalPaginas > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for ($pagina = 1; $pagina <= $totalPaginas; $pagina++): ?>
                <li class="<?php echo $pagina === $paginaActual ? 'active' : ''; ?>">
                    <a href="?c=Alumno&page=<?php echo $pagina; ?><?php echo !empty($_GET['matricula']) ? '&matricula=' . (int)$_GET['matricula'] : ''; ?>">
                        <?php echo $pagina; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
