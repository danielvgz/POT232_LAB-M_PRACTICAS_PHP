<?php
require_once __DIR__ . '/../config/database.php';
class UsuarioModel
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::connect();
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
