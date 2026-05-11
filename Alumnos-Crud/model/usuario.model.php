<?php
class UsuarioModel
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $host = getenv('DB_HOST') ?: 'daniel-virguez.com';
            $db   = getenv('DB_NAME') ?: 'db_uptp';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: 'toor';
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function Login($correo, $password)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE correo = ? LIMIT 1");
            $stm->execute([$correo]);
            $r = $stm->fetch(PDO::FETCH_OBJ);
            if ($r && $r->password === $password) {
                $user = new Usuario();
                $user->__SET('id', $r->id);
                $user->__SET('correo', $r->correo);
                $user->__SET('password', $r->password);
                return $user;
            }
            return false;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
