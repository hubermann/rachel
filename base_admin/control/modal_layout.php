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
	<?php $this->load->view($content); ?></div>
