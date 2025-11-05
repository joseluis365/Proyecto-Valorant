<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id_partida  = intval($data['id_partida']);
$id_atacante = intval($data['id_atacante']);
$id_objetivo = intval($data['id_objetivo']);
$id_arma     = intval($data['id_arma']);
$parte       = $data['parte'] ?? 'cuerpo';

// Obtener info del arma
$stmt = $con->prepare("SELECT id_tipo_arma, dano_cabeza, dano_cuerpo FROM arma WHERE id_arma = ?");
$stmt->execute([$id_arma]);
$arma = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$arma) {
    echo json_encode(['error' => 'Arma no encontrada']);
    exit;
}

// Calcular daño
$dano = ($parte === 'cabeza') ? $arma['dano_cabeza'] : $arma['dano_cuerpo'];

// Vida actual del objetivo
$stmt = $con->prepare("SELECT vida_actual FROM partida_jugador WHERE id_partida = ? AND id_user = ?");
$stmt->execute([$id_partida, $id_objetivo]);
$vida_actual = intval($stmt->fetchColumn());

$vida_restante   = max(0, $vida_actual - $dano);
$es_eliminacion  = ($vida_restante <= 0);
$puntos_otorgados = 0;

// Actualizar vida del objetivo
$stmt = $con->prepare("UPDATE partida_jugador SET vida_actual = ? WHERE id_partida = ? AND id_user = ?");
$stmt->execute([$vida_restante, $id_partida, $id_objetivo]);

// Si el jugador objetivo murió
if ($es_eliminacion) {
    $response['murio'] = true;

    // Contar jugadores vivos y obtener sus IDs
    $stmt = $con->prepare("SELECT id_user FROM partida_jugador WHERE id_partida = ? AND vida_actual > 0");
    $stmt->execute([$id_partida]);
    $vivos_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($vivos_ids) <= 1) {
        // === FINALIZAR PARTIDA ===
        $stmt = $con->prepare("UPDATE partida SET estado = 'finalizada', fecha_fin = NOW() WHERE id_partida = ?");
        $stmt->execute([$id_partida]);

        $ganador_id = null;
        if (count($vivos_ids) === 1) {
            $ganador_id = intval($vivos_ids[0]);
        } else {
            // Si todos murieron (empate), gana el último atacante
            $ganador_id = $id_atacante;
        }

        // Marcar ganador en partida_jugador (nuevo campo es_ganador)
        $stmt = $con->prepare("UPDATE partida_jugador 
            SET es_ganador = CASE WHEN id_user = ? THEN 1 ELSE 0 END 
            WHERE id_partida = ?
        ");
        $stmt->execute([$ganador_id, $id_partida]);

        // Dar +30 puntos al ganador global
        $stmt = $con->prepare("UPDATE user SET puntos = puntos + 30 WHERE id_user = ?");
        $stmt->execute([$ganador_id]);

        // Revisar si sube de rango
        $stmt = $con->prepare("SELECT puntos, id_rango FROM user WHERE id_user = ?");
        $stmt->execute([$ganador_id]);
        $usr = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usr && $usr['puntos'] >= 250 && $usr['id_rango'] < 5) {
            $nuevoRango = min(5, floor($usr['puntos'] / 250) + 1);
            $stmt = $con->prepare("UPDATE user SET id_rango = ? WHERE id_user = ?");
            $stmt->execute([$nuevoRango, $ganador_id]);
        }

        $response['ganador'] = true;
        $response['ganador_id'] = $ganador_id;
    }
}

// Asignar puntos por tipo de arma
switch ($arma['id_tipo_arma']) {
    case 1: $puntos_otorgados += 1; break;  // puño
    case 2: $puntos_otorgados += 2; break;  // pistola
    case 3: $puntos_otorgados += 10; break; // ametralladora
    case 4: $puntos_otorgados += 20; break; // francotirador
}

// Puntos extra por eliminación
if ($es_eliminacion) {
    $puntos_otorgados += 5;
    if ($parte === 'cabeza') $puntos_otorgados += 75;

    // Sumar kill al atacante
    $stmt = $con->prepare("UPDATE partida_jugador SET kills = kills + 1 WHERE id_partida = ? AND id_user = ?");
    $stmt->execute([$id_partida, $id_atacante]);
}

// Actualizar puntos en partida y globales
$stmt = $con->prepare("UPDATE partida_jugador SET puntos_totales = puntos_totales + ? WHERE id_partida = ? AND id_user = ?");
$stmt->execute([$puntos_otorgados, $id_partida, $id_atacante]);

$stmt = $con->prepare("UPDATE user SET puntos = puntos + ? WHERE id_user = ?");
$stmt->execute([$puntos_otorgados, $id_atacante]);

// Verificar si sube de rango
$stmt = $con->prepare("SELECT puntos, id_rango FROM user WHERE id_user = ?");
$stmt->execute([$id_atacante]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $nuevo_rango = min(5, floor($user['puntos'] / 250) + 1);
    if ($nuevo_rango > $user['id_rango']) {
        $stmt = $con->prepare("UPDATE user SET id_rango = ? WHERE id_user = ?");
        $stmt->execute([$nuevo_rango, $id_atacante]);
    }
}

// Registrar log de disparo
$stmt = $con->prepare("INSERT INTO log_disparos 
    (id_partida, id_atacante, id_objetivo, id_arma, tipo_disparo, dano_aplicado, puntos_otorgados, es_eliminacion, vida_inicial, vida_final)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $id_partida, $id_atacante, $id_objetivo, $id_arma, $parte,
    $dano, $puntos_otorgados, $es_eliminacion ? 1 : 0,
    $vida_actual, $vida_restante
]);

$response['vida_restante'] = $vida_restante;
$response['puntos_otorgados'] = $puntos_otorgados;

echo json_encode($response);
?>



