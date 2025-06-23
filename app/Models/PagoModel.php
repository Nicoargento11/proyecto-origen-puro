<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'pedido_id',
        'monto',
        'metodo_pago_id',
        'transaccion_id',
        'estado',
        'fecha_pago',
        'datos_adicionales'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'pedido_id' => 'required|integer',
        'monto' => 'required|decimal',
        'metodo_pago_id' => 'required|integer',
        'estado' => 'required|in_list[pendiente,completado,fallido,reembolsado]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Crear pago automático para pedido
    public function crearPagoAutomatico($pedido_id, $monto, $metodo_pago_id)
    {
        $transaccion_id = 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999);

        $pago_data = [
            'pedido_id' => $pedido_id,
            'monto' => $monto,
            'metodo_pago_id' => $metodo_pago_id,
            'transaccion_id' => $transaccion_id,
            'estado' => 'completado', // Simulamos que se pagó automáticamente
            'fecha_pago' => date('Y-m-d H:i:s'),
            'datos_adicionales' => json_encode([
                'tipo' => 'simulado',
                'procesado_en' => 'sistema_interno'
            ])
        ];

        return $this->insert($pago_data);
    }

    // Crear pago pendiente (para cuando no se procesa pago inmediato)
    public function crearPagoPendiente($pedido_id, $monto, $metodo_pago_id, $notas = '')
    {
        $pago_data = [
            'pedido_id' => $pedido_id,
            'monto' => $monto,
            'metodo_pago_id' => $metodo_pago_id,
            'transaccion_id' => null, // No hay transacción aún
            'estado' => 'pendiente',
            'fecha_pago' => null, // Se asignará cuando se procese
            'datos_adicionales' => json_encode([
                'tipo' => 'pendiente',
                'creado_en' => date('Y-m-d H:i:s'),
                'nota' => $notas ?: 'Pago pendiente de procesamiento'
            ])
        ];

        return $this->insert($pago_data);
    }

    // Procesar pago pendiente (para cuando se integre sistema de pagos)
    public function procesarPagoPendiente($pago_id, $transaccion_id, $estado = 'completado', $datos_adicionales = [])
    {
        $datos_actuales = $this->find($pago_id)['datos_adicionales'] ?? '{}';
        $datos = json_decode($datos_actuales, true);

        // Agregar información del procesamiento
        $datos['procesado'] = [
            'fecha' => date('Y-m-d H:i:s'),
            'transaccion_id' => $transaccion_id,
            'estado_anterior' => 'pendiente'
        ];

        // Agregar datos adicionales del procesamiento
        if (!empty($datos_adicionales)) {
            $datos['procesado'] = array_merge($datos['procesado'], $datos_adicionales);
        }

        return $this->update($pago_id, [
            'transaccion_id' => $transaccion_id,
            'estado' => $estado,
            'fecha_pago' => date('Y-m-d H:i:s'),
            'datos_adicionales' => json_encode($datos)
        ]);
    }

    // Obtener pagos con información del pedido
    public function getPagosConPedidos($limit = 50)
    {
        return $this->select('pagos.*, pedidos.numero_pedido, usuarios.nombre, usuarios.apellido, metodos_pago.nombre as metodo_pago_nombre')
            ->join('pedidos', 'pedidos.id = pagos.pedido_id')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
            ->join('metodos_pago', 'metodos_pago.id = pagos.metodo_pago_id')
            ->orderBy('pagos.fecha_pago', 'DESC')
            ->limit($limit)
            ->findAll();
    }    // Obtener pago por pedido
    public function getPagoPorPedido($pedido_id)
    {
        return $this->select('pagos.*, metodos_pago.nombre as metodo_nombre')
            ->join('metodos_pago', 'metodos_pago.id = pagos.metodo_pago_id')
            ->where('pagos.pedido_id', $pedido_id)
            ->first();
    }

    // Marcar como reembolsado
    public function marcarReembolsado($id, $notas = '')
    {
        $datos_actuales = $this->find($id)['datos_adicionales'] ?? '{}';
        $datos = json_decode($datos_actuales, true);
        $datos['reembolso'] = [
            'fecha' => date('Y-m-d H:i:s'),
            'notas' => $notas
        ];

        return $this->update($id, [
            'estado' => 'reembolsado',
            'datos_adicionales' => json_encode($datos)
        ]);
    }

    // Estadísticas de pagos
    public function getEstadisticasPagos()
    {
        return [
            'total_pagos' => $this->countAll(),
            'pagos_completados' => $this->where('estado', 'completado')->countAllResults(false),
            'pagos_fallidos' => $this->where('estado', 'fallido')->countAllResults(false),
            'monto_total' => $this->selectSum('monto')->where('estado', 'completado')->first()['monto'] ?? 0,
            'monto_mes' => $this->selectSum('monto')
                ->where('estado', 'completado')
                ->where('MONTH(fecha_pago)', date('m'))
                ->where('YEAR(fecha_pago)', date('Y'))
                ->first()['monto'] ?? 0
        ];
    }
}
