<?php
 require_once 'dbconfig.php';

 if($_POST)
 {

  $idtrato = $_POST['idtra'];
  $actividad = $_POST['actividad'];
  $empleado = $_POST['empleado'];
  $producto = $_POST['producto'];
  $valorkilo = $_POST['valor_kilo'];
  $cantkilo = $_POST['kilos'];
  $totalpago = $_POST['total_pagar'];
  $fechatrato = date("Y-m-d", strtotime($_POST['fecha_trato']));
  $fechaproceso = date("Y-m-d", strtotime($_POST['fecha_proceso']));
  $lote = $_POST['lote'];



  try
  { 

    $stmt1 = $db_con->prepare("UPDATE trato
      SET  id_actividad=:act, id_empleado=:emp, id_producto=:pro, valor_kilo=:vkilo, cantidad_kilos=:cantk, total_pagar=:tot, fecha_trato=:fech, fecha_proceso=:fpro, lote_trato=:lote WHERE id_trato=:tra ");
    $stmt1->bindParam(":tra",$idtrato);
    $stmt1->bindParam(":act",$actividad);
    $stmt1->bindParam(":emp",$empleado);
    $stmt1->bindParam(":pro",$producto);
    $stmt1->bindParam(":vkilo",$valorkilo);
    $stmt1->bindParam(":cantk",$cantkilo);
    $stmt1->bindParam(":tot",$totalpago);
    $stmt1->bindParam(":fech",$fechatrato);
    $stmt1->bindParam(":fpro",$fechaproceso);
    $stmt1->bindParam(":lote",$lote);
    

    
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