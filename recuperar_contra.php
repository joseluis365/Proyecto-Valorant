<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

session_start();
require_once("database/connection.php");
$db = new Database();
$con = $db->conectar();

if (isset($_POST['enviar'])) {
    $elEmail = $_POST['input_correo'];

    if (empty($elEmail)) {
        echo "<script>alert('El campo correo está vacío');</script>";
        die();
    }

    // Consultar si el correo existe
    $Cemail = $con->prepare("SELECT email FROM user WHERE email = :email");
    $Cemail->bindParam(":email", $elEmail);

    $Cemail->execute();
    $Cenviar = $Cemail->fetchColumn();

    // Obtener datos del usuario
    $user = $con->prepare("SELECT * FROM user WHERE email = :email");
    $user->bindParam(":email", $elEmail);
    $user->execute();
    $usuario = $user->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Generar un código aleatorio
        $numero_aleatorio = rand(1000, 9999);

        $_SESSION['user'] = $usuario['id_user'];
        $_SESSION['code'] = $numero_aleatorio;

        if ($Cenviar) {
            // Configuración de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'bastobrayan246@gmail.com'; // tu correo
                $mail->Password   = 'buhk pmqz fugv ruar'; // usa contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipientes
                $mail->setFrom('bastobrayan246@gmail.com', 'Recordar Contraseña');
                $mail->addAddress($Cenviar);

                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'CONTRA NUEVA - Reestablecer contraseña';
                $mail->Body    = "Su código para restablecer la contraseña es el siguiente: <b>" . $_SESSION['code'] . "</b>";
                $mail->AltBody = "Su código para restablecer la contraseña es: " . $_SESSION['code'];

                $mail->send();

                header("Location: verify_code.php");
                exit();
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        echo "<script>alert('Correo no encontrado');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="controller/css/style3.css">
    <title>Recuperar Contraseña</title>
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

                <h2 class="jugar mb-4 text-center fw-bold mt-2">RECORDAR CONTRASEÑA</h2>

                <form action="" method="POST" enctype="multipart/form-data" class="formulario">
                    <div class="mb-3 col-md-8 mx-auto text-center">
                        <label for="input_correo" class="form-label">Correo:</label>
                        <input type="email" name="input_correo" id="input_correo" class="form-control py-2" placeholder="example@gmail.com" required>
                    </div>
                    
                    <div class="botones text-center mt-4">
                        <button type="submit" name="enviar" class="btn btn-custom w-75 mb-2">Enviar Código</button>
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