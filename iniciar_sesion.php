<?php
session_start();
require_once("database/connection.php");
$db = new Database;
$con = $db->conectar();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $usuario = trim($_POST['usuario']);
        $contra = trim($_POST['contrasena']);

        $sql = $con->prepare("SELECT * FROM user WHERE usuario = ?");
        $sql->execute([$usuario]);
        $fila = $sql->fetch(PDO::FETCH_ASSOC);

        if ($fila && password_verify($contra, $fila['contrasena'])) {

            // Guardar fecha y hora actual en ultimo_login
            $fecha_login = date('Y-m-d H:i:s');
            $update = $con->prepare("UPDATE user SET ultimo_login = :fecha WHERE id_user = :id");
            $update->bindParam(':fecha', $fecha_login);
            $update->bindParam(':id', $fila['id_user']);
            $update->execute();

            // Guardar datos en sesión
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['email'] = $fila['email'];
            $_SESSION['tipo'] = $fila['id_tipo_user'];
            $_SESSION['estado'] = $fila['id_estado'];
            $_SESSION['rango'] = $fila['id_rango'];
            $_SESSION['id_usuario'] = $fila['id_user'];

            // Lógica de acceso según tipo y estado
            if ($fila['id_tipo_user'] == 2 && $fila['id_estado'] == 1) {
                echo json_encode(["entrar" => "Bienvenido usuario", "redirect" => "model/usuario/lobby_offi.php"]);
                exit();
            }

            if ($fila['id_tipo_user'] == 2 && $fila['id_estado'] == 2) {
                echo json_encode(["error" => "Tu cuenta está bloqueada. Comunícate con un administrador."]);
                exit();
            }

            if ($fila['id_tipo_user'] == 1 && $fila['id_estado'] == 1) {
                echo json_encode(["entrar" => "Bienvenido administrador", "redirect" => "model/admin/lobby.php"]);
                exit();
            }

            if ($fila['id_tipo_user'] == 1 && $fila['id_estado'] == 2) {
                echo json_encode(["error" => "Tu cuenta de administrador está bloqueada."]);
                exit();
            }

        } else {
            echo json_encode(["error" => "Usuario o contraseña incorrectos."]);
            exit();
        }

    } else {
        echo json_encode(['error' => 'Método no permitido.']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>
