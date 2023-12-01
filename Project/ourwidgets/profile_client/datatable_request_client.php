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
                        echo "<td>" . $row['client_service_id'] . "</td>";
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
                        echo '<td class="text-center"><a href="profile_technical_request.php?id=' . $row['id'] . '" class=" btn btn-danger role="button"><i class="fas fa-plug"></i></a></td>';
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