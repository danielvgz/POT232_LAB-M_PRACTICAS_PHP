<?php
require_once 'models/model.base.php';

class CalificacionModel extends ModelBase
{
    public function ContarTodos()
    {
        $stm = $this->pdo->prepare("SELECT COUNT(*) AS total FROM inscripciones");
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarTodosPaginado($limite, $offset)
    {
        $sql = "SELECT i.id,
                       i.fecha_inscripcion,
                       a.nombre AS nombre_alumno,
                       a.apellido AS apellido_alumno,
                       asig.nombre AS nombre_asignacion,
                       d.nombre AS nombre_docente,
                       d.apellido AS apellido_docente,
                       c.evaluacion1,
                       c.evaluacion2,
                       c.evaluacion3,
                       c.evaluacion4
                FROM inscripciones i
                INNER JOIN alumnos a ON a.id = i.id_alumno
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                LEFT JOIN calificaciones c ON c.id_inscripcion = i.id
                ORDER BY asig.nombre, a.apellido, a.nombre
                LIMIT ? OFFSET ?";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stm->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ContarParaDocente($idDocente)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                WHERE ad.id_docente = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([(int)$idDocente]);
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarParaDocente($idDocente)
    {
        $sql = "SELECT i.id,
                       i.fecha_inscripcion,
                       a.nombre AS nombre_alumno,
                       a.apellido AS apellido_alumno,
                       asig.nombre AS nombre_asignacion,
                       c.evaluacion1,
                       c.evaluacion2,
                       c.evaluacion3,
                       c.evaluacion4
                FROM inscripciones i
                INNER JOIN alumnos a ON a.id = i.id_alumno
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                LEFT JOIN calificaciones c ON c.id_inscripcion = i.id
                WHERE ad.id_docente = ?
                ORDER BY asig.nombre, a.apellido, a.nombre";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idDocente]);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ListarParaDocentePaginado($idDocente, $limite, $offset)
    {
        $sql = "SELECT i.id,
                       i.fecha_inscripcion,
                       a.nombre AS nombre_alumno,
                       a.apellido AS apellido_alumno,
                       asig.nombre AS nombre_asignacion,
                       c.evaluacion1,
                       c.evaluacion2,
                       c.evaluacion3,
                       c.evaluacion4
                FROM inscripciones i
                INNER JOIN alumnos a ON a.id = i.id_alumno
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                LEFT JOIN calificaciones c ON c.id_inscripcion = i.id
                WHERE ad.id_docente = ?
                ORDER BY asig.nombre, a.apellido, a.nombre
                LIMIT ? OFFSET ?";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(1, (int)$idDocente, PDO::PARAM_INT);
        $stm->bindValue(2, (int)$limite, PDO::PARAM_INT);
        $stm->bindValue(3, (int)$offset, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ListarParaAlumno($idAlumno)
    {
        $sql = "SELECT i.id,
                       asig.nombre AS nombre_asignacion,
                       d.nombre AS nombre_docente,
                       d.apellido AS apellido_docente,
                       c.evaluacion1,
                       c.evaluacion2,
                       c.evaluacion3,
                       c.evaluacion4
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                LEFT JOIN calificaciones c ON c.id_inscripcion = i.id
                WHERE i.id_alumno = ?
                ORDER BY asig.nombre";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idAlumno]);
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ContarParaAlumno($idAlumno)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM inscripciones i
                WHERE i.id_alumno = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([(int)$idAlumno]);
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    public function ListarParaAlumnoPaginado($idAlumno, $limite, $offset)
    {
        $sql = "SELECT i.id,
                       asig.nombre AS nombre_asignacion,
                       d.nombre AS nombre_docente,
                       d.apellido AS apellido_docente,
                       c.evaluacion1,
                       c.evaluacion2,
                       c.evaluacion3,
                       c.evaluacion4
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones asig ON asig.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                LEFT JOIN calificaciones c ON c.id_inscripcion = i.id
                WHERE i.id_alumno = ?
                ORDER BY asig.nombre
                LIMIT ? OFFSET ?";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(1, (int)$idAlumno, PDO::PARAM_INT);
        $stm->bindValue(2, (int)$limite, PDO::PARAM_INT);
        $stm->bindValue(3, (int)$offset, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function GuardarParaDocente($idInscripcion, $idDocente, array $evaluaciones)
    {
        $validacion = $this->pdo->prepare(
            "SELECT 1
             FROM inscripciones i
             INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
             WHERE i.id = ? AND ad.id_docente = ?
             LIMIT 1"
        );
        $validacion->execute([$idInscripcion, $idDocente]);

        if (!$validacion->fetch(PDO::FETCH_ASSOC)) {
            throw new Exception('No tiene permiso para calificar esta matrícula.');
        }

        $sql = "INSERT INTO calificaciones (id_inscripcion, evaluacion1, evaluacion2, evaluacion3, evaluacion4)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    evaluacion1 = VALUES(evaluacion1),
                    evaluacion2 = VALUES(evaluacion2),
                    evaluacion3 = VALUES(evaluacion3),
                    evaluacion4 = VALUES(evaluacion4)";

        $this->pdo->prepare($sql)->execute([
            $idInscripcion,
            $evaluaciones['evaluacion1'],
            $evaluaciones['evaluacion2'],
            $evaluaciones['evaluacion3'],
            $evaluaciones['evaluacion4'],
        ]);
    }

    public function ObtenerDocenteIdPorUsuario($idUsuario, $correoUsuario)
    {
        $sql = "SELECT COALESCE(u.docente_id, d.id) AS docente_id
                FROM usuarios u
                LEFT JOIN docentes d ON d.correo = u.correo
                WHERE u.id = ?
                LIMIT 1";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idUsuario]);
        $row = $stm->fetch(PDO::FETCH_OBJ);

        if (!empty($row->docente_id)) {
            return (int)$row->docente_id;
        }

        if ($correoUsuario !== '') {
            $fallback = $this->pdo->prepare("SELECT id FROM docentes WHERE correo = ? LIMIT 1");
            $fallback->execute([$correoUsuario]);
            $docente = $fallback->fetch(PDO::FETCH_OBJ);
            if ($docente) {
                return (int)$docente->id;
            }
        }

        return null;
    }

    public function ObtenerAlumnoIdPorUsuario($idUsuario, $correoUsuario)
    {
        $sql = "SELECT COALESCE(u.alumno_id, a.id) AS alumno_id
                FROM usuarios u
                LEFT JOIN alumnos a ON a.correo = u.correo
                WHERE u.id = ?
                LIMIT 1";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idUsuario]);
        $row = $stm->fetch(PDO::FETCH_OBJ);

        if (!empty($row->alumno_id)) {
            return (int)$row->alumno_id;
        }

        if ($correoUsuario !== '') {
            $fallback = $this->pdo->prepare("SELECT id FROM alumnos WHERE correo = ? LIMIT 1");
            $fallback->execute([$correoUsuario]);
            $alumno = $fallback->fetch(PDO::FETCH_OBJ);
            if ($alumno) {
                return (int)$alumno->id;
            }
        }

        return null;
    }
}
