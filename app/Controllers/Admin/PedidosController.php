<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\ItemPedidoModel;
use App\Models\PagoModel;
use App\Traits\AdminHelpers;

class PedidosController extends BaseController
{
    use AdminHelpers;

    protected $pedidoModel;
    protected $itemPedidoModel;
    protected $pagoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->itemPedidoModel = new ItemPedidoModel();
        $this->pagoModel = new PagoModel();
    }

    // =============================================
    // VISTAS
    // =============================================

    public function index()
    {
        $data = [
            'title' => 'Gestión de Pedidos',
            'user' => $this->getAdminUserData()
        ];

        return view('admin/pedidos/index', $data);
    }

    public function editar($id)
    {
        // Obtener pedido real
        $pedido = $this->pedidoModel->getPedidoCompleto($id);

        if (!$pedido) {
            return redirect()->to('/admin/pedidos')->with('error', 'Pedido no encontrado');
        }

        $data = [
            'title' => 'Editar Pedido #' . str_pad($id, 6, '0', STR_PAD_LEFT) . ' - Admin',
            'user' => $this->getAdminUserData(),
            'pedido' => $pedido
        ];

        return view('admin/pedidos/editar', $data);
    }

    public function ver($id)
    {
        // Obtener pedido completo
        $pedido = $this->pedidoModel->getPedidoCompleto($id);

        if (!$pedido) {
            return redirect()->to('/admin/pedidos')->with('error', 'Pedido no encontrado');
        }        // Obtener items del pedido
        $items = $this->itemPedidoModel->getItemsPorPedido($id);

        $data = [
            'title' => 'Ver Pedido #' . str_pad($id, 6, '0', STR_PAD_LEFT),
            'user' => $this->getAdminUserData(),
            'pedido' => $pedido,
            'items' => $items
        ];
        return view('admin/pedidos/ver', $data);
    }

    // =============================================
    // APIs
    // =============================================

    public function getPedidos()
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $pedidos = $this->pedidoModel->getPedidosCompletos();
            return $this->sendJsonResponse(true, 'Pedidos obtenidos exitosamente', $pedidos);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener pedidos');
        }
    }

    public function getPedido($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            // Obtener pedido completo con datos de usuario y pago
            $pedido = $this->pedidoModel->getPedidoCompleto($id);

            if (!$pedido) {
                return $this->sendJsonResponse(false, 'Pedido no encontrado');
            }

            // Obtener información del pago
            $pago = $this->pagoModel->where('pedido_id', $id)->first();
            if ($pago) {
                $pedido['pago'] = $pago;
            }

            // Contar total de productos
            $totalProductos = $this->itemPedidoModel->where('pedido_id', $id)
                ->selectSum('cantidad')
                ->first();
            $pedido['total_productos'] = $totalProductos['cantidad'] ?? 0;
            return $this->sendJsonResponse(true, 'Pedido obtenido exitosamente', $pedido);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener pedido');
        }
    }
    public function getProductosPedido($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $items = $this->itemPedidoModel->getItemsPorPedido($id);
            return $this->sendJsonResponse(true, 'Productos del pedido obtenidos exitosamente', $items);
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al obtener productos del pedido');
        }
    }

    public function actualizarPedido($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            $pedido = $this->pedidoModel->find($id);
            if (!$pedido) {
                return $this->sendJsonResponse(false, 'Pedido no encontrado');
            }

            // Obtener datos JSON para PUT request, o POST como fallback
            $datos = $this->request->getJSON(true);
            if (!$datos) {
                $datos = $this->request->getPost();
            }
            $rules = [
                'estado' => 'required|in_list[pendiente,procesando,enviado,completado,cancelado]'
            ];

            if (!$this->validate($rules, $datos)) {
                return $this->sendJsonResponse(false, 'Datos inválidos', [
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Preparar datos de actualización
            $updateData = [
                'estado' => $datos['estado']
            ];

            // Agregar número de seguimiento si se proporcionó
            if (!empty($datos['numero_seguimiento'])) {
                $updateData['numero_seguimiento'] = trim($datos['numero_seguimiento']);
            }

            // Agregar notas si se proporcionaron
            if (!empty($datos['notas'])) {
                $updateData['notas'] = trim($datos['notas']);
            }

            // Actualizar pedido
            $success = $this->pedidoModel->update($id, $updateData);

            if ($success) {
                return $this->sendJsonResponse(true, 'Pedido actualizado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al actualizar el pedido');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al actualizar pedido');
        }
    }

    public function eliminarPedido($id)
    {
        $ajaxValidation = $this->validateAjaxRequest();
        if ($ajaxValidation) return $ajaxValidation;

        try {
            // Verificar que el pedido existe
            $pedido = $this->pedidoModel->find($id);
            if (!$pedido) {
                return $this->sendJsonResponse(false, 'Pedido no encontrado');
            }

            // No permitir eliminar pedidos que ya han sido procesados/enviados
            if (in_array($pedido['estado'], ['procesando', 'enviado', 'entregado'])) {
                return $this->sendJsonResponse(false, 'No se puede eliminar un pedido que ya ha sido procesado o enviado');
            }

            // Eliminar items del pedido primero
            $this->itemPedidoModel->where('pedido_id', $id)->delete();

            // Eliminar información de pago si existe
            $this->pagoModel->where('pedido_id', $id)->delete();

            // Eliminar el pedido
            $success = $this->pedidoModel->delete($id);

            if ($success) {
                return $this->sendJsonResponse(true, 'Pedido eliminado exitosamente');
            } else {
                return $this->sendJsonResponse(false, 'Error al eliminar el pedido');
            }
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error al eliminar pedido');
        }
    }
}
