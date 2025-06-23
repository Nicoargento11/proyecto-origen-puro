<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Café de Especialidad | Origen Puro' ?></title>
    <!-- Bootstrap + Font Awesome -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
        :root {
            --cafe-oscuro: #4A2E1D;
            /* Color principal del café en la imagen */
            --cafe-mediio: #6F4E37;
            /* Tonos medios de los granos */
            --beige: #E6D5C3;
            /* Color del croissant */
            --dorado: #D4A762;
            /* Reflejos dorados */
            --crema: #F5F0E6;
            /* Color de la espuma */
        }

        /* Compensar altura de navbar fija */
        body {
            padding-top: 50px !important;
            /* Altura ajustada de la navbar */
        }

        /* Asegurar que las primeras secciones tengan espaciado correcto */
        body>.hero-section:first-child,
        body>.py-5:first-child,
        body>.container:first-child,
        body>.section:first-child {
            margin-top: 0 !important;
            /* padding-top: 20px !important; */
        }

        /* Compensación específica para pantallas móviles */
        @media (max-width: 767.98px) {
            body {
                padding-top: 90px !important;
                /* Navbar más alta en móvil */
            }
        }

        .navbar {
            background-color: var(--cafe-oscuro);
            border-bottom: 2px solid var(--dorado);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background-color: rgba(74, 46, 29, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .navbar-brand img {
            transition: transform 0.3s;
        }

        .navbar-brand:hover img {
            transform: rotate(-15deg);
        }

        .nav-link {
            color: var(--beige) !important;
            font-weight: 500;
            position: relative;
            margin: 0 5px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--dorado);
            transition: width 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .dropdown-menu {
            background-color: var(--cafe-oscuro);
            border: 1px solid var(--dorado);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: var(--beige);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--dorado);
            color: var(--cafe-oscuro);
        }

        .dropdown-item.text-warning:hover {
            background-color: #ffc107;
            color: var(--cafe-oscuro);
        }

        .dropdown-divider {
            border-color: var(--dorado);
            opacity: 0.5;
        }

        .btn-search {
            background-color: transparent;
            border-color: var(--beige);
            color: var(--beige);
        }

        .btn-search:hover {
            background-color: var(--dorado);
            border-color: var(--dorado);
        }

        .btn-auth {
            border: 1px solid var(--dorado);
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: transparent;
            color: var(--dorado);
        }

        .btn-login:hover {
            background-color: var(--dorado);
            color: var(--cafe-oscuro);
        }

        .btn-register {
            background-color: var(--dorado);
            color: var(--cafe-oscuro);
        }

        .btn-register:hover {
            background-color: transparent;
            color: var(--dorado);
        }

        .badge {
            background-color: var(--dorado) !important;
            color: var(--cafe-oscuro) !important;
        }

        @media (max-width: 991.98px) {
            .auth-buttons {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid rgba(212, 167, 98, 0.3);
            }

            .btn-auth {
                margin-left: 0;
                margin-right: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <!-- Logo + Nombre --> <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/img/coffee.png') ?>" alt="Logo" width="40" height="40" class="me-2">
                <span class="fw-bold" style="color: var(--dorado)">Origen Puro</span>
            </a>

            <!-- Botón móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Menú principal -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('productos') ?>">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('comercializacion') ?>">Comercializacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('quienes-somos') ?>">Quienes somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contacto') ?>">Contacto</a>
                    </li>
                </ul> <!-- Botones de autenticación -->
                <?php if (session()->get('logged_in')): ?>
                    <div class="auth-buttons d-flex">
                        <a href="<?= base_url('carrito') ?>" class="btn btn-auth btn-login position-relative me-2">
                            <i class="fas fa-shopping-cart me-1"></i> Carrito
                            <span class="carrito-contador badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" style="display: none;">0</span>
                        </a>
                        <!-- Dropdown de Perfil -->
                        <div class="dropdown me-2">
                            <button class="btn btn-auth btn-login dropdown-toggle" type="button" id="perfilDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> Perfil
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="perfilDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="fas fa-user me-2"></i>Ver Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('mis-pedidos') ?>"><i class="fas fa-shopping-bag me-2"></i>Mis Pedidos</a></li>

                                <!-- Opción Admin (solo si es admin) -->
                                <?php if (session()->get('rol') === 'admin'): ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-warning" href="<?= base_url('admin') ?>"><i class="fas fa-cogs me-2"></i>Panel Admin</a></li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="auth-buttons d-flex">
                        <a href="<?= base_url('login') ?>" class="btn btn-login btn-auth">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                        <a href="<?= base_url('registro') ?>" class="btn btn-register btn-auth">
                            <i class="fas fa-user-plus me-1"></i> Registrarse
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        // Inicializar Bootstrap cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap !== 'undefined') {
                // Inicializar dropdowns manualmente si es necesario
                const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                const dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
            }
        });
    </script>

    <?php if (session()->get('logged_in')): ?>
        <script>
            // Función global para actualizar contador del carrito
            function actualizarContadorCarrito() {
                fetch('<?= base_url('carrito/conteo') ?>')
                    .then(response => response.json())
                    .then(data => {
                        const contador = document.querySelector('.carrito-contador');
                        if (contador && data.success) {
                            if (data.cantidad > 0) {
                                contador.textContent = data.cantidad;
                                contador.style.display = 'inline';
                            } else {
                                contador.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener conteo del carrito:', error);
                    });
            }

            // Actualizar contador del carrito al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                actualizarContadorCarrito();
            });
        </script>
    <?php endif; ?>