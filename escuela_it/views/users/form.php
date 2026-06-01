<div class="page-header"><h3><?php echo $row['id'] ? 'Editar' : 'Nuevo'; ?> usuario</h3></div>
<form method="post" action="index.php?controller=users&action=save">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <div class="row">
        <div class="col-sm-6 form-group"><label>Correo</label><input type="email" class="form-control" name="correo" required value="<?php echo htmlspecialchars($row['correo']); ?>"></div>
        <div class="col-sm-6 form-group"><label>Clave</label><input type="password" class="form-control" name="password" value=""></div>
        <div class="col-sm-4 form-group">
            <label>Rol</label>
            <select class="form-control" name="rol">
                <option value="alumno" <?php echo (($row['rol'] ?? '') === 'alumno') ? 'selected' : ''; ?>>Alumno</option>
                <option value="maestro" <?php echo (($row['rol'] ?? '') === 'maestro') ? 'selected' : ''; ?>>Maestro</option>
                <option value="profesor" <?php echo (($row['rol'] ?? '') === 'profesor') ? 'selected' : ''; ?>>Profesor</option>
                <option value="admin" <?php echo (($row['rol'] ?? '') === 'admin') ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </div>
        <div class="col-sm-4 form-group">
            <label>Alumno vinculado</label>
            <select class="form-control" name="alumno_id">
                <option value="">Ninguno</option>
                <?php foreach ($profiles['alumnos'] as $a): ?>
                    <option value="<?php echo (int) $a['id']; ?>" <?php echo ((string)($row['alumno_id'] ?? '') === (string) $a['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($a['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-4 form-group">
            <label>Docente vinculado</label>
            <select class="form-control" name="docente_id">
                <option value="">Ninguno</option>
                <?php foreach ($profiles['docentes'] as $d): ?>
                    <option value="<?php echo (int) $d['id']; ?>" <?php echo ((string)($row['docente_id'] ?? '') === (string) $d['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($d['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="btn btn-primary">Guardar</button>
    <a class="btn btn-default" href="index.php?controller=users&action=index">Cancelar</a>
</form>
