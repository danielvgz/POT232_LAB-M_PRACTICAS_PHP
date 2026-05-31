<?php
require_once 'models/model.base.php';
require_once 'models/inscripcion.entidad.php';

class InscripcionModel extends ModelBase
{
    // El constructor base ya establece $this->pdo
    // Métodos CRUD y de soporte:
    public function Listar() {
        $sql = "SELECT i.id, i.fecha_inscripcion, a.id as id_alumno, a.nombre as nombre_alumno, a.apellido as apellido_alumno, ad.id as id_asignacion_docente, asig.nombre AS nombre_asignacion, d.nombre AS nombre_docente, d.apellido AS apellido_docente
                FROM inscripciones i
                INNER JOIN alumnos a ON i.id_alumno = a.id
                INNER JOIN asignaciones_docente ad ON i.id_asignacion_docente = ad.id
                INNER JOIN asignaciones asig ON ad.id_asignacion = asig.id
                INNER JOIN docentes d ON ad.id_docente = d.id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function Obtener($id) {
        $stm = $this->pdo->prepare("SELECT * FROM inscripciones WHERE id = ?");
        $stm->execute([$id]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    public function Eliminar($id) {
        $stm = $this->pdo->prepare("DELETE FROM inscripciones WHERE id = ?");
        $stm->execute([$id]);
    }

    public function Actualizar(Inscripcion $data) {
        $this->validarLimiteCreditos(
            $data->__GET('id_alumno'),
            $data->__GET('id_asignacion_docente'),
            $data->__GET('id')
        );

        $sql = "UPDATE inscripciones SET id_alumno = ?, id_asignacion_docente = ?, fecha_inscripcion = ? WHERE id = ?";
        $this->pdo->prepare($sql)
            ->execute([
                $data->__GET('id_alumno'),
                $data->__GET('id_asignacion_docente'),
                $data->__GET('fecha_inscripcion'),
                $data->__GET('id')
            ]);
    }

    public function Registrar(Inscripcion $data) {
        $this->validarLimiteCreditos(
            $data->__GET('id_alumno'),
            $data->__GET('id_asignacion_docente')
        );

        $sql = "INSERT INTO inscripciones (id_alumno, id_asignacion_docente, fecha_inscripcion) VALUES (?, ?, ?)";
        $this->pdo->prepare($sql)
            ->execute([
                $data->__GET('id_alumno'),
                $data->__GET('id_asignacion_docente'),
                $data->__GET('fecha_inscripcion'),
            ]);
    }

    public function ListarAlumnos() {
        $stm = $this->pdo->prepare("SELECT * FROM alumnos WHERE activo = 1");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function ListarAsignacionesDocente() {
        $sql = "SELECT ad.id, asig.nombre AS nombre_asignacion, d.nombre AS nombre_docente, d.apellido AS apellido_docente
                FROM asignaciones_docente ad
                INNER JOIN asignaciones asig ON ad.id_asignacion = asig.id
                INNER JOIN docentes d ON ad.id_docente = d.id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    private function validarLimiteCreditos($idAlumno, $idAsignacionDocente, $idInscripcionExcluir = null)
    {
        $creditosActuales = $this->obtenerCreditosInscritosPorAlumno($idAlumno, $idInscripcionExcluir);
        $creditosNuevaMatricula = $this->obtenerCreditosDeAsignacionDocente($idAsignacionDocente);

        if (($creditosActuales + $creditosNuevaMatricula) > 30) {
            throw new Exception('El alumno no puede inscribir más de 30 créditos.');
        }
    }

    private function obtenerCreditosInscritosPorAlumno($idAlumno, $idInscripcionExcluir = null)
    {
        $sql = "SELECT COALESCE(SUM(asig.creditos), 0) AS total
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON i.id_asignacion_docente = ad.id
                INNER JOIN asignaciones asig ON ad.id_asignacion = asig.id
                WHERE i.id_alumno = ?";

        $params = [$idAlumno];
        if ($idInscripcionExcluir !== null) {
            $sql .= " AND i.id <> ?";
            $params[] = $idInscripcionExcluir;
        }

        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return (int)($row->total ?? 0);
    }

    private function obtenerCreditosDeAsignacionDocente($idAsignacionDocente)
    {
        $sql = "SELECT asig.creditos
                FROM asignaciones_docente ad
                INNER JOIN asignaciones asig ON ad.id_asignacion = asig.id
                WHERE ad.id = ?
                LIMIT 1";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idAsignacionDocente]);
        $row = $stm->fetch(PDO::FETCH_OBJ);

        if (!$row) {
            throw new Exception('La matrícula seleccionada no existe.');
        }

        return (int)$row->creditos;
    }
}
