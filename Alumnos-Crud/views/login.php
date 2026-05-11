<?php include 'header.php'; ?>
<div class="container" style="max-width:400px; margin-top:70px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Iniciar sesión</h3>
        </div>
        <div class="panel-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
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
</div></div></body></html>
