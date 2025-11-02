<?php
session_start();
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();
$id_user = 1;

// OBTENER AVATAR ACTUAL
$queryUser = $con->prepare("SELECT id_avatar FROM user WHERE id_user = :id");
$queryUser->execute([':id' => $id_user]);
$userAvatar = $queryUser->fetchColumn();

// ACTUALIZAR AVATAR SELECCIONADO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_avatar'])) {
    $id_avatar = intval($_POST['id_avatar']);

    if ($id_avatar > 0) {
        $update = $con->prepare("UPDATE user SET id_avatar = :avatar WHERE id_user = :id");
        if ($update->execute([':avatar' => $id_avatar, ':id' => $id_user])) {
            $userAvatar = $id_avatar; // actualizar variable para vista
        } else {
            echo "<script>alert('Error al actualizar el avatar.');</script>";
        }
    }
}

// OBTENER TODOS LOS AVATARES
$sql = $con->prepare("SELECT * FROM avatar ORDER BY id_avatar ASC");
$sql->execute();
$avatars = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="coleccion.php" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
    </a>
    <span class="divider">//</span>
    <span class="text-light">AVATAR</span>
    </div>

    <div class="d-flex justify-content-center">
                <h2 class="title">AVATAR</h2>
            </div>

<div class="container-fluid">

    <div class="row vh-100">

        <!-- COLUMNA IZQUIERDA -->
        <div class="banners col-3 p-3 overflow-auto " style="background-color: #2229;">
            <h4 class="subtitle mb-3 text-center">AVATARES DISPONIBLES</h4>
            <?php foreach ($avatars as $a): ?>
                <img
                    src="../../controller/multimedia/avatars/<?= htmlspecialchars($a['avatar']) ?>"
                    class="img-fluid mb-2 banner-item m-1 <?= ($a['id_avatar'] == $userAvatar) ? 'borde' : '' ?>"
                    onclick="previewAvatar(<?= $a['id_avatar'] ?>, '<?= htmlspecialchars($a['avatar']) ?>', <?= $a['id_avatar'] == $userAvatar ? 'true' : 'false' ?>)"
                >
            <?php endforeach; ?>
        </div>

        <!-- COLUMNA DERECHA (PREVISUALIZACIÓN) -->
        <div class="col-9 d-flex justify-content-center align-items-start" style=" padding-right: 350px;">
            
            <div id="previewArea" class="d-flex flex-column text-center justify-content-center align-items-center">
                <?php if ($userAvatar): ?>
                    <p class="mb-2 subtitle fw-bold">TU AVATAR ACTUAL</p>
                    <img src="../../controller/multimedia/avatars/<?= htmlspecialchars(
                        $avatars[array_search($userAvatar, array_column($avatars, 'id_avatar'))]['avatar']
                    ) ?>" class="preview-img borde">
                <?php endif; ?>
                
                <form method="POST" class="mt-3 d-none" id="selectForm">
                    <input type="hidden" name="id_avatar" id="selectedAvatar">
                    <button type="submit" class="btn btn-danger boton-custom btn-lg" style="height: 50px;">Seleccionar</button>
                </form>
            </div>
        </div>
</div>

<script>
function previewAvatar(id, file, isCurrent) {
    const previewArea = document.getElementById('previewArea');
    const img = previewArea.querySelector('img.preview-img');

    if (img) {
        img.src = `../../controller/multimedia/avatars/${file}`;
        img.className = `preview-img ${isCurrent ? 'borde' : ''}`;
    } else {
        previewArea.insertAdjacentHTML('afterbegin',
            `<img src='../../controller/multimedia/avatars/${file}' class='preview-img ${isCurrent ? 'borde' : ''}'>`
        );
    }

    const form = document.getElementById('selectForm');
    const input = document.getElementById('selectedAvatar');

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
