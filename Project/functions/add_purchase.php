<?php

session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] != 1) {
    header('Location: dashboard.php');
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
    $purchaseData = json_decode(file_get_contents("php://input"));
    $order_details = $purchaseData->products_list;

    // Conecta a la base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }

    // Inserta los datos del cliente en la base de datos
    $query = "INSERT INTO purchase_orders (description, status, user_id) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sii", $purchaseData->description, $purchaseData->status, $_SESSION['id']);

        if ($stmt->execute()) {
            // Consulto el utlimo id de pedidos
            $purchase_id = $mysqli->insert_id;
            // Inserta los datos del detalle de 
            $query = "INSERT INTO order_details (purchase_order_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            if ($stmt) {
                // Recorre la lista de diccionarios e inserta los datos en la tabla 
                foreach ($order_details as $products) {
                    $product_id = $products->product_id;
                    $product_stock = $products->product_stock;

                    // Vincula los parametros y ejecuta la consulta
                    $stmt->bind_param("iii", $purchase_id, $product_id, $product_stock);
                    $stmt->execute();
                }
            }
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
