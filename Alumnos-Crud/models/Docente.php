<?php
require_once 'models/model.base.php';

class DocenteEntity {
    public $id;
    public $Nombre;
    public $Apellido;
    public $Correo;
    public $Foto;
    public $Sexo;
    public $FechaNacimiento;

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        $this->$k = $v;
    }
}

class Docente extends ModelBase
{
    public function Listar()
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT id, nombre AS Nombre, apellido AS Apellido, correo AS Correo, foto AS Foto, sexo AS Sexo, fecha_nacimiento AS FechaNacimiento FROM docentes");
            $stm->execute();

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                $doc = new DocenteEntity();
                $doc->__SET('id', $r->id);
                $doc->__SET('Nombre', $r->Nombre);
                $doc->__SET('Apellido', $r->Apellido);
                $doc->__SET('Correo', $r->Correo);
                $doc->__SET('Foto', $r->Foto);
                $doc->__SET('Sexo', $r->Sexo);
                $doc->__SET('FechaNacimiento', $r->FechaNacimiento);
                $result[] = $doc;
            }
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT id, nombre AS Nombre, apellido AS Apellido, correo AS Correo, foto AS Foto, sexo AS Sexo, fecha_nacimiento AS FechaNacimiento FROM docentes WHERE id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            if (!$r) {
                return new DocenteEntity();
            }

            $doc = new DocenteEntity();
            $doc->__SET('id', $r->id);
            $doc->__SET('Nombre', $r->Nombre);
            $doc->__SET('Apellido', $r->Apellido);
            $doc->__SET('Correo', $r->Correo);
            $doc->__SET('Foto', $r->Foto);
            $doc->__SET('Sexo', $r->Sexo);
            $doc->__SET('FechaNacimiento', $r->FechaNacimiento);
            return $doc;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM docentes WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar(DocenteEntity $data)
    {
        try {
            $sql = "UPDATE docentes SET 
                        nombre = ?, 
                        apellido = ?,
                        sexo = ?, 
                        fecha_nacimiento = ?,
                        correo = ?,
                        foto = ?
                    WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $data->__GET('Nombre'),
                    $data->__GET('Apellido'),
                    $data->__GET('Sexo'),
                    $data->__GET('FechaNacimiento'),
                    $data->__GET('Correo'),
                    $data->__GET('Foto'),
                    $data->__GET('id')
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(DocenteEntity $data)
    {
        try {
            $sql = "INSERT INTO docentes (nombre, apellido, sexo, fecha_nacimiento, correo, foto) VALUES (?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)->execute(
                array(
                    $data->__GET('Nombre'),
                    $data->__GET('Apellido'),
                    $data->__GET('Sexo'),
                    $data->__GET('FechaNacimiento'),
                    $data->__GET('Correo'),
                    $data->__GET('Foto')
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
