<?php
// get_tiempo_partida.php
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

$id_partida = intval($_GET['id_partida'] ?? 0);

$stmt = $con->prepare("SELECT fecha_inicio, estado FROM partida WHERE id_partida = ? LIMIT 1");
$stmt->execute([$id_partida]);
$partida = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$partida) {
    echo json_encode(['error' => 'Partida no encontrada']);
    exit;
}

echo json_encode([
    'fecha_inicio' => $partida['fecha_inicio'],
    'estado' => $partida['estado']
]);
