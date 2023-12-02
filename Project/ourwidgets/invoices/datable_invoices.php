<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Facturas</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <table id="tableinvoices" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Factura ID</th>
                    <th>Servicio</th>
                    <th>Tipo</th>
                    <th>Fecha de emisión</th>
                    <th>Fecha de vencimiento</th>
                    <th>Total</th>
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



                $sql = 'SELECT invoices.*, services.name as "service_name" FROM invoices INNER JOIN client_services ON invoices.client_service_id = client_services.id INNER JOIN services ON client_services.service_id = services.service_id';

                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['service_name'] . "</td>";
                        switch ($row['type']) {
                            case 0:
                                echo '<td>Factura A</td>';
                                break;
                            case 1:
                                echo '<td>Factura B</td>';
                                break;
                            case 2:
                                echo '<td>Factura C</td>';
                                break;
                            case 3:
                                echo '<td>Factura E</td>';
                                break;
                            case 4:
                                echo '<td>Factura M</td>';
                                break;
                            default:

                                break;
                        }

                        echo "<td>" . $row['issue_date'] . "</td>";
                        echo "<td>" . $row['due_date'] . "</td>";
                        echo "<td>$" . $row['price_service'] + $row['price_installation'] + $row['surcharge'] . "</td>";
                        switch ($row['state']) {
                            case 0:
                                echo '<td><span class="badge bg-danger">Cancelada</span></td>';
                                break;
                            case 1:
                                echo '<td><span class="badge bg-success">Pagada</span></td>';
                                break;
                            case 2:
                                echo '<td><span class="badge bg-secondary">Pendiente</span></td>';
                                break;
                            case 3:
                                echo '<td><span class="badge bg-warning">Vencida</span></td>';
                                break;
                            default:
                                # code...
                                break;
                        }
                        echo '<td class="text-center">
                        <a href="../functions/pdf/invoice.php?id=' . $row['id'] . '" target="_blank" class="btn btn-primary mx-1"><i class="fas fa-file-alt text-white"></i></a>
                        <a href="#" data-toggle="modal" data-target="#editarModal' . $row['id'] . '" class="btn btn-danger mx-1"><i class="fas fa-edit text-white"></i></a>
                      </td>';

                        echo "</tr>";
                        echo '
<div class="modal fade" id="editarModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Factura N° ' . $row['id'] . '</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega el formulario de edición aquí -->
                <form id="editarForm' . $row['id'] . '">
                    <!-- Campo oculto para la factura_id -->
                    <input type="hidden" name="factura_id" value="' . $row['id'] . '">

                    <label for="exampleSelectBorder">Estado</label>
                    <select class="custom-select rounded-0 my-1" id="exampleSelectBorder" name="estado">
                        <option value="0" ' . (($row['state'] == 0) ? 'selected' : '') . '>Cancelada</option>
                        <option value="1" ' . (($row['state'] == 1) ? 'selected' : '') . '>Pagada</option>
                        <option value="2" ' . (($row['state'] == 2) ? 'selected' : '') . '>Pendiente</option>
                        <option value="3" ' . (($row['state'] == 3) ? 'selected' : '') . '>Vencida</option>
                    </select>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="confirmarGuardar(' . $row['id'] . ')">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarGuardar(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción actualizará la factura.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, guardar cambios",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes realizar acciones adicionales si es necesario
            // Puedes agregar una llamada AJAX para actualizar la base de datos

            // Cierra la ventana modal
            $("#editarModal" + id).modal("hide");

            // Muestra un SweetAlert de éxito (puedes ajustarlo según tus necesidades)
            Swal.fire("¡Error!", "La factura no pudo ser actualizada.", "error");
        }
    });
}
</script>';
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