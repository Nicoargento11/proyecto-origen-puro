<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoPagoModel extends Model
{
    protected $table = 'metodos_pago';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'activo'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'nombre' => 'required|max_length[100]',
        'activo' => 'in_list[0,1]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Obtener métodos de pago activos
    public function getMetodosActivos()
    {
        return $this->where('activo', 1)->findAll();
    }

    // Verificar si un método está activo
    public function estaActivo($id)
    {
        $metodo = $this->find($id);
        return $metodo && $metodo['activo'] == 1;
    }

    // Activar/desactivar método
    public function toggleActivo($id)
    {
        $metodo = $this->find($id);
        if ($metodo) {
            return $this->update($id, ['activo' => $metodo['activo'] ? 0 : 1]);
        }
        return false;
    }
}
