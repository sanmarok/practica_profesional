<?php

function GuardarFactura()
{
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
    // Obtiene los datos enviados por la solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "UPDATE invoices SET state = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $_POST['estado'], $_POST['factura_id']);
            if ($stmt->execute()) {
                echo '
                <script>Swal.fire({
                    icon: "success",
                    title: "Factura actualizada exitosamente.",
                    showConfirmButton: false,
                    timer: 500,
                  }).then(() => {
                    window.location = "";
                  });
                  </script>';
            } else {
                echo '<script>Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al actualizar la factura. Detalles: " + data.error,
                    showConfirmButton: true,
                  });</script>';
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>