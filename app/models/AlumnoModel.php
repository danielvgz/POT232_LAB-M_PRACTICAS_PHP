<?php

declare(strict_types=1);

class AlumnoModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM alumnos ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM alumnos WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO alumnos (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES (:nombre, :apellido, :sexo, :fecha_nacimiento, :fecha_registro, :foto, :correo)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE alumnos SET nombre=:nombre, apellido=:apellido, sexo=:sexo, fecha_nacimiento=:fecha_nacimiento, fecha_registro=:fecha_registro, foto=:foto, correo=:correo WHERE id=:id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM alumnos WHERE id = ?');
        $stmt->execute([$id]);
    }
}
