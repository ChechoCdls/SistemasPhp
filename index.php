<?php
session_start();
include_once 'dbconfig.php';

if(isset($_SESSION['user_session'])!="")
{
    $stmt = $db_con->prepare("SELECT * FROM usuario WHERE id_usuario=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['user_session']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row['permiso']=="admin"){
            header("Location: menuadmin.php");
        }else if ($row['permiso']=="normal"){
            header("Location: menuser.php");
        }else if($row['permiso']=="super"){
            header("Location: menusuperadmin.php");
  }
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

  <title> Comercial Del Mar | Login </title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


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

<body style="background:#F7F7F7;">

  <div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <form method="post" id="login-form" >
            <h1>Ingreso al Sistema</h1>
            <img src="images/Logo-DELMAR-1.png" alt="" width="330" height="129" margin:20px>
            </br>
            <div>

            <div id="error">
                            <!-- error will be showen here ! -->
            </div>
            
            <br>
            <br>
              <input type="text" class="form-control" placeholder="Ingrese rut sin guión y punto" name="rut" id="rut" onKeyPress="return Rut(event)"; required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Ingrese contraseña" name="password" id="password" required="" />
            </div>
            <div>
            <div>
              <button type="submit" class="btn btn-default submit" name="btn-login" id="btn-login">
              <span class="glyphicon glyphicon-log-in"></span> &nbsp; Ingresar
            </div>
              <a  class="reset_pass" href="#">¿Olvidó su contraseña?</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <div class="clearfix"></div>
              <br />
              <div>
                <h1><i  style="font-size: 26px;"></i> Comercial Del Mar</h1>

                <p>©2017 All Rights Reserved. </p>
              </div>
            </div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
      
    </div>
  </div>

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


    <script type="text/javascript" src="jsweb/script2.js"></script>
    <script type="text/javascript" src="jsweb/validation.min.js"></script>

</body>

</html>
