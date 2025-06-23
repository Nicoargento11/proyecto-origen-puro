<?= $this->include('templates/header') ?>

<!-- Gestión de Categorías -->
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
        padding: 0;
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

    .table th {
        background-color: var(--beige) !important;
        color: var(--cafe-oscuro);
        font-weight: 600;
        border: none;
    }

    .table tbody tr:hover {
        background-color: var(--crema);
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

    .badge-activo {
        background-color: #28a745;
    }

    .badge-inactivo {
        background-color: #dc3545;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
    }

    .btn-edit {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-edit:hover {
        background-color: #138496;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        color: white;
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categorías</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-tags me-2"></i>Gestión de Categorías
                    </h1>
                    <p class="text-muted mb-0">Administra las categorías de productos de la tienda</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('admin/categorias/crear') ?>" class="btn btn-admin-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Categoría
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <!-- Tabla de categorías -->
        <div class="admin-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="categorias-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Productos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Cargando categorías...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Cargar categorías
    function loadCategorias() {
        fetch('<?= base_url('admin/api/categorias') ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json()).then(data => {
                if (data.success) {
                    renderCategorias(data.data);
                } else {
                    showAlert('error', data.message || 'Error al cargar categorías');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al cargar categorías');
            });
    }

    // Renderizar tabla de categorías
    function renderCategorias(categorias) {
        const tbody = document.querySelector('#categorias-table tbody');

        if (categorias.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-info-circle me-2"></i>No hay categorías registradas
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = categorias.map(categoria => `
            <tr>
                <td>${categoria.id}</td>
                <td><strong>${categoria.nombre}</strong></td>
                <td>${categoria.descripcion || '-'}</td>                <td>
                    <div class="d-flex align-items-center">
                        <span class="badge ${categoria.activa == 1 ? 'badge-activo' : 'badge-inactivo'} me-2" id="estado-${categoria.id}">
                            ${categoria.activa == 1 ? 'Activa' : 'Inactiva'}
                        </span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggle-${categoria.id}" 
                                   ${categoria.activa == 1 ? 'checked' : ''} 
                                   onchange="toggleCategoriaEstado(${categoria.id})">
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-secondary">${categoria.productos_count || 0} productos</span>
                </td>
                <td>
                    <a href="<?= base_url('admin/categorias/editar') ?>/${categoria.id}" 
                       class="btn btn-icon btn-edit" 
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-icon btn-delete" 
                            onclick="eliminarCategoria(${categoria.id}, '${categoria.nombre}')"
                            title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>        `).join('');
    } // Toggle estado de la categoría
    function toggleCategoriaEstado(id) {
        const toggle = document.getElementById(`toggle-${id}`);
        const estadoBadge = document.getElementById(`estado-${id}`);
        const originalChecked = toggle.checked;

        // Deshabilitar el toggle mientras se procesa
        toggle.disabled = true;

        fetch(`<?= base_url('admin/api/categorias') ?>/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success && data.data) {
                    // Actualizar el badge
                    estadoBadge.textContent = data.data.texto_estado;
                    estadoBadge.className = `badge me-2 ${data.data.nuevo_estado == 1 ? 'badge-activo' : 'badge-inactivo'}`;

                    // Actualizar el toggle
                    toggle.checked = data.data.nuevo_estado == 1;

                    showAlert('success', data.message);
                } else {
                    console.error('Error response:', data);
                    // Revertir el toggle si falló
                    toggle.checked = originalChecked;
                    showAlert('error', data.message || 'Error al cambiar el estado de la categoría');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                // Revertir el toggle si falló
                toggle.checked = originalChecked;
                showAlert('error', 'Error al cambiar el estado de la categoría');
            })
            .finally(() => {
                // Rehabilitar el toggle
                toggle.disabled = false;
            });
    }

    // Eliminar categoría
    function eliminarCategoria(id, nombre) {
        if (!confirm(`¿Estás seguro de que deseas eliminar la categoría "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
            return;
        }

        fetch(`<?= base_url('admin/api/categorias') ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    loadCategorias(); // Recargar tabla
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Error al eliminar la categoría');
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

        // Auto-hide después de 5 segundos
        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Cargar categorías al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        loadCategorias();
    });
</script>

<?= $this->include('templates/footer') ?>