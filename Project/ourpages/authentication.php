<?php
session_start();
if (isset($_SESSION['id'])) {
  header('Location: dashboard.php');
  exit();
}
?>

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
  <link rel="icon" href="../logoicon.png" type="image/x-icon">
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

  <style>
    .fade-from-bottom {
      animation: fadeFromBottom 1.5s ease-out;
    }

    @keyframes fadeFromBottom {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body class="hold-transition login-page bg-black">


  <div class="container h-100">
    <div class="text-center">
      <img src="../logo.gif" class="img-fluid" style="max-height: 400px;">
    </div>
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body px-5 text-center">
            <div class="mb-md-5 mt-md-4 pb-0">
              <h2 class="fw-bold mb-2 text-uppercase">Ingresar</h2>
              <p class="text-white-50 mb-5">Por favor ingrese numero de empleado y contraseña</p>
              <form id="loginForm" action="" method="post">
                <div class="form-outline form-white mb-4 text-left">
                  <label class="form-label " for="employeeNumber">Numero de empleado</label>
                  <input type="text" id="employeeNumber" class="form-control form-control-lg" placeholder="Numero de empleado" name="employee_number" required>
                </div>
                <div class="form-outline form-white mb-4 text-left">
                  <label class="form-label" for="password">Contraseña</label>
                  <input type="password" id="password" class="form-control form-control-lg" placeholder="Contraseña" name="password" required>
                </div>
                <div id="response"></div>
                <button type="button" id="loginButton" class="btn btn-outline-light btn-lg px-5">Iniciar sesion</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


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