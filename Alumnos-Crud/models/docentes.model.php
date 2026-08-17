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

    public function Contar()
    {
        $stm = $this->pdo->prepare("SELECT COUNT(*) AS total FROM docentes");
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarPaginado($limite, $offset)
    {
        $stm = $this->pdo->prepare("SELECT * FROM docentes ORDER BY apellido, nombre LIMIT ? OFFSET ?");
        $stm->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stm->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stm->execute();

        $result = [];
        foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
            $result[] = new Docente(
                $r->id,
                $r->nombre,
                $r->apellido,
                $r->email,
                $r->especialidad
            );
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
