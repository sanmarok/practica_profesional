<?php
if (isset($_SESSION['id']) && $_SESSION['role'] != 1) {
    header('Location: dashboard.php');
    exit();
}
function verDato($columna, $dato)
{
    // $db_host = 'localhost';
    // $db_user = 'root';
    // $db_pass = '';
    // $db_name = 'infinet';

    $db_host = 'localhost';
    $db_user = 'dbadmin';
    $db_pass = '.admindb';
    $db_name = 'infinet';
    
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }
    $query = "SELECT COUNT(*) as total FROM clients WHERE $columna = ? && id != ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("si", $dato, $_POST["id"]);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->get_result();

        // Obtener el número total de filas encontradas
        $fila = $resultado->fetch_assoc();
        $total = $fila['total'];

        // Cerrar la conexión y liberar los recursos
        $stmt->close();
        $mysqli->close();

        // Verificar si hay duplicados
        return $total > 0;
    } else {
        // Error en la preparación de la consulta
        die("Error en la consulta: " . $mysqli->error);
    }
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }
    if (isset($_POST["first_name"])) {
        $errores = "";
        if (!preg_match("/^[\p{L}\s]+$/u", $_POST["first_name"])) {
            $errores = "El nombre debe contener solo letras y espacios.";
        }
        if (!preg_match("/^[\p{L}\s]+$/u", $_POST["last_name"])) {
            $errores = "El apellido debe contener solo letras y espacios.";
        }
        if (!ctype_digit($_POST["document"]) || (strlen($_POST["document"]) != 8)) {
            $errores = "El documento debe contener solo números y de una longitud de 8 digitos.";
        } else if (verDato('document', $_POST["document"])) {
            $errores = "El documento ya existe.";
        }
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errores = "El correo electrónico no es válido.";
        } else if (verDato('email', $_POST["email"])) {
            $errores = "El correo electrónico ya existe.";
        }
        if (!preg_match("/^[\d\s()+-]*$/", $_POST["phone"])) {
            $errores = "El teléfono debe contener solo números y guiones.";
        } else if (verDato('phone', $_POST["phone"])) {
            $errores = "El teléfono ya existe.";
        }
        if ($errores == "") {
            $query = "UPDATE clients SET first_name = ?, last_name = ?,phone = ?,email = ?,document = ?,state = ? WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssssssi", $_POST["first_name"], $_POST["last_name"], $_POST["phone"], $_POST["email"], $_POST["document"], $_POST["state"], $_POST["id"]);
            if ($stmt) {
                if ($stmt->execute()) {
                    if ($_POST['state'] == 0) {
                        $query = "SELECT COUNT(*) AS servicios_contratados FROM client_services WHERE client_id = ?";
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param("i", $_POST["id"]);
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $servicios_contratados = $row['servicios_contratados'];

                            if ($servicios_contratados > 0) {
                                $query = "UPDATE client_services SET state = ? WHERE client_id = ?";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("si", $_POST["state"], $_POST["id"]);
                                $stmt->execute();
                            }
                        }
                    }
                    echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Exito',
                        text: 'Se actualizo correctamente el cliente.',
                        showConfirmButton: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'clients.php';;
                        }
                      });
                    </script>";
                } else {
                    echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el cliente.',
                        showConfirmButton: true,
                    });
                    </script>";
                }
                $stmt->close();
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el cliente.',
                        showConfirmButton: true,
                    });
                    </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '" . $errores . "',
                        showConfirmButton: true,
                    });
                    </script>";
        }
        $mysqli->close();
    }
}
