<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_sala'])) {
    header("Location: modos_juego.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id_sala = $_GET['id_sala'];

/* 1. ELIMINAR JUGADOR DE LA SALA */
$stmt = $con->prepare("DELETE FROM usuario_sala WHERE id_sala = ? AND id_user = ?");
$stmt->execute([$id_sala, $user_id]);

/* 2. VERIFICAR SI QUEDAN JUGADORES */
$stmt = $con->prepare("SELECT id_user, rol FROM usuario_sala WHERE id_sala = ? ORDER BY id_usu_sala ASC");
$stmt->execute([$id_sala]);
$jugadoresRestantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($jugadoresRestantes) == 0) {
    // 3. SI NO QUEDA NADIE → ELIMINAR SALA
    $stmt = $con->prepare("DELETE FROM sala WHERE id_sala = ?");
    $stmt->execute([$id_sala]);

    header("Location: listar_salas.php");
    exit;
}

/* 4. SI EL QUE SE FUE ERA HOST → TRANSFERIR HOST */
$eraHost = false;
foreach ($jugadoresRestantes as $j) {
    if ($j['rol'] === 'Host') {
        $eraHost = false; // Aún hay un host
        break;
    }
}

// Si ya no queda host, asignar el primero de la lista como nuevo host
if (!$eraHost) {
    // ver si hay algún host todavía
    $verificarHost = $con->prepare("SELECT COUNT(*) FROM usuario_sala WHERE id_sala = ? AND rol = 'Host'");
    $verificarHost->execute([$id_sala]);
    $existeHost = $verificarHost->fetchColumn();

    if ($existeHost == 0) {
        $nuevoHost = $jugadoresRestantes[0]['id_user'];
        $stmt = $con->prepare("UPDATE usuario_sala SET rol = 'Host' WHERE id_sala = ? AND id_user = ?");
        $stmt->execute([$id_sala, $nuevoHost]);
    }
}

/* 5. REDIRIGIR A LISTAR SALAS */
header("Location: listar_salas.php");
exit;
