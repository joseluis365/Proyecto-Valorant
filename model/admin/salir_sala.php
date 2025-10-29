<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

if (!isset($_SESSION['id_usuario'])) {
    die("No autenticado");
}

$user_id = intval($_SESSION['id_usuario']);
$id_sala = intval($_GET['id_sala'] ?? 0);

try {
    $con->beginTransaction();

    // 1️⃣ Eliminar al usuario de la sala
    $stmt = $con->prepare("DELETE FROM usuario_sala WHERE id_sala = ? AND id_user = ?");
    $stmt->execute([$id_sala, $user_id]);

    // 2️⃣ Revisar cuántos jugadores quedan en la sala
    $stmt = $con->prepare("SELECT COUNT(*) FROM usuario_sala WHERE id_sala = ?");
    $stmt->execute([$id_sala]);
    $totalJugadores = intval($stmt->fetchColumn());

    if ($totalJugadores == 0) {
        // 3️⃣ Si no quedan jugadores, revisar que la sala no esté en juego
        $stmt = $con->prepare("SELECT estado FROM sala WHERE id_sala = ?");
        $stmt->execute([$id_sala]);
        $estado = $stmt->fetchColumn();

        if ($estado === 'disponible') {
            // 4️⃣ Eliminar la sala si está vacía y no ha comenzado
            $stmt = $con->prepare("DELETE FROM sala WHERE id_sala = ?");
            $stmt->execute([$id_sala]);
        }
    } else {
        // 5️⃣ Si aún hay jugadores, verificar que quede un host
        $stmt = $con->prepare("SELECT COUNT(*) FROM usuario_sala WHERE id_sala = ? AND rol = 'Host'");
        $stmt->execute([$id_sala]);
        $hayHost = intval($stmt->fetchColumn());

        if ($hayHost == 0) {
            // reasignar host al jugador más antiguo
            $stmt = $con->prepare("SELECT id_user FROM usuario_sala WHERE id_sala = ? ORDER BY joined_at ASC LIMIT 1");
            $stmt->execute([$id_sala]);
            $nuevoHost = $stmt->fetchColumn();
            if ($nuevoHost) {
                $stmt = $con->prepare("UPDATE usuario_sala SET rol = 'Host' WHERE id_sala = ? AND id_user = ?");
                $stmt->execute([$id_sala, $nuevoHost]);
            }
        }
    }

    $con->commit();

    header("Location: listar_salas.php");
    exit;
} catch (Exception $e) {
    $con->rollBack();
    die("Error al salir de la sala: " . $e->getMessage());
}

