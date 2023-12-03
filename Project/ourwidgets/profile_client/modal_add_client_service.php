<div class="modal fade" id="modalContratarServicio">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Contratar servicio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formContratarServicio" class="needs-validation" novalidate>
                    <input type="hidden" id="id_client" name="id_client" value="<?php echo $_GET["id"]; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelectBorder">Servicio</label>
                                <select class="custom-select rounded-0 my-1" id="exampleSelectBorder" name="service_id" required>
                                    <option value="" selected>Seleccione el servicio a contratar</option>
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
                                            echo '<option value="' . $row['service_id'] . '">' . $row['name'] . '</option>';
                                        }
                                    } else {
                                    }

                                    // Cierra la conexión a la base de datos
                                    $mysqli->close();
                                    ?>
                                </select>
                                <div class="invalid-feedback">Por favor, selecciona un servicio.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Departamento</label>
                                <select name="city" id="city" class="custom-select rounded-0 my-1">
                                    <option value="" selected disabled>Seleccione departamento</option>
                                    <option value="Concordia">Concordia</option>
                                    <option value="Paso de los Libres">Paso de los Libres</option>
                                    <option value="Villaguay">Villaguay</option>
                                    <option value="Mercedes">Mercedes</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecciona un departamento.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="street">Calle</label>
                            <input type="text" name="street" id="street" class="form-control" required>
                            <div class="invalid-feedback">Por favor, ingresa una calle válida (letras, números y espacios).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Número</label>
                            <input type="number" name="number" id="number" class="form-control" required min=1 step="1">
                            <div class="invalid-feedback">Por favor, ingresa un número válido.</div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="validationAddClientServiceForm()">Guardar</button>
            </div>
        </div>
    </div>
</div>