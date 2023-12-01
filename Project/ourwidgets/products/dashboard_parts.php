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