<div class="page-header"><h3><?php echo $row['id'] ? 'Editar' : 'Nueva'; ?> matricula</h3></div>
<form method="post" action="index.php?controller=matriculas&action=save">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <div class="row">
        <div class="col-sm-4 form-group">
            <label>Alumno</label>
            <select class="form-control" name="alumno_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($alumnos as $a): ?>
                    <option value="<?php echo (int) $a['id']; ?>" <?php echo ((string) $row['alumno_id'] === (string) $a['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($a['nombre'] . ' ' . $a['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-4 form-group">
            <label>Docente asignado</label>
            <?php if (!empty($canEditDocente) && !empty($docentes)): ?>
                <select class="form-control" name="docente_id" required>
                    <?php foreach ($docentes as $d): ?>
                        <option value="<?php echo (int) $d['id']; ?>" <?php echo ((string) $row['docente_id'] === (string) $d['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($d['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <?php
                    $docenteNombre = '';
                    foreach ($docentes as $d) {
                        if ((string) $row['docente_id'] === (string) $d['id']) {
                            $docenteNombre = $d['nombre'];
                            break;
                        }
                    }
                ?>
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($docenteNombre ?: $row['docente_id']); ?>" disabled>
            <?php endif; ?>
        </div>
        <div class="col-sm-4 form-group">
            <label>Materia</label>
            <select class="form-control" name="materia_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($materias as $m): ?>
                    <option value="<?php echo (int) $m['id']; ?>" <?php echo ((string) $row['materia_id'] === (string) $m['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($m['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label>Fecha matricula</label>
        <input class="form-control" type="date" name="fecha_matricula" value="<?php echo htmlspecialchars($row['fecha_matricula']); ?>">
    </div>
    <div class="row">
        <div class="col-sm-3 form-group"><label>Obj.1</label><input class="form-control" name="obj1" value="<?php echo htmlspecialchars($row['obj1']); ?>"></div>
        <div class="col-sm-3 form-group"><label>Obj.2</label><input class="form-control" name="obj2" value="<?php echo htmlspecialchars($row['obj2']); ?>"></div>
        <div class="col-sm-3 form-group"><label>Obj.3</label><input class="form-control" name="obj3" value="<?php echo htmlspecialchars($row['obj3']); ?>"></div>
        <div class="col-sm-3 form-group"><label>Obj.4</label><input class="form-control" name="obj4" value="<?php echo htmlspecialchars($row['obj4']); ?>"></div>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=matriculas&action=index">Cancelar</a>
</form>
