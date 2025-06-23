<?= $this->include('templates/header') ?>

<!-- Estilos específicos para perfil -->
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

    .form-control:focus {
        border-color: var(--dorado);
        box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
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

    <div class="row">
        <!-- Perfil Info -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Mi Perfil</h5>
                </div>
                <div class="card-body text-center">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4><?= $user['nombre'] ?> <?= $user['apellido'] ?></h4>
                    <p class="text-muted"><?= $user['email'] ?></p>
                    <?php if (!empty($user['roles'])): ?>
                        <?php foreach ($user['roles'] as $rol): ?>
                            <span class="badge bg-primary me-1"><?= ucfirst($rol['nombre']) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="badge bg-secondary">Usuario</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Formulario de edición -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Información Personal</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?= $user['nombre'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                    value="<?= $user['apellido'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $user['email'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario"
                                value="<?= $user['usuario'] ?? $user['email'] ?>" required>
                        </div>

                        <hr>

                        <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Cambiar Contraseña (Opcional)</h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <small class="form-text text-muted">Déjalo vacío si no quieres cambiar la contraseña</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" min="6">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                            </a>
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>