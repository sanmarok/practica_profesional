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
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <form method="post" class="needs-validation" novalidate autocomplete="off">
            <div class="row">
                <div class="col-sm-6">
                    <!-- Nombres -->
                    <div class="form-group input-group">
                        <label for="inputFirstName">Nombres</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border " name="first_name" id="inputFirstName" value="<?php echo $first_name; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editFirstName"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">
                                Por favor, Ingrese un Nombre.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Apellidos -->
                    <div class="form-group input-group">
                        <label for="inputLastName">Apellidos</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-border" name="last_name" id="inputLastName" value="<?php echo $last_name; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editLastName"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">
                                Por favor, Ingrese un Apellido.
                            </div>
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
                            <input type="text" class="form-control form-control-border" name="phone" id="inputPhone" value="<?php echo $phone; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editPhone"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">
                                Por favor, Ingrese un numero de Telefono.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Correo Electrónico -->
                    <div class="form-group input-group">
                        <label for="inputEmail">Correo Electrónico</label>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-border" name="email" id="inputEmail" value="<?php echo $email; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editEmail"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">
                                Por favor, Ingrese un Correo Electrónico.
                            </div>
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
                            <input type="text" class="form-control form-control-border" name="document" id="inputDocumento" value="<?php echo $document; ?>" required disabled>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editDocumento"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                            <div class="invalid-tooltip">
                                Por favor, Ingrese un Numero de Documento.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Estado -->
                    <div class="form-group input-group">
                        <div class="input-group">
                            <label for="inputState">Estado</label>
                        </div>
                        <select class="custom-select form-control-border form-select" name="state" id="inputState" disabled>
                            <option value="1" <?php echo $state == 1 ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo $state == 0 ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                        <span class="input-group-append">
                            <button class="btn btn-outline-danger mx-2" type="button" id="editState"><i class="fas fa-pencil-alt"></i></button>
                        </span>
                    </div>

                </div>
                <input type="hidden" id="inputId" name="id" value="<?php echo $client_id; ?>">
            </div>
    </div>
    <div class="card-footer">
        <button id="btnGuardar" type="submit" class="btn btn-success float-right" disabled>Guardar</button>
    </div>
    </form>
</div>
</div>
<?php include("../functions/update_client.php"); ?>
<!-- /.card-body -->
</div>