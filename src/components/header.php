




<!DOCTYPE html>
<html>



<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FARMACIA | MUNHIFE</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- jQuery 3 -->
   <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>

<script src="assets/bower_components/sweetalert/sweetalert.js"></script>
 <!-- DataTables -->
<script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="assets/chart.js/Chart.min.js"></script>

<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">  
<!-- Select2 -->
<link rel="stylesheet" href="assets/bower_components/select2/dist/css/select2.min.css">
                                                
 <!-- Select2 -->
 <script src="assets/bower_components/select2/dist/js/select2.full.min.js"></script>  

<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="assets/dist/css/skins/skin-blue.min.css">
  
<!-- Google Font -->
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- DataTables -->
<link rel="stylesheet" href="assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        
    <!-- daterange picker -->
<link rel="stylesheet" href="assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
<link rel="stylesheet" href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">   
       
            
<script src="assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->     
       
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="assets/plugins/iCheck/all.css">  
 <!-- iCheck 1.0.1 -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>                         

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>OS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>FARMACIA</b>-MUNHIFE</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
                    <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <!-- <img src="assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <img src="assets/dist/img/linder.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"> <?php echo $_SESSION['username'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <!-- <li class="user-header">
                <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['useremail'];?>
                  <small>Member since Jun. 2025</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">

                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="changepassword.php" class="btn btn-default btn-flat">Change password</a>
                </div>
                <div class="pull-right">
                <div class="pull-right">
                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>

                </div>

                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
 
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="assets/dist/img/linder.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>BEM VINDO-<?php echo $_SESSION['username'];?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->


      <ul class="sidebar-menu" data-widget="tree">
    <!-- Menu Inicial -->
    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Pagina Inicial</span></a></li>

    <!-- Menu Venda - Visível apenas para 'Caixa' -->
    <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Caixa'): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Venda</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="orderCreate.php"><i class="fa fa-cart-plus"></i> <span>Efectuar venda</span></a></li>
            <li><a href="orderList.php"><i class="fa fa-list-ul"></i> <span>Lista de Vendas</span></a></li>
        </ul>
    </li>
    <?php endif; ?>

    <!-- Menu Produto - Visível apenas para 'Admin' ou 'Caixa' -->
    <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Caixa'): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-cogs"></i> <span>Produto</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

        <li><a href="productList.php"><i class="fa fa-th-list"></i> <span>Lista de Produto</span></a></li>
        
            
                    <li><a href="productCreate.php">
                      <i class="fa fa-plus-circle"></i> 
                      <span>Adicionar produto</span></a>
                    </li>
            <li><a href="categoryList.php"><i class="fa fa-tag"></i> <span>Categoria</span></a></li>
            <?php if ($_SESSION['role'] === 'Admin'): ?>
            <li><a href="stockEntradaProduto.php"><i class="fa fa-arrow-circle-right"></i> <span>Entrada Produto</span></a></li>
            <?php endif; ?>
        </ul>
    </li>
    <?php endif; ?>

    <!-- Menu Cliente - Visível apenas para 'Admin' -->
    <?php if ($_SESSION['role'] === 'Admin' || ($_SESSION['role']==='Caixa')): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>Cliente</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="clientCreate.php"><i class="fa fa-user-plus"></i> <span>Adicionar cliente</span></a></li>
            <li><a href="clientList.php"><i class="fa fa-list-alt"></i> <span>Lista de Cliente</span></a></li>
        </ul>
    </li>
    <?php endif; ?>

    <!-- Outros menus -->
    <?php if ($_SESSION['role'] === 'Admin' || ($_SESSION['role']==='Caixa')): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text"></i> <span>Cotação</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="cotacaoCreate.php"><i class="fa fa-file-o"></i> <span>Criar</span></a></li>
            <li><a href="cotacaoList.php"><i class="fa fa-list"></i> <span>Listar</span></a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-exclamation-triangle"></i> <span>Dividas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="debtList.php"><i class="fa fa-money"></i> <span>Listar</span></a></li>
        </ul>
    </li>
    <?php endif; ?>


    <?php if ($_SESSION['role'] === 'Admin'): ?>
      <li class="treeview">
        <a href="#">
            <i class="fa fa-archive"></i> <span>Stock</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="stockEntrada.php"><i class="fa fa-arrow-circle-up"></i> <span>Entrada Stock</span></a></li>
            <li><a href="stockListEntrada.php?action=entrada"><i class="fa fa-list-alt"></i> <span>Lista entradas</span></a></li>
            <li><a href="stockListSaida.php?action=saida"><i class="fa fa-list-alt"></i> <span>Lista saidas</span></a></li>
        </ul>
    </li>
    <?php endif; ?>

    
    <!-- Menu Relatórios - Visível apenas para 'Admin' -->
    <?php if ($_SESSION['role'] === 'Admin'): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i> <span>Relatórios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="tableReport.php"><i class="fa fa-line-chart"></i> <span>Relatório de Venda</span></a></li>
            <li><a href="tableReportStock.php"><i class="fa fa-bar-chart"></i> <span>Stock</span></a></li>
        </ul>
    </li>
    <?php endif; ?>

    <!-- Menu Usuários - Visível apenas para 'Admin' -->
    <?php if ($_SESSION['role'] === 'Admin'): ?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>Usuarios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="userCreate.php"><i class="fa fa-user-plus"></i> <span>Adicionar usuario</span></a></li>
            <li><a href="userList.php"><i class="fa fa-list-alt"></i> <span>Lista de usuarios</span></a></li>
        </ul>
    </li>
    <?php endif; ?>

</ul>




      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

<body>
