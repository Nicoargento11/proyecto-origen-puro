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

    <?php if (session('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>Por favor corrige los errores indicados abajo.<br>
            <?php foreach (session('errors') as $campo => $mensaje): ?>
                <strong><?= esc($campo) ?>:</strong> <?= esc($mensaje) ?><br>
            <?php endforeach; ?>
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
                                <input type="text" class="form-control<?= session('errors.nombre') ? ' is-invalid' : '' ?>" id="nombre" name="nombre"
                                    value="<?= old('nombre', $user['nombre']) ?>" required>
                                <?php if (session('errors.nombre')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.nombre')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control<?= session('errors.apellido') ? ' is-invalid' : '' ?>" id="apellido" name="apellido"
                                    value="<?= old('apellido', $user['apellido']) ?>" required>
                                <?php if (session('errors.apellido')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.apellido')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control<?= session('errors.email') ? ' is-invalid' : '' ?>" id="email" name="email"
                                value="<?= old('email', $user['email']) ?>" required>
                            <?php if (session('errors.email')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.email')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control<?= session('errors.telefono') ? ' is-invalid' : '' ?>" id="telefono" name="telefono"
                                    value="<?= old('telefono', $user['telefono'] ?? '') ?>">
                                <?php if (session('errors.telefono')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.telefono')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control<?= session('errors.ciudad') ? ' is-invalid' : '' ?>" id="ciudad" name="ciudad"
                                    value="<?= old('ciudad', $user['ciudad'] ?? '') ?>">
                                <?php if (session('errors.ciudad')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.ciudad')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control<?= session('errors.direccion') ? ' is-invalid' : '' ?>" id="direccion" name="direccion"
                                    value="<?= old('direccion', $user['direccion'] ?? '') ?>">
                                <?php if (session('errors.direccion')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.direccion')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="codigo_postal" class="form-label">Código Postal</label>
                                <input type="text" class="form-control<?= session('errors.codigo_postal') ? ' is-invalid' : '' ?>" id="codigo_postal" name="codigo_postal"
                                    value="<?= old('codigo_postal', $user['codigo_postal'] ?? '') ?>">
                                <?php if (session('errors.codigo_postal')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.codigo_postal')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" class="form-control<?= session('errors.pais') ? ' is-invalid' : '' ?>" id="pais" name="pais"
                                    value="<?= old('pais', $user['pais'] ?? '') ?>">
                                <?php if (session('errors.pais')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.pais')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Cambiar Contraseña (Opcional)</h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control<?= session('errors.current_password') ? ' is-invalid' : '' ?>" id="current_password" name="current_password">
                            <small class="form-text text-muted">Déjalo vacío si no quieres cambiar la contraseña</small>
                            <?php if (session('errors.current_password')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.current_password')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control<?= session('errors.new_password') ? ' is-invalid' : '' ?>" id="new_password" name="new_password" min="6">
                                <?php if (session('errors.new_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.new_password')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control<?= session('errors.confirm_password') ? ' is-invalid' : '' ?>" id="confirm_password" name="confirm_password">
                                <?php if (session('errors.confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors.confirm_password')) ?>
                                    </div>
                                <?php endif; ?>
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