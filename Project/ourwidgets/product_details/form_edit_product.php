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

// Consulta SQL para obtener los datos del producto
$sql = "SELECT * FROM products WHERE id =" . $_GET["id"];
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_id = $row['id'];
    $product_name = $row['name'];
    $description = trim($row['description']);
    $unit = $row['unit'];
    $cost = $row['cost'];
    $product_stock = $row['stock'];
} else {
    echo "No se encontro el Producto.";
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>

<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Editar producto</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputName">Nombre del producto</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" name="product_name"
                                    id="inputName" value="<?php echo $product_name; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editName"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputDescription">Descripcion</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control form-control-border"
                                    name="product_description" id="inputDescription" value=""
                                    disabled><?php echo $description; ?></textarea>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editDescription"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputUnit">Unidad</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" name="product_unit"
                                    id="inputUnit" value="<?php echo $unit; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editUnit"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputCost">Costo</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" name="product_cost"
                                    id="inputCost" value="<?php echo $cost; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editCost"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputStock">Stock</label>
                            <div class="input-group">
                                <input type="number" min="0.00" step="0.01" class="form-control form-control-border"
                                    name="product_stock" id="inputStock" value="<?php echo $product_stock; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editStock"><i
                                            class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group input-group">
                            <label for="inputTotalCost">Costo Total</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control form-control-border"
                                    value="<?php echo $cost * $product_stock; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        </div>
    </div>
    <div class="card-footer">
        <button id="btnGuardar" type="submit" class="btn btn-success float-right" disabled>Guardar</button>
    </div>
</div>
</form>
</div>

<!-- /.card-body -->
</div>

<?php
include '../functions/update_products.php';
?>