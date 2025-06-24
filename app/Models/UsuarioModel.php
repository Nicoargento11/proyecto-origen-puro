<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'password', 'telefono', 'direccion', 'ciudad', 'codigo_postal', 'pais', 'baja'];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;    // Timestamps automáticos - deshabilitados porque manejamos fecha_registro manualmente
    protected $useTimestamps = false;

    // Hash automático deshabilitado - lo manejamos manualmente en el controlador
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Validar credenciales de login
    public function validateLogin($email, $password)
    {
        $user = $this->where('email', $email)
            ->where('baja', 'NO')
            ->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Verificar si el email ya existe
    public function emailExists($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
    public function testConnection()
    {
        return $this->db->query('SELECT 1 as conexion_ok')->getRow();
    }    // Obtener usuario con sus roles
    public function getUsuarioConRoles($userId)
    {
        $usuario = $this->where('id', $userId)->where('baja', 'NO')->first();
        if (!$usuario) {
            return null;
        }

        // Obtener roles del usuario usando la conexión del modelo
        $rolesQuery = $this->db->table('roles r')
            ->select('r.*')
            ->join('usuario_roles ur', 'r.id = ur.rol_id')
            ->where('ur.usuario_id', $userId)
            ->get();

        $usuario['roles'] = $rolesQuery->getResultArray();
        return $usuario;
    }    // Asignar rol a usuario
    public function asignarRol($userId, $rolId)
    {
        return $this->db->table('usuario_roles')
            ->ignore(true)  // Equivalente a INSERT IGNORE
            ->insert([
                'usuario_id' => $userId,
                'rol_id' => $rolId
            ]);
    }

    // Eliminar todos los roles de un usuario
    public function eliminarRoles($userId)
    {
        return $this->db->table('usuario_roles')
            ->where('usuario_id', $userId)
            ->delete();
    }

    // Verificar si usuario tiene un rol específico
    public function tieneRol($userId, $rolNombre)
    {
        $count = $this->db->table('usuario_roles ur')
            ->select('COUNT(*) as count')
            ->join('roles r', 'ur.rol_id = r.id')
            ->where('ur.usuario_id', $userId)
            ->where('r.nombre', $rolNombre)
            ->countAllResults();

        return $count > 0;
    }
}
