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

//contadores 
$stmt1 = $db_con->prepare("SELECT * FROM empleado WHERE estado_empleado='1'");
$stmt1->execute();
$contemp = $stmt1->rowCount();


$sql1 = "SELECT SUM(total_pagar) AS total FROM trato";
$result1 = $db_con->query($sql1) or die(mysql_error());
$arreglo_trato = $result1->fetchAll();
foreach($arreglo_trato as $trato){
  $sumatratos = $trato['total'];
  $sumatratos2 = number_format($sumatratos, 0); 
}

$sql2 = "SELECT SUM(sueldoliquido) AS totalpago FROM liquidacion";
$result2 = $db_con->query($sql2) or die(mysql_error());
$arreglo_liqui = $result2->fetchAll();
foreach($arreglo_liqui as $liqui){
  $sumaliquidacion = $liqui['totalpago'];
  $sumaliquidacion2 = number_format($sumaliquidacion, 0); 
}

$sql3 = "SELECT SUM(total_compra) AS totalpago FROM compra";
$result3 = $db_con->query($sql3) or die(mysql_error());
$arreglo_compra = $result3->fetchAll();
foreach($arreglo_compra as $compra){
  $sumacompras = $compra['totalpago'];
  $sumacompras2 = number_format($sumacompras, 0); 
}

//contadores 

//grafico remuneraciones
//SELECT sum(sueldoliquido) from liquidacion GROUP BY mes
$SQLDatos1 = "SELECT SUM(sueldoliquido) as sueldo, mes as mes FROM liquidacion GROUP BY mes";
$result3 = $db_con->query($SQLDatos1) or die(mysql_error());
$arreglo_grafico2 = $result3->fetchAll();
 
$datos1[0] = array('mes','sueldo');


 
foreach ($arreglo_grafico2 as $valores1)
{
    $datos1[]=array(utf8_encode($valores1['mes']),(int)$valores1['sueldo']);
}

//grafico tratos
//SELECT sum(sueldoliquido) from liquidacion GROUP BY mes
$SQLDatos2 = "SELECT SUM(cantidad_kilos) as kilos, producto.nombre_producto as producto, Month(fecha_trato) as mes
              FROM trato 
              INNER JOIN producto
              ON trato.id_producto = producto.id_producto
              GROUP BY Month(fecha_trato), producto.nombre_producto";
$result4 = $db_con->query($SQLDatos2) or die(mysql_error());
$arreglo_tratos = $result4->fetchAll();
 
$datos2[0] = array('producto','kilos','mes');


 
foreach ($arreglo_tratos as $tratos)
{
    $datos2[]=array(utf8_encode($tratos['producto']),(int)$tratos['kilos'],(int)$tratos['mes']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comercial Del Mar | Inicio </title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/maps/jquery-jvectormap-2.0.3.css" />
  <link href="css/icheck/flat/green.css" rel="stylesheet" />
  <link href="css/floatexamples.css" rel="stylesheet" type="text/css" />

  <script src="js/jquery.min.js"></script>
  <script src="js/nprogress.js"></script>

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
                  <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Salir</a>
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

        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i>
                </div>
                <div class="count"><?php echo $contemp ?></div>

                <h3>Empleados</h3>
                <p>Total de empleados actuales en la empresa.</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-tasks"></i>
                </div>
                <div class="count"><?php echo '$'. $sumatratos2 ?></div>

                <h3>Total Tratos</h3>
                <p>Total de dinero pagado en tratos.</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-money"></i>
                </div>
                <div class="count"><?php echo '$'. $sumaliquidacion2 ?></div>

                <h3>Total Remuneraciones</h3>
                <p>Total de dinero pagado en remuneraciones.</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-shopping-cart"></i>
                </div>
                <div class="count"><?php echo '$'. $sumacompras2 ?></div>

                <h3>Total Compras</h3>
                <p>Total de dinero en compras realizadas.</p>
              </div>
            </div>
          </div>



        <div class="row">


        <!-- line area -->
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Remuneraciones<small>Pagos</small></h2>
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
                  <div id="materiales_cantidad" style="width: 100%; height:300px"></div>
                </div>
              </div>
            </div>
          <!-- /line area -->

            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Tratos <small>Kilos Productos</small></h2>
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
                  <div id="grafico_tratos" style="width: 100%; height:300px"></div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Últimos Empleados Registrados</h2>
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
                <?php 
                $sql5 = "SELECT id_empleado, rut_empleado, nombre_empleado, apellido_empleado, fechaingreso_empleado
                        FROM empleado 
                        ORDER By id_empleado 
                        DESC LIMIT 5 ";
                $result5 = $db_con->query($sql5) or die(mysql_error());
                $arreglo_emp = $result5->fetchAll();

                foreach($arreglo_emp as $emp){
                  $cont ++;
                  $id = $emp['id_empleado'];
                  $rut = $emp['rut_empleado'];
                  $nombre = $emp['nombre_empleado'].' '. $emp['apellido_empleado'];
                  $ingreso = date("d-m-Y", strtotime($emp['fechaingreso_empleado']));

                  echo " 
                  <article class='media event'>
                    <a class='pull-left date'>
                      <p class='month'>Id</p>
                      <p class='day'>$id</p>
                    </a>
                    <div class='media-body'>
                      <a class='title' href='#'>$nombre</a>
                      <p>Rut: $rut</p>
                    </div>Ingreso: $ingreso
                  </article>";
                }
                ?>

                </div>

              </div>
            </div>

            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Últimos Tratos Registrados</h2>
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
                <?php 
                $sql6 = "SELECT trato.id_trato, 
                        empleado.nombre_empleado, empleado.apellido_empleado,
                        actividad.nombre_actividad, producto.nombre_producto,
                        trato.cantidad_kilos, trato.total_pagar
                        FROM trato
                        INNER JOIN empleado
                        ON trato.id_empleado = empleado.id_empleado
                        INNER JOIN actividad
                        ON trato.id_actividad = actividad.id_actividad
                        INNER JOIN producto
                        ON trato.id_producto = producto.id_producto
                        ORDER By trato.id_trato 
                        DESC LIMIT 5";
                $result6 = $db_con->query($sql6) or die(mysql_error());
                $arreglo_tra = $result6->fetchAll();

                foreach($arreglo_tra as $tra){
                  $cont ++;
                  $id = $tra['id_trato'];
                  $nombre = $tra['nombre_empleado'].' '. $tra['apellido_empleado'];
                  $actpro = $tra['nombre_actividad']. ' ' . $tra['nombre_producto'];
                  $cant = $tra['cantidad_kilos'];
                  $pago = $tra['total_pagar'];
                  $pago2 = number_format($pago, 0); 
                  
                  echo " 
                  <article class='media event'>
                    <a class='pull-left date'>
                      <p class='month'>Id</p>
                      <p class='day'>$id</p>
                    </a>
                    <div class='media-body'>
                      <a class='title' href='#'>$nombre</a>
                      <p>$actpro</p>
                      <p> Kilos: $cant K  -  $$pago2</p>
                    </div>
                  </article>";
                }
                ?>

                </div>

              </div>
            </div>

            <div class="col-md-4">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Últimas Liquidaciones Generadas</h2>
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
                <?php 
                $sql7 = "SELECT liquidacion.id_liquidacion, liquidacion.sueldoliquido,
                        liquidacion.mes, liquidacion.ano,
                        empleado.nombre_empleado, empleado.apellido_empleado
                        FROM liquidacion
                        INNER JOIN empleado
                        ON liquidacion.id_empleado = empleado.id_empleado
                        ORDER By liquidacion.id_liquidacion
                        DESC LIMIT 5";
                $result7 = $db_con->query($sql7) or die(mysql_error());
                $arreglo_liqui = $result7->fetchAll();

                foreach($arreglo_liqui as $liqui){
                  $cont ++;
                  $id = $liqui['id_liquidacion'];
                  $nombre = $liqui['nombre_empleado'].' '. $liqui['apellido_empleado'];
                  $periodo = $liqui['mes']. ' / ' . $liqui['ano'];
                  $sueldo = $liqui['sueldoliquido'];
                  $sueldo2 = number_format($sueldo, 0); 
                  echo " 
                  <article class='media event'>
                    <a class='pull-left date'>
                      <p class='month'>Id</p>
                      <p class='day'>$id</p>
                    </a>
                    <div class='media-body'>
                      <a class='title' href='#'>$nombre</a>
                      <p>$periodo</p>
                      <p> Sueldo Líquido: $$sueldo2 </p>
                    </div>
                  </article>";
                }
                ?>

                </div>

              </div>
            </div>



          </div>
          

        </div>
        <br />

        <div class="row">

        </div>

        
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

  <script type="text/javascript" src="https://www.google.com/jsapi"></script>

  <!-- gauge js -->
  <script type="text/javascript" src="js/gauge/gauge.min.js"></script>
  <script type="text/javascript" src="js/gauge/gauge_demo.js"></script>
  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  <!-- chart js -->
  <script src="js/chartjs/chart.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- flot js -->
  <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
  <script type="text/javascript" src="js/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="js/flot/date.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.spline.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.stack.js"></script>
  <script type="text/javascript" src="js/flot/curvedLines.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.resize.js"></script>
  <script>
    $(document).ready(function() {
      // [17, 74, 6, 39, 20, 85, 7]
      //[82, 23, 66, 9, 99, 6, 2]
      var data1 = [
        [gd(2012, 1, 1), 17],
        [gd(2012, 1, 2), 74],
        [gd(2012, 1, 3), 6],
        [gd(2012, 1, 4), 39],
        [gd(2012, 1, 5), 20],
        [gd(2012, 1, 6), 85],
        [gd(2012, 1, 7), 7]
      ];

      var data2 = [
        [gd(2012, 1, 1), 82],
        [gd(2012, 1, 2), 23],
        [gd(2012, 1, 3), 66],
        [gd(2012, 1, 4), 9],
        [gd(2012, 1, 5), 119],
        [gd(2012, 1, 6), 6],
        [gd(2012, 1, 7), 9]
      ];
      $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
        data1, data2
      ], {
        series: {
          lines: {
            show: false,
            fill: true
          },
          splines: {
            show: true,
            tension: 0.4,
            lineWidth: 1,
            fill: 0.4
          },
          points: {
            radius: 0,
            show: true
          },
          shadowSize: 2
        },
        grid: {
          verticalLines: true,
          hoverable: true,
          clickable: true,
          tickColor: "#d5d5d5",
          borderWidth: 1,
          color: '#fff'
        },
        colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
        xaxis: {
          tickColor: "rgba(51, 51, 51, 0.06)",
          mode: "time",
          tickSize: [1, "day"],
          //tickLength: 10,
          axisLabel: "Date",
          axisLabelUseCanvas: true,
          axisLabelFontSizePixels: 12,
          axisLabelFontFamily: 'Verdana, Arial',
          axisLabelPadding: 10
            //mode: "time", timeformat: "%m/%d/%y", minTickSize: [1, "day"]
        },
        yaxis: {
          ticks: 8,
          tickColor: "rgba(51, 51, 51, 0.06)",
        },
        tooltip: false
      });

      function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
      }
    });
  </script>

  <!-- worldmap -->
  <script type="text/javascript" src="js/maps/jquery-jvectormap-2.0.3.min.js"></script>
  <script type="text/javascript" src="js/maps/gdp-data.js"></script>
  <script type="text/javascript" src="js/maps/jquery-jvectormap-world-mill-en.js"></script>
  <script type="text/javascript" src="js/maps/jquery-jvectormap-us-aea-en.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script>
    $(function() {
      $('#world-map-gdp').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        zoomOnScroll: false,
        series: {
          regions: [{
            values: gdpData,
            scale: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
          }]
        },
        onRegionTipShow: function(e, el, code) {
          el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
        }
      });
    });
  </script>
  <!-- skycons -->
  <script src="js/skycons/skycons.min.js"></script>
  <script>
    var icons = new Skycons({
        "color": "#73879C"
      }),
      list = [
        "clear-day", "clear-night", "partly-cloudy-day",
        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
        "fog"
      ],
      i;

    for (i = list.length; i--;)
      icons.set(list[i], list[i]);

    icons.play();
  </script>

  <!-- dashbord linegraph -->
  <script>
    Chart.defaults.global.legend = {
      enabled: false
    };

    var data = {
      labels: [
        "Symbian",
        "Blackberry",
        "Other",
        "Android",
        "IOS"
      ],
      datasets: [{
        data: [15, 20, 30, 10, 30],
        backgroundColor: [
          "#BDC3C7",
          "#9B59B6",
          "#455C73",
          "#26B99A",
          "#3498DB"
        ],
        hoverBackgroundColor: [
          "#CFD4D8",
          "#B370CF",
          "#34495E",
          "#36CAAB",
          "#49A9EA"
        ]

      }]
    };

    var canvasDoughnut = new Chart(document.getElementById("canvas1"), {
      type: 'doughnut',
      tooltipFillColor: "rgba(51, 51, 51, 0.55)",
      data: data
    });
  </script>
  <!-- /dashbord linegraph -->
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
          days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>
  <script>
    NProgress.done();
  </script>
  <!-- /datepicker -->
  <!-- /footer content -->

    

    <script type="text/javascript">

    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(dibujarGrafico2);
         
    function dibujarGrafico2() {
     // Tabla de datos: valores y etiquetas de la gráfica
      var cargaDatos2 = <?php echo json_encode($datos1); ?>;
      var datosFinales2 = google.visualization.arrayToDataTable(cargaDatos2);
      var options = {
      
    };
     // Dibujar el gráfico
     var chart = new google.visualization.LineChart(document.getElementById('materiales_cantidad'));
     chart.draw(datosFinales2, options);
   }

    google.setOnLoadCallback(dibujarGraficoTratos);
         
    function dibujarGraficoTratos() {
     // Tabla de datos: valores y etiquetas de la gráfica
      var cargaDatos3= <?php echo json_encode($datos2); ?>;
      var datosFinales3= google.visualization.arrayToDataTable(cargaDatos3);
      var options = {
      
    };
     // Dibujar el gráfico
     var chart = new google.visualization.LineChart(document.getElementById('grafico_tratos'));
     chart.draw(datosFinales3, options);
   }



    </script>

    
</body>

</html>




