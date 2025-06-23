<!-- Carrito de Compras -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold text-cafe mb-4">
                    <i class="fas fa-shopping-cart me-3"></i>Mi Carrito
                </h1>

                <?php if (session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($carrito && !empty($carrito['items'])): ?>
                    <!-- Items del Carrito -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header bg-cafe text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-list me-2"></i>
                                        Productos en tu carrito (<?= $carrito['total_items'] ?>)
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <?php foreach ($carrito['items'] as $item): ?>
                                        <div class="item-carrito p-3 border-bottom" data-item-id="<?= $item['id'] ?>">
                                            <div class="row align-items-center">
                                                <!-- Imagen del Producto -->
                                                <div class="col-md-2">
                                                    <?php if ($item['imagen_producto']): ?>
                                                        <img src="<?= base_url('public/uploads/productos/' . $item['imagen_producto']) ?>"
                                                            class="img-fluid rounded" alt="<?= esc($item['producto_nombre']) ?>"
                                                            style="height: 80px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                            style="height: 80px; width: 80px;">
                                                            <i class="fas fa-coffee text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Información del Producto -->
                                                <div class="col-md-4">
                                                    <h6 class="mb-1"><?= esc($item['producto_nombre']) ?></h6>
                                                    <small class="text-muted">
                                                        Precio unitario: $<?= number_format($item['precio_unitario'], 2) ?> /kg
                                                    </small><br>
                                                    <small class="text-muted">
                                                        Stock disponible: <?= $item['stock_disponible'] ?> kg
                                                    </small>
                                                </div>

                                                <!-- Cantidad -->
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <button class="btn btn-outline-secondary btn-sm decrementar-item"
                                                            type="button" data-item-id="<?= $item['id'] ?>">-</button>
                                                        <input type="number" class="form-control form-control-sm text-center cantidad-item"
                                                            value="<?= $item['cantidad'] ?>"
                                                            min="1"
                                                            max="<?= $item['stock_disponible'] ?>"
                                                            data-item-id="<?= $item['id'] ?>">
                                                        <button class="btn btn-outline-secondary btn-sm incrementar-item"
                                                            type="button" data-item-id="<?= $item['id'] ?>">+</button>
                                                    </div>
                                                </div>

                                                <!-- Subtotal -->
                                                <div class="col-md-2">
                                                    <div class="text-center">
                                                        <span class="fw-bold text-cafe subtotal-item">
                                                            $<?= number_format($item['subtotal'], 2) ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Eliminar -->
                                                <div class="col-md-1">
                                                    <a href="<?= base_url('carrito/eliminar/' . $item['id']) ?>"
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Acciones del Carrito -->
                            <div class="mt-3">
                                <a href="<?= base_url('productos') ?>" class="btn btn-outline-cafe">
                                    <i class="fas fa-arrow-left me-2"></i>Seguir Comprando
                                </a>
                                <a href="<?= base_url('carrito/limpiar') ?>" class="btn btn-outline-danger ms-2"
                                    onclick="return confirm('¿Seguro que quieres limpiar todo el carrito?')">
                                    <i class="fas fa-trash me-2"></i>Limpiar Carrito
                                </a>
                            </div>
                        </div>

                        <!-- Resumen del Pedido -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-dorado text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calculator me-2"></i>Resumen del Pedido
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="resumen-carrito">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total de productos:</span>
                                            <span id="total-cantidad"><?= $carrito['total_cantidad'] ?> kg</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal-precio">$<?= number_format($carrito['total_precio'], 2) ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Envío:</span>
                                            <span class="text-success">Gratis</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-3">
                                            <strong>Total:</strong>
                                            <strong class="h5 text-cafe" id="total-precio">
                                                $<?= number_format($carrito['total_precio'], 2) ?>
                                            </strong>
                                        </div> <a href="<?= base_url('checkout') ?>" class="btn btn-cafe btn-lg w-100 mb-3">
                                            <i class="fas fa-credit-card me-2"></i>
                                            Proceder al Checkout
                                        </a>

                                        <div class="text-muted small">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Compra 100% segura
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-truck me-2"></i>Información de Envío
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Envío gratis en CABA
                                        </li>
                                        <li class="mb-1">
                                            <i class="fas fa-clock text-info me-2"></i>
                                            Entrega en 24-48hs
                                        </li>
                                        <li>
                                            <i class="fas fa-box text-warning me-2"></i>
                                            Embalaje hermético
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Carrito Vacío -->
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">
                            ¡Descubre nuestros increíbles cafés de especialidad y comienza a llenar tu carrito!
                        </p>
                        <a href="<?= base_url('productos') ?>" class="btn btn-cafe btn-lg">
                            <i class="fas fa-coffee me-2"></i>
                            Explorar Productos
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --dorado: #D4A762;
        --beige: #E6D5C3;
        --crema: #F5F0E6;
    }

    .text-cafe {
        color: var(--cafe-oscuro) !important;
    }

    .bg-cafe {
        background-color: var(--cafe-oscuro) !important;
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

    .item-carrito {
        transition: background-color 0.3s ease;
    }

    .item-carrito:hover {
        background-color: var(--crema);
    }

    .cantidad-item {
        max-width: 80px;
    }

    .resumen-carrito {
        background-color: var(--crema);
        padding: 20px;
        border-radius: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar cambios de cantidad
        document.querySelectorAll('.cantidad-item').forEach(input => {
            input.addEventListener('change', function() {
                actualizarCantidadItem(this.dataset.itemId, this.value);
            });
        });

        // Botones incrementar/decrementar
        document.querySelectorAll('.incrementar-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const input = document.querySelector(`.cantidad-item[data-item-id="${itemId}"]`);
                const nuevaCantidad = parseInt(input.value) + 1;
                const maxCantidad = parseInt(input.max);

                if (nuevaCantidad <= maxCantidad) {
                    input.value = nuevaCantidad;
                    actualizarCantidadItem(itemId, nuevaCantidad);
                }
            });
        });

        document.querySelectorAll('.decrementar-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const input = document.querySelector(`.cantidad-item[data-item-id="${itemId}"]`);
                const nuevaCantidad = parseInt(input.value) - 1;

                if (nuevaCantidad >= 1) {
                    input.value = nuevaCantidad;
                    actualizarCantidadItem(itemId, nuevaCantidad);
                }
            });
        });

        function actualizarCantidadItem(itemId, cantidad) {
            fetch('<?= base_url('carrito/actualizar') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `item_id=${itemId}&cantidad=${cantidad}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar totales en la página
                        actualizarTotales(data.carrito);
                    } else {
                        alert(data.message);
                        // Revertir el valor del input
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar el carrito');
                    location.reload();
                });
        }

        function actualizarTotales(carrito) {
            document.getElementById('total-cantidad').textContent = carrito.total_cantidad + ' kg';
            document.getElementById('subtotal-precio').textContent = '$' + carrito.total_precio.toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('total-precio').textContent = '$' + carrito.total_precio.toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Actualizar subtotales individuales
            carrito.items.forEach(item => {
                const subtotalElement = document.querySelector(`.item-carrito[data-item-id="${item.id}"] .subtotal-item`);
                if (subtotalElement) {
                    subtotalElement.textContent = '$' + item.subtotal.toLocaleString('es-AR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });
        }
    });
</script>