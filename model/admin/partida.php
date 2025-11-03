<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../../controller/css/salas.css">
<title>Partida</title>
</head>
<body class="fondo">

<img id="bg-image" class="fullscreen" src="../../controller/multimedia/Mapas/Ascent/pistolas/fondo_pistola1.png" alt="Fondo imagen">

<video id="bg-video" class="fullscreen" src="../../controller/multimedia/Mapas/Ascent/pistolas/video_pistola1.mp4"></video>

<button class="boton-partida" id="playVideo" class="hud-button">
    <img class="icono" src="../../controller/multimedia/img/boton_disparo.png" alt="">
</button>

<script>
const btn = document.getElementById("playVideo");
const video = document.getElementById("bg-video");
const img = document.getElementById("bg-image");

let ultimaPosicion = -1;
const posiciones = [
  { top: "10%", left: "10%" },
  { top: "10%", left: "80%" },
  { top: "50%", left: "50%" },
  { top: "80%", left: "20%" },
  { top: "80%", left: "70%" }
];

// --- Función para mover el botón ---
function moverBoton() {
  let nuevaPos;
  do {
    nuevaPos = Math.floor(Math.random() * posiciones.length);
  } while (nuevaPos === ultimaPosicion);

  ultimaPosicion = nuevaPos;

  btn.style.top = posiciones[nuevaPos].top;
  btn.style.left = posiciones[nuevaPos].left;
}

// --- Evento al hacer clic en el botón ---
btn.addEventListener("click", () => {
  btn.disabled = true;
  moverBoton();              
  img.style.display = "none";
  video.style.display = "block";
  video.currentTime = 0;
  video.play();
});

// --- Evento al terminar el video ---
video.addEventListener("ended", () => {
  video.style.display = "none";
  img.style.display = "block";
  btn.disabled = false;
});


</script>

</body>
</html>
