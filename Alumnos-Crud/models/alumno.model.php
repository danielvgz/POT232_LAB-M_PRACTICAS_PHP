<?php
require_once 'models/model.base.php';

class AlumnoModel extends ModelBase
{
    public function Listar()
    {
        try
        {
            $result = array();
            $stm = $this->pdo->prepare("SELECT * FROM alumnos");
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $alm = new Alumno();
                $alm->__SET('id', $r->id);
                $alm->__SET('Nombre', $r->Nombre);
                $alm->__SET('Apellido', $r->Apellido);
                $alm->__SET('Correo', $r->Correo);
                $alm->__SET('Foto', $r->Foto);
                $alm->__SET('Sexo', $r->Sexo);
                $alm->__SET('FechaNacimiento', $r->FechaNacimiento);
                $result[] = $alm;
            }
            return $result;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Obtener($id)
    {
        try
        {
            $stm = $this->pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);

            $alm = new Alumno();
            $alm->__SET('id', $r->id);
            $alm->__SET('Nombre', $r->Nombre);
            $alm->__SET('Correo', $r->Correo);
            $alm->__SET('Apellido', $r->Apellido);
            $alm->__SET('Foto', $r->Foto);
            $alm->__SET('Sexo', $r->Sexo);
            $alm->__SET('FechaNacimiento', $r->FechaNacimiento);
            return $alm;
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try
        {
            $stm = $this->pdo->prepare("DELETE FROM alumnos WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Actualizar(Alumno $data)
    {
        try
        {
            $sql = "UPDATE alumnos SET 
                        Nombre          = ?, 
                        Apellido        = ?,
                        Sexo            = ?, 
                        FechaNacimiento = ?,
                        Correo          = ?,
                        Foto            = ?
                    WHERE id = ?";
            $this->pdo->prepare($sql)
                 ->execute(
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
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Registrar(Alumno $data)
    {
        try
        {
            $sql = "INSERT INTO alumnos (Nombre,Apellido,Sexo,FechaNacimiento,Correo,Foto) VALUES (?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                 ->execute(
                    array(
                        $data->__GET('Nombre'),
                        $data->__GET('Apellido'),
                        $data->__GET('Sexo'),
                        $data->__GET('FechaNacimiento'),
                        $data->__GET('Correo'),
                        $data->__GET('Foto'),
                        )
                    );
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
	
}
