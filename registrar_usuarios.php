<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir datos del formulario
        $usuario = trim($_POST['usuario']);
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        // Verificar que no exista el usuario o el correo
        $sql = $con->prepare("SELECT * FROM user WHERE usuario = '$usuario' OR email = '$email'");
        $sql->execute();
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            echo json_encode(["error" => "El usuario o correo ya están registrados"]);
            exit;

        } else if ($usuario == '' || $nombre == "" || $email == "" || $contrasena == "") {
            echo json_encode(["error" => "Por favor diligencie todos los datos"]);
            exit;
            
        } else {
            $pass_cifrado = password_hash($contrasena, PASSWORD_DEFAULT, array("cost" => 12));

            $id_tipo_user = 1; // Usuario normal
            $id_estado = 2;    // Bloqueado
            $id_rango = 1;     // Platino

            $sql = $con->prepare("INSERT INTO user (nombre, usuario, email, contrasena, id_tipo_user, id_estado, id_rango)
            VALUES ('$nombre', '$usuario', '$email', '$pass_cifrado', '$id_tipo_user', '$id_estado', '$id_rango')");
            $sql->execute();
            echo json_encode(["message" => "Usuario registrado correctamente. Espera aprobación del administrador."]);
            exit;
        }
        
    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>
