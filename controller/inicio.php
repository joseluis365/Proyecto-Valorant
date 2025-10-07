<?php
require_once("../database/connection.php");
$db = new database;
$con = $db->conectar();
session_start();

if ($_POST["inicio"]) {
    $nombre = $_POST["usuario"]; 
    $contra = $_POST["clave"];   

    $sql = $con ->prepare("SELECT * FROM user WHERE nombre = '$nombre' AND contrasena = '$contra'") ;

    $sql -> execute();

    $fila = $sql -> fetch();

    if ($fila){

        $_SESSION['doc_user'] = $fila ['documento'];
        $_SESSION['tipo'] = $fila ['id_tip_user'];
        echo "si encontro" ;
        echo $_SESSION['doc_user'];
        
        if ($_SESSION['tipo']== 1) {
            header("location:../model/admin/index.php");
        }
        if ($_SESSION['tipo']== 2) {
            header("location:../model/aprendiz/index.php");
        }
        if ($_SESSION['tipo']== 3) {
        header("location:../model/funcionario/index.php");
        }

    }

    else{
        echo '<script> alert("usuario no encontrado")</scritp>' ; 
    }

}
else{

}

?>