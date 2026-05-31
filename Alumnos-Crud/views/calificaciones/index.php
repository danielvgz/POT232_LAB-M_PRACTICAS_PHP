<?php
$promedio = static function ($r) {
    $notas = [];
    foreach (['evaluacion1', 'evaluacion2', 'evaluacion3', 'evaluacion4'] as $campo) {
        if ($r->$campo !== null && $r->$campo !== '') {
            $notas[] = (float)$r->$campo;
        }
    }
    if (count($notas) === 0) {
        return '—';
    }
    return number_format(array_sum($notas) / count($notas), 2);
};
?>

<h1 class="page-header">Calificaciones</h1>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'guardado'): ?>
    <div class="alert alert-success">Calificaciones guardadas correctamente.</div>
<?php elseif (!empty($_GET['msg']) && $_GET['msg'] === 'error_validacion'): ?>
    <div class="alert alert-danger">No se pudo guardar: revise que las notas estén entre 0 y 10.</div>
<?php endif; ?>

<?php if ($mensaje !== ''): ?>
    <div class="alert alert-warning"><?php echo htmlspecialchars($mensaje); ?></div>
<?php endif; ?>

<?php if ($vista === 'docente'): ?>
    <p class="text-muted">Asigne las 4 evaluaciones a las matrículas de sus asignaciones.</p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Asignación</th>
                <th>Fecha inscripción</th>
                <th style="width: 320px;">Evaluaciones (0-10)</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($registros)): ?>
            <tr><td colspan="5">No hay matrículas para este docente.</td></tr>
        <?php else: ?>
            <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r->apellido_alumno . ', ' . $r->nombre_alumno); ?></td>
                    <td><?php echo htmlspecialchars($r->nombre_asignacion); ?></td>
                    <td><?php echo htmlspecialchars((string)$r->fecha_inscripcion); ?></td>
                    <td>
                        <form method="post" action="index.php?c=Calificacion&a=Guardar" class="form-inline">
                            <input type="hidden" name="id_inscripcion" value="<?php echo (int)$r->id; ?>">
                            <?php for ($i = 1; $i <= 4; $i++): $campo = 'evaluacion' . $i; ?>
                                <input type="number"
                                       name="<?php echo $campo; ?>"
                                       min="0"
                                       max="10"
                                       step="0.01"
                                       class="form-control input-sm"
                                       style="width: 72px; margin-right: 4px;"
                                       value="<?php echo $r->$campo === null ? '' : htmlspecialchars((string)$r->$campo); ?>"
                                       placeholder="E<?php echo $i; ?>">
                            <?php endfor; ?>
                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </form>
                    </td>
                    <td><?php echo $promedio($r); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
<?php elseif ($vista === 'alumno'): ?>
    <p class="text-muted">Estas son las calificaciones de sus asignaciones inscritas.</p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Asignación</th>
                <th>Docente</th>
                <th>E1</th>
                <th>E2</th>
                <th>E3</th>
                <th>E4</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($registros)): ?>
            <tr><td colspan="7">No tiene asignaciones inscritas.</td></tr>
        <?php else: ?>
            <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r->nombre_asignacion); ?></td>
                    <td><?php echo htmlspecialchars($r->nombre_docente . ' ' . $r->apellido_docente); ?></td>
                    <td><?php echo $r->evaluacion1 === null ? '—' : htmlspecialchars((string)$r->evaluacion1); ?></td>
                    <td><?php echo $r->evaluacion2 === null ? '—' : htmlspecialchars((string)$r->evaluacion2); ?></td>
                    <td><?php echo $r->evaluacion3 === null ? '—' : htmlspecialchars((string)$r->evaluacion3); ?></td>
                    <td><?php echo $r->evaluacion4 === null ? '—' : htmlspecialchars((string)$r->evaluacion4); ?></td>
                    <td><?php echo $promedio($r); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">Este menú está disponible para alumnos y docentes.</div>
<?php endif; ?>
