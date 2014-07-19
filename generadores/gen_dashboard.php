<?php

$dashboard = "<?php  

class Dashboard extends CI_Controller{

	function __construct(){
		parent::__construct();
		$"."this->load->model('useradmins_m');
		$"."this->load->helper('url');
		$"."this->load->helper('form');
		$"."this->load->library('session');
		$"."this->load->library('form_validation');
	}

	public function index(){
			if(! $"."this->session->userdata('logged_in')){
					redirect('dashboard/login');
			}
			$"."data['title'] = 'Bienvenido';
			$"."data['menu'] = 'control/empty';
			$"."data['content'] = 'control/control_index';
			$"."this->load->view('control/control_layout', $"."data);
		}

	public function migrate(){
		$"."this->load->library('migration');		
		$"."this->migration->current();
		if ( ! $"."this->migration->current()){
			show_error($"."this->migration->error_string());
		}else{
			echo \"Migration successfully runned!\";
		}
	}

	public function login(){
		$"."this->form_validation->set_rules('email', 'Email', 'required|trim');
		$"."this->form_validation->set_rules('password', 'Password', 'required|trim');

	    #Paso validacion
	    if ($"."this->form_validation->run()){

		//Coinciden los datos
		if ($"."this->useradmins_m->try_login($"."this->input->post('email'), $"."this->input->post('password'))){
			redirect('/control/notes');
		}
	    //no coinciden datos
		else{
			$"."this->session->set_flashdata('error', 'No se encuentran usuario con esos datos.');
			redirect('dashboard/login', 'refresh');
		}

	}
	//No paso la validacion
	$"."data['content'] = 'control/login';
	$"."this->load->view('control/modal_layout', $"."data);

}

	public function logout(){
		$"."this->useradmins_m->logout();
		$"."data['content'] = 'control/login';
		$"."this->load->view('control/modal_layout', $"."data);
	}


}

?>";
$file_dash = fopen("proyectos/$proyecto/controllers/dashboard".".php", "w+");
fwrite($file_dash, $dashboard);


?>