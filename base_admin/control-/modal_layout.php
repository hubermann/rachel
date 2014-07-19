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
	<header class="block">
	<div class="one_3">
		<h1>Backend</h1>
	</div>	
	<div class="two_3">
		<!--<nav>
			<ul>
				<li><a href="/">Home</a></li>
				
				<li><a href="/dashboard/logout">Logout</a></li>
			</ul>
		</nav>	-->
		</div>
</header>


<!-- content -->
	
	
	<div class="block">
	<div class="full">
	<?php 
		
	if($this->session->flashdata('success')): 
    echo '<div class="success">'.$this->session->flashdata('success').'</div>';
	endif;
	
	if($this->session->flashdata('warning')): 
    echo '<div class="warning">'.$this->session->flashdata('warning').'</div>';
	endif;
	
	if($this->session->flashdata('error')): 
    echo '<div class="error">'.$this->session->flashdata('error').'</div>';
	endif;

	?>
	</div>
	</div>
	
		


<div class="block">

<div class="half">Hello</div>
<div class="half"><?php $this->load->view($content); ?></div>
</div>



<!-- footer -->
<footer class="block">
	
		
		<div class="full">Footer Backend</div>
		
		

</footer>


	
	
</body>
</html>