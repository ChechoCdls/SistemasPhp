<?php

 require_once 'dbconfig.php';

 if($_POST)
 {

 	$producto = $_POST['nombreproducto'];
 	$descripcion = $_POST['descripcion'];


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM producto WHERE nombre_producto=:pro");
   $stmt->execute(array(":pro"=>$producto));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO producto(nombre_producto,descripcion_producto) VALUES(:pro,:des)");

   	$stmt->bindParam(":pro",$producto);
	  $stmt->bindParam(":des",$descripcion);


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
    
    echo "Nombre de producto ya registrado"; //  not available
   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
