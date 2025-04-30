<style>
    /* Estilos generales */
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        overflow-x: hidden;
        color: #333;
    }

    /* Navbar */
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
        transform: rotate(15deg);
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

    /* Estilos para el hero con imagen */
    .hero-image {
        height: 100vh;
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        /* Corte diagonal */
        margin-bottom: -10vh;
        /* Empuja la siguiente sección hacia arriba */
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .hero-background img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .hero-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
    }

    /* Secciones */
    .section {
        padding: 6rem 0;
        position: relative;
    }

    /* Cards de productos */
    .card-cafe {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
    }

    .card-cafe:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(74, 46, 29, 0.3);
    }

    .card-cafe:hover img {
        transform: scale(1.05);
    }

    /* Botones */
    .btn-cafe {
        background-color: var(--dorado);
        color: var(--cafe-oscuro);
        font-weight: 600;
        border: none;
    }

    .btn-cafe:hover {
        background-color: var(--beige);
        color: var(--cafe-oscuro);
    }

    .btn-outline-cafe {
        border: 2px solid var(--beige);
        color: var(--beige);
        background-color: transparent;
    }

    .btn-outline-cafe:hover {
        background-color: var(--beige);
        color: var(--cafe-oscuro);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section {
            padding: 4rem 0;
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-content p.lead {
            font-size: 1.25rem;
        }
    }
</style>


<!-- Hero Section -->
<section class="hero-image">
    <div class="hero-background">
        <img src="assets/img/background-coffee-3.jpg" alt="Café de especialidad" class="w-100 h-100 object-fit-cover">
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content text-center text-white container">
        <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Descubre el Alma del Café</h1>
        <p class="lead fs-2 mb-5 animate__animated animate__fadeInUp animate__delay-1s">Directo de las montañas a tu taza</p>
        <a href="#cafes" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-pill animate__animated animate__fadeIn animate__delay-2s">
            <i class="fas fa-coffee me-2"></i> Explorar Cafés
        </a>
    </div>
</section>

<!-- Sección Orígenes -->
<section id="origenes" class="section" style="background: linear-gradient(to right, var(--crema), var(--beige));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="display-4 fw-bold mb-4" style="color: var(--cafe-oscuro);">De la Tierra a tu Paladar</h2>
                <p class="lead mb-4" style="color: var(--cafe-medio);">Trabajamos directamente con pequeños productores en Latinoamérica y África.</p>
                <div class="d-flex mb-4">
                    <i class="fas fa-mountain fs-1 me-4" style="color: var(--dorado);"></i>
                    <div>
                        <h3 class="h4" style="color: var(--cafe-oscuro);">Altitud Perfecta</h3>
                        <p style="color: var(--cafe-medio);">Cultivado entre 1,200 y 2,000 msnm para un perfil de taza complejo.</p>
                    </div>
                </div>
                <a href="<?= base_url('comercializacion') ?>" class="btn btn-cafe btn-lg px-4">
                    Conoce a los Productores
                </a>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('assets/img/origenes-cafe.jpg') ?>" alt="Finca de café" class="img-fluid rounded-4 shadow" loading="lazy" style="border: 8px solid white; box-shadow: 0 10px 30px rgba(74, 46, 29, 0.2);">
            </div>
        </div>
    </div>
</section>

<!-- Sección Cafés -->
<section id="cafes" class="section" style="background-color: var(--cafe-oscuro);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold mb-3" style="color: var(--beige);">Nuestra Selección</h2>
            <p class="lead mx-auto" style="color: var(--dorado); max-width: 600px;">Descubre perfiles únicos de nuestras fincas asociadas</p>
        </div>

        <div class="row g-4">
            <!-- Café 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-cafe h-100 border-0 overflow-hidden">
                    <div class="overflow-hidden" style="height: 200px;">
                        <img src="<?= base_url('assets/img/cafe-etiopia.jpg') ?>" class="card-img-top w-100 h-100 object-cover" alt="Etiopía">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--crema);">Etiopía Yirgacheffe</h5>
                        <p class="small mb-1" style="color: var(--dorado);"><i class="fas fa-mountain me-2"></i>1,850 msnm</p>
                        <p class="mb-3" style="color: var(--beige);">Notas: Bergamota, jazmín y melocotón.</p>
                        <a href="#" class="btn btn-cafe btn-sm w-100">
                            Añadir al carrito
                        </a>
                    </div>
                </div>
            </div>

            <!-- Café 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-cafe h-100 border-0 overflow-hidden">
                    <div class="overflow-hidden" style="height: 200px;">
                        <img src="<?= base_url('assets/img/cafe-colombia.jpg') ?>" class="card-img-top w-100 h-100 object-cover" alt="Colombia">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--crema);">Colombia Huila</h5>
                        <p class="small mb-1" style="color: var(--dorado);"><i class="fas fa-mountain me-2"></i>1,600 msnm</p>
                        <p class="mb-3" style="color: var(--beige);">Notas: Chocolate negro y caramelo.</p>
                        <a href="#" class="btn btn-cafe btn-sm w-100">
                            Añadir al carrito
                        </a>
                    </div>
                </div>
            </div>

            <!-- Café 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-cafe h-100 border-0 overflow-hidden">
                    <div class="overflow-hidden" style="height: 200px;">
                        <img src="<?= base_url('assets/img/cafe-brasil.jpg') ?>" class="card-img-top w-100 h-100 object-cover" alt="Brasil">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--crema);">Brasil Cerrado</h5>
                        <p class="small mb-1" style="color: var(--dorado);"><i class="fas fa-mountain me-2"></i>1,200 msnm</p>
                        <p class="mb-3" style="color: var(--beige);">Notas: Avellana y azúcar moreno.</p>
                        <a href="#" class="btn btn-cafe btn-sm w-100">
                            Añadir al carrito
                        </a>
                    </div>
                </div>
            </div>

            <!-- Café 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-cafe h-100 border-0 overflow-hidden">
                    <div class="overflow-hidden" style="height: 200px;">
                        <img src="<?= base_url('assets/img/cafe-blend.jpg') ?>" class="card-img-top w-100 h-100 object-cover" alt="Blend">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--crema);">Blend Especial</h5>
                        <p class="small mb-1" style="color: var(--dorado);"><i class="fas fa-blend me-2"></i>Mezcla exclusiva</p>
                        <p class="mb-3" style="color: var(--beige);">Notas: Frutos rojos y especias dulces.</p>
                        <a href="#" class="btn btn-cafe btn-sm w-100">
                            Añadir al carrito
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-cafe btn-lg px-4 py-2 fw-bold rounded-pill">
                Ver toda la selección <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Sección Experiencia -->
<section id="experiencia" class="section" style="background: linear-gradient(to left, var(--crema), var(--beige));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0">
                <div class="position-relative">
                    <img src="<?= base_url('assets/img/experiencia-cafe.jpg') ?>" alt="Experiencia café" class="img-fluid rounded-4 shadow" loading="lazy" style="border: 8px solid white; box-shadow: 0 10px 30px rgba(74, 46, 29, 0.2);">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(212, 167, 98, 0.1); border-radius: 16px; z-index: 0;"></div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h2 class="display-4 fw-bold mb-4" style="color: var(--cafe-oscuro);">Más que Café, una Cultura</h2>
                <div class="d-flex mb-4">
                    <div class="me-4" style="color: var(--dorado);">
                        <i class="fas fa-coffee fs-1"></i>
                    </div>
                    <div>
                        <h3 class="h4" style="color: var(--cafe-oscuro);">Cataciones Mensuales</h3>
                        <p style="color: var(--cafe-medio);">Aprende a distinguir sabores como un profesional.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-4" style="color: var(--dorado);">
                        <i class="fas fa-book fs-1"></i>
                    </div>
                    <div>
                        <h3 class="h4" style="color: var(--cafe-oscuro);">Biblioteca Cafetera</h3>
                        <p style="color: var(--cafe-medio);">Material educativo sobre métodos de preparación.</p>
                    </div>
                </div>
                <a href="<?= base_url('eventos') ?>" class="btn btn-lg px-4" style="background-color: var(--cafe-oscuro); color: var(--beige);">
                    Ver Eventos
                </a>
            </div>
        </div>
    </div>
</section>