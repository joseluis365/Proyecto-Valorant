<?php
session_start();
require_once("../../database/connection.php");
$db = new database;
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM rango ORDER BY id_rango ASC");
$sql->execute();
$rangos = $sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangos | Valorant</title>
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style2.css">
</head>
<body>
    <div class="top-bar">
    <a href="lobby.html" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">RANGOS</span>
    </div>
    <div class="container text-center">
    <div class="row d-flex justify-content-">
        <div class="title-container d-flex justify-content-center align-items-start flex">
        <h1 class="title" style="font-size: 4rem;">RANGOS COMPETITIVOS</h1>
        
    </div>
    <div class="text-container">
    <p><span class="fw-bold">Valorant cuenta con cinco rangos competitivos Platino, Diamante, Ascendente, Inmortal, y Radiante que reflejan la progresión del jugador dentro del modo clasificado.</span> Al disputar partidas y ganar Puntos de Clasificación, los jugadores pueden ascender de un rango a otro, demostrando mejora constante, coordinación estratégica y dominio del juego.</p>
    </div>
    
    </div>
    </div>
    <div class="col-12 rangos-container mx-auto">
        <?php  foreach ($rangos as $rango): ?>
            <?php
        $width = '100%';
        switch ($rango['id_rango']) {
            case 1:
                $width = '130%';
                break;
            case 2:
                $width = '130%';
                break;
            case 3:
                $width = '140%';
                break;
            case 4:
                $width = '130%';
                break;
            case 5:
                $width = '100%';
                break;
        }
        ?>
        <div class="d-flex flex-column align-items-start"> 
            <div class="text-align-center sub-container" style="width: <?= $width ?>;">
                <p class="fw-bold" style="margin-bottom: 5px;"><?= htmlspecialchars($rango['nombre_rango']) ?></p>
            </div>
            <div class="image-container" style="width: <?= $width ?>;">
                <img src="../../controller/multimedia/rangos/<?= htmlspecialchars($rango['icono']) ?>"
                alt="Rango <?= htmlspecialchars($rango['nombre_rango']) ?> en Valorant"
                style="width: 100%;">
            </div>
        </div>
        <?php endforeach; ?>

        <!-- <div class="d-flex flex-column align-items-center"> 
            <div class="text-align-center sub-container">
                <p style="margin-bottom: 5px;">Platino</p>
            </div>
            <div class="image-container">
                <img src="../../controller/multimedia/rangos/platino.png" alt="Rango Platino en Valorant">
            </div>
        </div> -->
        <!-- <div>
            <img src="../../controller/multimedia/rangos/diamante.png" alt="Rango Diamante en Valorant">
        </div>
        <div>
            <img src="../../controller/multimedia/rangos/ascendente.png" alt="Rango Ascendente en Valorant" width="130">
        </div>
        <div>
            <img src="../../controller/multimedia/rangos/Inmortal.png" alt="Rango Inmortal en Valorant" width="150">
        </div>
        <div>
            <img src="../../controller/multimedia/rangos/radiante.png" alt="Rango Radiante en Valorant">
        </div> -->
    </div>
</body>
</html>