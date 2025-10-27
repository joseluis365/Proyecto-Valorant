<?php
require_once("database/connection.php");
$db = new Database();
$con = $db->conectar();
session_start();

if (isset($_POST['enviar'])) {
    $codigo = $_POST['codigo'];

    if (empty($codigo)) {
        echo "<script>alert('Campo vacío');</script>";
        exit();
    }

    // Verificar si el código coincide con el de la sesión
    if (isset($_SESSION['code']) && $codigo == $_SESSION['code']) {
        header("Location: changepass.php");
        exit();
    } else {
        echo "<script>alert('Código incorrecto');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="controller/css/style.css">
    <title>Verificación de Código</title>
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

                <h2 class="mb-3 text-center fw-bold">CÓDIGO DE VERIFICACIÓN</h2>

                <form action="" method="POST" enctype="multipart/form-data" class="formulario">
                    <div class="mb-3 col-md-8 mx-auto text-center">
                        <label for="codigo" class="form-label">Código*</label>
                        <input type="text" name="codigo" id="codigo" class="form-control py-2" placeholder="Escribe Tu Código" required>
                    </div>

                    <div class="botones text-center mt-4">
                        <button type="submit" name="enviar" class="btn btn-custom w-75 mb-2">Continuar</button>
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