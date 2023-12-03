<?php
session_start();

// Verifica la sesión y el rol del usuario
if (!isset($_SESSION['id']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 3)) {
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

    try {
        // Verifica la conexión a la base de datos
        if ($mysqli->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . $mysqli->connect_error);
        }

        // Prepara la consulta SQL
        $stmt = $mysqli->prepare("INSERT INTO technical_requests (description, problem, status, type, client_service_id, technician_id) VALUES (?, ?, ?, ?, ?, ?)");

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $mysqli->error);
        }

        // Vincula los parámetros a la consulta
        $stmt->bind_param("ssiiii", $serviceData->descripcion, $serviceData->problem, $serviceData->status, $serviceData->type, $serviceData->clientServiceId, $technicianId);

        // Ejecuta la consulta
        $stmt->execute();

        // Verifica si la ejecución de la consulta fue exitosa
        if ($stmt->affected_rows > 0) {
            $response = array('success' => true, 'message' => 'Solicitud técnica agregada correctamente.');
        } else {
            throw new Exception("Error al agregar la solicitud técnica: " . $mysqli->error);
        }
    } catch (Exception $e) {
        $response = array('success' => false, 'error' => 'Error: ' . $e->getMessage());
    } finally {
        // Cierra la declaración y la conexión a la base de datos
        $stmt->close();
        $mysqli->close();
    }
} else {
    // Si no se recibieron datos por POST, retorna un error
    $response = array('success' => false, 'error' => 'Solicitud no válida.');
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
