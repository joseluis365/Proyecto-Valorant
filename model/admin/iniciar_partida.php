<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db-> conectar();


if (!isset($_GET['id_sala'])) {
    header("Location: listar_salas.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id_sala = $_GET['id_sala'];

/* 1. Verificar que el usuario es host */
$stmt = $con->prepare("SELECT rol FROM usuario_sala 
    WHERE id_sala = ? AND id_user = ?
");
$stmt->execute([$id_sala, $user_id]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datos || $datos['rol'] !== 'Host') {
    die("No tienes permisos para iniciar la partida.");
}

/* 2. Cambiar estado de la sala */
$stmt = $con->prepare("UPDATE sala SET estado = 'En juego' WHERE id_sala = ?");
$stmt->execute([$id_sala]);

/* 3. Redirigir a la partida */
header("Location: partida.php?id_sala=" . $id_sala);
exit;
