<?= $this->include('templates/header') ?>

<!-- Gestión de Productos -->
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

    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-box me-2"></i>Gestión de Productos
                    </h1>
                    <p class="text-muted mb-0">Administra el catálogo de productos de la tienda</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-admin-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div> <!-- Tabla de productos -->
        <div class="admin-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="productos-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Cargando productos...
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
    // Cargar productos
    function loadProductos() {
        fetch('<?= base_url('admin/api/productos') ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json()).then(data => {
                const tbody = document.querySelector('#productos-table tbody');
                if (data.success && data.data) {
                    tbody.innerHTML = '';
                    data.data.forEach(producto => {
                        const row = `
                        <tr>
                            <td><span class="badge bg-secondary">${producto.id}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        ${producto.imagen ? `
                                            <img src="${producto.imagen}" alt="${producto.nombre}" class="product-image">` :
                                            '<div class="product-image bg-light d-flex align-items-center justify-content-center"><i class="fas fa-box text-muted"></i></div>'
                                        }
                                    </div>
                                    <div>
                                        <strong>${producto.nombre}</strong>
                                        ${producto.descripcion_corta ? `<br><small class="text-muted">${producto.descripcion_corta.substring(0, 50)}...</small>` : ''}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">${producto.categoria_nombre || 'Sin categoría'}</span>
                            </td>
                            <td>
                                <strong>$${parseFloat(producto.precio || 0).toFixed(2)}</strong>
                                ${producto.precio_descuento ? `<br><small class="text-muted">Desc: $${parseFloat(producto.precio_descuento).toFixed(2)}</small>` : ''}
                            </td>
                            <td>
                                <span class="badge ${producto.stock > 10 ? 'bg-success' : producto.stock > 0 ? 'bg-warning' : 'bg-danger'}">
                                    ${producto.stock || 0}
                                </span>
                            </td>                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge ${producto.activo == 1 ? 'bg-success' : 'bg-danger'} me-2" id="estado-${producto.id}">
                                        ${producto.activo == 1 ? 'Activo' : 'Inactivo'}
                                    </span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="toggle-${producto.id}" 
                                               ${producto.activo == 1 ? 'checked' : ''} 
                                               onchange="toggleProductoEstado(${producto.id})">
                                    </div>
                                </div>
                            </td><td>
                                <div class="btn-group">
                                    <a href="<?= base_url('admin/productos/editar') ?>/${producto.id}" class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No hay productos para mostrar</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.querySelector('#productos-table tbody').innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Error al cargar productos</td></tr>';
            });
    } // Toggle estado del producto
    function toggleProductoEstado(id) {
        const toggle = document.getElementById(`toggle-${id}`);
        const estadoBadge = document.getElementById(`estado-${id}`);
        const originalChecked = toggle.checked;

        // Deshabilitar el toggle mientras se procesa
        toggle.disabled = true;
        fetch(`<?= base_url('admin/api/producto') ?>/${id}/toggle`, {
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
                    estadoBadge.className = `badge me-2 ${data.data.nuevo_estado == 1 ? 'bg-success' : 'bg-danger'}`;

                    // Actualizar el toggle
                    toggle.checked = data.data.nuevo_estado == 1;

                    showAlert('success', data.message);
                } else {
                    console.error('Error response:', data);
                    // Revertir el toggle si falló
                    toggle.checked = originalChecked;
                    showAlert('error', data.message || 'Error al cambiar el estado del producto');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                // Revertir el toggle si falló
                toggle.checked = originalChecked;
                showAlert('error', 'Error al cambiar el estado del producto');
            })
            .finally(() => {
                // Rehabilitar el toggle
                toggle.disabled = false;
            });
    }

    // Eliminar producto
    function deleteProduct(id) {
        if (confirm('¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.')) {
            fetch(`<?= base_url('admin/api/producto') ?>/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        loadProductos(); // Recargar tabla
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Error al eliminar producto');
                });
        }
    }

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

    // Cargar productos al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        loadProductos();
    });
</script>

<?= $this->include('templates/footer') ?>