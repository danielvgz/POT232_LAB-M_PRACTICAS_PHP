<?php

declare(strict_types=1);

class UsuarioModel extends Model
{
    public function all(): array
    {
        $sql = 'SELECT u.*, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM usuarios u
                LEFT JOIN alumnos a ON a.id = u.alumno_id
                LEFT JOIN docentes d ON d.id = u.docente_id
                ORDER BY u.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO usuarios (username, correo, password_hash, rol, alumno_id, docente_id) VALUES (:username, :correo, :password_hash, :rol, :alumno_id, :docente_id)');
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $passwordHash = $data['password_hash'] ?? null;
        unset($data['password_hash']);
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE usuarios SET username=:username, correo=:correo, rol=:rol, alumno_id=:alumno_id, docente_id=:docente_id WHERE id=:id');
        $stmt->execute($data);

        if (!empty($passwordHash)) {
            $stmtPwd = $this->db->prepare('UPDATE usuarios SET password_hash = :password_hash WHERE id = :id');
            $stmtPwd->execute(['password_hash' => $passwordHash, 'id' => $id]);
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
    }
}
