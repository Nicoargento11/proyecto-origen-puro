<?= $this->include('templates/header') ?>

<!-- Gestión de Usuarios -->
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
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-2" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-users me-2"></i>Gestión de Usuarios
                    </h1>
                    <p class="text-muted mb-0">Administra todos los usuarios del sistema</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('admin/usuarios/crear') ?>" class="btn btn-admin-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenedor de alertas -->
        <div id="alertContainer"></div>

        <!-- Tabla de usuarios -->
        <div class="admin-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="usuarios-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Fecha Registro</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Cargando usuarios...
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
    // Cargar usuarios
    function loadUsuarios() {
        fetch('<?= base_url('admin/api/usuarios') ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#usuarios-table tbody');
                if (data.success && data.data) {
                    tbody.innerHTML = '';
                    data.data.forEach(usuario => {
                        const row = `
                        <tr>
                            <td><span class="badge bg-secondary">${usuario.id}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>${usuario.nombre} ${usuario.apellido}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>${usuario.email}</td>
                            <td>
                                ${usuario.roles ? usuario.roles.map(rol => `<span class="badge bg-primary me-1">${rol.nombre}</span>`).join('') : '<span class="badge bg-secondary">Usuario</span>'}
                            </td>
                            <td>${new Date(usuario.fecha_registro).toLocaleDateString()}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input usuario-activo-switch" type="checkbox" id="switch-activo-${usuario.id}" data-usuario-id="${usuario.id}" ${usuario.baja === 'NO' ? 'checked' : ''}>
                                    <label class="form-check-label" for="switch-activo-${usuario.id}">${usuario.baja === 'NO' ? 'Activo' : 'Baja'}</label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href=\"<?= base_url('admin/usuarios/editar') ?>/${usuario.id}\" class=\"btn btn-sm btn-outline-primary\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No hay usuarios para mostrar</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.querySelector('#usuarios-table tbody').innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Error al cargar usuarios</td></tr>';
            });
    }

    // Cambiar estado de baja/activo
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('usuario-activo-switch')) {
            const usuarioId = e.target.dataset.usuarioId;
            const nuevoEstado = e.target.checked ? 'NO' : 'SI';
            fetch(`<?= base_url('admin/api/usuario/baja') ?>/${usuarioId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        baja: nuevoEstado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        loadUsuarios();
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    showAlert('error', 'Error al actualizar el estado del usuario');
                });
        }
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

    // Cargar usuarios al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        loadUsuarios();
    });
</script>

<?= $this->include('templates/footer') ?>