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

if($_POST)
 {
  $id_empleado = $_POST['empleado'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];
 }else{
  $id_empleado="";
  $mes = "";
  $ano = "";
 }

$sql = "SELECT * FROM empleado WHERE id_empleado='$id_empleado'";
// Crea la consulta y asigna el resultado a la variable result
$result = $db_con->query($sql);
// extrae los valores de result en un array, cada valor esta en row
$arreglo_empleado= $result->fetchAll();

//contador de dias trabajados
$stmt1 = $db_con->prepare("SELECT * FROM asistencia WHERE Month(fecha_asistencia)='$mes' AND id_empleado='$id_empleado' AND tipo_asistencia='presente' ");
$stmt1->execute();
$contdiastrabajados = $stmt1->rowCount();

//otener total de horas trabajadas
$sql2 = "SELECT SUM(horas_asistencia) as totalhtrab FROM asistencia WHERE Month(fecha_asistencia)='$mes' AND id_empleado='$id_empleado' AND tipo_asistencia='presente' ";
$result2 = $db_con->query($sql2);
$horas_trabajadas= $result2->fetchAll();
foreach ($horas_trabajadas as $htrabajadas) { 
 $horastrabajadas = $htrabajadas['totalhtrab'];
}

//obtener total de horas extras
$sql3 = "SELECT SUM(horas_extras) as totalhextras FROM asistencia WHERE Month(fecha_asistencia)='$mes' AND id_empleado='$id_empleado' AND tipo_asistencia='presente' ";
$result3 = $db_con->query($sql3);
$arreglo_horas= $result3->fetchAll();
foreach ($arreglo_horas as $horas) { 
 $horaext = $horas['totalhextras'];
}

//suma de horas trabajadas y extras
$totalhoras = $horastrabajadas + $horaext;

//obtener pago en emparrillado
$sql4 = "SELECT SUM(cantidad_kilos) as kilosempa, SUM(total_pagar) as pagoempa FROM trato WHERE Month(fecha_trato)='$mes' AND id_empleado='$id_empleado' AND id_actividad='1' ";
$result4 = $db_con->query($sql4);
$pago_emparrillado= $result4->fetchAll();
foreach ($pago_emparrillado as $empa) { 
 $pagoemparrillado = $empa['pagoempa'];
 $kemparrillado = $empa['kilosempa'];
}

//obtener pago en fileteo
$sql5 = "SELECT SUM(cantidad_kilos) as kilosfileteo, SUM(total_pagar) as pagofileteo FROM trato WHERE Month(fecha_trato)='$mes' AND id_empleado='$id_empleado' AND id_actividad='2' ";
$result5 = $db_con->query($sql5);
$pago_fileteo= $result5->fetchAll();
foreach ($pago_fileteo as $fileteo) { 
 $pagofileteo = $fileteo['pagofileteo'];
 $kfileteo = $fileteo['kilosfileteo'];
}

//obtener pago en ramaleo
$sql6 = "SELECT SUM(cantidad_kilos) as kilosramaleo, SUM(total_pagar) as pagoramaleo FROM trato WHERE Month(fecha_trato)='$mes' AND id_empleado='$id_empleado' AND id_actividad='3' ";
$result6 = $db_con->query($sql6);
$pago_ramaleo= $result6->fetchAll();
foreach ($pago_ramaleo as $ramaleo) { 
 $pagoramaleo = $ramaleo['pagoramaleo'];
 $kramaleo = $ramaleo['kilosramaleo'];
}

//obtener pago en esvicerado
$sql7 = "SELECT SUM(cantidad_kilos) as kilosesvicerado, SUM(total_pagar) as pagoesvicerado FROM trato WHERE Month(fecha_trato)='$mes' AND id_empleado='$id_empleado' AND id_actividad='5' ";
$result7 = $db_con->query($sql7);
$pago_esvicerado= $result7->fetchAll();
foreach ($pago_esvicerado as $esvicerado) { 
 $pagoesvicerado = $esvicerado['pagoesvicerado'];
 $kesvicerado = $esvicerado['kilosesvicerado'];
}

//obtener pago en empaque
$sql8 = "SELECT SUM(cantidad_kilos) as kilosempaque, SUM(total_pagar) as pagoempaque FROM trato WHERE Month(fecha_trato)='$mes' AND id_empleado='$id_empleado' AND id_actividad='4' ";
$result8 = $db_con->query($sql8);
$pago_empaque= $result8->fetchAll();
foreach ($pago_empaque as $empaque) { 
 $pagoempaque = $empaque['pagoempaque'];
 $kempaque = $empaque['kilosempaque'];
}

//suma de pagos por trato
$totaltrato = $pagoemparrillado + $pagofileteo + $pagoramaleo + $pagoempaque + $pagoesvicerado;


//sueldobase
$sql9 = "SELECT * FROM empleado  WHERE id_empleado='$id_empleado' ";
$result9 = $db_con->query($sql9);
$sueldobase= $result9->fetchAll();
foreach ($sueldobase as $sueldo) { 
 $sueldo_base = $sueldo['sueldobase_empleado'];
}

//calculo sueldo mes
$sueldomes1 = (($sueldo_base/30) / 8);
$sueldomes = $horastrabajadas * $sueldomes1 ;


//calculo gratificacion
if($sueldo_base <= 270000){
  $gratificacion = round(($sueldomes * 0.25));

}else if($sueldo_base > 270000){
  $gratificacion = round(($sueldomes*4.75) / 12);

}

//calculo horas extras
$pago_horasextras = $horaext * 2000 ;

//obtener bonos del empleado
$sql10= "SELECT * FROM bono  WHERE id_empleado='$id_empleado' AND mes='$mes' AND ano='$ano' ";
$result10 = $db_con->query($sql10);
$bonos_empleado= $result10->fetchAll();
foreach ($bonos_empleado as $bonos) { 
 $bonoproduccion = $bonos['bono_produccion'];
 $bonoresponsabilidad = $bonos['bono_responsabilidad'];
 $bonocolacion = $bonos['bono_colacion'];
 $bonomovilizacion = $bonos['bono_movilizacion'];
 $aguinaldo = $bonos['aguinaldo'];
 $comision = $bonos['comision_venta'];
 $hotelera = $bonos['asignacion_hotelera'];
 $salacuna = $bonos['sala_cuna'];
 $bonoanticipos = $bonos['anticipo_sueldo'];
 $anticiposueldo2 = $bonos['segundoanticipo_sueldo'];
 $anticipoaguinaldo = $bonos['anticipo_aguinaldo'];
 $prestamo = $bonos['prestamo_personal'];
 $reintegro = $bonos['reintegro_asigfamiliar'];
 $retroactiva = $bonos['asignacion_retroactiva'];
 $otroshaberesimp = $bonos['otros_haberesimp'];
 $otroshaberesnoimp = $bonos['otros_haberesnoimp'];
 $segurocesantia = $bonos['seguro_cesantia'];
 $ahorrovol = $bonos['ahorro_voluntario'];
 $impuesto = $bonos['impuesto_renta'];
 $seguro = $bonos['seguro_vida'];
 $creditosocial = $bonos['credito_social'];
 $otrosdescuentos = $bonos['otros_descuentos'];

}


//calculo total haberes imponibles

$totalhaberesimponibles = $sueldomes + $gratificacion + $pago_horasextras + $totaltrato + $bonoproduccion + $bonoresponsabilidad + $aguinaldo + $comision + $hotelera + $otroshaberesimp;

//calculo de afp segun sueldo base
$sql11 = "SELECT afp.valor_afp FROM empleado 
          INNER JOIN afp  
          ON empleado.id_afp = afp.id_afp
          WHERE id_empleado='$id_empleado' ";
$result11 = $db_con->query($sql11);
$afpempleado= $result11->fetchAll();
foreach ($afpempleado as $afp) { 
 $valorafp = $afp['valor_afp'];
}
$totalafp = round(($totalhaberesimponibles*($valorafp/100)));

//calculo salud 7%
$totalsalud = round(($totalhaberesimponibles*(7/100)));

//calculo total dcto legales
$totaladctolegales = $totalafp + $totalsalud + $segurocesantia + $ahorrovol + $impuesto;

//calculo asignacion familiar
$sql12 = "SELECT * FROM empleado WHERE id_empleado='$id_empleado'";
$result12 = $db_con->query($sql12);
$carga_familiar= $result12->fetchAll();
foreach ($carga_familiar as $carga) { 
 $cargafam = $carga['cfamiliar_empleado'];
 $tipocontrato = $carga['tipo_contrato'];
}

$sql13 = "SELECT * FROM valores_informativos WHERE  mes='$mes' AND ano='$ano' ";
$result13 = $db_con->query($sql13);
$valores_informativos = $result13->fetchAll();
foreach ($valores_informativos as $valorcarga) { 
 $tramo1 = $valorcarga['asigfam_tramo1'];
 $tramo2 = $valorcarga['asigfam_tramo2'];
 $tramo3 = $valorcarga['asigfam_tramo3'];
 $tramo4 = $valorcarga['asigfam_tramo4'];
}

if($sueldo_base <= 277016){
  $pagocarga = $cargafam * $tramo1;

}if($sueldo_base > 277016 && $sueldo_base <= 404613){
  $pagocarga = $cargafam * $tramo2;

}if($sueldo_base > 404613 && $sueldo_base <= 631058){
  $pagocarga = $cargafam * $tramo3;

}if($sueldo_base > 631058){
  $pagocarga = $cargafam * $tramo4;

}


//calculo seguro cesantía
$pago_cesantia = round($totalhaberesimponibles * (0.006));

//calculo total haberes no imponibles
$totalhaberesnoimponibles = $reintegro + $pagocarga + $retroactiva + $bonocolacion + $bonomovilizacion + 
$salacuna + $otroshaberesnoimp ;

//total haberes
$totalhaberes = $totalhaberesimponibles + $totalhaberesnoimponibles;

//total otros descuentos
$totalotrosdescuentos = $seguro + $creditosocial + $prestamo + $anticipoaguinaldo + $bonoanticipos + $anticiposueldo2 + $otrosdescuentos;

//total descuentos
$totaldescuentos = $totaladctolegales + $totalotrosdescuentos ;

//sueldo liquido a pagar
$sueldoliquido = +($totalhaberes - $totaldescuentos);

//setlocale(LC_MONETARY,"es_CL"); 
//echo number_format($sueldoliquido);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comercial Del Mar | Liquidación </title>

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
                    Generar Liquidación
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
                  <h2>Liquidación / Período <?php echo $mes .' - '. $ano ?></h2>
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

                  <div class="col-xs-6">
                  <p class="lead">Datos del Empleado</p>
                    <span class="section">Empleado: <?php foreach ($arreglo_empleado as $empleado) { ?> <?php echo $empleado['nombre_empleado']. ' ' .$empleado['apellido_empleado']; ?></br>
                      Rut: <?php echo $empleado['rut_empleado']; } ?></br>
                      Días Trabajados: <?php echo $contdiastrabajados ?> </br>
                      Horas Trabajadas: <?php echo $horastrabajadas ?> </br>
                      Horas Extras: <?php echo $horaext ?> </br>
                      Total Horas: <?php echo $totalhoras ?> </br>
                      </br>
                    </span>       
                  </div>

                  <input type="hidden" id="idempleado" name="idempleado" value="<?php echo $id_empleado ?>">
                  <input type="hidden" id="mes" name="mes" value="<?php echo $mes ?>">
                  <input type="hidden" id="ano" name="ano" value="<?php echo $ano ?>">

                  <div class="col-xs-6">
                  <p class="lead">Tratos</p>
                    <span class="section">Emparrillado: $ <?php echo $pagoemparrillado?> (<?php echo $kemparrillado ?> Kilos ) </br>
                      Fileteo: $ <?php echo $pagofileteo ?> (<?php echo $kfileteo ?> Kilos ) </br>
                      Ramaleo: $ <?php echo $pagoramaleo ?> (<?php echo $kramaleo ?> Kilos ) </br>
                      Esvicerado:$ <?php echo $pagoesvicerado ?> (<?php echo $kesvicerado ?> Kilos ) </br>
                      Empaque:$ <?php echo $pagoempaque ?> (<?php echo $kempaque ?> Kilos ) </br>
                      Total Pago: <?php echo $totaltrato ?> </br>
                      </br>
                    </span>       
                  </div>
                    
                    
                    </br>

                    <div class="col-xs-6">
                        <p class="lead">Haberes</p>
                        <span class="section"></span>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Sueldo Base</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="sueldobase" name="sueldobase" class="form-control col-md-7 col-xs-12" readonly="true" value="<?php echo $sueldo_base ?>" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Sueldo Mes</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="sueldomes" name="sueldomes" class="form-control col-md-7 col-xs-12" readonly="true" value="<?php echo $sueldomes ?>" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Gratificación</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="gratificacion" name="gratificacion" class="form-control col-md-7 col-xs-12" readonly="true" value="<?php echo $gratificacion ?>" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Horas Extras</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="hextras" name="hextras" class="form-control col-md-7 col-xs-12" readonly="true" value="<?php echo $pago_horasextras ?>" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Tratos</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="tratos" name="tratos" class="form-control col-md-7 col-xs-12" readonly="true" value="<?php echo $totaltrato ?>" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bono Producción
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="bproduccion" class="form-control col-md-7 col-xs-12" name="bproduccion" value="<?php echo $bonoproduccion ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bono Responsabilidad
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="bresponsabilidad" class="form-control col-md-7 col-xs-12" name="bresponsabilidad" value="<?php echo $bonoresponsabilidad ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Aguinaldos
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="aguinaldo" class="form-control col-md-7 col-xs-12" name="aguinaldo" value="<?php echo $aguinaldo ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Comisión Por Ventas
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="comisionventas" class="form-control col-md-7 col-xs-12" name="comisionventas" value="<?php echo $comision ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Asignación Hotelera
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="asighotelera" class="form-control col-md-7 col-xs-12" name="asighotelera" value="<?php echo $hotelera ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Haberes
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="otroshaberes" class="form-control col-md-7 col-xs-12" name="otroshaberes" value="<?php echo $otroshaberesimp ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        </br>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Haberes Imponibles
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totalhaberesimp" class="form-control col-md-7 col-xs-12" name="totalhaberesimp" value="<?php echo $totalhaberesimponibles ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>
                        <span class="section"></span>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Reintegro Asig. Familiar
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="reasignacionfamiliar" class="form-control col-md-7 col-xs-12" name="reasignacionfamiliar" value="<?php echo $reintegro ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Asignación Familiar
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="asigfamiliar" class="form-control col-md-7 col-xs-12" name="asigfamiliar" value="<?php echo $pagocarga ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Asignación Retroactiva
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="asigretroactiva" class="form-control col-md-7 col-xs-12" name="asigretroactiva" value="<?php echo $retroactiva ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Colación
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="colacion" class="form-control col-md-7 col-xs-12" name="colacion" value="<?php echo $bonocolacion ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>


                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Movilización
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="movilizacion" class="form-control col-md-7 col-xs-12" name="movilizacion" value="<?php echo $bonomovilizacion ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sala Cuna
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="salacuna" class="form-control col-md-7 col-xs-12" name="salacuna" value="<?php echo $salacuna ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Hab. No Imp.
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="otroshaberesnoimp" class="form-control col-md-7 col-xs-12" name="otroshaberesnoimp" value="<?php echo $otroshaberesnoimp ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        </br>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Haberes No Imp.
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totalhaberesnoimp" class="form-control col-md-7 col-xs-12" name="totalhaberesnoimp" value="<?php echo $totalhaberesnoimponibles ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>

                    </div>



                    <!--  -->
                    <div class="col-xs-6">
                        <p class="lead">Descuentos</p>
                        <span class="section"></span>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">AFP
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="afp" class="form-control col-md-7 col-xs-12" name="afp" value="<?php echo $totalafp ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Salud
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="salud" class="form-control col-md-7 col-xs-12" name="salud" value="<?php echo $totalsalud ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Seguro Cesantía
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php
                            if($tipocontrato == 'indefinido' || $tipocontrato == 'Indefinido' || $tipocontrato == 'INDEFINIDO'){
                              ?>
                              <input id="segurocesantia" class="form-control col-md-7 col-xs-12" name="segurocesantia" value="<?php echo $pago_cesantia ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                            <?php
                            }else{
                            ?>
                              <input id="segurocesantia" class="form-control col-md-7 col-xs-12" name="segurocesantia" value="<?php echo $segurocesantia ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">

                            <?php
                            }
                          ?>
                            
                          
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ahorro Voluntario AFP
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="ahorroafp" class="form-control col-md-7 col-xs-12" name="ahorroafp" value="<?php echo $ahorrovol ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Impuesto a la Renta
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="impuestorenta" class="form-control col-md-7 col-xs-12" name="impuestorenta" value="<?php echo $impuesto ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Descuentos Legales
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totaldescuentoslegales" class="form-control col-md-7 col-xs-12" name="totaldescuentoslegales" value="<?php echo $totaladctolegales ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>
                    </div>


                    <div class="col-xs-6">
                        <span class="section"></span>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Seguro de Vida
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="segurovida" class="form-control col-md-7 col-xs-12" name="segurovida" value="<?php echo $seguro ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Crédito Social CCAF Los Andes
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="csocial" class="form-control col-md-7 col-xs-12" name="csocial" value="<?php echo $creditosocial ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Préstamo Personal
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="prestamopersonal" class="form-control col-md-7 col-xs-12" name="prestamopersonal" value="<?php echo $prestamo ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Anticipo de Aguinaldo
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="anticipoaguinaldo" class="form-control col-md-7 col-xs-12" name="anticipoaguinaldo" value="<?php echo $anticipoaguinaldo ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>


                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Anticipo de Sueldo
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="anticiposueldo" class="form-control col-md-7 col-xs-12" name="anticiposueldo" value="<?php echo $bonoanticipos ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Segundo Anticipo
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="segundoanticipo" class="form-control col-md-7 col-xs-12" name="segundoanticipo" value="<?php echo $anticiposueldo2 ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Otros Descuentos
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="otrosdescuentos" class="form-control col-md-7 col-xs-12" name="otrosdescuentos" value="<?php echo $otrosdescuentos ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        </br>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Otros Descuentos
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totalotrosdescuentos" class="form-control col-md-7 col-xs-12" name="totalotrosdescuentos" value="<?php echo $totalotrosdescuentos ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>

                        

                    </div>


                                        <!--  -->
                    <div class="col-xs-6">
                        <p class="lead">Sueldo </p>
                        <span class="section"></span>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Haberes
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totalhaberes" class="form-control col-md-7 col-xs-12" name="totalhaberes" value="<?php echo $totalhaberes ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Descuentos
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="totaldescuentos" class="form-control col-md-7 col-xs-12" name="totaldescuentos" value="<?php echo $totaldescuentos ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>

                        </br>

                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sueldo Líquido $
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="sueldoliquido" class="form-control col-md-7 col-xs-12" name="sueldoliquido" value="<?php echo $sueldoliquido ?>" readonly="true" type="text" onKeyPress="return SoloNumeros(event);">
                          </div>
                        </div>
                        </br>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-5">

                            <button type="submit" class="btn btn-primary">Cancelar <span class="glyphicon glyphicon-remove"> </button>
                            <button type="submit" id="btn-submit" name="guardar" class="btn btn-success">Registrar <span class="glyphicon glyphicon-ok"></span></button>
                            
                          </div>
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

  <script type="text/javascript" src="jsweb/scriptregistrarliquidacion.js"></script>
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
