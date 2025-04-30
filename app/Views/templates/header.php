<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Café de Especialidad | Origen Puro' ?></title>
    <!-- Bootstrap + Font Awesome -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
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
        }

        .dropdown-item {
            color: var(--beige);
        }

        .dropdown-item:hover {
            background-color: var(--cafe-mediio);
            color: var(--dorado);
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

        /* .form-control {
            background-color: rgba(230, 213, 195, 0.1) !important;
            color: var(--beige) !important;
            border-color: var(--beige);
        }

        .form-control::placeholder {
            color: var(--beige);
            opacity: 0.7;
        } */

        .badge {
            background-color: var(--dorado) !important;
            color: var(--cafe-oscuro) !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <!-- Logo + Nombre -->
            <a class="navbar-brand d-flex align-items-center" href="/pruebacodeneigter">
                <img src="assets/img/coffee.png" alt="Logo" width="40" height="40" class="me-2">
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
                        <a class="nav-link" href="/pruebacodeneigter">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comercializacion">Comercializacion</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="catalogo">Catálogo</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="quienes-somos">Quienes somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto">Contacto</a>
                    </li>
                </ul>

                <!-- Buscador + Carrito -->
                <!-- <div class="d-flex align-items-center">
                    <form class="d-flex me-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar café..." aria-label="Search">
                        <button class="btn btn-search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <a href="carrito" class="btn btn-outline-light position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill">3</span>
                    </a>
                </div> -->
            </div>
        </div>
    </nav>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto navbar al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>