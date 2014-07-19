
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/public_html/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
      .warning{background: yellow}
      .success{background: green}
      .error{color: red}
     
    </style>
    <link href="/public_html/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/public_html/assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Backend</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
             <i class="icon-remove"></i>  <a href="/dashboard/logout" class="navbar-link">Cerrar sesion.</a>
            </p>
            <ul class="nav">
              <li class="active"><a  href="<?php base_url() ?>/dashboard/index"> <i class="icon-home"></i> Home</a></li>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
		
		
		<div id="avisos">

		<?php 
		
		if($this->session->flashdata('success')): 
   				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
				'.$this->session->flashdata('success').'</div>';
		endif;
	
		if($this->session->flashdata('warning')): 
				echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>
				'.$this->session->flashdata('warning').'</div>';
		endif;
	
		if($this->session->flashdata('error')): 
    		echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
				'.$this->session->flashdata('error').'</div>';
		endif;

		?>
		
		</div>

    <div class="container-fluid">
    
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
           
            <?php $this->load->view($menu); ?>

          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
        
		
            <?php $this->load->view($content); ?>
          
         
         <div class="row-fluid">
         <br />
         <br />
         <br />
         <br />
         <br />
         </div>
          
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; BuenosWeb.com 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/public_html/assets/js/jquery.js"></script>
    <script src="/public_html/assets/js/bootstrap-transition.js"></script>
    <script src="/public_html/assets/js/bootstrap-alert.js"></script>
    <script src="/public_html/assets/js/bootstrap-modal.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-button.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-collapse.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-carousel.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
