$('document').ready(function()
{ 
     /* validation */
	 $("#register-form").validate({
      rules:
	  {


			
	   },
       messages:
	   {

           
  
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
				url  : 'pregistroliquidacion.php',
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
