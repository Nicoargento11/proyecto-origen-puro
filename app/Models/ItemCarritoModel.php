<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemCarritoModel extends Model
{
    protected $table = 'items_carrito';
    protected $primaryKey = 'id';
    protected $allowedFields = ['carrito_id', 'producto_id', 'cantidad', 'precio_unitario'];

    // Configuraciones del modelo
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Agregar producto al carrito
    public function agregarProducto($carritoId, $productoId, $cantidad, $precioUnitario)
    {
        // Verificar si el producto ya existe en el carrito
        $itemExistente = $this->where('carrito_id', $carritoId)
            ->where('producto_id', $productoId)
            ->first();

        if ($itemExistente) {
            // Actualizar cantidad
            $nuevaCantidad = $itemExistente['cantidad'] + $cantidad;
            return $this->update($itemExistente['id'], [
                'cantidad' => $nuevaCantidad,
                'precio_unitario' => $precioUnitario // Actualizar precio por si cambió
            ]);
        } else {
            // Insertar nuevo item
            return $this->insert([
                'carrito_id' => $carritoId,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario
            ]);
        }
    }

    // Actualizar cantidad de un item
    public function actualizarCantidad($itemId, $nuevaCantidad)
    {
        if ($nuevaCantidad <= 0) {
            return $this->delete($itemId);
        }

        return $this->update($itemId, ['cantidad' => $nuevaCantidad]);
    }

    // Eliminar item del carrito
    public function eliminarItem($itemId)
    {
        return $this->delete($itemId);
    }    // Verificar si un item pertenece a un usuario
    public function perteneceAUsuario($itemId, $usuarioId)
    {
        $result = $this->select('COUNT(*) as count')
            ->join('carritos c', 'c.id = items_carrito.carrito_id')
            ->where('items_carrito.id', $itemId)
            ->where('c.usuario_id', $usuarioId)
            ->first();

        return $result['count'] > 0;
    }    // Obtener item con información del producto
    public function getItemConProducto($itemId)
    {
        return $this->select('items_carrito.*, p.nombre as producto_nombre, p.stock as stock_disponible, p.imagen_producto')
            ->join('productos p', 'p.id = items_carrito.producto_id')
            ->where('items_carrito.id', $itemId)
            ->first();
    }
}
