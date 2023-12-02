<?php
// Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

// Establece una conexión a la base de datos
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verifica si la conexión se realizó correctamente
if ($mysqli->connect_error) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}

// Asegúrate de tener la conexión a la base de datos antes de este punto

// Obtén el service_id de la URL
$service_id = $_GET['id'];  // Ajusta esto según cómo estés manejando las URL

// Consulta SQL para obtener servicios relacionados con el cliente actual
$sqlRelatedServices = "SELECT s.service_id, s.name FROM services s
                      INNER JOIN client_services cs ON s.service_id = cs.service_id
                      WHERE cs.client_id = (SELECT client_id FROM client_services WHERE service_id = $service_id)
                      AND cs.service_id <> $service_id";

$resultRelatedServices = $mysqli->query($sqlRelatedServices);

if ($resultRelatedServices->num_rows >= 0) {
    echo '<div class="card card-info m-2">';
    echo '<div class="card-header">';
    echo '<h3 class="card-title">Otros servicios contratados junto a este servicio:</h3>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<ul>';


    while ($rowRelatedService = $resultRelatedServices->fetch_assoc()) {
        $relatedServiceId = $rowRelatedService['service_id'];
        $relatedServiceName = $rowRelatedService['name'];

        // Muestra los servicios relacionados como enlaces
        echo "<li><h5><a href='profile_service.php?id=$relatedServiceId'>$relatedServiceName</a></h5></li>";
    }

    echo '</ul>';
    echo '</div>';
    echo '</div>';
}

// Cierra la conexión a la base de datos
$mysqli->close();
