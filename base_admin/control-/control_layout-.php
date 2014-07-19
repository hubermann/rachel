<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/public_html/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public_html/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/public_html/assets/css/docs.css" rel="stylesheet">
    <link href="/public_html/assets/js/bootstrap.min.js" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
	<style type="text/css">

	</style>
    </head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Project name</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="<?php base_url() ?>/dashboard/index"><i class="icon-home"></i> Home</a></li>
              <li><a href="/dashboard/logout"><i class="icon-remove"></i> Logout</a></li>
              <!--<li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>
            </ul>
           <!-- <form class="navbar-form pull-right">
              <input class="span2" type="text" placeholder="Email">
              <input class="span2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form>-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container">
		
	<div class="row">
		<div class="span3 bs-docs-sidebar">
      	<?php $this->load->view($menu); ?>
      
      
       <!-- <ul class="nav nav-list bs-docs-sidenav">
          <li><a href="#download-bootstrap"><i class="icon-chevron-right"></i> Download</a></li>
          <li><a href="#file-structure"><i class="icon-chevron-right"></i> File structure</a></li>
          <li><a href="#contents"><i class="icon-chevron-right"></i> What's included</a></li>
          <li><a href="#html-template"><i class="icon-chevron-right"></i> HTML template</a></li>
          <li><a href="#examples"><i class="icon-chevron-right"></i> Examples</a></li>
          <li><a href="#what-next"><i class="icon-chevron-right"></i> What next?</a></li>
        </ul>-->
      </div>


		<div class="span9">
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
	
	
		<section>
			<?php $this->load->view($content); ?>
		</section>

	
	</div>


</div> <!-- /container -->

	<!-- Footer
    ================================================== -->
    <footer class="footer">
    
    	<p>2013 - Buenosweb.com</p>
    
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="/public_html/assets/js/widgets.js"></script>
    <script src="/public_html/assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-affix.js"></script>

    <script src="assets/js/holder/holder.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>

    <script src="assets/js/application.js"></script>


    <!-- Analytics
    ================================================== -->


  </body>
</html>
