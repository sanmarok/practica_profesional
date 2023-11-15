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
$sql = "SELECT id, description, status, user_id, creation_date FROM purchase_orders WHERE id =" . $_GET["id"];
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order_id = $row['id'];
    $description = $row['description'];
    $status = $row['status'];
    $user_id = $row['user_id'];
    $creation_date = $row['creation_date'];

    $sql = "SELECT od.product_id, p.name,od.quantity FROM order_details AS od 
    INNER JOIN products AS p ON od.product_id = p.id
    WHERE od.purchase_order_id =" . $order_id;
    $result = $mysqli->query($sql);

    $sql = "SELECT id, name FROM products";
    $products = $mysqli->query($sql);
    $sql = "SELECT first_name,last_name FROM users WHERE id = " . $user_id;
    $stmt = $mysqli->query($sql);
    $titular = $stmt->fetch_assoc();

} else {
    echo "No se encontro el pedido.";
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>

<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Editar pedido</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="input">Titular</label>
                            <div class="input-group">
                                <input type="text" rows="1" class="form-control form-control-border" id="input"
                                    value="<?php echo $titular["first_name"] . " " . $titular["last_name"]; ?>"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Apellidos -->
                        <div class="form-group input-group">
                            <label for="inputCreation">Fecha de Creacion</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputCreation" value="<?php echo $creation_date; ?>"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputDesciption">Descripcion</label>
                            <div class="input-group">
                                <textarea type="text" rows="1" class="form-control form-control-border"
                                    id="inputDesciption" value="" disabled><?php echo $description; ?></textarea>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editDescription"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Apellidos -->
                        <div class="form-group input-group">
                            <label for="inputStatus">Estado</label>
                            <div class="input-group">
                                <select type="text" class="form-control form-control-border" id="inputStatus" value=""
                                    disabled>
                                    <option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Cancelado</option>
                                    <option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Recibido</option>
                                    <option value="2" <?php echo $status == 2 ? 'selected' : ''; ?>>Pendiente</option>
                                </select>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editStatus"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="form-froup">Productos:</h4>
                <br>
                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // print_r($row);
                            echo
                                '<div class="col-sm-6">
                                    <div class="form-group input-group">
                                    <label for="inputProduct">Producto</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-border" id="inputProduct" disabled>
                                            <option value="' . $row['product_id'] . '">' . $row['name'] . '</option>
                                            ';
                            while ($product = $products->fetch_assoc()) {
                                echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option> ';
                            }
                            echo '
                                        </select>
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-danger mx-2" type="button" id="editProduct"><i
                                                    class="fas fa-pencil-alt"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group input-group">
                                    <label for="inputQuantity">Cantidad</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control form-control-border" id="inputQuantity"
                                            value="' . $row['quantity'] . '" disabled>
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-danger mx-2" type="button" id="editQuantity"><i
                                                    class="fas fa-pencil-alt"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card-footer">
    <button id="btnGuardar" class="btn btn-success float-right" disabled>Guardar</button>
</div>
<!-- /.card-body -->
</div>