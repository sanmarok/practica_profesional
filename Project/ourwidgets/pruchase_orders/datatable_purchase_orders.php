<div class="col-12">
    <div class="card card-primary m-2">

        <div class="card-header">
            <h3 class="card-title">Pedidos de Compra</h3>
        </div>


        <!-- /.card-header -->
        <div class="card-body">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarPedido">
                <i class="nav-icon fas fa-plus"><span class="mx-1">Pedidos</span></i>

            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Creacion</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Creador</th>
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
                    $sql = "SELECT id, creation_date, description, status, user_id FROM purchase_orders";
                    $result = $mysqli->query($sql);
                    $sql = "SELECT first_name,last_name FROM users WHERE id = ?";
                    $stmt = $mysqli->prepare($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['creation_date'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            switch ($row['status']) {
                                case 0:
                                    echo '<td><span class="badge bg-danger">Cancelado</span></td>';
                                    break;
                                case 1:
                                    echo '<td><span class="badge bg-success">Recibido</span></td>';
                                    break;
                                case 2:
                                    echo '<td><span class="badge bg-warning">Pendiente</span></td>';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            $stmt->bind_param("i", $row['user_id']);
                            $stmt->execute();
                            $stmt->bind_result($first_name, $last_name);
                            $stmt->fetch();
                            echo "<td>" . $first_name . " " . $last_name . "</td>";
                            echo '<td class="text-center"><div><a href="orders_details.php?id=' . $row['id'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a>
                            <a href="../functions/pdf/pedido.php?id=' . $row['id'] . '" target="_blank" class="mx-2"><i class="fas fa-file-alt text-white"></i></a></td>';
                            echo "</tr>";
                        }
                    } else {
                    }
                    $stmt->close();
                    // Cierra la conexión a la base de datos
                    $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>