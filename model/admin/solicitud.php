<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db-> conectar();

$id_user = $_SESSION['id_usuario'];

$sql = $con->prepare("SELECT user.*, tip_user.tipo_user, rango.*
    FROM user
    INNER JOIN tip_user ON user.id_tipo_user = tip_user.id_tipo_user
    INNER JOIN rango ON user.id_rango = rango.id_rango
    WHERE user.id_user = $id_user");
$sql->execute();

$fila = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solicitudes de Jugadores | Valorant</title>
  <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
  <link rel="stylesheet" href="../../controller/css/style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <!-- Invocar a JQuery para que funcione el archivo JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="busqueda.js"></script>
</head>

<body class="bg-light login-custom">
    <div class="top-bar">
      <a href="lobby.php" class="back-link">
        <div class="back-icon"></div>
        <span class="text-muted">ATRÁS</span>
      </a>
      <span class="divider">//</span>
      <span class="text-light">SOLICITUD</span>
    </div>



  <main class="container py-4">
    <header class="mb-4">
      <h1 class="jugar text-white">Solicitudes de jugadores</h1>
      <p class="text-white fw-bold">Aquí Puedes Aceptar O Rechazar Las Solicitudes De Jugadores Bloqueados.</p>
    </header>
    <section class="card shadow-sm">
      <div class="card-body">
        <form class="d-flex" role="search">
          <!-- <label for="caja_busqueda">Buscar: </label> -->
          <input class="form-control me-2" type="text" name="caja-busqueda" id="caja-busqueda" placeholder="Buscar" aria-label="Search">
        </form>
        <br>
        <div class="list-group" id="lista-solicitudes">

          <div id="datos"></div>
        </div>
      </div>
    </section>

  </main>

  <!-- Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header mb-2">
          <h5 class="jugar modal-title" id="updateModalLabel"><strong>ACTUALIZAR USUARIO</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body" id="updateContent">
          <!-- Aquí se carga el contenido -->
        </div>

      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const updateModal = document.getElementById('updateModal');

      updateModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-id');

        const modalBody = updateModal.querySelector('#updateContent');
        modalBody.innerHTML = `
      <div class='text-center p-3'>
        <div class='spinner-border text-secondary' role='status'>
          <span class='visually-hidden'>Cargando...</span>
        </div>
      </div>`;

        fetch(`update.php?id=${userId}`)
          .then(response => response.text())
          .then(html => modalBody.innerHTML = html)
          .catch(() => modalBody.innerHTML = `<p class='text-danger text-center'>Error al cargar el contenido.</p>`);
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>