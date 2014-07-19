<!DOCTYPE HTML> 
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Title</title>
	
	<meta name="description" content="" />

	<link rel="stylesheet" media="all" href="/public_html/assets/grid.css" />
	<link rel="stylesheet" media="all" href="/public_html/assets/backend.css" />
	<link rel="stylesheet" media="all" href="/public_html/assets/font-awesome.css" />
	
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/ie.css" />
	<![endif]-->
	
	
	<!-- GOOGLE +1 -->
	<!--<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>-->
	<!-- GOOGLE +1 -->
	
	
</head>

<body>

<div class="one3"></div>
<div class="one3">


<?php 
$attribute = Array ("id"=>"simpleform");
echo form_open('dashboard/login',$attribute); ?>

		
		<fieldset>
		<legend> <strong>&nbsp; Access &nbsp;</strong> </legend>

		<div class="form-item">
			<label for="name">Email:</label>
			<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Provide your first email." required />
			<?php echo form_error('email','<p class="error">', '</p>'); ?>
		</div>

		<div class="form-item">
			<label for="password">password:</label>
			<input type="text" name="password" id="password" placeholder="Provide your password." required />
			<?php echo form_error('password','<p class="error">', '</p>'); ?>
		</div>

		<button class="form_button">Submit form</button>
		</fieldset>								
<?php echo form_close(); ?>


</div>
<div class="one3"></div>
	
</body>
</html>