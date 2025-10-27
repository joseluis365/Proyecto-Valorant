<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();
$id_user = 1;
$avatar = $con->prepare("SELECT id_avatar FROM user WHERE id_user = :id");
$avatar->execute([':id' => $id_user]);
$idAvatar = $avatar->fetchColumn();

$consultaAvatar = $con->prepare("SELECT avatar FROM avatar WHERE id_avatar = :id");
$consultaAvatar->execute([':id' => $idAvatar]);
$userAvatar = $consultaAvatar->fetch();


$queryUser = $con->prepare("SELECT id_banner FROM user WHERE id_user = :id");
$queryUser->execute([':id' => $id_user]);
$userBanner = $queryUser->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_banner'])) {
    $id_banner = intval($_POST['id_banner']);

    if ($id_banner > 0) {
        $update = $con->prepare("UPDATE user SET id_banner = :banner WHERE id_user = :id");
        if ($update->execute([':banner' => $id_banner, ':id' => $id_user])) {
            $userBanner = $id_banner; // actualizar variable para vista
            // echo "<script>alert('Banner actualizado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al actualizar el banner.');</script>";
        }
    }
}


$sql = $con->prepare("SELECT * FROM banner ORDER BY id_banner ASC");
$sql->execute();
$banners = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../controller/css/style2.css">
    <title>Coleccion | Valorant</title>
</head>
<body>


    <div class="top-bar">
    <a href="lobby.html" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">COLECCION</span>
    </div>

    <div class="d-flex justify-content-center">
                <h2 class="title">COLECCION</h2>
            </div>

<div class="container-fluid">

    <div class="row vh-100">

        <!-- COLUMNA IZQUIERDA -->
        <div class="banners col-3 p-3 overflow-auto " style="background-color: #2229;">
            <h4 class="subtitle mb-3 text-center">BANNERS DISPONIBLES</h4>
            <?php foreach ($banners as $b): ?>
                <img
                    src="../../controller/multimedia/banners/<?= htmlspecialchars($b['banner']) ?>"
                    class="img-fluid mb-2 banner-item <?= ($b['id_banner'] == $userBanner) ? 'borde' : '' ?>"
                    onclick="previewBanner(<?= $b['id_banner'] ?>, '<?= htmlspecialchars($b['banner']) ?>', <?= $b['id_banner'] == $userBanner ? 'true' : 'false' ?>)"
                >
            <?php endforeach; ?>
        </div>

        <!-- COLUMNA DERECHA (PREVISUALIZACIÓN) -->
        <div class="col-9 d-flex justify-content-evenly align-items-start" style=" padding-right: 0px;">
            
            <div id="previewArea" class="d-flex flex-column text-center justify-content-center align-items-center">
                <?php if ($userBanner): ?>
                    <p class="mb-2 subtitle fw-bold">TU BANNER ACTUAL</p>
                    <img src="../../controller/multimedia/banners/<?= htmlspecialchars(
                        $banners[array_search($userBanner, array_column($banners, 'id_banner'))]['banner']
                    ) ?>" class="preview-img borde">
                <?php endif; ?>
                
                

                <form method="POST" class="mt-3 d-none" id="selectForm">
                    <input type="hidden" name="id_banner" id="selectedBanner">
                    <button type="submit" class="btn btn-danger boton-custom btn-lg" style="height: 50px;">Seleccionar</button>
                </form>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center" style="margin-left: 10px;">
                <p class="subtitle">AVATAR</p>
                <div class="container-avatar">
                    <a href="avatar.php"><img src="../../controller/multimedia/avatars/<?= htmlspecialchars($userAvatar['avatar']) ?>" 
                    alt="avatar" width="100" height="100"></a>
                </div>
            </div>
            

        </div>
</div>

<script>
function previewBanner(id, file, isCurrent) {
    const previewArea = document.getElementById('previewArea');
    const img = previewArea.querySelector('img.preview-img');

    // Si ya hay imagen, solo la actualizamos
    if (img) {
        img.src = `../../controller/multimedia/banners/${file}`;
        img.className = `preview-img ${isCurrent ? 'borde' : ''}`;
    } else {
        previewArea.insertAdjacentHTML('afterbegin',
            `<img src='../../controller/multimedia/banners/${file}' class='preview-img ${isCurrent ? 'borde' : ''}'>`
        );
    }

    const form = document.getElementById('selectForm');
    const input = document.getElementById('selectedBanner');

    if (!isCurrent) {
        input.value = id;
        form.classList.remove('d-none');
    } else {
        form.classList.add('d-none');
    }
}

</script>

</body>
</html>