<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$id_bono = '0';

 	$empleado = $_POST['empleado'];
 	$bonoproduccion = $_POST['bproduccion'];
 	$bonoresponsabilidad = $_POST['bresponsabilidad'];
 	$bonocolacion = $_POST['bcolacion'];
 	$bonomovilizacion = $_POST['bmovilizacion'];
  $aguinaldo = $_POST['aguinaldo'];
  $comision_porventa = $_POST['comisionventas'];
  $asig_hotelera = $_POST['asighotelera'];
  $salacuna = $_POST['bsalacuna'];
  $anticiposueldo1 = $_POST['anticiposueldo'];
  $anticiposueldo2 = $_POST['segundoanticiposueldo'];
  $anticipo_aguinaldo = $_POST['anticipoaguinaldo'];
  $prestamo = $_POST['prestamopersonal'];
  $reintegro = $_POST['reintegroasigfamiliar'];
  $retroactiva = $_POST['asignacionretroactiva'];
  $otrosimp = $_POST['otroshaberesimp'];
  $otrosnoimp = $_POST['otroshaberesnoimp'];
  $cesantia = $_POST['segurocesantia'];
  $ahorro = $_POST['ahorrovoluntario'];
  $impuesto = $_POST['impuestoalarenta'];
  $seguro = $_POST['segurovida'];
  $credito = $_POST['creditosocial'];
  $otrosdescuentos = $_POST['otrosdescuentos'];

  $mes = $_POST['mes'];
  $ano = $_POST['ano'];
  //$fechaproceso = date("Y-m-d", strtotime($_POST['fecha_proceso']));


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM bono WHERE id_bono=:bono");
   $stmt->execute(array(":bono"=>$id_bono));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO bono(id_empleado, bono_produccion, bono_responsabilidad, bono_colacion, bono_movilizacion, aguinaldo, comision_venta, asignacion_hotelera, sala_cuna, anticipo_sueldo, segundoanticipo_sueldo, anticipo_aguinaldo, prestamo_personal, reintegro_asigfamiliar, asignacion_retroactiva, otros_haberesimp, otros_haberesnoimp, seguro_cesantia, ahorro_voluntario, impuesto_renta, seguro_vida, credito_social,  otros_descuentos,  mes, ano) VALUES(:emp,:bpro,:bres,:bcol,:bmov,:agui,:com,:hotel,:sala,:ant1,:ant2,:antagui,:pres,:rein,:retro,:oimp,:onoimp,:cesa,:aho,:imp,:segu,:cred,:odesc,:mes,:ano)");

   	$stmt->bindParam(":emp",$empleado);
	  $stmt->bindParam(":bpro",$bonoproduccion);
	  $stmt->bindParam(":bres",$bonoresponsabilidad);
	  $stmt->bindParam(":bcol",$bonocolacion);
	  $stmt->bindParam(":bmov",$bonomovilizacion);
    $stmt->bindParam(":agui",$aguinaldo);
    $stmt->bindParam(":com",$comision_porventa);
    $stmt->bindParam(":hotel",$asig_hotelera);
    $stmt->bindParam(":sala",$salacuna);
    $stmt->bindParam(":ant1",$anticiposueldo1);
    $stmt->bindParam(":ant2",$anticiposueldo2);
    $stmt->bindParam(":antagui",$anticipo_aguinaldo);
    $stmt->bindParam(":pres",$prestamo);
    $stmt->bindParam(":rein",$reintegro);
    $stmt->bindParam(":retro",$retroactiva);
    $stmt->bindParam(":oimp",$otrosimp);
    $stmt->bindParam(":onoimp",$otrosnoimp);
    $stmt->bindParam(":cesa",$cesantia);
    $stmt->bindParam(":aho",$ahorro);
    $stmt->bindParam(":imp",$impuesto);
    $stmt->bindParam(":segu",$seguro);
    $stmt->bindParam(":cred",$credito);
    $stmt->bindParam(":odesc",$otrosdescuentos);
	  $stmt->bindParam(":mes",$mes);
    $stmt->bindParam(":ano",$ano);

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
    
    echo "1"; //  not available
   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
