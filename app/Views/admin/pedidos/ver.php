<?= $this->include('templates/header') ?>

<!-- Ver Pedido -->
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

    .info-item {
        border-bottom: 1px solid #f1f3f4;
        padding: 12px 0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .status-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .status-timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #dee2e6;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #dee2e6;
    }

    .timeline-item.active::before {
        background: var(--dorado);
        box-shadow: 0 0 0 2px var(--dorado);
    }

    .product-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .total-section {
        background: linear-gradient(45deg, var(--crema), var(--beige));
        border-radius: 10px;
        padding: 20px;
        border: 1px solid var(--dorado);
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/pedidos') ?>">Pedidos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver Pedido</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-eye me-2"></i>Detalles del Pedido
                    </h1>
                    <p class="text-muted mb-0">Información completa del pedido: <strong>#<?= $pedido['id'] ?? 'N/A' ?></strong></p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <!-- <a href="<?= base_url('admin/pedidos/editar/' . ($pedido['id'] ?? '')) ?>" class="btn btn-admin-primary">
                            <i class="fas fa-edit me-2"></i>Editar Pedido
                        </a> -->
                        <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <div class="row">
            <!-- Información del pedido -->
            <div class="col-md-8"> <!-- Información del cliente -->
                <div class="admin-card">
                    <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-user me-2"></i>Información del Cliente
                    </h5>
                    <div class="info-item">
                        <div class="row">
                            <div class="col-sm-3"><strong>Nombre:</strong></div>
                            <div class="col-sm-9"><?= esc(($pedido['nombre'] ?? '') . ' ' . ($pedido['apellido'] ?? '')) ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="row">
                            <div class="col-sm-3"><strong>Email:</strong></div>
                            <div class="col-sm-9"><?= esc($pedido['email'] ?? 'No especificado') ?></div>
                        </div>
                    </div>
                    <?php if (!empty($pedido['telefono'])): ?>
                        <div class="info-item">
                            <div class="row">
                                <div class="col-sm-3"><strong>Teléfono:</strong></div>
                                <div class="col-sm-9"><?= esc($pedido['telefono']) ?></div>
                            </div>
                        </div>
                    <?php endif; ?> <?php if (!empty($pedido['direccion_envio']) || !empty($pedido['direccion'])): ?>
                        <div class="info-item">
                            <div class="row">
                                <div class="col-sm-3"><strong>Dirección:</strong></div>
                                <div class="col-sm-9"><?= esc($pedido['direccion_envio'] ?? $pedido['direccion'] ?? 'No especificada') ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Productos del pedido -->
                <div class="admin-card">
                    <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-shopping-cart me-2"></i>Productos del Pedido
                    </h5>
                    <div id="productos-container">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin me-2"></i>Cargando productos...
                        </div>
                    </div>
                </div>
            </div> <!-- Resumen y estado -->
            <div class="col-md-4">
                <!-- Resumen del pedido -->
                <div class="admin-card">
                    <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-receipt me-2"></i>Resumen del Pedido
                    </h5>
                    <div class="info-item">
                        <div class="d-flex justify-content-between">
                            <span><strong>ID del Pedido:</strong></span>
                            <span>#<?= esc($pedido['id'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="d-flex justify-content-between">
                            <span><strong>Número:</strong></span>
                            <span><?= esc($pedido['numero_pedido'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="d-flex justify-content-between">
                            <span><strong>Fecha:</strong></span>
                            <span><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'] ?? 'now')) ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="d-flex justify-content-between">
                            <span><strong>Estado:</strong></span>
                            <span><?= ucfirst($pedido['estado'] ?? 'pendiente') ?></span>
                        </div>
                    </div>
                    <div class="total-section mt-3">
                        <?php if (isset($pedido['subtotal']) && $pedido['subtotal'] > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>$<?= number_format($pedido['subtotal'], 2) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($pedido['envio']) && $pedido['envio'] > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Envío:</span>
                                <span>$<?= number_format($pedido['envio'], 2) ?></span>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>$<?= number_format($pedido['total'] ?? 0, 2) ?></strong>
                        </div>
                    </div>
                </div>
                <i class="fas fa-clock me-2"></i>Estado del Pedido
            </div>
        </div>
    </div>
</div>

<script>
    // Cargar productos del pedido
    function loadProductosPedido() {
        const pedidoId = <?= $pedido['id'] ?? 0 ?>;
        if (!pedidoId) {
            document.getElementById('productos-container').innerHTML = '<p class="text-center text-muted">No se pudo cargar la información de productos</p>';
            return;
        }

        fetch(`<?= base_url('admin/api/pedido') ?>/${pedidoId}/productos`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json()).then(data => {
                const container = document.getElementById('productos-container');
                if (data.success && data.data) {
                    container.innerHTML = '';
                    data.data.forEach(item => {
                        const productItem = `
                        <div class="product-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    ${item.imagen_producto ? 
                                        `<img src="<?= base_url("public/uploads/productos/") ?>${item.imagen_producto}" alt="${item.nombre_producto}" class="product-image">` :
                                        '<div class="product-image bg-light d-flex align-items-center justify-content-center"><i class="fas fa-box text-muted"></i></div>'
                                    }
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-1">${item.nombre_producto}</h6>
                                    <small class="text-muted">${item.descripcion || 'Sin descripción'}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-secondary">x${item.cantidad}</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong>$${parseFloat(item.precio_unitario || 0).toFixed(2)}</strong>
                                    <br><small class="text-muted">Total: $${(parseFloat(item.precio_unitario || 0) * parseInt(item.cantidad || 0)).toFixed(2)}</small>
                                </div>
                            </div>
                        </div>
                    `;
                        container.innerHTML += productItem;
                    });
                } else {
                    container.innerHTML = '<p class="text-center text-muted">No hay productos en este pedido</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('productos-container').innerHTML = '<p class="text-center text-danger">Error al cargar los productos del pedido</p>';
            });
    }

    // Cargar datos al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        loadProductosPedido();
    });
</script>

<?= $this->include('templates/footer') ?>