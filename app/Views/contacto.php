<?= $this->include('templates/header') ?>

<!-- Estilos específicos para contacto -->
<style>
    :root {
        --cafe-oscuro: #4A2E1D;
        --cafe-medio: #6F4E37;
        --beige: #E6D5C3;
        --dorado: #D4A762;
        --crema: #F5F0E6;
    }

    .hero-contact {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('assets/img/background-coffee-1.jpg');
        background-size: cover;
        background-position: center;
        min-height: 40vh;
        display: flex;
        align-items: center;
        padding-top: 15vh;
    }

    .contact-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: white;
        overflow: hidden;
        color: var(--cafe-oscuro);
    }

    .contact-header {
        background-color: var(--cafe-oscuro);
        color: var(--beige);
        padding: 1.5rem;
        text-align: center;
    }

    .contact-form {
        padding: 2rem;
        color: var(--cafe-oscuro);
    }

    .form-control,
    .form-select {
        border: 1px solid var(--beige);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        color: #4A2E1D;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--dorado);
        box-shadow: 0 0 0 0.25rem rgba(212, 167, 98, 0.25);
    }

    .btn-cafe {
        background-color: var(--dorado);
        color: var(--cafe-oscuro);
        border: none;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-cafe:hover {
        background-color: var(--cafe-medio);
        color: white;
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 8px;
    }

    .contact-info {
        background-color: var(--beige);
        padding: 2rem;
        border-radius: 0 15px 15px 0;
    }

    .info-item {
        margin-bottom: 1.5rem;
    }

    .info-icon {
        color: var(--dorado);
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    @media (max-width: 767.98px) {
        .contact-info {
            border-radius: 0 0 15px 15px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-contact text-white">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Contáctanos</h1>
        <p class="lead">Estamos aquí para atenderte</p>
    </div>
</section>

<!-- Contenido principal -->
<section class="py-5">
    <div class="container contact-container">
        <!-- Mostrar mensaje de éxito o error -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success text-center mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success')['message'] ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <div class="row g-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Formulario -->
            <div class="col-lg-7">
                <div class="contact-card h-100">
                    <div class="contact-header">
                        <h2 class="h3 mb-0"><i class="bi bi-envelope me-2"></i> Escríbenos</h2>
                    </div>
                    <div class="contact-form">
                        <form action="<?= base_url('contacto/enviar') ?>" method="post">
                            <div class="mb-4">
                                <label for="nombre" class="form-label fw-bold">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-4">
                                <label for="asunto" class="form-label fw-bold">Asunto</label>
                                <select class="form-select" id="asunto" name="asunto" required>
                                    <option value="" selected disabled>Selecciona un asunto</option>
                                    <option value="consulta">Consulta general</option>
                                    <option value="reserva">Reserva de mesa</option>
                                    <option value="evento">Eventos privados</option>
                                    <option value="productos">Sobre nuestros productos</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="mensaje" class="form-label fw-bold text-black">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" style="resize: none; color: black;" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-cafe btn-lg">
                                    <i class="bi bi-send-fill me-2"></i> Enviar Mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="h-100 contact-info">
                    <h3 class="h4 mb-4 fw-bold"><i class="bi bi-info-circle me-2"></i> Información de contacto</h3>

                    <div class="info-item d-flex">
                        <i class="bi bi-geo-alt-fill info-icon"></i>
                        <div>
                            <h4 class="h6 fw-bold mb-1">Dirección</h4>
                            <p class="mb-0">Av. del Café 123, Buenos Aires</p>
                        </div>
                    </div>

                    <div class="info-item d-flex">
                        <i class="bi bi-telephone-fill info-icon"></i>
                        <div>
                            <h4 class="h6 fw-bold mb-1">Teléfono</h4>
                            <p class="mb-0">+54 11 1234-5678</p>
                        </div>
                    </div>

                    <div class="info-item d-flex">
                        <i class="bi bi-envelope-fill info-icon"></i>
                        <div>
                            <h4 class="h6 fw-bold mb-1">Email</h4>
                            <p class="mb-0">contacto@origenpuro.com</p>
                        </div>
                    </div>

                    <!-- <div class="info-item d-flex">
                            <i class="bi bi-clock-fill info-icon"></i>
                            <div>
                                <h4 class="h6 fw-bold mb-1">Horario</h4>
                                <p class="mb-0">Lunes a Viernes: 8:00 - 20:00<br>
                                    Sábados: 9:00 - 18:00</p>
                            </div>
                        </div> -->

                    <hr class="my-4">

                    <h4 class="h6 fw-bold mb-3">Síguenos</h4>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-4" style="color: var(--cafe-oscuro);"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-instagram fs-4" style="color: var(--cafe-oscuro);"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-whatsapp fs-4" style="color: var(--cafe-oscuro);"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer') ?>