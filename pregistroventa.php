<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$id_venta = '0';

  $fechacompra = date("Y-m-d", strtotime($_POST['fecha_venta']));
  $nfactura = $_POST['factura'];
  $rutcliente = $_POST['rutcliente'];
 	$nombrecliente = $_POST['cliente'];
 	$descripcion = $_POST['descripcion'];
 	$subtotal = $_POST['subtotal'];
 	$iva = $_POST['iva'];
 	$total = $_POST['total'];
 	$mediopago = $_POST['mediopago'];
  $fechapago = date("Y-m-d", strtotime($_POST['fecha_pago']));
  $diascheque = $_POST['diascheque'];
  $tarjeta = $_POST['nombretarjeta'];


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM venta WHERE id_venta=:ven");
   $stmt->execute(array(":ven"=>$id_venta));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO venta(numero_venta, rutcliente_venta,nombrecliente_venta,descripcion_venta,subtotal_venta, iva_venta, total_venta, mediopago_venta, fecha_venta, fechapago_venta, diascheque_venta, tarjeta_venta) VALUES(:fac,:rut,:nom,:des,:sub,:iva,:tot,:med,:fco,:fpa,:dia,:tar)");

    $stmt->bindParam(":fac",$nfactura);
   	$stmt->bindParam(":rut",$rutcliente);
	  $stmt->bindParam(":nom",$nombrecliente);
	  $stmt->bindParam(":des",$descripcion);
	  $stmt->bindParam(":sub",$subtotal);
	  $stmt->bindParam(":iva",$iva);
	  $stmt->bindParam(":tot",$total);
	  $stmt->bindParam(":med",$mediopago);
    $stmt->bindParam(":fco",$fechacompra);
    $stmt->bindParam(":fpa",$fechapago);
    $stmt->bindParam(":dia",$diascheque);
    $stmt->bindParam(":tar",$tarjeta);

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
