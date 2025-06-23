<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'numero_pedido',
        'usuario_id',
        'fecha_pedido',
        'estado',
        'subtotal',
        'envio',
        'total',
        'metodo_pago_id',
        'metodo_envio_id',
        'direccion_envio',
        'notas'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'numero_pedido' => 'required|max_length[20]',
        'usuario_id' => 'required|integer',
        'subtotal' => 'required|decimal',
        'envio' => 'required|decimal',
        'total' => 'required|decimal',
        'estado' => 'required|in_list[pendiente,procesando,enviado,completado,cancelado]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Generar número de pedido único
    public function generarNumeroPedido()
    {
        $anio = date('Y');
        $ultimoPedido = $this->selectMax('id')->first();
        $siguiente = ($ultimoPedido['id'] ?? 0) + 1;

        return 'PED-' . $anio . '-' . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
    }

    // Obtener pedidos con información del usuario
    public function getPedidosConUsuario($limit = 50)
    {
        return $this->select('pedidos.*, usuarios.nombre, usuarios.apellido, usuarios.email')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
            ->orderBy('pedidos.fecha_pedido', 'DESC')
            ->limit($limit)
            ->findAll();
    }    // Obtener todos los pedidos con información completa para administración
    public function getPedidosCompletos($limit = 100)
    {
        return $this->select('pedidos.*, usuarios.nombre, usuarios.apellido, usuarios.email, metodos_pago.nombre as metodo_pago_nombre, COALESCE(SUM(items_pedido.cantidad), 0) as total_productos')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
            ->join('metodos_pago', 'metodos_pago.id = pedidos.metodo_pago_id', 'left')
            ->join('items_pedido', 'items_pedido.pedido_id = pedidos.id', 'left')
            ->groupBy('pedidos.id')
            ->orderBy('pedidos.fecha_pedido', 'DESC')
            ->limit($limit)
            ->findAll();
    }    // Obtener pedido completo con detalles
    public function getPedidoCompleto($id)
    {
        $pedido = $this->select('pedidos.*, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.telefono, usuarios.direccion, metodos_pago.nombre as metodo_pago_nombre')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
            ->join('metodos_pago', 'metodos_pago.id = pedidos.metodo_pago_id', 'left')
            ->find($id);

        if ($pedido) {
            $itemPedidoModel = new ItemPedidoModel();
            $pedido['items'] = $itemPedidoModel->getItemsPorPedido($id);
        }

        return $pedido;
    }

    // Obtener pedidos por usuario
    public function getPedidosPorUsuario($usuario_id, $limit = 20)
    {
        return $this->where('usuario_id', $usuario_id)
            ->orderBy('fecha_pedido', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Obtener pedidos por usuario con información de método de pago
    public function getPedidosUsuario($usuario_id, $limit = 20)
    {
        return $this->select('pedidos.*, metodos_pago.nombre as metodo_pago_nombre')
            ->join('metodos_pago', 'metodos_pago.id = pedidos.metodo_pago_id', 'left')
            ->where('pedidos.usuario_id', $usuario_id)
            ->orderBy('pedidos.fecha_pedido', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Estadísticas para admin
    public function getEstadisticas()
    {
        return [
            'total_pedidos' => $this->countAll(),
            'pedidos_pendientes' => $this->where('estado', 'pendiente')->countAllResults(false),
            'pedidos_completados' => $this->where('estado', 'completado')->countAllResults(false),
            'ventas_mes' => $this->selectSum('total')
                ->where('MONTH(fecha_pedido)', date('m'))
                ->where('YEAR(fecha_pedido)', date('Y'))
                ->first()['total'] ?? 0
        ];
    }
}
