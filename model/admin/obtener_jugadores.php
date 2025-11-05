<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();

$id_sala = $_GET['id_sala'] ?? null;
if (!$id_sala) {
    echo json_encode(["error" => "Sala no especificada"]);
    exit;
}

// Obtener datos de la sala
$stmt = $con->prepare("SELECT estado, max_jugadores, inicio_ts FROM sala WHERE id_sala = ?");
$stmt->execute([$id_sala]);
$sala = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$sala) {
    echo json_encode(["error" => "Sala no encontrada"]);
    exit;
}

// Obtener jugadores actuales
$stmt = $con->prepare("SELECT us.id_user, us.rol, u.usuario, b.banner, r.icono
    FROM usuario_sala us
    INNER JOIN user u ON us.id_user = u.id_user
    INNER JOIN rango r ON u.id_rango = r.id_rango
    INNER JOIN banner b ON u.id_banner = b.id_banner
    WHERE us.id_sala = ?");
$stmt->execute([$id_sala]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rutaBanner = "../../controller/multimedia/banners/";

// Renderizar HTML de jugadores
function renderJugador($jug, $rutaBanner) {
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

$html = "";
$maxJugadores = (int) $sala['max_jugadores'];

if ($jugadores) {
    $host = null;
    $otros = [];
    foreach ($jugadores as $jug) {
        if ($jug['rol'] === "Host") $host = $jug;
        else $otros[] = $jug;
    }

    if ($host) $html .= renderJugador($host, $rutaBanner);
    foreach ($otros as $jug) $html .= renderJugador($jug, $rutaBanner);

    $faltantes = $maxJugadores - count($jugadores);
    for ($i = 0; $i < $faltantes; $i++) {
        $html .= '<div class="jugador-card esperando-jugador card p-3 d-flex align-items-center justify-content-center" 
                    style="width:170px; height:180px;">
                    <span class="text-muted">Esperando jugador...</span>
                </div>';
    }
}

echo json_encode([
    "html" => $html,
    "count" => count($jugadores),
    "max" => $maxJugadores,
    "estado" => $sala['estado'],
    "inicio_ts" => $sala['inicio_ts'] ?? null
]);
?>

