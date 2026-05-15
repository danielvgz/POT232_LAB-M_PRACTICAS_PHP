<div style="max-width:400px; margin-top:70px; margin:0 auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Iniciar sesión</h3>
        </div>
        <div class="panel-body">
            <?php if (!empty(
$error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars(
$error) ?></div>
            <?php endif; ?>
            <!-- Bloque de accesos de prueba actualizado -->
            <div class="alert alert-info" style="margin-bottom:18px;">
              <strong>Prueba con estos accesos (recuerda: debes iniciar sesión usando el correo):</strong>
              <ul style="margin-bottom: 0;">
                <li>
                  <b>Docente:</b><br>
                  Usuario: <code>jperez</code><br>
                  Correo: <code>jperez@ejemplo.com</code><br>
                  Contraseña: <code>docente123</code>
                </li>
                <li>
                  <b>Administrador:</b><br>
                  Usuario: <code>admin</code><br>
                  Correo: <code>admin@ejemplo.com</code><br>
                  Contraseña: <code>admin123</code>
                </li>
                <li>
                  <b>Alumno:</b><br>
                  Usuario: <code>eduardo</code><br>
                  Correo: <code>eduardo@ejemplo.com</code><br>
                  Contraseña: <code>contraseñaSegura123</code>
                </li>
              </ul>
              <span style="font-size:0.9em; color:#555;">El acceso se realiza con el correo y contraseña.</span>
            </div>

            <form method="POST">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" class="form-control" required autofocus
                        placeholder="ejemplo@correo.com"
                        oninvalid="this.setCustomValidity('Por favor ingrese un correo válido')"
                        oninput="setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" class="form-control" required
                        oninvalid="this.setCustomValidity('Por favor ingrese la contraseña')"
                        oninput="setCustomValidity('')">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>
        </div>
    </div>
</div>
