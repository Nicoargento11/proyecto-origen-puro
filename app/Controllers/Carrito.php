<?php

namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ItemCarritoModel;
use App\Models\ProductoModel;

class Carrito extends BaseController
{
    protected $carritoModel;
    protected $itemCarritoModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->itemCarritoModel = new ItemCarritoModel();
        $this->productoModel = new ProductoModel();

        helper(['form']);
    }

    // Ver carrito completo
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para ver tu carrito');
        }

        $usuarioId = session()->get('id');
        $carritoCompleto = $this->carritoModel->getCarritoCompleto($usuarioId);

        $data = [
            'title' => 'Mi Carrito | Origen Puro',
            'carrito' => $carritoCompleto
        ];

        return view('templates/header', $data)
            . view('carrito/index', $data)
            . view('templates/footer');
    }

    // Agregar producto al carrito (AJAX)
    public function agregar()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión para agregar productos al carrito',
                'redirect' => base_url('login')
            ]);
        }

        $productoId = $this->request->getPost('producto_id');
        $cantidad = (int) $this->request->getPost('cantidad', FILTER_SANITIZE_NUMBER_INT);

        if (!$productoId || $cantidad <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
        }

        try {
            // Verificar que el producto existe y está activo
            $producto = $this->productoModel->find($productoId);
            if (!$producto || !$producto['activo']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ]);
            }

            // Verificar stock
            if (!$this->productoModel->tieneStock($productoId, $cantidad)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Stock insuficiente. Disponible: ' . $producto['stock'] . ' kg'
                ]);
            }

            $usuarioId = session()->get('id');
            $carrito = $this->carritoModel->obtenerCarritoUsuario($usuarioId);

            // Agregar al carrito
            $resultado = $this->itemCarritoModel->agregarProducto(
                $carrito['id'],
                $productoId,
                $cantidad,
                $producto['precio']
            );

            if ($resultado) {
                // Obtener conteo actualizado
                $totalItems = $this->carritoModel->contarItems($usuarioId);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Producto agregado al carrito',
                    'total_items' => $totalItems
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al agregar el producto'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    // Actualizar cantidad de un item
    public function actualizar()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado']);
        }

        $itemId = $this->request->getPost('item_id');
        $cantidad = (int) $this->request->getPost('cantidad');
        $usuarioId = session()->get('id');

        // Verificar que el item pertenece al usuario
        if (!$this->itemCarritoModel->perteneceAUsuario($itemId, $usuarioId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item no encontrado']);
        }

        // Obtener información del item y producto
        $item = $this->itemCarritoModel->getItemConProducto($itemId);
        if (!$item) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item no encontrado']);
        }

        // Verificar stock
        if ($cantidad > $item['stock_disponible']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stock insuficiente. Disponible: ' . $item['stock_disponible'] . ' kg'
            ]);
        }

        $resultado = $this->itemCarritoModel->actualizarCantidad($itemId, $cantidad);

        if ($resultado) {
            $carritoCompleto = $this->carritoModel->getCarritoCompleto($usuarioId);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Carrito actualizado',
                'carrito' => $carritoCompleto
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
        }
    }

    // Eliminar item del carrito
    public function eliminar($itemId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = session()->get('id');

        // Verificar que el item pertenece al usuario
        if (!$this->itemCarritoModel->perteneceAUsuario($itemId, $usuarioId)) {
            return redirect()->to('/carrito')->with('error', 'Item no encontrado');
        }

        $resultado = $this->itemCarritoModel->eliminarItem($itemId);

        if ($resultado) {
            return redirect()->to('/carrito')->with('success', 'Producto eliminado del carrito');
        } else {
            return redirect()->to('/carrito')->with('error', 'Error al eliminar el producto');
        }
    }

    // Limpiar carrito completo
    public function limpiar()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = session()->get('id');
        $resultado = $this->carritoModel->limpiarCarrito($usuarioId);

        if ($resultado) {
            return redirect()->to('/carrito')->with('success', 'Carrito limpiado');
        } else {
            return redirect()->to('/carrito')->with('error', 'Error al limpiar el carrito');
        }
    }    // Obtener conteo de items (AJAX)
    public function conteo()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => true,
                'cantidad' => 0,
                'count' => 0 // Para compatibilidad
            ]);
        }

        $usuarioId = session()->get('id');
        $count = $this->carritoModel->contarItems($usuarioId);

        return $this->response->setJSON([
            'success' => true,
            'cantidad' => $count,
            'count' => $count // Para compatibilidad
        ]);
    }
}
