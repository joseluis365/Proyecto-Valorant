<?php
require_once "../../database/connection.php";
session_start();
$db = new database;
$con = $db->conectar();

$id_sala = $_POST['id_sala'] ?? null;
$id_user = $_SESSION['id_usuario'] ?? null; // asegúrate que tu sesión usa id_usuario

if (!$id_sala || !$id_user) {
    echo json_encode(["error" => "Datos insuficientes"]);
    exit;
}

// Validar que sea el host quien inicia
$stmt = $con->prepare("SELECT id_user AS host FROM usuario_sala WHERE id_sala = ? AND rol = 'Host'");
$stmt->execute([$id_sala]);
$host = $stmt->fetchColumn();

if ($host != $id_user) {
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

// Registrar timestamp 5s en el futuro
$inicio_ts = time() + 5;

$stmt = $con->prepare("UPDATE sala SET estado = 'iniciando', inicio_ts = ? WHERE id_sala = ?");
$ok = $stmt->execute([$inicio_ts, $id_sala]);

if ($ok) {
    echo json_encode([
        "ok" => true,
        "inicio_ts" => $inicio_ts
    ]);
} else {
    echo json_encode(["error" => "No se pudo actualizar la sala"]);
}


