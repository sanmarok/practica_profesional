<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] == '1') {
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
    <title>Pedido de Compra</title>
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
    <!-- SweetAlert -->
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

        <!--Start dashboard parts-->
        <?php include '../ourwidgets/order_details/dashboard_parts.php' ?>
        <!--End dashboard parts-->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!--Start form_edit_order -->
                            <?php include '../ourwidgets/order_details/form_edit_order.php'; ?>
                            <!--End form_edit_order-->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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
    <!-- Table script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
        });
    </script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Control save form -->
    <script>
        $(document).ready(function () {
            // Función para habilitar la edición de un campo
            function enableEdit(inputId) {
                const inputElement = document.getElementById(inputId);
                inputElement.removeAttribute("disabled");
                inputElement.focus();
            }

            // Función para habilitar o deshabilitar el interruptor de estado
            function toggleStateSwitch(disabled) {
                const stateSwitch = document.querySelector('input[name="my-checkbox"]');
                stateSwitch.setAttribute("disabled", disabled);
            }

            // Inicializar el interruptor Bootstrap
            $("[name='my-checkbox']").bootstrapSwitch();

            // Agregar eventos de clic a los botones de edición
            $("#editDescription").click(function () {
                enableEdit("inputDesciption");
            });

            $("#editStatus").click(function () {
                enableEdit("inputStatus");
            });

            $("#editProduct").click(function () {
                enableEdit("inputProduct");
            });

            $("#editQuantity").click(function () {
                enableEdit("inputQuantity");
            });

        });
    </script>
    <script>
        $(document).ready(function () {
            // Función para habilitar el botón de "Guardar"
            function enableSaveButton() {
                $("#btnGuardar").prop("disabled", false);
            }

            // Función para deshabilitar el botón de "Guardar"
            function disableSaveButton() {
                $("#btnGuardar").prop("disabled", true);
            }

            // Agregar eventos de cambio a los campos del formulario
            $("#inputDesciption, #inputStatus, #inputQuantity, #inputProduct").on("change", function () {
                enableSaveButton(); // Habilitar el botón cuando se realizan cambios en los campos de texto
            });

            // Inicialmente, deshabilitar el botón de "Guardar"
            disableSaveButton();
        });
    </script>
    <!-- Save button -->
    <script>
        // Evento para el botón "Guardar"
        $("#btnGuardar").click(function () {
            // Simula una actualización exitosa
            // Aquí deberías agregar tu lógica de actualización del cliente

            // Luego, muestra la alerta de SweetAlert2
            Swal.fire({
                title: 'Actualización Exitosa',
                text: 'El pedido ha sido actualizado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'

            });
        });
    </script>
    <script>
        // Evento para el botón "Guardar"
        // $("#btnGuardar").click(function () {
        //     // Simula una actualización exitosa
        //     // Aquí deberías agregar tu lógica de actualización del cliente

        //     // Luego, muestra la alerta de SweetAlert2
        //     Swal.fire({
        //         title: 'Error',
        //         text: 'El pedido no se ha sido actualizado.',
        //         icon: 'error',
        //         confirmButtonText: 'Aceptar'

        //     });
        // });
    </script>
</body>

</html>