<?php

declare(strict_types=1);

class AsignacionModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM asignaciones ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM asignaciones WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO asignaciones (nombre, descripcion) VALUES (:nombre, :descripcion)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE asignaciones SET nombre=:nombre, descripcion=:descripcion WHERE id=:id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM asignaciones WHERE id = ?');
        $stmt->execute([$id]);
    }
}
