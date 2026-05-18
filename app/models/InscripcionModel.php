<?php

declare(strict_types=1);

class InscripcionModel extends Model
{
    public function all(): array
    {
        $sql = 'SELECT i.*, al.nombre AS alumno_nombre, al.apellido AS alumno_apellido, a.nombre AS asignacion_nombre, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM inscripciones i
                INNER JOIN alumnos al ON al.id = i.id_alumno
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones a ON a.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                ORDER BY i.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM inscripciones WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO inscripciones (id_alumno, id_asignacion_docente, fecha_inscripcion) VALUES (:id_alumno, :id_asignacion_docente, :fecha_inscripcion)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE inscripciones SET id_alumno=:id_alumno, id_asignacion_docente=:id_asignacion_docente, fecha_inscripcion=:fecha_inscripcion WHERE id=:id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM inscripciones WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function availableForAlumno(int $alumnoId): array
    {
        $sql = 'SELECT ad.id, a.nombre AS asignacion_nombre, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM asignaciones_docente ad
                INNER JOIN asignaciones a ON a.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                LEFT JOIN inscripciones i ON i.id_asignacion_docente = ad.id AND i.id_alumno = :alumno_id
                WHERE i.id IS NULL
                ORDER BY a.nombre, d.apellido, d.nombre';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['alumno_id' => $alumnoId]);
        return $stmt->fetchAll();
    }

    public function byAlumno(int $alumnoId): array
    {
        $sql = 'SELECT i.id, i.fecha_inscripcion, a.nombre AS asignacion_nombre, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones a ON a.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                WHERE i.id_alumno = :alumno_id
                ORDER BY i.id DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['alumno_id' => $alumnoId]);
        return $stmt->fetchAll();
    }
}
