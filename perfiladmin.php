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

$sql2 = "SELECT * FROM empleado";
$result2 = $db_con->query($sql2) or die(mysql_error());
$arreglo_empleado = $result2->fetchAll();



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comercial Del Mar | Perfil</title>

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
                  <li><a href="perfiladmin.php"><i class="fa fa-user pull-right"></i> Perfil</a>
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
                    Perfil Usuario
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
                  <h2>Perfil</h2>
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

                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Change the avatar">
                          <img src="images/user.png" alt="Avatar">
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal" type="button">&times;</button>
                                  <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                      <input class="avatar-src" name="avatar_src" type="hidden">
                                      <input class="avatar-data" name="avatar_data" type="hidden">
                                      <label for="avatarInput">Local upload</label>
                                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                      <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                      </div>
                                    </div>

                                    <div class="row avatar-btns">
                                      <div class="col-md-9">
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">Rotate Left</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">Rotate Right</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3><?php echo $row['nombre_usuario']; ?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i> Comercial Del Mar, Coquimbo
                      </li>

                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> Administración
                      </li>

                      <li class="m-top-xs">
                        <i class="fa fa-external-link user-profile-icon"></i>
                        <a href="http://www.kimlabs.com/profile/" target="_blank"><?php echo $row['mail']; ?></a>
                      </li>
                    </ul>

                    <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                    <br />

                    <!-- start skills -->
                    <h4>Skills</h4>
                    <ul class="list-unstyled user_data">
                      <li>
                        <p>Web Applications</p>
                        <div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </li>
                      <li>
                        <p>Website Design</p>
                        <div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                        </div>
                      </li>
                      <li>
                        <p>Automation & Testing</p>
                        <div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                        </div>
                      </li>
                      <li>
                        <p>UI / UX</p>
                        <div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </li>
                    </ul>
                    <!-- end of skills -->

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <!-- start recent activity -->
                          <ul class="messages">
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-info">24</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Desmond Davison</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                  <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-error">21</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Brian Michaels</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1" aria-hidden="true" data-icon=""></span>
                                  <a href="#" data-original-title="">Download</a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-info">24</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Desmond Davison</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                  <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-error">21</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Brian Michaels</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1" aria-hidden="true" data-icon=""></span>
                                  <a href="#" data-original-title="">Download</a>
                                </p>
                              </div>
                            </li>

                          </ul>
                          <!-- end recent activity -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                          <!-- start user projects -->
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Client Company</th>
                                <th class="hidden-phone">Hours Spent</th>
                                <th>Contribution</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>New Company Takeover Review</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">18</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="35"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>New Partner Contracts Consultanci</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">13</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-danger" data-transitiongoal="15"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Partners and Inverstors report</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">30</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="45"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>New Company Takeover Review</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">28</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="75"></div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- end user projects -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                            photo booth letterpress, commodo enim craft beer mlkshk </p>
                        </div>
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
  <!-- form validation
  <script src="js/validator/validator.js"></script> -->
  <!-- bootstrap-daterangepicker -->
  <script src="css/moment/min/moment.min.js"></script>
  <script src="css/bootstrap-daterangepicker/daterangepicker.js"></script>
  
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
