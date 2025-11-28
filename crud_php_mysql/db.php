<?php
// db.php - Conexión PDO con soporte para SQLite (por defecto)

// Cambia a false si prefieres usar MySQL al incluir este archivo directamente
$USE_SQLITE = true;

if ($USE_SQLITE) {
    $sqlite_file = __DIR__ . '/database.sqlite';
    try {
        $pdo = new PDO('sqlite:' . $sqlite_file);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Habilitar claves foráneas en SQLite
        $pdo->exec('PRAGMA foreign_keys = ON');

        // Crear la tabla si no existe (estructura base)
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            email TEXT NOT NULL,
            telefono TEXT
        );");

        // Asegurar que las columnas nuevas existen (ALTER TABLE ADD COLUMN en SQLite)
        $cols = $pdo->query("PRAGMA table_info(users)")->fetchAll(PDO::FETCH_ASSOC);
        $colNames = array_column($cols, 'name');
        if (!in_array('cedula', $colNames)) {
            $pdo->exec("ALTER TABLE users ADD COLUMN cedula TEXT;");
        }
        if (!in_array('fecha_nacimiento', $colNames)) {
            $pdo->exec("ALTER TABLE users ADD COLUMN fecha_nacimiento TEXT;");
        }

        // Insertar datos de ejemplo si está vacía
        $row = $pdo->query('SELECT COUNT(*) as c FROM users')->fetch();
        if (!$row || $row['c'] == 0) {
            $st = $pdo->prepare('INSERT INTO users (nombre, email, telefono, cedula, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)');
            $st->execute(['Juan Pérez', 'juan@example.com', '555-1234', 'A1234567', '1985-04-12']);
            $st->execute(['María López', 'maria@example.com', '555-5678', 'B9876543', '1990-09-30']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Error SQLite: " . htmlspecialchars($e->getMessage());
        exit;
    }
    return;
}

// --- Fallback MySQL (si $USE_SQLITE = false) ---
$host = '127.0.0.1';
$db   = 'crud_php';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error de conexión a la base de datos: " . htmlspecialchars($e->getMessage());
    exit;
}
