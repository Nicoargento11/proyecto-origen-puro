<!-- Hero Section -->
<section class="hero-productos">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto text-center">
                <?php if (isset($busqueda_activa) && $busqueda_activa): ?>
                    <h1 class="display-4 fw-bold mb-4">
                        Resultados de <span class="text-dorado">Búsqueda</span>
                    </h1>
                    <p class="lead mb-4">
                        <?php if ($total_resultados > 0): ?>
                            Se encontraron <strong><?= $total_resultados ?></strong> productos para "<strong><?= esc($termino) ?></strong>"
                        <?php else: ?>
                            No se encontraron productos para "<strong><?= esc($termino) ?></strong>"
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <h1 class="display-4 fw-bold mb-4">
                        Nuestros <span class="text-dorado">Cafés de Especialidad</span>
                    </h1>
                    <p class="lead mb-4">
                        Descubre nuestra selección de cafés premium, cuidadosamente seleccionados
                        de las mejores fincas del mundo y tostados con pasión.
                    </p>
                <?php endif; ?>

                <!-- Barra de búsqueda -->
                <form action="<?= base_url('productos/buscar') ?>" method="get" class="d-flex justify-content-center mb-4">
                    <div class="input-group" style="max-width: 500px;">
                        <input type="text" class="form-control form-control-lg" name="q"
                            placeholder="Buscar por nombre, origen, descripción..."
                            value="<?= esc($termino ?? '') ?>"
                            style="border-radius: 50px 0 0 50px; border: 2px solid var(--dorado);">
                        <button class="btn btn-dorado btn-lg" type="submit" style="border-radius: 0 50px 50px 0; border: 2px solid var(--dorado);">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>

                <!-- Mensaje de búsqueda rápida -->
                <?php if (!isset($busqueda_activa)): ?>
                    <div class="mt-3">
                        <small class="text-light opacity-75">
                            <i class="fas fa-lightbulb me-1"></i>
                            Prueba buscar: "Colombia", "Arábica", "Tostado medio", etc.
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Filtros y Categorías -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                    <?php if (isset($busqueda_activa) && $busqueda_activa): ?>
                        <!-- Opciones de búsqueda -->
                        <a href="<?= base_url('productos') ?>" class="btn btn-outline-cafe">
                            <i class="fas fa-arrow-left me-1"></i>Ver Todos los Cafés
                        </a>
                        <span class="btn btn-cafe disabled">
                            <i class="fas fa-search me-1"></i>Búsqueda: "<?= esc($termino) ?>"
                        </span>
                        <?php if ($total_resultados > 0): ?>
                            <span class="btn btn-outline-success disabled">
                                <?= $total_resultados ?> resultado<?= $total_resultados != 1 ? 's' : '' ?>
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Filtros por categoría -->
                        <a href="<?= base_url('productos') ?>"
                            class="btn btn-outline-cafe <?= !isset($categoria) ? 'active' : '' ?>">
                            Todos los Cafés
                        </a>
                        <?php foreach ($categorias as $cat): ?>
                            <a href="<?= base_url('productos/categoria/' . $cat['slug']) ?>"
                                class="btn btn-outline-cafe <?= isset($categoria) && $categoria['id'] == $cat['id'] ? 'active' : '' ?>">
                                <?= esc($cat['nombre']) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <?php if (isset($busqueda_activa) && $busqueda_activa && $total_resultados > 0): ?>
                    <div class="text-center text-md-end">
                        <small class="text-muted">
                            <i class="fas fa-filter me-1"></i>
                            Ordenado por relevancia
                        </small>
                    </div>
                <?php elseif (!isset($busqueda_activa)): ?>
                    <div class="text-center text-md-end">
                        <small class="text-muted">
                            <i class="fas fa-coffee me-1"></i>
                            <?= count($productos) ?> productos disponibles
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Productos -->
<section class="py-5">
    <div class="container">
        <?php if (isset($categoria)): ?>
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="mb-3"><?= esc($categoria['nombre']) ?></h2>
                    <?php if ($categoria['descripcion']): ?>
                        <p class="text-muted"><?= esc($categoria['descripcion']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($productos)): ?>
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card producto-card h-100">
                            <!-- Imagen del producto -->
                            <div class="position-relative overflow-hidden">
                                <?php if ($producto['imagen_producto']): ?>
                                    <img src="<?= base_url('public/uploads/productos/' . $producto['imagen_producto']) ?>"
                                        class="card-img-top producto-img" alt="<?= esc($producto['nombre']) ?>">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light producto-img">
                                        <i class="fas fa-coffee fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Badges -->
                                <?php if ($producto['destacado']): ?>
                                    <span class="badge bg-dorado position-absolute top-0 start-0 m-2">
                                        <i class="fas fa-star me-1"></i>Destacado
                                    </span>
                                <?php endif; ?>

                                <?php if ($producto['stock'] <= 0): ?>
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                        Sin Stock
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Categoría -->
                                <?php if ($producto['categoria_nombre']): ?>
                                    <small class="text-muted mb-1">
                                        <i class="fas fa-tag me-1"></i><?= esc($producto['categoria_nombre']) ?>
                                    </small>
                                <?php endif; ?>

                                <!-- Nombre -->
                                <h5 class="card-title mb-2"><?= esc($producto['nombre']) ?></h5>

                                <!-- Origen -->
                                <?php if ($producto['origen']): ?>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-map-marker-alt me-1"></i><?= esc($producto['origen']) ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Puntuación -->
                                <?php if ($producto['puntuacion']): ?>
                                    <div class="mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= $producto['puntuacion'] ? 'text-warning' : 'text-muted' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="ms-1 text-muted">(<?= $producto['puntuacion'] ?>)</span>
                                    </div>
                                <?php endif; ?> <!-- Descripción corta -->
                                <?php if ($producto['descripcion']): ?>
                                    <p class="card-text text-muted mb-3">
                                        <?= substr(strip_tags($producto['descripcion']), 0, 100) . (strlen(strip_tags($producto['descripcion'])) > 100 ? '...' : '') ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Precio y botones -->
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="text-cafe mb-0">$<?= number_format($producto['precio'], 2) ?></h4>
                                            <small class="text-muted">por kg</small>
                                        </div>
                                        <div>
                                            <a href="<?= base_url('productos/' . $producto['id']) ?>"
                                                class="btn btn-outline-cafe btn-sm me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($producto['stock'] > 0): ?>
                                                <button class="btn btn-cafe btn-sm agregar-carrito"
                                                    data-producto-id="<?= $producto['id'] ?>">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> <?php else: ?>
            <div class="row">
                <div class="col-12 text-center py-5">
                    <?php if (isset($busqueda_activa) && $busqueda_activa): ?>
                        <!-- Sin resultados de búsqueda -->
                        <i class="fas fa-search fa-4x text-muted mb-3" style="opacity: 0.5;"></i>
                        <h3 class="text-muted">No se encontraron productos</h3>
                        <p class="text-muted mb-4">
                            No pudimos encontrar cafés que coincidan con "<strong><?= esc($termino) ?></strong>".
                        </p>

                        <!-- Sugerencias de búsqueda -->
                        <div class="alert alert-info d-inline-block" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-lightbulb me-1"></i>Sugerencias de búsqueda:
                            </h6>
                            <ul class="list-unstyled mb-0 text-start" style="max-width: 300px;">
                                <li>• Verifica la ortografía</li>
                                <li>• Usa términos más generales</li>
                                <li>• Busca por origen: "Colombia", "Brasil"</li>
                                <li>• Busca por tipo: "Arábica", "Tostado"</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <a href="<?= base_url('productos') ?>" class="btn btn-cafe me-2">
                                <i class="fas fa-coffee me-1"></i>Ver Todos los Cafés
                            </a>
                            <button class="btn btn-outline-cafe" onclick="document.querySelector('input[name=q]').focus()">
                                <i class="fas fa-search me-1"></i>Buscar de Nuevo
                            </button>
                        </div>
                    <?php else: ?>
                        <!-- Sin productos en general -->
                        <i class="fas fa-coffee fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">No se encontraron productos</h3>
                        <p class="text-muted">Intenta con una búsqueda diferente o explora nuestras categorías.</p>
                        <a href="<?= base_url('productos') ?>" class="btn btn-cafe">
                            Ver Todos los Cafés
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
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

    .hero-productos {
        background: linear-gradient(135deg, var(--cafe-oscuro) 0%, var(--cafe-medio) 100%);
        color: white;
        padding: 80px 0 40px;
    }

    .text-dorado {
        color: var(--dorado) !important;
    }

    .text-cafe {
        color: var(--cafe-oscuro) !important;
    }

    .bg-dorado {
        background-color: var(--dorado) !important;
    }

    .btn-dorado {
        background-color: var(--dorado);
        border-color: var(--dorado);
        color: var(--cafe-oscuro);
        font-weight: 600;
    }

    .btn-dorado:hover {
        background-color: #c19a4f;
        border-color: #c19a4f;
        color: white;
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

    .btn-outline-cafe:hover,
    .btn-outline-cafe.active {
        background-color: var(--cafe-oscuro);
        border-color: var(--cafe-oscuro);
        color: white;
    }

    .producto-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .producto-img {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .producto-card:hover .producto-img {
        transform: scale(1.05);
    }

    .min-vh-50 {
        min-height: 50vh;
    }
</style>

<script>
    // Agregar al carrito con AJAX
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.agregar-carrito').forEach(btn => {
            btn.addEventListener('click', function() {
                const productoId = this.dataset.productoId;
                const cantidad = 1; // Por defecto 1 kg

                // Mostrar indicador de carga
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Agregando...';
                this.disabled = true;

                // Realizar petición AJAX
                fetch('<?= base_url('carrito/agregar') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `producto_id=${productoId}&cantidad=${cantidad}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            this.innerHTML = '<i class="fas fa-check me-2"></i>¡Agregado!';
                            this.classList.remove('btn-cafe');
                            this.classList.add('btn-success');

                            // Actualizar contador del carrito en navbar si existe
                            updateCartCount(data.total_items);

                            // Restaurar botón después de 2 segundos
                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.classList.remove('btn-success');
                                this.classList.add('btn-cafe');
                                this.disabled = false;
                            }, 2000);

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

        function updateCartCount(count) {
            // Buscar elemento del contador del carrito en la navbar
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
                if (count > 0) {
                    cartCountElement.style.display = 'inline';
                }
            }
        }

        // Mejorar experiencia de búsqueda
        const searchInput = document.querySelector('input[name="q"]');
        const searchForm = searchInput.closest('form');

        // Autoenfoque en el campo de búsqueda si está vacío
        if (searchInput.value === '') {
            searchInput.focus();
        }

        // Limpiar búsqueda con Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.blur();
            }
        });

        // Validación del formulario de búsqueda
        searchForm.addEventListener('submit', function(e) {
            const termino = searchInput.value.trim();

            if (termino.length < 2) {
                e.preventDefault();
                searchInput.focus();

                // Mostrar mensaje temporal
                const originalPlaceholder = searchInput.placeholder;
                searchInput.placeholder = 'Ingresa al menos 2 caracteres...';
                searchInput.classList.add('is-invalid');

                setTimeout(() => {
                    searchInput.placeholder = originalPlaceholder;
                    searchInput.classList.remove('is-invalid');
                }, 2000);

                return false;
            }
        });

        // Resaltar términos de búsqueda en los resultados
        <?php if (isset($busqueda_activa) && $busqueda_activa && !empty($termino)): ?>
            const terminoBusqueda = '<?= addslashes($termino) ?>';
            const regex = new RegExp(`(${terminoBusqueda})`, 'gi');

            // Resaltar en títulos y descripciones
            document.querySelectorAll('.card-title, .card-text').forEach(element => {
                const texto = element.innerHTML;
                const textoResaltado = texto.replace(regex, '<mark class="bg-warning text-dark">$1</mark>');
                element.innerHTML = textoResaltado;
            });
        <?php endif; ?>

        // Contador de caracteres en tiempo real
        searchInput.addEventListener('input', function() {
            const longitud = this.value.length;
            const button = searchForm.querySelector('button[type="submit"]');

            if (longitud === 0) {
                button.innerHTML = '<i class="fas fa-search"></i> Buscar';
            } else if (longitud === 1) {
                button.innerHTML = '<i class="fas fa-edit"></i> 1 más...';
            } else {
                button.innerHTML = `<i class="fas fa-search"></i> Buscar (${longitud})`;
            }
        });

        // Búsquedas sugeridas
        const terminosPopulares = ['Colombia', 'Brasil', 'Arábica', 'Tostado medio', 'Descafeinado', 'Orgánico'];

        // Solo mostrar sugerencias si no estamos en una búsqueda activa
        <?php if (!isset($busqueda_activa) || !$busqueda_activa): ?>
            if (terminosPopulares.length > 0) {
                const sugerenciasContainer = document.createElement('div');
                sugerenciasContainer.className = 'mt-2';
                sugerenciasContainer.innerHTML = `
                <small class="text-light opacity-75">
                    <i class="fas fa-tags me-1"></i>Búsquedas populares: 
                    ${terminosPopulares.map(termino => 
                        `<button type="button" class="btn btn-link btn-sm text-warning p-0 ms-1" onclick="buscarTermino('${termino}')">${termino}</button>`
                    ).join(', ')}
                </small>
            `;
                searchForm.parentNode.appendChild(sugerenciasContainer);
            }
        <?php endif; ?>

        // Función para buscar término sugerido
        window.buscarTermino = function(termino) {
            searchInput.value = termino;
            searchForm.submit();
        };
    });
</script>

<!-- Estilos adicionales para la búsqueda -->
<style>
    .is-invalid {
        border-color: #dc3545 !important;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    mark {
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 600;
    }

    .btn-link {
        text-decoration: none !important;
    }

    .btn-link:hover {
        text-decoration: underline !important;
    }
</style>