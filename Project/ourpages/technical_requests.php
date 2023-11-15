<?php
session_start();
if (isset($_SESSION['id'])) {
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
    <title>Modelo de tabla</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <style>
        /* Regla de estilo personalizada para el mensaje de error */
        .swal2-popup .swal2-title {
            color: white;
            /* Cambia el color del texto a blanco */
        }
    </style>


</head>

<body class="layout-navbar-fixed control-sidebar-slide-open dark-mode">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light bg-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard.php" class="nav-link text-white">Inicio</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard.php" class="brand-link elevation-4">
                <span class="brand-text font-weight-light mx-auto">Infinet</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block m-2"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></a>

                        <?php
                        switch ($_SESSION['role']) {
                            case 1:
                                echo '<i class="nav-icon fas fa-user-tie m-2"></i><span class="px-1">Adminstrador<span>';
                                break;
                            case 2:
                                echo '<i class="nav-icon fas fa-users-gears m-2"></i><span class= px-1>Tecnico<span>';
                                break;
                            case 3:
                                echo '<i class="nav-icon fas fa-user m-2"></i><span class= px-1>Secretario<span>';
                                break;
                            default:
                                # code...
                                break;
                        }
                        ?>

                        <div class="mt-3"> <!-- Este div envuelve el botón de cierre de sesión -->
                            <a href="../functions/logout.php" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i><span class="text-white m-2">Cerrar Sesión</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <?php
                        if ($_SESSION['role'] != 2) {
                            echo '            <li class="nav-item">
              <a href="clients.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Clientes
                </p>
              </a>
            </li>';
                        }
                        ?>

                        <?php
                        if ($_SESSION['role'] != 2) {
                            echo '           <li class="nav-item">
              <a href="services.php" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Servicios
                </p>
              </a>
            </li>';
                        }
                        ?>

                        <li class="nav-item">
                            <a href="technical_requests.php" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Solicitudes Técnicas
                                </p>
                            </a>
                        </li>

                        <?php
                        if ($_SESSION['role'] == 1) {
                            echo '
              <li class="nav-item">
                <a href="purchase_orders.php" class="nav-link">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Pedidos de Compra
                  </p>
                </a>
              </li>';
                        }
                        ?>

                        <?php
                        if ($_SESSION['role'] == 1) {
                            echo '
              <li class="nav-item">
                <a href="products.php" class="nav-link">
                  <i class="nav-icon fas fa-box-open"></i>
                  <p>
                    Productos
                  </p>
                </a>
              </li>';
                        }
                        ?>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary m-2">

                                <div class="card-header">
                                    <h3 class="card-title">Solicitudes tecnicas</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarCT">
                                        <i class="nav-icon fas fa-plus"><span class="mx-1">Solicitud tecnica</span></i>
                                    </button>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>IDSolicitud</th>
                                                <th>Descripcion</th>
                                                <th>Problema</th>
                                                <th>Estado</th>
                                                <th>Fecha Creacion</th>
                                                <th>Tipo</th>
                                                <th>Servicio del Cliente</th>
                                                <th>IDTecnico</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
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

                                            // Consulta SQL para obtener los datos de los clientes
                                            $sql = "SELECT id, description, problem, status, date_created, type, client_service_id, technician_id FROM technical_requests";
                                            $result = $mysqli->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td style='text-align: center;'>" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['description'] . "</td>";
                                                    echo "<td>" . $row['problem'] . "</td>";
                                                    switch ($row['status']) {
                                                        case 0:
                                                            echo '<td><span class="badge bg-danger">Cancelada</span></td>';
                                                            break;
                                                        case 1:
                                                            echo '<td><span class="badge bg-success">Completada</span></td>';
                                                            break;
                                                        case 2:
                                                            echo '<td><span class="badge bg-primary">Asignada</span></td>';
                                                            break;
                                                        case 3:
                                                            echo '<td><span class="badge bg-warning">Pendiente</span></td>';
                                                            break;
                                                        case 4:
                                                            echo '<td><span class="badge bg-info">En proceso</span></td>';
                                                            break;
                                                        default:
                                                            # code...
                                                            break;
                                                    }
                                                    echo "<td>" . $row['date_created'] . "</td>";
                                                    switch ($row['type']) {
                                                        case 0:
                                                            echo '<td>Instalación</td>';
                                                            break;
                                                        case 1:
                                                            echo '<td>Mantenimiento</td>';
                                                            break;
                                                        case 2:
                                                            echo '<td>Infraestructura</td>';
                                                            break;
                                                    }
                                                    echo "<td style='text-align: center;'>" . $row['client_service_id'] . "</td>";
                                                    echo "<td style='text-align: center;'>";
                                                    if ($row['technician_id'] == 0) {
                                                        // Muestra un botón más pequeño si el valor es 0
                                                        echo '<button class="btn" style="font-size: 12px; padding: 3px 6px;"><i class="fas fa-edit text-danger"></i></button>';
                                                    } else {
                                                        // De lo contrario, muestra el valor de technician_id
                                                        echo $row['technician_id'];
                                                    }
                                                    echo "</td>";




                                                    // echo "<td>" . $row['state'] . "</td>";
                                                    echo '<td class="text-center"><div><a href="profile_technical_request.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a></div></td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "No se encontraron casos.";
                                            }

                                            // Cierra la conexión a la base de datos
                                            $mysqli->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- Modal EJEMPLO -->
    <div class="modal fade" id="modalAgregarCT">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Caso Tecnico</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarCT" method="post" action="add_solicitudesT.php">

                        <div class="form-group">
                            <label for="ID Cliente">ID Cliente</label>
                            <input type="text" class="form-control" id="client_service_id" name="client_service_id" placeholder="Ingresar ID del cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="Problema">Problema</label>
                            <input type="text" class="form-control" id="problem" name="problem" placeholder="Problema" required>
                        </div>
                        <div class="form-group">
                            <label for="Tipo">Tipo</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="Tipo" required>
                        </div>
                        <div class="form-group">
                            <label for="ID Tecnico">ID Tecnico</label>
                            <input type="email" class="form-control" id="technician_id" name="technician_id" placeholder="ID Tecnico (Opcional)" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="addCasoCliente()">Ingresar Caso</button>

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
        function addCasoCliente() {
            // Obtén los valores del formulario
            var client_service_id = document.getElementById("client_service_id").value;
            var description = document.getElementById("description").value;
            var problem = document.getElementById("problem").value;
            var type = document.getElementById("type").value;
            var technician_id = document.getElementById("technician_id").value;
            var status = 3;


            // Crea un objeto con los datos que deseas enviar
            var clientData = {
                client_service_id: client_service_id,
                description: description,
                problem: problem,
                type: type,
                technician_id: technician_id,
                status: status
            };

            // Realiza una llamada AJAX para enviar los datos al servidor
            fetch("../functions/add_solicitudesT.php", {
                    method: "POST",
                    body: JSON.stringify(clientData),
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Aquí puedes manejar la respuesta del servidor
                    if (data.success) {
                        // La operación se completó exitosamente, puedes cerrar el modal o hacer otras acciones
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'El caso técnico ha sido agregado exitosamente.',
                            showConfirmButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Cierra el modal y recarga la página o actualiza la tabla de datos para reflejar los cambios
                                $("#modalAgregarCT").modal("hide");
                                window.location.reload();
                            }
                        });
                    } else {
                        // Si no es exitoso, muestra un SweetAlert de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al agregar el caso. ' + data.error,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    // Manejo de errores
                    console.error("Error en la llamada AJAX: " + error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo ingresar un nuevo caso tecnico.',
                        showConfirmButton: true
                    });
                });
        }
    </script>

</body>

</html>