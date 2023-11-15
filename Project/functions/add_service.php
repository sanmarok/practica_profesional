<?php

session_start();
if (isset($_SESSION['id']) || $_SESSION['role'] != 1 || $_SESSION['role'] != 3) {
} else {
    header('Location: ../ourpages/dashboard.php');
    exit();
}

// Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

// Verifica si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del servicio desde la solicitud AJAX
    $serviceData = json_decode(file_get_contents("php://input"));

    // Conecta a la base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }

    // Inserta los datos del servicio en la base de datos
    $query = "INSERT INTO services (name, type, upload_speed, download_speed, monthly_fee, installation_fee) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssddd", $serviceData->name, $serviceData->type, $serviceData->upload_speed, $serviceData->download_speed, $serviceData->monthly_fee, $serviceData->installation_fee);

        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            $response = array('success' => true);
        } else {
            // Hubo un error al insertar en la base de datos
            $response = array('success' => false);
        }

        $stmt->close();
    } else {
        // Hubo un error en la preparación de la consulta
        $response = array('success' => false);
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no se recibieron datos por POST, retorna un error
    $response = array('success' => false);
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
