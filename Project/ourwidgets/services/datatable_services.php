<div class="col-12">
    <div class="card card-primary m-2">
        <div class="card-header">
            <h3 class="card-title">Servicios</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarServicio">
                <i class="nav-icon fas fa-plus"></i><span class="mx-1">Servicio</span>
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Carga(Mbps)</th>
                        <th>Descarga(Mbps)</th>
                        <th>Tarifa Mensual</th>
                        <th>Tarifa de Instalación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
                    // $db_host = 'localhost';
                    // $db_user = 'root';
                    // $db_pass = '';
                    // $db_name = 'infinet'; // Cambia esto con el nombre de tu base de datos

                    $db_host = 'localhost';
                    $db_user = 'dbadmin';
                    $db_pass = '.admindb';
                    $db_name = 'infinet';

                    // Establece una conexión a la base de datos
                    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

                    // Verifica si la conexión se realizó correctamente
                    if ($mysqli->connect_error) {
                        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
                    }

                    // Consulta SQL para obtener los datos de los servicios
                    $sql = "SELECT service_id, name, type, upload_speed, download_speed, monthly_fee, installation_fee FROM services";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['service_id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['type'] . "</td>";
                            echo "<td>" . $row['upload_speed'] . "</td>";
                            echo "<td>" . $row['download_speed'] . "</td>";
                            echo "<td>" . $row['monthly_fee'] . "</td>";
                            echo "<td>" . $row['installation_fee'] . "</td>";

                            echo '<td class="text-center">
                            <div>
                                <a href="profile_service.php?id=' . $row['service_id'] . '">
                                    <button class="btn btn-success mx-1"><i class="fas fa-eye"></i></button>
                                </a>
                            </div>';
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
</div>

<!-- /.card-body -->
</div>
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
                            // Borrado exitoso, actualiza la tabla
                            $("#example1").DataTable().row($("#example1 tbody tr[data-id='" + serviceId + "']")).remove().draw(false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Borrado exitoso',
                                text: 'El servicio ha sido borrado correctamente.',
                            }).then(() => {
                                // Recarga la página después de mostrar el mensaje
                                location.reload();
                            });
                        } else {
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