<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Registro de solicitudes tecnicas</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Servicio ID</th>
                    <th>Tipo</th>
                    <th>Encargado</th>
                    <th>Fecha</th>
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



                $sql = "SELECT tr.* FROM technical_requests tr INNER JOIN client_services cs ON tr.client_service_id = cs.id WHERE cs.client_id =" . $_GET['id'];




                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
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
                        if ($row['technician_id'] == null) {
                            echo '<td>Pendiente</td>';
                        } else {
                            $subresult = $mysqli->query("SELECT `first_name`,`last_name` FROM `users` WHERE `id` =" . $row['technician_id']);
                            $subrow = $subresult->fetch_assoc();
                            echo '<td>' . $subrow['first_name'] . " " . $subrow['last_name'] . '</td>';
                        }
                        echo "<td>" . $row['date_created'] . "</td>";
                        echo "<td>" . $row['client_service_id'] . "</td>";
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
                        echo '<td class="text-center"><a href="profile_technical_request.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-plug text-danger"></i></a></td>';
                        echo "</tr>";
                    }
                } else {
                }

                // Cierra la conexión a la base de datos
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<!-- Start modal addServiceClient -->
<div>
    <div class="modal fade" id="modalAgregarSolicitud">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Solicitud</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formContratarServicio" method="post" action="../functions/add_services_client.php">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Servicio</label>
                            <select class="custom-select rounded-0 my-1" id="exampleSelectBorder">
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
                                $sql = "SELECT * FROM `services`";
                                $result = $mysqli->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value=" . $row['service_id'] . '">' . $row['name'] . '</option>';
                                    }
                                } else {
                                }

                                // Cierra la conexión a la base de datos
                                $mysqli->close();
                                ?>
                            </select>
                            <div class="form-group">
                                <label for="nombre">Direccion</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Direccion" required autocomplete="off">
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="addClient()">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End modal addServiceClient -->