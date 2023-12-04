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

// Obtiene los datos enviados por la solicitud POST
$data = json_decode(file_get_contents("php://input"));

// Valida que los datos no estén vacíos
if (empty($data->service_id) || empty($data->name) || empty($data->type) || empty($data->upload_speed) || empty($data->download_speed) || empty($data->monthly_fee) || empty($data->installation_fee)) {
    $response = array('success' => false, 'message' => 'Todos los campos son obligatorios.');
    echo json_encode($response);
    exit;
}

// Sanitiza y escapa los datos
$service_id = $mysqli->real_escape_string($data->service_id);
$name = $mysqli->real_escape_string($data->name);
$type = $mysqli->real_escape_string($data->type);
$upload_speed = $mysqli->real_escape_string($data->upload_speed);
$download_speed = $mysqli->real_escape_string($data->download_speed);
$monthly_fee = $mysqli->real_escape_string($data->monthly_fee);
$installation_fee = $mysqli->real_escape_string($data->installation_fee);

// Verifica si ya existe un servicio con el mismo nombre
$existingServiceQuery = "SELECT * FROM services WHERE name = ? AND service_id != ?";
$stmtExisting = $mysqli->prepare($existingServiceQuery);

if ($stmtExisting) {
    $stmtExisting->bind_param("si", $name, $service_id);
    $stmtExisting->execute();
    $stmtExisting->store_result();

    if ($stmtExisting->num_rows > 0) {
        // Ya existe un servicio con el mismo nombre (excluyendo el servicio actual), devuelve una respuesta de error
        $response = array('success' => false, 'message' => 'Ya existe un servicio con ese nombre.');
        echo json_encode($response);
        exit(); // Sale del script si ya existe el servicio
    }

    $stmtExisting->close();
} else {
    // Hubo un error en la preparación de la consulta
    $response = array('success' => false, 'message' => 'Error en la preparación de la consulta.');
    echo json_encode($response);
    exit(); // Sale del script si hay un error en la preparación de la consulta
}

// Consulta SQL para actualizar el servicio
$sql = "UPDATE services SET name = '$name', type = '$type', upload_speed = '$upload_speed', download_speed = '$download_speed', monthly_fee = '$monthly_fee', installation_fee = '$installation_fee' WHERE service_id = $service_id";

if ($mysqli->query($sql)) {
    // Actualización exitosa
    $response = array('success' => true);
    echo json_encode($response);
} else {
    // Error en la actualización
    $response = array('success' => false, 'message' => 'Error al actualizar el servicio: ' . $mysqli->error);
    echo json_encode($response);
}

// Cierra la conexión a la base de datos
$mysqli->close();

?>
