<div class="col-12">
    <div class="card card-primary m-2">

        <div class="card-header">
            <h3 class="card-title">Usuarios</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarUsuario">
                <i class="nav-icon fas fa-plus"><span class="mx-1">Usuario</span></i>
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numero de empleado</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Archivo de conexión a la base de datos (ajusta la configuración según tu entorno)
                    // $db_host = 'localhost';
                    // $db_user = 'root';
                    // $db_pass = '';
                    // $db_name = 'infinet';

                    $db_host = 'localhost';
                    $db_user = 'dbadmin';
                    $db_pass = '.admindb';
                    $db_name = 'infinet';

                    // Establece una conexión a la base de datos
                    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

                    // Verifica si la conexión se realizó correctamente
                    if ($mysqli->connect_error) {
                        die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
                    }

                    // Consulta SQL para obtener los datos de los clientes
                    $sql = "SELECT * FROM `users`";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['employee_number'] . "</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['last_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";

                            switch ($row['role']) {
                                case 1:
                                    echo '<td>Administrador</td>';
                                    break;
                                case 2:
                                    echo '<td>Tecnico</td>';
                                    break;
                                case 3:
                                    echo '<td>Secretario</td>';
                                default:
                                    # code...
                                    break;
                            }
                            echo '<td class="text-center ">';
                            echo '<button type="button" class="btn btn-info btn-editar-usuario mr-2" data-toggle="modal" data-target="#modalEditarUsuario" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></button>';

                            echo '<button type="button" class="btn btn-warning btn-recuperar-contraseña mr-2" data-toggle="modal" data-target="#modalRecuperarContraseña" data-id="' . $row['id'] . '"><i class="fas fa-key"></i></button>';
                            echo ' <button type="button" class="btn btn-danger btn-borrar-usuario mr-2" data-id="' . $row['id'] . '" onclick="confirmarBorrado(' . $row['id'] . ')">
                            <i class="fas fa-trash-alt"></i>';
                            echo '</td>';
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

<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega el formulario de edición aquí -->
                <form id="agregarForm" autocomplete="off">
                    <!-- Campo oculto para el usuario_id si es necesario -->
                    <!-- <input type="hidden" name="usuario_id" value="' . $row['id'] . '"> -->

                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select class="custom-select rounded-0 my-1" id="rol" name="rol" required>
                            <option value="1">Administrador</option>
                            <option value="2">Técnico</option>
                            <option value="3">Secretario</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required autocomplete="false">
                    </div>

                    <div class="form-group">
                        <label for="contraseña">Repetir contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required autocomplete="false">
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="mostrarAlertaFallo()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega el formulario de edición aquí -->
                <form id="agregarForm" autocomplete="off">
                    <!-- Campo oculto para el usuario_id si es necesario -->
                    <!-- <input type="hidden" name="usuario_id" value="' . $row['id'] . '"> -->

                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select class="custom-select rounded-0 my-1" id="rol" name="rol" required>
                            <option value="1">Administrador</option>
                            <option value="2">Técnico</option>
                            <option value="3">Secretario</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="mostrarAlertaFallo()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalRecuperarContraseña" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Restaurar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega el formulario de edición aquí -->
                <form id="agregarForm" autocomplete="off">
                    <!-- Campo oculto para el usuario_id si es necesario -->
                    <!-- <input type="hidden" name="usuario_id" value="' . $row['id'] . '"> -->

                    <div class="form-group">
                        <label for="contraseña">Nueva contraseña:</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required autocomplete="false">
                    </div>

                    <div class="form-group">
                        <label for="contraseña">Repetir contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" required autocomplete="false">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" onclick="mostrarAlertaFallo()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- SweetAlert para registro exitoso -->
<script>
    function mostrarAlertaExito() {
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'El nuevo usuario se ha registrado correctamente.',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Aceptar'
        });
    }
</script>

<!-- SweetAlert para fallo en el registro -->
<script>
    function mostrarAlertaFallo() {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema al registrar el nuevo usuario. Inténtalo de nuevo.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Aceptar'
        });
    }
</script>

<script>
    function confirmarBorrado(usuarioId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí puedes llamar a la función que realiza el borrado
                borrarUsuario(usuarioId);
            }
        });
    }

    // Ejemplo de función para borrar el usuario (debes ajustar esto según tu implementación)
    function borrarUsuario(usuarioId) {
        // Realiza la lógica de borrado aquí, puedes usar AJAX para hacer la solicitud al servidor
        // Puedes mostrar otro SweetAlert para indicar si el borrado fue exitoso o no
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El usuario no se ha podido borrar.',
            confirmButtonColor: 'error',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#dc3545',
        });
    }
</script>