<?php
// db_connect.php - Forzar uso de MySQL como único driver.
// Lee variables de entorno para conexión en `db_mysql.php`.

require_once __DIR__ . '/db_mysql.php';

// Al incluir `db_mysql.php` queda disponible la variable $pdo
