<div class="container-fluid pt-5 pb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-title">
                            <i class="fas fa-receipt me-2"></i>
                            <?= $titulo ?>
                        </h1>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            <a href="<?= base_url('mis-pedidos') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
                            </a>
                            <a href="<?= base_url('factura/' . $pedido['id']) ?>" class="btn btn-success">
                                <i class="fas fa-file-invoice me-2"></i>Ver Factura
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información del Pedido -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Pedido
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Número de Pedido</label>
                                <div class="h4">#<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Estado</label>
                                <div>
                                    <?php
                                    $badge_class = 'bg-secondary';
                                    switch (strtolower($pedido['estado'])) {
                                        case 'pendiente':
                                            $badge_class = 'bg-yellow';
                                            break;
                                        case 'procesando':
                                            $badge_class = 'bg-blue';
                                            break;
                                        case 'enviado':
                                            $badge_class = 'bg-cyan';
                                            break;
                                        case 'entregado':
                                            $badge_class = 'bg-green';
                                            break;
                                        case 'cancelado':
                                            $badge_class = 'bg-red';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?= $badge_class ?> fs-6"><?= ucfirst($pedido['estado']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Fecha del Pedido</label>
                        <div><?= date('d/m/Y H:i:s', strtotime($pedido['fecha_pedido'])) ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Total del Pedido</label>
                        <div class="h3 text-success">$<?= number_format($pedido['total'], 2) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Envío -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shipping-fast me-2"></i>
                        Información de Envío
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nombre Completo</label>
                        <div><?= esc($pedido['nombre_completo']) ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Dirección</label>
                        <div><?= esc($pedido['direccion']) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Ciudad</label>
                                <div><?= esc($pedido['ciudad']) ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Código Postal</label>
                                <div><?= esc($pedido['codigo_postal']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Teléfono</label>
                        <div><?= esc($pedido['telefono']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Pago -->
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card me-2"></i>
                        Información de Pago
                    </h3>
                </div>
                <div class="card-body">
                    <?php if ($pago): ?>
                        <div class="mb-3">
                            <label class="form-label text-muted">Método de Pago</label>
                            <div><?= esc($pago['metodo_nombre']) ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Estado del Pago</label>
                            <div>
                                <?php
                                $badge_class = 'bg-secondary';
                                switch (strtolower($pago['estado'])) {
                                    case 'pendiente':
                                        $badge_class = 'bg-yellow';
                                        break;
                                    case 'completado':
                                        $badge_class = 'bg-green';
                                        break;
                                    case 'fallido':
                                        $badge_class = 'bg-red';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $badge_class ?>"><?= ucfirst($pago['estado']) ?></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Total Pagado</label>
                            <div class="h4 text-success">$<?= number_format($pago['monto'], 2) ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Referencia de Pago</label>
                            <div class="text-muted"><?= esc($pago['transaccion_id'] ?? 'No especificada') ?></div>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No se encontró información de pago
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos del Pedido -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Productos del Pedido
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter mb-0">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"> <?php if (!empty($item['imagen_producto'])): ?>
                                                    <img src="<?= base_url('uploads/' . $item['imagen_producto']) ?>"
                                                        alt="<?= esc($item['nombre']) ?>"
                                                        class="rounded me-3"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;"> <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-bold"><?= esc($item['nombre_producto']) ?></div>
                                                    <?php if (!empty($item['descripcion'])): ?>
                                                        <div class="text-muted small"><?= esc(substr($item['descripcion'], 0, 80)) ?>...</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $item['cantidad'] ?></span>
                                        </td>
                                        <td>
                                            $<?= number_format($item['precio_unitario'], 2) ?>
                                        </td>
                                        <td>
                                            <strong>$<?= number_format($item['precio_unitario'] * $item['cantidad'], 2) ?></strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total del Pedido:</th>
                                    <th class="text-success h4">$<?= number_format($pedido['total'], 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-header {
        background-color: var(--bs-gray-50);
        border-bottom: 1px solid var(--bs-border-color);
    }

    .badge.fs-6 {
        font-size: 0.875rem !important;
        padding: 0.375rem 0.75rem;
    }

    .btn-list {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .btn-list {
            flex-direction: column;
            width: 100%;
        }

        .page-header .row {
            flex-direction: column;
            gap: 1rem;
        }

        .table img {
            width: 40px !important;
            height: 40px !important;
        }
    }
</style>

<?= $this->include('templates/footer') ?>