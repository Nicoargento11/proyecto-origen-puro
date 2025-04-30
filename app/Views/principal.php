<style>
  /* Estilo general "seamless" */


  /* Hero con video */
  .hero-video {
    height: 100vh;
    position: relative;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
    margin-bottom: -10vh;
  }

  .hero-video video {
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
  }

  /* Secciones fluidas */
  .section {
    padding: 8rem 0;
    position: relative;
  }

  .section-cafe {
    background: linear-gradient(to bottom, var(--cafe-oscuro), var(--cafe-medio));
    color: white;
  }

  .section-beige {
    background: linear-gradient(to bottom, var(--cafe-medio), var(--beige));
    color: var(--cafe-oscuro);
  }

  /* Cards de productos */
  .card-cafe {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
  }

  .card-cafe:hover {
    transform: translateY(-10px);
  }

  /* Botones */
  .btn-dorado {
    background-color: var(--dorado);
    color: var(--cafe-oscuro);
    font-weight: 600;
  }
</style>



<!-- Hero con Video -->
<!-- Hero con Imagen -->
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

<style>
  /* Estilos para el hero con imagen */
  .hero-image {
    height: 100vh;
    position: relative;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
    margin-bottom: -10vh;
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
    /* Ajusta la opacidad del overlay aquí */
  }

  .hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
  }
</style>

<!-- Sección Orígenes -->
<section id="origenes" class="" style="background: linear-gradient(to right, #F5F0E6, #E6D5C3); padding-top: 15vh; padding-bottom: 10vh;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <h2 class="display-4 fw-bold mb-4" style="color: #4A2E1D;">De la Tierra a tu Paladar</h2>
        <p class="lead mb-4" style="color: #6F4E37;">Trabajamos directamente con pequeños productores en Latinoamérica y África.</p>
        <div class="d-flex mb-4">
          <i class="fas fa-mountain fs-1 me-4" style="color: #D4A762;"></i>
          <div>
            <h3 class="h4" style="color: #4A2E1D;">Altitud Perfecta</h3>
            <p style="color: #6F4E37;">Cultivado entre 1,200 y 2,000 msnm para un perfil de taza complejo.</p>
          </div>
        </div>

      </div>
      <div class="col-lg-6">
        <img src="assets/img/origenes-cafe.jpg" alt="Finca de café" class="img-fluid rounded-4 shadow" loading="lazy" style="border: 8px solid white; box-shadow: 0 10px 30px rgba(74, 46, 29, 0.2);">
      </div>
    </div>
  </div>
</section>

<!-- Sección Cafés - Actualizada -->
<section id="cafes" class="" style="background-color: #4A2E1D; padding: 10vh;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-4 fw-bold mb-3" style="color: #E6D5C3;">Nuestra Selección</h2>
      <p class="lead mx-auto" style="color: #D4A762; max-width: 600px;">Descubre perfiles únicos de nuestras fincas asociadas</p>
    </div>

    <div class="row g-4">
      <!-- Café 1 -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px); transition: all 0.3s;">
          <div class="overflow-hidden" style="height: 200px;">
            <img src="assets/img/cafe-etiopia.jpg" class="card-img-top w-100 h-100 object-cover" alt="Etiopía" style="transition: transform 0.5s;">
          </div>
          <div class="card-body">
            <h5 class="card-title" style="color: #F5F0E6;">Etiopía Yirgacheffe</h5>
            <p class="small mb-1" style="color: #D4A762;"><i class="fas fa-mountain me-2"></i>1,850 msnm</p>
            <p class="mb-3" style="color: #E6D5C3;">Notas: Bergamota, jazmín y melocotón.</p>
            <!-- <a href="#" class="btn btn-sm w-100" style="background-color: #D4A762; color: #4A2E1D; font-weight: 600;">
              Añadir al carrito
            </a> -->
          </div>
        </div>
      </div>

      <!-- Café 2 -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px); transition: all 0.3s;">
          <div class="overflow-hidden" style="height: 200px;">
            <img src="assets/img/cafe-colombia.jpg" class="card-img-top w-100 h-100 object-cover" alt="Colombia" style="transition: transform 0.5s;">
          </div>
          <div class="card-body">
            <h5 class="card-title" style="color: #F5F0E6;">Colombia Huila</h5>
            <p class="small mb-1" style="color: #D4A762;"><i class="fas fa-mountain me-2"></i>1,600 msnm</p>
            <p class="mb-3" style="color: #E6D5C3;">Notas: Chocolate negro y caramelo.</p>
            <!-- <a href="#" class="btn btn-sm w-100" style="background-color: #D4A762; color: #4A2E1D; font-weight: 600;">
              Añadir al carrito
            </a> -->
          </div>
        </div>
      </div>

      <!-- Café 3 -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px); transition: all 0.3s;">
          <div class="overflow-hidden" style="height: 200px;">
            <img src="assets/img/cafe-brasil.jpg" class="card-img-top w-100 h-100 object-cover" alt="Brasil" style="transition: transform 0.5s;">
          </div>
          <div class="card-body">
            <h5 class="card-title" style="color: #F5F0E6;">Brasil Cerrado</h5>
            <p class="small mb-1" style="color: #D4A762;"><i class="fas fa-mountain me-2"></i>1,200 msnm</p>
            <p class="mb-3" style="color: #E6D5C3;">Notas: Avellana y azúcar moreno.</p>
            <!-- <a href="#" class="btn btn-sm w-100" style="background-color: #D4A762; color: #4A2E1D; font-weight: 600;">
              Añadir al carrito
            </a> -->
          </div>
        </div>
      </div>

      <!-- Café 4 -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px); transition: all 0.3s;">
          <div class="overflow-hidden" style="height: 200px;">
            <img src="assets/img/cafe-blend.jpg" class="card-img-top w-100 h-100 object-cover" alt="Blend" style="transition: transform 0.5s;">
          </div>
          <div class="card-body">
            <h5 class="card-title" style="color: #F5F0E6;">Blend Especial</h5>
            <p class="small mb-1" style="color: #D4A762;"><i class="fas fa-blend me-2"></i>Mezcla exclusiva</p>
            <p class="mb-3" style="color: #E6D5C3;">Notas: Frutos rojos y especias dulces.</p>
            <!-- <a href="#" class="btn btn-sm w-100" style="background-color: #D4A762; color: #4A2E1D; font-weight: 600;">
              Añadir al carrito
            </a> -->
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <!-- <a href="<?= base_url('catalogo') ?>" class="btn btn-lg px-4 py-2 fw-bold rounded-pill" style="background-color: transparent; border: 2px solid #E6D5C3; color: #E6D5C3;">
        Ver toda la selección <i class="fas fa-arrow-right ms-2"></i>
      </a> -->
    </div>
  </div>
</section>

<!-- Sección Experiencia - Actualizada -->
<!-- <section id="experiencia" class="py-6" style="background: linear-gradient(to left, #F5F0E6, #E6D5C3); padding: 10vh">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0">
        <div class="position-relative">
          <img src="assets/img/experiencia-cafe.jpg" alt="Experiencia café" class="img-fluid rounded-4 shadow" loading="lazy" style="border: 8px solid white; box-shadow: 0 10px 30px rgba(74, 46, 29, 0.2);">
          <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(212, 167, 98, 0.1); border-radius: 16px; z-index: 0;"></div>
        </div>
      </div>
      <div class="col-lg-6 order-lg-1">
        <h2 class="display-4 fw-bold mb-4" style="color: #4A2E1D;">Más que Café, una Cultura</h2>
        <div class="d-flex mb-4">
          <div class="me-4" style="color: #D4A762;">
            <i class="fas fa-coffee fs-1"></i>
          </div>
          <div>
            <h3 class="h4" style="color: #4A2E1D;">Cataciones Mensuales</h3>
            <p style="color: #6F4E37;">Aprende a distinguir sabores como un profesional.</p>
          </div>
        </div>
        <div class="d-flex mb-4">
          <div class="me-4" style="color: #D4A762;">
            <i class="fas fa-book fs-1"></i>
          </div>
          <div>
            <h3 class="h4" style="color: #4A2E1D;">Biblioteca Cafetera</h3>
            <p style="color: #6F4E37;">Material educativo sobre métodos de preparación.</p>
          </div>
        </div>
        <!-- <a href="<?= base_url('eventos') ?>" class="btn btn-lg px-4" style="background-color: #4A2E1D; color: #E6D5C3;">
          Ver Eventos
        </a> -->
</div>
</div>
</div>
</section>

<style>
  /* Efectos hover para las cards */
  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(74, 46, 29, 0.3);
  }

  .card:hover img {
    transform: scale(1.05);
  }

  /* Transiciones suaves */
  .card,
  .card img {
    transition: all 0.3s ease-out;
  }
</style>


<!-- Scripts -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
<script>
  // Navbar cambia al hacer scroll
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>