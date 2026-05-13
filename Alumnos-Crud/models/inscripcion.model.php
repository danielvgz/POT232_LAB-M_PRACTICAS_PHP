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
}
