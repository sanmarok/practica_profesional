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

// Datos de ejemplo para insertar en la tabla users
$usuarios = [
    [
        'employee_number' => '000001',
        'employee_password' => generarHash('contraseña1'),
        'first_name' => 'Nombre1',
        'last_name' => 'Apellido1',
        'email' => 'usuario1@example.com',
        'phone' => '1234567890',
        'role' => 1
    ],
    [
        'employee_number' => '000002',
        'employee_password' => generarHash('contraseña2'),
        'first_name' => 'Nombre2',
        'last_name' => 'Apellido2',
        'email' => 'usuario2@example.com',
        'phone' => '2345678901',
        'role' => 2
    ],
    [
        'employee_number' => '000003',
        'employee_password' => generarHash('contraseña3'),
        'first_name' => 'Nombre3',
        'last_name' => 'Apellido3',
        'email' => 'usuario3@example.com',
        'phone' => '3456789012',
        'role' => 3
    ],
    [
        'employee_number' => '000004',
        'employee_password' => generarHash('contraseña4'),
        'first_name' => 'Nombre4',
        'last_name' => 'Apellido4',
        'email' => 'usuario4@example.com',
        'phone' => '4567890123',
        'role' => 1
    ],
    [
        'employee_number' => '000005',
        'employee_password' => generarHash('contraseña5'),
        'first_name' => 'Nombre5',
        'last_name' => 'Apellido5',
        'email' => 'usuario5@example.com',
        'phone' => '5678901234',
        'role' => 2
    ],
    [
        'employee_number' => '000006',
        'employee_password' => generarHash('contraseña6'),
        'first_name' => 'Nombre6',
        'last_name' => 'Apellido6',
        'email' => 'usuario6@example.com',
        'phone' => '6789012345',
        'role' => 3
    ]
];

// Inserta los datos en la tabla users
foreach ($usuarios as $usuario) {
    $sql = "INSERT INTO users (employee_number, employee_password, first_name, last_name, email, phone, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssssi', $usuario['employee_number'], $usuario['employee_password'], $usuario['first_name'], $usuario['last_name'], $usuario['email'], $usuario['phone'], $usuario['role']);
    $stmt->execute();
    $stmt->close();
}

// Cierra la conexión a la base de datos
$mysqli->close();

echo 'Datos insertados con éxito.';
?>
