<?php
require_once BASE_PATH . '/models/BaseModel.php';

class UserModel extends BaseModel
{
    public function all()
    {
        $sql = 'SELECT u.id, u.correo, u.rol, u.alumno_id, u.docente_id,
                       a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM usuarios u
                LEFT JOIN alumnos a ON a.id = u.alumno_id
                LEFT JOIN docentes d ON d.id = u.docente_id
                ORDER BY u.id DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, correo, rol, alumno_id, docente_id FROM usuarios WHERE id = ?');
        $stmt->execute(array((int) $id));
        return $stmt->fetch();
    }

    public function profiles()
    {
        $alumnos = $this->pdo->query("SELECT id, CONCAT(nombre, ' ', apellido) AS nombre FROM alumnos ORDER BY nombre ASC")->fetchAll();
        $docentes = $this->pdo->query("SELECT id, CONCAT(nombre, ' ', apellido) AS nombre FROM docentes ORDER BY nombre ASC")->fetchAll();

        return array('alumnos' => $alumnos, 'docentes' => $docentes);
    }

    public function login($correo, $password)
    {
        $sql = 'SELECT id, correo, password, rol, alumno_id, docente_id FROM usuarios WHERE correo = ? LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($correo));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        return false;
    }

    public function save($data)
    {
        $password = isset($data['password']) ? trim($data['password']) : '';

        if (!empty($data['id'])) {
            $sql = 'UPDATE usuarios SET correo = ?, rol = ?, alumno_id = ?, docente_id = ?' . (!empty($password) ? ', password = ?' : '') . ' WHERE id = ?';
            $params = array(
                $data['correo'],
                $data['rol'],
                !empty($data['alumno_id']) ? (int) $data['alumno_id'] : null,
                !empty($data['docente_id']) ? (int) $data['docente_id'] : null,
            );
            if (!empty($password)) {
                $params[] = password_hash($password, PASSWORD_DEFAULT);
            }
            $params[] = (int) $data['id'];
        } else {
            $sql = 'INSERT INTO usuarios (correo, password, rol, alumno_id, docente_id) VALUES (?,?,?,?,?)';
            $params = array(
                $data['correo'],
                password_hash($password ?: 'password', PASSWORD_DEFAULT),
                $data['rol'],
                !empty($data['alumno_id']) ? (int) $data['alumno_id'] : null,
                !empty($data['docente_id']) ? (int) $data['docente_id'] : null,
            );
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function updateProfile($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE usuarios SET correo = ?, password = CASE WHEN ? = "" THEN password ELSE ? END WHERE id = ?');
        $passwordHash = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : '';
        $stmt->execute(array($data['correo'], $passwordHash, $passwordHash, (int) $id));
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = ?');
        $stmt->execute(array((int) $id));
    }
}
