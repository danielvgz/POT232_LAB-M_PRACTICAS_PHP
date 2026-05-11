<?php
session_start();

// Parámetros de conexión
$host = 'localhost';
$db = 'test';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

$mensaje = '';

try {
    // Conexión con PDO
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesa el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // No es necesario escapar, usamos parámetros

    // Consulta segura con parámetros
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Validar contraseña (MD5 para el ejemplo, usa password_hash en proyectos nuevos)
        if ($usuario['password_hash'] === md5($password)) {
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['usuario_id'] = $usuario['id'];
            header("Location: dashboard.php"); // Cambia a la página destino protegida
            exit;
        } else {
            $mensaje = 'Contraseña incorrecta.';
        }
    } else {
        $mensaje = 'Usuario no encontrado.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row" style="margin-top:100px;">
        <div class="col-md-4 col-md-offset-4">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>