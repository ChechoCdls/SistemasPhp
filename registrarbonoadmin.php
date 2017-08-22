<?php
session_start();

if(!isset($_SESSION['user_session'])) //si no inicia sesion
{
header("Location: index.php");
}else{

  include_once 'dbconfig.php';

  $stmt = $db_con->prepare("SELECT * FROM usuario WHERE id_usuario=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['user_session']));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);

  if ($row['permiso']=="normal"){ //SI EL PERMISO ES NORMAL ENVIARLO AL MENU MONITOR PORQUE YA INICIó SESION
            header("Location: menuser.php");
  }else if($row['permiso']=="super"){
            header("Location: menusuperadmin.php");
  }
}

$sql = "SELECT * FROM actividad";
$result = $db_con->query($sql) or die(mysql_error());
$arreglo_actividad = $result->fetchAll();

$sql2 = "SELECT * FROM empleado WHERE estado_empleado = '1'";
$result2 = $db_con->query($sql2) or die(mysql_error());
$arreglo_empleado = $result2->fetchAll();

$sql3 = "SELECT * FROM producto";
$result3 = $db_con->query($sql3) or die(mysql_error());
$arreglo_producto = $result3->fetchAll();



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comercial Del Mar | Bonos </title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">

  <!-- bootstrap-daterangepicker -->
  <link href="css/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="clearfix"></div>

          <br>

          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="images/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenid@,</span>
              <h2> <?php echo $row['nombre_usuario']; ?> </h2>
              <br>
              <br>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">

                <li><a href="menuadmin.php"><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
                </li>

                <li><a><i class="fa fa-users"></i> Empleados <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrarempleadoadmin.php">Registrar Empleado</a>
                    </li>
                    <li><a href="verempleadosadmin.php">Visualizar Empleados</a>
                    </li>
                    <li><a href="empleadomodadmin.php">Modificar Empleado</a>
                    </li>
                  </ul>
                </li>
                
                <li><a><i class="fa fa-tags"></i> Productos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrarproductoadmin.php">Registrar Producto</a>
                    </li>
                    <li><a href="verproductosadmin.php">Visualizar Productos</a>
                    </li>
                    <li><a href="modificarproductoadmin.php">Modificar Producto</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-tasks"></i> Actividades <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registraractividadadmin.php">Registrar Actividad</a>
                    </li>
                    <li><a href="asignaractividadadmin.php">Asignar Actividad</a>
                    </li>
                    <li><a href="veractividadesadmin.php">Visualizar Actividad</a>
                    </li>
                  </ul>
                </li>

                <li><a><i class="fa fa-book"></i> Tratos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrartratoadmin.php">Registrar Trato</a>
                    </li>
                    <li><a href="vertratosadmin.php">Visualizar Tratos</a>
                    </li>
                    <li><a href="buscartratosadmin.php">Buscar Tratos</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-calendar-check-o"></i> Asistencia <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="consultarempleadoadmin.php">Registrar Asitencia</a>
                    </li>
                    <li><a href="verasistenciaadmin.php">Visualizar Asistencias</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-credit-card-alt"></i> Liquidación <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="consultarempleadoadmin2.php">Generar Liquidación</a>
                    </li>
                    <li><a href="registrarbonoadmin.php">Registrar Bonos</a>
                    </li>
                    <li><a href="buscarliquidacionadmin.php">Buscar Liquidaciones</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <h3>Administración</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-user-plus"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registraruseradmin.php">Nuevo Usuario</a>
                    </li>
                    <li><a href="verusuariosadmin.php">Ver Usuarios</a>
                    </li>
                  </ul>
                </li>

                <li><a><i class="fa fa-credit-card"></i> Compras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrarcompraadmin.php">Registrar Compra</a>
                    </li>
                    <li><a href="vercompraadmin.php">Visualizar Compras</a>
                    </li>
                  </ul>
                </li>

                <li><a><i class="fa fa-usd"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="verventasadmin.php">Ver Ventas</a>
                    </li>
                  </ul>
                </li>
                
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

       <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/user.png" alt=""><?php echo $row['nombre_usuario']; ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="perfiladmin.php"><i class="fa fa-user pull-right"></i>   Perfil</a>
                  </li>
                  <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>


            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>
                    Registrar Bonos
                </h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Bonos</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <form class="form-horizontal form-label-left" id="register-form" role="form" method="POST" novalidate>
                  
                  <div id="error">
                    <!-- error will be showen here ! -->
                  </div>

                  </br>
                    
                    <span class="section">Período</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Período <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="mes" id="mes" >
                          <option value="01">Enero</option>       
                          <option value="02">Febrero</option>       
                          <option value="03">Marzo</option>       
                          <option value="04">Abril</option>
                          <option value="05">Mayo</option>
                          <option value="06">Junio</option>
                          <option value="07" selected="true">Julio</option>
                          <option value="08">Agosto</option>
                          <option value="09">Septiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="ano" id="ano" >
                          <option value="2015">2015</option>       
                          <option value="2016">2016</option>       
                          <option value="2017" selected="true">2017</option>       
                          <option value="2018">2018</option>
                        </select>
                      </div>
                    </div>

                    <span class="section">Empleado</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Empleado <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="empleado" id="empleado" >
                        <option  selected="true" disabled="disabled">Seleccione Empleado</option>
                        <?php foreach ($arreglo_empleado as $empleado) { ?>
                          <option value="<?php echo $empleado['id_empleado'] ?>"><?php echo $empleado['nombre_empleado']. ' ' .$empleado['apellido_empleado'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    </br>

                    <div class="col-xs-6">

                    <span class="section">Bonos</span>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bono Producción <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bproduccion" class="form-control col-md-7 col-xs-12" name="bproduccion" placeholder="Bono Producción" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bono Responsabilidad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bresponsabilidad" class="form-control col-md-7 col-xs-12" name="bresponsabilidad" placeholder="Bono Responsabilidad" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Colación <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bcolacion" class="form-control col-md-7 col-xs-12" name="bcolacion" placeholder="Bono Colación" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Movilización <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bmovilizacion" class="form-control col-md-7 col-xs-12" name="bmovilizacion" placeholder="Bono Movilización" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Aguinaldo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="aguinaldo" class="form-control col-md-7 col-xs-12" name="aguinaldo" placeholder="Aguinaldos" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Comisión por Ventas <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="comisionventas" class="form-control col-md-7 col-xs-12" name="comisionventas" placeholder="Comisión por Ventas" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Asignación Hotelera <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="asighotelera" class="form-control col-md-7 col-xs-12" name="asighotelera" placeholder="Asignación Hotelera" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>


                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sala Cuna <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bsalacuna" class="form-control col-md-7 col-xs-12" name="bsalacuna" placeholder="Bono Sala CUna" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    </br>

                    <span class="section">Anticipos</span>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Anticipos Sueldo  <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="anticiposueldo" class="form-control col-md-7 col-xs-12" name="anticiposueldo" placeholder="Anticipo" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Anticipos Sueldo (2) <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="segundoanticiposueldo" class="form-control col-md-7 col-xs-12" name="segundoanticiposueldo" placeholder="Anticipo" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Anticipos Aguinaldo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="anticipoaguinaldo" class="form-control col-md-7 col-xs-12" name="anticipoaguinaldo" placeholder="Anticipo" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    
                    </br>
                    <span class="section">Préstamos</span>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Prestamo Personal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="prestamopersonal" class="form-control col-md-7 col-xs-12" name="prestamopersonal" placeholder="Anticipo" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    </div>


                    <div class="col-xs-6">

                    <span class="section">Otros</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Reintegro Asig. Familiar <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="reintegroasigfamiliar" class="form-control col-md-7 col-xs-12" name="reintegroasigfamiliar" placeholder="Reintegro Asig. Familiar" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Asignación Retroactiva <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="asignacionretroactiva" class="form-control col-md-7 col-xs-12" name="asignacionretroactiva" placeholder="Asignación Retroactiva" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Haberes Imp. <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="otroshaberesimp" class="form-control col-md-7 col-xs-12" name="otroshaberesimp" placeholder="Otros Haberes Imponibles" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>


                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Haberes No Imp. <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="otroshaberesnoimp" class="form-control col-md-7 col-xs-12" name="otroshaberesnoimp" placeholder="Otros Haberes No Imponibles" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>


                    </br>
                    <span class="section">Descuentos</span>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Seguro Cesantía <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="segurocesantia" class="form-control col-md-7 col-xs-12" name="segurocesantia" placeholder="Seguro Cesantía Trabajador" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ahorro Voluntario AFP <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="ahorrovoluntario" class="form-control col-md-7 col-xs-12" name="ahorrovoluntario" placeholder="Ahorro Voluntario AFP" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Impuesto a la Renta <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="impuestoalarenta" class="form-control col-md-7 col-xs-12" name="impuestoalarenta" placeholder="Impuesto a la Renta" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Seguro de Vida <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="segurovida" class="form-control col-md-7 col-xs-12" name="segurovida" placeholder="Seguro de Vida" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Crédito Social CCAF Los Andes <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="creditosocial" class="form-control col-md-7 col-xs-12" name="creditosocial" placeholder="Crédito Social CCAF Los Andes" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Descuentos <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="otrosdescuentos" class="form-control col-md-7 col-xs-12" name="otrosdescuentos" placeholder="Otros Haberes No Imponibles" value="0"  type="text" onKeyPress="return SoloNumeros(event);">
                      </div>
                    </div>


                    


                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-5">

                        <button type="submit" class="btn btn-primary">Cancelar <span class="glyphicon glyphicon-remove"> </button>
                        <button type="submit" id="btn-submit" name="guardar" class="btn btn-success">Registrar <span class="glyphicon glyphicon-ok"></span></button>
                        
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="copyright-info">
            <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>  
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script src="js/custom.js"></script>
  <!-- form validation
  <script src="js/validator/validator.js"></script> -->
  <!-- bootstrap-daterangepicker -->
  <script src="css/moment/min/moment.min.js"></script>
  <script src="css/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script type="text/javascript" src="jsweb/scriptregistrarbono.js"></script>
  <script type="text/javascript" src="jsweb/validation.min.js"></script>

  <script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
      .on('blur', 'input[required], input.optional, select.required', validator.checkField)
      .on('change', 'select.required', validator.checkField)
      .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required')
      .on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);

    $('form').submit(function(e) {
      e.preventDefault();
      var submit = true;
      // evaluate the form using generic validaing
      if (!validator.checkAll($(this))) {
        submit = false;
      }

      if (submit)
        this.submit();
      return false;
    });

    /* FOR DEMO ONLY */
    $('#vfields').change(function() {
      $('form').toggleClass('mode2');
    }).prop('checked', false);

    $('#alerts').change(function() {
      validator.defaults.alerts = (this.checked) ? false : true;
      if (this.checked)
        $('form .alert').remove();
    }).prop('checked', false);
  </script>

       <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#fecha_trato').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4",
          "locale": {
              "format": "DD-MM-YYYY",
              "daysOfWeek": [
                  "Do",
                  "Lu",
                  "Ma",
                  "Mi",
                  "Ju",
                  "Vi",
                  "Sa"
              ],
              "monthNames": [
                  "Enero",
                  "Febrero",
                  "Marzo",
                  "Abril",
                  "Mayo",
                  "Junio",
                  "Julio",
                  "Agusto",
                  "Septiembre",
                  "Octubre",
                  "Noviembre",
                  "Diciembre"
              ],
              "firstDay": 1
          }
        });

        $('#fecha_proceso').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4",
          "locale": {
              "format": "DD-MM-YYYY",
              "daysOfWeek": [
                  "Do",
                  "Lu",
                  "Ma",
                  "Mi",
                  "Ju",
                  "Vi",
                  "Sa"
              ],
              "monthNames": [
                  "Enero",
                  "Febrero",
                  "Marzo",
                  "Abril",
                  "Mayo",
                  "Junio",
                  "Julio",
                  "Agusto",
                  "Septiembre",
                  "Octubre",
                  "Noviembre",
                  "Diciembre"
              ],
              "firstDay": 1
          }
        });

      });

    </script>
    <!-- /bootstrap-daterangepicker -->
    <script type="text/javascript">
      //Se utiliza para que el campo de texto solo acepte numeros
      function SoloNumeros(evt){
       if(window.event){//asignamos el valor de la tecla a keynum
        keynum = evt.keyCode; //IE
       }
       else{
        keynum = evt.which; //FF
       } 
       //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
       if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum ==189){
        return true;
       }
       else{
        return false;
       }
      }
      </script>

      <script type="text/javascript">
      //Se utiliza para que el campo de texto solo acepte numeros
      function Rut(evt){
       if(window.event){//asignamos el valor de la tecla a keynum
        keynum = evt.keyCode; //IE
       }
       else{
        keynum = evt.which; //FF
       } 
       //comprobamos si se encuentra en el rango numérico y que teclas no recibirá.
       if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum==107){
        return true;
       }
       else{
        return false;
       }
      }
      </script>

      <script type="text/javascript">
      function soloLetras(e) {
          key = e.keyCode || e.which;
          tecla = String.fromCharCode(key).toString();
          letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
          especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

          tecla_especial = false
          for(var i in especiales) {
              if(key == especiales[i]) {
                  tecla_especial = true;
                  break;
              }
          }

          if(letras.indexOf(tecla) == -1 && !tecla_especial){
              return false;
            }
      }






      </script>

</body>

</html>
