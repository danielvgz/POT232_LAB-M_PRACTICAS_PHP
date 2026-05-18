<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Iniciar sesión</strong></div>
            <div class="panel-body">
                <form method="post" action="<?= BASE_URL ?>/index.php?c=Auth&a=login">
                    <div class="form-group">
                        <label>Usuario o correo</label>
                        <input type="text" class="form-control" name="identifier" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
                </form>
                <hr>
                <p><strong>Usuarios de prueba:</strong><br>admin/admin123 · jperez/docente123 · eduardo/contraseñaSegura123</p>
            </div>
        </div>
    </div>
</div>
