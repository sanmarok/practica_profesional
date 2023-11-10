<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] == '1' || $_SESSION['role'] == '3') {
} else {
    header('Location: authentication.php');
    exit();
}
?>

<?php


// Conexión a la base de datos (debes tener tu propia lógica de conexión)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la factura desde el parámetro GET
$invoice_id = $_GET['id'];

// Consulta SQL para obtener los datos de la factura, cliente y servicio asociado
$sql = "SELECT 
            inv.id AS invoice_id,
            inv.issue_date,
            inv.due_date,
            inv.type AS invoice_type,
            inv.price_service,
            inv.price_installation,
            inv.surcharge,
            inv.state AS invoice_state,
            cs.id AS client_service_id,
            cs.address,
            c.id AS client_id,
            c.first_name,
            c.last_name,
            c.document,
            c.phone,
            c.email,
            c.state AS client_state,
            s.name AS service_name,
            s.type AS service_type,
            s.upload_speed,
            s.download_speed,
            s.monthly_fee,
            s.installation_fee
        FROM invoices inv
        INNER JOIN client_services cs ON inv.client_service_id = cs.id
        INNER JOIN clients c ON cs.client_id = c.id
        INNER JOIN services s ON cs.service_id = s.service_id
        WHERE inv.id = $invoice_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Datos de la factura
    $invoice_data = $result->fetch_assoc();

    // Cerrar la conexión después de obtener los datos
    $conn->close();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Factura N° <?php echo $invoice_data['invoice_id']; ?></title>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <style>
            @import url(http://fonts.googleapis.com/css?family=Bree+Serif);

            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'Bree Serif', serif;
            }

            @media print {

                /* Oculta el encabezado */
                @page {
                    margin-top: 0;
                    margin-bottom: 0;
                }

                /* Oculta el pie de página */
                body::after {
                    content: "";
                    display: none;
                }
            }
        </style>


    </head>


    <body id="contenido-factura">
        <div class="container">
            <div class="row">

                <div class="col-xs-6">
                    <img alt="" src="image/logo.png" />
                </div>
                <div class="col-xs-6 text-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>CUIT :
                                <span>Infinet CUIT</span>
                            </h4>
                            <h4>R.S:
                                <span>Infinet R.S</span>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <h4>NUMERO DE FACTURA :
                                <span><?php echo $invoice_data['invoice_id']; ?></span>
                            </h4>
                        </div>
                    </div>
                </div>

                <hr />


                <h1 style="text-align: center;"> <?php
                                                    switch ($invoice_data['invoice_type']) {
                                                        case 0:
                                                            echo '<td>Factura A</td>';
                                                            break;
                                                        case 1:
                                                            echo '<td>Factura B</td>';
                                                            break;
                                                        case 2:
                                                            echo '<td>Factura C</td>';
                                                            break;
                                                        case 3:
                                                            echo '<td>Factura E</td>';
                                                            break;
                                                        case 4:
                                                            echo '<td>Factura M</td>';
                                                            break;
                                                        default:

                                                            break;
                                                    }
                                                    ?></h1>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>FECHA DE EMISIÓN: <?php echo $invoice_data['issue_date'] ?></h4>
                                <h4>FECHA DE VENCIMIENTO: <?php echo $invoice_data['due_date'] ?></h4>
                            </div>
                            <div class="panel-body">


                                <h5>CLIENTE :
                                    <?php echo $invoice_data['first_name'] . " " . $invoice_data['last_name'] ?>
                                </h5>
                                <h5>DOCUMENTO :
                                    <?php echo $invoice_data['document'] ?>
                                </h5>
                                <h5>DIRECCION :
                                    <?php echo $invoice_data['address'] ?>
                                </h5>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-body">
                                <h5>SERVICIO :<?php echo $invoice_data['service_name'] ?> </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;">
                                <h4>Concepto</h4>
                            </th>
                            <th style="text-align: center;">
                                <h4>Precio</h4>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left">
                                <h5><?php echo $invoice_data['service_name'] ?> </h5>
                            </td>
                            <td style="text-align: center">
                                <h5>$ <?php echo $invoice_data['price_service'] ?> </h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                <h5>Costo de instalación</h5>
                            </td>
                            <td style="text-align: center">
                                <h5>$ <?php echo $invoice_data['price_installation'] ?> </h5>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                <h5>Recargos</h5>
                            </td>
                            <td style="text-align: center">
                                <h5>$ <?php echo $invoice_data['surcharge'] ?> </h5>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        <tr class="bg-primary">
                            <td style="text-align: left;">TOTAL: </td>
                            <td style="text-align: center">$ <?php echo $invoice_data['price_service'] + $invoice_data['price_installation'] + $invoice_data['surcharge'] ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="row">

                    <div class="col-xs-8 align-content-center">

                        <div class="col-xs-4">
                            <h1><img alt="" src="image/qr.png" /></h1>
                        </div>


                    </div>


                </div>
                <div class="panel panel-info" style="text-align: center;">
                    <h6> "LA ALTERACI&Oacute;N, FALSIFICACI&Oacute;N O COMERCIALIZACI&Oacute;N ILEGAL DE ESTE DOCUMENTO ESTA PENADO POR LA LEY"</h6>
                </div>
            </div>
        </div>
        <script>
            //window.print();
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <!-- Agrega esto donde quieras que aparezca el botón de guardar como PDF -->
        <button onclick="guardarComoPDF()">Guardar como PDF</button>

        <!-- ... tu contenido HTML ... -->

        <script>
            function guardarComoPDF() {
                // Crea una instancia de jsPDF
                var pdf = new jsPDF();

                // Agrega el contenido del elemento con el id "contenido-factura" al PDF
                var contenido = document.getElementById("contenido-factura").innerHTML;
                pdf.fromHTML(contenido, 15, 15);

                // Guarda el PDF con un nombre de archivo específico
                pdf.save('factura.pdf');
            }
        </script>

    </body>

<?php
} else {
    echo "No se encontraron datos para la factura con ID: $invoice_id";
}
?>