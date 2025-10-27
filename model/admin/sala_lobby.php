<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

if (!isset($_GET['id_sala'])) {
    header("Location: listar_salas.php");
    exit;
}

$id_sala = $_GET['id_sala'];
$user_id = 1;

// 1. OBTENER DATOS DE LA SALA
$stmt = $con->prepare("SELECT s.*, m.nombre_mapa
    FROM sala s
    INNER JOIN mapa m ON s.id_mapa = m.id_mapa
    WHERE id_sala = ?
");
$stmt->execute([$id_sala]);
$sala = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sala) {
    die("Sala no encontrada.");
}

$maxJugadores = $sala['max_jugadores'];

// 2. OBTENER JUGADORES DENTRO DE LA SALA
$stmt = $con->prepare("SELECT us.id_user, us.rol, u.usuario, a.avatar
    FROM usuario_sala us
    INNER JOIN user u ON us.id_user = u.id_user
    INNER JOIN avatar a ON u.id_avatar = a.id_avatar
    WHERE us.id_sala = ?
");
$stmt->execute([$id_sala]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si el usuario actual es Host
$soyHost = false;
foreach ($jugadores as $jug) {
    if ($jug['id_user'] == $user_id && $jug['rol'] === "Host") {
        $soyHost = true;
        break;
    }
}

// 3. RUTAS
$rutaAvatar = "../../controller/multimedia/avatars/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lobby de la Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Lobby de la Sala #<?php echo $id_sala; ?></h2>

    <div class="card bg-secondary text-light p-3 mb-4">
        <p><strong>Mapa:</strong> <?php echo $sala['nombre_mapa']; ?></p>
        <p><strong>Modo de juego:</strong> <?php echo $sala['tipo_juego']; ?></p>
        <p><strong>Capacidad:</strong> <?php echo $maxJugadores; ?> jugadores</p>
    </div>

    <div class="row text-center">
        <?php
        $ocupados = 0;
        foreach ($jugadores as $jug) {
            $ocupados++;
            $avatar = !empty($jug['avatar']) ? $rutaAvatar . $jug['avatar'] : $rutaAvatar . "default.png";
            echo '
            <div class="col-6 col-md-3 mb-4">
                <div class="card bg-dark border-light p-2">
                    <img src="'.$avatar.'" alt="avatar" class="img-fluid rounded mb-2" style="height:120px; object-fit:cover;">
                    <p>'.$jug['usuario'].'</p>
                    <span class="badge bg-info">'.$jug['rol'].'</span>
                </div>
            </div>';
        }

        // Espacios vacíos
        for ($i = $ocupados; $i < $maxJugadores; $i++) {
            echo '
            <div class="col-6 col-md-3 mb-4">
                <div class="card bg-dark border-secondary p-2" style="height:180px; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted">Esperando jugador...</span>
                </div>
            </div>';
        }
        ?>
    </div>

    <div class="text-center mt-4">
        <?php if ($soyHost): ?>
            <a href="iniciar_partida.php?id_sala=<?php echo $id_sala; ?>" class="btn btn-success">Iniciar partida</a>
        <?php else: ?>
            <p class="text-muted">Esperando a que el host inicie la partida...</p>
        <?php endif; ?>

        <a href="salir_sala.php?id_sala=<?php echo $id_sala; ?>" class="btn btn-danger ms-2">Salir</a>
    </div>
</div>

</body>
</html>
