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
$sql = "SELECT id, first_name, last_name, document, phone, email, state FROM clients WHERE id =" . $_GET["id"];
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $client_id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $document = $row['document'];
    $phone = $row['phone'];
    $email = $row['email'];
    $state = $row['state'];
} else {
    echo "No se encontro al cliente.";
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>

<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Editar cliente</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Nombres -->
                        <div class="form-group input-group">
                            <label for="inputFirstName">Nombres</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputFirstName" value="<?php echo $first_name; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editFirstName"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Apellidos -->
                        <div class="form-group input-group">
                            <label for="inputLastName">Apellidos</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputLastName" value="<?php echo $last_name; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editLastName"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <!-- Teléfono -->
                        <div class="form-group input-group">
                            <label for="inputPhone">Teléfono</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputPhone" value="<?php echo $phone; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editPhone"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Correo Electrónico -->
                        <div class="form-group input-group">
                            <label for="inputEmail">Correo Electrónico</label>
                            <div class="input-group">
                                <input type="email" class="form-control form-control-border" id="inputEmail" value="<?php echo $email; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editEmail"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Documento -->
                        <div class="form-group input-group">
                            <label for="inputDocumento">Documento</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputDocumento" value="<?php echo $document; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editDocumento"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Estado -->
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputState">Estado</label>
                            </div>
                            <select class="custom-select form-control-border" id="inputState" disabled>
                                <option value="1" <?php echo $state == 1 ? 'selected' : ''; ?>>Activo</option>
                                <option value="0" <?php echo $state == 0 ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editState"><i class="fas fa-pencil-alt"></i></button>
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


