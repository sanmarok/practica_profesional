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

// Consulta SQL para obtener los datos del servicio
$sql = "SELECT service_id, name, type, upload_speed, download_speed, monthly_fee, installation_fee FROM services WHERE service_id =" . $_GET["id"];
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $service_id = $row['service_id'];
    $name = $row['name'];
    $type = $row['type'];
    $upload_speed = $row['upload_speed'];
    $download_speed = $row['download_speed'];
    $monthly_fee = $row['monthly_fee'];
    $installation_fee = $row['installation_fee'];
} else {
    echo "No se encontró el servicio.";
}

// Consulta SQL para obtener información cruzada relacionada con el servicio
// Consulta SQL para obtener información cruzada relacionada con el servicio
$sqlClientsWithService = "SELECT COUNT(*) as count 
                          FROM client_services
                          WHERE service_id = $service_id";

$resultClientsWithService = $mysqli->query($sqlClientsWithService);
$rowClientsWithService = $resultClientsWithService->fetch_assoc();
$countClientsWithService = $rowClientsWithService['count'];

// Cierra la conexión a la base de datos
$mysqli->close();
?>




<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Editar servicio</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="formEditarServicio" method="post" action="../functions/update_service.php" class="position-relative">
            <div class="row">
                <div class="col-sm-6">
                    <!-- Nombre del servicio -->
                    <div class="form-group input-group">
                        <label for="inputServiceName">Nombre del Servicio</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" id="inputServiceName" value="<?php echo $name; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editServiceName"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">Por favor, ingrese un nombre de servicio con al menos dos caracteres.</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Tipo de servicio -->
                    <div class="form-group input-group">
                        <label for="inputServiceType">Tipo de Servicio</label>
                        <div class="input-group">
                             <select class="form-control form-control-border" id="inputServiceType" disabled>
                                <?php
                                     // Tipos de servicios proporcionados
                                     $tiposDeServicio = array(
                                        'Fibra Óptica',
                                        'Cable',
                                        'Satélite',
                                        'Teléfono'
                                        // Agrega otros tipos según sea necesario
                                        );

                                        // Itera sobre los tipos de servicio y crea las opciones
                                         foreach ($tiposDeServicio as $tipo) {
                                        echo "<option value=\"$tipo\">$tipo</option>";
                                        }
                                ?>
                             </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editServiceType"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                        </div>
                        <div class="invalid-tooltip"></div>
                    </div>
                </div>
            </div>
            
            <!-- Velocidad de subida y Velocidad de bajada -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group input-group">
                        <label for="inputUploadSpeed">Velocidad de Subida</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" id="inputUploadSpeed" value="<?php echo $upload_speed; ?>" disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editUploadSpeed"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">Por favor, ingrese velocidades válidas (números positivos).</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group input-group">
                        <label for="inputDownloadSpeed">Velocidad de Bajada</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" id="inputDownloadSpeed" value="<?php echo $download_speed; ?>" disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editDownloadSpeed"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">Por favor, ingrese velocidades válidas (números positivos).</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cuota Mensual y Tarifa de Instalación -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group input-group">
                        <label for="inputMonthlyFee">Cuota Mensual</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" id="inputMonthlyFee" value="<?php echo $monthly_fee; ?>" disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2"  type="button" id="editMonthlyFee"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">Por favor, ingrese datos válidos (números positivos).</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group input-group">
                        <label for="inputInstallationFee">Tarifa de Instalación</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" id="inputInstallationFee" value="<?php echo $installation_fee; ?>" disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2"  type="button" id="editInstallationFee"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">Por favor, ingrese datos válidos (números positivos).</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="service-container" data-service-id="<?php echo $_GET['id']; ?>">
    <!-- Resto de tu código HTML -->
    </div>

    <!-- Botón para eliminar servicio -->
    <button type="button" class="btn btn-danger" onclick="deleteService(<?php echo $service_id; ?>)" style="position: absolute; top: 360px; left: 20px;" <?php echo ($countClientsWithService > 0 ? 'disabled' : ''); ?>>
        <i class="fas fa-times"></i> Eliminar Servicio
    </button>

    <div class="card-footer">
        <button id="btnGuardar" class="btn btn-success float-right" onclick="updateServiceValidationForm()">Guardar</button>
    </div>
    <!-- /.card-body -->
</div>






<script>
function deleteService(serviceId) {
    // Pregunta al usuario para confirmar el borrado
    Swal.fire({
        title: '¿Está seguro?',
        text: '¡No podrá revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realiza una llamada AJAX para borrar el servicio
            fetch("../functions/delete_service.php?id=" + serviceId, {
                method: "GET"
            })
            .then(response => response.json())
            .then(data => {
                // Maneja la respuesta del servidor
                if (data.success) {
                    // Borrado exitoso, muestra un mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'El servicio se ha borrado correctamente.',
                    }).then(() => {
                        // Redirige a la página de servicios
                        window.location.href = "services.php";
                    });
                } else {
                    // Muestra un mensaje de error en caso de fallo
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al borrar el servicio.',
                    });
                }
            })
            .catch(error => {
                console.error("Error en la llamada AJAX: " + error);
            });
        }
    });
}
</script>
