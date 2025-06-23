<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'slug', 'activa'];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Obtener todas las categorías activas
    public function getCategoriasActivas()
    {
        return $this->where('activa', true)->findAll();
    }

    // Obtener categoría por slug
    public function getPorSlug($slug)
    {
        return $this->where('slug', $slug)->where('activa', true)->first();
    }

    // Crear slug automáticamente antes de insertar
    protected $beforeInsert = ['createSlug'];
    protected $beforeUpdate = ['createSlug'];

    protected function createSlug(array $data)
    {
        if (isset($data['data']['nombre']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['nombre'], '-', true);
        }
        return $data;
    }

    // Obtener categorías con contador de productos
    public function getCategoriasConProductos()
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT c.*, COUNT(p.id) as total_productos
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id AND p.activo = 1
            WHERE c.activa = 1
            GROUP BY c.id
            ORDER BY c.nombre
        ")->getResultArray();
    }
}
