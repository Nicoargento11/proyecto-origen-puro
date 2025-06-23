<?= $this->include('templates/header') ?>

<!-- Crear Categoría -->
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
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/categorias') ?>">Categorías</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nueva Categoría
                    </h1>
                    <p class="text-muted mb-0">Completa los datos para crear una nueva categoría</p>
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

        <!-- Formulario -->
        <div class="admin-card">
            <form id="categoriaForm">
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
                                        name="activa"
                                        checked>
                                    <label class="form-check-label" for="activa">
                                        <strong>Categoría Activa</strong>
                                    </label>
                                </div>
                                <small class="text-muted mt-2">
                                    Solo las categorías activas aparecerán en la tienda
                                </small>
                            </div>
                        </div>

                        <div class="card p-3" style="background-color: var(--beige);">
                            <h6 class="card-title mb-2" style="color: var(--cafe-oscuro);">
                                <i class="fas fa-info-circle me-1"></i>Información
                            </h6>
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-1"></i>
                                    El nombre debe ser único
                                </li>
                                <li class="mb-1">
                                    <i class="fas fa-check text-success me-1"></i>
                                    La descripción es opcional
                                </li>
                                <li>
                                    <i class="fas fa-check text-success me-1"></i>
                                    Puedes cambiar el estado después
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
                            <i class="fas fa-save me-2"></i>Crear Categoría
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('categoriaForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Deshabilitar botón y mostrar loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';

            // Recopilar datos del formulario
            const formData = new FormData();
            formData.append('nombre', document.getElementById('nombre').value.trim());
            formData.append('descripcion', document.getElementById('descripcion').value.trim());
            formData.append('activa', document.getElementById('activa').checked ? '1' : '0');

            // Enviar datos
            fetch('<?= base_url('admin/api/categorias/crear') ?>', {
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
                        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Crear Categoría';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Error al crear la categoría');

                    // Rehabilitar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Crear Categoría';
                });
        });
    });

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

        // Auto-hide después de 5 segundos para alertas de error
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