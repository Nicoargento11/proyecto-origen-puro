<?= $this->include('templates/header') ?>

<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --beige: #E6D5C3;
        --dorado: #D4A762;
        --crema: #F5F0E6;
    }

    .hero-categoria {
        background: linear-gradient(135deg, var(--cafe-oscuro) 0%, var(--cafe-medio) 100%);
        padding: 80px 0 60px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-categoria::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('<?= base_url('assets/img/coffee-pattern.png') ?>') repeat;
        opacity: 0.1;
        z-index: 1;
    }

    .hero-categoria .container {
        position: relative;
        z-index: 2;
    }

    .productos-grid {
        padding: 60px 0;
        background: var(--crema);
    }

    .producto-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(74, 46, 29, 0.1);
        height: 100%;
    }

    .producto-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(74, 46, 29, 0.2);
    }

    .producto-imagen {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .producto-imagen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .producto-card:hover .producto-imagen img {
        transform: scale(1.1);
    }

    .producto-info {
        padding: 20px;
    }

    .producto-nombre {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--cafe-oscuro);
    }

    .producto-origen {
        color: var(--dorado);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .producto-notas {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-clamp: 2;
        overflow: hidden;
    }

    .producto-precio {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--cafe-oscuro);
        margin-bottom: 15px;
    }

    .btn-producto {
        background: var(--dorado);
        color: var(--cafe-oscuro);
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .btn-producto:hover {
        background: var(--cafe-medio);
        color: white;
        transform: translateY(-2px);
    }

    .btn-detalle {
        background: transparent;
        color: var(--cafe-medio);
        border: 2px solid var(--cafe-medio);
    }

    .btn-detalle:hover {
        background: var(--cafe-medio);
        color: white;
    }

    .sin-productos {
        text-align: center;
        padding: 80px 20px;
        color: #666;
    }

    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .breadcrumb-custom .breadcrumb {
        margin-bottom: 0;
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .breadcrumb-custom .breadcrumb-item a:hover {
        color: var(--dorado);
        text-shadow: 0 0 8px rgba(212, 167, 98, 0.5);
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--dorado);
        font-weight: 600;
        text-shadow: 0 0 8px rgba(212, 167, 98, 0.3);
    }

    .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        font-size: 1.1em;
    }

    .categoria-stats {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .filtros-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .hero-categoria {
            padding: 60px 0 40px;
        }

        .productos-grid {
            padding: 40px 0;
        }

        .producto-imagen {
            height: 200px;
        }

        .breadcrumb-custom {
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .breadcrumb-custom .breadcrumb {
            font-size: 0.9rem;
        }

        .breadcrumb-custom .breadcrumb-item a,
        .breadcrumb-custom .breadcrumb-item.active {
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }
    }
</style>

<!-- Hero Section de la Categoría -->
<section class="hero-categoria">
    <div class="container"> <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>" title="Ir a la página principal">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('productos') ?>" title="Ver todos los productos">
                        <i class="fas fa-box me-1"></i>Productos
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-tag me-1"></i><?= esc($categoria['nombre']) ?>
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-coffee me-3" style="color: var(--dorado);"></i>
                    <?= esc($categoria['nombre']) ?>
                </h1>

                <?php if (!empty($categoria['descripcion'])): ?>
                    <p class="lead mb-4"><?= esc($categoria['descripcion']) ?></p>
                <?php endif; ?>

                <div class="categoria-stats">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-1">
                                <i class="fas fa-box me-2" style="color: var(--dorado);"></i>
                                <?= count($productos) ?> productos
                            </h5>
                            <small class="text-light">disponibles en esta categoría</small>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">
                                <i class="fas fa-star me-2" style="color: var(--dorado);"></i>
                                Calidad Premium
                            </h5>
                            <small class="text-light">productos seleccionados</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-icon" style="font-size: 8rem; opacity: 0.3;">
                    <i class="fas fa-coffee"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de productos -->
<section class="productos-grid">
    <div class="container">

        <!-- Filtros y opciones (futuro) -->
        <div class="filtros-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2" style="color: var(--cafe-medio);"></i>
                        Mostrando <?= count($productos) ?> productos
                    </h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        <i class="fas fa-sort me-1"></i>
                        Ordenado por nombre
                    </small>
                </div>
            </div>
        </div>

        <?php if (!empty($productos)): ?>
            <div class="row g-4">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="producto-card">
                            <!-- Imagen del producto -->
                            <div class="producto-imagen">
                                <?php if (!empty($producto['imagen_producto'])): ?>
                                    <img src="<?= base_url('public/uploads/productos/' . $producto['imagen_producto']) ?>"
                                        alt="<?= esc($producto['nombre']) ?>"
                                        onerror="this.src='<?= base_url('assets/img/placeholder-coffee.jpg') ?>'">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-coffee fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Badge de stock -->
                                <?php if ($producto['stock'] <= 5 && $producto['stock'] > 0): ?>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Últimas unidades
                                        </span>
                                    </div>
                                <?php elseif ($producto['stock'] <= 0): ?>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Sin stock
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Información del producto -->
                            <div class="producto-info">
                                <h3 class="producto-nombre"><?= esc($producto['nombre']) ?></h3>

                                <?php if (!empty($producto['origen'])): ?>
                                    <p class="producto-origen">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <?= esc($producto['origen']) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($producto['notas_cata'])): ?>
                                    <p class="producto-notas">
                                        <?= esc($producto['notas_cata']) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="producto-precio">
                                        $<?= number_format($producto['precio'], 2) ?>
                                    </span>
                                    <?php if (!empty($producto['puntuacion'])): ?>
                                        <div class="text-warning">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star<?= $i <= $producto['puntuacion'] ? '' : ' text-muted' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if ($producto['stock'] > 0): ?>
                                        <button class="btn-producto agregar-carrito-categoria flex-grow-1"
                                            data-producto-id="<?= $producto['id'] ?>"
                                            data-producto-nombre="<?= esc($producto['nombre']) ?>"
                                            data-producto-precio="<?= $producto['precio'] ?>">
                                            <i class="fas fa-cart-plus me-1"></i>
                                            Agregar al carrito
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-producto flex-grow-1" disabled>
                                            <i class="fas fa-times me-1"></i>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>

                                    <a href="<?= base_url('productos/' . $producto['id']) ?>"
                                        class="btn-producto btn-detalle">
                                        <i class="fas fa-eye me-1"></i>
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginación (si fuera necesaria) -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        <i class="fas fa-check-circle me-2" style="color: var(--dorado);"></i>
                        Has visto todos los productos de esta categoría
                    </p>
                </div>
            </div>

        <?php else: ?>
            <!-- Sin productos -->
            <div class="sin-productos">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <i class="fas fa-coffee fa-5x mb-4" style="color: var(--dorado); opacity: 0.5;"></i>
                        <h3 class="mb-3">No hay productos en esta categoría</h3>
                        <p class="mb-4">
                            Actualmente no tenemos productos disponibles en la categoría
                            <strong><?= esc($categoria['nombre']) ?></strong>.
                        </p>
                        <a href="<?= base_url('productos') ?>" class="btn-producto">
                            <i class="fas fa-arrow-left me-2"></i>
                            Ver todos los productos
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Categorías relacionadas -->
        <?php if (!empty($categorias) && count($categorias) > 1): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="filtros-section">
                        <h5 class="mb-3">
                            <i class="fas fa-tags me-2" style="color: var(--cafe-medio);"></i>
                            Otras categorías
                        </h5>
                        <div class="row g-3">
                            <?php foreach ($categorias as $cat): ?>
                                <?php if ($cat['id'] !== $categoria['id']): ?>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="<?= base_url('productos/categoria/' . $cat['slug']) ?>"
                                            class="btn-producto d-block text-center">
                                            <i class="fas fa-coffee me-2"></i>
                                            <?= esc($cat['nombre']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Script para agregar al carrito -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botonesCarrito = document.querySelectorAll('.agregar-carrito-categoria');

        botonesCarrito.forEach(boton => {
            boton.addEventListener('click', function() {
                const productoId = this.dataset.productoId;
                const productoNombre = this.dataset.productoNombre;
                const productoPrecio = this.dataset.productoPrecio;

                // Mostrar indicador de carga
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Agregando...';
                this.disabled = true;

                // Realizar petición AJAX
                fetch('<?= base_url('carrito/agregar') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `producto_id=${productoId}&cantidad=1`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            this.innerHTML = '<i class="fas fa-check me-1"></i>¡Agregado!';
                            this.style.background = '#28a745';
                            this.style.color = 'white';

                            // Actualizar contador del carrito
                            if (typeof actualizarContadorCarrito === 'function') {
                                actualizarContadorCarrito();
                            }

                            // Mostrar toast de confirmación
                            mostrarToast(productoNombre);

                            // Restaurar botón después de 2 segundos
                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.style.background = 'var(--dorado)';
                                this.style.color = 'var(--cafe-oscuro)';
                                this.disabled = false;
                            }, 2000);

                        } else {
                            // Mostrar error
                            alert(data.message || 'Error al agregar el producto al carrito');
                            this.innerHTML = originalText;
                            this.disabled = false;

                            // Si necesita login, redirigir
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al agregar el producto al carrito');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });
            });
        });

        // Función para mostrar toast
        function mostrarToast(productoNombre) {
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
            <div class="toast show" role="alert" style="border-left: 4px solid var(--dorado);">
                <div class="toast-header bg-light">
                    <i class="fas fa-shopping-cart text-success me-2"></i>
                    <strong class="me-auto">Producto agregado</strong>
                    <button type="button" class="btn-close" onclick="this.closest('.position-fixed').remove()"></button>
                </div>
                <div class="toast-body">
                    <strong>${productoNombre}</strong> se agregó al carrito exitosamente.
                    <div class="mt-2">
                        <a href="<?= base_url('carrito') ?>" class="btn btn-sm btn-success me-2">
                            <i class="fas fa-eye me-1"></i>Ver carrito
                        </a>
                        <button class="btn btn-sm btn-secondary" onclick="this.closest('.position-fixed').remove()">
                            Continuar comprando
                        </button>
                    </div>
                </div>
            </div>
        `;
            document.body.appendChild(toast);

            // Eliminar toast después de 5 segundos
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 5000);
        }
    });
</script>

<?= $this->include('templates/footer') ?>