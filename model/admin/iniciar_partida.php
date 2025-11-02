<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();

$id_sala = $_POST['id_sala'] ?? null;
if (!$id_sala) {
    echo json_encode(["error" => "Sala no especificada"]);
    exit;
}

// Guardar estado como "iniciando" y registrar timestamp de inicio (5 seg después)
$inicio_ts = time() + 5;
$stmt = $con->prepare("UPDATE sala SET estado = 'iniciando', inicio_ts = ? WHERE id_sala = ?");
$stmt->execute([$inicio_ts, $id_sala]);

echo json_encode(["ok" => true, "inicio_ts" => $inicio_ts]);
?>

