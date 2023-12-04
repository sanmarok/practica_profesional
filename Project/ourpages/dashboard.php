<?php
session_start();
if (isset($_SESSION['id'])) {
} else {
  header('Location: authentication.php');
  exit();
}
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'infinet';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar conexión
if ($conn->connect_error) {
  die("La conexión ha fallado: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS pending_cases FROM technical_requests WHERE status != 1 && status != 0";
$result = $conn->query($sql);


$pendingCases = 0;

// Si la consulta devuelve resultados, asignar el valor a la variable
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $pendingCases = $row['pending_cases'];
}

// CONSULTA DE DIRECCIONES-----------------------------------------------------------------------------
$sql = "SELECT client_services.address 
        FROM technical_requests 
        INNER JOIN client_services ON technical_requests.client_service_id = client_services.id 
        WHERE technical_requests.status NOT IN (0, 1)";
$result = $conn->query($sql);
$addresses = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    array_push($addresses, $row['address']);
  }
}
// Función para obtener coordenadas de una dirección       api key AIzaSyAps2nlKyq2lFnqMw1zawiNkKBxfHxxTaI
function getCoordinates($address)
{
  $address = urlencode($address);
  $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAps2nlKyq2lFnqMw1zawiNkKBxfHxxTaI";     #Aca se usa la api de geocode que funciona pero deniega todo si la api key no esta paga.

  $resp_json = file_get_contents($url);
  $resp = json_decode($resp_json, true);

  if ($resp['status'] == 'OK') {
    $lat = $resp['results'][0]['geometry']['location']['lat'];
    $lng = $resp['results'][0]['geometry']['location']['lng'];
    return array("lat" => $lat, "lng" => $lng);
  } else {
    // Imprimir error para depuración
    echo "Error en la respuesta de la API para la dirección: $address. Estado: " . $resp['status'] . "\n";
    echo '<pre>';
    return false;
  }
}


// Obtener coordenadas para cada dirección
$locations = [];
foreach ($addresses as $address) {
  // Añadir la ciudad y el país a la dirección
  $fullAddress = $address . ', Argentina';
  $coords = getCoordinates($fullAddress);
  if ($coords) {
    array_push($locations, $coords);
  }
}

// testeo de Imprimir el array para depuración borrar despues
//echo '<pre>';
//echo 'MATENME';
//print_r($locations);
//echo '</pre>';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
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
    #mapMessage {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: black;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      z-index: 100;
      /* Agrega aquí más estilos si lo necesitas */
    }

    .flot-text {
      color: white !important;
    }
  </style>
</head>

<body class="layout-navbar-fixed control-sidebar-slide-open dark-mode">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light bg-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="dashboard.php" class="nav-link text-white">Inicio</a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="dashboard.php" class="brand-link elevation-4">
        <span class="brand-text font-weight-light mx-auto">Infinet</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <span class="d-block m-2">
              <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?>
            </span>

            <?php
            switch ($_SESSION['role']) {
              case 1:
                echo '<i class="nav-icon fas fa-user-tie m-2"></i><span class="px-1">Adminstrador<span>';
                break;
              case 2:
                echo '<i class="nav-icon fas fa-user-doctor m-2"></i><span class= px-1>Tecnico<span>';
                break;
              case 3:
                echo '<i class="nav-icon fas fa-user m-2"></i><span class= px-1>Secretario<span>';
                break;
              default:
                # code...
                break;
            }
            ?>

            <div class="mt-3"> <!-- Este div envuelve el botón de cierre de sesión -->
              <a href="../functions/logout.php" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i><span class="text-white m-2">Cerrar Sesión</span>
              </a>
            </div>
          </div>
        </div>




        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php
            if ($_SESSION['role'] != 2) {
              echo '            <li class="nav-item">
              <a href="clients.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Clientes
                </p>
              </a>
            </li>';
            }
            ?>


            <?php
            if ($_SESSION['role'] != 2) {
              echo '           <li class="nav-item">
              <a href="services.php" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Servicios
                </p>
              </a>
            </li>';
            }
            ?>


            <li class="nav-item">
              <a href="technical_requests.php" class="nav-link">
                <i class="nav-icon fas fa-tools"></i>
                <p>
                  Solicitudes Técnicas
                </p>
              </a>
            </li>


            <?php
            if ($_SESSION['role'] == 1) {
              echo '
              <li class="nav-item">
                <a href="purchase_orders.php" class="nav-link">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Pedidos de Compra
                  </p>
                </a>
              </li>';
            }
            ?>


            <?php
            if ($_SESSION['role'] == 1) {
              echo '
              <li class="nav-item">
                <a href="products.php" class="nav-link">
                  <i class="nav-icon fas fa-box-open"></i>
                  <p>
                    Productos
                  </p>
                </a>
              </li>';
            }
            ?>



            <?php
            if ($_SESSION['role'] == 1) {
              echo '
              <li class="nav-item">
                <a href="users.php" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Usuarios
                  </p>
                </a>
              </li>';
            }
            ?>

            <?php
            if ($_SESSION['role'] == 1) {
              echo '
              <li class="nav-item">
                <a href="invoices.php" class="nav-link">
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Facturacion
                  </p>
                </a>
              </li>';
            }
            ?>


          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Google Maps Card -->
        <div class="container-fluid">
          <div class="card card-primary m-2">
            <div class="card-header">
              <h3 class="card-title">Casos técnicos en curso</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="map" style="height: 600px; width: 100%;"></div>
            </div>
          </div>
        </div>

        <!-- Casos Técnicos y Avisos -->
        <div class="container-fluid">
          <div class="row">
            <!-- Small Box (Casos Técnicos) -->
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow"  style="margin-left: 10px;">
                <div class="inner" style="color: white;">
                  <h3><?php echo $pendingCases; ?></h3>
                  <p>Casos técnicos pendientes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="technical_requests.php" class="small-box-footer" style="color: white;">
                  Más información <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <!-- Avisos -->
            <div class="col-lg-9 col-xs-6">
              <div class="box-body" style="margin-bottom: 15px; margin-right: 10px;">
                <div class="alert alert-warning alert-dismissible" style="color: white;">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h6><i class="icon fa fa-warning"></i> Aviso!</h6>
                  OLT_4 está teniendo fallas para establecer conexión, revisar nodo.
                </div>
              </div>
              <div class="box-body" style="margin-bottom: 15px; margin-right: 10px;">
                <div class="alert alert-info alert-dismissible" style="color: white;">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h6><i class="icon fa fa-warning"></i> Aviso!</h6>
                  Tormentas pronosticadas para el fin de semana, que cualquier técnico se asigne la guardia para esas fechas y avise a administración.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Interactive Chart Card -->
        <div class="container-fluid">
          <div class="card card-primary m-2">
            <div class="card-header">
              <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                Consumo MBs Promedio
              </h3>
              <div class="card-tools">
                Real time
                <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-sm active" data-toggle="on">On</button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="off">Off</button>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="interactive" style="height: 250px;"></div>
            </div>
          </div>
        </div>

      </section>
    </div>

    <!-- /.content -->
  </div>


  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- DataTables & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
    // Usar el array $locations en JavaScript
    var locations = <?php echo json_encode($locations); ?>;


    function initMap() {
      var mapOptions = {
        center: new google.maps.LatLng(-30.68411047911765, -60.24989621990217),
        zoom: 7
      };
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      // Agregar marcadores al mapa
      addMarkers(map);
    }

    function addMarkers(map) {
      for (var i = 0; i < locations.length; i++) {
        var location = locations[i];
        var marker = new google.maps.Marker({
          position: {
            lat: location.lat,
            lng: location.lng
          },
          map: map,
          title: location.title
        });
      }
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAps2nlKyq2lFnqMw1zawiNkKBxfHxxTaI&callback=initMap">
  </script>
  <!-- FLOT CHARTS -->
  <script src="../plugins/flot/jquery.flot.js"></script>
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <script src="../plugins/flot/plugins/jquery.flot.resize.js"></script>
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <script src="../plugins/flot/plugins/jquery.flot.pie.js"></script>

  <!-- Page specific script -->
  <script>
    $(function() {
      /*
       * Flot Interactive Chart
       * -----------------------
       */
      // We use an inline data source in the example, usually data would
      // be fetched from a server
      var data = [],
        totalPoints = 100 //largo

      function getRandomData() {

        if (data.length > 0) {
          data = data.slice(1)
        }

        // Do a random walk
        while (data.length < totalPoints) {

          var prev = data.length > 0 ? data[data.length - 1] : 50,
            y = prev + Math.random() * 10 - 5


          if (y < 0) {
            y = 0
          } else if (y > 100) {
            y = 100
          }

          data.push(y)
        }

        // Zip the generated y values with the x values
        var res = []
        for (var i = 0; i < data.length; ++i) {
          res.push([i, data[i]])
        }

        return res
      }

      var interactive_plot = $.plot('#interactive', [{
        data: getRandomData(),
      }], {
        grid: {
          borderColor: '#FFFFFF',
          borderWidth: 1,
          tickColor: '#FFFFFF'
        },
        series: {
          color: '#3c8dbc',
          lines: {
            lineWidth: 2,
            show: true,
            fill: true,
          },
        },
        yaxis: {
          min: 0,
          max: 100,
          show: true,
          color: 'white',
          tickColor: 'white'
        },
        xaxis: {
          show: true,
          color: 'white',
          tickColor: 'white'
        }
      })

      var updateInterval = 500 //Fetch data ever x milliseconds
      var realtime = 'on' //If == to on then fetch data every x seconds. else stop fetching
      function update() {

        interactive_plot.setData([getRandomData()])

        // Since the axes don't change, we don't need to call plot.setupGrid()
        interactive_plot.draw()
        if (realtime === 'on') {
          setTimeout(update, updateInterval)
        }
      }

      //INITIALIZE REALTIME DATA FETCHING
      if (realtime === 'on') {
        update()
      }
      //REALTIME TOGGLE
      $('#realtime .btn').click(function() {
        if ($(this).data('toggle') === 'on') {
          realtime = 'on'
        } else {
          realtime = 'off'
        }
        update()
      })
    })

    /*
     * Custom Label formatter
     * ----------------------
     */
    function labelFormatter(label, series) {
      return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
        label +
        '<br>' +
        Math.round(series.percent) + '%</div>'
    }
  </script>

</body>

</html>