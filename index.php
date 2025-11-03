<!DOCTYPE html>
<html lang="en">

<head>
  <title>Reporte Usuarios</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="controller/css/style3.css">


  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top cabeza">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#inicio">
          <img src="controller/img/riot-icons.png" alt="Logo" height="40" width="100" class="me-2">
          <img src="controller/img/logo_valo.png" alt="Logo" width="70" class="me-2">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="#inicio"><strong>Inicio</strong></a></li>
            <li class="nav-item"><a class="nav-link" href="#noticias">Noticias</a></li>
            <li class="nav-item"><a class="nav-link" href="#personajes">Personajes</a></li>
            <li class="nav-item"><a class="nav-link" href="#armas">Armas</a></li>
            <li class="nav-item"><a class="nav-link" href="#mas">Más</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="hero d-flex flex-column justify-content-center align-items-center text-center text-white" id="inicio">
    <video class="bg-video" muted autoplay loop src="controller/multimedia/Animaciones/Video_valorant.mp4"></video>
    <div class="overlay"></div>
    <div class="content">
      <img src="controller/img/nombre.png" alt="Logo" width="445" class="me-2">
      <p class="lead mb-4" style="font-weight:bold; font-size: 15px;">UN JUEGO DE DISPAROS TACTICOS 5V5 CON AGENTES QUE
        POSEEN HABILIDADES UNICAS</p>
      <a href="login.php" class=" mt-3 btn btn-danger boton-custom btn-lg juega">JUEGA GRATIS</a>
    </div>
  </section>

    <section class="container my-5" id="noticias">
    <h2 class="fw-bold mb-4 text-uppercase little">Noticias más recientes</h2>

    <div class="row g-4">
      <!-- Tarjeta 1 -->
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <img src="controller/img/noticias1.jpg" class="card-img-top" alt="Tráiler de presentación de jugabilidad: Veto">
          <div class="card-body">
            <p class="text-danger text-uppercase mb-1 small fw-bold">Actualizaciones del juego | 5/10/2025</p>
            <h5 class="card-title fw-bold">Balance En El Campeon: YET</h5>
            <p class="card-text">Arruina los planes del enemigo y pelea bajo tus propias reglas</p>
          </div>
        </div>
      </div>

      <!-- Tarjeta 2 -->
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <img src="controller/img/noticias2.jpg" class="card-img-top" alt="NO LES DEN NADA // Tráiler de Veto - VALORANT">
          <div class="card-body">
            <p class="text-danger text-uppercase mb-1 small fw-bold">Actualizaciones del juego | 5/10/2025</p>
            <h5 class="card-title fw-bold">NO LES DEN NADA // BALANCE - VALORANT</h5>
            <p class="card-text">Nuevos balances en los personajes</p>
          </div>
        </div>
      </div>

      <!-- Tarjeta 3 -->
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <img src="controller/img/noticias3.jpg" class="card-img-top" alt="NO LES DEN NADA // Tráiler de Veto - VALORANT">
          <div class="card-body">
            <p class="text-danger text-uppercase mb-1 small fw-bold">Actualizaciones del juego | 5/10/2025</p>
            <h5 class="card-title fw-bold">ENTRA YA // Reclama Tu Llavero - VALORANT</h5>
            <p class="card-text">Entra Y Reclama Tu Llavero Gratis</p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <hr class="my-4" style="border: 3px solid #ccc;">
  </section>

<section class="personajes-section1 text-white my-5" id="personajes">
  <div class="container1">
    <h1 class="fw-bold mb-4 text-uppercase text-custom">Personajes Destacados</h1>

    <div class="row g-4">
      <!-- Tarjeta 1 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container1">
            <img src="controller/img/personaje1.png" class="card-img-top1" alt="Personaje 1">
            <div class="card-overlay">
              <h5>DUELISTA</h5>
              <p>Originaria de Filipinas, usa sus poderes bioeléctricos para generar electricidad y superar a sus oponentes a toda velocidad.</p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">NEON</h5>
          </div>
        </div>
      </div>

      <!-- Tarjeta 2 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container1">
            <img src="controller/img/personaje2.png" class="card-img-top1" alt="Personaje 2">
            <div class="card-overlay">
              <h5>INICIADOR</h5>
              <p>Originaria De Turquia, usa sus habilidades Radiantes para infiltrarse en los miedos más profundos de sus enemigos, antes de aplastarlos en la oscuridad.</p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">FADE</h5>
          </div>
        </div>
      </div>

      <!-- Tarjeta 3 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container1">
            <img src="controller/img/personaje3.png" class="card-img-top1" alt="Personaje 3">
            <div class="card-overlay">
              <h5>DUELISTA</h5>
              <p>Originario del Reino Unido, utiliza sus propias llamas de diversas maneras para derrotar al enemigo en su propio infierno.</p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">PHOENIX</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container my-5 arma-section" id="armas">
  <h1 class="fw-bold mb-4 text-uppercase little text-custom1">Armas Destacadas</h1>
  <div class="container2">
    <div class="row g-4 mt-2">
      <!-- Tarjeta 1 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container2">
            <img src="controller/img/arma-ghost.jpg" class="card-img-top2" alt="Personaje 1">
            <div class="card-overlay2">
              <h5>PISTOLA</h5>
              <p>Daño<strong>: 10P</strong></p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">GHOST</h5>
          </div>
        </div>
      </div>

      <!-- Tarjeta 2 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container2">
            <img src="controller/img/arma-vandal.jpg" class="card-img-top2" alt="Personaje 2">
            <div class="card-overlay2">
              <h5>AMETRALLADORA</h5>
              <p>Daño<strong>: 20P</strong></p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">VANDAL</h5>
          </div>
        </div>
      </div>

      <!-- Tarjeta 3 -->
      <div class="col-md-4">
        <div class="card card-hover border-0 shadow bg-dark text-white">
          <div class="card-img-container2">
            <img src="controller/img/arma-operator.jpg" class="card-img-top2" alt="Personaje 3">
            <div class="card-overlay2">
              <h5>RIFLE</h5>
              <p>Daño<strong>: 40P</strong></p>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">OPERATOR</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <hr class="my-4" style="border: 3px solid #ccc;">
</section>

<section class="footer text-white pt-7 pb-5 mt-5" id="mas">
  <div class="container">
    <div class="row gy-5">
      
      <!-- Columna 1 -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3 neon-text">V4LORANT</h5>
        <p class="text-secondary">
          Un espacio donde compartimos las últimas noticias, actualizaciones y estrategias de juego. 
          Mantente al día con lo más reciente del universo Valorant.
        </p>
        <p class="text-secondary mt-3">
           Comunidad global •  Precisión táctica •  Conecta con jugadores de todo el mundo.
        </p>
      </div>

      <!-- Columna 2 -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Enlaces útiles</h5>
        <ul class="list-unstyled">
          <li><a href="#inicio" class="footer-link">Inicio</a></li>
          <li><a href="#noticias" class="footer-link">Noticias</a></li>
          <li><a href="#personajes" class="footer-link">Personajes</a></li>
          <li><a href="#armas" class="footer-link">Armas</a></li>
          <li><a href="#" class="footer-link">Eventos</a></li>
          <li><a href="#" class="footer-link">Soporte</a></li>
        </ul>
      </div>

      <!-- Columna 3 -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Suscríbete</h5>
        <p class="text-secondary">Recibe actualizaciones exclusivas, skins, torneos y más.</p>

        <div class="mt-4">
          <h6 class="fw-bold mb-3">Síguenos</h6>
          <div class="d-flex gap-3">
            <a href="https://www.facebook.com/latamVALORANT/?locale=es_LA" class="social-link"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/valorant/?hl=es" class="social-link"><i class="bi bi-instagram"></i></a>
            <a href="https://github.com/Brayan-Stevan" class="social-link"><i class="bi bi-github"></i></a>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-5 border-light">

    <div class="text-center text-secondary small">
      © 2025 <span class="text-white fw-semibold neon-text">V4LORANT</span>. Todos los derechos reservados.
    </div>
  </div>
</section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Selecciona todos los enlaces del navbar
  const navLinks = document.querySelectorAll('.nav-link');

  // Mapea las secciones a sus IDs (usando los href del menú)
  const sections = Array.from(navLinks).map(link => {
    const id = link.getAttribute('href').substring(1);
    return document.getElementById(id);
  });

  // Observador para detectar qué sección está visible
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Remueve el "active" de todos los enlaces
        navLinks.forEach(link => link.classList.remove('active'));

        // Busca el link correspondiente a la sección visible
        const visibleLink = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
        if (visibleLink) visibleLink.classList.add('active');
      }
    });
  }, { threshold: 0.5 }); // 0.5 = cuando la mitad de la sección está visible

  // Observa cada sección
  sections.forEach(section => {
    if (section) observer.observe(section);
  });
</script>

</body>

</html>