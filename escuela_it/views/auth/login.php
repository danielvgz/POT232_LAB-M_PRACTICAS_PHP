<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Escuela IT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.17/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="max-width: 420px; margin-top: 80px;">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Iniciar sesión</strong></div>
        <div class="panel-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="alert alert-info">
                Usuario alumno: <strong>hitogoroshi@outlook.com</strong><br>
                Usuario maestro: <strong>juan.perez@escuela.it</strong><br>
                Clave por defecto: <strong>password</strong>
            </div>
            <form method="post" action="index.php?controller=auth&action=login">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Entrar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
