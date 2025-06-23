<?php helper('text'); ?>
<?= $this->include('templates/header') ?>

<!-- Gestionar Pedido -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --dorado: #D4A762;
        --beige: #E6D5C3;
        --crema: #F5F0E6;
    }

    .admin-container {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
    }

    .page-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .admin-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 2rem;
    }

    .btn-admin-primary {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-admin-primary:hover {
        background: linear-gradient(135deg, var(--cafe-medio), var(--dorado));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }

    .breadcrumb-item a {
        color: var(--cafe-medio);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--dorado);
    }

    .form-label {
        color: var(--cafe-oscuro);
        font-weight: 600;
    }

    .info-box {
        background: var(--crema);
        border-left: 4px solid var(--dorado);
        padding: 1rem;
        border-radius: 0 8px 8px 0;
        margin-bottom: 2rem;
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/pedidos') ?>">Pedidos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestionar</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-cogs me-2"></i>Gestionar Pedido
                    </h1>
                    <p class="text-muted mb-0">Gestiona el estado del pedido: <strong>#<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?></strong></p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Pedidos
                    </a>
                </div>
            </div>
        </div>

        <!-- Información de seguridad -->
        <div class="info-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-2"><i class="fas fa-shield-alt me-2"></i>Gestión Segura de Pedidos</h6>
                    <p class="mb-0 small">Por seguridad, solo puedes cambiar el estado del pedido y agregar notas administrativas. Los datos del cliente y productos no son editables.</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-info">Fecha: <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></span>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div> <!-- Información del pedido (solo lectura) -->
        <div class="row">
            <div class="col-md-8">
                <div class="admin-card">
                    <h5 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-info-circle me-2"></i>Información del Cliente
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nombre del Cliente</label>
                            <p class="fw-bold"><?= esc(($pedido['nombre'] ?? '') . ' ' . ($pedido['apellido'] ?? '')) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Email del Cliente</label>
                            <p class="fw-bold"><?= esc($pedido['email'] ?? 'No disponible') ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Número de Pedido</label>
                            <p class="fw-bold"><?= esc($pedido['numero_pedido'] ?? '#' . str_pad($pedido['id'], 6, '0', STR_PAD_LEFT)) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Fecha del Pedido</label>
                            <p class="fw-bold"><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <?php if (!empty($pedido['metodo_pago_nombre'])): ?>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Método de Pago</label>
                                <p class="fw-bold"><?= esc($pedido['metodo_pago_nombre']) ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Total del Pedido</label>
                            <p class="fw-bold text-success fs-5">$<?= number_format($pedido['total'], 2) ?></p>
                        </div>
                    </div>

                    <?php if (!empty($pedido['direccion_envio'])): ?>
                        <div class="mb-3">
                            <label class="form-label text-muted">Dirección de Envío</label>
                            <p class="fw-bold"><?= esc($pedido['direccion_envio']) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($pedido['notas'])): ?>
                        <div class="mb-3">
                            <label class="form-label text-muted">Notas del Cliente</label>
                            <p class="fw-bold"><?= esc($pedido['notas']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Productos del pedido -->
                <div class="admin-card">
                    <h5 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-shopping-bag me-2"></i>Productos del Pedido
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Debug temporal -->
                                <?php if (ENVIRONMENT === 'development'): ?>
                                    <!-- Debug: <?= print_r($pedido, true) ?> -->
                                <?php endif; ?>

                                <?php if (!empty($pedido['items'])): ?>
                                    <?php foreach ($pedido['items'] as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($item['imagen_producto'])): ?>
                                                        <img src="<?= base_url($item['imagen_producto']) ?>"
                                                            alt="<?= esc($item['nombre_producto']) ?>"
                                                            class="me-3 rounded"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <div> <strong><?= esc($item['nombre_producto']) ?></strong>
                                                        <?php if (!empty($item['descripcion'])): ?>
                                                            <br><small class="text-muted"><?= substr(esc($item['descripcion']), 0, 50) . (strlen($item['descripcion']) > 50 ? '...' : '') ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary"><?= $item['cantidad'] ?></span></td>
                                            <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                                            <td><strong>$<?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No hay productos en este pedido</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3">Total:</th>
                                    <th class="text-success">$<?= number_format($pedido['total'], 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div> <!-- Panel de gestión simplificado -->
            <div class="col-md-4">
                <div class="admin-card">
                    <h5 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-cogs me-2"></i>Gestión del Pedido
                    </h5>

                    <form id="gestionarPedidoForm">
                        <input type="hidden" id="pedido_id" name="pedido_id" value="<?= esc($pedido['id']) ?>">

                        <!-- Estado actual -->
                        <div class="mb-4">
                            <label class="form-label">Estado Actual</label>
                            <div class="p-3 rounded border text-center">
                                <?php
                                $estados_badges = [
                                    'pendiente' => '<span class="badge bg-warning fs-6">Pendiente</span>',
                                    'procesando' => '<span class="badge bg-info fs-6">Procesando</span>',
                                    'enviado' => '<span class="badge bg-primary fs-6">Enviado</span>',
                                    'completado' => '<span class="badge bg-success fs-6">Completado</span>',
                                    'entregado' => '<span class="badge bg-success fs-6">Entregado</span>',
                                    'cancelado' => '<span class="badge bg-danger fs-6">Cancelado</span>'
                                ];
                                echo $estados_badges[$pedido['estado']] ?? '<span class="badge bg-secondary fs-6">Sin estado</span>';
                                ?>
                            </div>
                        </div>

                        <!-- Cambiar estado -->
                        <div class="mb-3">
                            <label for="nuevo_estado" class="form-label">Cambiar Estado *</label>
                            <select class="form-select" id="nuevo_estado" name="nuevo_estado" required>
                                <option value="">Seleccionar nuevo estado...</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="procesando">Procesando</option>
                                <option value="enviado">Enviado</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <!-- Notas -->
                        <div class="mb-4">
                            <label for="notas" class="form-label">Notas del Pedido</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3"
                                placeholder="Agregar notas sobre el pedido..."><?= esc($pedido['notas'] ?? '') ?></textarea>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-admin-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Pedido
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Resumen del pedido -->
                <div class="admin-card">
                    <h6 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-info me-2"></i>Resumen del Pedido
                    </h6>

                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID del Pedido:</span>
                            <strong>#<?= $pedido['id'] ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Estado:</span>
                            <strong><?= ucfirst($pedido['estado']) ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <strong>$<?= number_format($pedido['subtotal'] ?? $pedido['total'], 2) ?></strong>
                        </div>
                        <?php if (isset($pedido['envio']) && $pedido['envio'] > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Envío:</span>
                                <strong>$<?= number_format($pedido['envio'], 2) ?></strong>
                            </div>
                        <?php endif; ?>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total:</span>
                            <strong class="text-success">$<?= number_format($pedido['total'], 2) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de navegación -->
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Pedidos
            </a>
            <a href="<?= base_url('admin/pedidos/ver/' . $pedido['id']) ?>" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>Ver Detalles Completos
            </a>
        </div>
    </div>
</div>

<script>
    // Manejar envío del formulario de gestión
    document.getElementById('gestionarPedidoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        const nuevoEstado = document.getElementById('nuevo_estado').value;

        if (!nuevoEstado) {
            showAlert('error', 'Debes seleccionar un estado');
            return;
        }

        // Confirmación
        if (!confirm(`¿Estás seguro de cambiar el estado a "${nuevoEstado}"?`)) {
            return;
        }

        // Mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';

        const pedidoId = document.getElementById('pedido_id').value;

        // Preparar datos para envío
        const updateData = {
            estado: nuevoEstado,
            notas: formData.get('notas')
        };

        fetch(`<?= base_url('admin/api/pedido') ?>/${pedidoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(updateData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Pedido actualizado exitosamente');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al actualizar pedido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al actualizar pedido: ' + error.message);
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
    });

    // Mostrar alertas
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertClass = type === 'success' ? 'alert-success' : (type === 'info' ? 'alert-info' : 'alert-danger');
        const icon = type === 'success' ? 'fa-check-circle' : (type === 'info' ? 'fa-info-circle' : 'fa-exclamation-triangle');

        const alertHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        alertContainer.innerHTML = alertHTML;

        // Auto-dismiss después de 5 segundos
        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
</script>

<?= $this->include('templates/footer') ?>