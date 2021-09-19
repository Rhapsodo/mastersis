<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bengala</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- Bootstrap 5.0 -->
  <link href="modules/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="modules/bootstrap/js/bootstrap.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <!-- Estilos propios -->
    <link type="text/css" rel="stylesheet" href="css/estilos_propios.css">

    <!-- JQuery 3.5.1 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>

    <!-- select2.js -->
    <link rel="stylesheet" href="modules/select2/select2.css">
    <link rel="stylesheet" href="modules/select2/select2-bootstrap4.css">
    <script src="modules/select2/select2.js"></script>

    <!-- alertify.js -->
    <link rel="stylesheet" href="modules/alertify/alertify.core.css">
    <link rel="stylesheet" href="modules/alertify/alertify.bootstrap.css">
    <script src="modules/alertify/alertify.js"></script>

  <link rel="icon" href="images/favicon.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini bg-light">
<div class="wrapper">

  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <a href="#" data-widget="fullscreen">
        <img src="bengala.svg" alt="AdminLTE Logo" class="brand-image elevation-3">
      </a>
      <span class="brand-text font-weight-light" data-widget="pushmenu" style="font-family: 'Lobster', cursive">Bengala</span>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="logo_empresa.jpg" class="elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- PRODUCTOS - INICIO -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag text-primary"></i>
              <p>
                Productos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="AbrirRegistroProductos()">
                  <i class="nav-icon fas fa-shopping-bag text-primary ml-3"></i>  
                  <p>Listado</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="AbrirRegistroIngresoProducto()">
                  <i class="nav-icon fas fa-shopping-bag text-primary ml-3"></i>  
                  <p>Ingresos</p>
                </a>
              </li>
              
            </ul>
          </li>
          <!-- PRODUCTOS - INICIO -->

          <!-- PERSONAS - INICIO -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users text-danger"></i>
              <p>
                Personas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="AbrirRegistroPersonas()">
                  <i class="nav-icon fas fa-users text-danger ml-3"></i>  
                  <p>Listado</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="AbrirRegistroIngresoPersonas()">
                  <i class="nav-icon fas fa-users text-danger ml-3"></i>  
                  <p>Ingresos</p>
                </a>
              </li>
              
            </ul>
          </li>
          <!-- PERSONAS - INICIO -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="contenido_sistema">
    <?php include('index2.php'); ?>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>

  function AbrirRegistroProductos()
  {
    $.ajax(
      {
        method: "POST",
        url : "productos.php",
        data:{
        }
      }
    )
    .done(function(html){
      $('#contenido_sistema').html(html);
    })
  }  

  function AbrirRegistroIngresoProducto()
  {
    $.ajax(
      {
        method: "POST",
        url : "productos_ingreso.php",
        data:{

        }
      }
    )
    .done(function(html){
      $('#contenido_sistema').html(html);
    })
  }
  
  function AbrirRegistroPersonas()
  {
    $.ajax(
      {
        method: "POST",
        url : "personas.php",
        data:{
        }
      }
    )
    .done(function(html){
      $('#contenido_sistema').html(html);
    })
  }  

  function AbrirRegistroIngresoPersonas()
  {
    $.ajax(
      {
        method: "POST",
        url : "productos_ingreso.php",
        data:{

        }
      }
    )
    .done(function(html){
      $('#contenido_sistema').html(html);
    })
  } 

  

</script>

</body>
</html>
