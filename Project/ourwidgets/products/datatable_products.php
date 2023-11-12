<div class="col-12">
    <div class="card">
        <h3 class="p-3">Productos</h3>
        <div class="card-header"><button type="button" class="btn btn-success" data-toggle="modal"
                data-target="#modalAgregarProducto">
                <i class="nav-icon fas fa-plus"></i>
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        <th>Costo</th>
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

                    // Consulta SQL para obtener los datos de los clientes
                    $sql = "SELECT id, name, description, unit, stock, cost FROM products";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['unit'] . "</td>";
                            echo "<td>" . $row['stock'] . "</td>";
                            echo "<td>" . $row['cost'] . "</td>";
                            // switch ($row['status']) {
                            //     case 0:
                            //         echo '<td><span class="badge bg-danger">Cancelado</span></td>';
                            //         break;
                            //     case 1:
                            //         echo '<td><span class="badge bg-success">Recibido</span></td>';
                            //         break;
                            //     case 2:
                            //         echo '<td><span class="badge bg-warning">Pendiente</span></td>';
                            //         break;
                            //     default:
                            //         # code...
                            //         break;
                            // }
                            // echo "<td>" . $row['state'] . "</td>";
                            echo '<td class="text-center"><div><a href="product_details.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a>';
                            echo "</tr>";
                        }
                    } else {
                        echo "No se encontraron clientes.";
                    }

                    // Cierra la conexión a la base de datos
                    $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>