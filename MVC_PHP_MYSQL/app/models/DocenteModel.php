<?php

declare(strict_types=1);

class DocenteModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM docentes ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM docentes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO docentes (nombre, apellido, correo, especialidad) VALUES (:nombre, :apellido, :correo, :especialidad)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE docentes SET nombre=:nombre, apellido=:apellido, correo=:correo, especialidad=:especialidad WHERE id=:id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM docentes WHERE id = ?');
        $stmt->execute([$id]);
    }
}
