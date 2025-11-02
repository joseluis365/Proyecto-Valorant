<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

if (!isset($_GET['id_sala'])) {
    header("Location: listar_salas.php");
    exit;
}

$id_sala = $_GET['id_sala'];
$user_id = $_SESSION['id_usuario'];

// --- Si se envía un mensaje (AJAX POST) ---
if (isset($_POST['accion']) && $_POST['accion'] === 'enviar') {
    $mensaje = trim($_POST['mensaje'] ?? '');
    if ($mensaje !== '') {
        $stmt = $con->prepare("INSERT INTO chat (mensaje, id_sala, id_user, fecha_mensaje) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$mensaje, $id_sala, $user_id]);
    }
    exit; // termina aquí si fue AJAX
}

// --- Si se solicitan mensajes (AJAX GET) ---
if (isset($_GET['accion']) && $_GET['accion'] === 'obtener') {
    $stmt = $con->prepare("
        SELECT c.mensaje, c.fecha_mensaje, u.usuario 
        FROM chat c
        INNER JOIN user u ON c.id_user = u.id_user
        WHERE c.id_sala = ?
        ORDER BY c.id_chat ASC
        LIMIT 30
    ");
    $stmt->execute([$id_sala]);
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($mensajes as $m) {
        $hash = substr(md5($m['usuario']), 0, 6);
    $color = "#" . $hash;

    echo "<p><strong style='color:{$color};'>{$m['usuario']}:</strong> {$m['mensaje']} 
          <span style='font-size:0.8em;color:gray;'>({$m['fecha_mensaje']})</span></p>";
    }
    exit;
}

// 1. OBTENER DATOS DE LA SALA
$stmt = $con->prepare("SELECT s.*, m.nombre_mapa
    FROM sala s
    INNER JOIN mapa m ON s.id_mapa = m.id_mapa
    WHERE id_sala = ?
");
$stmt->execute([$id_sala]);
$sala = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Verificar si el usuario ya está en la sala
$stmt = $con->prepare("SELECT COUNT(*) FROM usuario_sala WHERE id_user = ? AND id_sala = ?");
$stmt->execute([$user_id, $id_sala]);
$yaDentro = $stmt->fetchColumn();

if ($yaDentro == 0) {
    // Verificar cuántos jugadores hay en la sala
    $stmt = $con->prepare("SELECT COUNT(*) FROM usuario_sala WHERE id_sala = ?");
    $stmt->execute([$id_sala]);
    $numJugadores = $stmt->fetchColumn();

    // Obtener máximo de jugadores
    $maxJugadores = 5;

    // Si la sala está llena, redirigir
    if ($numJugadores >= $maxJugadores) {
        echo "<script>alert('La sala está llena.'); window.location.href='listar_salas.php';</script>";
        exit;
    }

    // Asignar rol
    $rol = ($numJugadores == 0) ? 'Host' : 'Jugador';

    // Insertar al usuario en la sala
    $stmt = $con->prepare("INSERT INTO usuario_sala (id_user, id_sala, rol) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $id_sala, $rol]);
}


if (!$sala) {
    die("Sala no encontrada.");
}

$maxJugadores = $sala['max_jugadores'];

// 2. OBTENER JUGADORES DENTRO DE LA SALA
$stmt = $con->prepare("SELECT us.id_user, us.rol, u.usuario, b.banner, r.icono
    FROM usuario_sala us 
    INNER JOIN user u ON us.id_user = u.id_user
    INNER JOIN rango r ON u.id_rango = r.id_rango
    INNER JOIN banner b ON u.id_banner = b.id_banner
    WHERE us.id_sala = ?
");
$stmt->execute([$id_sala]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si el usuario actual es Host
$soyHost = false;
foreach ($jugadores as $jug) {
    if ($jug['id_user'] == $user_id && $jug['rol'] === "Host") {
        $soyHost = true;
        break;
    }
}

$rutaBanner = "../../controller/multimedia/banners/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lobby de la Sala | Valorant</title>
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../controller/css/style2.css">
</head>
<body class="bg-dark text-light">

<div class="top-bar">
    <a href="salir_sala.php?id_sala=<?php echo $id_sala; ?>" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">SALIR</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">SALA</span>
</div>

<div class="container">
    <h2 class="title text-center mb-4" style="font-size: 4rem;">SALA <?php echo strtoupper($sala['tipo_juego']); ?></h2>

    <!-- CONTENEDOR PRINCIPAL DE JUGADORES -->
<div id="contenedor-jugadores" class="d-flex flex-wrap justify-content-center align-items-start gap-4 text-center">
    <?php
    // Dividimos jugadores en host y otros
    $host = null;
    $otros = [];
    foreach ($jugadores as $jug) {
        if ($jug['rol'] === "Host") {
            $host = $jug;
        } else {
            $otros[] = $jug;
        }
    }

    // Render de los jugadores
    function mostrarJugador($jug, $rutaBanner) {
        $banner = !empty($jug['banner']) ? $rutaBanner . $jug['banner'] : $rutaBanner . "default.png";
        $rolBadge = ($jug['rol'] === 'Host') ? '<span class="badge bg-warning text-dark mt-2">HOST</span>' : '';
        return '
        <div class="jugador-card">
            <div class="banner-frame mx-auto mb-2">
                <img src="'.$banner.'" alt="banner" class="banner-img">
                <p class="nombre mb-1 text-black fw-bold">'.strtoupper($jug['usuario']).'</p>
                <img class="icono-rango" src="../../controller/multimedia/rangos/'.$jug['icono'].'" alt="Rango" height="45" width="40">
            </div>
            '.$rolBadge.'
        </div>';
    }

    // Mostrar host primero
    if ($host) echo mostrarJugador($host, $rutaBanner);

    // Mostrar los demás jugadores
    foreach ($otros as $jug) echo mostrarJugador($jug, $rutaBanner);

    // Agregar placeholders si faltan jugadores
    $totalJugadores = count($jugadores);
    for ($i = $totalJugadores; $i < $maxJugadores; $i++) {
        echo '
        <div class="jugador-card esperando-jugador card p-3 d-flex align-items-center justify-content-center" 
             style="width:170px; height:180px;">
            <span class="text-muted">Esperando jugador...</span>
        </div>';
    }
    ?>
</div>



    <div class="text-center mt-4">
    <?php if ($soyHost): ?>
    <button id="botonIniciar" class="btn btn-lg btn-secondary" disabled>
        Esperando jugadores (<?php echo count($jugadores); ?>/<?php echo $maxJugadores; ?>)
    </button>
<?php else: ?>
    <p class="text-muted">Esperando a que el host inicie la partida...</p>
<?php endif; ?>
    </div>

</div>

<<<<<<< HEAD

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const idSala = <?php echo json_encode($id_sala); ?>;
const soyHost = <?php echo $soyHost ? 'true' : 'false'; ?>;
let contando = false;
let inicio_ts_global = null;

function refreshLobby(){
  $.get('obtener_jugadores.php', { id_sala: idSala }, function(res){
    try {
      const info = typeof res === 'string' ? JSON.parse(res) : res;
      if (info.error) { console.error(info.error); return; }

      // actualizar HTML del contenedor
      $('#contenedor-jugadores').html(info.html);

      // actualizar boton (si soy host)
      if (soyHost) {
        if (info.count >= info.max) {
          $('#botonIniciar').prop('disabled', false).text('Iniciar partida');
        } else {
          $('#botonIniciar').prop('disabled', true).text(`Esperando jugadores (${info.count}/${info.max})`);
        }
      }

      // detectar estado iniciando
      if (info.estado === 'iniciando') {
        if (!contando) {
          // iniciar cuenta usando el inicio_ts del servidor
          inicio_ts_global = info.inicio_ts ? parseInt(info.inicio_ts) : (Math.floor(Date.now()/1000) + 5);
          startCountdown(inicio_ts_global);
        }
      } else if (info.estado === 'en_juego') {
        // si ya está en juego, redirigir a la partida (o cargar la vista)
        window.location.href = 'partida.php?id_sala=' + idSala;
      } else {
        // estado normal
      }

    } catch (e) { console.error('parse error', e); }
  });
}

// manejar click iniciar
$('#botonIniciar').on('click', function(){
  if (!soyHost) return;
  $.post('iniciar_partida.php', { id_sala: idSala }, function(resp){
    // la respuesta no importa demasiado, la próxima refresh detectará el estado 'iniciando'
    refreshLobby();
  });
});

// cuenta regresiva centralizada
function startCountdown(inicio_ts) {
  contando = true;
  // bloquear salida visualmente y advertir en beforeunload
  $('#salirLink').hide();
  window.onbeforeunload = function(){ return "La partida está por iniciar, ¿deseas salir?"; };

  const intervalo = setInterval(function(){
    const ahora = Math.floor(Date.now()/1000);
    const rem = inicio_ts - ahora;
    if (rem > 0) {
      // mostrar overlay o mensaje grande
      if ($('#contadorOverlay').length === 0) {
        $('body').append('<div id="contadorOverlay" style="position:fixed;left:0;top:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;z-index:9999;"><div style="background:rgba(0,0,0,0.7);padding:30px;border-radius:12px;color:#fff;font-size:2rem;">La partida comienza en <span id="segundos">'+rem+'</span> s</div></div>');
      } else {
        $('#segundos').text(rem);
      }
    } else {
      clearInterval(intervalo);
      // quitar overlay
      $('#contadorOverlay').remove();
      window.onbeforeunload = null;
      // confirmar inicio en servidor y redirigir
      $.post('confirmar_inicio.php', { id_sala: idSala }, function(r){
        // redirigir a la pantalla de partida
        window.location.href = 'partida.php?id_sala=' + idSala;
      });
    }
  }, 300); // frecuencia interna para mostrar seg decreciente (300ms)
}

// arrancar polling corto
refreshLobby();
setInterval(refreshLobby, 1000); // 1s, ajustar si quieres menos carga
</script>


=======
<!-- Chat inferior izquierdo -->
<div id="chat-box" class="position-fixed bottom-0 start-0 bg-dark text-light border-top border-end"
     style="width:450px; height:180px; border-radius: 2px 2px 0 0; display:flex; flex-direction:column;">

    <!-- Contenedor de mensajes con scroll -->
    <div id="mensajes" style="flex:1; overflow-y:auto; padding:8px;"></div>

    <!-- Input fijo al fondo -->
    <form id="formChat" class="d-flex p-2 border-top border-secondary bg-dark">
        <input type="text" name="mensaje" id="mensaje" class="w-75 form-control-sm me-2" autocomplete="off" placeholder="Escribe algo...">
        <button class="btn btn-danger btn-sm w-50">Enviar</button>
    </form>
</div>


<script>
const idSala = <?php echo json_encode($id_sala); ?>;

function cargarMensajes() {
    fetch(`?accion=obtener&id_sala=${idSala}`)
        .then(res => res.text())
        .then(data => {
            const contenedor = document.getElementById("mensajes");
            contenedor.scrollTop = contenedor.scrollHeight;
            const estabaAbajo = contenedor.scrollHeight - contenedor.scrollTop === contenedor.clientHeight;
            contenedor.innerHTML = data;
            
            // Si estaba abajo, sigue bajando automáticamente
            if (estabaAbajo) {
                contenedor.scrollTop = contenedor.scrollHeight;
            }
        });
}


setInterval(cargarMensajes, 2000);
cargarMensajes();

document.getElementById("formChat").addEventListener("submit", e => {
    e.preventDefault();
    const mensaje = document.getElementById("mensaje").value.trim();
    if (mensaje === "") return;

    const formData = new FormData();
    formData.append("accion", "enviar");
    formData.append("mensaje", mensaje);
    formData.append("id_sala", idSala);

    fetch(`?id_sala=${idSala}`, { method: "POST", body: formData })
        .then(() => {
            document.getElementById("mensaje").value = "";
            cargarMensajes();
        });
});
</script>

>>>>>>> sombrah
</body>
</html>
