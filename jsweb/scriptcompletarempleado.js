$(document).ready(function(){
	// generamos un evento cada vez que se pulse una tecla
	$("#empleado").change(function(){
		// enviamos una petición al servidor mediante AJAX enviando el id
		// introducido por el usuario mediante POST
		$.post("buscaremp.php", {"idempleado":$("#empleado").val()}, function(data){
			// Si devuelve un nombre lo mostramos, si no, vaciamos la casilla
			if(data.rut_empleado)
				$("#rut").val(data.rut_empleado);
			else
				$("#rut").val("");
				
			// Si devuelve un rut lo mostramos, si no, vaciamos la casilla
			if(data.nombre_empleado)
				$("#nombre").val(data.nombre_empleado);
			else
				$("#nombre").val("");

			// Si devuelve un direccion lo mostramos, si no, vaciamos la casilla
			if(data.telefono_empleado)
				$("#telefono").val(data.telefono_empleado);
			else
				$("#telefono").val("");

			// Si devuelve un contacto lo mostramos, si no, vaciamos la casilla
			if(data.email_empleado)
				$("#email").val(data.email_empleado);
			else
				$("#email").val("");

		},"json");
	});
});
