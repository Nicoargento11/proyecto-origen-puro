<?= $this->include('templates/header') ?>

<!-- Checkout/Finalizar Compra -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --dorado: #D4A762;
        --beige: #E6D5C3;
        --crema: #F5F0E6;
    }

    .checkout-container {
        padding: 2rem 0;
        min-height: calc(100vh - 80px);
    }

    .checkout-header {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
    }

    .checkout-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 2rem;
    }

    .btn-checkout {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        border: none;
        color: white;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-checkout:hover {
        background: linear-gradient(135deg, var(--cafe-medio), var(--dorado));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .btn-checkout:disabled {
        background: #6c757d;
        transform: none;
        box-shadow: none;
    }

    .item-carrito {
        border-bottom: 1px solid #f1f3f4;
        padding: 1rem 0;
    }

    .item-carrito:last-child {
        border-bottom: none;
    }

    .producto-imagen {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .resumen-total {
        background: linear-gradient(45deg, var(--crema), var(--beige));
        border-radius: 10px;
        padding: 1.5rem;
        border: 2px solid var(--dorado);
    }
</style>

<div class="checkout-container">
    <div class="container">
        <!-- Header -->
        <div class="checkout-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h2 mb-2">
                            <i class="fas fa-shopping-cart me-3"></i>Finalizar Compra
                        </h1>
                        <p class="mb-0 opacity-90">Revisa tu pedido y completa la compra</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-box me-2"></i><?= $carrito['total_cantidad'] ?> productos
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <div class="row">
            <!-- Resumen del pedido -->
            <div class="col-lg-8">
                <div class="checkout-card">
                    <h4 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-list me-2"></i>Resumen del Pedido
                    </h4>

                    <?php foreach ($carrito['items'] as $item): ?>
                        <div class="item-carrito">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <?php if (!empty($item['imagen_producto'])): ?>
                                        <img src="<?= base_url("public/uploads/productos/" . $item['imagen_producto']) ?>"
                                            alt="<?= esc($item['producto_nombre']) ?>"
                                            class="producto-imagen">
                                    <?php else: ?>
                                        <div class="producto-imagen bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-coffee text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-5">
                                    <h6 class="mb-1"><?= esc($item['producto_nombre']) ?></h6>
                                    <small class="text-muted">Precio: $<?= number_format($item['precio_unitario'], 2) ?></small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-secondary">Cant: <?= $item['cantidad'] ?></span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <strong>$<?= number_format($item['subtotal'], 2) ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> <!-- Información del pedido -->
                <div class="checkout-card">
                    <h4 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-clipboard-check me-2"></i>Confirmación del Pedido
                    </h4>

                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>¡Todo listo!</strong> Tu pedido será procesado inmediatamente una vez confirmado.
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-4">
                            Revisa tu pedido en el resumen de la izquierda y haz clic en "Procesar Pedido" cuando estés listo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Resumen de totales -->
            <div class="col-lg-4">
                <div class="checkout-card">
                    <h4 class="mb-4" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-calculator me-2"></i>Resumen de Compra
                    </h4>
                    <div class="resumen-total">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>$<?= number_format($subtotal, 2) ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="h5">Total:</span>
                            <span class="h4" style="color: var(--cafe-oscuro);">$<?= number_format($total, 2) ?></span>
                        </div>
                    </div> <button type="button" class="btn-checkout mt-4" id="btnProcesar">
                        <i class="fas fa-shopping-cart me-2"></i>Procesar Pedido
                    </button>

                    <div class="text-center mt-3">
                        <a href="<?= base_url('carrito') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Carrito
                        </a>
                    </div>
                </div>

                <!-- Información del cliente -->
                <div class="checkout-card">
                    <h5 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-user me-2"></i>Datos del Cliente
                    </h5>
                    <p class="mb-1"><strong><?= esc($usuario['nombre'] . ' ' . $usuario['apellido']) ?></strong></p>
                    <p class="mb-0 text-muted"><?= esc($usuario['email']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Manejar clic del botón procesar
    document.getElementById('btnProcesar').addEventListener('click', function(e) {
        e.preventDefault();

        const btnProcesar = this;
        const originalText = btnProcesar.innerHTML;

        // Mostrar loading
        btnProcesar.disabled = true;
        btnProcesar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';

        // Crear FormData vacío (sin notas ni método de pago)
        const formData = new FormData();

        fetch('<?= base_url('checkout/procesar') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => {
                        window.location.href = `<?= base_url('checkout/factura') ?>/${data.pedido_id}`;
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al procesar el pedido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al procesar el pedido: ' + error.message);
            })
            .finally(() => {
                // Restaurar botón
                btnProcesar.disabled = false;
                btnProcesar.innerHTML = originalText;
            });
    });

    // Mostrar alertas
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

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