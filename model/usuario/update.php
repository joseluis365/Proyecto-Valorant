<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

session_start();
require_once("../../database/connection.php");
$db = new Database();
$con = $db->conectar();

$id_user = $_GET['id'];

// Consultar datos del usuario
$query = $con->prepare("SELECT * FROM user WHERE id_user = :id_user");
$query->bindParam(":id_user", $id_user);
$query->execute();
$usuario = $query->fetch(PDO::FETCH_ASSOC);

// Si se presiona el botón para desbloquear
if (isset($_POST['desbloquear'])) {
    try {
        // Cambiar estado a activo
        $update = $con->prepare("UPDATE user SET id_estado = 1 WHERE id_user = :id_user");
        $update->bindParam(":id_user", $id_user);
        $update->execute();

        // Enviar correo de notificación
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bastobrayan246@gmail.com';
        $mail->Password   = 'buhk pmqz fugv ruar';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('bastobrayan246@gmail.com', 'Administrador Valorant');

        $mail->addAddress($usuario['email'], $usuario['nombre']);

        $mail->isHTML(true);
        $mail->Subject = 'Tu cuenta ha sido activada';
        $mail->Body    = "
            <h2>¡Buenas noticias, {$usuario['nombre']}!</h2>
            <p>Tu cuenta ha sido <b>activada</b> nuevamente y ya puedes ingresar al sistema.</p>
            <p>Gracias por tu paciencia.</p>
            <br>
            <p>Atentamente,<br><b>Equipo Valorant</b></p>
        ";

        $mail->send();

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Error al enviar el correo: {$mail->ErrorInfo}</div>";
    }
}

// Si se presiona el botón para bloquear
if (isset($_POST['bloquear'])) {
    try {
        // Cambiar estado a bloqueado
        $update = $con->prepare("UPDATE user SET id_estado = 2 WHERE id_user = :id_user");
        $update->bindParam(":id_user", $id_user);
        $update->execute();

        // Enviar correo de notificación de bloqueo
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bastobrayan246@gmail.com';
        $mail->Password   = 'buhk pmqz fugv ruar';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('bastobrayan246@gmail.com', 'Administrador Valorant');
        $mail->addAddress($usuario['email'], $usuario['nombre']);

        $mail->isHTML(true);
        $mail->Subject = 'Tu cuenta ha sido bloqueada';
        $mail->Body    = "
            <h2>Hola, {$usuario['nombre']}.</h2>
            <p>Lamentamos informarte que tu cuenta ha sido <b>bloqueada</b> temporalmente por el equipo de administración.</p>
            <p>Si consideras que esto es un error, comunícate con soporte.</p>
            <br>
            <p>Atentamente,<br><b>Equipo Valorant</b></p>
        ";

        $mail->send();

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Error al enviar el correo: {$mail->ErrorInfo}</div>";
    }
}
?>

<!-- HTML del modal -->
<div class="container p-3">
    <h6 class="jugar1"><strong>Detalles Del Usuario</strong></h6>

    <p class="jugar2"><b><strong>Nombre:</strong></b>
        <span class="dato"><?= htmlspecialchars($usuario['nombre']) ?></span>
    </p>

    <p class="jugar2"><b><strong>Usuario:</strong></b>
        <span class="dato"><?= htmlspecialchars($usuario['usuario']) ?></span>
    </p>

    <p class="jugar2"><b><strong>Email:</strong></b>
        <span class="dato"><?= htmlspecialchars($usuario['email']) ?></span>
    </p>

    <p class="jugar2"><b><strong>Estado Actual:</strong></b>
        <?php if ($usuario['id_estado'] == 1): ?>
            <span class="text-success fw-bold">Activo</span>
        <?php else: ?>
            <span class="text-danger fw-bold">Bloqueado</span>
        <?php endif; ?>
    </p>

    <?php if ($usuario['id_estado'] == 2): ?>
        <!-- Desbloquear -->
        <form method="POST" action="update.php?id=<?= $usuario['id_user'] ?>">
            <button type="submit" name="desbloquear" class="btn btn-outline-success w-100 jugar2">
                DESBLOQUEAR
            </button>
        </form>

    <?php else: ?>
        <!-- Bloquear -->
        <form method="POST" action="update.php?id=<?= $usuario['id_user'] ?>">
            <button type="submit" name="bloquear" class="btn btn-outline-danger w-100 jugar2">
                BLOQUEAR
            </button>
        </form>
    <?php endif; ?>
</div>
