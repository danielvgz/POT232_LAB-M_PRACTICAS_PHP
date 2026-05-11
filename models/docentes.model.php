<?php
require_once 'conexion.php';
require_once 'docentes.entidad.php';

class DocenteModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::Conectar();
    }

    public function Listar()
    {
        $result = [];
        $stm = $this->pdo->prepare("SELECT * FROM docentes");
        $stm->execute();
        foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
            $docente = new Docente(
                $r->id,
                $r->nombre,
                $r->apellido,
                $r->email,
                $r->especialidad
            );
            $result[] = $docente;
        }
        return $result;
    }

    public function Obtener($id)
    {
        $stm = $this->pdo->prepare("SELECT * FROM docentes WHERE id = ?");
        $stm->execute([$id]);
        $r = $stm->fetch(PDO::FETCH_OBJ);
        if ($r) {
            return new Docente($r->id, $r->nombre, $r->apellido, $r->email, $r->especialidad);
        }
        return null;
    }

    public function Eliminar($id)
    {
        $stm = $this->pdo->prepare("DELETE FROM docentes WHERE id = ?");
        $stm->execute([$id]);
    }

    public function Actualizar(Docente $data)
    {
        $sql = "UPDATE docentes SET 
                    nombre = ?, 
                    apellido = ?, 
                    email = ?, 
                    especialidad = ?
                WHERE id = ?";
        $this->pdo->prepare($sql)
            ->execute([
                $data->nombre,
                $data->apellido,
                $data->email,
                $data->especialidad,
                $data->id
            ]);
    }

    public function Registrar(Docente $data)
    {
        $sql = "INSERT INTO docentes (nombre, apellido, email, especialidad) VALUES (?, ?, ?, ?)";
        $this->pdo->prepare($sql)
            ->execute([
                $data->nombre,
                $data->apellido,
                $data->email,
                $data->especialidad
            ]);
    }
}
