<?= $this->include('templates/header') ?>

<div class="container-fluid container-pedidos">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-shopping-bag me-2"></i>
                    <?= $titulo ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (empty($pedidos)): ?>
                        <div class="empty">
                            <div class="empty-img">
                                <i class="fas fa-shopping-bag text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <p class="empty-title">No tienes pedidos realizados</p>
                            <p class="empty-subtitle text-muted">
                                Cuando realices tu primer pedido, aparecerá aquí.
                            </p>
                            <div class="empty-action">
                                <a href="<?= base_url('productos') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Ir de compras
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Método de Pago</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td>
                                                <span class="text-muted">#<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?></span>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?>
                                            </td>
                                            <td>
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
                                                <span class="badge <?= $badge_class ?>"><?= ucfirst($pedido['estado']) ?></span>
                                            </td>
                                            <td>
                                                <strong>$<?= number_format($pedido['total'], 2) ?></strong>
                                            </td>
                                            <td>
                                                <?= $pedido['metodo_pago_nombre'] ?? 'N/A' ?>
                                            </td>
                                            <td>
                                                <div class="btn-list">
                                                    <a href="<?= base_url('pedido/' . $pedido['id']) ?>"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Ver Detalle
                                                    </a>
                                                    <a href="<?= base_url('factura/' . $pedido['id']) ?>"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-file-invoice me-1"></i>Factura
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container-pedidos {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
    }

    .empty {
        text-align: center;
    }

    .empty-img {
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-subtitle {
        margin-bottom: 2rem;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-list {
        display: flex;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .btn-list {
            flex-direction: column;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>