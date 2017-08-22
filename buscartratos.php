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

  if ($row['permiso']=="admin"){ //SI EL PERMISO ES NORMAL ENVIARLO AL MENU MONITOR PORQUE YA INICIó SESION
            header("Location: menuadmin.php");
  }else if($row['permiso']=="super"){
            header("Location: menusuperadmin.php");
  }
}


$id_empleado = $_POST['empleado'];
$fecha1 = date("Y-m-d", strtotime($_POST['fecha_1']));
$fecha2 = date("Y-m-d", strtotime($_POST['fecha_2']));

$sql1 = "SELECT * FROM empleado";
$result1 = $db_con->query($sql1) or die(mysql_error());
$arreglo_empleado = $result1->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comercial Del Mar | Tratos </title>

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

  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

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

                <li><a><i class="fa fa-money"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrarventa.php">Registrar Venta</a>
                    </li>
                    <li><a href="verventa.php">Visualizar Ventas</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-tags"></i> Stock <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registrarstock.php">Registrar Stock</a>
                    </li>
                    <li><a href="verstock.php">Visualizar Stock</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-user-plus"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="registraruser.php">Nuevo Usuario</a>
                    </li>
                    <li><a href="veruser.php">Ver Usuarios</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <h3>Administración</h3>
              <ul class="nav side-menu">

              <li><a><i class="fa fa-users"></i> Empleados <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="verempleados.php">Visualizar Empleados</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-tags"></i> Productos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="verproductos.php">Visualizar Productos</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-tasks"></i> Actividades <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="veractividades.php">Visualizar Actividad</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-book"></i> Tratos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="vertratos.php">Visualizar Tratos</a>
                    </li>
                    <li><a href="buscartratos.php">Buscar Tratos</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-calendar-check-o"></i> Asistencia <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="verasistencia.php">Visualizar Asistencias</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-credit-card-alt"></i> Liquidación <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="buscarliquidacion.php">Buscar Liquidaciones</a>
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
                  <li><a href="javascript:;">  Perfil</a>
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

        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>
                    Búsqueda de Tratos
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
                  <h2>Tratos</h2>
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

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Búsqueda </h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a href="#"><i class="fa fa-chevron-up"></i></a>
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
                              <li><a href="#"><i class="fa fa-close"></i></a>
                              </li>
                            </ul>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                  <form class="form-horizontal form-label-left" action="buscartratos.php" id="register-form" role="form" method="POST" novalidate>

                    <p class="text-muted font-13 m-b-30">
                    Puede realizar la búsqueda de tratos por: Empleado y/o Rango de Fechas.</p>
                    </br></br>
                    
                    <div id="error">
                            <!-- error will be showen here ! -->
                    </div>

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

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Rango de Fechas *</label>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                          <input  value="" type="text" placeholder="Fecha " id="fecha_1" name="fecha_1" class="form-control col-md-4 col-xs-6" onKeyPress="return SoloNumeros(event);">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                          <input  value="" type="text" placeholder="Fecha " id="fecha_2" name="fecha_2" class="form-control col-md-4 col-xs-6" onKeyPress="return SoloNumeros(event);">
                        </div>
                    </div>

    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-5">

                        <button type="submit" class="btn btn-primary">Cancelar <span class="glyphicon glyphicon-remove"> </button>
                        <button type="submit" id="btn-submit" name="guardar" class="btn btn-success">Buscar <span class="glyphicon glyphicon-search"></span></button>
                        
                      </div>
                    </div>
                  </form>

                </div>
                        </div>
                      </div>







                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Lista de Tratos </h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a href="#"><i class="fa fa-chevron-up"></i></a>
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
                              <li><a href="#"><i class="fa fa-close"></i></a>
                              </li>
                            </ul>
                            <div class="clearfix"></div>
                          </div>
                          <?php
                          $sql3 = "SELECT SUM(trato.total_pagar) AS total_trato
                                          FROM trato
                                          INNER JOIN empleado
                                          ON trato.id_empleado = empleado.id_empleado 
                                          WHERE empleado.id_empleado = '$id_empleado'
                                          AND trato.fecha_trato BETWEEN '$fecha1' AND '$fecha2'";
                          $result3 = $db_con->query($sql3) or die(mysql_error());
                          $arreglo_totalpago = $result3->fetchAll();

                          foreach($arreglo_totalpago as $pago){
                            $totalpago = $pago[total_trato];
                          ?>

                          <h3> TOTAL A PAGAR: <?php echo $totalpago ?> </h3>

                          <?php

                          }
                          ?>

                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Puede exportar la lista a documentos: PDF, EXCEL.
                            </p>

                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>

                                <?php
                                $sql2 = "SELECT 
                                        trato.fecha_trato, 
                                        actividad.nombre_actividad,
                                        empleado.nombre_empleado,
                                        empleado.apellido_empleado,
                                        producto.nombre_producto,
                                        trato.cantidad_kilos,
                                        trato.valor_kilo,
                                        trato.total_pagar
                                        FROM trato
                                        INNER JOIN empleado
                                        ON trato.id_empleado = empleado.id_empleado
                                        INNER JOIN actividad
                                        ON trato.id_actividad = actividad.id_actividad
                                        INNER JOIN producto
                                        ON trato.id_producto = producto.id_producto 
                                        WHERE empleado.id_empleado = '$id_empleado'
                                        AND trato.fecha_trato BETWEEN '$fecha1' AND '$fecha2'
                                        ORDER BY trato.fecha_trato ";
                                  
                                  

                                $result2 = $db_con->query($sql2) or die(mysql_error());
                                $arreglo_trato = $result2->fetchAll();

                                

                                $numfilas =$result2->rowCount();
                                if($numfilas=='0'){
                                  echo "<h3> No hay resultados </h3>";
                                }else{

                                  echo "<tr>";
                                  echo "<th>Fecha</th>";
                                  echo "<th>Empleado</th>";
                                  echo "<th>Actividad</th>";
                                  echo "<th>Producto</th>";
                                  echo "<th>Kilos</th>";
                                  echo "<th>Valor K</th>";
                                  echo "<th>Total a Pagar</th>";
                                  echo "</tr>";

                                  echo "</thead>";
                                  echo "<tbody>";

                                  foreach($arreglo_trato as $trato){
                                  echo "<tr>";
                                  $fechatrato = date("d-m-Y", strtotime($trato['fecha_trato']));
                                  echo "<td> $fechatrato </td>";                                  
                                  echo "<td> $trato[nombre_empleado] $trato[apellido_empleado] </td>";
                                  echo "<td> $trato[nombre_actividad] </td>";
                                  echo "<td> $trato[nombre_producto]</td>";
                                  echo "<td> $trato[cantidad_kilos] </td>";
                                  echo "<td> $trato[valor_kilo] </td>";
                                  echo "<td> $trato[total_pagar] </td>";

                                  }

                              }?>

                                
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

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
  <!-- form validation-->
  <script src="js/validator/validator.js"></script> 
  <!-- bootstrap-daterangepicker -->
  <script src="css/moment/min/moment.min.js"></script>
  <script src="css/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Datatables-->
  <script src="js/datatables/jquery.dataTables.min.js"></script>
  <script src="js/datatables/dataTables.bootstrap.js"></script>
  <script src="js/datatables/dataTables.buttons.min.js"></script>
  <script src="js/datatables/buttons.bootstrap.min.js"></script>
  <script src="js/datatables/jszip.min.js"></script>
  <script src="js/datatables/pdfmake.min.js"></script>
  <script src="js/datatables/vfs_fonts.js"></script>
  <script src="js/datatables/buttons.html5.min.js"></script>
  <script src="js/datatables/buttons.print.min.js"></script>
  <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
  <script src="js/datatables/dataTables.keyTable.min.js"></script>
  <script src="js/datatables/dataTables.responsive.min.js"></script>
  <script src="js/datatables/responsive.bootstrap.min.js"></script>
  <script src="js/datatables/dataTables.scroller.min.js"></script>


  <!-- pace -->
        <script src="js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>

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
        $('#fecha_1').daterangepicker({
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

        $('#fecha_2').daterangepicker({
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

</body>

</html>
