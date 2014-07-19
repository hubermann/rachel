<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--<link rel="stylesheet" type="text/css" media="all" href="assets/base.css" />-->
	

	<!-- charset -->
	<meta charset="utf-8">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Description -->
	<meta name="description" content="">

<style type="text/css">
	body{width:500px; margin:0 auto; font-family:arial; font-size:.8em}
	form, input, label{width:500px; float:left; margin-top:10px;}
	input{padding:5px 3px;}
	label{font-weight:bold;}
	button{margin-top:15px; float:right}
</style>

<script type="text/javascript" src="base_admin/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="base_admin/js/jquery.validate.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
    $(".formvalid").validate({
      event: "blur",
      rules: {
       proyecto: { 
		required: true, 
		minlength: 2 
		},
		singular: { 
		required: true, 
		minlength: 2 
		},
		plural: { 
		required: true, 
		minlength: 2 
		},
		     
      
    },
    messages: {
    proyecto: { 
		required: " Complete nombre de proyecto", 
		minlength: "* 2 caracteres minimo." 
		},
		singular: { 
		required: " Complete nombre en singular", 
		minlength: "* 2 caracteres minimo." 
		},
		plural: { 
		required: " Complete nombre en plural", 
		minlength: "* 2 caracteres minimo." 
		},
			
             
        },
      debug: true,
      errorElement: "p",
      submitHandler: function(form){
         //alert('Los datos seran enviados');
          form.submit();
      }
   });
});
</script> 


</head>
<body>
<div class="block">
	<header>
		
		
	</header>
</div>


<div class="block">
<form action="paso1.php" method="post" class="formvalid">
	<label for="path">proyecto:</label>
	<input type="text" name="proyecto" id="proyecto">
	<label for="singular">Singular:</label>
	<input type="text" name="singular" id="singular">
	<label for="plural">Plural:</label>
	<input type="text" name="plural" id="plural">
	<label for="images">1 imagen ?</label>
	<input type="checkbox" name="imagen" id="">
	<label for="images">varias imagenes ?</label>
	<input type="checkbox" name="imagenes" id="">
	<label for="images">categoria ?</label>
	<input type="checkbox" name="categoria" id="">

<button type="submit">Next &rarr;</button>
</form>



</div>

<div class="block">
	<footer>
		

	</footer>
</div>

<!-- JQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

</body>
</html>