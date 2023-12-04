<?php
echo '<button type="button" class="btn btn-warning mx-1" data-toggle="modal" data-target="#modalSolicitudTecnica' . $row['id'] . '">
    <i class="fas fa-plus"></i>
</button>
<div class="modal fade text-left" id="modalSolicitudTecnica' . $row['id'] . '">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear solicitud técnica</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSolicitudTecnica' . $row['id'] . '" class="needs-validation" novalidate>
                    <input type="hidden" name="clientServiceId' . $row["id"] . '" value="' . $row['id'] . '">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion' . $row['id'] . '" name="descripcion" rows="4" class="form-control" required></textarea>
                                <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="problem">Problema</label>
                                <textarea id="problem' . $row['id'] . '" name="problem" rows="4" class="form-control" required></textarea>
                                <div class="invalid-feedback">Este campo no puede estar vacío.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarSolicitud(' . $row['id'] . ')">Guardar</button>
            </div>
        </div>
    </div>
</div>';
