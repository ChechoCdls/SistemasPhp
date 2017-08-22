<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$id_compra = '0';

  $fechacompra = date("Y-m-d", strtotime($_POST['fecha_compra']));
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
  
   $stmt = $db_con->prepare("SELECT * FROM compra WHERE id_compra=:com");
   $stmt->execute(array(":com"=>$id_compra));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO compra(numero_compra, rutcliente_compra,nombrecliente_compra,descripcion_compra,subtotal_compra, iva_compra, total_compra, mediopago_compra, fecha_compra, fechapago_compra, diascheque_compra, tarjeta_compra) VALUES(:fac,:rut,:nom,:des,:sub,:iva,:tot,:med,:fco,:fpa,:dia,:tar)");

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
