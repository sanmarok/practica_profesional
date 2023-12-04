<div class="col-12">
    <div class="card card-primary m-2">

        <div class="card-header">
            <h3 class="card-title">Clientes</h3>
        </div>
        <div class="card-tools">
            <button type="button" id="btnAgregarCliente" class="btn btn-success ml-4 mt-4 mb-0" data-toggle="modal"
                data-target="#modalAgregarCliente">
                <i class="nav-icon fas fa-plus"></i><span class="mx-1">Cliente</span>
            </button>
        </div>
        <div class="card-body" id="table_clients_container">

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
                            switch ($row['state']) {
                                case null:
                                case '':
                                case 0:
                                    echo '<td class="text-left my-auto"><span class="badge bg-danger">Inactivo</span></td>';
                                    break;
                                case 1:
                                    echo '<td class="text-left my-auto"><span class="badge bg-success">Activo</span></td>';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            // echo "<td>" . $row['state'] . "</td>";
                            echo '<td class="text-center">
        <div>
            <a href="profile_client.php?id=' . $row['id'] . '">
                <button class="btn btn-success mx-1"><i class="fas fa-eye"></i></button>
            </a>
        </div>';
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