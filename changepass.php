<?php
require_once("database/connection.php");
$db = new Database();
$con = $db->conectar();
session_start();

if (isset($_POST["enviar"])) {
    $contrasena = $_POST["new_contrasefia"];
    $contrasena_Verify = $_POST["confirmar_con"];

    // Validación de campos vacíos
    if (empty($contrasena) || empty($contrasena_Verify)) {
        echo "<script>alert('DATOS VACÍOS');</script>";
    }
    // Validación de formato (solo letras y números)
    else if (!preg_match("/^[a-zA-Z0-9]+$/", $contrasena)) {
        echo "<script>alert('La contraseña solo puede contener letras y números.');</script>";
    }
    else {
        // Encriptar la contraseña
        $encripted = password_hash($contrasena, PASSWORD_BCRYPT, array("cost" => 12));

        // Verificar que coincidan
      if ($contrasena === $contrasena_Verify) {
    $sql = $con->prepare("UPDATE user SET contrasena = :password WHERE id_user = :user");
    $sql->bindParam(":password", $encripted, PDO::PARAM_STR);
    $sql->bindParam(":user", $_SESSION['user'], PDO::PARAM_STR);
    $sql->execute();

    header("Location: destruir_contra.php");
    exit();
} else {
    echo "<script>alert('CONTRASEÑAS DESIGUALES');</script>";
}

    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="controller/css/style.css">
  <title>Cambiar Contraseña</title>
  <link rel="stylesheet" href="controller/css/style3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="login-custom1">

    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Lado Izquierdo (Formulario) -->
            <div class="col-md-6 left-section d-flex flex-column justify-content-center">
                <div class="text-center">
                    <img src="controller/img/logo-black1.png" alt="Logo" width="300" class="img-fluid">
                </div>
                <div class="text-center mt-3">
                    <img src="controller/img/riot_icono1.png" alt="Logo" width="120" class="img-fluid">
                </div>

                <h2 class="mb-4 text-center fw-bold">CAMBIAR CONTRASEÑA</h2>

                <form action="" method="POST" enctype="multipart/form-data" class="formulario">
                    <div class="mb-3 col-md-8 mx-auto">
                        <label for="new_contrasefia" class="form-label">Nueva Contraseña:</label>
                        <input type="password" class="form-control py-2" id="new_contrasefia" name="new_contrasefia" placeholder="********" required>
                    </div>

                    <div class="mb-3 col-md-8 mx-auto">
                        <label for="confirmar_con" class="form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control py-2" id="confirmar_con" name="confirmar_con" placeholder="********" required>
                    </div>

                    <div class="botones text-center mt-4">
                        <button type="submit" class="btn btn-custom w-75 mb-2" name="enviar">Cambiar</button>
                        <button type="button" onclick="window.location.href='login.php'" class="btn btn-outline-secondary w-75 volver">Volver</button>
                    </div>
                </form>
            </div>

            <!-- Lado Derecho (Video) -->
            <div class="col-md-6 p-0 right-section position-relative">
                <video id="videoFondo" autoplay muted loop class="w-100 h-100 object-fit-cover">
                    <source src="controller/multimedia/Animaciones/valorant-login.mp4" type="video/mp4">
                    Tu navegador no soporta el video.
                </video>

                <button id="toggleSound"
                    class="btn btn-light rounded-circle position-absolute bottom-0 end-0 m-3 shadow">
                    <i class="bi bi-volume-mute-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('videoFondo');
        const btn = document.getElementById('toggleSound');

        btn.addEventListener('click', () => {
            video.muted = !video.muted;
            btn.innerHTML = video.muted
                ? '<i class="bi bi-volume-mute-fill"></i>'
                : '<i class="bi bi-volume-up-fill"></i>';
        });
    </script>
</body>

</html>