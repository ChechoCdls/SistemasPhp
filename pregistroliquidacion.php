<?php

 require_once 'dbconfig.php';

 if($_POST)
 {
 	$empleado = $_POST['idempleado'];
  //$empleado = '10';

  $sueldomes = $_POST['sueldomes'];
  $gratificacion = $_POST['gratificacion'];
  $hextras = $_POST['hextras'];
  $tratos = $_POST['tratos'];
  $bproduccion = $_POST['bproduccion'];
  $bresponsabilidad = $_POST['bresponsabilidad'];
  $aguinaldo = $_POST['aguinaldo'];
  $comisionventas = $_POST['comisionventas'];
  $asighotelera = $_POST['asighotelera'];
  $otroshaberes = $_POST['otroshaberes'];
  $totalhaberesimp = $_POST['totalhaberesimp'];
  $reasignacionfamiliar = $_POST['reasignacionfamiliar'];
  $asigfamiliar = $_POST['asigfamiliar'];
  $asigretroactiva = $_POST['asigretroactiva'];
  $colacion = $_POST['colacion'];
  $movilizacion = $_POST['movilizacion'];
  $salacuna = $_POST['salacuna'];
  $otroshaberesnoimp = $_POST['otroshaberesnoimp'];
  $totalhaberesnoimp = $_POST['totalhaberesnoimp'];
  $afp = $_POST['afp'];
  $salud = $_POST['salud'];
  $segurocesantia = $_POST['segurocesantia'];
  $ahorroafp = $_POST['ahorroafp'];
  $impuestorenta = $_POST['impuestorenta'];
  $totaldescuentoslegales = $_POST['totaldescuentoslegales'];
  $segurovida = $_POST['segurovida'];
  $csocial = $_POST['csocial'];
  $prestamopersonal = $_POST['prestamopersonal'];
  $anticipoaguinaldo = $_POST['anticipoaguinaldo'];
  $anticiposueldo = $_POST['anticiposueldo'];
  $segundoanticipo = $_POST['segundoanticipo'];
  $otrosdescuentos = $_POST['otrosdescuentos'];
  $totalotrosdescuentos = $_POST['totalotrosdescuentos'];
  $totalhaberes = $_POST['totalhaberes'];
  $totaldescuentos = $_POST['totaldescuentos'];
  $sueldoliquido = $_POST['sueldoliquido'];
  $mes = $_POST['mes'];
  $ano = $_POST['ano'];

  //$fechaasistencia = '30-06-2017';


 try
  {
  
   $stmt = $db_con->prepare("SELECT * FROM liquidacion WHERE id_empleado=:emp AND mes=:mes AND ano=:an ");
   $stmt->execute(array(":emp"=>$empleado,":mes"=>$mes,":an"=>$ano));
   $count = $stmt->rowCount();
   
   if($count==0){

    $stmt = $db_con->prepare("INSERT INTO liquidacion(id_empleado,sueldomes,gratificacion,horasextras,tratos,bonoproduccion,bonoresponsabilidad,aguinaldo,comisionventa,asighotelera,otroshaberes,totalhaberes_imponible,reintegro_asigfamiliar,asignacion_familiar,asignacion_retroactiva,bonocolacion,bonomovilizacion,salacuna,otroshaberenoimp,totalhaberes_noimponible,afp,salud,seguro_cesantia,ahorrovoluntario_afp, impuesto_renta,totaldescuentos_legales,segurovida,creditosocial,prestamo,anticipo_aguinaldo,anticiposueldo, anticiposueldo2,otrosdescuentos,total_otrosdescuentos,totalhaberes,totaldescuentos,sueldoliquido,mes,ano) VALUES(:emp,:smes,:gra,:hex,:tra,:bpr,:bre,:agu,:com,:hote,:ohab,:thi,:raf,:afa,:are,:col,:mov,:scu,:ohni,:thni,:afp,:sal,:sce,:ahr,:imp,:dcl,:svi,:cso,:pre,:aag,:asu,:sas,:odc,:todc,:thab,:tdc,:sli,:mes,:ano)");

  $stmt->bindParam(":emp",$empleado);
  $stmt->bindParam(":smes",$sueldomes);

  $stmt->bindParam(":gra",$gratificacion);
  $stmt->bindParam(":hex",$hextras);
  $stmt->bindParam(":tra",$tratos);
  $stmt->bindParam(":bpr",$bproduccion);
  $stmt->bindParam(":bre",$bresponsabilidad);  
  
  $stmt->bindParam(":agu",$aguinaldo);
  $stmt->bindParam(":com",$comisionventas);
  $stmt->bindParam(":hote",$asighotelera);
  $stmt->bindParam(":ohab",$otroshaberes);
  $stmt->bindParam(":thi",$totalhaberesimp);
  $stmt->bindParam(":raf",$reasignacionfamiliar);
  $stmt->bindParam(":afa",$asigfamiliar);
  $stmt->bindParam(":are",$asigretroactiva);
  $stmt->bindParam(":col",$colacion);
  $stmt->bindParam(":mov",$movilizacion);

  $stmt->bindParam(":scu",$salacuna);
  $stmt->bindParam(":ohni",$otroshaberesnoimp);
  $stmt->bindParam(":thni",$totalhaberesnoimp);
  $stmt->bindParam(":afp",$afp);
  $stmt->bindParam(":sal",$salud);
  $stmt->bindParam(":sce",$segurocesantia);
  $stmt->bindParam(":ahr",$ahorroafp);
  $stmt->bindParam(":imp",$impuestorenta);
  $stmt->bindParam(":dcl",$totaldescuentoslegales);
   
  $stmt->bindParam(":svi",$segurovida);
  $stmt->bindParam(":cso",$csocial);
  $stmt->bindParam(":pre",$prestamopersonal);
  $stmt->bindParam(":aag",$anticipoaguinaldo);
  $stmt->bindParam(":asu",$anticiposueldo);
  $stmt->bindParam(":sas",$segundoanticipo);
  $stmt->bindParam(":odc",$otrosdescuentos);
  $stmt->bindParam(":todc",$totalotrosdescuentos);

  $stmt->bindParam(":thab",$totalhaberes);
  $stmt->bindParam(":tdc",$totaldescuentos);
  $stmt->bindParam(":sli",$sueldoliquido);
    
  $stmt->bindParam(":mes",$mes);
  
  $stmt->bindParam(":ano",$ano);
  


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
    
    echo "Ya generó una liquidación para este empleado y período"; //  not available
   }
   

  }
  catch(PDOException $e){
       echo $e->getMessage();
  }

}
