<?php

$model .= '<?php  

class ';
	
$model .= ucfirst($singular);

$model .= " extends CI_Model{

	public function __construct(){

	$"."this->load->database();

	}
	//all
	public function get_records($"."num,$"."start){
		$"."this->db->select()->from('$plural')->order_by('id','ASC')->limit($"."num,$"."start);
		return $"."this->db->get();

	}

	//detail
	public function get_record($"."id){
		$"."this->db->where('id' ,$"."id);
		$"."this->db->limit(1);
		$"."c = $"."this->db->get('".$plural."');

		return $"."c->row(); 
	}
	
	//total rows
	public function count_rows(){ 
		$"."this->db->select('id')->from('$plural');
		$"."query = $"."this->db->get();
		return $"."query->num_rows();
	}



		//add new
		public function add_record($"."data){ ";
			
if($_POST['require_image']){

		$model .= "
				$"."this->upload->do_upload('avatar');
				$"."name = $"."_FILES['avatar']['name'];
				$"."data['avatar'] = $"."name;
				
					";
		}

			

		$model .=	"$"."this->db->insert('".$plural."', $"."data);
				

	}


		//update
		public function update_record($"."id, $"."data){

			$"."this->db->where('id', $"."id);
			$"."this->db->update('$plural', $"."data);

		}

		//destroy
		public function delete_record(){

			$"."this->db->where('id', $"."this->uri->segment(4));
			$"."this->db->delete('".$plural."');
		}


		/*
		public function traer_nombre($"."id){
					$"."this->db->where('lugar_categoria_id' ,$"."id);
					$"."this->db->limit(1);
					$"."c = $"."this->db->get('$plural');

					return $"."c->row('nombre'); 
				}
		
		*/

}


?>";

$filelist = fopen("proyectos/$proyecto/models/$singular".".php", "w+");
fwrite($filelist, $model);
?>
