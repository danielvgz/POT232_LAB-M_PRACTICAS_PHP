<h1 class="page-header">Matrículas</h1>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'inscripcion_ok'): ?>
    <div class="alert alert-success">Matrícula registrada correctamente.</div>
<?php elseif (!empty($_GET['msg'])): ?>
    <div class="alert alert-warning"><?php echo htmlspecialchars(urldecode((string)$_GET['msg'])); ?></div>
<?php endif; ?>

<?php if ($mensaje !== ''): ?>
    <div class="alert alert-warning"><?php echo htmlspecialchars($mensaje); ?></div>
<?php else: ?>
    <p class="text-muted">
        Créditos inscritos: <strong><?php echo (int)$totalCreditos; ?>/30</strong>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Nueva matrícula</strong></div>
        <div class="panel-body">
            <form method="post" action="index.php?c=Inscripcion&a=Guardar" class="form-inline">
                <div class="form-group">
                    <label for="id_asignacion_docente">Asignación</label>
                    <select id="id_asignacion_docente" name="id_asignacion_docente" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($asignacionesDisponibles as $asig): ?>
                            <?php if ((int)$asig->ya_inscrita === 1) { continue; } ?>
                            <option value="<?php echo (int)$asig->id; ?>">
                                <?php
                                echo htmlspecialchars(
                                    $asig->nombre_asignacion
                                    . ' - '
                                    . $asig->nombre_docente
                                    . ' '
                                    . $asig->apellido_docente
                                    . ' ('
                                    . (int)$asig->creditos
                                    . ' créditos)'
                                );
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Inscribir</button>
            </form>
        </div>
    </div>

    <h3>Matrículas inscritas</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Asignación</th>
                <th>Docente</th>
                <th>Créditos</th>
                <th>Fecha inscripción</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($inscripciones)): ?>
            <tr><td colspan="4">No tiene matrículas inscritas.</td></tr>
        <?php else: ?>
            <?php foreach ($inscripciones as $ins): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ins->nombre_asignacion); ?></td>
                    <td><?php echo htmlspecialchars($ins->nombre_docente . ' ' . $ins->apellido_docente); ?></td>
                    <td><?php echo (int)$ins->creditos; ?></td>
                    <td><?php echo htmlspecialchars((string)$ins->fecha_inscripcion); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
