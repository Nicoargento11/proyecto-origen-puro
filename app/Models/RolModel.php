<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion'];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Obtener todos los roles
    public function getAllRoles()
    {
        return $this->findAll();
    }

    // Obtener rol por nombre
    public function getRolPorNombre($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }

    // Crear roles básicos del sistema
    public function crearRolesBasicos()
    {
        $rolesBasicos = [
            [
                'nombre' => 'admin',
                'descripcion' => 'Administrador del sistema con acceso completo'
            ],
            [
                'nombre' => 'usuario',
                'descripcion' => 'Usuario estándar del sistema'
            ],
            [
                'nombre' => 'moderador',
                'descripcion' => 'Moderador con permisos intermedios'
            ]
        ];

        foreach ($rolesBasicos as $rol) {
            // Solo crear si no existe
            if (!$this->getRolPorNombre($rol['nombre'])) {
                $this->insert($rol);
            }
        }
    }
}
