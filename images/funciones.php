<?php


//recibimos el caso
$caso = $_GET['caso'];

//echo $caso;


//Switch que decide que funcion debe ejecutar
switch ($caso) {
    case 'guardar_test':
        $nivel = $_GET['nivel'];
        guardar_test($nivel);
        break;

    case 'login':
        login();
        break;

    case 'verdatos':
    	verdatos();
        break;

    default:
        echo 'caso default';
        break;
}


function conectarBD(){
    // Parametros del servidor
$servidor   ='localhost';
$usuario    ='root';
$pass       ='12345678';
$baseDatos  ='comercialdelmar';
// Conexion
$conexion = new mysqli($servidor,$usuario,$pass,$baseDatos);

// checkiando conexion
if (!$conexion) {
    die("Fallo en la conexion". mysqli_connect_error());
}else{
    //echo ("conexion exitosa");
}

return $conexion;
}

function login(){
    // test link fonoeducapp.azurewebsites.net/inicio_sesion/funciones.php?caso=login&&uss=benjamca@hotmail.com&&pss=123
 $conexion = conectarBD();   
//obteniendo usuario y pass
 $uss = $_GET['uss'];
 $pss = $_GET['pss'];
 
 //echo $uss;
 //echo $pss;
 
 
//validar si el usuario existe en la BD
    $resultado = $conexion->query("SELECT * FROM usuario WHERE rut = '".$uss."' AND password = '".$pss."' ");

    
    if(mysqli_num_rows($resultado)>0) {
        echo "bien";
    }else{
        echo "mal";
    }
         
         
         
}

function verdatos(){
	$conexion = conectarBD(); 

	$uss	= $_GET['uss'];

	$resultado2 = $conexion->query("SELECT * FROM usuario WHERE email_us LIKE '".$uss."' ");

	if(mysqli_num_rows($resultado2)>0)
	{
		//mostrar datos obtenidos
		while ($row = mysqli_fetch_assoc($resultado2)) {

			echo $row['email_us']."|".$row['nom_us']."|".$row['ape_us'];
		}
	}else{
		echo "mal";
	}
}

function guardar_test($nivel){
    // link test http://fonoeducapp.azurewebsites.net/inicio_sesion/funciones.php?caso=guardar_test&&nivel=fonetico&&puntaje=20&&id_test=187090075

//rescatamos datos    
$puntaje = $_GET['puntaje'];
$id_test = $_GET['id_test'];
$tiempo_te = $_GET['tiempo'];

//llamamos conexion
$conexion = conectarBD();

   
    switch ($nivel) {
        case 'fonetico':
            $conexion->query("UPDATE test SET puntaje_fonetico_te = ".$puntaje." WHERE id_te = ".$id_test);
            echo 'guardado '.$nivel;
            break;
        case 'semantico':
            $conexion->query("UPDATE test SET puntaje_semantico_te = ".$puntaje." WHERE id_te = ".$id_test);
            echo 'guardado '.$nivel;
            break;
        case 'morfo':
            $conexion->query("UPDATE test SET puntaje_morfo_te = ".$puntaje." WHERE id_te = ".$id_test);
            echo 'guardado '.$nivel;
            break;
        case 'prag':
            $conexion->query("UPDATE test SET puntaje_prag_te = ".$puntaje." WHERE id_te = ".$id_test);
            echo 'guardado '.$nivel;
            break;

        case 'total':

        //link test http://fonoeducapp.azurewebsites.net/inicio_sesion/funciones.php?caso=guardar_test&&nivel=total&&puntaje=30&&id_test=187090075&&tiempo=00:13:20
        //rescatamos el puntaje total de todos los test
        $resultado = $conexion->query("SELECT (puntaje_fonetico_te+puntaje_semantico_te+puntaje_morfo_te+puntaje_prag_te) as total from test where id_te = ".$id_test);
        $row = $resultado->fetch_array();
        $puntaje_total = $row['total'];

        if ($puntaje_total >= 40) # designar cual es el puntaje minimo para lograr el test 
        {
            $resultado = 'logrado';
        }else{
            $resultado = 'no logrado';
        }
        $conexion->query("UPDATE test SET tiempo_te = '".$tiempo_te."', puntaje_total_te = ".$puntaje_total." , puntaje_obtenido_te = '".$resultado."' WHERE  id_te = ".$id_test);
        echo 'guardado '.$nivel;
        
            break;

        default:
             echo 'caso default en guardar_test';
            break;
    }
}









//----------------------------------------- ANTIGUO CODIGOOOOO------------------------------------------//
//recibimos las variables
// $id_evaluacion = $_GET['id_evaluacion'];
// $id_usuario = $_GET['id_usuario'];
// $puntaje = $_GET['puntaje'];

// //insertamos
// $stmt = $db_con->prepare("INSERT INTO evaluacion_usuario(id_evaluacion,id_usuario,puntaje_obtenido) VALUES(:eva,:user,:ptje)");
//    	$stmt->bindParam(":eva",$id_evaluacion);
// 	$stmt->bindParam(":user",$id_usuario);
// 	$stmt->bindParam(":ptje",$puntaje);
	
// 	if($stmt->execute())
//     {
//      echo "registrado";
//     }
//     else
//     {
//      echo "Query could not execute ";
//     }


?>