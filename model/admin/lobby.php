<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db-> conectar();

$id_user = $_SESSION['id_usuario'];

$sql = $con->prepare("SELECT user.*, tip_user.tipo_user, rango.*, avatar.avatar
    FROM user
    INNER JOIN tip_user ON user.id_tipo_user = tip_user.id_tipo_user
    INNER JOIN rango ON user.id_rango = rango.id_rango
    INNER JOIN avatar ON user.id_avatar = avatar.id_avatar
    WHERE user.id_user = $id_user");

$sql->execute();

$fila = $sql->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Valorant</title>
  <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../controller/css/style.css">

</head>
<body>
  <video class="bg-video" id="bg-video" autoplay loop muted src="../../controller/multimedia/Animaciones/fondo_animacion.mp4"></video>
  <div class="overlay"></div>
  <!-- Panel lateral derecho -->
  <div class="position-absolute top-0 end-0 mt-5 me-4 d-flex flex-column gap-3" style="width: 18rem; margin-right: 5rem !important;">
    <a href="modos_juego.php" class="text-decoration-none">
    <div class="card-custom card1 text-white mt-3 d-flex flex-column justify-content-end" id="card-1">
  <div class="bg layer-a"></div>
  <div class="bg layer-b"></div>
  <div class="card-content p-3">
    <h5 class="fw-bold mb-0">Mapas de Juego</h5>
    <p class="small mb-0">Corrode - Ascent</p>
  </div>
</div>
    </a>
    <div class="card-custom card-2 ">
      <h6 class="fw-bold">Version del juego - 1.0.0</h6>
    </div>
    <a href="personajes.html" class="text-decoration-none">
    <div class="card-custom text-white card-3 d-flex flex-column justify-content-end">
      <p class="fw-bold mb-0">Nuevo Personaje</p>
      <p class="small">Reyna</p>
    </div>
    </a>
    <div class="card-custom card-4 d-flex flex-column justify-content-end">
      <h6 class="fw-bold mb-1">Modos destacados</h6>
      <p class="mb-0 small">Multigugador </p>
    </div>
  </div>

  <header class="d-flex justify-content-end align-items-center">
    <p class="mt-3 fw-bold" style="font-size: large;"> Puntos <?php echo $fila['puntos_requeridos'];?></p>
    <img src="../../controller/multimedia/rangos/<?php echo $fila['icono'];?>"  alt="Rango diamante" height="50" width="50" style="margin-left: 5px; margin-right: 5px; margin-top: 5px;">
    <h3 class="mt-1" style="margin-right: 15px; font-family: sans-serif;"><?php echo $fila['usuario']; ?></h3>
    <a href="" class="d-flex">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icono" style="width: 40px; margin-right: 10px;">
    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
    </svg>
    </a>

  </header>
  <div class="d-flex">
  <!-- Contenido principal (izquierda) -->
  <div class="flex-grow-1 p-3">
      <div class="position-absolute top-50 start-0 translate-middle-y ps-4 d-flex flex-column gap-3 fs-5 fw-bold">
<div class="d-flex menu-option">
  <div class="d-flex align-items-center">
    <span class="rombo rombo-activo align-items-center" style="background-color: #dc3545;"></span>
  </div>
  <a href="modos_juego.php" class="jugar  d-flex align-items-center text-danger fs-1 text-decoration-none">JUGAR</a>
</div>

<div class="d-flex menu-option1">
  <div class="d-flex align-items-center">
    <span class="rombo"></span>
  </div>
  <a href="rangos.php" class=" d-flex align-items-center text-white text-decoration-none">Rangos</a>
</div>

<div class="d-flex menu-option1 ">
  <div class="d-flex align-items-center">
    <span class="rombo"></span>
  </div>
  <a href="coleccion.php" class=" d-flex align-items-center text-white text-decoration-none">COLECCIÓN</a>
</div>

<div class="d-flex menu-option1">
  <div class="d-flex align-items-center">
    <span class="rombo"></span>
  </div>
  <a href="agentes.php" class=" d-flex align-items-center text-white text-decoration-none">AGENTES</a>
</div>

<div class="d-flex menu-option1">
  <div class="d-flex align-items-center">
    <span class="rombo"></span>
  </div>
  <a href="armas.php" class=" d-flex align-items-center text-white text-decoration-none">ARMAS</a>
</div>

<div class="d-flex menu-option1">
  <div class="d-flex align-items-center">
    <span class="rombo"></span>
  </div>
  <a href="solicitud.php" class=" d-flex align-items-center text-white text-decoration-none">SOLICITUD</a>
</div>

  </div>
  </div>

  <!-- Barra lateral derecha -->
  <div class="sidebar bg-dark text-white p-2">
    

    <div class="image-container card bg-secondary text-white mb-3" style="border-radius: 0;">
      <img src="../../controller/multimedia/avatars/<?php echo $fila['avatar'];?>" class="card-img-top" alt="Imagen noticia">
        <div class="info-card">
          <h3><?php echo $fila['usuario'];?></h3>
          <p><?php echo $fila['nombre_rango'];?></p>
          <img src="../../controller/multimedia/rangos/<?php echo $fila['icono'];?>" alt="Rango diamante" height="45" width="40" style="margin-left: 40%;">
        </div>
      </div>
    <div class="position-absolute bottom-0 end-0 mb-3" style="margin-right: 5px;">
      <button id="btn-audio" class="btn btn-custom">🔊</button>
    </div>
    </div>

  </div>
</div>

  

<script>
  const video = document.getElementById("bg-video");
  const btn = document.getElementById("btn-audio");

  btn.addEventListener("click", () => {
    if (video.muted) {
      video.muted = false;
      btn.textContent = "🔊";
    } else {
      video.muted = true;
      btn.textContent = "🔇";
    }
  });
(function () {
  const images = [
    '../../controller/multimedia/Mapas/Ascent/mapa_ascent.webp',
    '../../controller/multimedia/Mapas/Corrode/mapa_corrode.webp',
  ];

  const card = document.getElementById('card-1');
  const layerA = card.querySelector('.bg.layer-a');
  const layerB = card.querySelector('.bg.layer-b');
  // Estado
  let currentImageIndex = 0;
  let showingLayer = layerA;

  // inicializar
  layerA.style.backgroundImage = `url(${images[0]})`;
  layerA.classList.add('visible');

  // función para avanzar a la próxima imagen
  function nextImage() {
    const nextIdx = (currentImageIndex + 1) % images.length;
    const hiddenLayer = (showingLayer === layerA) ? layerB : layerA;

    // poner la siguiente imagen en la capa oculta
    hiddenLayer.style.backgroundImage = `url(${images[nextIdx]})`;

    hiddenLayer.classList.add('visible');
    showingLayer.classList.remove('visible');

    // actualizar estado
    showingLayer = hiddenLayer;
    currentImageIndex = nextIdx;
  }
  if (images.length > 1) {
    setInterval(nextImage, 5000);
  }
})();
</script>


</body>
</html>


