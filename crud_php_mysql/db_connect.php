<?php
// db_connect.php - Selecciona driver por variable de entorno DB_DRIVER
// Valores: 'sqlite' (por defecto) o 'mysql'

$driver = getenv('DB_DRIVER') ?: 'sqlite';

if (strtolower($driver) === 'mysql') {
    require_once __DIR__ . '/db_mysql.php';
} else {
    require_once __DIR__ . '/db.php';
}

// Al incluir uno de los archivos anteriores, queda disponible la variable $pdo
