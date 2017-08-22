<?php
 require_once 'dbconfig.php';

 if($_POST)
 {
  $id_empleado = $_POST['empleado'];
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
  //$fecha_termino = date("Y-m-d", strtotime($_POST['fecha_termino']));
  $fecha_termino = $_POST['fecha_termino'];
  $fecha_inicio = date("Y-m-d", strtotime($_POST['fecha_inicio']));
  $sueldobase = $_POST['sueldobase'];
  $estado = $_POST['estado_empleado'];
  $tipocontrato = $_POST['tipocontrato'];

  try
  { 

    $stmt1 = $db_con->prepare("UPDATE empleado
      SET  rut_empleado=:rut, nombre_empleado=:nom, apellido_empleado=:ape, nacionalidad_empleado=:nac , fechanac_empleado=:fna, ciudadnac_empleado=:ciu, estadocivil_empleado=:eci, email_empleado=:ema, telefono_empleado=:tel, direccion_empleado=:dir, estudios_empleado=:est, cfamiliar_empleado=:cfa , salud_empleado=:sal, cargo_empleado=:car, area_empleado=:are ,fechaingreso_empleado=:ing, estado_empleado=:esta, inicio_empleado=:ini ,termino_empleado=:ter, tipo_contrato=:tipo, sueldobase_empleado=:sue WHERE empleado.id_empleado = :ide ");
    $stmt1->bindParam(":ide",$id_empleado);
    //$stmt1->bindParam(":afp",$afp_empleado);
    $stmt1->bindParam(":rut",$rut_empleado);
    $stmt1->bindParam(":nom",$nombre_empleado);
    $stmt1->bindParam(":ape",$apellido_empleado);
    $stmt1->bindParam(":nac",$nacionalidad_empleado);
    $stmt1->bindParam(":fna",$fechanac_empleado);
    $stmt1->bindParam(":ciu",$ciudad_empleado);
    $stmt1->bindParam(":eci",$ecivil_empleado);
    $stmt1->bindParam(":ema",$email_empleado);
    $stmt1->bindParam(":tel",$telefono_empleado);
    $stmt1->bindParam(":dir",$direccion_empleado);
    $stmt1->bindParam(":est",$estudios_empleado);
    $stmt1->bindParam(":cfa",$cargafamiliar_empleado);
    $stmt1->bindParam(":sal",$salud_empleado);
    $stmt1->bindParam(":car",$cargo_empleado);
    $stmt1->bindParam(":are",$area_empleado);
    $stmt1->bindParam(":ing",$fecha_ingreso);
    $stmt1->bindParam(":esta",$estado);
    $stmt1->bindParam(":ini",$fecha_inicio);
    $stmt1->bindParam(":ter",$fecha_termino);
    $stmt1->bindParam(":tipo",$tipocontrato);
    $stmt1->bindParam(":sue",$sueldobase);

    
    if($stmt1->execute()){
      echo "registered";

    }else{
        echo "Query could not execute";
    }
  }
  catch(PDOException $e){
       echo $e->getMessage();
  }
 }
?>