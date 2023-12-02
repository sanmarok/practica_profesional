<!-- Modal para agregar cliente -->
<div class="modal fade" id="modalAgregarCliente">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarCliente" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombre del cliente" required autocomplete="off">
                                <div class="invalid-feedback">Por favor, ingrese un nombre válido (solo letras, al menos dos caracteres).</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellido del cliente" required autocomplete="off">
                                <div class="invalid-feedback">Por favor, ingrese un apellido válido (solo letras, al menos dos caracteres).</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <input type="text" class="form-control" id="documento" name="document" placeholder="Documento del cliente" required autocomplete="off">
                                <div class="invalid-feedback">Por favor, ingrese un documento válido (número entero positivo de 8 dígitos).</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono del cliente" required autocomplete="off">
                                <div class="invalid-feedback">Por favor, ingrese un número de teléfono válido.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico del cliente" required autocomplete="off">
                                <div class="invalid-feedback">Por favor, ingrese una dirección de correo electrónico válida.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="addClientValidationForm()">Guardar</button>
            </div>
        </div>
    </div>
</div>