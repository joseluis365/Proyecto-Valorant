<?php
// actualizar_vidas.php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

$id_partida = intval($_GET['id_partida'] ?? 0);
if (!$id_partida) {
    echo json_encode(['error' => 'id_partida requerido']);
    exit;
}

try {
    // obtener datos de los jugadores de la partida
    $stmt = $con->prepare("SELECT id_partida_jugador, id_user, vida_actual, kills FROM partida_jugador WHERE id_partida = ? ORDER BY id_partida_jugador ASC");
    $stmt->execute([$id_partida]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $out = [];
    foreach ($jugadores as $j) {
        $out[] = [
            'id_partida_jugador' => intval($j['id_partida_jugador']),
            'id_user' => intval($j['id_user']),
            'vida_actual' => intval($j['vida_actual']),
            'kills' => intval($j['kills']),
        ];
    }

    // comprobar estado de la partida
    $stmt = $con->prepare("SELECT estado FROM partida WHERE id_partida = ? LIMIT 1");
    $stmt->execute([$id_partida]);
    $estado = $stmt->fetchColumn() ?? 'desconocido';

    // si finalizada, devolvemos también id_partida para que el front redirija
    $resp = [
        'jugadores' => $out,
        'estado' => $estado,
        'id_partida' => $id_partida
    ];

    echo json_encode($resp);
    exit;

} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['error' => $ex->getMessage()]);
    exit;
}
