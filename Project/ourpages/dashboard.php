<?php
session_start();
if (isset($_SESSION['id'])) {
} else {
  header('Location: authentication.php');
  exit();
}
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            z-index: 100;
            /* Agrega aquí más estilos si lo necesitas */
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
                echo '<i class="nav-icon fas fa-users-gears m-2"></i><span class= px-1>Tecnico<span>';
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


          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
      <h6>

        <small>Infinet ABMC 1.0</small>
      </h6>
      <!-- Main content -->
     <!-- Main content -->
      <section class="content ">
          <div class="container-fluid ">
            <!-- Aquí puedes agregar otros elementos de tu página -->
            
            <!-- Google Maps -->
            <div id="map" style="height: 600px; width: 100%; margin-bottom: 20px;" ></div>
            <div id="mapMessage" style="position: absolute; top: 50px; left: 300px; background-color: gray; padding: 10px; z-index: 100;">
                Casos tecnicos en curso
            </div>
          
          
            <div class="row"> <!-- Asegúrate de que todo esté dentro de un 'row' -->
              <div class="col-lg-3 col-xs-6" >
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>13</h3>
                    <p>Casos técnicos pendientes</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="technical_requests.php" class="small-box-footer">
                    Más información <i class="fa fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>

              <div class="col-lg-9 col-xs-6" style="margin-bottom: 15px;"> <!-- Ajusta las clases de columna según sea necesario -->
                <div class="box-body">
                  <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h6><i class="icon fa fa-warning"></i> Aviso!</h6>
                    OLT_4 está teniendo fallas para establecer conexión, revisar nodo.
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <!-- interactive chart -->
                <div class="card card-primary card-outline">
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
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="interactive" style="height: 250px;"></div>
                  </div>
                  <!-- /.card-body-->
                </div>
                <!-- /.card -->

              </div>
              <!-- /.col -->
            </div>
              
        </section>
        
        <!-- /.content -->
      </div>
      <!-- /.content -->
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  </div>
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
     var locations = [
        {lat: -31.864485040401153, lng: -59.03540832644696, title: 'Caso tecnico ID:1'},
        {lat: -31.8630, lng: -59.0340, title: 'Caso tecnico 2'},
        {lat: -31.860838182862558, lng: -59.02205113981479, title: 'Caso tecnico ID:3'},
        {lat: -31.86445962922279, lng: -59.022029470956426, title: 'Caso tecnico ID:4'},
        {lat: -31.85673641320513, lng: -59.04061658164112, title: 'Caso tecnico ID:5'},
        {lat: -31.87263050687988, lng: -59.031650311190575, title: 'Caso tecnico ID:6'},
        {lat: -31.87254520641514, lng: -59.02838454970633, title: 'Caso tecnico ID:7'},
        {lat: -31.87354786157071, lng: -59.02521923632184, title: 'Caso tecnico ID:8'},
        {lat: -31.85594730072456, lng: -59.01964396816157, title: 'Caso tecnico ID:9'},
        {lat: -31.855371350474172, lng: -59.03149900268485, title: 'Caso tecnico ID:10'},
        {lat: -31.85490230910371, lng: -59.0375, title: 'Caso tecnico ID:11'},
        {lat: -31.861031635997502, lng: -59.02942522096242, title: 'Caso tecnico ID:12'},
        {lat: -31.862508531731677, lng: -59.032180756946346, title: 'Caso tecnico ID:13'}

        // ... más ubicaciones
    ];
    
    function initMap() {
      var mapOptions = {
        center: new google.maps.LatLng(-31.85999961300427, -59.031932381073965),
        zoom: 14
      };
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      // Agregar marcadores al mapa
      addMarkers(map);
    }
    function addMarkers(map) {
        for (var i = 0; i < locations.length; i++) {
            var location = locations[i];
            var marker = new google.maps.Marker({
                position: {lat: location.lat, lng: location.lng},
                map: map,
                title: location.title
            });
        }
    }

  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAps2nlKyq2lFnqMw1zawiNkKBxfHxxTaI&callback=initMap">
  </script>
  <!-- FLOT CHARTS -->
  <script src="../plugins/flot/jquery.flot.js"></script>
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <script src="../plugins/flot/plugins/jquery.flot.resize.js"></script>
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <script src="../plugins/flot/plugins/jquery.flot.pie.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function () {
      /*
      * Flot Interactive Chart
      * -----------------------
      */
      // We use an inline data source in the example, usually data would
      // be fetched from a server
      var data        = [],
          totalPoints = 100   //largo

      function getRandomData() {

        if (data.length > 0) {
          data = data.slice(1)
        }

        // Do a random walk
        while (data.length < totalPoints) {

          var prev = data.length > 0 ? data[data.length - 1] : 50,
              y    = prev + Math.random() * 10 - 5

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

      var interactive_plot = $.plot('#interactive', [
          {
            data: getRandomData(),
          }
        ],
        {
          grid: {
            borderColor: '#f3f3f3',
            borderWidth: 1,
            tickColor: '#f3f3f3'
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
            max: 5,
            show: true
          },
          xaxis: {
            show: true
          }
        }
      )

      var updateInterval = 500 //Fetch data ever x milliseconds
      var realtime       = 'on' //If == to on then fetch data every x seconds. else stop fetching
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
      $('#realtime .btn').click(function () {
        if ($(this).data('toggle') === 'on') {
          realtime = 'on'
        }
        else {
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
      return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + '<br>'
        + Math.round(series.percent) + '%</div>'
    }
  </script>
  
</body>

</html>