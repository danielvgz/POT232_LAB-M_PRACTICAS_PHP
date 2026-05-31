<?php
require_once 'models/model.base.php';

class UsuarioModel extends ModelBase
{
    public function Login($usuarioOCorreo, $password)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE username = ? OR correo = ? LIMIT 1");
            $stm->execute([$usuarioOCorreo, $usuarioOCorreo]);
            $r = $stm->fetch(PDO::FETCH_OBJ);

            $esPasswordValido = false;
            if ($r) {
                if (password_verify($password, $r->password_hash)) {
                    $esPasswordValido = true;
                } elseif (md5($password) === $r->password_hash) {
                    $esPasswordValido = true;
                    $this->actualizarHashPassword($r->id, $password);
                }
            }

            if ($r && $esPasswordValido) {
                $user = new Usuario();
                $user->__SET('id', $r->id);
                $user->__SET('username', $r->username);
                $user->__SET('correo', $r->correo);
                $user->__SET('password', $r->password_hash);
                $user->__SET('rol', $r->rol);
                $user->__SET('alumno_id', $r->alumno_id ?? null);
                $user->__SET('docente_id', $r->docente_id ?? null);
                return $user;
            }
            return false;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function ExistePorUsuarioOCorreo($username, $correo)
    {
        $stm = $this->pdo->prepare("SELECT id FROM usuarios WHERE username = ? OR correo = ? LIMIT 1");
        $stm->execute([$username, $correo]);
        return (bool) $stm->fetch(PDO::FETCH_OBJ);
    }

    public function RegistrarAlumno($username, $correo, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $alumnoId = $this->buscarAlumnoIdPorCorreo($correo);

        $sql = "INSERT INTO usuarios (username, correo, password_hash, rol, alumno_id, docente_id)
                VALUES (?, ?, ?, 'alumno', ?, NULL)";
        $this->pdo->prepare($sql)->execute([$username, $correo, $hash, $alumnoId]);
    }

    public function ListarAlumnos()
    {
        $sql = "SELECT id, username, correo, rol
                FROM usuarios
                WHERE rol = 'alumno'
                ORDER BY username ASC";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function AsignarProfesor($idUsuario)
    {
        $usuario = $this->obtenerUsuarioAlumno($idUsuario);
        if (!$usuario) {
            return false;
        }

        $docenteId = $this->resolverDocenteIdParaUsuario($usuario);
        if (!$docenteId) {
            return false;
        }

        $sql = "UPDATE usuarios
                SET rol = 'profesor', docente_id = ?
                WHERE id = ? AND rol = 'alumno'";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$docenteId, $idUsuario]);
        return $stm->rowCount() > 0;
    }

    private function buscarAlumnoIdPorCorreo($correo)
    {
        $stm = $this->pdo->prepare("SELECT id FROM alumnos WHERE Correo = ? LIMIT 1");
        $stm->execute([$correo]);
        $row = $stm->fetch(PDO::FETCH_OBJ);
        return $row ? $row->id : null;
    }

    private function actualizarHashPassword($id, $password)
    {
        $nuevoHash = password_hash($password, PASSWORD_DEFAULT);
        $this->pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?")
            ->execute([$nuevoHash, $id]);
    }

    private function obtenerUsuarioAlumno($idUsuario)
    {
        $sql = "SELECT u.id,
                       u.correo,
                       u.docente_id,
                       u.alumno_id,
                       COALESCE(a.Nombre, a.nombre) AS nombre_alumno,
                       COALESCE(a.Apellido, a.apellido) AS apellido_alumno
                FROM usuarios u
                LEFT JOIN alumnos a ON a.id = u.alumno_id
                WHERE u.id = ? AND u.rol = 'alumno'
                LIMIT 1";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idUsuario]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    private function resolverDocenteIdParaUsuario($usuario)
    {
        if (!empty($usuario->docente_id)) {
            return (int)$usuario->docente_id;
        }

        $correo = (string)($usuario->correo ?? '');
        if ($correo !== '') {
            $stm = $this->pdo->prepare("SELECT id FROM docentes WHERE correo = ? LIMIT 1");
            $stm->execute([$correo]);
            $docente = $stm->fetch(PDO::FETCH_OBJ);
            if ($docente) {
                return (int)$docente->id;
            }
        }

        $nombre = trim((string)($usuario->nombre_alumno ?? ''));
        $apellido = trim((string)($usuario->apellido_alumno ?? ''));
        if ($nombre === '') {
            $nombre = 'Docente';
        }
        if ($apellido === '') {
            $apellido = 'Asignado';
        }

        $sqlInsert = "INSERT INTO docentes (nombre, apellido, correo, especialidad)
                      VALUES (?, ?, ?, ?)";
        $this->pdo->prepare($sqlInsert)->execute([$nombre, $apellido, $correo, 'General']);
        return (int)$this->pdo->lastInsertId();
    }
}
