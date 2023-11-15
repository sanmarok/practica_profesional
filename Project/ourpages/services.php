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
    <title>Servicios</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        <?php include '../ourwidgets/services/dashboard_parts.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php include '../ourwidgets/services/datatable_services.php' ?>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal para agregar servicio -->
    <div class="modal fade" id="modalAgregarServicio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarServicio" method="post" action="../functions/add_service.php">


                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Nombre del servicio" required autocomplete="off">
                        </div>
                        <div class="form-group">
                        <label for="service_type">Tipo</label>
                        <select class="form-control" id="service_type" name="service_type" required>
                            <?php
                            // Tipos de servicios proporcionados
                            $tiposDeServicio = array(
                                'Fibra Óptica',
                                'Cable',
                                'Satélite',
                                'Teléfono'
                                // Agrega otros tipos según sea necesario
                            );

                            // Itera sobre los tipos de servicio y crea las opciones
                            foreach ($tiposDeServicio as $tipo) {
                                echo "<option value=\"$tipo\">$tipo</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="documento">Carga(Mbps)</label>
                            <input type="text" class="form-control" id="upload_speed" name="upload_speed" placeholder="Velocidad de subida" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Descarga(Mbps)</label>
                            <input type="text" class="form-control" id="download_speed" name="download_speed" placeholder="Velocidad de bajada" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="email">Tarifa Mensual</label>
                            <input type="text" class="form-control" id="monthly_fee" name="monthly_fee" placeholder="Cuota Mensual" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Tarifa de Instalación</label>
                            <input type="text" class="form-control" id="installation_fee" name="installation_fee" placeholder="Tarifa de Instalación" required autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="addService()">Guardar</button>
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
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
        $(function() {
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
    function addService() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al agregar el servicio.',
            showConfirmButton: false,
            timer: 1500
        });



        // Obtén los valores del formulario
        /*var serviceName = document.getElementById("service_name").value;
        var serviceType = document.getElementById("service_type").value;
        var uploadSpeed = document.getElementById("upload_speed").value;
        var downloadSpeed = document.getElementById("download_speed").value;
        var monthlyFee = document.getElementById("monthly_fee").value;
        var installationFee = document.getElementById("installation_fee").value;

        // Crea un objeto con los datos que deseas enviar
        var serviceData = {
            name: serviceName,
            type: serviceType,
            upload_speed: uploadSpeed,
            download_speed: downloadSpeed,
            monthly_fee: monthlyFee,
            installation_fee: installationFee
        };

        // Realiza una llamada AJAX para enviar los datos al servidor
        fetch("../functions/add_service.php", {
                method: "POST",
                body: JSON.stringify(serviceData),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                // Aquí puedes manejar la respuesta del servidor
                if (data.success) {
                    // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
                    $("#modalAgregarServicio").modal("hide");
                    // Recarga la página o realiza otras acciones necesarias
                    window.location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el servicio.',
                        showConfirmButton: false,
                        timer: 1500 // Cierra automáticamente el SweetAlert después de 1.5 segundos
                    });
                }
            })
            .catch(error => {
                // Manejo de errores
                console.error("Error en la llamada AJAX: " + error);
            });*/
    }
</script>

</body>

</html>
