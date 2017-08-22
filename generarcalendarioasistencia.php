<?php  include_once 'dbconfig.php'; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/custom.css" media="print"/>
</head>
<body>

<?php
    $sql2 = "SELECT 
    empleado.rut_empleado,
    empleado.nombre_empleado,
    empleado.apellido_empleado,
    empleado.cargo_empleado,
    asistencia.fecha_asistencia,
    asistencia.tipo_asistencia,
    asistencia.horas_asistencia
    FROM asistencia
    INNER JOIN empleado
    ON asistencia.id_empleado = empleado.id_empleado
    WHERE empleado.id_empleado = '$id_empleado'
    AND asistencia.fecha_asistencia BETWEEN '$fecha1' AND '$fecha2'
    ORDER BY asistencia.fecha_asistencia ";

    $result2 = $db_con->query($sql2) or die(mysql_error());
    $arreglo_asistencia = $result2->fetchAll();

 	$numfilas =$result2->rowCount();
    if($numfilas=='0'){
    echo "<h3> No hay resultados </h3>";
    }else{

    foreach($arreglo_asistencia as $asistencia){
    echo "<tr>";
    $tipo_asistencia = $asistencia['tipo_asistencia'];
    $fechaasistencia = date("d-m-Y", strtotime($asistencia['fecha_asistencia']));
    echo "<td> $asistencia[rut_empleado] </td>"; 
    echo "<td> $asistencia[nombre_empleado] $asistencia[apellido_empleado] </td>";
    echo "<td> $asistencia[cargo_empleado] </td>";
    echo "<td> Contratado </td>";
    echo "<td> $fechaasistencia</td>";
    if($tipo_asistencia == "presente"){
    echo "<td> <i class='fa fa-check'></i> </td>";

    }else{
        echo "<td> <i class='fa fa-remove'></i> </td>";
    }
                                  
    echo "<td> $asistencia[horas_asistencia] </td>";

    ?>


<table border="0" align="center" width="100%">
	<tr>
    	<td rowspan="2" width="10%">
        	
        </td>
        <td width="90%" valign="top">
        	<h2 style="font-family:Arial, Helvetica, sans-serif" align="center">Asistencia</h2>
            <h3 style="font-family:Arial, Helvetica, sans-serif" align="center">FICHA DE ASISTENCIA MENSUAL</h3>
        </td>
	</tr>
</table>
 
<?php
$dias = array('D','L','M','M','J','V','S'); //ARRAY DE DÍAS DE LA SEMANA 
$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciciembre'); //ARRAY DE MESES DEL AÑO
?>
 
<p align="center">
  <table border="0" cellpadding="2" cellspacing="2" width="100%" class="fuente">
        <tr>
        	<td align="right"><strong>Periodo:</strong></td>
            <td align="left"><?=$meses[$_GET['fecha_month']]?> - <?=$_GET['fecha_year']?></td>
            <td>&nbsp;</td>
            <td align="right"><strong>Empleado:</strong></td>
            <td align="left"><?php $asistencia[nombre_empleado] ?></td>
            <td>&nbsp;</td>
            <td align="right"><strong>Grado:</strong></td>
            <td align="left"></td>
            <td>&nbsp;</td>
            <td align="right"><strong>Secci&oacute;n:</strong></td>
            <td align="left"></td>
        </tr>
  </table>
</p>
 
<table border="1" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; ; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px">
	<tr>
    	<td align="center" width="5%" style="; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px">N°</td>
    	<td align="center" width="28%" style="; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px"><strong>Alumno</strong></td>
        <?php
			//-----------------------------------------------------------------------------			
			$limite_mes = date('t', mktime(0, 0, 0, $_GET['fecha_month'], 1, $_GET['fecha_year'])); //ÚLTIMO DÍA DEL MES
			$fecha_base = "01-".$_GET['fecha_month']."-".$_GET['fecha_year']; //FECHA DE PARTIDA DEL MES
			$dia_sem = date("w",strtotime($fecha_base)); //DÍA DE LA SEMANA DE LA FECHA DE PARTIDA DEL MES
 
			$fecha_inicio = $_GET['fecha_year']."-".$_GET['fecha_month']."-01"; //FECHA DE INICIO PARA LA BÚSQUEDA EN LA BD
			$fecha_fin = $_GET['fecha_year']."-".$_GET['fecha_month']."-".$limite_mes; //FECHA FINAL PARA LA BÚSQUEDA EN LA BD
			//------------------------------------------------------------------------------
 
			//EMPIEZA LA IMPRESIÓN DE LAS CABECERAS
			for ($j=0;$j<$limite_mes;$j++) { //Genero los divisiones de la semana
				if ($dia_sem>6){ $dia_sem = 0; } // Con esto reinicio los dias de Sabado a Domingo.
				?>
				<div class="cuadro<? if ($dia_sem==0) { echo " rojo"; } else { echo " verde"; } // Verifico si es domingo entonces ?>" align="center">
					<?php
                    $actual = date('d-m-Y', strtotime($fecha_base. '+'.$j.' day'));
                    list($dia, $mes, $year) = split('[/.-]', $actual); //Separo los dias
                    $cero = substr($mes,0,1);
                    if ($cero==0) { $mesreal = substr($mes,-1,1); } else { $mesreal = $mes; }
 
					if($dia_sem == 0){
						$color = "#F06";
					}
					else{
						$color = "#FFF";
					}
                    ?>
                        <td style="background:<?=$color?>; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px" align="center"><?=$dias[$dia_sem]."<br />".$dia?></td>
                    <?php
                    $dia_sem++;
                    $dia++;
                    ?>
                </div>
                <?php
			}
			?>
    </tr>
 
        <?php
		$nro = 1;
 
		//AHORA SE IMPRIMEN LOS NOMBRES DE ALUMNOS Y LOS ESTADOS DE ASISTENCIA
		do{
			$id_alu = $asistencia['rut_empleado'];
		?>
        	<tr>
            	<td align="center" style="; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px"><?=$nro?></td>
            	<td align="center" style="; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px"><?=utf8_encode($asistencia['nombre_empleado'])?>&nbsp;<?=utf8_encode($asistencia['apellido_empleado'])?></td>
 
                <?php
					$actual2 = $_GET['fecha_year']."-".$_GET['fecha_month']."-01";
 
					for($z=1;$z<=$limite_mes;$z++){
						//BUSCANDO ASISTENCIA
						mysql_select_db($database_cnx_WebApp, $cnx_WebApp);
						$query_rsAsistencia = "SELECT * FROM asistencia WHERE Fecha_Asi = '".$actual2."' AND IdAlumno_Asi = ".$id_alu;
						$rsAsistencia = mysql_query($query_rsAsistencia, $cnx_WebApp) or die(mysql_error());
						$row_rsAsistencia = mysql_fetch_assoc($rsAsistencia);
						$totalRows_rsAsistencia = mysql_num_rows($rsAsistencia);

						$dia_sem2 = date("w", strtotime($actual2));
						
						if($dia_sem2 == 0){
							$color = "#F06";
						}
						else{
							$color = "#FFF";
						}
						
						switch($asistencia['tipo_asistencia']){
							case 1:
								$estado = "P";
							break;
							
							case 2:
								$estado = "TJ";
							break;
							
						}
						
						//SI EL ID DEL ALUMNO EN LA TABLA ASISTENCIA COINCIDE CON EL DE LA TABLA ALUMNOS Y LA FECHA EN LA BASE COINCIDE CON LA FECHA MOMENTÁNEA
						if($totalRows_rsAsistencia>0){
						?>
							<td style="background:<?=$color?>;; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px" align="center"><?=$estado?></td>
						<?php
						}
						else{
						?>
                            <td style="background:<?=$color?>;; border:#333; border-bottom:#000 solid 1px; border-left:#000 solid 1px; border-right:#000 solid 1px; border-top:#000 solid 1px" align="center">&nbsp;</td>
                           <?php
						}
 
						$actual2 = date('Y-m-d', strtotime($actual2. '+ 1 day'));
					}
				?>
            </tr>
        <?php
		$nro++;
		}while($row_rsAlumnos = mysql_fetch_assoc($rsAlumnos));
        ?>
</table>
<br />
<table border="0" align="center">
	<tr>
    	<td align="center" style="background:#0F0"><strong>P: Presente</strong></td>
        <td>&nbsp;</td>
 
        <td align="center" style="background:#F60"><strong><font color="#FFFFFF">TJ: Tardanza Justificada</font></strong></td>
        <td>&nbsp;</td>
 
        <td align="center" style="background:#FF0"><strong>TI: Tardanza Injustificada</strong></td>
        <td>&nbsp;</td>
 
        <td align="center" style="background:#0FF"><strong>FJ: Falta Justificada</strong></td>
        <td>&nbsp;</td>
 
        <td align="center" style="background:#F00"><strong><font color="#FFFFFF">FI: Falta Injustificada</font></strong></td>
        <td>&nbsp;</td>
    </tr>
</table>

    <?php
    }

    }
    ?>
 
<div id="print">
<p><a href="javascript:print()" title="Imprimir asistencia" class="linksrojo fuente"><img src="../img/icono_print.png" border="0" /><strong>Imprimir</strong></a></p>
</div>
</body>
</html>