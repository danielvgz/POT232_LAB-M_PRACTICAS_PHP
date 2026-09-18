<?php
class Database
{
    public static function connect()
    {
        $host = getenv('DB_HOST') ? getenv('DB_HOST') : '127.0.0.1';
        $dbname = getenv('DB_NAME') ? getenv('DB_NAME') : 'escuela_it';
        $user = getenv('DB_USER') ? getenv('DB_USER') : 'root';
        $pass = getenv('DB_PASS') ? getenv('DB_PASS') : '';
        $charset = getenv('DB_CHARSET') ? getenv('DB_CHARSET') : 'utf8';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset;

        return new PDO($dsn, $user, $pass, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ));
    }
}
