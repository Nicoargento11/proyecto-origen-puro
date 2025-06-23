<?= $this->include('templates/header') ?>

<!-- Estilos específicos para comercialización -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --beige: #E6D5C3;
        --dorado: #D4A762;
        --crema: #F5F0E6;
    }

    .hero-commercial {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('assets/img/commercial-hero.jpg');
        background-size: cover;
        background-position: center;
        min-height: 60vh;
        display: flex;
        align-items: center;
        padding-top: 15vh;
    }

    .process-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        background-color: rgba(230, 213, 195, 0.1);
        backdrop-filter: blur(5px);
        height: 100%;
    }

    .process-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background-color: rgba(212, 167, 98, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .payment-method {
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 1.5rem;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .payment-method:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    .certification-img {
        height: 80px;
        object-fit: contain;
        filter: grayscale(100%) brightness(0.8);
        transition: all 0.3s ease;
    }

    .certification-img:hover {
        filter: grayscale(0%) brightness(1);
    }
</style>

<!-- Hero Section -->
<section class="hero-commercial text-white" style="padding-bottom: 10vh">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-3 fw-bold mb-4" style="color: var(--beige);">Comercialización Ética</h1>
                <p class="lead fs-2 mb-5" style="color: var(--dorado);">Desde el productor hasta tu taza con transparencia</p>
                <a href="#proceso" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-bold">
                    <i class="bi bi-arrow-down-circle me-2"></i> Conoce nuestro proceso
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Proceso de Comercialización -->
<section id="proceso" class="py-5" style="background-color: var(--cafe-oscuro);">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: var(--beige);">Nuestro Proceso</h2>
            <p class="lead mx-auto" style="color: var(--dorado); max-width: 600px;">
                Cada paso está diseñado para garantizar calidad y sostenibilidad
            </p>
        </div>

        <div class="row g-4">
            <!-- Paso 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="process-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-box">
                            <span class="fs-3 fw-bold" style="color: var(--dorado);">1</span>
                        </div>
                        <h3 style="color: var(--beige);">Selección</h3>
                        <p style="color: var(--beige);">Visitas técnicas a fincas que cumplen nuestros estándares de cultivo</p>
                    </div>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="process-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-box">
                            <span class="fs-3 fw-bold" style="color: var(--dorado);">2</span>
                        </div>
                        <h3 style="color: var(--beige);">Contratación</h3>
                        <p style="color: var(--beige);">Acuerdos directos con precios justos y condiciones claras</p>
                    </div>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="process-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-box">
                            <span class="fs-3 fw-bold" style="color: var(--dorado);">3</span>
                        </div>
                        <h3 style="color: var(--beige);">Transporte</h3>
                        <p style="color: var(--beige);">Logística especializada para preservar la calidad del grano</p>
                    </div>
                </div>
            </div>

            <!-- Paso 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="process-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-box">
                            <span class="fs-3 fw-bold" style="color: var(--dorado);">4</span>
                        </div>
                        <h3 style="color: var(--beige);">Tueste</h3>
                        <p style="color: var(--beige);">Proceso artesanal en pequeños lotes para control de calidad</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Métodos de Pago -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3" style="color: var(--cafe-oscuro);">Métodos de Pago</h2>
            <p class="lead mx-auto" style="color: var(--cafe-medio); max-width: 600px;">
                Ofrecemos múltiples opciones para facilitar tus transacciones
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Tarjeta de Crédito -->
            <div class="col-6 col-md-4 col-lg-2">
                <div class="payment-method text-center">
                    <i class="bi bi-credit-card fs-1 mb-3" style="color: var(--dorado);"></i>
                    <h5 style="color: var(--cafe-oscuro);">Tarjetas</h5>
                    <p class="small" style="color: var(--cafe-medio);">Crédito/Débito</p>
                </div>
            </div>

            <!-- Transferencia -->
            <div class="col-6 col-md-4 col-lg-2">
                <div class="payment-method text-center">
                    <i class="bi bi-bank fs-1 mb-3" style="color: var(--dorado);"></i>
                    <h5 style="color: var(--cafe-oscuro);">Transferencia</h5>
                    <p class="small" style="color: var(--cafe-medio);">Bancaria</p>
                </div>
            </div>

            <!-- Efectivo -->
            <div class="col-6 col-md-4 col-lg-2">
                <div class="payment-method text-center">
                    <i class="bi bi-cash-coin fs-1 mb-3" style="color: var(--dorado);"></i>
                    <h5 style="color: var(--cafe-oscuro);">Efectivo</h5>
                    <p class="small" style="color: var(--cafe-medio);">En tienda</p>
                </div>
            </div>

            <!-- PayPal -->
            <div class="col-6 col-md-4 col-lg-2">
                <div class="payment-method text-center">
                    <i class="bi bi-paypal fs-1 mb-3" style="color: var(--dorado);"></i>
                    <h5 style="color: var(--cafe-oscuro);">PayPal</h5>
                    <p class="small" style="color: var(--cafe-medio);">Pago online</p>
                </div>
            </div>

            <!-- Cripto -->
            <div class="col-6 col-md-4 col-lg-2">
                <div class="payment-method text-center">
                    <i class="bi bi-currency-bitcoin fs-1 mb-3" style="color: var(--dorado);"></i>
                    <h5 style="color: var(--cafe-oscuro);">Criptomonedas</h5>
                    <p class="small" style="color: var(--cafe-medio);">Bitcoin, Ethereum</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<!-- <section class="py-5" style="background-color: var(--cafe-oscuro);">
        <div class="container py-4 text-center">
            <h2 class="display-5 fw-bold mb-4" style="color: var(--beige);">¿Eres productor y quieres trabajar con nosotros?</h2>
            <p class="lead mb-5 mx-auto" style="color: var(--dorado); max-width: 600px;">
                Únete a nuestra red de proveedores y comercializa tu café de manera justa
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="<?= site_url('contacto-productores') ?>" class="btn btn-lg px-4 py-2 fw-bold rounded-pill" style="background-color: var(--dorado); color: var(--cafe-oscuro);">
                    <i class="bi bi-person-lines-fill me-2"></i> Contactar
                </a>
                <a href="<?= site_url('requisitos') ?>" class="btn btn-outline-light btn-lg px-4 py-2 fw-bold rounded-pill">
                    <i class="bi bi-file-earmark-text me-2"></i> Ver requisitos
                </a>
            </div>
        </div>    </section> -->

<?= $this->include('templates/footer') ?>