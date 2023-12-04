  <!-- Modal para agregar servicio -->
    <div class="modal fade" id="modalAgregarServicio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarServicio" method="post" action="../functions/add_service.php">
                        <div class="form-group">
                            <label for="service_name">Nombre</label>
                            <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Nombre del servicio" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, ingrese un nombre de servicio válido.</div>
                        </div>

                        <div class="form-group">
                            <label for="service_type">Tipo</label>
                            <select class="form-control" id="service_type" name="service_type" required>
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
                            <div class="invalid-feedback">Por favor, seleccione un tipo de servicio válido.</div>
                        </div>

                        <div class="form-group">
                            <label for="upload_speed">Carga(Mbps)</label>
                            <input type="text" class="form-control" id="upload_speed" name="upload_speed" placeholder="Velocidad de subida" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, ingrese una velocidad de carga válida.</div>
                        </div>

                        <div class="form-group">
                            <label for="download_speed">Descarga(Mbps)</label>
                            <input type="text" class="form-control" id="download_speed" name="download_speed" placeholder="Velocidad de bajada" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, ingrese una velocidad de descarga válida.</div>
                        </div>

                        <div class="form-group">
                            <label for="monthly_fee">Tarifa Mensual</label>
                            <input type="text" class="form-control" id="monthly_fee" name="monthly_fee" placeholder="Cuota Mensual" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, ingrese una tarifa mensual válida.</div>
                        </div>

                        <div class="form-group">
                            <label for="installation_fee">Tarifa de Instalación</label>
                            <input type="text" class="form-control" id="installation_fee" name="installation_fee" placeholder="Tarifa de Instalación" required autocomplete="off">
                            <div class="invalid-feedback">Por favor, ingrese una tarifa de instalación válida.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="addServiceValidationForm()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

