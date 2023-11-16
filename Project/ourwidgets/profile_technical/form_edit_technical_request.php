<?php
// Archivo de conexión a la base de datos
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

// Escapa la variable 'id' para prevenir inyecciones SQL
$technical_request_id = $mysqli->real_escape_string($_GET["id"]);

// Consulta SQL para obtener los datos de la solicitud técnica
$sql = "SELECT id, description, problem, status, date_created, type, client_service_id, technician_id FROM technical_requests WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $technical_request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Asigna los valores a las variables
    $description = $row['description'];
    $problem = $row['problem'];
    $status = $row['status'];
    $date_created = $row['date_created'];
    $type = $row['type'];
    $client_service_id = $row['client_service_id'];
    $technician_id = $row['technician_id'];

    // Prepara la consulta para obtener el nombre y apellido del técnico
    $tech_sql = "SELECT id, first_name, last_name FROM users WHERE id = ?";
    $tech_stmt = $mysqli->prepare($tech_sql);
    $tech_stmt->bind_param("i", $technician_id);
    $tech_stmt->execute();
    $tech_result = $tech_stmt->get_result();

    if ($tech_result->num_rows > 0) {
        $tech_row = $tech_result->fetch_assoc();
        // Concatena el nombre, apellido y ID del técnico
        $technician_info = $tech_row['first_name'] . ' ' . $tech_row['last_name'] . ' (' . $tech_row['id'] . ')';
    } else {
        $technician_info = "Tecnico no asignado";
    }
    $tech_stmt->close();
} else {
    echo "No se encontró la solicitud técnica.";
}

$techs_sql = "SELECT id, first_name, last_name FROM users WHERE role = 2";
$techs_stmt = $mysqli->prepare($techs_sql);
$techs_stmt->execute();
$techs_result = $techs_stmt->get_result();
$techs_stmt->close();

$stmt->close();
$mysqli->close();
?>


<!-- Aquí comienza el HTML para el formulario -->
<div class="card card-primary m-2">
    <div class="card-header">
        <h3 class="card-title">Editar Caso Tecnico</h3>
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
                        <!-- ID serv -->
                        <div class="form-group input-group">
                            <label for="inputIDservice">Servicio Contratado</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Ícono de vista que actúa como enlace al perfil del servicio del cliente -->
                                    <a href="profile_client_service.php?id=<?php echo $client_service_id; ?>">
                                        <i class="fas fa-eye text-success"></i>
                                    </a>
                                </div>
                                <?php 
                                 echo '<span>&nbsp&nbsp;Servicio contratado ' . $row['client_service_id'] . '</span>';
                                 ?>

                                
                                <span class="input-group-append">


                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- Problema -->
                        <div class="form-group input-group">
                            <label for="inputProblem">Problema</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-border" id="inputProblem" value="<?php echo $problem; ?>" disabled>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editProblem"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <!-- Tecnico encargado -->
                        <div class="form-group input-group">
                            <label for="inputTech">Técnico encargado</label>
                            <div class="input-group">
                                <select class="custom-select form-control-border" id="inputTech" name="technician_id" disabled>
                                    <option value="">Sin tecnico asignado</option>
                                    <?php while ($tech = $techs_result->fetch_assoc()) : ?>
                                        <option value="<?php echo $tech['id']; ?>" <?php echo $tech['id'] == $technician_id ? 'selected' : ''; ?>>
                                            <?php echo $tech['first_name'] . ' ' . $tech['last_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <span class="input-group-append">
                                    <button class="btn btn-outline-danger mx-2" type="button" id="editTech"><i class="fas fa-pencil-alt"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <!-- ID serv -->
                        <div class="form-group input-group">
                            <label for="inputIDservice">Fecha iniciada</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Ícono de vista que actúa como enlace al perfil del servicio del cliente -->
                                    <a href="profile_client_service.php?id=<?php echo $date_created; ?>">
                                    
                                    </a>
                                </div>
                                <?php 
                                 echo '<span>&nbsp&nbsp; ' . $row['date_created'] . '</span>';
                                 ?>

                                
                                <span class="input-group-append">


                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Tipo de caso -->
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputCaseType">Tipo de Caso</label>
                            </div>
                            <select class="custom-select form-control-border" id="inputCaseType" disabled>
                                <option value="2" <?php echo $type == 2 ? 'selected' : ''; ?>>Infraestructura</option>
                                <option value="1" <?php echo $type == 1 ? 'selected' : ''; ?>>Mantenimiento</option>
                                <option value="0" <?php echo $type == 0 ? 'selected' : ''; ?>>Instalacion</option>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editCaseType"><i class="fas fa-pencil-alt"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Estado Tecnico -->
                        <div class="form-group input-group">
                            <div class="input-group">
                                <label for="inputTechStatus">Estado Tecnico</label>
                            </div>
                            <select class="custom-select form-control-border" id="inputTechStatus" disabled>
                                <option value="4" <?php echo $status == 4 ? 'selected' : ''; ?>>En proceso</option>
                                <option value="3" <?php echo $status == 3 ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="2" <?php echo $status == 2 ? 'selected' : ''; ?>>Asignada</option>
                                <option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Completada</option>
                                <option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-outline-danger mx-2" type="button" id="editTechStatus"><i class="fas fa-pencil-alt"></i></button>
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


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cliente</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    <style>
        /* Regla de estilo personalizada para el mensaje de error */
        .swal2-popup .swal2-title {
            color: white;
            /* Cambia el color del texto a blanco */
        }

        .swal2-html-container {
            color: white;
        }
    </style>