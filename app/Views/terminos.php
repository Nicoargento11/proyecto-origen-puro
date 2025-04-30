<!-- Hero Section -->
<section class="hero-terms text-black" style="padding-top: 15vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-3 fw-bold mb-4">Términos y Condiciones</h1>
                <p class="lead">Última actualización: <?= $fechaActualizacion ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Términos y Condiciones -->
<section class="py-5">
    <div class="container">
        <div class="terms-container p-4 p-lg-5">
            <?php foreach ($terminos as $termino): ?>
                <div class="term-section" id="<?= $termino['id'] ?>">
                    <h2 class="term-title fw-bold mb-4"><?= $termino['titulo'] ?></h2>
                    <?= $termino['contenido'] ?>
                </div>
            <?php endforeach; ?>

            <div class="term-section">
                <h2 class="term-title fw-bold mb-4">Contacto</h2>
                <p>Para cualquier pregunta sobre estos términos, contáctenos a través de:</p>
                <ul>
                    <li>Email: <?= $supportEmail ?></li>
                    <li>Teléfono: <?= $contactPhone ?></li>
                    <li>Dirección: <?= $companyAddress ?></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Botón para volver arriba -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="bi bi-arrow-up"></i>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>