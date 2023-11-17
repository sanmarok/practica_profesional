<?php
// Obtén el ID del usuario desde la solicitud
$userId = $_GET['id'];

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

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT * FROM `users` WHERE `id` =" . $userId;
$result = $mysqli->query($sql);

// Verifica si la consulta fue exitosa
if ($result) {
    // Obtiene los datos del usuario como un array asociativo
    $userData = $result->fetch_assoc();

    // Devuelve los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($userData);
} else {
    // Manejar el caso en que la consulta falla
    echo json_encode(['error' => 'No se pudieron obtener los datos del usuario']);
}

// Cierra la conexión a la base de datos
$mysqli->close();
