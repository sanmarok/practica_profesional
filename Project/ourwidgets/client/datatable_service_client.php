<div class="card card-primary m-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Servicios</h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarServicio">
            <i class="nav-icon fas fa-plus"><span class="mx-1">Contratar</span></i>
        </button>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Velocidad de Carga (Mbps)</th>
                    <th>Velocidad de Descarga (Mbps)</th>
                    <th>Tarifa Mensual</th>
                    <th>Tarifa de Instalación</th>
                    <th>Dirección</th>
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



                $sql = "SELECT cs.id ,s.name, s.type, s.upload_speed, s.download_speed, s.monthly_fee, s.installation_fee, s.service_id ,cs.address, cs.state
                                            FROM client_services cs
                                            INNER JOIN services s ON cs.service_id = s.service_id
                                            WHERE cs.client_id = " . $_GET["id"];




                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['upload_speed'] . "</td>";
                        echo "<td>" . $row['download_speed'] . "</td>";
                        echo "<td>$" . $row['monthly_fee'] . "</td>";
                        echo "<td>$" . $row['installation_fee'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        switch ($row['state']) {
                            case 0:
                                echo '<td><span class="badge bg-danger">Inactivo</span></td>';
                                break;
                            case 1:
                                echo '<td><span class="badge bg-success">Activo</span></td>';
                                break;
                            default:
                                # code...
                                break;
                        }
                        echo '<td class="text-center"><div><a href="service_client.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a></td>';
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
    <div class="modal fade" id="modalAgregarServicio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contratar servicio</h4>
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