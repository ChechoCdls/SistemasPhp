<?php

//getcolegio y get carrera tambien
 $db_host = "localhost"; //NOMBRE DEL HOST
 $db_name = "comercialdelmar"; //NOMBRE DE LA BASE DE DATOS
 $db_user = "root"; //NOMBRE DEL USUARIO DE LA BASE DE DATOS
 $db_pass = "12345678"; //CONTRASEÑA DEL USUARIO DE LA BASE DE DATOS
 
 try{

 	
  
  $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 

 }
 catch(PDOException $e){
       echo $e->getMessage();
 }

?>