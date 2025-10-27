<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['tipoJuego'])) {
    header("Location: modos_juego.php");
    exit;
}

$tipoJuego = $_POST['tipoJuego'];
$mapaSeleccionado = $_POST['mapaSeleccionado'];
$user_id = 1;


// Obtiene rango del usuario
$stmt = $con->prepare("SELECT u.id_rango, r.nombre_rango
                    FROM user u
                    INNER JOIN rango r ON u.id_rango = r.id_rango
                    WHERE u.id_user = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$id_rango = $userData['id_rango'];
$nombre_rango = $userData['nombre_rango'];


// Consulta salas disponibles
$sql = "SELECT s.id_sala, s.max_jugadores, s.nombre_sala, s.estado,
        (SELECT COUNT(*) FROM usuario_sala us WHERE us.id_sala = s.id_sala) AS ocupacion
        FROM sala s
        WHERE s.tipo_juego = :tipoJuego
          AND s.estado = 'Disponible'
          AND s.id_nivel_min = :rango
        HAVING ocupacion < s.max_jugadores
        ORDER BY s.id_sala DESC";

$stmt = $con->prepare($sql);
$stmt->execute([
    ':tipoJuego' => $tipoJuego,
    ':rango' => $id_rango
]);
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Capacidad automática
$capacidad = ($tipoJuego === "1vs1") ? 2 : 5;

if ($tipoJuego === "1vs1") {
    $fondo = "../../controller/multimedia/Mapas/Corrode/mapa_corrode.webp";
    $titulo = "<h1 class='title text-center d-flex justify-content-center'>1 <span><h3 style='margin-top: 25px;'> VS </h3></span> 1</h1>";
}else{
    $fondo = "../../controller/multimedia/Mapas/Ascent/mapa_ascent.webp";
    $titulo = "<h3 class='subtitle text-center d-flex justify-content-center'>MULTIJUGADOR</h3>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/salas.css">
    <title>Salas disponibles | Valorant</title>
</head>
<body class="text-light" style="background-image: url('<?php echo $fondo; ?>');">
    <div class="top-bar">
    <a href="lobby.html" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">SALAS</span>
    </div>

<div class="container mt-5">
    <h1 class="title text-center mb-0">SALAS DISPONIBLES</h1>
    <?php echo $titulo; ?>

    <?php if (empty($salas)) : ?>
        <div class="alert alert-info text-center">
            No hay salas disponibles en este modo de juego.
        </div>
    <?php else : ?>
        <?php foreach ($salas as $sala) : ?>
        <div class="sala card p-3 shadow-sm mb-3 text-white">
  <div class="row align-items-center text-center gy-3">
    
    <div class="col-12 col-md-3">
      <h4 class="mb-0 fw-bold"><?php echo $sala['nombre_sala']; ?></h4>
    </div>

    <div class="col-12 col-md-3">
      <h6 class="mb-1 fw-bold text-secondary">Jugadores conectados</h6>
      <p class="mb-0"><?php echo $sala['ocupacion']; ?></p>
    </div>

    <div class="col-12 col-md-3">
      <h6 class="mb-1 fw-bold text-secondary">Capacidad</h6>
      <p class="mb-0"><?php echo $sala['max_jugadores']; ?></p>
    </div>

    <div class="col-12 col-md-3">
      <a href="join_sala.php?id_sala=<?php echo $sala['id_sala']; ?>" 
         class="btn btn-danger boton-custom btn-lg">
         Unirse
      </a>
    </div>

  </div>
</div>




        <?php endforeach; ?>
    <?php endif; ?>

    <div class="text-center mt-4">
        <button class="btn btn-lg boton" data-bs-toggle="modal" data-bs-target="#modalCrearSala">
            CREAR NUEVA SALA
        </button>
    </div>
</div>


<!-- MODAL CREAR SALA -->
<div class="modal fade" id="modalCrearSala" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border border-secondary">
      <form action="crear_sala.php" method="GET"> 
        <!-- También puedes usar POST si prefieres -->
        <div class="modal-header">
          <h5 class="modal-title">Confirmar creación de sala</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input 
            class="form-control mb-3" 
            type="text" 
            name="nombre_sala" 
            placeholder="Nombre de la sala"
            required
        >

            <input type="hidden" name="tipoJuego" value="<?php echo htmlspecialchars($tipoJuego); ?>">
            <input type="hidden" name="mapa" value="<?php echo htmlspecialchars($mapaSeleccionado); ?>">
            <input type="hidden" name="capacidad" value="<?php echo htmlspecialchars($capacidad); ?>">
            <input type="hidden" name="nivel" value="<?php echo htmlspecialchars($nombre_rango); ?>">

            <p><strong>Modo de juego:</strong> <?php echo htmlspecialchars($tipoJuego); ?></p>
            <p><strong>Mapa:</strong> <?php echo htmlspecialchars($mapaSeleccionado); ?></p>
            <p><strong>Capacidad:</strong> <?php echo $capacidad; ?> jugadores</p>
            <p><strong>Nivel mínimo:</strong> <?php echo htmlspecialchars($nombre_rango); ?></p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn boton-custom text-white">Confirmar</button>
            <button type="button" class="btn boton" data-bs-dismiss="modal">Cancelar</button>
        </div>
        </form>
    </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

