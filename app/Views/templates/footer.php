<footer id="contacto" class="footer-cafe py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Logo y descripción -->
            <div class="col-lg-4 mb-4">
                <div class="footer-brand">
                    <img src="assets/img/coffee.png" alt="Origen Puro" height="50" class="mb-3">
                    <p class="footer-text">Café de especialidad tostado artesanalmente con pasión desde 2025.</p>
                    <!-- <div class="footer-newsletter mt-4">
                        <h4 class="h6 mb-3">Suscríbete a nuestro newsletter</h4>
                        <form class="d-flex">
                            <input type="email" class="form-control form-control-sm" placeholder="Tu correo electrónico">
                            <button type="submit" class="btn btn-sm btn-newsletter ms-2">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div> -->
                </div>
            </div>

            <!-- Contacto -->
            <div class="col-lg-4 mb-4">
                <div class="footer-contact">
                    <h3 class="h4 footer-title mb-4">Contacto</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt footer-icon me-2"></i>
                            <span>Calle del Café 123, Bogotá, Colombia</span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope footer-icon me-2"></i>
                            <a href="mailto:hola@origenpuro.com">hola@origenpuro.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone-alt footer-icon me-2"></i>
                            <a href="tel:+573001234567">+57 300 123 4567</a>
                        </li>
                        <li>
                            <i class="fas fa-clock footer-icon me-2"></i>
                            <span>Lun-Vie: 8am - 6pm / Sáb: 9am - 2pm</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Redes sociales y enlaces -->
            <div class="col-lg-4 mb-4">
                <div class="footer-social">
                    <h3 class="h4 footer-title mb-4">Síguenos</h3>
                    <div class="social-icons mb-4">
                        <a href="#" class="social-icon me-3" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon me-3" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon me-3" aria-label="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>

                    <h3 class="h4 footer-title mb-3">Enlaces rápidos</h3>
                    <ul class="footer-links list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('quienes-somos') ?>">Nuestra historia</a></li>
                        <li class="mb-2"><a href="terminos">Términos y condiciones</a></li>
                        <!-- <li><a href="<?= base_url('preguntas-frecuentes') ?>">Preguntas frecuentes</a></li> -->
                    </ul>
                </div>
            </div>
        </div>

        <hr class="footer-divider my-4">

        <div class="footer-bottom text-center pt-3">
            <p class="small mb-0">&copy; 2023 Origen Puro. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<style>
    /* Estilos del footer */
    .footer-cafe {
        background-color: #3E2723;
        /* Café oscuro */
        color: #E6D5C3;
        /* Beige claro */
    }

    .footer-title {
        color: #D4A762;
        /* Dorado */
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: #D4A762;
    }

    .footer-text {
        line-height: 1.6;
        opacity: 0.9;
    }

    .footer-icon {
        color: #D4A762;
        width: 20px;
        text-align: center;
    }

    .footer-contact a,
    .footer-links a {
        color: #E6D5C3;
        text-decoration: none;
        transition: all 0.3s;
    }

    .footer-contact a:hover,
    .footer-links a:hover {
        color: #D4A762;
        text-decoration: underline;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(212, 167, 98, 0.2);
        color: #E6D5C3;
        border-radius: 50%;
        transition: all 0.3s;
    }

    .social-icon:hover {
        background-color: #D4A762;
        color: #3E2723;
        transform: translateY(-3px);
    }

    .footer-divider {
        border-color: rgba(212, 167, 98, 0.3);
    }

    .btn-newsletter {
        background-color: #D4A762;
        color: #3E2723;
        border-radius: 4px;
    }

    .btn-newsletter:hover {
        background-color: #E6D5C3;
    }

    .form-control {
        background-color: rgba(230, 213, 195, 0.1);
        border-color: rgba(212, 167, 98, 0.3);
        color: #E6D5C3;
    }

    .form-control::placeholder {
        color: rgba(230, 213, 195, 0.7);
    }

    @media (max-width: 992px) {
        .footer-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-brand,
        .footer-contact,
        .footer-social {
            text-align: center;
        }

        .social-icons {
            justify-content: center;
        }
    }
</style>
</body>

</html>