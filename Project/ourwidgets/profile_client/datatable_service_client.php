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
        <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarServicio">
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
                                echo '<td><span class="badge bg-warning">Riesgoso</span></td>';
                                break;
                            default:
                                # code...
                                break;
                        }
                        echo '<td class="text-center"><div><a href="profile_client_service.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a>';
                        $subquery = "SELECT id, status FROM technical_requests WHERE client_service_id =" . $row['id'] . "";
                        $subresult = $mysqli->query($subquery);

                        if ($subresult->num_rows > 0) {
                            while ($row = $subresult->fetch_assoc()) {
                                if ($row['status'] != 0 && $row['status'] != 1) {
                                    echo '<a href="profile_technical_request.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-plug text-danger"></i></a>';
                                } else {
                                    echo '<a href="add_request.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-plus text-warning"></i></a>';
                                }
                            }
                        } else {
                            echo '<a href="add_request.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-plus text-warning"></i></a>';
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
                    <button type="button" class="btn btn-success" onclick="addServiceClient()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal addServiceClient -->

<script>
    function addServiceClient() {
        // Realiza alguna validación o acción aquí antes de mostrar SweetAlert

        // Muestra SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Servicio contratado correctamente',
            showConfirmButton: false,
            timer: 1000, // Tiempo en milisegundos (opcional)
            didClose: () => {
                // Cierra la ventana modal después de mostrar SweetAlert
                $('#modalAgregarServicio').modal('hide');
            }
        });

        // Puedes agregar aquí el código adicional para enviar el formulario o realizar otras acciones
    }
</script>