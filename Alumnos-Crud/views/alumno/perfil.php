<h1 class="page-header">Mi perfil</h1>

<?php if ($mensaje !== ''): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
<?php endif; ?>

<form method="post" action="index.php?c=Alumno&a=GuardarPerfil">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($perfil->username ?? ''); ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($perfil->correo ?? ''); ?>" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Nueva contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="Dejar vacío para conservarla">
    </div>

    <?php if (($perfil->rol ?? '') === 'alumno'): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($perfil->alumno_nombre ?? ''); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($perfil->alumno_apellido ?? ''); ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="1" <?php echo (int)($perfil->alumno_sexo ?? 0) === 1 ? 'selected' : ''; ?>>Masculino</option>
                        <option value="2" <?php echo (int)($perfil->alumno_sexo ?? 0) === 2 ? 'selected' : ''; ?>>Femenino</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars((string)($perfil->alumno_fecha_nacimiento ?? '')); ?>">
                </div>
            </div>
        </div>
    <?php elseif (in_array(($perfil->rol ?? ''), ['profesor', 'docente'], true)): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($perfil->docente_nombre ?? ''); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($perfil->docente_apellido ?? ''); ?>" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="<?php echo htmlspecialchars($perfil->docente_especialidad ?? ''); ?>">
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>
