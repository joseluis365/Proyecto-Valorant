<?php
require_once "../../database/connection.php";
session_start();
$db = new database;
$con = $db->conectar();

$id_sala = $_POST['id_sala'] ?? null;

if (!$id_sala) {
    echo json_encode(["error" => "Sala no especificada"]);
    exit;
}

// Obtener jugadores de la sala
$stmt = $con->prepare("SELECT id_user FROM usuario_sala WHERE id_sala = ?");
$stmt->execute([$id_sala]);
$jugadores = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (!$jugadores) {
    echo json_encode(["error" => "No hay jugadores en la sala"]);
    exit;
}

// Crear partida
$stmt = $con->prepare("INSERT INTO partida (id_sala, estado, fecha_inicio) VALUES (?, 'en_juego', NOW())");
$stmt->execute([$id_sala]);
$id_partida = $con->lastInsertId();

// Guardar en sesión
$_SESSION['id_partida'] = $id_partida;

// Insertar jugadores en partida_jugador
$stmt = $con->prepare("INSERT INTO partida_jugador (id_partida, id_user, kills, vida_actual, puntos_totales, es_ganador)
    VALUES (?, ?, 0, 100, 0, 0)
");
foreach ($jugadores as $id_user) {
    $stmt->execute([$id_partida, $id_user]);
}

// Cambiar estado de la sala a en_juego
$stmt = $con->prepare("UPDATE sala SET estado = 'en_juego', inicio_ts = NULL WHERE id_sala = ?");
$stmt->execute([$id_sala]);

echo json_encode([
    "ok" => true,
    "id_partida" => $id_partida
]);

