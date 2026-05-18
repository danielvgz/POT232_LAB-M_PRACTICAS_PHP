<?php

declare(strict_types=1);

class AsignacionDocenteModel extends Model
{
    public function all(): array
    {
        $sql = 'SELECT ad.*, a.nombre AS asignacion_nombre, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM asignaciones_docente ad
                INNER JOIN asignaciones a ON a.id = ad.id_asignacion
                INNER JOIN docentes d ON d.id = ad.id_docente
                ORDER BY ad.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function byDocente(int $docenteId): array
    {
        $stmt = $this->db->prepare('SELECT ad.*, a.nombre AS asignacion_nombre FROM asignaciones_docente ad INNER JOIN asignaciones a ON a.id = ad.id_asignacion WHERE ad.id_docente = ? ORDER BY ad.id DESC');
        $stmt->execute([$docenteId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM asignaciones_docente WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO asignaciones_docente (id_asignacion, id_docente) VALUES (:id_asignacion, :id_docente)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE asignaciones_docente SET id_asignacion=:id_asignacion, id_docente=:id_docente WHERE id=:id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM asignaciones_docente WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function enrolledByDocente(int $docenteId): array
    {
        $sql = 'SELECT i.id, i.fecha_inscripcion, a.nombre AS asignacion, al.nombre AS alumno_nombre, al.apellido AS alumno_apellido, al.correo
                FROM inscripciones i
                INNER JOIN asignaciones_docente ad ON ad.id = i.id_asignacion_docente
                INNER JOIN asignaciones a ON a.id = ad.id_asignacion
                INNER JOIN alumnos al ON al.id = i.id_alumno
                WHERE ad.id_docente = :docente_id
                ORDER BY i.fecha_inscripcion DESC, i.id DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['docente_id' => $docenteId]);
        return $stmt->fetchAll();
    }
}
