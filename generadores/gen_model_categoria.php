<?php

$modelcat .= '<?php  

class ';
	
$modelcat .= "Categorias_".ucfirst($singular);

$modelcat .= " extends CI_Model{

	public function __construct(){

	$"."this->load->database();

	}
	//all
	public function get_records($"."num,$"."start){
		$"."this->db->select()->from('categorias_$plural')->order_by('$singular"."_categoria_id','ASC')->limit($"."num,$"."start);
		return $"."this->db->get('categorias_".$plural."');

	}

	//detail
	public function get_record($"."id){
		$"."this->db->where('id' ,$"."id);
		$"."this->db->limit(1);
		$"."c = $"."this->db->get('categorias_".$plural."');

		return $"."c->row(); 
	}
	
	//total rows
	public function count_rows(){ 
		$"."this->db->select('id')->from('categorias_$plural');
		$"."query = $"."this->db->get();
		return $"."query->num_rows();
	}



		//add new
		public function add_record($"."data){ ";
			
if($_POST['require_image']){

$modelcat .= "
			$"."this->upload->do_upload('avatar');
			$"."name = $"."_FILES['avatar']['name'];
			$"."data['avatar'] = $"."name;
				
				";
}

			

$modelcat .=

"$"."this->db->insert('categorias_".$plural."', $"."data);
				

		}


		//update
		public function update_record($"."id, $"."data){

			$"."this->db->where('id', $"."id);
			$"."this->db->update('categorias_$plural', $"."data);

		}

		//destroy
		public function delete_record(){

			$"."this->db->where('id', $"."this->uri->segment(4));
			$"."this->db->delete('categorias_".$plural."');
		}




}


?>";

$filelist = fopen("proyectos/$proyecto/models/categorias_$singular".".php", "w+");
fwrite($filelist, $modelcat);
?>
