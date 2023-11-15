<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] == '1' || $_SESSION['role'] == '3') {
} else {
    header('Location: authentication.php');
    exit();
}
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
$order_id = $_GET['id'];
$sql = "SELECT p.name,od.quantity,p.cost
        FROM `order_details` AS od 
        INNER JOIN products AS p ON od.product_id = p.id 
        WHERE od.purchase_order_id =" . $order_id;
$products = $conn->query($sql);
$sql = "SELECT first_name,last_name,email,phone FROM users WHERE id = (SELECT user_id FROM purchase_orders WHERE id=" . $order_id . ");";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email, $phone);
$stmt->fetch();
$stmt->close();
$conn->close();
date_default_timezone_set('America/Argentina/Buenos_Aires');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pedido N°
        <?php echo $order_id; ?>
    </title>
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
                <h6><a href=" "><img alt="" src="image/logo.png" /> </a>
                </h6>

            </div>
            <div class="col-xs-6 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>PEDIDO
                            <a href="#"></a>
                        </h1>
                        <h4>CUIT :
                            <span>Infinet CUIT</span>
                        </h4>
                        <h4>R.S:
                            <span>Infinet R.S</span>
                        </h4>

                    </div>
                    <div class="panel-body">
                        <h4>PEDIDO Nº :
                            <span>
                                <?php echo $order_id; ?>
                            </span>
                        </h4>
                    </div>
                </div>
            </div>

            <hr />


            <h1 style="text-align: center;">NOTA DE PEDIDO</h1>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><a href="#">
                                    <?php echo date("d") ?>
                                </a> de <a href="#">
                                    <?php echo date("M") ?>
                                </a> de
                                <?php echo date("Y") ?></a>

                            </h4>
                        </div>
                        <div class="panel-body">


                            <h4>Comprador :
                                <a href="#">
                                    <?php echo $first_name . " " . $last_name; ?>
                                </a>
                            </h4>

                        </div>
                    </div>
                </div>

            </div>
            <pre></pre>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;">
                            <h4>Cantidad</h4>
                        </th>
                        <th style="text-align: center;">
                            <h4>Concepto</h4>
                        </th>
                        <th style="text-align: center;">
                            <h4>Precio unitario</h4>
                        </th>
                        <th style="text-align: center;">
                            <h4>Total</h4>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($products->num_rows > 0) {
                        $total = 0;
                        while ($product = $products->fetch_assoc()) {
                            $subtotal = $product['quantity'] * $product['cost'];
                            $total += $subtotal;
                            echo '<tr>';
                            echo '<td style="text-align: center;">' . $product['quantity'] . '</td>';
                            echo '<td style="text-align: center;"><a href="#">' . $product['name'] . '</a></td>';
                            echo '<td class=" text-right ">' . $product['cost'] . '</td>';
                            echo '<td class=" text-right ">' . $subtotal . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "No hay productos";
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total Ars.</td>
                        <td style="text-align: right;"><a href="#">
                                <?php echo $total ?>
                            </a></td>


                    </tr>
                </tbody>
            </table>
            <pre></pre>

            <div class="row">
                <div class="col-xs-4">
                    <h1><a href=" "><img alt="" src="image/qr.png" /></a></h1>
                </div>
                <div class="col-xs-8">

                    <div class="panel panel-info" style="text-align: right;">
                        <h6> "LA ALTERACI&Oacute;N, FALSIFICACI&Oacute;N O COMERCIALIZACI&Oacute;N ILEGAL DE ESTE
                            DOCUMENTO ESTA PENADO POR LA LEY"</h6>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>