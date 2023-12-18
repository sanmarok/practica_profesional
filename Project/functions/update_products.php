<?php

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
    $nombre_regex = "/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/u"; // Solo letras y espacios
    $descripcion_regex = "/^[a-zA-Z0-9áéíóúüñÁÉÍÓÚÜÑ\s.,-]+$/u"; // Alfanumérico con algunos caracteres especiales
    $unidad_regex = "/^[a-zA-Z0-9\s]+$/"; // Alfanumérico y espacios
    $costo_regex = "/^\d+(\.\d{1,2})?$/"; // Número decimal con hasta dos decimales
    $stock_regex = "/^\d+(\.\d+)?$/";
    $errors = "";

    // Conecta a la base de datos
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }
    if (isset($_POST["product_name"])) {
        if (!preg_match($nombre_regex, $_POST["product_name"])) {
            $errors = "El campo 'Nombre' no es válido. Debe contener solo letras y espacios.";
        }

        if (!preg_match($descripcion_regex, $_POST["product_description"])) {
            $errors = "El campo 'Descripción' no es válido. Puede contener letras, números y algunos caracteres especiales.";
        }

        if (!preg_match($unidad_regex, $_POST["product_unit"])) {
            $errors = "El campo 'Unidad' no es válido. Puede contener letras, números y espacios.";
        }

        if (!preg_match($costo_regex, $_POST["product_cost"])) {
            $errors = "El campo 'Costo' no es válido. Debe ser un número decimal con hasta dos decimales.";
        }
        if (!preg_match($stock_regex, $_POST["product_stock"])) {
            $errors = "El campo 'Stock' no es válido. Debe ser un número entero positivo.";
        }
        if ($errors == "") {
            $query = "UPDATE products SET name = ? , description = ?, unit = ?, stock = ?, cost = ? WHERE id = ?";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sssddi", $_POST["product_name"], $_POST["product_description"], $_POST["product_unit"], $_POST["product_stock"], $_POST["product_cost"], $_POST["id"]);

                if ($stmt->execute()) {
                    // La inserción se realizó con éxito
                    echo '<script>
                Swal.fire({
                    title: "Exito!",
                    text: "El prodcuto se ha actualizado!",
                    icon: "success"
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location = "products.php";
                    }
                  });
                </script>';
                } else {
                    // Hubo un error al insertar en la base de datos
                    echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "ha ocurrido un error",
                    icon: "error"
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location = "products.php";
                    }
                  });
                </script>';
                }

                $stmt->close();
            } else {
                // Hubo un error en la preparación de la consulta
                echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "ha ocurrido un error",
                    icon: "error"
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location = "products.php";
                    }
                  });
                </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Error: ' . $errors . '",
                    icon: "error"
                  });
                </script>';
        }
    }

    $mysqli->close();

} else {

}
