<?= $this->include('templates/header') ?>

<!-- Admin Dashboard Main -->
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

    .admin-header {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-medio));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }

    .admin-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--dorado), #B8860B);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .management-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .management-card:hover {
        border-color: var(--dorado);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }

    .management-icon {
        font-size: 4rem;
        color: var(--dorado);
        margin-bottom: 1.5rem;
    }

    .welcome-section {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

    .btn-admin-secondary {
        background: linear-gradient(135deg, var(--dorado), #B8860B);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 0.5rem;
    }

    .btn-admin-secondary:hover {
        background: linear-gradient(135deg, #B8860B, var(--cafe-oscuro));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .quick-actions {
        margin-top: 2rem;
    }

    .dashboard-icon {
        font-size: 8rem;
        color: var(--dorado);
        opacity: 0.3;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem 0;
        }

        .admin-header {
            padding: 1.5rem 0;
        }

        .welcome-section {
            padding: 1.5rem;
        }

        .dashboard-icon {
            font-size: 4rem;
        }
    }

    @media (max-width: 576px) {
        .dashboard-icon {
            font-size: 3rem;
        }

        .btn-admin-primary,
        .btn-admin-secondary {
            font-size: 0.9rem;
        }
    }
</style>

<div class="admin-container">
    <div class="container"> <!-- Header de Bienvenida -->
        <div class="admin-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12 text-center text-lg-start">
                        <h1 class="display-5 fw-bold mb-2">
                            <i class="fas fa-shield-alt me-3"></i>Panel de Administración
                        </h1>
                        <p class="lead mb-0 opacity-90">
                            Bienvenido, <?= $user['nombre'] ?? 'Administrador' ?>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-12 text-center text-lg-end mt-3 mt-lg-0">
                        <div class="d-flex flex-column align-items-center align-items-lg-end">
                            <span class="badge bg-success mb-2 px-3 py-2">
                                <i class="fas fa-circle me-1"></i>Sistema En Línea
                            </span>
                            <small class="opacity-75">Última actualización: Ahora</small>
                            <a href="<?= base_url('perfil/editar') ?>" class="btn btn-outline-light btn-sm mt-2">
                                <i class="fas fa-user-edit me-1"></i>Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2 class="mb-2"><?= $stats['usuarios'] ?? 0 ?></h2>
                    <p class="mb-0 fw-bold">Usuarios Registrados</p>
                    <small class="opacity-75">Total en el sistema</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <div class="stat-icon text-white">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <h2 class="mb-2 text-white"><?= $stats['productos'] ?? 0 ?></h2>
                    <p class="mb-0 fw-bold text-white">Productos</p>
                    <small class="text-white opacity-75">En catálogo</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #007bff, #6610f2);">
                    <div class="stat-icon text-white">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2 class="mb-2 text-white"><?= $stats['pedidos'] ?? 0 ?></h2>
                    <p class="mb-0 fw-bold text-white">Pedidos</p>
                    <small class="text-white opacity-75">Este mes</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                    <div class="stat-icon text-white">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h2 class="mb-2 text-white">$<?= number_format($stats['ventas'] ?? 0, 2) ?></h2>
                    <p class="mb-0 fw-bold text-white">Ventas</p>
                    <small class="text-white opacity-75">Este mes</small>
                </div>
            </div>
        </div> <!-- Welcome & Quick Actions -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-12">
                    <h3 class="mb-3" style="color: var(--cafe-oscuro);">
                        <i class="fas fa-rocket me-2"></i>Panel de Control
                    </h3>
                    <p class="text-muted mb-4">
                        Desde aquí puedes gestionar usuarios, productos, pedidos y ver estadísticas importantes de tu tienda de café.
                    </p>
                    <div class="quick-actions">
                        <div class="row g-2">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-admin-primary w-100">
                                    <i class="fas fa-users me-2"></i>Gestionar Usuarios
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="<?= base_url('admin/productos') ?>" class="btn btn-admin-secondary w-100">
                                    <i class="fas fa-coffee me-2"></i>Ver Productos
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="<?= base_url('admin/categorias') ?>" class="btn btn-admin-secondary w-100">
                                    <i class="fas fa-tags me-2"></i>Ver Categorías
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-admin-secondary w-100">
                                    <i class="fas fa-clipboard-list me-2"></i>Ver Pedidos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 text-center mt-lg-0 mt-4">
                    <i class="fas fa-chart-line dashboard-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>