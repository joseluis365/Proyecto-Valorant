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

// 1. OBTENER DATOS DE LA SALA
$stmt = $con->prepare("SELECT s.*, m.nombre_mapa
    FROM sala s
    INNER JOIN mapa m ON s.id_mapa = m.id_mapa
    WHERE id_sala = ?
");
$stmt->execute([$id_sala]);
$sala = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <h2 class="title text-center mb-4" style="font-size: 4rem;">LOBBY DE LA SALA <span style="font-size: 4rem;"><?php echo strtoupper($sala['tipo_juego']); ?></span></h2>

    <!-- <div class="card bg-secondary text-light p-3 mb-4">
        <p><strong>Mapa:</strong> <?php echo $sala['nombre_mapa']; ?></p>
        <p><strong>Modo de juego:</strong> <?php echo $sala['tipo_juego']; ?></p>
        <p><strong>Capacidad:</strong> <?php echo $maxJugadores; ?> jugadores</p>
    </div> -->

    <div class="row justify-content-center text-center">
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

    // Render de los jugadores a la izquierda (máx 2)
    $izquierda = array_slice($otros, 0, 2);

    // Render de los jugadores a la derecha (máx 2)
    $derecha = array_slice($otros, 2, 2);

    // Contador total ocupados
    $ocupados = count($jugadores);
    $rutaBanner = "../../controller/multimedia/banners/";

    // Función para mostrar un jugador
    function mostrarJugador($jug, $rutaBanner) {
        $banner = !empty($jug['banner']) ? $rutaBanner . $jug['banner'] : $rutaBanner . "default.png";
        return '
            <div class="xx col-12 col-md-2 mb-4 d-flex justify-content-center">
                <div class="">
                    <div class="banner-frame mx-auto mb-2">
                        <img src="'.$banner.'" alt="banner" class="banner-img">
                    <p class="nombre mb-1 text-black fw-bold">'.strtoupper($jug['usuario']).'</p>
                    <img class="icono-rango" src="../../controller/multimedia/rangos/'.$jug['icono'].'" alt="Rango" height="45" width="40"">
                    </div>
                </div>
            </div>'
        // return '
        //     <div class="col-6 col-md-2 mb-4 d-flex justify-content-center">
        //         <div>
        //             <div class="banner-frame mx-auto mb-2">
        //                 <img src="'.$banner.'" alt="banner" class="banner-img">
        //             </div>
        //             <p class="mb-1">'.$jug['usuario'].'</p>
        //             <span class="badge bg-info">'.$jug['rol'].'</span>
        //         </div>
        //     </div>';
    ;}

    // Render izquierda
    foreach ($izquierda as $jug) echo mostrarJugador($jug, $rutaBanner);

    // Si faltan jugadores a la izquierda, agregar placeholders
    for ($i = count($izquierda); $i < 2; $i++) {
        echo '
        <div class="col-6 col-md-2 mb-4 d-flex justify-content-center">
            <div class="esperando-jugador card p-2 d-flex align-items-center justify-content-center">
                <span class="text-muted">Esperando jugador...</span>
            </div>
        </div>';
    }

    // Render Host (centrado)
    if ($host) {
    $bannerHost = !empty($host['banner']) ? $rutaBanner . $host['banner'] : $rutaBanner . "default.png";
    echo '
    <div class="xx col-12 col-md-2 mb-4 d-flex justify-content-center">
        <div class="">
            <div class="banner-frame mx-auto mb-2">
                <img src="'.$bannerHost.'" alt="banner" class="banner-img">
            <p class="nombre mb-1 text-black fw-bold">'.strtoupper($host['usuario']).'</p>
            <img class="icono-rango" src="../../controller/multimedia/rangos/'.$host['icono'].'" alt="Rango" height="45" width="40"">
            </div>
            <span class="badge bg-warning text-dark">HOST</span>
        </div>
    </div>';
} else {
        // Si no hay host
        echo '
        <div class="col-12 col-md-2 mb-4 d-flex justify-content-center">
            <div class="card bg-dark border-secondary p-2 d-flex align-items-center justify-content-center" style="width:170px; height:180px;">
                <span class="text-muted">Esperando HOST...</span>
            </div>
        </div>';
    }

    // Render derecha
    foreach ($derecha as $jug) echo mostrarJugador($jug, $rutaBanner);

    // Si faltan jugadores a la derecha, agregar placeholders
    for ($i = count($derecha); $i < 2; $i++) {
        echo '
        <div class="col-6 col-md-2 mb-4 d-flex justify-content-center">
            <div class="esperando-jugador card p-2 d-flex align-items-center justify-content-center">
                <span class="text-muted">Esperando jugador...</span>
            </div>
        </div>';
    }
    ?>
</div>


    <div class="text-center mt-4">
        <?php if ($soyHost): ?>
            <a href="iniciar_partida.php?id_sala=<?php echo $id_sala; ?>" class="text-white btn btn-lg boton-custom">Iniciar partida</a>
        <?php else: ?>
            <p class="text-muted">Esperando a que el host inicie la partida...</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
