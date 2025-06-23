<?= $this->include('templates/header') ?>

<!-- Estilos específicos para ver perfil -->
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

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card-header {
        background: linear-gradient(135deg, var(--dorado), #d4b896);
        color: var(--cafe-oscuro);
        font-weight: 600;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-mediio));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin: 0 auto 1rem;
    }

    .btn-custom {
        background: linear-gradient(135deg, var(--dorado), #d4b896);
        border: none;
        color: var(--cafe-oscuro);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: var(--cafe-oscuro);
    }

    .info-item {
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: var(--cafe-oscuro);
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: var(--cafe-mediio);
        font-size: 1.1rem;
    }
</style>

<!-- Main Content -->
<div class="container mt-4">

    <!-- Mensajes -->
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Mi Perfil
                    </h3>
                </div>
                <div class="card-body p-4">
                    <!-- Avatar -->
                    <div class="text-center mb-4">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mt-3" style="color: var(--cafe-oscuro);">
                            <?= $user['nombre'] ?? 'Usuario' ?> <?= $user['apellido'] ?? '' ?>
                        </h4>
                        <p class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            <?= ucfirst($user['rol_nombre'] ?? $user['rol'] ?? 'Usuario') ?>
                        </p>
                    </div>

                    <!-- Información del perfil -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user me-2"></i>Nombre
                                </div>
                                <div class="info-value">
                                    <?= $user['nombre'] ?? 'No especificado' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user me-2"></i>Apellido
                                </div>
                                <div class="info-value">
                                    <?= $user['apellido'] ?? 'No especificado' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </div>
                                <div class="info-value">
                                    <?= $user['email'] ?? 'No especificado' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-at me-2"></i>Usuario
                                </div>
                                <div class="info-value">
                                    <?= $user['usuario'] ?? $user['email'] ?? 'No especificado' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha de registro
                                </div>
                                <div class="info-value">
                                    <?= isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'No disponible' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-shield-alt me-2"></i>Rol
                                </div>
                                <div class="info-value">
                                    <?= ucfirst($user['rol_nombre'] ?? $user['rol'] ?? 'Usuario') ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Botones de acción -->
                    <div class="text-center mt-4">
                        <a href="<?= base_url('perfil/dashboard') ?>" class="btn btn-custom me-3">
                            <i class="fas fa-tachometer-alt me-2"></i>Mi Dashboard
                        </a>
                        <a href="<?= base_url('perfil/editar') ?>" class="btn btn-outline-secondary me-3">
                            <i class="fas fa-edit me-2"></i>Editar Perfil
                        </a>
                        <?php if (isset($user['rol']) && $user['rol'] === 'admin'): ?>
                            <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-cogs me-2"></i>Panel Admin
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->include('templates/footer') ?>