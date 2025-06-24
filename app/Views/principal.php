<?php helper('text'); ?>
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

  .hero-image {
    height: 100vh;
    position: relative;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
    margin-bottom: -10vh;
    margin-top: -76px;
    /* Compensar altura de navbar fija */
    padding-top: 76px;
    /* Mantener contenido visible */
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

  /* Responsive grid para productos destacados en principal */
  @media (min-width: 576px) {
    .row.productos-grid>[class^="col-"] {
      flex: 0 0 auto;
      width: 50%;
    }
  }

  @media (min-width: 992px) {
    .row.productos-grid>[class^="col-"] {
      width: 25%;
    }
  }

  @media (max-width: 575.98px) {
    .row.productos-grid>[class^="col-"] {
      width: 100%;
    }
  }

  /* Scroll horizontal para productos destacados en principal */
  .productos-scroll {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 1.5rem;
    padding-bottom: 1rem;
    scrollbar-width: thin;
    scrollbar-color: #D4A762 #E6D5C3;
  }

  .productos-scroll>.col-md-6,
  .productos-scroll>.col-lg-3 {
    flex: 0 0 260px;
    max-width: 260px;
    min-width: 220px;
  }

  .productos-scroll::-webkit-scrollbar {
    height: 8px;
  }

  .productos-scroll::-webkit-scrollbar-thumb {
    background: #D4A762;
    border-radius: 4px;
  }

  .productos-scroll::-webkit-scrollbar-track {
    background: #E6D5C3;
  }
</style>



<!-- Hero con Video -->
<!-- Hero con Imagen -->
<section class="hero-image">
  <div class="hero-background">
    <img src="<?= base_url('assets/img/background-coffee-3.jpg') ?>" alt="Café de especialidad" class="w-100 h-100 object-fit-cover">
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-content text-center text-white container">
    <h1 class="display-3 fw-bold mb-4">Descubre el Alma del Café</h1>
    <p class="lead fs-2 mb-5">Directo de las montañas a tu taza</p>
    <a href="#cafes" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-pill">
      <i class="fas fa-coffee me-2"></i> Explorar Cafés
    </a>
  </div>
</section>


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
        <img src="<?= base_url('assets/img/origenes-cafe.jpg') ?>" alt="Finca de café" class="img-fluid rounded-4 shadow" loading="lazy" style="border: 8px solid white; box-shadow: 0 10px 30px rgba(74, 46, 29, 0.2);">
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
    <div class="row g-4 productos-scroll">
      <?php if (!empty($productos_destacados)): ?>
        <?php foreach ($productos_destacados as $producto): ?>
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 overflow-hidden" style="background-color: rgba(230, 213, 195, 0.1); backdrop-filter: blur(5px); transition: all 0.3s;">
              <div class="overflow-hidden" style="height: 200px;">
                <?php if ($producto['imagen_producto']): ?>
                  <img src="<?= base_url("public/uploads/productos/" . $producto['imagen_producto']) ?>"
                    class="card-img-top w-100 h-100"
                    alt="<?= esc($producto['nombre']) ?>"
                    style="object-fit: cover; transition: transform 0.5s;">
                <?php else: ?>
                  <div class="card-img-top w-100 h-100 d-flex align-items-center justify-content-center bg-light" style="transition: transform 0.5s;">
                    <i class="fas fa-coffee fa-3x text-muted"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <h5 class="card-title" style="color: #F5F0E6;"><?= esc($producto['nombre']) ?></h5>

                <?php if ($producto['origen']): ?>
                  <p class="small mb-1" style="color: #D4A762;">
                    <i class="fas fa-map-marker-alt me-2"></i><?= esc($producto['origen']) ?>
                  </p>
                <?php endif; ?>

                <?php if ($producto['notas_cata']): ?>
                  <p class="mb-2" style="color: #E6D5C3; font-size: 0.9em;">
                    <?= substr(esc($producto['notas_cata']), 0, 50) . (strlen($producto['notas_cata']) > 50 ? '...' : '') ?>
                  </p>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-bold" style="color: #D4A762;">$<?= number_format($producto['precio'], 2) ?></span>
                  <?php if ($producto['categoria_nombre']): ?>
                    <small style="color: #E6D5C3;"><?= esc($producto['categoria_nombre']) ?></small>
                  <?php endif; ?>
                </div>

                <div class="d-grid gap-2">
                  <button class="btn btn-sm agregar-carrito-home"
                    data-producto-id="<?= $producto['id'] ?>"
                    data-producto-nombre="<?= esc($producto['nombre']) ?>"
                    data-producto-precio="<?= $producto['precio'] ?>"
                    style="background-color: #D4A762; color: #4A2E1D; font-weight: 600;"
                    <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                    <?= $producto['stock'] <= 0 ? 'Sin Stock' : 'Añadir al carrito' ?>
                  </button>
                  <a href="<?= base_url('productos/' . $producto['id']) ?>"
                    class="btn btn-sm btn-outline-light">
                    Ver detalles
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Productos de ejemplo si no hay productos destacados -->
        <div class="col-12 text-center">
          <p class="text-muted">No hay productos destacados disponibles.</p>
          <a href="<?= base_url('productos') ?>" class="btn btn-outline-light">Ver todos los productos</a>
        </div>
      <?php endif; ?>
    </div>
    <div class="text-center mt-5">
      <a href="<?= base_url('productos') ?>" class="btn btn-lg px-4 py-2 fw-bold rounded-pill" style="background-color: transparent; border: 2px solid #E6D5C3; color: #E6D5C3;">
        Ver toda la selección <i class="fas fa-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>
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

  // Funcionalidad para agregar al carrito desde la home
  document.addEventListener('DOMContentLoaded', function() {
    const botonesCarrito = document.querySelectorAll('.agregar-carrito-home');

    botonesCarrito.forEach(boton => {
      boton.addEventListener('click', function() {
        const productoId = this.dataset.productoId;
        const productoNombre = this.dataset.productoNombre;
        const productoPrice = this.dataset.productoPrecio;

        // Mostrar indicador de carga
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Agregando...';
        this.disabled = true;

        // Realizar petición AJAX
        fetch('<?= base_url('carrito/agregar') ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `producto_id=${productoId}&cantidad=1`
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Mostrar mensaje de éxito
              this.innerHTML = '<i class="fas fa-check me-1"></i>¡Agregado!';
              this.style.backgroundColor = '#28a745';
              // Actualizar contador del carrito
              if (typeof actualizarContadorCarrito === 'function') {
                actualizarContadorCarrito();
              }

              // Mostrar toast de confirmación
              const toast = document.createElement('div');
              toast.className = 'position-fixed top-0 end-0 p-3';
              toast.style.zIndex = '9999';
              toast.innerHTML = `
              <div class="toast show" role="alert">
                <div class="toast-header">
                  <i class="fas fa-shopping-cart text-success me-2"></i>
                  <strong class="me-auto">Producto agregado</strong>
                </div>
                <div class="toast-body">
                  ${productoNombre} se agregó al carrito
                  <div class="mt-2">
                    <a href="<?= base_url('carrito') ?>" class="btn btn-sm btn-success me-2">Ver carrito</a>
                    <button class="btn btn-sm btn-secondary" onclick="this.closest('.position-fixed').remove()">Continuar</button>
                  </div>
                </div>
              </div>
            `;
              document.body.appendChild(toast);

              // Eliminar toast después de 5 segundos
              setTimeout(() => {
                if (toast.parentNode) {
                  toast.remove();
                }
              }, 5000);

              // Restaurar botón después de 2 segundos
              setTimeout(() => {
                this.innerHTML = originalText;
                this.style.backgroundColor = '#D4A762';
                this.disabled = false;
              }, 2000);

            } else {
              // Mostrar error
              // alert(data.message || 'Error al agregar el producto al carrito');
              // this.innerHTML = originalText;
              // this.disabled = false;

              // Si necesita login, redirigir
              if (data.redirect) {
                window.location.href = data.redirect;
              }
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Error al agregar el producto al carrito');
            this.innerHTML = originalText;
            this.disabled = false;
          });
      });
    });
  });
</script>