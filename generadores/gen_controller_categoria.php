<?php


$controller = "<?php 

class Categorias_".ucfirst($plural)." extends CI_Controller{


		public function __construct(){

			parent::__construct();
			$"."this->load->model('categorias_$singular');
			$"."this->load->helper('url');
			$"."this->load->library('session');
			
			//Si no hay session redirige a Login
			if(! $"."this->session->userdata('logged_in')){
				redirect('dashboard');
			}
			
			
			
			}

			public function index(){
				//Pagination
				$"."per_page = 3;
				$"."page = $"."this->uri->segment(3);
				if(!$"."page){ $"."start =0; $"."page =1; }else{ $"."start = ($"."page -1 ) * $"."per_page; }
				$"."data['pagination_links'] = \"\";
				$"."total_pages = ceil($"."this->categorias_$singular"."->count_rows() / $"."per_page);
			
					if ($"."total_pages > 1){ 
						for ($"."i=1;$"."i<=$"."total_pages;$"."i++){ 
  						 	if ($"."page == $"."i) 
     	 						//si muestro el índice de la página actual, no coloco enlace 
     	 						$"."data['pagination_links'] .=  '<li class=\"active\"><a>'.$"."i.'</a></li>'; 
  	 						else 
     	 						//si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa pagina 
     	 						$"."data['pagination_links']  .= '<li><a href=\"'.base_url().'control/categorias_$plural/'.$"."i.'\" > '. $"."i .'</a></li>'; 
						} 
					}
				//End Pagination
				
				$"."data['title'] = 'Categorias ".ucfirst(str_replace('_',' ',$plural))."';
				$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
				$"."data['content'] = 'control/$plural/categorias_all';
				$"."data['query'] = $"."this->categorias_$singular"."->get_records($"."per_page,$"."start);

				$"."this->load->view('control/control_layout', $"."data);

			}

			//detail
			public function detail(){

				$"."data['title'] = 'Categoria ".ucfirst(str_replace('_',' ',$plural))."';
				$"."data['content'] = 'control/$plural/categorias_detail';
				$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
				$"."data['query'] = $"."this->categorias_$singular->"."get_record($"."this->uri->segment(4));
				$"."this->load->view('control/control_layout', $"."data);
			}


			//new
			public function form_new(){
				$"."this->load->helper('form');
				$"."data['title'] = 'Nueva Categoria ".ucfirst($singular)."';
				$"."data['content'] = 'control/$plural/new_categoria_$singular';
				$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
				$"."this->load->view('control/control_layout', $"."data);
			}

			//create
			public function create(){

				$"."this->load->helper('form');
				$"."this->load->library('form_validation');";

foreach($catfields_clean as $field){

		
$controller .="\n
				$"."this->form_validation->set_rules('$field', '".ucfirst(str_replace('_',' ',$field))."', 'required');";
		

}

/* si requiere imagen */
if($_POST['require_image']){$controller .="
					
					//Path para subir imagen
					$"."config['upload_path'] = './images-$plural/';
					//formatos permitidos de imagen a subir
					$"."config['allowed_types'] = 'gif|jpg|png|jpeg';
		
					//libreria para subir archivos
					$"."this->load->library('upload', $"."config);
					//iniciao la libreria para upload
					$"."this->upload->initialize($"."config);";}

$controller .="\n
				$"."this->form_validation->set_message('required','El campo %s es requerido.');";
$controller .="\n
				if ($"."this->form_validation->run() === FALSE){";
				
/* si requiere imagen */
if($_POST['require_image']){$controller .="
					
					if ( ! $"."this->upload->do_upload('avatar'))
					{
					$"."data = array('error' => $"."this->upload->display_errors());
 					}";

}			
				
				
$controller .="\n
					$"."this->load->helper('form');
					$"."data['title'] = 'Nueva categoria $plural';
					$"."data['content'] = 'control/$plural/new_categoria_$singular';
					$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
					$"."this->load->view('control/control_layout', $"."data);

				}else{
					$"."new$singular = array(";
	foreach($catfields_clean as $field){


		$controller .="\n			
		'$field' => $"."this->input->post('$field'),";
		if($field == "slug"){ $controller .= "
		#$"."this->load->helper('url');
	       	#$"."slug = url_title($"."this->input->post('name'), 'dash', TRUE);";  }
	}
					

					
$controller .="     
					);
					#save
					$"."this->categorias_$singular"."->add_record($"."new$singular);
					$"."this->session->set_flashdata('success', '".ucfirst(str_replace('_',' ',$field))." creada. <a href=\"$plural/categorias_detail/'.$"."this->db->insert_id().'\">Ver</a>');
					redirect('control/$plural', 'refresh');

				}



			}

			//edit
			public function editar(){
				$"."this->load->helper('form');
				$"."data['title']= 'Editar categoria ".ucfirst($singular)."';	
				$"."data['content'] = 'control/$plural/edit_categorias_$singular';
				$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
				$"."data['query'] = $"."this->categorias_$singular"."->get_record($"."this->uri->segment(4));
				$"."this->load->view('control/control_layout', $"."data);
			}

			//update
			public function update(){
				$"."this->load->helper('form');
				$"."this->load->library('form_validation'); ";
foreach($catfields_clean as $field){
	
	$controller .=" 	$"."this->form_validation->set_rules('$field', '".ucfirst(str_replace('_',' ',$field))."', 'required');
       	";
	
}
$controller .="			
			$"."this->form_validation->set_message('required','El campo %s es requerido.');

				if ($"."this->form_validation->run() === FALSE){
						$"."this->load->helper('form');
						
						$"."data['title'] = 'Nueva categoria $singular';
						$"."data['content'] = 'control/$plural/edit_categorias_$singular';
						$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
						$"."data['query'] = $"."this->categorias_$singular"."->get_record($"."this->input->post('id'));
						$"."this->load->view('control/control_layout', $"."data);
				}else{

				$"."id=  $"."this->input->post('id');
				$"."edited$singular = array( ";
			
				

			foreach($catfields_clean as $field){

			$controller .=" '$field' => $"."this->input->post('$field'),
					";

			}				
				
				
				
$controller .="	);
				#save
				$"."this->session->set_flashdata('success', '".ucfirst(str_replace('_',' ',$field))." Actualizada!');
				$"."this->categorias_$singular"."->update_record($"."id, $"."edited$singular);
				if($"."this->input->post('id')!=\"\"){
					redirect('control/$plural/categorias_detail/'.$"."this->input->post('id'), 'refresh');
				}else{
					redirect('control/$plural', 'refresh');
				}
				
				

		}



	}


			//delete comfirm		
			public function delete_comfirm(){
				$"."this->load->helper('form');
				$"."data['content'] = 'control/$plural/categorias_comfirm_delete';
				$"."data['title'] = 'Eliminar categoria $singular';
				$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
				$"."data['query'] = $"."data['query'] = $"."this->categorias_$singular"."->get_record($"."this->uri->segment(4));
				$"."this->load->view('control/control_layout', $"."data);


			}

			//delete
			public function delete(){

				$"."this->load->helper('form');
				$"."this->load->library('form_validation');

				$"."this->form_validation->set_rules('comfirm', 'comfirm', 'required');
				$"."this->form_validation->set_message('required','Por favor, confirme para eliminar.');

				
				if ($"."this->form_validation->run() === FALSE){
				#validation failed
					$"."this->load->helper('form');

					$"."data['content'] = 'control/categorias_$plural/categorias_comfirm_delete';
					$"."data['title'] = 'Eliminar categoria $singular';
					$"."data['menu'] = 'control/$plural/menu_categorias_$plural';
					$"."data['query'] = $"."this->categorias_$singular"."->get_record($"."this->input->post('id'));
					$"."this->load->view('control/control_layout', $"."data);
				}else{
					#validation passed
					$"."this->session->set_flashdata('success', 'Categoria eliminada!');
					$"."this->categorias_$singular"."->delete_record();
					redirect('control/$plural', 'refresh');

				}




		}




} //end class

?>";

$filecon = fopen("proyectos/$proyecto/controllers/control/categorias_$plural".".php", "w+");
fwrite($filecon, $controller);


//Controler FRONTEND

$controller_front = "<?php 

class Categorias_".ucfirst($plural)." extends CI_Controller{


		public function __construct(){

			parent::__construct();
			$"."this->load->model('categorias_$singular');
			$"."this->load->helper('url');
			$"."this->load->library('session');
			}

			public function index(){

				$"."data['title'] = 'Categorias ".ucfirst(str_replace('_',' ',$plural))."';
				$"."data['menu'] = '$plural/menu_categorias_$plural';
				$"."data['content'] = '$plural/categorias_all';
				$"."data['query'] = $"."this->categorias_$singular"."->get_records('$plural');

				$"."this->load->view('layout', $"."data);

			}

			//detail
			public function detail(){

				$"."data['title'] = 'Categoria ".ucfirst(str_replace('_',' ',$plural))."';
				$"."data['content'] = '$plural/categorias_detail';
				$"."data['menu'] = '$plural/menu_categorias_$plural';
				$"."data['query'] = $"."this->categorias_$singular->"."get_record($"."this->uri->segment(4));
				$"."this->load->view('layout', $"."data);
			}


		






} //end class

?>";

$filecon_f = fopen("proyectos/$proyecto/controllers/categorias_$plural".".php", "w+");
fwrite($filecon_f, $controller_front);
?>
