<?= $this->include('templates/header') ?>

<!-- Estilos específicos para quienes somos -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --beige: #E6D5C3;
        --dorado: #D4A762;
        --crema: #F5F0E6;
    }

    .hero-about {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('assets/img/background-coffee-2.jpg');
        background-size: cover;
        background-position: center;
        min-height: 70vh;
        display: flex;
        align-items: center;
        padding-top: 15vh;
    }

    .team-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
        border-radius: 15px;
        background-color: rgba(230, 213, 195, 0.1);
        backdrop-filter: blur(5px);
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .team-img {
        height: 300px;
        object-fit: cover;
        object-position: top;
        transition: transform 0.5s;
    }

    .team-card:hover .team-img {
        transform: scale(1.05);
    }

    .history-img {
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .divider {
        height: 3px;
        background: linear-gradient(to right, transparent, var(--dorado), transparent);
        margin: 3rem 0;
        opacity: 0.5;
    }

    .bg-cafe-medio {
        background-color: var(--cafe-medio);
    }

    .text-beige {
        color: var(--beige);
    }

    .text-dorado {
        color: var(--dorado);
    }

    .btn-outline-beige {
        border: 2px solid var(--beige);
        color: var(--beige);
    }

    .btn-outline-beige:hover {
        background-color: var(--beige);
        color: var(--cafe-oscuro);
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background-color: rgba(212, 167, 98, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
</style>

<!-- Hero Section -->
<section class="hero-about text-white">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-3 fw-bold mb-4" style="color: var(--beige);">Nuestra Pasión por el Café</h1>
                <p class="lead fs-2 mb-5" style="color: var(--dorado);">Desde 2025 cultivando experiencias, no solo café</p>
                <a href="#nuestra-historia" class="btn btn-outline-beige btn-lg px-4 py-3 rounded-pill fw-bold">
                    <i class="bi bi-arrow-down-circle me-2"></i>Conoce más
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Nuestra Historia -->
<section id="nuestra-historia" class="py-5" style="background-color: var(--crema);">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold mb-4" style="color: var(--cafe-oscuro);">De las montañas a tu taza</h2>
                <p class="lead mb-4" style="color: var(--cafe-medio);">Todo comenzó en una pequeña finca familiar en las montañas de Colombia, donde aprendimos que el buen café es el resultado de paciencia, dedicación y respeto por la tierra.</p>

                <div class="d-flex mb-4">
                    <div class="me-4">
                        <div class="icon-box">
                            <i class="bi bi-tree-fill fs-3" style="color: var(--dorado);"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="h4" style="color: var(--cafe-oscuro);">Cultivo Sostenible</h3>
                        <p class="mb-0" style="color: var(--cafe-medio);">Trabajamos con agricultores que practican agricultura regenerativa, protegiendo el ecosistema.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="me-4">
                        <div class="icon-box">
                            <i class="bi bi-people-fill fs-3" style="color: var(--dorado);"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="h4" style="color: var(--cafe-oscuro);">Comercio Justo</h3>
                        <p class="mb-0" style="color: var(--cafe-medio);">Pagamos precios justos directamente a los productores, eliminando intermediarios.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="assets/img/origenes-cafe.jpg" class="img-fluid history-img" alt="Nuestra historia">
            </div>
        </div>
    </div>
</section>

<!-- Divider -->
<div class="divider"></div>

<!-- Nuestro Proceso -->
<section class="py-5" style="background-color: var(--crema);">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: var(--cafe-oscuro);">El Arte del Café de Especialidad</h2>
            <p class="lead mx-auto" style="color: var(--cafe-medio); max-width: 600px;">Cada etapa de nuestro proceso está diseñada para resaltar lo mejor de cada grano</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px);">
                    <div class="card-body text-center p-4">
                        <div class="icon-box mx-auto">
                            <i class="bi bi-flower1 fs-3" style="color: var(--cafe-medio);"></i>
                        </div>
                        <h3 style="color: var(--cafe-medio);">Selección</h3>
                        <p style="color: var(--cafe-medio);">Elegimos solo los lotes con puntaje superior a 85 puntos SCA</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px);">
                    <div class="card-body text-center p-4">
                        <div class="icon-box mx-auto">
                            <i class="bi bi-thermometer-sun fs-3" style="color: var(--cafe-medio);"></i>
                        </div>
                        <h3 style="color: var(--cafe-medio);">Tueste</h3>
                        <p style="color: var(--cafe-medio);">Tostamos en pequeñas cantidades para control perfecto del perfil</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px);">
                    <div class="card-body text-center p-4">
                        <div class="icon-box mx-auto">
                            <i class="bi bi-cup-hot fs-3" style="color: var(--cafe-medio);"></i>
                        </div>
                        <h3 style="color: var(--cafe-medio);">Pruebas</h3>
                        <p style="color: var(--cafe-medio);">Cada lote es catado por nuestro equipo de Q-Graders</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px);">
                    <div class="card-body text-center p-4">
                        <div class="icon-box mx-auto">
                            <i class="bi bi-truck fs-3" style="color: var(--cafe-medio);"></i>
                        </div>
                        <h3 style="color: var(--cafe-medio);">Envío</h3>
                        <p style="color: var(--cafe-medio);">Empacamos y enviamos el mismo día del tostado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nuestro Equipo -->
<!-- <section class="py-5" style="background-color: var(--cafe-oscuro);">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="color: var(--beige);">Conoce al Equipo</h2>
                <p class="lead mx-auto" style="color: var(--dorado); max-width: 600px;">Los apasionados detrás de cada taza</p>
            </div>

            <div class="row g-4">

            </div>
        </div>
    </section> -->

<!-- CTA -->
<section class="py-5" style="background-color: var(--cafe-medio);">
    <div class="container py-4 text-center">
        <h2 class="display-5 fw-bold mb-4" style="color: var(--beige);">¿Listo para vivir la experiencia?</h2>
        <p class="lead mb-5 mx-auto" style="color: var(--dorado); max-width: 600px;">Visita nuestra tienda física o conoce más sobre nuestros cafés de especialidad</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="<?= site_url('contacto') ?>" class="btn btn-lg px-4 py-2 fw-bold rounded-pill" style="background-color: var(--dorado); color: var(--cafe-oscuro);">
                <i class="bi bi-geo-alt me-2"></i> Visítanos
            </a>
            <!-- <a href="<?= site_url('nuestros-cafes') ?>" class="btn btn-outline-beige btn-lg px-4 py-2 fw-bold rounded-pill">
                    <i class="bi bi-cup-hot me-2"></i> Nuestros Cafés
                </a> -->
        </div>
    </div>
</section>

<?= $this->include('templates/footer') ?>