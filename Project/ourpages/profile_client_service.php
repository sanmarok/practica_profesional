<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] == '1' || $_SESSION['role'] == '3') {
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
    <title>Servicio contratado
        <?php echo $_GET['id'] ?>
    </title>
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

        .custom-select.is-valid,
        .was-validated .custom-select:valid {
            background-color: #343a40;
            color: #fff;
            border-color: #6c757d;
        }
    </style>
</head>

<body class="layout-navbar-fixed control-sidebar-slide-open dark-mode">
    <!-- Site wrapper -->
    <div class="wrapper">

        <!--Start dashboard parts-->
        <?php include '../ourwidgets/profile_client_service/dashboard_parts.php' ?>
        <!--End dashboard parts-->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php include '../ourwidgets/profile_client_service/form_edit_client_service.php'; ?>

                            <?php include '../ourwidgets/profile_client_service/datable_invoices.php'; ?>
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
    <!--Print JS -->
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

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

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example3").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,

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

            $("#editService").click(function () {
                enableEdit("inputServiceState");
                enableEdit("inputServiceAddress");
                enableEdit("inputService");
            });

            $("#editServiceAddress").click(function () {
                enableEdit("inputServiceState");
                enableEdit("inputService");
                enableEdit("inputServiceAddress");
            });
            $("#editServiceState").click(function () {
                enableEdit("inputServiceAddress");
                enableEdit("inputService");
                enableEdit("inputServiceState");
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
            $("#inputFirstName, #inputLastName, #inputPhone, #inputEmail, #inputService, #inputServiceAddress, #inputServiceState").on("change", function () {
                enableSaveButton(); // Habilitar el botón cuando se realizan cambios en los campos de texto
            });

            // Inicialmente, deshabilitar el botón de "Guardar"
            disableSaveButton();
        });
    </script>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <!-- Save button -->
    <script>
        function imprimirFactura(facturaId) {
            // Puedes personalizar la URL según la estructura de tu proyecto
            var url = '../functions/pdf/invoice.php?id=' + facturaId;

            // Usa print-js para imprimir la factura
            printJS(url);
        }
    </script>
</body>

</html>