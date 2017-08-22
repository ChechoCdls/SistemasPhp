<?php
include_once 'dbconfig.php';


$liquidacion= $_GET['id'];
//echo $liquidacion;

$sql1 = "SELECT * FROM liquidacion 
		INNER JOIN empleado 
		ON liquidacion.id_empleado = empleado.id_empleado 
		WHERE id_liquidacion = '$liquidacion' ";
$result1 = $db_con->query($sql1) or die(mysql_error());
$arreglo_liquidacion = $result1->fetchAll();
foreach ($arreglo_liquidacion as $liquidacion) {
 $id_empleado =  $liquidacion['id_empleado'];
 $mes = $liquidacion['mes'];
 $ano = $liquidacion['ano'];
 $nombre_emp = $liquidacion['nombre_empleado'];
 $apellido_emp = $liquidacion['apellido_empleado'];
 $rut_emp = $liquidacion['rut_empleado'];
 $cargo_emp = $liquidacion['cargo_empleado'];
 $salud_empleado = $liquidacion['salud_empleado'];
 $fechaingreso_emp = date("d-m-Y", strtotime($liquidacion['fechaingreso_empleado']));
 $sueldo_base = $liquidacion['sueldobase_empleado'];
 $gratificacion = $liquidacion['gratificacion'];
 $sueldomes = $liquidacion['sueldomes'];
 $horasextras = $liquidacion['horasextras'];
 $bonoproduccion = $liquidacion['bonoproduccion'];
 $bonoresponsabilidad = $liquidacion['bonoresponsabilidad'];
 $aguinaldo = $liquidacion['aguinaldo'];
 $comision = $liquidacion['comisionventa'];
 $hotelera = $liquidacion['asighotelera'];
 $otroshaberes = $liquidacion['otroshaberes'];
 $totalhaberesimponible = $liquidacion['totalhaberes_imponible'];
 $reintegro = $liquidacion['reintegro_asigfamiliar'];
 $asigfamiliar = $liquidacion['asignacion_familiar'];
 $retroactiva = $liquidacion['asignacion_retroactiva'];
 $colacion = $liquidacion['bonocolacion'];
 $movilizacion = $liquidacion['bonomovilizacion'];
 $salacuna = $liquidacion['salacuna'];
 $otroshnoimp = $liquidacion['otroshaberenoimp'];
 $totalhnoimp = $liquidacion['totalhaberes_noimponible'];
 $pagoafp = $liquidacion['afp'];
 $salud = $liquidacion['salud'];
 $seguro = $liquidacion['seguro_cesantia'];
 $ahorrovol = $liquidacion['ahorrovoluntario_afp'];
 $impuesto = $liquidacion['impuesto_renta'];
 $dctolegales = $liquidacion['totaldescuentos_legales'];
 $segurovida = $liquidacion['segurovida'];
 $credito = $liquidacion['creditosocial'];
 $prestamo = $liquidacion['prestamo'];
 $anticipoaguinaldo = $liquidacion['anticipo_aguinaldo'];
 $anticiposueldo = $liquidacion['anticiposueldo'];
 $segundoanticiposueldo = $liquidacion['anticiposueldo2'];
 $otrosdescuentos = $liquidacion['otrosdescuentos'];
 $totalotrosdescuentos = $liquidacion['total_otrosdescuentos'];
 $totalhaberes = $liquidacion['totalhaberes'];
 $totaldescuentos = $liquidacion['totaldescuentos'];
 $sueldoliquido = $liquidacion['sueldoliquido'];
 $pagotrato = $liquidacion['tratos'];
}

//dias trabajados
$stmt1 = $db_con->prepare("SELECT * FROM asistencia WHERE Month(fecha_asistencia)='$mes' AND id_empleado='$id_empleado' AND tipo_asistencia='presente' ");
$stmt1->execute();
$contdiastrabajados = $stmt1->rowCount();

//afp
$sql2 = "SELECT * FROM empleado
		INNER JOIN afp
		ON empleado.id_afp = afp.id_afp
		WHERE id_empleado='$id_empleado' ";
$result2 = $db_con->query($sql2) or die(mysql_error());
$arreglo_afp = $result2->fetchAll();
foreach ($arreglo_afp as $afp) {
$nombre_afp =  $afp['nombre_afp'];
}

//salud

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Liquidación de Sueldo</title>
<script language="JavaScript">
function BefPrt(){
	document.all.btnSig.style.display = 'none';
	var oObj = document.all.tags("TD");
	if (oObj!=null){
		for (var i=0; i<oObj.length; i++) 
			oObj[i].style.borderBottomStyle = "none";
	}
}
function AftPrt(){
	document.all.btnSig.style.display = '';
	var oObj = document.all.tags("TD");
	if (oObj!=null){
		for (var i=0; i<oObj.length; i++) 
			oObj[i].style.borderBottomStyle = "solid";
	}
}
</script>
</head>
<body onbeforeprint="BefPrt();" onafterprint="AftPrt();" onload="window.print();">

<form name="form1" action="EmiBolLiqui.ASP?WCI=wiBolLiqui&amp;WCE=form1&amp;WCU" method="post">

	<DIV style=" LEFT: 0cm; WIDTH: 21cm; POSITION: relative; TOP: 0cm; HEIGHT: 26cm">
	<SPAN onclick="seleccionaCampo('FCodLegal01');" id=FCodLegal01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 152px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 133px; WIDTH: 152px"><?php echo $rut_emp ?></span>
	<SPAN onclick="seleccionaCampo('FFecIniContrato01');" id=FFecIniContrato01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 494px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 152px; WIDTH: 190px"><?php echo $fechaingreso_emp ?></span>
	<SPAN onclick="seleccionaCampo('FIDAFP01');" id=FIDAFP01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 247px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 171px">AFP <?php echo $nombre_afp ?></span>
	<SPAN onclick="seleccionaCampo('FIDCNegocio01');" id=FIDCNegocio01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 494px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 133px; WIDTH: 190px">DELMAR CQBO.</span>
	<SPAN onclick="seleccionaCampo('FIDIsapre01');" id=FIDIsapre01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 505px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 152px"><?php echo $salud_empleado ?></span>
	<SPAN onclick="seleccionaCampo('FNomCompleto01');" id=FNomCompleto01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 114px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 114px; WIDTH: 380px"><?php echo $nombre_emp.' '.$apellido_emp ?></span>
	<SPAN onclick="seleccionaCampo('DAno01');" id=DAno01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: right; LEFT: 532px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 68px; WIDTH: 57px"><?php echo $ano ?></span>
	<SPAN onclick="seleccionaCampo('DMes01');" id=DMes01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: center; LEFT: 399px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 68px; WIDTH: 114px"><?php echo $mes ?></span>
	<SPAN onclick="seleccionaCampo('CCARGO01');" id=CCARGO01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 152px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 152px; WIDTH: 190px"><?php echo $cargo_emp ?></span>
	<SPAN onclick="seleccionaCampo('MADTMES01');" id=MADTMES01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 152px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 0px"><?php echo $contdiastrabajados ?></span>
	<SPAN onclick="seleccionaCampo('MSL01');" id=MSL01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 114px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 703px; WIDTH: 76px"><?php echo $sueldoliquido ?></span>
	<SPAN onclick="seleccionaCampo('MSL02');" id=MSL02 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 190px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 703px; WIDTH: 380px">doscientos ochenta y seis mil doscientos treinta </span>
	<SPAN onclick="seleccionaCampo('MSL03');" id=MSL03 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: right; LEFT: 494px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 677px; WIDTH: 114px"><?php echo $sueldoliquido ?></span>
	<SPAN onclick="seleccionaCampo('MTD01');" id=MTD01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: right; LEFT: 494px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 647px; WIDTH: 114px"><?php echo $totaldescuentos ?></span>
	<SPAN onclick="seleccionaCampo('MTH02');" id=MTH02 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: right; LEFT: 171px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 647px; WIDTH: 133px"><?php echo $totalhaberes ?></span>
	<SPAN onclick="seleccionaCampo('NCodLegal01');" id=NCodLegal01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 0px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 19px; WIDTH: 380px">76108516-6</span>
	<SPAN onclick="seleccionaCampo('NDireccion01');" id=NDireccion01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 0px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 38px; WIDTH: 380px">Los Albañiles 1240 Coquimbo -  Suc. Palacio Riesco 4325 Huechuraba</span>
	<SPAN onclick="seleccionaCampo('NNombre01');" id=NNombre01 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 0px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 0px; WIDTH: 342px">Sociedad Comercial Delmar Limitada</span></span></span></span></span></span>
	<SPAN onclick="seleccionaCampo('TTexto01');" id=TTexto01 style="CURSOR: hand; FONT-SIZE: 14px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 114px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 68px; WIDTH: 304px">LIQUIDACION&nbspDE&nbspREMUNERACIONES</span>
	<SPAN onclick="seleccionaCampo('TTexto02');" id=TTexto02 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 114px; WIDTH: 95px">NOMBRE:</span>
	<SPAN onclick="seleccionaCampo('TTexto03');" id=TTexto03 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 133px; WIDTH: 95px">R.U.T:</span>
	<SPAN onclick="seleccionaCampo('TTexto04');" id=TTexto04 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: center; LEFT: 76px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 209px; WIDTH: 228px">DETALLE&nbspDE&nbspHABERES</span>
	<SPAN onclick="seleccionaCampo('TTexto05');" id=TTexto05 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: right; LEFT: 380px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 209px; WIDTH: 228px">DETALLE&nbspDE&nbspDESCUENTOS</span>
	<SPAN onclick="seleccionaCampo('TTexto06');" id=TTexto06 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 152px; WIDTH: 95px">CARGO:</span>
	<SPAN onclick="seleccionaCampo('TTexto07');" id=TTexto07 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 342px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 152px; WIDTH: 114px">FECHA&nbspINGRESO:</span>
	<SPAN onclick="seleccionaCampo('TTexto08');" id=TTexto08 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 342px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 133px; WIDTH: 190px">CENTRO&nbspDE&nbspNEGOCIOS:</span>
	<SPAN onclick="seleccionaCampo('TTexto09');" id=TTexto09 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 83px; WIDTH: 722px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto10');" id=TTexto10 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 79px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto11');" id=TTexto11 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 190px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto12');" id=TTexto12 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 212px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto13');" id=TTexto13 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 186px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto14');" id=TTexto14 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 628px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto15');" id=TTexto15 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 76px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 647px; WIDTH: 114px">TOTAL&nbspHABERES</span>
	<SPAN onclick="seleccionaCampo('TTexto16');" id=TTexto16 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 660px; WIDTH: 532px">______________________________________________________________________________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto17');" id=TTexto17 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 684px; WIDTH: 380px">Certifico&nbspque&nbsphe&nbsprecibido</span>
	<SPAN onclick="seleccionaCampo('TTexto18');" id=TTexto18 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 703px; WIDTH: 95px">la&nbspsuma&nbspde&nbsp$</span>
	<SPAN onclick="seleccionaCampo('TTexto19');" id=TTexto19 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 722px; WIDTH: 456px">a&nbspmi&nbspentera&nbspsatisfaccion&nbspy&nbspno&nbsptengo&nbspcargo&nbspni&nbspcobro&nbspalguno&nbspposterior&nbspque&nbsphacer,</span>
	<SPAN onclick="seleccionaCampo('TTexto20');" id=TTexto20 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 741px; WIDTH: 380px">por&nbspninguno&nbspde&nbsplos&nbspconceptos&nbspcomprendidos&nbspen&nbspesta&nbspliquidación.&nbsp</span>
	<SPAN onclick="seleccionaCampo('TTexto25');" id=TTexto25 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 380px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 647px; WIDTH: 152px">TOTAL&nbspDESCUENTOS:</span>
	<SPAN onclick="seleccionaCampo('TTexto26');" id=TTexto26 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: bold; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 380px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 677px; WIDTH: 133px">SUELDO&nbspLIQUIDO:</span>
	<SPAN onclick="seleccionaCampo('TTexto30');" id=TTexto30 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 38px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 114px">D/TRABAJADOS:</span>
	<SPAN onclick="seleccionaCampo('TTexto31');" id=TTexto31 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 456px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 798px; WIDTH: 190px">__________________________</span>
	<SPAN onclick="seleccionaCampo('TTexto32');" id=TTexto32 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: center; LEFT: 456px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 817px; WIDTH: 190px">RECIBI&nbspCONFORME</span>
	<SPAN onclick="seleccionaCampo('TTexto33');" id=TTexto33 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 209px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 76px">A.F.P:</span>
	<SPAN onclick="seleccionaCampo('TTexto34');" id=TTexto34 style="CURSOR: hand; FONT-SIZE: 12px; BORDER-TOP: white 0px solid; HEIGHT: 19px; FONT-FAMILY: Tahoma; BORDER-RIGHT: white 0px solid; BORDER-BOTTOM: white 0px solid; POSITION: absolute; FONT-WEIGHT: normal; COLOR: #000000; FONT-STYLE: normal; TEXT-ALIGN: left; LEFT: 418px; BORDER-LEFT: white 0px solid; DISPLAY: inline; TOP: 171px; WIDTH: 95px">INST.&nbspSALUD:</span>

	<SPAN STYLE="COLOR:#000000;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:230px;WIDTH:228px;text-align:left" id="Span1Det" onclick="SeleccionaCampoDet(this.id)">SUELDO BASE.:</span>
	<SPAN STYLE="COLOR:#000000;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:230px;WIDTH:228px;text-align:right" id="Span2Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $sueldo_base ?></span>
	

	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:245px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">SUELDO MES:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:245px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $sueldomes ?></span>


	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:265px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">GRATIF. MENSUAL:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:265px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $gratificacion ?></span>


	<?php 
	if ($horasextras == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:280px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">HORAS EXTRAS:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:280px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $horasextras ?></span>
	<?php
	}	
	?>

	<?php 
	if ($horasextras == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:300px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">TRATOS:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:300px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $pagotrato ?></span>
	<?php
	}	
	?>
	
	<?php 
	if ($bonoproduccion == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:325px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">BONO PRODUCCIÓN:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:325px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $bonoproduccion ?></span>
	<?php
	}	
	?>
	
	<?php 
	if ($bonoresponsabilidad == 0){

	}else{
	?>	
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:345px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">BONO RESPONSABILIDAD:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:345px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $bonoresponsabilidad ?></span>
	<?php
	}	
	?>

	<?php 
	if ($aguinaldo == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:365px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">AGUINALDO:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:365px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $aguinaldo ?></span>
	<?php
	}	
	?>


	<?php 
	if ($comision == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:385px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">COMISIÓN POR VENTAS:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:385px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $comision ?></span>
	<?php
	}	
	?>


	<?php 
	if ($hotelera == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:405px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">ASIG. HOTELERA:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:405px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $hotelera ?></span>
	<?php
	}	
	?>

	<?php 
	if ($otroshaberes == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:425px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">OTROS HABERES:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:425px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $otroshaberes ?></span>
	<?php
	}	
	?>


	<?php 
	if ($comision == 0 && $hotelera == 0 && $otroshaberes == 0){
	?>
		<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:405px;WIDTH:228px;text-align:left" id="Span25Det" onclick="SeleccionaCampoDet(this.id)">T. HAB. IMP. Y TRIBUT.</span>
		<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:405px;WIDTH:228px;text-align:right" id="Span26Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $totalhaberesimponible ?></span>

	<?php
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:450px;WIDTH:228px;text-align:left" id="Span25Det" onclick="SeleccionaCampoDet(this.id)">T. HAB. IMP. Y TRIBUT.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:450px;WIDTH:228px;text-align:right" id="Span26Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $totalhaberesimponible ?></span>
	<?php
	}	
	?>
	

	<?php 
	if ($reintegro == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:475px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">REINTEGRO ASIG. FAMILIAR:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:475px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $reintegro ?></span>
	<?php
	}	
	?>

	<?php 
	if ($asigfamiliar == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:495px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">ASIG. FAMILIAR:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:495px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $asigfamiliar ?></span>
	<?php
	}	
	?>


	<?php 
	if ($retroactiva == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:515px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">ASIG. RETROACTIVA:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:515px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $retroactiva ?></span>
	<?php
	}	
	?>

	<?php 
	if ($colacion == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:535px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">COLACIÓN:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:535px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $colacion ?></span>
	<?php
	}	
	?>


	<?php 
	if ($movilizacion == 0){
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:555px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">MOVILIZACIÓN:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:555px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $movilizacion ?></span>
	<?php
	}	
	?>


	<?php 
	if ($salacuna == 0){
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">SALA CUNA:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $salacuna ?></span>
	<?php
	}	
	?>


	<?php 
	if ($otroshnoimp == 0){
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:595px;WIDTH:228px;text-align:left" id="Span82Det" onclick="SeleccionaCampoDet(this.id)">OTROS HABERES NO IMP.:</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:595px;WIDTH:228px;text-align:right" id="Span83Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $otroshnoimp ?></span>
	<?php
	}	
	?>


	<?php 
	if ($salacuna == 0 && $otroshnoimp == 0){
	?>
		<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:left" id="Span25Det" onclick="SeleccionaCampoDet(this.id)">T. HAB. N IMP. Y N TRIBUT.</span>
		<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:right" id="Span26Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $totalhnoimp ?></span>

	<?php
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:620px;WIDTH:228px;text-align:left" id="Span25Det" onclick="SeleccionaCampoDet(this.id)">T. HAB. N IMP. Y N TRIBUT.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:76px;POSITION:absolute;TOP:620px;WIDTH:228px;text-align:right" id="Span26Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $totalhnoimp ?></span>
	<?php
	}	
	?>


	<?php 
	if ($pagoafp == 0){

	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:247px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">AFP</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:247px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $pagoafp ?></span>
	<?php
	}	
	?>


	<?php 
	if ($salud == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:267px;WIDTH:228px;text-align:right" id="Span38Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $salud ?></span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:267px;WIDTH:228px;text-align:left" id="Span39Det" onclick="SeleccionaCampoDet(this.id)">SALUD</span>
	<?php
	}	
	?>

	<?php 
	if ($seguro == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:287px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)"> S. CESANTÍA TRAB.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:287px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $seguro ?></span>
	<?php
	}	
	?>


	<?php 
	if ($ahorrovol == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:307px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)"> AHORRO VOLUNTARIO AFP.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:307px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $ahorrovol ?></span>
	<?php
	}	
	?>


	<?php 
	if ($impuesto == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:327px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)"> IMPUESTO RENTA.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:327px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $impuesto ?></span>
	<?php
	}	
	?>



	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:350px;WIDTH:228px;text-align:left;" id="Span46Det" onclick="SeleccionaCampoDet(this.id)">TOTAL DCTOS. LEGALES.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:350px;WIDTH:228px;text-align:right;" id="Span47Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $dctolegales ?></span>


	<?php 
	if ($segurovida == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:390px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)"> SEGURO DE VIDA.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:390px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $segurovida ?></span>
	<?php
	}	
	?>


	<?php 
	if ($credito == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:420px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">CRÉDITO SOCIAL.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:420px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $credito ?></span>
	<?php
	}	
	?>


	<?php 
	if ($prestamo == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:440px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">PRÉSTAMO PERSONAL.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:440px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $prestamo ?></span>
	<?php
	}	
	?>


	<?php 
	if ($anticipoaguinaldo == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:460px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">ANTICIPIO DE AGUINALDO.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:460px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $anticipoaguinaldo ?></span>
	<?php
	}	
	?>

	<?php 
	if ($anticiposueldo == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:480px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">ANTICIPIO DE SUELDO.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:480px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $anticiposueldo ?></span>
	<?php
	}	
	?>

	<?php 
	if ($segundoanticiposueldo == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:500px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">2do. ANTICIPIO DE SUELDO.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:500px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $segundoanticiposueldo ?></span>
	<?php
	}	
	?>

	<?php 
	if ($otrosdescuentos == 0){
		
	}else{
	?>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:520px;WIDTH:228px;text-align:left" id="Span36Det" onclick="SeleccionaCampoDet(this.id)">OTROS DESCUENTOS.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:Normal;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:520px;WIDTH:228px;text-align:right" id="Span37Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $otrosdescuentos ?></span>
	<?php
	}	
	?>

	
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:left;" id="Span46Det" onclick="SeleccionaCampoDet(this.id)">TOTAL DESCUENTOS.</span>
	<SPAN STYLE="COLOR:black;CURSOR:hand;DISPLAY:inline;FONT-FAMILY:Tahoma;FONT-SIZE:12px;FONT-STYLE:Normal;FONT-WEIGHT:bold;HEIGHT:19px; LEFT:380px;POSITION:absolute;TOP:575px;WIDTH:228px;text-align:right;" id="Span47Det" onclick="SeleccionaCampoDet(this.id)"><?php echo $totalotrosdescuentos ?></span>

	</DIV>


	<input type='hidden' name='cboBoletas' value='LS4CE'><input type='hidden' name='cboBoletasDet' value='LS4CE'><input type='hidden' name='mes' value='6'><input type='hidden' name='ano' value='2017'><input type='hidden' name='cboDia' value=''><input type='hidden' name='cboMes' value=''><input type='hidden' name='cboAno' value=''><input type='hidden' name='orden' value=''><input type='hidden' name='checkempl'    value=''><input type='hidden' name='empleado1'    value='12.619.699-7'><input type='hidden' name='empleado2'    value='12.619.699-7'><input type='hidden' name='txtSeleccion' value=''><input type='hidden' name='checkcneg'    value=''><input type='hidden' name='cnegocio'     value=''><input type='hidden' name='checktcon'    value=''><input type='hidden' name='tipocontrato' value=''><input type='hidden' name='HojasxPag'    value='1'><input type='hidden' name='IntIndice'    value='1'><input type='hidden' name='TotEmpleados'    value='1'><input type='hidden' name='TipoBolLiqui' value='BolLiquiDet'><input type=hidden name='vienegrat' value=''>

</form>
</body>
</html>
