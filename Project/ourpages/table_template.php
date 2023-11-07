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
              <a href="../clientes.html" class="nav-link">
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
              <a href="../servicios.html" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Servicios
                </p>
              </a>
            </li>';
                        }
                        ?>

                        <li class="nav-item">
                            <a href="../solicitudes-tecnicas.html" class="nav-link">
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
                <a href="../pedidos-compra.html" class="nav-link">
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
                <a href="../productos.html" class="nav-link">
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
                            <div class="card">
                                <h3 class="p-3">Clientes</h3>
                                <div class="card-header"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarCliente">
                                        <i class="nav-icon fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Documento</th>
                                                <th>Teléfono</th>
                                                <th>Correo Electrónico</th>
                                                <th>Estado</th>
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
                                            $sql = "SELECT id, first_name, last_name, document, phone, email, state FROM clients";
                                            $result = $mysqli->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['first_name'] . "</td>";
                                                    echo "<td>" . $row['last_name'] . "</td>";
                                                    echo "<td>" . $row['document'] . "</td>";
                                                    echo "<td>" . $row['phone'] . "</td>";
                                                    echo "<td>" . $row['email'] . "</td>";
                                                    echo "<td>" . $row['state'] . "</td>";
                                                    echo '<td class="text-center"><div><a href="ver_cliente.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a><a href="editar_cliente.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-edit text-danger"></i></a></div></td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "No se encontraron clientes.";
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

    <!-- Modal para agregar cliente -->
    <div class="modal fade" id="modalAgregarCliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí puedes agregar el formulario para agregar un nuevo cliente -->
                    <!-- Por ejemplo: -->
                    <!-- <form>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cliente">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del cliente">
                        </div>
                        <!-- Agrega más campos aquí -->
                    </form> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
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
</body>

</html>