<?php

 require_once 'dbconfig.php';

 if($_POST)
 {


 	$actividad = $_POST['actividad'];
 	$descripcion = $_POST['descripcion'];


 try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM actividad WHERE nombre_actividad=:act");
   $stmt->execute(array(":act"=>$actividad));
   $count = $stmt->rowCount();
   
   if($count==0){

   	$stmt = $db_con->prepare("INSERT INTO actividad(nombre_actividad,descripcion_actividad) VALUES(:act,:des)");

   	$stmt->bindParam(":act",$actividad);
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
    
    echo "Nombre de actividad ya registrado"; //  not available
   }

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
