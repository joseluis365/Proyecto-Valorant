<?php
require_once "../../database/connection.php";
$db = new database;
$con = $db->conectar();

$id_partida = isset($_GET['id_partida']) ? intval($_GET['id_partida']) : 0;
$id_user    = isset($_GET['id_user']) ? intval($_GET['id_user']) : 0;

if (!$id_partida) {
    echo "ID de partida inválido.";
    exit;
}

// Obtener información de la partida
$stmt = $con->prepare("SELECT estado, fecha_fin FROM partida WHERE id_partida = ?");
$stmt->execute([$id_partida]);
$partida = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener todos los jugadores de la partida con datos necesarios
$stmt = $con->prepare("SELECT pj.id_user, pj.kills, pj.puntos_totales, pj.vida_actual, pj.es_ganador,
           u.usuario AS username, u.puntos AS puntos_globales, u.id_rango
    FROM partida_jugador pj
    JOIN `user` u ON u.id_user = pj.id_user
    WHERE pj.id_partida = ?
    ORDER BY pj.es_ganador DESC, pj.puntos_totales DESC, pj.kills DESC
");
$stmt->execute([$id_partida]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// buscar el registro del usuario actual si se pasó id_user
$miRegistro = null;
if ($id_user) {
    foreach ($jugadores as $j) {
        if (intval($j['id_user']) === $id_user) { $miRegistro = $j; break; }
    }
}

// Si no nos pasaron id_user, siéntete libre de mostrar un resumen general
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Resultado - Partida #<?= h($id_partida) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="shortcut icon" href="../../controller/multimedia/img/icono_valorant.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../controller/css/style2.css">
</head>
<body>
  <div class="container">
    <h1>Resultados de la partida #<?= h($id_partida) ?></h1>

    <?php if ($miRegistro): ?>
      <div class="card">
        <h2>Tu resultado</h2>
        <p><strong>Jugador:</strong> <?= h($miRegistro['username']) ?></p>
        <p><strong>Resultado:</strong>
          <?php
            if (intval($miRegistro['es_ganador']) === 1) echo '<span class="winner">¡Victoria!</span>';
            else if (intval($miRegistro['vida_actual']) <= 0) echo '<span class="loser">Perdiste</span>';
            else echo '<span>Terminado</span>';
          ?>
        </p>
        <p><strong>Kills:</strong> <?= intval($miRegistro['kills']) ?> &nbsp; <strong>Puntos (partida):</strong> <?= intval($miRegistro['puntos_totales']) ?> &nbsp; <strong>Puntos globales:</strong> <?= intval($miRegistro['puntos_globales']) ?></p>
      </div>
    <?php else: ?>
      
    <?php endif; ?>

    <div class="card">
      <h2>Ranking final</h2>
      <table>
        <thead><tr><th>Puesto</th><th>Jugador</th><th>Vida</th><th>Kills</th><th>Puntos (partida)</th><th>Ganador</th></tr></thead>
        <tbody>
        <?php $pos=1; foreach ($jugadores as $j): ?>
          <tr>
            <td><?= $pos++ ?></td>
            <td><?= h($j['username']) ?></td>
            <td><?= intval($j['vida_actual']) ?>%</td>
            <td><?= intval($j['kills']) ?></td>
            <td><?= intval($j['puntos_totales']) ?></td>
            <td><?= intval($j['es_ganador']) === 1 ? '<strong class="winner">Ganador</strong>' : 'Perdedor' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div style="margin-top:12px; color:#aaa;">
      Estado partida: <?= h($partida['estado'] ?? 'desconocido') ?> <?= $partida['fecha_fin'] ? ' | Finalizada: ' . h($partida['fecha_fin']) : '' ?>
    </div>

    <div style="margin-top:18px;">
      <a href="lobby.php" style="color:#00ff7f;">Cerrar</a>
    </div>
  </div>
</body>
</html>


