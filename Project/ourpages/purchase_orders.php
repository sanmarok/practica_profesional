<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['id'] == 1) {
} else {
    header('Location: authentication.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos de Compra</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <style>
        /* Regla de estilo personalizada para el mensaje de error */
        .swal2-popup .swal2-title {
            color: white;
            /* Cambia el color del texto a blanco */
        }

        .swal2-html-container {
            color: white;
        }
    </style>


</head>

<body class="layout-navbar-fixed control-sidebar-slide-open dark-mode">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include "../ourwidgets/pruchase_orders/dashboard_parts.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php include "../ourwidgets/pruchase_orders/datatable_purchase_orders.php"; ?>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
    <?php
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verifica si la conexión se realizó correctamente
    if ($mysqli->connect_error) {
        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
    }
    $sql = "SELECT id, name,unit FROM products";
    $result = $mysqli->query($sql);
    ?>

    <!-- Modal para agregar cliente -->
    <div class="modal fade" id="modalAgregarPedido">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarPedido" method="post" action="../functions/add_client.php">
                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Descripcion del pedido" required>
                        </div>
                        <div class="form-group">
                            <label for="productSelect">Productos:</label>
                            <select name="productSelect" id="productSelect" class="form-control">
                                <?php
                                if ($result->num_rows > 0) {
                                    echo '<option value="" disabled selected>Seleccione un producto</option>';
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . ' - ' . $row['unit'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled selected>No se encotraron productos</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock">Cantidad:</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="stock" name="stock"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-sm" onclick="addProduct()">Agregar
                                Producto</button>
                            <hr>
                        </div>
                        <div class="form-group">
                            <h5>Productos Selecionados:</h5>
                            <ul id="selectedProductsList" class=""></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="addPurchase()">Guardar</button>
                </div>

            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        var products_list = [];
        function addProduct() {
            var selectElement = document.getElementById("productSelect");
            var product_id = selectElement.selectedIndex;
            var product_name = selectElement.options[product_id].text;
            var product_stock = parseFloat(document.getElementById("stock").value);
            var selectedProductsList = document.getElementById("selectedProductsList");

            if (product_id && !isNaN(product_stock) && product_stock > 0) {
                // Agregar producto a la lista de productos seleccionados
                var product_li = document.createElement("li");
                product_li.textContent = product_name + ' - Cantidad: ' + product_stock;
                selectedProductsList.append(product_li);

                var data_product = {
                    product_id: product_id,
                    product_stock: product_stock
                };
                products_list.push(data_product);
                document.getElementById("stock").value = "";
                selectElement.value = "";

            } else {
                alert('Por favor, seleccione un producto y una cantidad válida.');
            }
            console.log(products_list);
        }
        function addPurchase() {
            // Obtén los valores del formulario
            var description = document.getElementById("description").value;
            var status = 2;

            // Crea un objeto con los datos que deseas enviar
            var purchaseData = {
                description: description,
                status: status,
                products_list: products_list
            };

            // Realiza una llamada AJAX para enviar los datos al servidor
            fetch("../functions/add_purchase.php", {
                method: "POST",
                body: JSON.stringify(purchaseData),
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(response => response.json())
                .then(data => {
                    // Aquí puedes manejar la respuesta del servidor
                    if (data.success) {
                        // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
                        $("#modalAgregarPedido").modal("hide");
                        // Recarga la página o realiza otras acciones necesarias
                        window.location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al agregar el pedido.',
                            showConfirmButton: false,
                            timer: 1500 // Cierra automáticamente el SweetAlert después de 1.5 segundos
                        });
                    }
                })
                .catch(error => {
                    // Manejo de errores
                    console.error("Error en la llamada AJAX: " + error);
                });
        }
    </script>

</body>

</html>