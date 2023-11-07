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

// Función para generar una contraseña hash
function generarHash($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Datos de ejemplo para insertar en la tabla clients
$clientes = [];

for ($i = 1; $i <= 50; $i++) {
    $clientes[] = [
        'first_name' => 'Nombre' . $i,
        'last_name' => 'Apellido' . $i,
        'document' => 'Documento' . $i,
        'phone' => '123456789' . $i,
        'email' => 'cliente' . $i . '@example.com',
        'state' => rand(0, 1) // Genera un valor aleatorio entre 0 y 9 para el estado
    ];
}

// Inserta los datos en la tabla clients
foreach ($clientes as $cliente) {
    $sql = "INSERT INTO clients (first_name, last_name, document, phone, email, state) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssssi', $cliente['first_name'], $cliente['last_name'], $cliente['document'], $cliente['phone'], $cliente['email'], $cliente['state']);
    $stmt->execute();
    $stmt->close();
}

// Cierra la conexión a la base de datos
$mysqli->close();

echo 'Datos de clientes insertados con éxito.';
?>
