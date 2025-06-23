<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'origen',
        'proceso',
        'tostacion',
        'notas_cata',
        'puntuacion',
        'imagen_producto',
        'destacado',
        'activo'
    ];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Timestamps automáticos
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_creacion'; // Solo usamos uno

    // Obtener productos activos
    public function getProductosActivos($limite = null)
    {
        $query = $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', true)
            ->orderBy('productos.destacado', 'DESC')
            ->orderBy('productos.fecha_creacion', 'DESC');

        if ($limite) {
            $query->limit($limite);
        }

        return $query->findAll();
    }

    // Obtener productos destacados
    public function getProductosDestacados($limite = 6)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', true)
            ->where('productos.destacado', true)
            ->limit($limite)
            ->findAll();
    }    // Obtener productos destacados para la home
    public function obtenerProductosDestacados($limite = 4)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', true)
            ->where('productos.destacado', true)
            ->orderBy('productos.nombre', 'ASC')
            ->limit($limite)
            ->findAll();
    }

    // Obtener productos por categoría
    public function getProductosPorCategoria($categoriaId)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.categoria_id', $categoriaId)
            ->where('productos.activo', true)
            ->orderBy('productos.nombre')
            ->findAll();
    }

    // Obtener producto por ID con información de categoría
    public function getProductoCompleto($id)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre, categorias.slug as categoria_slug')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.id', $id)
            ->where('productos.activo', true)
            ->first();
    }

    // Buscar productos
    public function buscarProductos($termino)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', true)
            ->groupStart()
            ->like('productos.nombre', $termino)
            ->orLike('productos.descripcion', $termino)
            ->orLike('productos.origen', $termino)
            ->orLike('productos.notas_cata', $termino)
            ->groupEnd()
            ->findAll();
    }

    // Verificar stock disponible
    public function tieneStock($productoId, $cantidad = 1)
    {
        $producto = $this->find($productoId);
        return $producto && $producto['stock'] >= $cantidad;
    }

    // Reducir stock
    public function reducirStock($productoId, $cantidad)
    {
        $producto = $this->find($productoId);
        if ($producto && $producto['stock'] >= $cantidad) {
            return $this->update($productoId, ['stock' => $producto['stock'] - $cantidad]);
        }
        return false;
    }
}
