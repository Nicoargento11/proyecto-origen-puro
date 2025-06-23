<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\PedidoModel;
use App\Traits\AdminHelpers;

class DashboardController extends BaseController
{
    use AdminHelpers;

    protected $usuarioModel;
    protected $productoModel;
    protected $pedidoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->productoModel = new ProductoModel();
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        // Obtener estadísticas para el dashboard
        $totalPedidos = $this->pedidoModel->countAll();

        // Calcular ventas totales
        $ventasTotal = $this->pedidoModel->selectSum('total')
            ->where('estado !=', 'cancelado')
            ->first();

        $data = [
            'title' => 'Panel de Administración',
            'user' => $this->getAdminUserData(),
            'stats' => [
                'usuarios' => $this->usuarioModel->countAll(),
                'productos' => $this->productoModel->where('activo', true)->countAllResults(),
                'pedidos' => $totalPedidos,
                'ventas' => $ventasTotal['total'] ?? 0,
                'pedidos_pendientes' => $this->pedidoModel->where('estado', 'pendiente')->countAllResults(),
                'productos_bajo_stock' => $this->productoModel->where('stock <=', 'stock_minimo')->countAllResults()
            ]
        ];

        return view('admin/dashboard_main', $data);
    }

    public function getStats()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $stats = [
                'usuarios' => $this->usuarioModel->countAll(),
                'productos' => $this->productoModel->where('activo', true)->countAllResults(),
                'pedidos' => $this->pedidoModel->countAll(),
                'pedidos_pendientes' => $this->pedidoModel->where('estado', 'pendiente')->countAllResults(),
                'productos_bajo_stock' => $this->productoModel->where('stock <=', 'stock_minimo')->countAllResults()
            ];

            // Calcular ventas totales
            $ventasTotal = $this->pedidoModel->selectSum('total')
                ->where('estado !=', 'cancelado')
                ->first();
            $stats['ventas'] = $ventasTotal['total'] ?? 0;

            // Pedidos por estado
            $pedidosPorEstado = $this->pedidoModel->select('estado, COUNT(*) as cantidad')
                ->groupBy('estado')
                ->findAll();
            $stats['pedidos_por_estado'] = $pedidosPorEstado;

            // Productos más vendidos (últimos 30 días)
            $productosMasVendidos = $this->pedidoModel->query("
                SELECT p.nombre, SUM(ip.cantidad) as total_vendido
                FROM item_pedidos ip
                JOIN productos p ON p.id = ip.producto_id
                JOIN pedidos ped ON ped.id = ip.pedido_id
                WHERE ped.fecha_pedido >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                  AND ped.estado != 'cancelado'
                GROUP BY p.id
                ORDER BY total_vendido DESC
                LIMIT 5
            ")->getResultArray();
            $stats['productos_mas_vendidos'] = $productosMasVendidos;
            return $this->sendJsonResponse(true, 'Estadísticas obtenidas exitosamente', $stats);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener estadísticas');
        }
    }
}
