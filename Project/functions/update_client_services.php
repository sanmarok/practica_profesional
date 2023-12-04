<?php

if (isset($_SESSION['id']) || $_SESSION['role'] != 1 || $_SESSION['role'] != 3) {
} else {
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
    $errores = "";
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }

    if (!preg_match('/^[a-zA-Z0-9, ]+$/', $_POST["address"])) {
        $errores = "La dirección no es válida. Solo se permiten letras, números, comas y espacios.";
    }
    if ($errores == "") {
        // Inserta los datos del cliente en la base de datos
        $query = "UPDATE client_services SET service_id= ? ,address= ?,state= ? WHERE id= ? ";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("issi", $_POST["service"], $_POST["address"], $_POST["state"], $_POST["id"]);

            if ($stmt->execute()) {
                // La inserción se realizó con éxito
                echo "<script>
            Swal.fire({
                title: 'Actualización Exitosa',
                text: 'El servicio ha sido actualizado correctamente. ',
                icon: 'success',
                confirmButtonText: 'Aceptar'

            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location = 'profile_client.php?id=" . $_POST['client_id'] . "';
                }
              });
            </script>";
            } else {
                // Hubo un error al insertar en la base de datos
                echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'El servicio no se ha sido actualizado1.',
                icon: 'error',
                confirmButtonText: 'Aceptar'

            });
            </script>";

            }

            $stmt->close();
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'El servicio no se ha sido actualizado2.',
                icon: 'error',
                confirmButtonText: 'Aceptar'

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