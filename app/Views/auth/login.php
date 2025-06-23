<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Origen Puro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        :root {
            --cafe-oscuro: #3a2618;
            --dorado: #c8a97e;
            --crema: #f8f3e9;
            --beige: #f9f5ed;
            --cafe-mediio: #5d3f2e;
            --sombra: 0 15px 30px rgba(0, 0, 0, 0.12);
            --transicion: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }

        body {
            background: url('https://images.unsplash.com/photo-1445116572660-236099ec97a0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            color: #333;
            padding-top: 80px !important;
            /* Compensar navbar fija */
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(58, 38, 24, 0.85);
            z-index: -1;
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--sombra);
            transition: var(--transicion);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--cafe-oscuro), var(--cafe-mediio));
            color: white;
            text-align: center;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--dorado), transparent);
        }

        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .card-header p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--cafe-oscuro);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .input-estetico {
            background-color: white;
            border: 2px solid #e0d6c9;
            border-radius: 8px;
            padding: 12px 15px;
            transition: var(--transicion);
            font-size: 0.95rem;
        }

        .input-estetico:focus {
            outline: none;
            border-color: var(--dorado);
            box-shadow: 0 0 0 3px rgba(200, 169, 126, 0.2);
        }

        .btn-login {
            background: linear-gradient(to right, var(--cafe-oscuro), var(--cafe-mediio));
            color: white;
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: var(--transicion);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.9rem;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(58, 38, 24, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 38, 24, 0.3);
            background: linear-gradient(to right, var(--cafe-mediio), var(--cafe-oscuro));
            color: white;
        }

        .card-footer {
            background-color: transparent;
            text-align: center;
            padding: 1.5rem 2.5rem;
            font-size: 0.95rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-footer a {
            color: var(--dorado);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
            position: relative;
        }

        .card-footer a:hover {
            color: var(--cafe-oscuro);
        }

        .card-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--dorado);
            transition: width 0.3s ease;
        }

        .card-footer a:hover::after {
            width: 100%;
        }

        .logo {
            position: absolute;
            top: 30px;
            left: 30px;
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            z-index: 10;
        }

        .logo span {
            color: var(--dorado);
        }

        @media (max-width: 768px) {
            .card-header {
                padding: 1.8rem;
            }

            .card-body {
                padding: 1.8rem;
            }

            .logo {
                top: 20px;
                left: 20px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="logo">Origen<span>Puro</span></div>

    <section class="py-5 w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-header">
                            <h2><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</h2>
                            <p class="mb-0">Bienvenido de vuelta a Origen Puro</p>
                        </div>

                        <div class="card-body">
                            <!-- Mensajes de éxito -->
                            <?php if (session('success')): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Mensajes de error -->
                            <?php if (session('error')): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Errores de validación -->
                            <?php if (session('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('login/procesar') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-4">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control input-estetico" id="email" name="email"
                                        placeholder="tu@email.com" value="<?= old('email') ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control input-estetico" id="password" name="password"
                                        placeholder="Ingresa tu contraseña" required>
                                </div>

                                <button type="submit" class="btn btn-login w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </button>
                            </form>
                        </div>

                        <div class="card-footer">
                            ¿No tienes cuenta?
                            <a href="<?= base_url('registro') ?>">Regístrate aquí</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>