<?php
session_start();

// Ruta donde se guardarán los usuarios (JSON simple para demo)
$dataDir = __DIR__ . '/../data';
$usersFile = $dataDir . '/users.json';

$errors = [];
$old = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $old['name'] = $name;
    $old['email'] = $email;

    if ($name === '') $errors[] = 'El nombre es obligatorio.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email no válido.';
    if (strlen($password) < 6) $errors[] = 'La contraseña debe tener al menos 6 caracteres.';

    if (empty($errors)) {
        // Asegura que exista el directorio
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }

        $users = [];
        if (file_exists($usersFile)) {
            $content = file_get_contents($usersFile);
            $users = json_decode($content, true) ?: [];
        }

        // Comprueba si el email ya está registrado
        foreach ($users as $u) {
            if (isset($u['email']) && strtolower($u['email']) === strtolower($email)) {
                $errors[] = 'Ya existe un usuario con ese correo.';
                break;
            }
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user = ['name' => $name, 'email' => $email, 'password' => $hash, 'created_at' => date('c')];
        $users[] = $user;
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Inicia sesión y redirige al dashboard
        $_SESSION['user'] = ['name' => $name, 'email' => $email];
        header('Location: dashboard.php');
        exit;
    }
}

// Si GET o hay errores, muestra el formulario
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Registro — MiApp</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
  <main class="w-full max-w-md p-6">
    <section class="bg-white shadow rounded-lg p-6">
      <h1 class="text-2xl font-bold text-center">Crear cuenta</h1>
      <p class="text-center text-sm text-gray-500 mt-1">Regístrate para acceder al panel</p>

      <?php if (!empty($errors)): ?>
        <div class="mt-4 p-3 bg-red-50 text-red-700 rounded">
          <ul class="list-disc pl-5">
            <?php foreach ($errors as $err): ?>
              <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="registro.php" method="post" id="registerForm" class="mt-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
          <input name="name" type="text" required value="<?php echo htmlspecialchars($old['name']); ?>" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
          <input name="email" type="email" required value="<?php echo htmlspecialchars($old['email']); ?>" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input id="password" name="password" type="password" required minlength="6" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500" />
        </div>

        <div>
          <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded-md">Crear cuenta</button>
        </div>
      </form>

      <div class="mt-4 text-center text-sm text-gray-600">
        ¿Ya tienes cuenta? <a href="login.html" class="text-sky-600 hover:underline">Inicia sesión</a>
      </div>
    </section>

    <p class="mt-4 text-center text-xs text-gray-400">Registro sencillo de ejemplo — valida y sanitiza en servidor para producción.</p>
  </main>

  <script>
    // Validación simple: comprobar que la contraseña tiene longitud mínima
    document.getElementById('registerForm').addEventListener('submit', function(e){
      var p = document.getElementById('password').value;
      if (p.length < 6) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 6 caracteres');
      }
    });
  </script>
</body>
</html>
