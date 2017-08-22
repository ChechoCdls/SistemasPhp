<?php

 require_once 'dbconfig.php';

 if($_POST)
 {

  $fecha_ingreso = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
  $rut_empleado = $_POST['rut_empleado'];
  $nombre_empleado = $_POST['nombre_empleado'];
  $apellido_empleado = $_POST['apellido_empleado'];
  $nacionalidad_empleado = $_POST['nacionalidad_empleado'];
  $fechanac_empleado = date("Y-m-d", strtotime($_POST['nacimiento_empleado']));
  $ciudad_empleado = $_POST['ciudad_empleado'];
  $ecivil_empleado = $_POST['ecivil_empleado'];
  $email_empleado = $_POST['email_empleado'];
  $telefono_empleado = $_POST['telefono_empleado'];
  $direccion_empleado = $_POST['direccion_empleado'];
  $estudios_empleado = $_POST['estudios_empleado'];
  $cargafamiliar_empleado = $_POST['cfamiliar_empleado'];
  $afp_empleado = $_POST['afp_empleado'];
  $salud_empleado = $_POST['salud_empleado'];
  $cargo_empleado = $_POST['cargo_empleado'];
  $area_empleado = $_POST['area_empleado'];
  $estado_empleado = '1';
  //$fecha_termino = date("Y-m-d", strtotime($_POST['fecha_termino']));
  $fecha_termino = $_POST['fecha_termino'];
  $fecha_inicio = date("Y-m-d", strtotime($_POST['fecha_inicio']));
  $sueldobase = $_POST['sueldobase'];
  $tipocontrato = $_POST['tipocontrato'];
  
  try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM empleado WHERE rut_empleado=:rut");
   $stmt->execute(array(":rut"=>$rut_empleado));
   $count = $stmt->rowCount();
   
   if($count==0){
    
   $stmt = $db_con->prepare("INSERT INTO empleado(id_afp,rut_empleado,nombre_empleado,apellido_empleado,nacionalidad_empleado, fechanac_empleado,ciudadnac_empleado,estadocivil_empleado,email_empleado,telefono_empleado,direccion_empleado,estudios_empleado,cfamiliar_empleado,salud_empleado,cargo_empleado,area_empleado,fechaingreso_empleado,estado_empleado,inicio_empleado,termino_empleado,tipo_contrato,sueldobase_empleado) VALUES(:empafp,:emprut,:empnom,:empape,:empnac,:empfnac,:empciud,:empecivil,:empema,:emptel,:empdir,:empest,:empcfam,:empsalud,:empcar,:empar,:empfing,:empesta,:fini,:fter,:tcont,:sueldo)");

   //echo $stmt;
   $stmt->bindParam(":empafp",$afp_empleado);
   $stmt->bindParam(":emprut",$rut_empleado);
   $stmt->bindParam(":empnom",$nombre_empleado);
   $stmt->bindParam(":empape",$apellido_empleado);
   $stmt->bindParam(":empnac",$nacionalidad_empleado);
   $stmt->bindParam(":empfnac",$fechanac_empleado);
   $stmt->bindParam(":empciud",$ciudad_empleado);
   $stmt->bindParam(":empecivil",$ecivil_empleado);
   $stmt->bindParam(":empema",$email_empleado);
   $stmt->bindParam(":emptel",$telefono_empleado);
   $stmt->bindParam(":empdir",$direccion_empleado);
   $stmt->bindParam(":empest",$estudios_empleado);
   $stmt->bindParam(":empcfam",$cargafamiliar_empleado);
   $stmt->bindParam(":empsalud",$salud_empleado);
   $stmt->bindParam(":empcar",$cargo_empleado);
   $stmt->bindParam(":empar",$area_empleado);
   $stmt->bindParam(":empfing",$fecha_ingreso);
   $stmt->bindParam(":empesta",$estado_empleado);
   $stmt->bindParam(":fini",$fecha_inicio);
   $stmt->bindParam(":fter",$fecha_termino);
   $stmt->bindParam(":tcont",$tipocontrato);
   $stmt->bindParam(":sueldo",$sueldobase);

     
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
    
    echo "Rut de empleado ya registrado"; //  not available
   }
    
  }
  catch(PDOException $e){
       echo $e->getMessage();
  }
 }

?>