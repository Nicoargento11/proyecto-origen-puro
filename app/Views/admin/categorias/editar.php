<?= $this->include('templates/header') ?>

<!-- Editar Categoría -->
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

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        color: white;
        transform: translateY(-2px);
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

    .form-check-input:checked {
        background-color: var(--dorado);
        border-color: var(--dorado);
    }

    .form-check-input:focus {
        border-color: var(--dorado);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(212, 167, 98, 0.25);
    }

    .required {
        color: #dc3545;
    }

    .loading-container {
        text-align: center;
        padding: 3rem;
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/categorias') ?>">Categorías</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-edit me-2"></i>Editar Categoría
                    </h1>
                    <p class="text-muted mb-0">Modifica los datos de la categoría</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('admin/categorias') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <!-- Loading -->
        <div id="loadingContainer" class="admin-card">
            <div class="loading-container">
                <i class="fas fa-spinner fa-spin fa-2x" style="color: var(--cafe-medio);"></i>
                <p class="mt-3 text-muted">Cargando datos de la categoría...</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="admin-card" id="formContainer" style="display: none;">
            <form id="categoriaForm">
                <input type="hidden" id="categoria_id" value="<?= $categoria['id'] ?>">

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                Nombre de la Categoría <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="nombre"
                                name="nombre"
                                required
                                maxlength="100"
                                placeholder="Ej: Café Especial">
                            <div class="form-text">Mínimo 3 caracteres, máximo 100</div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control"
                                id="descripcion"
                                name="descripcion"
                                rows="4"
                                maxlength="500"
                                placeholder="Descripción opcional de la categoría..."></textarea>
                            <div class="form-text">Máximo 500 caracteres</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <div class="card p-3" style="background-color: var(--crema);">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="activa"
                                        name="activa">
                                    <label class="form-check-label" for="activa">
                                        <strong>Categoría Activa</strong>
                                    </label>
                                </div>
                                <small class="text-muted mt-2">
                                    Solo las categorías activas aparecerán en la tienda
                                </small>
                            </div>
                        </div>

                        <div class="card p-3" style="background-color: var(--beige);" id="infoCard">
                            <h6 class="card-title mb-2" style="color: var(--cafe-oscuro);">
                                <i class="fas fa-info-circle me-1"></i>Información
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-1">
                                    <i class="fas fa-calendar text-primary me-1"></i>
                                    <strong>Creada:</strong> <span id="fecha_creacion">-</span>
                                </li>
                                <li class="mb-1">
                                    <i class="fas fa-boxes text-info me-1"></i>
                                    <strong>Productos:</strong> <span id="productos_count">0</span>
                                </li>
                                <li>
                                    <i class="fas fa-hashtag text-secondary me-1"></i>
                                    <strong>ID:</strong> <span id="categoria_info_id">-</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="<?= base_url('admin/categorias') ?>" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-admin-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const categoriaId = <?= $categoria['id'] ?>;

    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos de la categoría
        loadCategoriaData();

        // Configurar formulario
        const form = document.getElementById('categoriaForm');
        form.addEventListener('submit', handleSubmit);
    });

    function loadCategoriaData() {
        fetch(`<?= base_url('admin/api/categorias') ?>/${categoriaId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateForm(data.data || data.categoria);
                    showForm();
                } else {
                    showAlert('error', 'Error al cargar los datos de la categoría');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al cargar los datos de la categoría');
            });
    }

    function populateForm(categoria) {
        // Llenar formulario
        document.getElementById('nombre').value = categoria.nombre || '';
        document.getElementById('descripcion').value = categoria.descripcion || '';
        document.getElementById('activa').checked = categoria.activa == 1;

        // Llenar información adicional
        document.getElementById('categoria_info_id').textContent = categoria.id;

        // Formatear fecha si existe
        if (categoria.created_at) {
            const fecha = new Date(categoria.created_at);
            document.getElementById('fecha_creacion').textContent = fecha.toLocaleDateString('es-ES');
        }

        // Si hay contador de productos, mostrarlo
        if (categoria.productos_count !== undefined) {
            document.getElementById('productos_count').textContent = categoria.productos_count;
        }
    }

    function showForm() {
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('formContainer').style.display = 'block';
    }

    function handleSubmit(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');

        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';

        // Preparar datos
        const formData = {
            nombre: document.getElementById('nombre').value.trim(),
            descripcion: document.getElementById('descripcion').value.trim(),
            activa: document.getElementById('activa').checked ? 1 : 0
        };

        // Enviar datos
        fetch(`<?= base_url('admin/api/categorias') ?>/${categoriaId}`, {
                method: 'PUT',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);

                    // Redirigir después de 2 segundos
                    setTimeout(() => {
                        window.location.href = '<?= base_url('admin/categorias') ?>';
                    }, 2000);
                } else {
                    showAlert('error', data.message);

                    // Mostrar errores de validación
                    if (data.errors) {
                        let errorMsg = 'Errores de validación:<ul>';
                        for (let field in data.errors) {
                            errorMsg += `<li>${data.errors[field]}</li>`;
                        }
                        errorMsg += '</ul>';
                        showAlert('error', errorMsg);
                    }

                    // Rehabilitar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Cambios';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al actualizar la categoría');

                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Cambios';
            });
    }

    // Mostrar alertas
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        alertContainer.innerHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas ${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Auto-hide después de tiempo determinado
        if (type === 'error') {
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 8000);
        }
    }

    // Contador de caracteres para descripción
    document.getElementById('descripcion').addEventListener('input', function() {
        const maxLength = 500;
        const currentLength = this.value.length;
        const formText = this.parentNode.querySelector('.form-text');

        formText.textContent = `${currentLength}/${maxLength} caracteres`;

        if (currentLength > maxLength * 0.9) {
            formText.style.color = '#dc3545';
        } else {
            formText.style.color = '#6c757d';
        }
    });
</script>

<?= $this->include('templates/footer') ?>