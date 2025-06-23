<!-- Producto Individual -->
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('productos') ?>">Productos</a></li>
                <?php if ($producto['categoria_nombre']): ?>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('productos/categoria/' . $producto['categoria_slug']) ?>">
                            <?= esc($producto['categoria_nombre']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($producto['nombre']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Imagen del Producto -->
            <div class="col-lg-6 mb-4">
                <div class="producto-imagen-container">
                    <?php if ($producto['imagen_producto']): ?>
                        <img src="<?= base_url('public/uploads/productos/' . $producto['imagen_producto']) ?>"
                            class="img-fluid rounded producto-imagen-principal"
                            alt="<?= esc($producto['nombre']) ?>">
                    <?php else: ?>
                        <div class="img-fluid rounded producto-imagen-principal d-flex align-items-center justify-content-center bg-light">
                            <i class="fas fa-coffee fa-5x text-muted"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Badges -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <?php if ($producto['destacado']): ?>
                            <span class="badge bg-dorado mb-1 d-block">
                                <i class="fas fa-star me-1"></i>Destacado
                            </span>
                        <?php endif; ?>

                        <?php if ($producto['stock'] <= 0): ?>
                            <span class="badge bg-danger">
                                Sin Stock
                            </span>
                        <?php elseif ($producto['stock'] <= 5): ?>
                            <span class="badge bg-warning text-dark">
                                Últimas unidades
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="col-lg-6">
                <div class="producto-info">
                    <!-- Categoría -->
                    <?php if ($producto['categoria_nombre']): ?>
                        <span class="badge bg-outline-cafe mb-2">
                            <i class="fas fa-tag me-1"></i><?= esc($producto['categoria_nombre']) ?>
                        </span>
                    <?php endif; ?>

                    <!-- Nombre -->
                    <h1 class="display-5 fw-bold text-cafe mb-3"><?= esc($producto['nombre']) ?></h1>

                    <!-- Origen -->
                    <?php if ($producto['origen']): ?>
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <strong>Origen:</strong> <?= esc($producto['origen']) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Puntuación -->
                    <?php if ($producto['puntuacion']): ?>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $producto['puntuacion'] ? 'text-warning' : 'text-muted' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-muted">(<?= $producto['puntuacion'] ?>/5)</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Precio -->
                    <div class="precio-container mb-4">
                        <h2 class="text-cafe mb-1">$<?= number_format($producto['precio'], 2) ?></h2>
                        <small class="text-muted">por kilogramo</small>
                    </div>

                    <!-- Descripción -->
                    <?php if ($producto['descripcion']): ?>
                        <div class="mb-4">
                            <h5 class="text-cafe mb-2">Descripción</h5>
                            <p class="text-muted"><?= nl2br(esc($producto['descripcion'])) ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Características -->
                    <div class="caracteristicas mb-4">
                        <h5 class="text-cafe mb-3">Características</h5>
                        <div class="row">
                            <?php if ($producto['proceso']): ?>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Proceso:</small><br>
                                    <strong><?= esc($producto['proceso']) ?></strong>
                                </div>
                            <?php endif; ?>

                            <?php if ($producto['tostacion']): ?>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Tostación:</small><br>
                                    <strong><?= esc($producto['tostacion']) ?></strong>
                                </div>
                            <?php endif; ?>

                            <div class="col-md-6 mb-2">
                                <small class="text-muted">Stock disponible:</small><br>
                                <strong class="<?= $producto['stock'] <= 5 ? 'text-warning' : 'text-success' ?>">
                                    <?= $producto['stock'] ?> kg
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Notas de Cata -->
                    <?php if ($producto['notas_cata']): ?>
                        <div class="mb-4">
                            <h5 class="text-cafe mb-2">Notas de Cata</h5>
                            <p class="text-muted fst-italic"><?= esc($producto['notas_cata']) ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Cantidad y Botón de Compra -->
                    <?php if ($producto['stock'] > 0): ?>
                        <div class="compra-container">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad (kg)</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="decrementar">-</button>
                                        <input type="number" class="form-control text-center" id="cantidad"
                                            value="1" min="1" max="<?= $producto['stock'] ?>">
                                        <button class="btn btn-outline-secondary" type="button" id="incrementar">+</button>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <button class="btn btn-cafe btn-lg w-100 agregar-carrito"
                                        data-producto-id="<?= $producto['id'] ?>"
                                        data-producto-nombre="<?= esc($producto['nombre']) ?>"
                                        data-producto-precio="<?= $producto['precio'] ?>">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        Agregar al Carrito
                                    </button>
                                </div>
                            </div>

                            <!-- Precio Total -->
                            <div class="precio-total-container p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total:</span>
                                    <span class="h4 text-cafe mb-0" id="precio-total">
                                        $<?= number_format($producto['precio'], 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Este producto está agotado. Te notificaremos cuando esté disponible.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productos Relacionados -->
<?php if (!empty($relacionados)): ?>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="text-cafe">Productos Relacionados</h3>
                    <p class="text-muted">Otros cafés que te podrían interesar</p>
                </div>
            </div>

            <div class="row">
                <?php foreach ($relacionados as $relacionado): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card producto-card h-100">
                            <div class="position-relative overflow-hidden">
                                <?php if ($relacionado['imagen_producto']): ?>
                                    <img src="<?= base_url('public/uploads/productos/' . $relacionado['imagen_producto']) ?>"
                                        class="card-img-top producto-img-small" alt="<?= esc($relacionado['nombre']) ?>">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light producto-img-small">
                                        <i class="fas fa-coffee fa-2x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h6 class="card-title"><?= esc($relacionado['nombre']) ?></h6>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i><?= esc($relacionado['origen']) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-cafe">$<?= number_format($relacionado['precio'], 2) ?></span>
                                    <a href="<?= base_url('productos/' . $relacionado['id']) ?>"
                                        class="btn btn-outline-cafe btn-sm">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --dorado: #D4A762;
        --beige: #E6D5C3;
        --crema: #F5F0E6;
    }

    .producto-imagen-container {
        position: relative;
    }

    .producto-imagen-principal {
        width: 100%;
        height: 500px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .producto-info {
        padding: 20px 0;
    }

    .precio-container {
        border-left: 4px solid var(--dorado);
        padding-left: 20px;
    }

    .caracteristicas {
        background-color: var(--crema);
        padding: 20px;
        border-radius: 8px;
    }

    .compra-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .producto-img-small {
        height: 200px;
        object-fit: cover;
    }

    .text-cafe {
        color: var(--cafe-oscuro) !important;
    }

    .bg-dorado {
        background-color: var(--dorado) !important;
    }

    .btn-cafe {
        background-color: var(--cafe-oscuro);
        border-color: var(--cafe-oscuro);
        color: white;
        font-weight: 500;
    }

    .btn-cafe:hover {
        background-color: var(--cafe-medio);
        border-color: var(--cafe-medio);
        color: white;
    }

    .btn-outline-cafe {
        border-color: var(--cafe-oscuro);
        color: var(--cafe-oscuro);
    }

    .btn-outline-cafe:hover {
        background-color: var(--cafe-oscuro);
        border-color: var(--cafe-oscuro);
        color: white;
    }

    .bg-outline-cafe {
        background-color: transparent;
        border: 1px solid var(--cafe-oscuro);
        color: var(--cafe-oscuro);
    }

    .producto-card {
        transition: transform 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .producto-card:hover {
        transform: translateY(-5px);
    }

    .precio-total-container {
        border: 2px solid var(--dorado);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cantidadInput = document.getElementById('cantidad');
        const incrementarBtn = document.getElementById('incrementar');
        const decrementarBtn = document.getElementById('decrementar');
        const precioTotalSpan = document.getElementById('precio-total');
        const agregarCarritoBtn = document.querySelector('.agregar-carrito');

        const precioUnitario = <?= $producto['precio'] ?>;
        const stockMaximo = <?= $producto['stock'] ?>;

        // Función para actualizar el precio total
        function actualizarPrecioTotal() {
            const cantidad = parseInt(cantidadInput.value);
            const total = precioUnitario * cantidad;
            precioTotalSpan.textContent = '$' + total.toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Incrementar cantidad
        incrementarBtn.addEventListener('click', function() {
            const cantidad = parseInt(cantidadInput.value);
            if (cantidad < stockMaximo) {
                cantidadInput.value = cantidad + 1;
                actualizarPrecioTotal();
            }
        });

        // Decrementar cantidad
        decrementarBtn.addEventListener('click', function() {
            const cantidad = parseInt(cantidadInput.value);
            if (cantidad > 1) {
                cantidadInput.value = cantidad - 1;
                actualizarPrecioTotal();
            }
        });

        // Cambio manual de cantidad
        cantidadInput.addEventListener('input', function() {
            let cantidad = parseInt(this.value);
            if (cantidad < 1) cantidad = 1;
            if (cantidad > stockMaximo) cantidad = stockMaximo;
            this.value = cantidad;
            actualizarPrecioTotal();
        });
        // Agregar al carrito
        agregarCarritoBtn.addEventListener('click', function() {
            const cantidad = parseInt(cantidadInput.value);
            const productoId = this.dataset.productoId;
            const productoNombre = this.dataset.productoNombre;

            // Mostrar indicador de carga
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Agregando al Carrito...';
            this.disabled = true;

            // Realizar petición AJAX
            fetch('<?= base_url('carrito/agregar') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `producto_id=${productoId}&cantidad=${cantidad}`
                })
                .then(response => response.json()).then(data => {
                    if (data.success) {
                        // Actualizar contador del carrito
                        if (typeof actualizarContadorCarrito === 'function') {
                            actualizarContadorCarrito();
                        }

                        // Mostrar mensaje de éxito
                        this.innerHTML = '<i class="fas fa-check me-2"></i>¡Agregado al Carrito!';
                        this.classList.remove('btn-cafe');
                        this.classList.add('btn-success');

                        // Mostrar opción de ir al carrito o seguir comprando
                        setTimeout(() => {
                            if (confirm(`${productoNombre} agregado al carrito.\n\n¿Quieres ir al carrito o seguir comprando?`)) {
                                window.location.href = '<?= base_url('carrito') ?>';
                            } else {
                                // Restaurar botón
                                this.innerHTML = originalText;
                                this.classList.remove('btn-success');
                                this.classList.add('btn-cafe');
                                this.disabled = false;
                            }
                        }, 1000);

                    } else {
                        // Mostrar error
                        alert(data.message);
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
</script>