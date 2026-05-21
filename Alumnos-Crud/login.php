<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['auth_user'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario === 'admin' && $password === 'password123') {
        $_SESSION['auth_user'] = $usuario;
        header('Location: index.php');
        exit;
    }

    $error = 'Usuario o contraseña inválidos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
</head>
<body>
    <div class="container" style="max-width: 420px; margin-top: 80px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Iniciar sesión</h3>
            </div>
            <div class="panel-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
