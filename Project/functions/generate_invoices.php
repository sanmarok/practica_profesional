<?php
session_start();

// Verifica la sesión y el rol del usuario
if (!isset($_SESSION['id']) || ($_SESSION['role'] != 1)) {
    header('Location: ../ourpages/dashboard.php');
    exit();
}

// Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

// Intenta realizar la conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

try {
    // Consulta para generar facturas
    $sql = "
    INSERT INTO invoices (issue_date, due_date, client_service_id, type, price_service, price_installation, surcharge, state)
    SELECT
        CURDATE() AS issue_date,
        DATE_ADD(CURDATE(), INTERVAL 2 WEEK) AS due_date,
        cs.id AS client_service_id,
        2 AS type,
        (SELECT s.monthly_fee FROM services s WHERE s.service_id = cs.service_id) AS price_service,
        CASE
            WHEN cs.installation = 1 THEN (SELECT s.installation_fee FROM services s WHERE s.service_id = cs.service_id)
            ELSE 0
        END AS price_installation,
        (SELECT s.monthly_fee FROM services s WHERE s.service_id = cs.service_id) * 0.05 AS surcharge,
        2 AS state
    FROM client_services cs
    WHERE
        cs.state IN ('1', '2')
        AND cs.state NOT IN ('0', '3')
        AND NOT EXISTS (
            SELECT 1
            FROM invoices i
            WHERE cs.id = i.client_service_id
                AND MONTH(i.issue_date) = MONTH(NOW())
                AND YEAR(i.issue_date) = YEAR(NOW())
        )
        AND DATEDIFF(CURDATE(), cs.hire_date) >= 30;
    
    ";

    // Ejecuta la consulta
    $result = $conn->query($sql);

    // Verifica si la consulta fue exitosa y obtén el número de filas afectadas
    if ($result) {
        $num_rows_affected = $conn->affected_rows;

        if ($num_rows_affected > 0) {
            // Éxito y al menos una factura generada
            $response = array('status' => 'success', 'num_invoices' => $num_rows_affected);
        } else {
            // Éxito pero ninguna factura generada
            $response = array('status' => 'success', 'num_invoices' => 0);
        }
    } else {
        // Fallo y mensaje de error
        throw new Exception($conn->error);
    }
} catch (Exception $e) {
    // Captura cualquier excepción y devuelve un mensaje de error
    $response = array('status' => 'error', 'message' => $e->getMessage());
}

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cierra la conexión a la base de datos
$conn->close();
