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
    if (isset($_POST["service_name"])) {
        $errores = "";
        if (!preg_match("/^[\p{L}\s]+$/u", $_POST["service_name"])) {
            $errores = "El Nombre del Servicio debe contener solo letras y espacios.";
        }
        if (!preg_match("/^[\p{L}\s]+$/u", $_POST["type_service"])) {
            $errores = "El Tipo de Servicio debe contener solo letras y espacios.";
        }
        if (!ctype_digit($_POST["upload_speed"])) {
            $errores = "El Velocidad de Subida debe contener solo números.";
        }
        if (!ctype_digit($_POST["download_speed"])) {
            $errores = "La Velocidad de Bajada solo debe contener números.";
        }
        if (!preg_match('/^\d+(\.\d+)?$/', $_POST["monthly_fee"])) {
            $errores = "La Cuota Mensual debe contener solo números.";
        }
        if (!preg_match('/^\d+(\.\d+)?$/', $_POST["install_fee"])) {
            $errores = "El Tarifa de Instalación debe contener solo números.";
        }
        echo "tipo: " . $_POST["type_service"];
        if ($errores == "") {
            $query = "UPDATE services SET name = ?, type = ?,upload_speed = ?,download_speed = ?,monthly_fee = ?,installation_fee = ? WHERE service_id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssiissi", $_POST["service_name"], $_POST["type_service"], $_POST["upload_speed"], $_POST["download_speed"], $_POST["monthly_fee"], $_POST["install_fee"], $_POST["id"]);
            if ($stmt) {
                if ($stmt->execute()) {
                    // $query = "SELECT COUNT(*) AS servicios_contratados FROM client_services WHERE client_id = ?";
                    // $stmt = $mysqli->prepare($query);
                    // $stmt->bind_param("i", $_POST["id"]);
                    // if ($stmt->execute()) {
                    //     $result = $stmt->get_result();
                    //     $row = $result->fetch_assoc();
                    //     $servicios_contratados = $row['servicios_contratados'];

                    //     if ($servicios_contratados > 0) {
                    //         $query = "UPDATE client_services SET state = ? WHERE client_id = ?";
                    //         $stmt = $mysqli->prepare($query);
                    //         $stmt->bind_param("ii", $_POST["state"], $_POST["id"]);
                    //         $stmt->execute();
                    //     }
                    // }
                    echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Exito',
                        text: 'Se actualizo correctamente el cliente.',
                        showConfirmButton: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'services.php';;
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