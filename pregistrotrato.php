<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$id_trato = '0';

 	$actividad = $_POST['actividad'];
 	$empleado = $_POST['empleado'];
 	$producto = $_POST['producto'];
 	$valorkilo = $_POST['valor_kilo'];
 	$cantkilo = $_POST['kilos'];
 	$totalpago = $_POST['total_pagar'];
 	$fechatrato = date("Y-m-d", strtotime($_POST['fecha_trato']));
  $fechaproceso = date("Y-m-d", strtotime($_POST['fecha_proceso']));
  $lote = $_POST['lote'];
  $tipo = 'presente';

 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM asistencia WHERE id_empleado=:emp AND fecha_asistencia=:fec AND tipo_asistencia=:asi");
   $stmt->execute(array(":emp"=>$empleado,":fec"=>$fechatrato,":asi"=>$tipo));
   $count = $stmt->rowCount();
   
   if($count==1){

   	$stmt = $db_con->prepare("INSERT INTO trato(id_actividad,id_empleado,id_producto,valor_kilo, cantidad_kilos,total_pagar,fecha_trato,fecha_proceso,lote_trato) VALUES(:act,:emp,:pro,:vkilo,:cantk,:tot,:fech,:fpro,:lote)");

   	$stmt->bindParam(":act",$actividad);
	$stmt->bindParam(":emp",$empleado);
	$stmt->bindParam(":pro",$producto);
	$stmt->bindParam(":vkilo",$valorkilo);
	$stmt->bindParam(":cantk",$cantkilo);
	$stmt->bindParam(":tot",$totalpago);
	$stmt->bindParam(":fech",$fechatrato);
  $stmt->bindParam(":fpro",$fechaproceso);
  $stmt->bindParam(":lote",$lote);

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
    
    echo "No puede registrar el trato, porque el empleado no tiene registrado asistencia en ese fecha"; //  not available
   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
