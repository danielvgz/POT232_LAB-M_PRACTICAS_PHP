<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
        <div class="col-md-4 col-md-offset-4 ">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Iniciar sesión</h3>
                </div>
                <div class="panel-body">
                    <?php if ($mensaje): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
