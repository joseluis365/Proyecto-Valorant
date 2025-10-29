<?php
session_start();
require_once("../../database/connection.php");
$db = new database;
$con = $db->conectar();

$sql = $con->prepare("SELECT a.*, t.tipo_arma
    FROM arma a
    INNER JOIN tipo_arma t ON a.id_tipo_arma = t.id_tipo_arma
    ORDER BY FIELD(t.id_tipo_arma, 2, 3, 4, 1), a.img_arma ASC
");
$sql->execute();
$armas = $sql->fetchAll(PDO::FETCH_ASSOC);

// Agrupar las armas por tipo
$grupos = [];
foreach ($armas as $arma) {
    $grupos[$arma['tipo_arma']][] = $arma;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armas | Valorant</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kfy5R3xK4B8...etc"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style2.css">
</head>
<body>
    <div class="top-bar">
    <a href="lobby.php" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">ARSENAL</span>
    </div>
    <div class="container text-center">
        <div class="title-container d-flex justify-content-center align-items-start">
        <h1 class="title" style="font-size: 4rem;">ARSENAL</h1>
    </div>
    <div class="row d-flex justify-content-center">
        
        <?php foreach (['Pistola', 'Ametralladora', 'Francotirador', 'Melee'] as $tipo): ?>
    <div class="columna col-3">
        <div class="title-container d-flex justify-content-center">
            <h4 class="subtitle text-uppercase"><?= htmlspecialchars($tipo) ?><?= $tipo === 'Melee' ? '' : 'S' ?></h4>
        </div>

        <?php if (isset($grupos[$tipo])): ?>
            <?php foreach ($grupos[$tipo] as $arma): ?>
                <?php
        // Cambia el ancho según el tipo de arma
        $width = '100%';
        switch ($arma['tipo_arma']) {
            case 'Pistola':
                $width = '95%';
                break;
            case 'Ametralladora':
                $width = '130%';
                break;
            case 'Francotirador':
                $width = '120%';
                break;
            case 'Melee':
                $width = '110%';
                break;
        }
        ?>
                <div class="container-arma d-flex justify-content-center align-items-center">
                    <img class="img"
                        src="../../controller/multimedia/Armas/<?= htmlspecialchars($arma['img_arma']) ?>"
                        alt="<?= htmlspecialchars($arma['nombre_arma']) ?>"
                        style="width: <?= $width ?>;">
                    <div class="card-overlay">
                        <h5><?= htmlspecialchars($arma['nombre_arma']) ?></h5>
                        <p><?= htmlspecialchars($arma['descrip_arma']) ?></p>
                        <p style="margin-bottom: 0;"><strong><i class="fa-solid fa-skull"></i>  Daño Cabeza: </strong> <?= htmlspecialchars($arma['dano_cabeza']) ?></p>
                        <p class="mt-0"><strong><i class="fa-solid fa-person"></i> Daño Cuerpo: </strong> <?= htmlspecialchars($arma['dano_cuerpo']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">Sin armas registradas</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
    </div>
</body>
</html>