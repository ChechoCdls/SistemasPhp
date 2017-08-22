<?php
	session_start();
	require_once 'dbconfig.php';

	if(isset($_POST['btn-login']))
	{
		//md5 encripta la contraseña debe ser varchar32 en la bd
		$user_rut = $_POST['rut'];
		$user_password = md5($_POST['password']);
		$permiso_admin ="admin";
		$permiso_super = "super";
		$permiso_normal="normal";
		$estado="1"; //vacio cuando esta activo y 1 cuando esta desactivado

		
		try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM usuario WHERE rut=:rut");
			$stmt->execute(array(":rut"=>$user_rut));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			

			if ($row['password']==$user_password && $row['permiso']==$permiso_super  && $row['estado']!=$estado ){

				echo "ok_superadmin"; // log in
				$_SESSION['user_session'] = $row['id_usuario'];

			}else if($row['password']==$user_password && $row['permiso']==$permiso_admin  && $row['estado']!=$estado ){
				
				echo "ok_admin"; // log in
				$_SESSION['user_session'] = $row['id_usuario'];


			}else if($row['password']==$user_password && $row['permiso']==$permiso_normal && $row['estado']!=$estado){

				echo "ok_normal"; // log in
				$_SESSION['user_session'] = $row['id_usuario'];

			}else if($row['estado']==$estado){

				echo "Usuario Inactivo, Comuníquese con el Administrador";

			}else{
				
				echo "RUT o contraseña no coinciden"; // wrong details 
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>