<?= $this->include('templates/header') ?>

<!-- Dashboard del Usuario -->
<style>
    :root {
        --cafe-oscuro: #3a2618;
        --dorado: #c8a97e;
        --crema: #f8f3e9;
        --beige: #f9f5ed;
        --cafe-mediio: #5d3f2e;
    }

    body {
        background-color: var(--crema);
        font-family: 'Poppins', sans-serif;
    }

    .nav-link {
        font-weight: 500;
    }

    .nav-link:hover {
        color: var(--dorado) !important;
    }

    .btn-outline-light:hover {
        background-color: var(--dorado);
        border-color: var(--dorado);
        color: var(--cafe-oscuro);
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(135deg, var(--dorado), #d4b896);
        color: var(--cafe-oscuro);
        font-weight: 600;
        border-radius: 12px 12px 0 0 !important;
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-mediio));
        color: white;
    }

    .stats-card {
        background: var(--beige);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .btn-custom {
        background: linear-gradient(to right, var(--cafe-oscuro), var(--cafe-mediio));
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(58, 38, 24, 0.3);
        color: white;
    }

    .footer {
        background: var(--cafe-oscuro);
        color: white;
        padding: 2rem 0;
        margin-top: 3rem;
    }
</style>

<!-- Main Content -->
<div class="container mt-4">

    <!-- Mensajes de éxito -->
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Mensajes de error -->
    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">¡Bienvenido, <?= $user['nombre'] ?>!</h2>
                            <p class="mb-0 opacity-75">Disfruta de la mejor experiencia en Origen Puro. Explora nuestros productos y servicios.</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="icon-box mx-auto">
                                <i class="fas fa-coffee"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center p-4">
                    <div class="icon-box mx-auto mb-3" style="background: var(--dorado); color: var(--cafe-oscuro);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h5 class="card-title">Mis Pedidos</h5>
                    <p class="card-text text-muted">Revisa el estado de tus pedidos</p>
                    <a href="#" class="btn btn-custom">Ver Pedidos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center p-4">
                    <div class="icon-box mx-auto mb-3" style="background: var(--dorado); color: var(--cafe-oscuro);">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 class="card-title">Favoritos</h5>
                    <p class="card-text text-muted">Tus productos favoritos</p>
                    <a href="#" class="btn btn-custom">Ver Favoritos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card stats-card">
                <div class="card-body text-center p-4">
                    <div class="icon-box mx-auto mb-3" style="background: var(--dorado); color: var(--cafe-oscuro);">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h5 class="card-title">Mi Perfil</h5>
                    <p class="card-text text-muted">Administra tu información</p>
                    <a href="#" class="btn btn-custom">Ver Perfil</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon-box me-3" style="background: var(--cafe-oscuro); color: white; width: 50px; height: 50px;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Explorar Productos</h6>
                                    <small class="text-muted">Descubre nuestro catálogo completo</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="icon-box me-3" style="background: var(--dorado); color: var(--cafe-oscuro); width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Contacto</h6>
                                    <small class="text-muted">¿Necesitas ayuda? Contáctanos</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Información Personal</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td><?= $user['nombre'] ?> <?= $user['apellido'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td><?= $user['email'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Rol:</strong></td>
                            <td>
                                <?php if (isset($user['roles']) && !empty($user['roles'])): ?>
                                    <?php foreach ($user['roles'] as $rol): ?>
                                        <span class="badge bg-primary me-1"><?= ucfirst($rol['nombre']) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Usuario</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->include('templates/footer') ?>