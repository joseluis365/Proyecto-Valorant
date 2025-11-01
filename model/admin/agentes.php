<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

$id_user = $_SESSION['id_usuario'];

// ACTUALIZAR PERSONAJE SI SE ENVÍA POR POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_personaje'])) {
    $id_personaje = intval($_POST['id_personaje']);
    if ($id_personaje > 0) {
        $update = $con->prepare("UPDATE user SET id_personaje = :personaje WHERE id_user = :id");
        $update->execute([':personaje' => $id_personaje, ':id' => $id_user]);
    }
}

// Consultar datos del usuario
$avatar = $con->prepare("SELECT id_avatar FROM user WHERE id_user = :id");
$avatar->execute([':id' => $id_user]);

// Consultar el personaje seleccionado actualmente
$query_personaje_sel = $con->prepare("SELECT id_personaje FROM user WHERE id_user = ?");
$query_personaje_sel->execute([$id_user]);
$id_personaje_sel = $query_personaje_sel->fetchColumn();

// Consultar rango del usuario
$query_rango = $con->prepare("SELECT id_rango FROM user WHERE id_user = ?");
$query_rango->execute([$id_user]);
$user_rango = $query_rango->fetch(PDO::FETCH_ASSOC)['id_rango'];

// Consultar personajes con su rango e icono
$query_personajes = $con->prepare("
    SELECT p.*, r.icono AS icono_rango
    FROM personaje p
    LEFT JOIN rango r ON p.rango_requerido = r.id_rango
");

$query_personajes->execute();
$personajes = $query_personajes->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agentes | Valorant</title>
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style2.css">
</head>

<body class="agent">
    <div class="top-bar">
        <a href="lobby.php" class="back-link">
            <div class="back-icon"></div>
            <span class="text-muted">ATRÁS</span>
        </a>
        <span class="divider">//</span>
        <span class="text-light">AGENTES</span>
    </div>
    <div class="container text-center">
    <div class="row d-flex justify-content-">
        <div class="title-container d-flex justify-content-center align-items-start flex">
        <h1 class="jugar title" style="font-size: 4rem;">AGENTES</h1>
    </div>
    <div class="text-container d-flex justify-content-center my-1">
    <p><span class="jugar4 fw-bold text-danger">VALORANT CUENTA CON VARIOS PERSONAJES QUE PUEDES IR DESBLOQUEANDO DURANTE TU ASCENSO DE RANGO</p>
    </div>
    <div class="container py-2">
        <div class="row g-4 justify-content-center">

            <?php foreach ($personajes as $personaje): ?>
                <?php
                $bloqueado = $personaje['rango_requerido'] > $user_rango;
                $seleccionado = ($personaje['id_personaje'] == $id_personaje_sel);
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <form method="POST">
                        <input type="hidden" name="id_personaje" value="<?= $personaje['id_personaje'] ?>">
                        <div class="card agent-card <?= $bloqueado ? 'bloqueado' : '' ?> <?= $seleccionado ? 'seleccionado' : '' ?>"
                            <?= $bloqueado ? '' : 'onclick="this.parentNode.submit()"' ?>>
                            <div class="img-wrapper position-relative">
                                <img src="../../controller/multimedia/Personajes/<?= htmlspecialchars($personaje['imagen_personaje']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($personaje['nombre_personaje']) ?>">

                                <?php if ($bloqueado): ?>
                                    <div class="candado-overlay">
                                        <img src="../../controller/multimedia/rangos/<?= htmlspecialchars($personaje['icono_rango']) ?>"
                                            alt="Bloqueado" class="candado">
                                    </div>
                                <?php elseif ($seleccionado): ?>
                                    <div class="seleccion-overlay">
                                        <span>SELECCIONADO</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="jugar3 agent-name"><?= strtoupper($personaje['nombre_personaje']) ?></h5>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>