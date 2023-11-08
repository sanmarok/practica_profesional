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
    <title>Inicio</title>
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
                        <span class="d-block m-2"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></span>

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
                            $sql = "SELECT id, first_name, last_name, document, phone, email, state FROM clients WHERE id =" . $_GET["id"];
                            $result = $mysqli->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $client_id = $row['id'];
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $document = $row['document'];
                                $phone = $row['phone'];
                                $email = $row['email'];
                                $state = $row['state'];
                            } else {
                                echo "No se encontro al cliente.";
                            }

                            // Cierra la conexión a la base de datos
                            $mysqli->close();
                            ?>

                            <div class="card card-primary m-2">
                                <div class="card-header">
                                    <h3 class="card-title">Editar cliente</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- Nombres -->
                                                    <div class="form-group input-group">
                                                        <label for="inputFirstName">Nombres</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-border" id="inputFirstName" value="<?php echo $first_name; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-outline-danger" type="button" id="editFirstName"><i class="fas fa-pencil-alt"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <!-- Apellidos -->
                                                    <div class="form-group input-group">
                                                        <label for="inputLastName">Apellidos</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-border" id="inputLastName" value="<?php echo $last_name; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-outline-danger" type="button" id="editLastName"><i class="fas fa-pencil-alt"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- Teléfono -->
                                                    <div class="form-group input-group">
                                                        <label for="inputPhone">Teléfono</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-border" id="inputPhone" value="<?php echo $phone; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-outline-danger" type="button" id="editPhone"><i class="fas fa-pencil-alt"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <!-- Correo Electrónico -->
                                                    <div class="form-group input-group">
                                                        <label for="inputEmail">Correo Electrónico</label>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control form-control-border" id="inputEmail" value="<?php echo $email; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-outline-danger" type="button" id="editEmail"><i class="fas fa-pencil-alt"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- Documento -->
                                                    <div class="form-group input-group">
                                                        <label for="inputDocumento">Documento</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-border" id="inputDocumento" value="<?php echo $document; ?>" disabled>
                                                            <span class="input-group-append">
                                                                <button class="btn btn-outline-danger" type="button" id="editDocumento"><i class="fas fa-pencil-alt"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <!-- Estado -->
                                                    <div class="form-group input-group">
                                                        <div class="input-group">
                                                            <label for="inputState">Estado</label>
                                                        </div>
                                                        <div class="bootstrap-switch bootstrap-switch-wrapper m-1">
                                                            <input type="checkbox" name="my-checkbox" id="inputState" data-off-color="danger" <?php echo $state == 1 ? 'checked' : ''; ?> data-bootstrap-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button id="btnGuardar" class="btn btn-success float-right" disabled>Guardar</button>
                                </div>
                                <!-- /.card-body -->
                            </div>
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
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
        $(document).ready(function() {
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
            $("#editFirstName").click(function() {
                enableEdit("inputFirstName");
            });

            $("#editLastName").click(function() {
                enableEdit("inputLastName");
            });

            $("#editPhone").click(function() {
                enableEdit("inputPhone");
            });

            $("#editEmail").click(function() {
                enableEdit("inputEmail");
            });

            $("#editDocumento").click(function() {
                enableEdit("inputDocumento");
            });

            $("#editState").click(function() {
                // Habilitar o deshabilitar el interruptor de estado
                const stateSwitch = document.querySelector('input[name="my-checkbox"]');
                if (stateSwitch.getAttribute("disabled")) {
                    toggleStateSwitch(false);
                } else {
                    toggleStateSwitch(true);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Función para habilitar el botón de "Guardar"
            function enableSaveButton() {
                $("#btnGuardar").prop("disabled", false);
            }

            // Función para deshabilitar el botón de "Guardar"
            function disableSaveButton() {
                $("#btnGuardar").prop("disabled", true);
            }

            // Agregar eventos de cambio a los campos del formulario
            $("#inputFirstName, #inputLastName, #inputPhone, #inputEmail, #inputDocumento").on("change", function() {
                enableSaveButton(); // Habilitar el botón cuando se realizan cambios en los campos de texto
            });

            // Evento para el cambio en el interruptor
            $("#inputState").on("switchChange.bootstrapSwitch", function() {
                enableSaveButton(); // Habilitar el botón cuando se cambia el interruptor
            });


            // Inicialmente, deshabilitar el botón de "Guardar"
            disableSaveButton();
        });
    </script>
</body>

</html>