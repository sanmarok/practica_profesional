<?php

session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] == 2) {
    header('Location: authentication.php');
    exit();
}

// Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
// $db_host = 'localhost';
// $db_user = 'root';
// $db_pass = '';
// $db_name = 'infinet';

$db_host = 'localhost';
$db_user = 'dbadmin';
$db_pass = '.admindb';
$db_name = 'infinet';

// Verifica si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos de la solicitud técnica desde la solicitud AJAX
    $requestData = json_decode(file_get_contents("php://input"));

    // Conecta a la base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }

    // Inserta los datos de la solicitud técnica en la base de datos
    $query = "INSERT INTO technical_requests (description, problem, status, type, client_service_id, technician_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // El campo 'status' se asume que es recibido desde el formulario o se establece por defecto aquí
        // Se asume que 'type' es un entero. Asegúrate de que los tipos de datos correspondan a los de tu base de datos
        $stmt->bind_param(
            "ssiisi",
            $requestData->description,
            $requestData->problem,
            $requestData->status,
            $requestData->type,
            $requestData->client_service_id,
            $requestData->technician_id
        );

        if ($stmt->execute()) {
            // La inserción se realizó con éxito
            $response = array('success' => true);
        } else {
            // Hubo un error al insertar en la base de datos
            $response = array('success' => false, 'error' => $stmt->error);
        }

        $stmt->close();
    } else {
        // Hubo un error en la preparación de la consulta
        $response = array('success' => false, 'error' => $mysqli->error);
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();

    // Devuelve la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no se recibieron datos por POST, retorna un error
    $response = array('success' => false, 'error' => 'No POST data received');
    header('Content-Type: application/json');
    echo json_encode($response);
}
