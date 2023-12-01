<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Registro de servicios</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalContratarServicio">
            <i class="nav-icon fas fa-plus"><span class="mx-1">Contratar</span></i>
        </button>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Servicio ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Carga (Mbps)</th>
                    <th>Descarga (Mbps)</th>
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
                        echo "<td>" . $row['id'] . "</td>";
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
                            case 2:
                                echo '<td><span class="badge bg-secondary">Pendiente</span></td>';
                                break;
                            case 3:
                                echo '<td><span class="badge bg-warning">Suspendido</span></td>';
                                break;
                            default:
                                # code...
                                break;
                        }
                        echo '<td class="text-center">

                            <a href="profile_client_service.php?id=' . $row['id'] . '" class="mx-1 btn btn-success" role="button">
                                <i class="fas fa-eye"></i>
                            </a>
                        ';

                        $subquery = "SELECT id, status FROM technical_requests WHERE client_service_id =" . $row['id'] . "";
                        $subresult = $mysqli->query($subquery);

                        if ($subresult->num_rows > 0) {
                            while ($row = $subresult->fetch_assoc()) {
                                if ($row['status'] != 0 && $row['status'] != 1) {
                                    echo '<a href="profile_technical_request.php?id=' . $row['id'] . '" class="mx-1 btn btn-danger role="button"><i class="fas fa-plug"></i></a>';
                                }
                            }
                        } else {
                            echo '<button type="button" class="btn btn-warning mx-1" data-toggle="modal" data-target="#modalSolicitudTecnica' . $row['id'] . '">
                            <i class="fas fa-plus"></i>
                          </button>
    <div class="modal fade text-left " id="modalSolicitudTecnica' . $row['id'] . '">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Nueva Solicitud Técnica</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formSolicitudTecnica' . $row['id'] . '" action="procesar_solicitud_tecnica.php" method="post">
                <!-- Puedes agregar aquí los campos y elementos del formulario necesarios -->
                <input type="hidden" name="clientServiceId" value="' . $row['id'] . '">

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="problem">Problema:</label>
                    <textarea id="problem" name="problem" rows="4" class="form-control"></textarea>
                </div>

                <!-- Puedes agregar más campos y elementos aquí -->

            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" onclick="addRequest()">Guardar</button>
        </div>
    </div>
</div>
        </div>
    </div>';
                        }
                        echo "</td></tr>";
                    }
                }

                // Cierra la conexión a la base de datos
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>