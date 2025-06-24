<?= $this->include('templates/header') ?>

<!-- Gestión de Pedidos -->
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
</style>

<div class="admin-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fas fa-home me-1"></i>Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-clipboard-list me-2"></i>Gestión de Pedidos
                    </h1>
                    <p class="text-muted mb-0">Administra todos los pedidos del sistema</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-admin-primary" onclick="loadPedidos()">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <!-- Tabla de pedidos -->
        <div class="admin-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="pedidos-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Productos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Cargando pedidos...
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
    // Cargar pedidos
    function loadPedidos() {
        fetch('<?= base_url('admin/api/pedidos') ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                const tbody = document.querySelector('#pedidos-table tbody');
                if (data.success && data.data) {
                    tbody.innerHTML = '';

                    data.data.forEach(pedido => {
                        const row = `
                        <tr>
                            <td><span class="badge bg-secondary">${pedido.id}</span></td>                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>${(pedido.nombre || '') + ' ' + (pedido.apellido || '') || 'Cliente'}</strong>
                                        <br><small class="text-muted">${pedido.email || 'Sin email'}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>${new Date(pedido.fecha_pedido).toLocaleDateString()}</strong>
                                    <br><small class="text-muted">${new Date(pedido.fecha_pedido).toLocaleTimeString()}</small>
                                </div>
                            </td>
                            <td>
                                <strong>$${parseFloat(pedido.total || 0).toFixed(2)}</strong>
                            </td>
                            <td>
                                ${getEstadoBadge(pedido.estado)}
                            </td>
                            <td>
                                <span class="badge bg-info">${pedido.total_productos || 0} items</span>
                            </td>                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('admin/pedidos/ver') ?>/${pedido.id}" class="btn btn-sm btn-outline-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });

                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No hay pedidos para mostrar</td></tr>';
                    }
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No hay pedidos para mostrar</td></tr>';
                }
            })
            .catch(error => {
                document.querySelector('#pedidos-table tbody').innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Error al cargar pedidos: ' + error.message + '</td></tr>';
            });
    } // Obtener badge según el estado
    function getEstadoBadge(estado) {
        const estados = {
            'pendiente': '<span class="badge bg-warning">Pendiente</span>',
            'confirmado': '<span class="badge bg-info">Confirmado</span>',
            'enviado': '<span class="badge bg-primary">Enviado</span>',
            'entregado': '<span class="badge bg-success">Entregado</span>',
            'cancelado': '<span class="badge bg-danger">Cancelado</span>'
        };
        return estados[estado] || '<span class="badge bg-secondary">Sin estado</span>';
    }

    // Eliminar pedido
    function deletePedido(id) {
        if (confirm('¿Estás seguro de que quieres eliminar este pedido? Esta acción no se puede deshacer.')) {
            fetch(`<?= base_url('admin/api/pedido') ?>/${id}`, {
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
                        loadPedidos(); // Recargar tabla
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Error al eliminar pedido');
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

    // Cargar pedidos al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        loadPedidos();
    });
</script>

<?= $this->include('templates/footer') ?>