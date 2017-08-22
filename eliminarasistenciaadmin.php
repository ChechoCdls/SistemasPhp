<?php

 require_once 'dbconfig.php';


  $idemp = $_GET['id'];
  $fecha = $_GET['fecha'];

 try
  { 
  
   	$stmt = $db_con->prepare("DELETE FROM asistencia WHERE id_empleado = '$idemp' AND fecha_asistencia = '$fecha' ");


   	if($stmt->execute())
    {
     header("Location: verasistenciaadmin.php");
    }
    else
    {
     echo "ERROR";
    }
   


  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

?>