<?php
 require_once 'dbconfig.php';

 if($_POST)
 {

  $empleado = $_POST['id_empleado'];
  $asistencia = $_POST['asistencia'];
  $horas = $_POST['horas'];
  $horasextras = $_POST['horas_extras'];
  $fechaasistencia = date("Y-m-d", strtotime($_POST['fecha_asistencia']));
  //$fechaasistencia = '30-06-2017';

  //echo $empleado;
  //echo $asistencia;
  //echo $horas;
  //echo $horasextras;
  //echo $fechaasistencia;



  try
  { 

    $stmt1 = $db_con->prepare("UPDATE asistencia
      SET  tipo_asistencia=:asist, horas_asistencia=:hrs, horas_extras=:hext WHERE id_empleado=:emp AND fecha_asistencia=:fecha ");
    $stmt1->bindParam(":asist",$asistencia);
    $stmt1->bindParam(":hrs",$horas);
    $stmt1->bindParam(":hext",$horasextras);
    $stmt1->bindParam(":fecha",$fechaasistencia); 
    $stmt1->bindParam(":emp",$empleado);
    

    
    if($stmt1->execute()){
      echo "registered";

    }else{
        echo "Query could not execute";
    }
  }
  catch(PDOException $e){
       echo $e->getMessage();
  }
 }
?>