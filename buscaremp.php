<?php
require_once 'dbconfig.php';

if($_POST)
{
	$empleado=$_POST['idempleado'];
	
	$sql1 = "SELECT rut_empleado FROM empleado WHERE empleado.id_empleado='$empleado'";
	$result1 = $db_con->query($sql1);
	$arreglo1 = $result1->fetchAll();

	foreach ($arreglo1 as $rut){
	$rut_emp= utf8_encode($rut['rut_empleado']); 
	}
	
	$sql2 = "SELECT nombre_empleado FROM empleado WHERE empleado.id_empleado='$empleado'";
	$result2 = $db_con->query($sql2);
	$arreglo2 = $result2->fetchAll();

	foreach ($arreglo2 as $nombre){
	$nom_emp= $nombre['nombre_empleado']; 
	}

	$sql3 = "SELECT telefono_empleado FROM empleado WHERE empleado.id_empleado='$empleado'";
	$result3 = $db_con->query($sql3);
	$arreglo3 = $result3->fetchAll();

	foreach ($arreglo3 as $telefono){
	$tel_emp= $telefono['telefono_empleado']; 
	}

	$sql4 = "SELECT email_empleado FROM empleado WHERE empleado.id_empleado='$empleado'";
	$result4 = $db_con->query($sql4);
	$arreglo4 = $result4->fetchAll();

	foreach ($arreglo4 as $email){
	$email_emp= $email['email_empleado']; 
	}
	
	echo json_encode(array("rut_empleado"=>$rut_emp,"nombre_empleado"=>$nom_emp,"telefono_empleado"=>$tel_emp,"email_empleado"=>$email_emp));
}
?>
