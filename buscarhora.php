<?php
require_once 'dbconfig.php';

if($_POST)
{
	$emp=$_POST['empleado'];
	$fecha=date("Y-m-d", strtotime($_POST['fecha']));
	
	$sql1 = "SELECT horas_asistencia FROM asistencia 
			WHERE id_empleado='$emp' 
			AND fecha_asistencia='$fecha' ";
	$result1 = $db_con->query($sql1);
	$arreglo1 = $result1->fetchAll();

	foreach ($arreglo1 as $asistencia){
	$hora= $asistencia['horas_asistencia']; 
	}
	
	echo json_encode(array("hora"=>$hora));
}
?>