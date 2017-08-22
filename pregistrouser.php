<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
  $user_name = $_POST['nombre'];
  $user_rut = $_POST['rut'];
  $user_password = md5($_POST['pass']);
  $user_email=$_POST['email'];
  //$user_estado='1';
  $user_tele=$_POST['telefono'];

  if(empty($_POST['tipousuario'])) {
    $tipo = "normal";
    
  }else{
    $tipo = $_POST['tipousuario'];
  }
  

  $joining_date =date('Y-m-d H:i:s');
  
  try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM usuario WHERE rut=:rut");
   $stmt->execute(array(":rut"=>$user_rut));
   $count = $stmt->rowCount();
   
   if($count==0){
    
   $stmt = $db_con->prepare("INSERT INTO usuario(nombre_usuario,rut,password,telefono,mail,permiso,joining_date) VALUES(:uname,:urut,:pass,:utel,:uem,:perm,:jdate)");
   $stmt->bindParam(":uname",$user_name);
   $stmt->bindParam(":urut",$user_rut);
   $stmt->bindParam(":pass",$user_password);
   $stmt->bindParam(":utel",$user_tele);
   $stmt->bindParam(":uem",$user_email);
   $stmt->bindParam(":perm",$tipo);
   $stmt->bindParam(":jdate",$joining_date);


     
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
    
    echo "Rut usuario ya registrado"; //  not available
   }
    
  }
  catch(PDOException $e){
       echo $e->getMessage();
  }
 }

?>