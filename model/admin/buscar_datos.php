<?php
session_start();
require_once("../../database/connection.php");
$db = new Database;
$con = $db->conectar();

$mysqli = new mysqli("localhost", "root", "", "valorant");

$por_pagina = 17;

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {
    $pagina = 1;
}

$empieza = ($pagina - 1) * $por_pagina;

$salida = "";
$query = $query = "SELECT * FROM user 
          INNER JOIN estado 
          ON user.id_estado = estado.id_estado
          INNER JOIN rango
          ON user.id_rango = rango.id_rango
          INNER JOIN tip_user
          ON user.id_tipo_user = tip_user.id_tipo_user
          WHERE estado.id_estado IN (1,2)
          AND tip_user.tipo_user != 'Administrador'
          ORDER BY user.id_user 
          LIMIT $empieza, $por_pagina";


if (isset($_POST['consulta'])) {
    $q = $mysqli->real_escape_string($_POST['consulta']);
    $query = "SELECT * FROM user 
          INNER JOIN estado 
          ON user.id_estado = estado.id_estado
          INNER JOIN rango
          ON user.id_rango = rango.id_rango
          INNER JOIN tip_user
          ON user.id_tipo_user = tip_user.id_tipo_user
          WHERE estado.id_estado IN (1,2)
          AND tip_user.tipo_user != 'Administrador'
          AND (user.usuario LIKE '%".$q."%' 
          OR user.id_user LIKE '%".$q."%'
          OR rango.nombre_rango LIKE '%".$q."%'
          OR estado.tipo_estado LIKE '%".$q."%'
          OR user.email LIKE '%".$q."%')";
}

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $salida .= "
    <div class='container'>
        <div class='list-group'>";
            
    while ($fila = $result->fetch_assoc()) {

        // Generar una imagen de perfil provisional (puedes cambiar por tu campo real)
        $avatar = "../../controller/img/" . $fila['avatar'];

        $colorEstado = ($fila['id_estado'] == 1) ? 'text-success' : 'text-danger';

        $salida .= "
        <div class='list-group-item d-flex align-items-center justify-content-between'>
            <div class='d-flex align-items-center'>
                <img src='$avatar' class='rounded-circle me-3' alt='Jugador' style='width:45px; height:45px; object-fit:cover;'>
                <div>
                    <h6 class='mb-0 text-black'>{$fila['usuario']}</h6> 
                    <small class='text-muted'>
                        Rango: <span class='text-primary'>{$fila['nombre_rango']}</span> · 
                        Puntos <span class='text-warning'>{$fila['puntos_requeridos']}</span> · 
                        Estado: <span class='$colorEstado'>{$fila['tipo_estado']}</span>
                    </small>
                </div>
            </div>
            <div>
                <button 
                    type='button' 
                    class='btn btn-outline-secondary btn-sm me-2' 
                    data-bs-toggle='modal' 
                    data-bs-target='#updateModal' 
                    data-id='{$fila['id_user']}'>
                    Actualizar
                </button>
            </div>
        </div>";
    }

    $salida .= "</div></div>";
} else {
    $salida .= "<div class='list-group-item text-center text-muted py-4'>No se encuentran datos.</div>";
}


echo $salida;
$mysqli->close();
?>

<?php
// Paginación
$sql = $con->prepare("SELECT COUNT(*) 
                      FROM user 
                      INNER JOIN estado 
                      ON user.id_estado = estado.id_estado
                      INNER JOIN tip_user
                      ON user.id_tipo_user = tip_user.id_tipo_user
                      WHERE estado.id_estado IN (1,2)
                      AND tip_user.tipo_user != 'Administrador'");
$sql->execute();
$resul = $sql->fetchColumn();
$total_paginas = ceil($resul / $por_pagina);

if ($total_paginas == 0) {
    echo "<center>Lista Vacía</center>";
} else {
    echo "<center><a href='search_user.php?pagina=1'><i class='fa fa-arrow-left'></i></a>";
    for ($i = 1; $i <= $total_paginas; $i++) {
        echo "<a href='search_user.php?pagina=".$i."'> ".$i." </a>";
    }
    echo "<a href='search_user.php?pagina=$total_paginas'><i class='fa fa-arrow-right'></i></a></center>";
}
?>
