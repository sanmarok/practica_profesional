<?php
if (isset($_GET['id'])) {
    $serviceId = $_GET['id'];

    // Realiza la conexión a la base de datos (ajusta según tu entorno)
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'infinet'; // Cambia esto con el nombre de tu base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }

    // Realiza la consulta SQL para borrar el servicio
    $sql = "DELETE FROM services WHERE service_id = $serviceId";
    $result = $mysqli->query($sql);

    // Maneja la respuesta
    if ($result) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
