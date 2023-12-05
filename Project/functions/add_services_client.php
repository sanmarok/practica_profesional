<?php
session_start();

// Verifica la sesión y el rol del usuario
if (!isset($_SESSION['id']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 3)) {
    header('Location: ../ourpages/dashboard.php');
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
    // Obtén los datos del servicio desde la solicitud AJAX
    $serviceData = json_decode(file_get_contents("php://input"));

    // Conecta a la base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    try {
        // Inserta los datos del servicio en la base de datos
        $query = "INSERT INTO client_services (client_id, service_id, address, state) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            // Estado por defecto para un nuevo servicio
            $defaultState = "2";

            // Enlaza los parámetros y ejecuta la consulta
            $stmt->bind_param("iiss", $serviceData->client_id, $serviceData->service_id, $serviceData->direccion, $defaultState);
            if ($stmt->execute()) {
                // La inserción se realizó con éxito

                // Obtén el ID del último registro insertado
                $lastInsertId = $mysqli->insert_id;

                // Realiza una consulta adicional en la tabla technical_requests
                $queryTechnical = "INSERT INTO technical_requests (description, status, client_service_id, problem, type) VALUES (?, ?, ?, ?,?)";
                $stmtTechnical = $mysqli->prepare($queryTechnical);

                if ($stmtTechnical) {
                    // Enlaza los parámetros y ejecuta la consulta
                    $description = "Instalacion de nuevo servicio";
                    $status = 3;
                    $type = 0;
                    $problem = "Instalacion pendiente";
                    $stmtTechnical->bind_param("siisi", $description, $status, $lastInsertId, $problem, $type);
                    $stmtTechnical->execute();

                    // Cierra la consulta preparada
                    $stmtTechnical->close();
                }

                $response = array('success' => true);
            } else {
                // Hubo un error al insertar en la base de datos
                $response = array('success' => false, 'error' => 'Error al ejecutar la consulta: ' . $stmt->error);
            }

            // Cierra la consulta preparada
            $stmt->close();
        } else {
            // Hubo un error en la preparación de la consulta
            $response = array('success' => false, 'error' => 'Error en la preparación de la consulta: ' . $mysqli->error);
        }
    } catch (Exception $e) {
        $response = array('success' => false, 'error' => 'Error: ' . $e->getMessage());
    } finally {
        // Cierra la conexión a la base de datos
        $mysqli->close();
    }
} else {
    // Si no se recibieron datos por POST, retorna un error
    $response = array('success' => false, 'error' => 'Solicitud no válida.');
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
