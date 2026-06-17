<?php
require_once 'models/model.base.php';

class UsuarioModel extends ModelBase
{
    public function ObtenerPorId($idUsuario)
    {
        $stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ? LIMIT 1");
        $stm->execute([(int)$idUsuario]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    public function ObtenerPerfil($idUsuario)
    {
        $sql = "SELECT u.id,
                       u.username,
                       u.correo,
                       u.rol,
                       u.alumno_id,
                       u.docente_id,
                       a.Nombre AS alumno_nombre,
                       a.Apellido AS alumno_apellido,
                       a.Sexo AS alumno_sexo,
                       a.FechaNacimiento AS alumno_fecha_nacimiento,
                       a.Foto AS alumno_foto,
                       d.nombre AS docente_nombre,
                       d.apellido AS docente_apellido,
                       d.correo AS docente_correo,
                       d.especialidad AS docente_especialidad
                FROM usuarios u
                LEFT JOIN alumnos a ON a.id = u.alumno_id
                LEFT JOIN docentes d ON d.id = u.docente_id
                WHERE u.id = ?
                LIMIT 1";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([(int)$idUsuario]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

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

    public function ExistePorUsuarioOCorreoExceptoId($username, $correo, $idUsuario)
    {
        $stm = $this->pdo->prepare(
            "SELECT id FROM usuarios WHERE (username = ? OR correo = ?) AND id <> ? LIMIT 1"
        );
        $stm->execute([$username, $correo, (int)$idUsuario]);
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

    public function ActualizarPerfil($idUsuario, array $datos)
    {
        $usuario = $this->ObtenerPerfil($idUsuario);
        if (!$usuario) {
            throw new Exception('Usuario no encontrado.');
        }

        $username = trim((string)($datos['username'] ?? ''));
        $correo = trim((string)($datos['correo'] ?? ''));
        $password = (string)($datos['password'] ?? '');

        if ($username === '' || $correo === '') {
            throw new Exception('Usuario y correo son obligatorios.');
        }

        if ($this->ExistePorUsuarioOCorreoExceptoId($username, $correo, $idUsuario)) {
            throw new Exception('El usuario o correo ya está registrado.');
        }

        $hashPassword = null;
        if ($password !== '') {
            if (strlen($password) < 8) {
                throw new Exception('La contraseña debe tener al menos 8 caracteres.');
            }
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->pdo->beginTransaction();
        try {
            $sql = "UPDATE usuarios SET username = ?, correo = ?" . ($hashPassword ? ", password_hash = ?" : "") . " WHERE id = ?";
            $params = [$username, $correo];
            if ($hashPassword) {
                $params[] = $hashPassword;
            }
            $params[] = (int)$idUsuario;
            $this->pdo->prepare($sql)->execute($params);

            if ($usuario->rol === 'alumno' && !empty($usuario->alumno_id)) {
                $this->actualizarPerfilAlumno((int)$usuario->alumno_id, $datos, $correo);
            }

            if (in_array($usuario->rol, ['profesor', 'docente'], true) && !empty($usuario->docente_id)) {
                $this->actualizarPerfilDocente((int)$usuario->docente_id, $datos, $correo);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
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

    private function actualizarPerfilAlumno($idAlumno, array $datos, $correo)
    {
        $nombre = trim((string)($datos['nombre'] ?? ''));
        $apellido = trim((string)($datos['apellido'] ?? ''));
        $sexo = (int)($datos['sexo'] ?? 0);
        $fechaNacimiento = trim((string)($datos['fecha_nacimiento'] ?? ''));
        $foto = trim((string)($datos['foto_actual'] ?? ''));

        if ($nombre === '' || $apellido === '') {
            throw new Exception('El nombre y apellido del alumno son obligatorios.');
        }

        if (!in_array($sexo, [1, 2], true)) {
            throw new Exception('Seleccione un sexo válido.');
        }

        $sql = "UPDATE alumnos SET Nombre = ?, Apellido = ?, Sexo = ?, FechaNacimiento = ?, Correo = ? WHERE id = ?";
        $this->pdo->prepare($sql)->execute([
            $nombre,
            $apellido,
            $sexo,
            $fechaNacimiento !== '' ? $fechaNacimiento : null,
            $correo,
            $idAlumno,
        ]);
    }

    private function actualizarPerfilDocente($idDocente, array $datos, $correo)
    {
        $nombre = trim((string)($datos['nombre'] ?? ''));
        $apellido = trim((string)($datos['apellido'] ?? ''));
        $especialidad = trim((string)($datos['especialidad'] ?? ''));

        if ($nombre === '' || $apellido === '') {
            throw new Exception('El nombre y apellido del docente son obligatorios.');
        }

        $sql = "UPDATE docentes SET nombre = ?, apellido = ?, correo = ?, especialidad = ? WHERE id = ?";
        $this->pdo->prepare($sql)->execute([
            $nombre,
            $apellido,
            $correo,
            $especialidad !== '' ? $especialidad : 'General',
            $idDocente,
        ]);
    }
}
