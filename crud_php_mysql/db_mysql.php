<?php
// db_mysql.php - Conexión PDO para MySQL
// Uso: require 'db_mysql.php';  (exporta $pdo)
// Lee variables de entorno si están presentes: DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET

$host = getenv('DB_HOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: 'examen';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$charset = getenv('DB_CHARSET') ?: 'utf8mb4';

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
    echo "Error de conexión MySQL: " . htmlspecialchars($e->getMessage());
    exit;
}
