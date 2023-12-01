<?php
if (isset($_SESSION['id']) && $_SESSION['role'] != 1) {
    header('Location: dashboard.php');
    exit();
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
        if (!ctype_digit($_POST["document"])) {
            $errores = "El documento debe contener solo números.";
        }
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errores = "El correo electrónico no es válido.";
        }
        if (!preg_match("/^[0-9-]+$/", $_POST["phone"])) {
            $errores = "El teléfono debe contener solo números y guiones.";
        }
        if ($errores == "") {
            $query = "UPDATE clients SET first_name = ?, last_name = ?,phone = ?,email = ?,document = ?,state = ? WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sssssii", $_POST["first_name"], $_POST["last_name"], $_POST["phone"], $_POST["email"], $_POST["document"], $_POST["state"], $_POST["id"]);
            if ($stmt) {
                if ($stmt->execute()) {
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
                            $stmt->bind_param("ii", $_POST["state"], $_POST["id"]);
                            $stmt->execute();
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
} ?>