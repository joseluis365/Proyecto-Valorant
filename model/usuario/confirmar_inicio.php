<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();

$id_sala = $_POST['id_sala'] ?? null;
if (!$id_sala) {
    echo json_encode(["error" => "Sala no especificada"]);
    exit;
}

// Cambiar el estado a "en_juego"
$stmt = $con->prepare("UPDATE sala SET estado = 'en_juego' WHERE id_sala = ?");
$stmt->execute([$id_sala]);

echo json_encode(["ok" => true]);
?>

