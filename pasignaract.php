<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
  $idactividad = '0';

 	$producto = $_POST['producto'];
 	$actividad = $_POST['actividad'];
  $precio = $_POST['precio'];


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM actividad_producto WHERE id_actividad=:act AND id_producto=:pro");
   $stmt->execute(array(":act"=>$actividad,":pro"=>$producto));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO actividad_producto(id_actividad,id_producto,precio) VALUES(:act,:pro,:pre)");

   	$stmt->bindParam(":act",$actividad);
	  $stmt->bindParam(":pro",$producto);
    $stmt->bindParam(":pre",$precio);


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
    echo "Ya tiene registrado la actividad para aquél producto seleccionado"; //  not available

   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
