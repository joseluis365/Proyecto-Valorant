<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

$id_sala = intval($_GET['id_sala'] ?? 0);
if (!$id_sala) {
    die("Sala no encontrada.");
}

// compatibilidad con la sesión (tus nombres previos)
$id_usuario = $_SESSION['id_usuario'] ?? $_SESSION['id_user'] ?? null;
if (!$id_usuario) {
    die("Usuario no autenticado.");
}
// Obtener sala y modo
$stmt = $con->prepare("SELECT * FROM sala WHERE id_sala = ?");
$stmt->execute([$id_sala]);
$sala = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$sala) {
    die("Sala inválida.");
}
$tipo_juego = $sala['tipo_juego']; 

if ($tipo_juego == 'Multijugador') {
  $mapaCarpeta = 'Ascent';
} else {
  $mapaCarpeta = 'Corrode';
}

// Obtener partida activa para la sala (iniciando/en_juego)

$stmt = $con->prepare("SELECT * FROM partida WHERE id_sala = ? AND estado IN ('en_juego','iniciando') ORDER BY id_partida DESC LIMIT 1");
$stmt->execute([$id_sala]);
$partida = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$partida) {
    die("No hay una partida activa. El host debe iniciarla.");
}
$id_partida = intval($partida['id_partida']);
$_SESSION['id_partida'] = $id_partida;


// Obtener rango del usuario (para filtrar armas)
$stmt = $con->prepare("SELECT id_rango FROM `user` WHERE id_user = ?");
$stmt->execute([$id_usuario]);
$id_rango_usuario = intval($stmt->fetchColumn() ?? 0);

// ---------------------------
// Traer armas permitidas según rango
// ---------------------------
$stmt = $con->prepare("SELECT id_arma, nombre_arma, img_arma, img_fondo, video_arma, id_tipo_arma
    FROM arma
    WHERE (rango_requerido IS NULL OR rango_requerido <= ?)
    ORDER BY FIELD(id_tipo_arma, 2,3,4,1), id_arma
");
$stmt->execute([$id_rango_usuario]);
$armasDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$armaActual = null;
foreach ($armasDisponibles as $arma) {
    if ($arma['id_tipo_arma'] == 1) {
        $armaActual = $arma;
        break;
    }
}
if (!$armaActual) {
    $armaActual = $armasDisponibles[0]; // fallback
}
// --------------------------
// Traer jugadores de la partida (partida_jugador) con su vida_actual, kills, y datos de usuario
// ---------------------------
$stmt = $con->prepare("SELECT pj.id_partida_jugador, pj.id_user, pj.vida_actual, pj.kills, u.usuario, p.imagen_personaje
    FROM partida_jugador pj
    JOIN user u ON pj.id_user = u.id_user
    LEFT JOIN personaje p ON u.id_personaje = p.id_personaje
    WHERE pj.id_partida = ?
    ORDER BY pj.id_partida_jugador ASC
");
$stmt->execute([$id_partida]);
$jugadores_partida = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($jugadores_partida)) {
    echo "<pre style='color:red;'>No hay jugadores en la partida (id_partida=$id_partida)</pre>";
}


// separar mi info y enemigos
$miInfo = null;
$enemigos = [];
foreach ($jugadores_partida as $p) {
    if (intval($p['id_user']) === intval($id_usuario)) {
        $miInfo = $p;
    } else {
        $enemigos[] = $p;
    }
}

// aquí asumimos si $sala['tipo_juego'] tiene el nombre '1vs1' o similar - si tu campo es distinto ajusta la condición
if (strtolower($sala['tipo_juego']) === '1vs1' || strtolower($sala['tipo_juego']) === '1v1') {
    if (count($enemigos) > 1) $enemigos = [ $enemigos[0] ];
}

// rutas base (relativas desde model/admin/partida.php)
$armasBase = '../../controller/multimedia/Armas/';
$personajeBase = '../../controller/multimedia/Personajes/';

// helper
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../controller/css/salas.css">
<title>Partida</title>
</head>
<body class="fondo">

<!-- IMAGEN DE FONDO -->
<div id="imagenFondo" class="imagen-fondo"
    style="background-image: url('../../controller/img/fondo-partida.jpg');">
</div>
<!-- Temporizador -->
<div id="temporizador" 
    style="position: fixed; top: 15px; left: 50%; transform: translateX(-50%);
            background: rgba(0,0,0,0.7); color: #fff; padding: 10px 25px; 
            border-radius: 12px; font-size: 1.8em; font-weight: bold;
            border: 2px solid #00ff7f;">
  05:00
</div>

<form id="formulario-seleccion" action="#" method="post" style="position:relative;z-index:20;">
  <div class="contenedor-avatares d-flex justify-content-center" style="width: 100%; margin-right:200px;" id="contenedorAvatares">

    <?php
        // Imprimir enemigos reales (sin cambiar tus clases y estructura)
        foreach ($enemigos as $e) {
            $personajeFile = !empty($e['imagen_personaje']) ? $e['imagen_personaje'] : 'chamber.png';
            $personajePath = $personajeBase . $personajeFile;
            $vida = intval($e['vida_actual'] ?? 100);
            $disabledCls = ($vida <= 0) ? 'jugador-desactivado' : '';
            echo '
              <div class="selector-avatar justify-content-center '.$disabledCls.'" data-id-user="'.intval($e['id_user']).'">
                <p class="text-center">'.$e['usuario'].'</p>
                <div class="imagen-contenedor">
                  <img src="'.h($personajePath).'" alt="'.h($e['usuario']).'" class="avatar-img">
                  <div class="overlay cabeza"></div>
                  <div class="overlay cuerpo"></div>
                </div>
              <div class="opciones">
                <button type="button" data-parte="cabeza">Cabeza</button>
                <button type="button" data-parte="cuerpo">Cuerpo</button>
              </div>
              <div class="barra-vida">
              <div class="barra-vida-fill" id="fill-' .intval($e['id_user']).'" style="width:'.intval($e['vida_actual']).'%"></div>
              </div>
            </div>
            ';

        }
    ?>

  </div>

  <!-- BOTÓN DISPARO (manteniendo tu estructura) -->
  <div class="buton">
  <button type="button" id="playVideo" class="hud-button" style="position:fixed;right:40px;bottom:40px;z-index:30;">
    <img class="icono" src="../../controller/multimedia/img/boton_disparo.png" alt="">
  </button>
  </div>

  <!-- SELECTOR DE ARMAS -->
  <div class="selector-arma" id="selectorArma">

      <div class="arma-seleccionada" id="armaSeleccionada">
          <img id="imgArmaActual"
                src="../../controller/multimedia/Armas/<?php echo htmlspecialchars($armaActual['img_arma']); ?>">
      </div>

      <div class="lista-armas" id="listaArmas">
          <?php foreach ($armasDisponibles as $arma): ?>
    <img src="<?= $armasBase . htmlspecialchars($arma['img_arma']); ?>"
          class="arma-opcion"
          data-idarma="<?= intval($arma['id_arma']); ?>"
          alt="<?= htmlspecialchars($arma['nombre_arma']); ?>">
<?php endforeach; ?>

      </div>

  </div>

  <!-- BARRA DE VIDA (tuya) -->
  <div class="barra-vida-contenedor" style="position:fixed;left:50%;transform:translateX(-50%);bottom:20px;z-index:30;">
    <div class="barra-vida" id="barraVida" style="width:300px;">
      <div id="miBarFill" style="width:<?php echo intval($miInfo['vida_actual'] ?? 100); ?>%; height:100%; background:linear-gradient(90deg,#2ecc71,#27ae60);"></div>
    </div>
  </div>

</form>

<script>
(() => {
  // === Variables globales desde PHP ===
  window.ID_USUARIO  = <?= json_encode((int)$id_usuario); ?>;
  window.ID_SALA     = <?= json_encode((int)$id_sala); ?>;
  window.ID_PARTIDA  = <?= json_encode((int)$id_partida); ?>;
  const idPartida    = window.ID_PARTIDA;

  // === Referencias DOM ===
  const listaArmasEl = document.getElementById('listaArmas');
  const imgArmaActual = document.getElementById('imgArmaActual');
  const btnPlay = document.getElementById('playVideo');
  const miBarFill = document.getElementById('miBarFill');
  const temporizador = document.getElementById('temporizador');

  if (!listaArmasEl) return console.error('listaArmas no encontrada en DOM');

  // === Estado interno ===
  let armaActualId = null;
  let seleccion = { id_objetivo: null, parte: null };
  let isFetchingVidas = false;
  let disparando = false;

  // === Utilidades ===
  const clamp = (v) => Math.max(0, Math.min(100, v));
  const qsa = (sel, ctx = document) => ctx.querySelectorAll(sel);

  // === Selección de arma ===
  function marcarSeleccion(img) {
    qsa('#listaArmas img').forEach(i => i.classList.remove('seleccionada', 'arma-seleccionada'));
    img.classList.add('seleccionada');
  }

  function seleccionarArma(imgEl) {
    if (!imgEl) return;
    marcarSeleccion(imgEl);
    armaActualId = parseInt(imgEl.dataset.idarma) || 0;
    if (imgArmaActual) imgArmaActual.src = imgEl.src;
  }

  function initListaArmas() {
    qsa('#listaArmas img').forEach(img => img.addEventListener('click', () => seleccionarArma(img)));
  }

  function seleccionarArmaPorDefecto() {
    seleccionarArma(document.querySelector('#listaArmas img[data-idarma="10"]') || document.querySelector('#listaArmas img'));
  }

  // === Disparar ===
  async function disparar() {
    if (disparando) return;
    disparando = true;

    try {
      if (!seleccion.id_objetivo || !seleccion.parte) return alert('Selecciona un enemigo y una parte del cuerpo.');
      if (!armaActualId) return alert('Selecciona un arma.');

      const payload = {
        id_partida: idPartida,
        id_atacante: window.ID_USUARIO,
        id_objetivo: seleccion.id_objetivo,
        id_arma: armaActualId,
        parte: seleccion.parte
      };

      const resp = await fetch('registrar_disparo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const data = await resp.json();

      if (data.error) return alert(data.error);

      if (typeof data.vida_restante !== 'undefined') {
        const bar = document.getElementById('fill-' + payload.id_objetivo);
        if (bar) bar.style.width = clamp(data.vida_restante) + '%';
        if (payload.id_objetivo === window.ID_USUARIO && miBarFill)
          miBarFill.style.width = clamp(data.vida_restante) + '%';
      }

      if (data.murio) {
        const av = document.querySelector(`.selector-avatar[data-id-user="${payload.id_objetivo}"]`);
        if (av) av.classList.add('jugador-desactivado');
      }

      if (data.ganador) {
        location.href = 'finalizar_partida.php?id_partida=' + idPartida;
      }

    } catch (err) {
      console.error('Error en disparar:', err);
    } finally {
      disparando = false;
    }
  }

  if (btnPlay) btnPlay.addEventListener('click', (e) => {
    e.preventDefault();
    disparar();
  });

  // === Cambiar posición del botón al disparar ===
const posiciones = [
  { right: "40px", bottom: "40px" },          // esquina inferior derecha
  { left: "40px", bottom: "40px" },           // esquina inferior izquierda
  { left: "50%", bottom: "40px", transform: "translateX(-50%)" }, // centro abajo
  { right: "40px", top: "40px" },             // esquina superior derecha
  { left: "40px", top: "40px" }               // esquina superior izquierda
];

let ultimaPos = -1; // Guarda la última posición usada

function moverBotonDisparo() {
  if (!btnPlay) return;

  // Elegir nueva posición distinta a la anterior
  let idx;
  do {
    idx = Math.floor(Math.random() * posiciones.length);
  } while (idx === ultimaPos);
  ultimaPos = idx;

  const pos = posiciones[idx];

  // Resetear estilos anteriores
  btnPlay.style.left = btnPlay.style.right = btnPlay.style.top = btnPlay.style.bottom = btnPlay.style.transform = "";

  // Aplicar nueva posición
  for (const [prop, val] of Object.entries(pos)) {
    btnPlay.style[prop] = val;
  }

  // Añadir animación suave
  btnPlay.style.transition = "all 0.4s ease";
}

// Ejecutar movimiento después de cada disparo
btnPlay.addEventListener("click", moverBotonDisparo);

// Escuchar clic y mover después de disparar
btnPlay.addEventListener("click", moverBotonDisparo);


  // === Selección de objetivo ===
  qsa('.selector-avatar').forEach(avatarEl => {
    const opciones = avatarEl.querySelector('.opciones');
    const avatarImg = avatarEl.querySelector('.imagen-contenedor');
    if (!avatarImg || !opciones) return;

    avatarImg.addEventListener('click', () => {
      opciones.style.display = opciones.style.display === 'flex' ? 'none' : 'flex';
    });

    qsa('button[data-parte]', opciones).forEach(btn => {
      btn.addEventListener('click', () => {
        qsa('.overlay').forEach(o => (o.style.opacity = 0));
        qsa('.selector-avatar').forEach(a => a.classList.remove('seleccionado'));

        const parte = btn.dataset.parte;
        const overlay = avatarEl.querySelector('.overlay.' + parte);
        if (overlay) overlay.style.opacity = 1;

        seleccion.id_objetivo = parseInt(avatarEl.dataset.idUser || avatarEl.getAttribute('data-id-user')) || 0;
        seleccion.parte = parte;

        avatarEl.classList.add('seleccionado');
        opciones.style.display = 'none';
      });
    });
  });

  // === Actualizar vidas ===
  async function actualizarVidas() {
    if (isFetchingVidas) return;
    isFetchingVidas = true;

    try {
      const r = await fetch('actualizar_vidas.php?id_partida=' + idPartida, { cache: 'no-store' });
      const data = await r.json();
      if (!data?.jugadores) return;

      for (const j of data.jugadores) {
        const fillEl = document.getElementById('fill-' + j.id_user);
        if (fillEl) fillEl.style.width = clamp(j.vida_actual) + '%';
        if (j.id_user === window.ID_USUARIO && miBarFill)
          miBarFill.style.width = clamp(j.vida_actual) + '%';

        if (j.vida_actual <= 0) {
          const av = document.querySelector(`.selector-avatar[data-id-user="${j.id_user}"]`);
          if (av) av.classList.add('jugador-desactivado');
          if (j.id_user === window.ID_USUARIO) comprobarMuerteJugador(j.vida_actual);
        }
      }

      if (data.estado === 'finalizada') {
        location.href = 'resultado_partida.php?id_partida=' + (data.id_partida || idPartida);
      }
    } catch (e) {
      console.error('Error actualizarVidas:', e);
    } finally {
      isFetchingVidas = false;
    }
  }

  // === Efectos de muerte ===
  function mostrarPerdiste() {
    document.body.style.filter = 'grayscale(100%)';
    const overlay = Object.assign(document.createElement('div'), {
      style: `
        position:fixed;top:0;left:0;width:100%;height:100%;
        background:rgba(0,0,0,0.7);color:#fff;font-size:4em;
        font-weight:bold;display:flex;align-items:center;
        justify-content:center;z-index:9999;
      `,
      innerText: 'PERDISTE'
    });
    document.body.appendChild(overlay);
  }

  function comprobarMuerteJugador(vida) {
    if (vida > 0) return;
    mostrarPerdiste();
    setTimeout(() => {
      fetch('finalizar_partida.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_partida=' + idPartida
      }).then(() => location.href = 'resultado_partida.php?id_partida=' + idPartida);
    }, 2000);
  }

  // === Contador de partida (5 min) ===
  let tiempoTotal = 300;

  fetch('tiempo_partida.php?id_partida=' + idPartida)
    .then(r => r.json())
    .then(data => {
      if (data.estado === 'finalizada') {
        location.href = 'resultado_partida.php?id_partida=' + idPartida;
        return;
      }

      const inicio = new Date(data.fecha_inicio).getTime();
      let restante = Math.max(0, tiempoTotal - Math.floor((Date.now() - inicio) / 1000));

      const interval = setInterval(() => {
        if (!temporizador) return;
        const min = String(Math.floor(restante / 60)).padStart(2, '0');
        const seg = String(restante % 60).padStart(2, '0');
        temporizador.textContent = `${min}:${seg}`;

        if (restante-- <= 0) {
          clearInterval(interval);
          temporizador.textContent = "00:00";
          finalizarPartida();
        }
      }, 1000);
    })
    .catch(err => console.error('Error al obtener tiempo de partida:', err));

  async function finalizarPartida() {
    try {
      const r = await fetch('finalizar_partida.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_partida=' + idPartida
      });
      const resp = await r.json();
      if (resp.status === 'ok' || resp.status === 'ya_finalizada')
        location.href = 'resultado_partida.php?id_partida=' + idPartida;
    } catch (err) {
      console.error('Error finalizando partida:', err);
    }
  }

  // === Inicialización ===
  initListaArmas();
  seleccionarArmaPorDefecto();
  setInterval(actualizarVidas, 1000);
  actualizarVidas();

})();
</script>



</body>
</html>
