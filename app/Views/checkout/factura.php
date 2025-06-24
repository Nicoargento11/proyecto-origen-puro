<?= $this->include('templates/header') ?>

<!-- Factura -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --dorado: #D4A762;
        --beige: #E6D5C3;
        --crema: #F5F0E6;
    }

    .factura-container {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
    }

    .factura-card {
        background: white;
        border-radius: 12px;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 2rem;
    }

    .factura-header {
        border-bottom: 3px solid var(--dorado);
        padding-bottom: 2rem;
        margin-bottom: 2rem;
    }

    .factura-numero {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        color: white;
        padding: 1rem 2rem;
        border-radius: 10px;
        display: inline-block;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .info-cliente {
        background: var(--crema);
        border-left: 4px solid var(--dorado);
        padding: 1.5rem;
        border-radius: 0 8px 8px 0;
        margin-bottom: 2rem;
    }

    .tabla-items {
        margin: 2rem 0;
    }

    .tabla-items th {
        background-color: var(--beige);
        color: var(--cafe-oscuro);
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .tabla-items td {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .producto-imagen-factura {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
    }

    .totales-factura {
        background: linear-gradient(45deg, var(--crema), var(--beige));
        border-radius: 10px;
        padding: 2rem;
        border: 2px solid var(--dorado);
    }

    .estado-badge {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .btn-factura {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
    }

    .btn-factura:hover {
        background: linear-gradient(135deg, var(--cafe-medio), var(--dorado));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .success-icon {
        color: var(--dorado);
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .factura-card,
        .factura-card * {
            visibility: visible;
        }

        .factura-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<div class="factura-container">
    <div class="container">
        <!-- Mensaje de éxito -->
        <div class="text-center mb-4 no-print">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 style="color: var(--cafe-oscuro);">¡Compra Exitosa!</h2>
            <p class="text-muted">Tu pedido ha sido procesado correctamente</p>
        </div>

        <!-- Factura -->
        <div class="factura-card">
            <!-- Header de la factura -->
            <div class="factura-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 style="color: var(--cafe-oscuro); margin: 0;">
                            <i class="fas fa-coffee me-2"></i>Tienda de Café
                        </h1>
                        <p class="text-muted mb-0">Tu tienda de café de confianza</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="factura-numero">
                            FACTURA #<?= esc($pedido['numero_pedido']) ?>
                        </div>
                        <p class="mt-2 mb-0">
                            <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Información del cliente y estado -->
            <div class="row">
                <div class="col-md-8">
                    <div class="info-cliente">
                        <h5 style="color: var(--cafe-oscuro); margin-bottom: 1rem;">
                            <i class="fas fa-user me-2"></i>Datos del Cliente
                        </h5>
                        <p class="mb-2">
                            <strong><?= esc($pedido['nombre'] . ' ' . $pedido['apellido']) ?></strong>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-envelope me-2"></i><?= esc($pedido['email']) ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <h6>Estado del Pedido</h6>
                        <?php
                        $estado_clase = [
                            'pendiente' => 'bg-warning',
                            'procesando' => 'bg-info',
                            'enviado' => 'bg-primary',
                            'completado' => 'bg-success',
                            'cancelado' => 'bg-danger'
                        ][$pedido['estado']] ?? 'bg-secondary';

                        $estado_texto = [
                            'pendiente' => 'Pendiente',
                            'procesando' => 'Procesando',
                            'enviado' => 'Enviado',
                            'completado' => 'Completado',
                            'cancelado' => 'Cancelado'
                        ][$pedido['estado']] ?? 'Sin estado';
                        ?>
                        <span class="badge <?= $estado_clase ?> estado-badge">
                            <?= $estado_texto ?>
                        </span>

                        <?php if (!empty($pedido['metodo_pago_nombre'])): ?>
                            <p class="mt-3 mb-0">
                                <strong>Método de pago:</strong><br>
                                <?= esc($pedido['metodo_pago_nombre']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($pago): ?>
                            <p class="mt-2 mb-0">
                                <strong>ID de transacción:</strong><br>
                                <small class="text-muted"><?= esc($pago['transaccion_id']) ?></small>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Detalle de productos -->
            <div class="tabla-items">
                <h5 style="color: var(--cafe-oscuro); margin-bottom: 1rem;">
                    <i class="fas fa-list me-2"></i>Detalle del Pedido
                </h5>

                <div class="table-responsive">
                    <table class="table tabla-items">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedido['items'] as $item): ?>
                                <tr>
                                    <td> <?php if (!empty($item['imagen_producto'])): ?>
                                            <img src="<?= base_url($item['imagen_producto']) ?>"
                                                alt="<?= esc($item['nombre_producto']) ?>"
                                                class="producto-imagen-factura me-2">
                                        <?php else: ?>
                                            <div class="producto-imagen-factura bg-light d-inline-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-coffee text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= esc($item['nombre_producto']) ?></strong>
                                        <?php if (!empty($item['descripcion_corta'])): ?>
                                            <br><small class="text-muted"><?= esc($item['descripcion_corta']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= $item['cantidad'] ?></span>
                                    </td>
                                    <td class="text-end">
                                        $<?= number_format($item['precio_unitario'], 2) ?>
                                    </td>
                                    <td class="text-end">
                                        <strong>$<?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="row justify-content-end">
                <div class="col-md-6">
                    <div class="totales-factura">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>$<?= number_format($pedido['subtotal'], 2) ?></strong>
                        </div>
                        <hr style="border-color: var(--dorado);">
                        <div class="d-flex justify-content-between">
                            <span class="h5">TOTAL:</span>
                            <span class="h4" style="color: var(--cafe-oscuro);">
                                $<?= number_format($pedido['total'], 2) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notas del pedido -->
            <?php if (!empty($pedido['notas'])): ?>
                <div class="mt-4">
                    <h6 style="color: var(--cafe-oscuro);">
                        <i class="fas fa-sticky-note me-2"></i>Notas del Pedido
                    </h6>
                    <div class="alert alert-info">
                        <?= nl2br(esc($pedido['notas'])) ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Pie de factura -->
            <div class="text-center mt-4 pt-4" style="border-top: 1px solid #dee2e6;">
                <p class="text-muted mb-0">
                    <small>Gracias por tu compra. ¡Disfruta tu café!</small>
                </p>
            </div>
        </div>

        <!-- Acciones -->
        <div class="text-center no-print">
            <button onclick="window.print()" class="btn btn-factura">
                <i class="fas fa-print me-2"></i>Imprimir Factura
            </button>
            <a href="<?= base_url('mis-pedidos') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-history me-2"></i>Ver Mis Pedidos
            </a>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary">
                <i class="fas fa-home me-2"></i>Volver a la Tienda
            </a>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>