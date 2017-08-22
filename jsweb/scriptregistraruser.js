$('document').ready(function()
{ 
     /* validation */
	 $("#register-form").validate({
      rules:
	  {
			rut: {
            required: true,
            },
            nombre: {
            required: true,
            },
            telefono: {
            required: true,
            },
            email: {
            required: true,
            },
			pass1: {
			required: true,
			minlength: 5,
			maxlength: 25
			},
			pass: {
			required: true,
			equalTo: '#pass1'
			},
			tipousuario: {
			required: true,
			},
	   },
       messages:
	   {
            rut:{ required: "Por favor ingrese rut válido ",
						minlength: "Rut debe contener mínimo 3 caracteres"
						},
			nombre: "Por favor ingrese un nombre",
			telefono: "Por favor ingrese teléfono",
			email: "Por favor ingrese email",			
						
            pass1:{
                      required: "Por favor ingrese una contraseña ",
                      minlength: "La contraseña debe contener mínimo 5 caracteres"
                     },

			pass:{
						required: "Por favor repita la contraseña",
						equalTo: "Contraseñas no coinciden"
					  },
			tipousuario: "Por favor seleccione opción",
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
				url  : 'pregistrouser.php',
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
											
											
											$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Lo sentimos, el rut ya se encuentra registrado</div>');
											
											$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Crear cuenta');
										
									});
																				
								}
								else if(data=="registered")
								{
									
									$("#btn-submit").html(' &nbsp; Registrando ...'); 
									alert('Registro Completado Correctamente');
									window.location.reload();     
									
									
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
									$("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' </div>');
											
									$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Crear cuenta');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
