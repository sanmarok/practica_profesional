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
$sql = "SELECT 
    clients.id AS client_id,
    clients.first_name,
    clients.last_name,
    clients.document,
    clients.phone,
    clients.email,
    clients.state AS client_state,
    client_services.id AS service_id,
    client_services.client_id AS service_client_id,
    client_services.service_id AS service_service_id,
    client_services.address AS service_address,
    client_services.state AS service_state
    FROM 
    clients
    INNER JOIN 
    client_services ON clients.id = client_services.client_id
    WHERE 
    client_services.id =" . $_GET['id'];
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

// Cierra la conexión a la base de datos
$mysqli->close();
?>

<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Servicio contratado</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card-body">

            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="inputService">Titular</label>
                            </div>
                            <?php echo '<a href="profile_client.php?id=' . $row['client_id'] . '" class="mx-2" target="_blank"><i class="fas fa-eye text-success"></i></a>' . '<span>' . $row['first_name'] . " " . $row['last_name'] . '</span>'; ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Plan -->
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputService">Plan</label>
                            </div>
                            <select class="custom-select form-control-border" id="inputService" disabled>
                                <?php
                                // Establece una conexión a la base de datos
                                $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

                                // Verifica si la conexión se realizó correctamente
                                if ($mysqli->connect_error) {
                                    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
                                }

                                $subquery = "SELECT * FROM `services`";
                                $subresult = $mysqli->query($subquery);

                                if ($subresult->num_rows > 0) {
                                    while ($subrow = $subresult->fetch_assoc()) {
                                        // Verifica si el servicio actual coincide con el servicio obtenido en la consulta
                                        $selected = ($subrow['service_id'] == $row['service_service_id']) ? 'selected' : '';
                                        echo "<option value=" . $subrow['service_id'] . "' $selected>" . $subrow['name'] . '</option>';
                                    }
                                }

                                // Cierra la conexión a la base de datos
                                $mysqli->close();
                                ?>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editService"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Estado -->
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputServiceAddress">Direccion</label>
                            </div>
                            <input type="text" class="form-control form-control-border" id="inputServiceAddress" value="<?php echo $row['service_address']; ?>" disabled>

                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editServiceAddress"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputService">Estado</label>
                            </div>
                            <select class="custom-select form-control-border" id="inputServiceState" disabled>
                                <option value="0" <?= ($row['service_state'] == 0) ? 'selected' : '' ?>>Inactivo</option>
                                <option value="1" <?= ($row['service_state'] == 1) ? 'selected' : '' ?>>Activo</option>
                                <option value="2" <?= ($row['service_state'] == 2) ? 'selected' : '' ?>>Pendiente</option>
                                <option value="3" <?= ($row['service_state'] == 3) ? 'selected' : '' ?>>Suspendido</option>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editServiceState"><i class="fas fa-pencil-alt"></i></button>
                            </span>
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