$('document').ready(function()
{ 
     /* validation */
	 $("#register-form").validate({
      rules:
	  {
			rut_empleado: {
		    required: true,
			minlength: 3
			},
			nombre_empleado: {
		    required: true,
			minlength: 3
			},
			apellido_empleado: {
		    required: true,
			minlength: 3
			},
			cargo_empleado: {
		    required: true,
			minlength: 3
			},
			area_empleado: {
		    required: true,
			minlength: 3
			},
			
	   },
       messages:
	   {
            rut_empleado: "Ingrese Rut del Empleado",
            nombre_empleado: "Ingrese Nombre del Empleado",
            apellido_empleado: "Ingrese Apellido del Empleado",
            cargo_empleado: "Ingrese Cargo del Empleado",
            area_empleado: "Ingrese Área del Empleado",
           
  
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	   function submitForm()
	   {		
				var data = $("#register-form").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'pregistroempleado.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
											$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error</div>');
											
											$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Registrar');
										
									});
																				
								}
								else if(data=="registered")
								{
									
									$("#btn-submit").html('&nbsp; Registrando ...'); 
									alert('Registro Completado Correctamente');
									window.location.reload();     
									
									
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
									$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' </div>');
											
									$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
