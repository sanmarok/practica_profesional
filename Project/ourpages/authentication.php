<?php
session_start();
if (isset($_SESSION['id'])) {
  header('Location: dashboard.php');
  exit();
}
?>

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $employee_number = $_POST['employee_number'];
  $password = $_POST['password'];

  $sql = "SELECT id, first_name, last_name, role, employee_password FROM users WHERE employee_number = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('s', $employee_number);
  $stmt->execute();
  $stmt->bind_result($id, $first_name, $last_name, $role, $employee_password);

  if ($stmt->fetch() && password_verify($password, $employee_password)) {
    $_SESSION['id'] = $id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['role'] = $role;

    // Redirige al usuario a la página deseada
    echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas. Por favor, inténtalo de nuevo.']);
  }

  $stmt->close();
  exit; // Detener la ejecución del script PHP después de la respuesta AJAX
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>¡Bienvenido!</title>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!--Our styles-->
</head>

<body class="hold-transition login-page" style="background-color: #343a40;">
  <div class="login-box" style="background-color: #ffffff;">
    <div class="login-logo">
      <b>Infinet</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Comienza tu sesión</p>

        <div id="response"></div> <!-- Aquí mostraremos la respuesta del servidor -->

        <form id="loginForm" action="" method="post">
          <div class="input-group mb-3">
            <input class="form-control" placeholder="Numero de empleado" name="employee_number">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Contraseña" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center">
              <button type="button" id="loginButton" class="btn btn-success">Ingresar</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <script>
    $(document).ready(function() {
      // Manejo del evento de clic en el botón de inicio de sesión
      $("#loginButton").click(function() {
        // Realizar una solicitud AJAX para procesar el inicio de sesión
        $.ajax({
          type: "POST",
          url: "authentication.php",
          data: $("#loginForm").serialize(), // Envía los datos del formulario
          dataType: "json",
          success: function(response) {
            if (response.success) {
              // Redirige al usuario a la página deseada
              window.location.href = response.redirect;
            } else {
              // Muestra la ventana modal SweetAlert si hay un mensaje de error
              Swal.fire({
                icon: 'error',
                title: 'Inicio de sesión fallido',
                text: response.message,
              });
            }
          }
        });
      });
    });
  </script>
</body>

</html>