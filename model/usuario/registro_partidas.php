<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;

$con = $db-> conectar();

$id_user = $_SESSION['id_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Partidas | Valorant</title>
  <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
  <link rel="stylesheet" href="../../controller/css/style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">

  <!-- Invocar a JQuery para que funcione el archivo JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="busqueda.js"></script>
</head>
<body class="bg-light login-custom">
    <div class="top-bar">
      <a href="lobby_offi.php" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
      </a>
      <span class="divider">//</span>
      <span class="text-light">CARRERA</span>
    </div>

  <main class="container py-4">
    <header class="mb-4">
      <h1 class="jugar text-white">CARERA</h1>
      <p class="text-danger fw-bold">Aquí Puedes ver los registros de tus partidas</p>
    </header>
  </main>

  <!-- <div class="container">
        <div class="row">
            <div class="col">
                 
                <table class="table table-striped tablas table-hover table-sm table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripcion</th>
                            <th>Imagen</th>
                            <th>Tipo De Articulo</th>
                            <th>Publicado Por Ti</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articulos as $fila): ?>
                        <tr>
                            <td><?php echo $fila['nombre_art']; ?></td>
                            <td><?php echo "$" . number_format($fila['precio'], 0, ',', ','); ?></td>
                            <td><?php echo $fila['descripcion']; ?></td>
                            <td><?php echo $fila['imagen']; ?></td>
                            <td><?php echo $fila['tipo_articulo']; ?></td>
                            <td><?php echo $fila['user']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
</body>
</html>