<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$id_asistencia = '0';

 	$empleado = $_POST['id_empleado'];
 	$asistencia = $_POST['asistencia'];
 	$horas = $_POST['horas'];
  $horasextras = $_POST['horas_extras'];
 	$fechaasistencia = date("Y-m-d", strtotime($_POST['fecha_asistencia']));
  //$fechaasistencia = '30-06-2017';


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM asistencia WHERE id_empleado=:emp AND fecha_asistencia=:asi ");
   $stmt->execute(array(":emp"=>$empleado,":asi"=>$fechaasistencia));
   //$stmt->execute(array(":emp"=>$empleado));
   //$stmt->execute(array(":fec"=>$fechaasistencia));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO asistencia(id_empleado,tipo_asistencia,horas_asistencia,fecha_asistencia,horas_extras) VALUES(:emp,:asist,:hrs,:fecha,:hext)");

  $stmt->bindParam(":emp",$empleado);
	$stmt->bindParam(":asist",$asistencia);
	$stmt->bindParam(":hrs",$horas);
	$stmt->bindParam(":fecha",$fechaasistencia);
  $stmt->bindParam(":hext",$horasextras);


   	if($stmt->execute())
    {
     echo "registered";
    }
    else
    {
     echo "Query could not execute ";
    }
   
   }
   else{
    
    echo "Ya tiene registrado asistencia en esa fecha"; //  not available
   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
