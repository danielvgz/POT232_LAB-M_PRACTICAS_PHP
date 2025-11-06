<?php
session_start();

// Comprueba si hay usuario en sesión. Ajusta la clave si tu login usa otra.
if (!isset($_SESSION['user'])) {
    // Ajusta la ruta de redirección según tu estructura (actualmente va a la raíz)
    header('Location: ../../index.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard — MiApp</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
  <header class="bg-gradient-to-r from-sky-600 to-blue-500 text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="font-semibold">MiApp</div>
        <div class="text-sm opacity-90">Panel de control</div>
      </div>

      <div class="flex items-center gap-4">
        <div class="text-sm">Hola, <strong><?php echo htmlspecialchars($user['name'] ?? $user['email'] ?? 'Usuario'); ?></strong></div>
        <a href="../../profile.php" class="text-sm hover:underline">Perfil</a>
        <a href="logout.php" class="bg-white text-blue-600 px-3 py-1 rounded shadow">Cerrar sesión</a>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 py-8">
    <section class="bg-white rounded-lg shadow p-6">
      <h1 class="text-2xl font-bold">Bienvenido, <?php echo htmlspecialchars($user['name'] ?? $user['email'] ?? ''); ?></h1>
      <p class="text-gray-600 mt-2">Este panel está protegido por sesión PHP.</p>
    </section>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
      <article class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold">Estadísticas</h2>
        <div class="mt-3 text-3xl font-bold">124</div>
        <div class="text-sm text-gray-500">Usuarios</div>
      </article>

      <article class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold">Notificaciones</h2>
        <div class="mt-3 text-3xl font-bold">5</div>
        <div class="text-sm text-gray-500">Nuevas</div>
      </article>

      <article class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold">Soporte</h2>
        <p class="text-gray-600 mt-2">Enlaces y documentación rápida.</p>
      </article>
    </section>

    <section class="bg-white rounded-lg shadow p-6 mt-6">
      <h3 class="text-lg font-semibold">Acciones recientes</h3>
      <ul class="list-disc pl-5 mt-3 text-gray-700">
        <li>Inicio de sesión reciente</li>
        <li>Actualización de perfil</li>
      </ul>
    </section>

    <footer class="mt-8 text-center text-sm text-gray-500">&copy; <?php echo date('Y'); ?> MiApp</footer>
  </main>
</body>
</html>
