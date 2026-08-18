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
            <label>Docente</label>
            <select class="form-control" name="docente_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($docentes as $d): ?>
                    <option value="<?php echo (int) $d['id']; ?>" <?php echo ((string) $row['docente_id'] === (string) $d['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($d['nombre'] . ' ' . $d['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=matriculas&action=index">Cancelar</a>
</form>
