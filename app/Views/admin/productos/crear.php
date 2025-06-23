<?= $this->include('templates/header') ?>

<!-- Crear Producto -->
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

    .form-label {
        color: var(--cafe-oscuro);
        font-weight: 600;
    }

    .form-control:focus {
        border-color: var(--dorado);
        box-shadow: 0 0 0 0.2rem rgba(212, 167, 98, 0.25);
    }

    .form-select:focus {
        border-color: var(--dorado);
        box-shadow: 0 0 0 0.2rem rgba(212, 167, 98, 0.25);
    }

    .image-preview {
        width: 200px;
        height: 200px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color 0.2s;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    .image-preview:hover {
        border-color: var(--dorado);
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
        transition: transform 0.2s ease;
    }

    .image-preview:hover img {
        transform: scale(1.05);
    }

    .image-preview>div {
        text-align: center;
        padding: 1rem;
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/productos') ?>">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Producto
                    </h1>
                    <p class="text-muted mb-0">Añade un nuevo producto al catálogo</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Productos
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <!-- Formulario -->
        <div class="admin-card">
            <form id="crearProductoForm" enctype="multipart/form-data">
                <div class="row">
                    <!-- Información básica -->
                    <div class="col-md-8">
                        <h5 class="mb-4" style="color: var(--cafe-oscuro);">
                            <i class="fas fa-info-circle me-2"></i>Información Básica
                        </h5>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoria_id" class="form-label">Categoría *</label>
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="">Seleccionar categoría...</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        step="0.01" min="0" required>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4"></textarea>
                        </div>

                        <!-- Características del café -->
                        <h5 class="mb-4 mt-4" style="color: var(--cafe-oscuro);">
                            <i class="fas fa-coffee me-2"></i>Características del Café
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="origen" class="form-label">Origen</label>
                                <input type="text" class="form-control" id="origen" name="origen"
                                    placeholder="Ej: Colombia, Brasil">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="proceso" class="form-label">Proceso</label>
                                <input type="text" class="form-control" id="proceso" name="proceso"
                                    placeholder="Ej: Lavado, Natural">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tostacion" class="form-label">Tostación</label>
                                <select class="form-select" id="tostacion" name="tostacion">
                                    <option value="">Seleccionar...</option>
                                    <option value="Clara">Clara</option>
                                    <option value="Media">Media</option>
                                    <option value="Oscura">Oscura</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="puntuacion" class="form-label">Puntuación (0-100)</label>
                                <input type="number" class="form-control" id="puntuacion" name="puntuacion"
                                    min="0" max="100" placeholder="85">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="notas_cata" class="form-label">Notas de Cata</label>
                                <textarea class="form-control" id="notas_cata" name="notas_cata" rows="3"
                                    placeholder="Ej: Notas frutales, chocolate, caramelo"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="stock" class="form-label">Stock Inicial *</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    min="0" value="0" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen y configuración -->
                    <div class="col-md-4">
                        <h5 class="mb-4" style="color: var(--cafe-oscuro);">
                            <i class="fas fa-image me-2"></i>Imagen del Producto
                        </h5>

                        <div class="image-preview mb-3" onclick="document.getElementById('imagen_producto').click()">
                            <div id="imagePreviewContent">
                                <div>
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted small mb-0">Clic para subir imagen</p>
                                    <p class="text-muted small mb-0">200x200px recomendado</p>
                                </div>
                            </div>
                        </div>
                        <input type="file" class="form-control d-none" id="imagen_producto" name="imagen_producto" accept="image/*">
                        <small class="text-muted d-block text-center">Formatos: JPG, PNG, GIF. Máximo 2MB.</small>

                        <!-- Configuración -->
                        <h5 class="mb-4 mt-4" style="color: var(--cafe-oscuro);">
                            <i class="fas fa-cogs me-2"></i>Configuración
                        </h5>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                                <label class="form-check-label" for="activo">
                                    Producto Activo
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="destacado" name="destacado">
                                <label class="form-check-label" for="destacado">
                                    Producto Destacado
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                    <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-admin-primary">
                        <i class="fas fa-save me-2"></i>Crear Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let categoriasData = [];

    // Cargar datos iniciales
    document.addEventListener('DOMContentLoaded', function() {
        cargarCategorias();
        configurarPreviewImagen();
    });

    // Cargar categorías
    function cargarCategorias() {
        fetch('<?= base_url('admin/api/categorias/activas') ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json()).then(data => {
                if (data.success && data.data) {
                    categoriasData = data.data;
                    const selectCategoria = document.getElementById('categoria_id');

                    categoriasData.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nombre;
                        selectCategoria.appendChild(option);
                    });
                } else {
                    console.error('Error al cargar categorías:', data.message);
                    mostrarAlerta('Error al cargar categorías', 'warning');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('Error al cargar categorías', 'warning');
            });
    } // Configurar preview de imagen
    function configurarPreviewImagen() {
        const inputImagen = document.getElementById('imagen_producto');
        const previewContent = document.getElementById('imagePreviewContent');

        inputImagen.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    mostrarAlerta('La imagen no debe superar los 2MB', 'warning');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContent.innerHTML = `<img src="${e.target.result}" alt="Preview" style="display: block;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Manejar envío del formulario
    document.getElementById('crearProductoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Asegurar que los checkboxes se envíen correctamente
        const activoCheckbox = document.getElementById('activo');
        const destacadoCheckbox = document.getElementById('destacado');

        formData.set('activo', activoCheckbox.checked ? '1' : '0');
        formData.set('destacado', destacadoCheckbox.checked ? '1' : '0');

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';

        // Limpiar errores previos
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        fetch('<?= base_url('admin/api/producto') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('Producto creado exitosamente', 'success');
                    setTimeout(() => {
                        window.location.href = '<?= base_url('admin/productos') ?>';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al crear producto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('Error al crear producto: ' + error.message, 'danger');
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
    });

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