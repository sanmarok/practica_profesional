<div class="modal fade" id="modalContratarServicio">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Contratar Servicio 1</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formContratarServicio" class="needs-validation" novalidate>
                    <input type="hidden" id="id_client" name="id_client" value="<?php echo $_GET["id"]; ?>">
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
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required autocomplete="off">
                        <div class="invalid-feedback">Por favor, ingresa una dirección válida.</div>
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