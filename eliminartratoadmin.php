<?php

 require_once 'dbconfig.php';


  $idtrato = $_GET['id'];

 try
  { 
  
   	$stmt = $db_con->prepare("DELETE FROM trato WHERE id_trato = '$idtrato' ");


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