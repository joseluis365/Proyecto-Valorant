<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

header('Content-Type: application/json');

$id_partida = intval($_POST['id_partida'] ?? 0);

// marcar partida finalizada
$stmt = $con->prepare("UPDATE partida SET estado = 'finalizada' WHERE id_partida = ?");
$stmt->execute([$id_partida]);

// obtener ganador (más vida o más puntos)
$stmt = $con->prepare("SELECT id_user, vida_actual, puntos_totales
FROM partida_jugador
WHERE id_partida = ?
ORDER BY vida_actual DESC, puntos_totales DESC
LIMIT 1
");
$stmt->execute([$id_partida]);
$ganador = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ganador) {
    $id_ganador = intval($ganador['id_user']);

    // marcar ganador
    $stmt = $con->prepare("UPDATE partida_jugador SET gano = 1 WHERE id_partida = ? AND id_user = ?");
    $stmt->execute([$id_partida, $id_ganador]);

    // puntos extra por ganar
    $stmt = $con->prepare("UPDATE user SET puntos = puntos + 30 WHERE id_user = ?");
    $stmt->execute([$id_ganador]);

    // actualizar rango si aplica
    $stmt = $con->prepare("SELECT puntos, id_rango FROM user WHERE id_user = ?");
    $stmt->execute([$id_ganador]);
    $usr = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usr) {
        $nuevo_rango = min(5, floor($usr['puntos'] / 250) + 1);
        if ($nuevo_rango > $usr['id_rango']) {
            $stmt = $con->prepare("UPDATE user SET id_rango = ? WHERE id_user = ?");
            $stmt->execute([$nuevo_rango, $id_ganador]);
        }
    }

    echo json_encode(['status' => 'ok', 'ganador' => $id_ganador]);
} else {
    echo json_encode(['status' => 'ok', 'ganador' => null]);
}
?>

