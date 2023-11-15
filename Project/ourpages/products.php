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
    <title>Productos</title>
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
        <?php include "../ourwidgets/products/dashboard_parts.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php include "../ourwidgets/products/datatable_products.php" ?>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- Modal para agregar cliente -->
    <div class="modal fade" id="modalAgregarProducto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarProducto" method="post" action="../functions/add_product.php">


                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                placeholder="Nombre del producto" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Descripcion del producto" required>
                        </div>
                        <div class="form-group">
                            <label for="Unidad">Unidad</label>
                            <select class="form-control" name="unit" id="unit">
                                <option value="" disabled selected>Selecione una Unidad</option>
                                <option value="unidad">Unidad</option>
                                <option value="metro">Metro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="stock" name="stock"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="cost">Costo</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="cost" name="cost"
                                placeholder="" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="addProduct()">Guardar</button>
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
        function addProduct() {
            // Obtén los valores del formulario
            var product_name = document.getElementById("product_name").value;
            var description = document.getElementById("description").value;
            var unit = document.getElementById("unit").value;
            var stock = document.getElementById("stock").value;
            var cost = document.getElementById("cost").value;
            // var state = 1;

            // Crea un objeto con los datos que deseas enviar
            var productData = {
                product_name: product_name,
                description: description,
                unit: unit,
                stock: stock,
                cost: cost
            };

            // Realiza una llamada AJAX para enviar los datos al servidor
            fetch("../functions/add_product.php", {
                method: "POST",
                body: JSON.stringify(productData),
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(response => response.json())
                .then(data => {
                    // Aquí puedes manejar la respuesta del servidor
                    if (data.success) {
                        // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
                        $("#modalAgregarProducto").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito!',
                            text: 'El producto de agrego satisfactoriamente.',
                            showConfirmButton: true
                        });
                        // Recarga la página o realiza otras acciones necesarias
                        // window.location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al agregar el producto.',
                            showConfirmButton: true,
                            //timer: 1500 // Cierra automáticamente el SweetAlert después de 1.5 segundos
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