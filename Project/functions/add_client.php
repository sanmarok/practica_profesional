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
    // Obtén los datos del cliente desde la solicitud AJAX
    $clientData = json_decode(file_get_contents("php://input"));

    // Validación del nombre y apellido (solo letras y espacio, más de dos caracteres)
    if (!preg_match('/^[a-zA-Z ]{2,}$/', $clientData->first_name) || !preg_match('/^[a-zA-Z ]{2,}$/', $clientData->last_name)) {
        $response = array('success' => false, 'error' => 'Nombre o apellido no válido.');
    } else {
        // Conecta a la base de datos
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

        try {
            // Inserta los datos del cliente en la base de datos
            $query = "INSERT INTO clients (first_name, last_name, document, phone, email, state) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {
                // Enlaza los parámetros y ejecuta la consulta
                $stmt->bind_param("ssssss", $clientData->first_name, $clientData->last_name, $clientData->document, $clientData->phone, $clientData->email, $clientData->state);
                if ($stmt->execute()) {
                    // La inserción se realizó con éxito
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
            switch ($e->getCode()) {
                case 1062:
                    $response = array('success' => false, 'error' => 'Datos en uso: ' . $e->getMessage());
                    break;
                default:
                    $response = array('success' => false, 'error' => 'Error: ' . $e->getMessage());
                    break;
            }
        } finally {
            // Cierra la conexión a la base de datos
            $mysqli->close();
        }
    }
} else {
    // Si no se recibieron datos por POST, retorna un error
    $response = array('success' => false, 'error' => 'Solicitud no válida.');
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
