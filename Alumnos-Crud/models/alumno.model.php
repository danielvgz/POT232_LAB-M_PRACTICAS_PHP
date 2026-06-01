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

    public function Contar()
    {
        $stm = $this->pdo->prepare("SELECT COUNT(*) AS total FROM alumnos");
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarPaginado($limite, $offset)
    {
        $stm = $this->pdo->prepare("SELECT * FROM alumnos ORDER BY Apellido, Nombre LIMIT ? OFFSET ?");
        $stm->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stm->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stm->execute();

        $result = [];
        foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
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

    public function ListarPorDocente($idDocente, $idAsignacionDocente = null, $limite = null, $offset = null)
    {
        $sql = "SELECT i.id AS id_inscripcion,
                       i.fecha_inscripcion,
                       ad.id AS id_asignacion_docente,
                       asig.nombre AS nombre_asignacion,
                       asig.creditos,
                       a.id AS id_alumno,
                       a.Nombre AS nombre_alumno,
                       a.Apellido AS apellido_alumno,
                       a.Correo AS correo_alumno,
                       d.nombre AS nombre_docente,
                       d.apellido AS apellido_docente
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                INNER JOIN alumnos a ON a.id = i.id_alumno
                INNER JOIN docentes d ON d.id = ad.id_docente
                WHERE ad.id_docente = ?";
        $params = [(int)$idDocente];

        if ($idAsignacionDocente !== null) {
            $sql .= " AND ad.id = ?";
            $params[] = (int)$idAsignacionDocente;
        }

        $sql .= " ORDER BY asig.nombre, a.Apellido, a.Nombre";

        if ($limite !== null && $offset !== null) {
            $sql .= " LIMIT ? OFFSET ?";
        }

        $stm = $this->pdo->prepare($sql);
        foreach ($params as $index => $param) {
            $stm->bindValue($index + 1, $param, PDO::PARAM_INT);
        }

        if ($limite !== null && $offset !== null) {
            $stm->bindValue(count($params) + 1, (int)$limite, PDO::PARAM_INT);
            $stm->bindValue(count($params) + 2, (int)$offset, PDO::PARAM_INT);
        }

        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ContarPorDocente($idDocente, $idAsignacionDocente = null)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                WHERE ad.id_docente = ?";
        $params = [(int)$idDocente];

        if ($idAsignacionDocente !== null) {
            $sql .= " AND ad.id = ?";
            $params[] = (int)$idAsignacionDocente;
        }

        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarAsignacionesDeDocente($idDocente)
    {
        $sql = "SELECT ad.id,
                       asig.nombre AS nombre_asignacion,
                       asig.creditos,
                       COUNT(i.id) AS total_inscripciones
                FROM asignaciones_docente ad
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                LEFT JOIN inscripciones i ON i.id_asignacion_docente = ad.id
                WHERE ad.id_docente = ?
                GROUP BY ad.id, asig.nombre, asig.creditos
                ORDER BY asig.nombre";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([(int)$idDocente]);
        return $stm->fetchAll(PDO::FETCH_OBJ);
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
