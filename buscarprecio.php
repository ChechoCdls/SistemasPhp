<?php
require_once 'dbconfig.php';

if($_POST)
{
	$prod=$_POST['producto'];
	$acti=$_POST['actividad'];
	
	$sql1 = "SELECT precio FROM actividad_producto 
			WHERE actividad_producto.id_producto='$prod' 
			AND actividad_producto.id_actividad='$acti' ";
	$result1 = $db_con->query($sql1);
	$arreglo1 = $result1->fetchAll();

	foreach ($arreglo1 as $valorkilo){
	$precio= $valorkilo['precio']; 
	}
	
	echo json_encode(array("precio"=>$precio));
}
?>