<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemPedidoModel extends Model
{
    protected $table = 'items_pedido';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'nombre_producto'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'pedido_id' => 'required|integer',
        'producto_id' => 'required|integer',
        'cantidad' => 'required|integer|greater_than[0]',
        'precio_unitario' => 'required|decimal',
        'nombre_producto' => 'required|max_length[255]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;    // Obtener items de un pedido específico
    public function getItemsPorPedido($pedido_id)
    {
        return $this->select('items_pedido.*, productos.imagen_producto, productos.descripcion')
            ->join('productos', 'productos.id = items_pedido.producto_id', 'left')
            ->where('pedido_id', $pedido_id)
            ->findAll();
    }

    // Crear items desde carrito
    public function crearDesdeCarrito($pedido_id, $items_carrito)
    {
        $items_creados = [];

        foreach ($items_carrito as $item) {
            $item_data = [
                'pedido_id' => $pedido_id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'nombre_producto' => $item['nombre']
            ];

            $item_id = $this->insert($item_data);
            if ($item_id) {
                $items_creados[] = $item_id;
            }
        }

        return $items_creados;
    }

    // Calcular subtotal de un pedido
    public function calcularSubtotalPedido($pedido_id)
    {
        $result = $this->selectSum('cantidad * precio_unitario', 'subtotal')
            ->where('pedido_id', $pedido_id)
            ->first();

        return $result['subtotal'] ?? 0;
    }

    // Obtener productos más vendidos
    public function getProductosMasVendidos($limit = 10)
    {
        return $this->select('producto_id, nombre_producto, SUM(cantidad) as total_vendido')
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Eliminar items por pedido
    public function eliminarPorPedido($pedido_id)
    {
        return $this->where('pedido_id', $pedido_id)->delete();
    }
}
