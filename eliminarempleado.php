<?php

 require_once 'dbconfig.php';


  $idemp = $_GET['id'];

 try
  { 
  
   	$stmt = $db_con->prepare("DELETE FROM empleado WHERE id_empleado = '$idemp' ");


   	if($stmt->execute())
    {
     header("Location: verempleadosadmin.php");
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