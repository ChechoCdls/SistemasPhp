//para logearse
$('document').ready(function()
{ 
     /* validation */
	 $("#login-form").validate({
      rules:
	  {
			password: {
			required: true,
			},
			rut: {
            required: true
            },
	   },
       messages:
	   {
            password:{
                      required: "Por favor ingrese contraseña"
                     },
            rut: "Por favor ingrese su rut",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#login-form").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'login_process.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; enviando ...');
			},
			success :  function(response)
			   {						
					if(response=="ok_admin"){
									
						$("#btn-login").html('Ingresando ...');
						setTimeout(' window.location.href = "menuadmin.php"; ',4000);


					}else if(response=="ok_superadmin"){

						$("#btn-login").html('Ingresando ...');
						setTimeout(' window.location.href = "menusuperadmin.php"; ',4000);

					}else if(response=="ok_normal"){

						$("#btn-login").html('Ingresando ...');
						setTimeout(' window.location.href = "menuser.php"; ',4000);


					}else{
									
						$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
											$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Ingresar');
									});
					}
			  }
			});
				return false;
		}
});