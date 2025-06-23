<?php

namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ItemCarritoModel;
use App\Models\PedidoModel;
use App\Models\ItemPedidoModel;
use App\Models\PagoModel;
use App\Models\MetodoPagoModel;
use App\Models\ProductoModel;

class Checkout extends BaseController
{
    protected $carritoModel;
    protected $itemCarritoModel;
    protected $pedidoModel;
    protected $itemPedidoModel;
    protected $pagoModel;
    protected $metodoPagoModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->itemCarritoModel = new ItemCarritoModel();
        $this->pedidoModel = new PedidoModel();
        $this->itemPedidoModel = new ItemPedidoModel();
        $this->pagoModel = new PagoModel();
        $this->metodoPagoModel = new MetodoPagoModel();
        $this->productoModel = new ProductoModel();
    }    // Mostrar resumen del carrito antes del checkout
    public function index()
    {
        // Verificar que el usuario esté logueado
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para proceder con la compra');
        }

        $usuario_id = session()->get('id');

        // Obtener carrito completo
        $carritoCompleto = $this->carritoModel->getCarritoCompleto($usuario_id);

        if (!$carritoCompleto || empty($carritoCompleto['items'])) {
            return redirect()->to('/carrito')->with('error', 'Tu carrito está vacío');
        }

        // Verificar stock de productos
        $errores_stock = $this->verificarStock($carritoCompleto['items']);
        if (!empty($errores_stock)) {
            return redirect()->to('/carrito')->with('error', 'Algunos productos no tienen stock suficiente: ' . implode(', ', $errores_stock));
        }        // Obtener métodos de pago activos (solo para referencia visual)
        $metodos_pago = [
            ['id' => null, 'nombre' => 'Procesamiento directo', 'descripcion' => 'Pedido procesado directamente', 'activo' => 1]
        ]; // Calcular totales
        $subtotal = $carritoCompleto['total_precio'];
        $total = $subtotal; // Sin costo de envío

        $data = [
            'title' => 'Finalizar Compra - Tienda de Café',
            'carrito' => $carritoCompleto,
            'metodos_pago' => $metodos_pago,
            'subtotal' => $subtotal,
            'total' => $total,
            'usuario' => [
                'id' => session()->get('id'),
                'nombre' => session()->get('nombre'),
                'apellido' => session()->get('apellido'),
                'email' => session()->get('email')
            ]
        ];

        return view('checkout/index', $data);
    }
    /**
     * Procesar pedido y marcarlo como completado (sin método de pago específico)
     */
    public function procesar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/checkout');
        }

        // Verificar que el usuario esté logueado
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión para proceder'
            ]);
        }

        $usuario_id = session()->get('id');
        try {
            // Obtener carrito
            $carritoCompleto = $this->carritoModel->getCarritoCompleto($usuario_id);

            if (!$carritoCompleto || empty($carritoCompleto['items'])) {
                throw new \Exception('El carrito está vacío');
            }

            // Verificar stock nuevamente
            $errores_stock = $this->verificarStock($carritoCompleto['items']);
            if (!empty($errores_stock)) {
                throw new \Exception('Stock insuficiente: ' . implode(', ', $errores_stock));
            }

            // Calcular totales
            $subtotal = $carritoCompleto['total_precio'];
            $total = $subtotal; // Sin costo de envío

            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transStart();

            // 1. Crear pedido (ESTADO: completado - sin método de pago específico)
            $numero_pedido = $this->pedidoModel->generarNumeroPedido();
            $pedido_data = [
                'numero_pedido' => $numero_pedido,
                'usuario_id' => $usuario_id,
                'fecha_pedido' => date('Y-m-d H:i:s'),
                'estado' => 'completado', // Marcado como completado
                'subtotal' => $subtotal,
                'envio' => 0,
                'total' => $total,
                'metodo_pago_id' => null, // Sin método de pago específico
                'direccion_envio' => '',
                'notas' => 'Pedido procesado directamente'
            ];

            $pedido_id = $this->pedidoModel->insert($pedido_data);

            if (!$pedido_id) {
                throw new \Exception('Error al crear el pedido');
            }            // 2. Crear items del pedido
            foreach ($carritoCompleto['items'] as $item) {
                $item_data = [
                    'pedido_id' => $pedido_id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'nombre_producto' => $item['producto_nombre']
                ];

                $this->itemPedidoModel->insert($item_data);

                // Actualizar stock del producto
                $this->actualizarStock($item['producto_id'], $item['cantidad']);
            }

            // 3. No crear registro de pago (sin método específico)
            // Los pedidos se procesan directamente sin asociar método de pago

            // 4. Limpiar carrito
            $this->carritoModel->limpiarCarrito($usuario_id);

            // Completar transacción
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Error en la transacción');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pedido procesado exitosamente',
                'pedido_id' => $pedido_id,
                'numero_pedido' => $numero_pedido,
                'estado' => 'completado'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    } // Mostrar factura generada
    public function factura($pedido_id)
    {
        // Verificar que el usuario esté logueado
        if (!session()->get('logged_in')) { // Corregido
            return redirect()->to('/login'); // Corregido
        }

        $usuario_id = session()->get('id');

        // Obtener pedido completo
        $pedido = $this->pedidoModel->getPedidoCompleto($pedido_id);

        if (!$pedido) {
            return redirect()->to('/')->with('error', 'Pedido no encontrado');
        }

        // Verificar que el pedido pertenezca al usuario (excepto si es admin)
        if ($pedido['usuario_id'] != $usuario_id && session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes acceso a este pedido');
        }

        // Obtener información del pago
        $pago = $this->pagoModel->getPagoPorPedido($pedido_id);

        $data = [
            'title' => 'Factura #' . $pedido['numero_pedido'],
            'pedido' => $pedido,
            'pago' => $pago
        ];
        return view('checkout/factura', $data);
    }

    // Ver historial de pedidos del usuario
    public function misPedidos()
    {
        $usuario_id = session('id');
        if (!$usuario_id) {
            return redirect()->to('/login');
        }

        $pedidos = $this->pedidoModel->getPedidosUsuario($usuario_id);

        $data = [
            'titulo' => 'Mis Pedidos',
            'pedidos' => $pedidos
        ];

        return view('checkout/mis_pedidos', $data);
    }

    // Ver detalle de un pedido específico
    public function verPedido($pedido_id)
    {
        $usuario_id = session('id'); // Corregido

        if (!$usuario_id) {
            return redirect()->to('/login');
        }

        $pedido = $this->pedidoModel->find($pedido_id);

        // Verificar que el pedido pertenece al usuario actual
        if (!$pedido || $pedido['usuario_id'] != $usuario_id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pedido no encontrado');
        }

        $items = $this->itemPedidoModel->getItemsPorPedido($pedido_id);
        $pago = $this->pagoModel->getPagoPorPedido($pedido_id);

        // DEBUG: Verificar estructura de datos
        if (ENVIRONMENT === 'development') {
            log_message('debug', 'Pedido data: ' . json_encode($pedido));
            log_message('debug', 'Items data: ' . json_encode($items));
            log_message('debug', 'Pago data: ' . json_encode($pago));
        }

        // Obtener información completa del usuario para los datos de envío
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->find($usuario_id);

        // Agregar información del usuario al pedido para la vista
        $pedido['nombre_completo'] = ($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '');
        $pedido['direccion'] = $usuario['direccion'] ?? 'No especificada';
        $pedido['ciudad'] = $usuario['ciudad'] ?? 'No especificada';
        $pedido['codigo_postal'] = $usuario['codigo_postal'] ?? 'No especificado';
        $pedido['telefono'] = $usuario['telefono'] ?? 'No especificado';
        $pedido['email_usuario'] = $usuario['email'] ?? '';

        $data = [
            'titulo' => 'Detalle del Pedido #' . $pedido['numero_pedido'],
            'pedido' => $pedido,
            'items' => $items,
            'pago' => $pago
        ];

        return view('templates/header')
            . view('checkout/ver_pedido', $data)
            . view('templates/footer');
    } // Inicializar métodos de pago básicos (solo para desarrollo/testing)
    public function initMetodosPago()
    {
        try {
            $this->crearMetodosPagoBasicos();

            // Verificar que se crearon correctamente
            $metodos = $this->metodoPagoModel->getMetodosActivos();

            $response = [
                'success' => true,
                'message' => 'Métodos de pago inicializados correctamente',
                'metodos_creados' => count($metodos),
                'metodos' => $metodos
            ];

            // Si es AJAX, devolver JSON
            if ($this->request->isAJAX()) {
                return $this->response->setJSON($response);
            }

            // Si no es AJAX, mostrar una página simple
            echo "<h2>✅ Métodos de Pago Inicializados</h2>";
            echo "<p>Se han creado " . count($metodos) . " métodos de pago:</p>";
            echo "<ul>";
            foreach ($metodos as $metodo) {
                echo "<li><strong>" . esc($metodo['nombre']) . "</strong>: " . esc($metodo['descripcion']) . "</li>";
            }
            echo "</ul>";
            echo "<p><a href='" . base_url('checkout') . "'>Ir al Checkout</a></p>";
            echo "<p><a href='" . base_url() . "'>Volver al Inicio</a></p>";
        } catch (\Exception $e) {
            $error = [
                'success' => false,
                'message' => 'Error al inicializar métodos de pago: ' . $e->getMessage()
            ];

            if ($this->request->isAJAX()) {
                return $this->response->setJSON($error);
            }

            echo "<h2>❌ Error al Inicializar</h2>";
            echo "<p>" . esc($e->getMessage()) . "</p>";
            echo "<p><a href='" . base_url() . "'>Volver al Inicio</a></p>";
        }
    }

    // Método temporal para debug - verificar datos de sesión
    public function debugSession()
    {
        if (ENVIRONMENT !== 'development') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $sessionData = session()->get();

        echo "<h2>Datos de Sesión:</h2>";
        echo "<pre>";
        print_r($sessionData);
        echo "</pre>";

        $usuario_id = session()->get('id');
        echo "<h3>Usuario ID: " . ($usuario_id ?? 'NULL') . "</h3>";

        if ($usuario_id) {
            $carritoCompleto = $this->carritoModel->getCarritoCompleto($usuario_id);
            echo "<h3>Carrito Completo:</h3>";
            echo "<pre>";
            print_r($carritoCompleto);
            echo "</pre>";
        }
    }

    // Verificar stock de productos
    private function verificarStock($items)
    {
        $errores = [];

        foreach ($items as $item) {
            if ($item['cantidad'] > $item['stock_disponible']) {
                $errores[] = $item['producto_nombre'] . ' (disponible: ' . $item['stock_disponible'] . ')';
            }
        }

        return $errores;
    }

    // Actualizar stock del producto
    private function actualizarStock($producto_id, $cantidad_vendida)
    {
        $producto = $this->productoModel->find($producto_id);
        if ($producto) {
            $nuevo_stock = max(0, $producto['stock'] - $cantidad_vendida);
            $this->productoModel->update($producto_id, ['stock' => $nuevo_stock]);
        }
    }

    // Crear métodos de pago básicos automáticamente
    private function crearMetodosPagoBasicos()
    {
        $metodos = [
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo contra entrega', 'activo' => 1],
            ['nombre' => 'Tarjeta de Crédito', 'descripcion' => 'Visa, MasterCard, American Express', 'activo' => 1],
            ['nombre' => 'Tarjeta de Débito', 'descripcion' => 'Débito inmediato', 'activo' => 1],
            ['nombre' => 'Transferencia Bancaria', 'descripcion' => 'Transferencia bancaria', 'activo' => 1],
            ['nombre' => 'MercadoPago', 'descripcion' => 'Pago con MercadoPago', 'activo' => 1]
        ];

        foreach ($metodos as $metodo) {
            $existe = $this->metodoPagoModel->where('nombre', $metodo['nombre'])->first();
            if (!$existe) {
                $this->metodoPagoModel->insert($metodo);
            }
        }
    }
}
