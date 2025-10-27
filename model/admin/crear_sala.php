<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

if (!isset($_GET['tipoJuego']) || !isset($_GET['mapa'])) {
    header("Location: listar_salas.php");
    exit;
}

$user_id     = 1;
$nombreSala = $_GET['nombre_sala'];
$tipoJuego   = $_GET['tipoJuego'];
$mapaNombre  = $_GET['mapa'];

// OBTENER ID DEL MAPA (flexible mayúsculas, espacios)
$stmt = $con->prepare("SELECT id_mapa FROM mapa WHERE TRIM(UPPER(nombre_mapa)) = TRIM(UPPER(?))");
$stmt->execute([$mapaNombre]);
$mapaData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mapaData) {
    die("Mapa no encontrado en la base de datos.");
}

$id_mapa = $mapaData['id_mapa'];

// OBTENER RANGO DEL HOST
$stmt = $con->prepare("SELECT id_rango FROM user WHERE id_user = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$id_rango = $userData['id_rango'];

// CAPACIDAD AUTOMÁTICA
$maxJugadores = ($tipoJuego === "1vs1") ? 2 : 5;

// INSERTAR LA SALA
$stmt = $con->prepare("INSERT INTO sala (nombre_sala, tipo_juego, id_mapa, max_jugadores, id_nivel_min, estado, fecha_creacion)
                       VALUES (?, ?, ?, ?, ?, 'Disponible', NOW())");
$stmt->execute([$nombreSala, $tipoJuego, $id_mapa, $maxJugadores, $id_rango]);

$id_sala = $con->lastInsertId();

// INSERTAR HOST EN usuario_sala (sin fecha)
$stmt = $con->prepare("INSERT INTO usuario_sala (id_sala, id_user, rol)
                       VALUES (?, ?, 'Host')");
$stmt->execute([$id_sala, $user_id]);

// REDIRIGIR AL LOBBY
header("Location: sala_lobby.php?id_sala=" . $id_sala);
exit;
