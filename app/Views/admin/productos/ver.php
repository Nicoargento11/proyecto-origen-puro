<?= $this->include('templates/header') ?>

<!-- Ver Producto -->
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

    .product-image {
        width: 100%;
        max-width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }

    .image-placeholder {
        width: 100%;
        max-width: 300px;
        height: 300px;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .info-item {
        border-bottom: 1px solid #f1f3f4;
        padding: 12px 0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .status-badge {
        font-size: 0.9em;
    }

    .price-info {
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
                <li class="breadcrumb-item"><a href="<?= base_url('admin/productos') ?>">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver Producto</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-eye me-2"></i>Detalles del Producto
                    </h1>
                    <p class="text-muted mb-0">Información completa de: <strong><?= esc($producto['nombre']) ?></strong></p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <a href="<?= base_url('admin/productos/editar/' . $producto['id']) ?>" class="btn btn-admin-primary">
                            <i class="fas fa-edit me-2"></i>Editar Producto
                        </a>
                        <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <div class="row">
            <!-- Imagen del producto -->
            <div class="col-md-4 mb-4">
                <div class="admin-card text-center">
                    <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-image me-2"></i>Imagen del Producto
                    </h5>

                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= esc($producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="product-image">
                    <?php else: ?>
                        <div class="image-placeholder">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Sin imagen</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información del producto -->
            <div class="col-md-8 mb-4">
                <div class="admin-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 class="mb-0" style="color: var(--cafe-oscuro);"><?= esc($producto['nombre']) ?></h3>
                        <span class="badge status-badge <?= ($producto['activo'] ?? 1) ? 'bg-success' : 'bg-secondary' ?> fs-6">
                            <?= ($producto['activo'] ?? 1) ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </div>

                    <?php if (!empty($producto['descripcion_corta'])): ?>
                        <p class="text-muted mb-3"><?= esc($producto['descripcion_corta']) ?></p>
                    <?php endif; ?>

                    <!-- Información básica -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong><i class="fas fa-hashtag me-2"></i>ID:</strong>
                                <span class="float-end"><?= $producto['id'] ?></span>
                            </div>
                            <div class="info-item">
                                <strong><i class="fas fa-barcode me-2"></i>Código/SKU:</strong>
                                <span class="float-end"><?= esc($producto['codigo'] ?? 'No definido') ?></span>
                            </div>
                            <div class="info-item">
                                <strong><i class="fas fa-tag me-2"></i>Categoría:</strong>
                                <span class="float-end">
                                    <?php
                                    // Simular categorías
                                    $categorias = [1 => 'Electrónicos', 2 => 'Ropa', 3 => 'Hogar', 4 => 'Deportes', 5 => 'Libros'];
                                    echo $categorias[$producto['categoria_id']] ?? 'Sin categoría';
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong><i class="fas fa-cube me-2"></i>Stock:</strong>
                                <span class="float-end">
                                    <span class="badge <?= ($producto['stock'] ?? 0) > 10 ? 'bg-success' : (($producto['stock'] ?? 0) > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                        <?= $producto['stock'] ?? 0 ?>
                                    </span>
                                </span>
                            </div>
                            <div class="info-item">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Stock Mínimo:</strong>
                                <span class="float-end"><?= $producto['stock_minimo'] ?? 5 ?></span>
                            </div>
                            <div class="info-item">
                                <strong><i class="fas fa-calendar me-2"></i>Fecha Creación:</strong>
                                <span class="float-end">
                                    <?= isset($producto['fecha_creacion']) ? date('d/m/Y', strtotime($producto['fecha_creacion'])) : 'No disponible' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Precios -->
                    <div class="price-info">
                        <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                            <i class="fas fa-dollar-sign me-2"></i>Información de Precios
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h4 class="text-primary mb-1">$<?= number_format($producto['precio'] ?? 0, 2) ?></h4>
                                    <small class="text-muted">Precio Regular</small>
                                </div>
                            </div>
                            <?php if (!empty($producto['precio_descuento']) && $producto['precio_descuento'] > 0): ?>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <h4 class="text-success mb-1">$<?= number_format($producto['precio_descuento'], 2) ?></h4>
                                        <small class="text-muted">Precio con Descuento</small>
                                        <br>
                                        <span class="badge bg-success">
                                            <?= round((($producto['precio'] - $producto['precio_descuento']) / $producto['precio']) * 100) ?>% OFF
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción completa y características -->
        <div class="row">
            <?php if (!empty($producto['descripcion'])): ?>
                <div class="col-md-8 mb-4">
                    <div class="admin-card">
                        <h5 style="color: var(--cafe-oscuro);">
                            <i class="fas fa-align-left me-2"></i>Descripción Completa
                        </h5>
                        <p><?= nl2br(esc($producto['descripcion'])) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Configuraciones adicionales -->
            <div class="col-md-4 mb-4">
                <div class="admin-card">
                    <h5 style="color: var(--cafe-oscuro);">
                        <i class="fas fa-cogs me-2"></i>Configuraciones
                    </h5>

                    <div class="info-item">
                        <strong><i class="fas fa-star me-2"></i>Destacado:</strong>
                        <span class="float-end">
                            <?php if ($producto['destacado'] ?? 0): ?>
                                <span class="badge bg-warning">
                                    <i class="fas fa-star"></i> Sí
                                </span>
                            <?php else: ?>
                                <span class="text-muted">No</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <strong><i class="fas fa-shipping-fast me-2"></i>Envío Gratis:</strong>
                        <span class="float-end">
                            <?php if ($producto['envio_gratis'] ?? 0): ?>
                                <span class="badge bg-info">
                                    <i class="fas fa-check"></i> Sí
                                </span>
                            <?php else: ?>
                                <span class="text-muted">No</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <strong><i class="fas fa-toggle-on me-2"></i>Estado:</strong>
                        <span class="float-end">
                            <span class="badge status-badge <?= ($producto['activo'] ?? 1) ? 'bg-success' : 'bg-secondary' ?>">
                                <?= ($producto['activo'] ?? 1) ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="admin-card">
                    <h6 style="color: var(--cafe-oscuro);">
                        <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                    </h6>

                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/productos/editar/' . $producto['id']) ?>" class="btn btn-admin-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar Producto
                        </a>

                        <?php if ($producto['activo'] ?? 1): ?>
                            <button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstado(<?= $producto['id'] ?>, 0)">
                                <i class="fas fa-eye-slash"></i> Desactivar
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-success btn-sm" onclick="cambiarEstado(<?= $producto['id'] ?>, 1)">
                                <i class="fas fa-eye"></i> Activar
                            </button>
                        <?php endif; ?>

                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?= $producto['id'] ?>, '<?= esc($producto['nombre']) ?>')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Cambiar estado del producto
    function cambiarEstado(id, nuevoEstado) {
        const accion = nuevoEstado ? 'activar' : 'desactivar';

        if (!confirm(`¿Estás seguro de que deseas ${accion} este producto?`)) {
            return;
        }

        fetch(`<?= base_url('admin/api/producto/') ?>${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    activo: nuevoEstado
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta(`Producto ${accion} exitosamente`, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || `Error al ${accion} producto`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta(`Error al ${accion} producto: ` + error.message, 'danger');
            });
    }

    // Confirmar eliminación
    function confirmarEliminar(id, nombre) {
        if (confirm(`¿Estás seguro de que deseas eliminar el producto "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
            eliminarProducto(id);
        }
    }

    // Eliminar producto
    function eliminarProducto(id) {
        fetch(`<?= base_url('admin/api/producto/') ?>${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('Producto eliminado exitosamente', 'success');
                    setTimeout(() => {
                        window.location.href = '<?= base_url('admin/productos') ?>';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al eliminar producto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('Error al eliminar producto: ' + error.message, 'danger');
            });
    }

    // Mostrar alertas
    function mostrarAlerta(mensaje, tipo) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${tipo} alert-dismissible fade show`;
        alert.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alert);

        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>

<?= $this->include('templates/footer') ?>