<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id'];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Timestamps automáticos
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

    // Obtener o crear carrito para usuario
    public function obtenerCarritoUsuario($usuarioId)
    {
        $carrito = $this->where('usuario_id', $usuarioId)->first();

        if (!$carrito) {
            $carritoId = $this->insert(['usuario_id' => $usuarioId]);
            $carrito = $this->find($carritoId);
        }

        return $carrito;
    }

    // Obtener carrito con items y productos
    public function getCarritoCompleto($usuarioId)
    {
        $carrito = $this->obtenerCarritoUsuario($usuarioId);

        if (!$carrito) {
            return null;
        }

        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT 
                ic.*,
                p.nombre as producto_nombre,
                p.imagen_producto,
                p.stock as stock_disponible,
                (ic.cantidad * ic.precio_unitario) as subtotal
            FROM items_carrito ic
            INNER JOIN productos p ON ic.producto_id = p.id
            WHERE ic.carrito_id = ? AND p.activo = 1
            ORDER BY ic.id DESC
        ", [$carrito['id']]);

        $items = $query->getResultArray();

        return [
            'carrito' => $carrito,
            'items' => $items,
            'total_items' => count($items),
            'total_cantidad' => array_sum(array_column($items, 'cantidad')),
            'total_precio' => array_sum(array_column($items, 'subtotal'))
        ];
    }

    // Limpiar carrito
    public function limpiarCarrito($usuarioId)
    {
        $carrito = $this->obtenerCarritoUsuario($usuarioId);
        if ($carrito) {
            $itemsModel = new ItemCarritoModel();
            return $itemsModel->where('carrito_id', $carrito['id'])->delete();
        }
        return false;
    }

    // Contar items del carrito
    public function contarItems($usuarioId)
    {
        $carrito = $this->where('usuario_id', $usuarioId)->first();
        if (!$carrito) {
            return 0;
        }

        $itemsModel = new ItemCarritoModel();
        return $itemsModel->where('carrito_id', $carrito['id'])->countAllResults();
    }
}
