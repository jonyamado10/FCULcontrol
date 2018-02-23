<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acessos_model extends CI_Model {

    function get_acessos() {
        $query = $this->db->get('acessos');
        return $query->result_array();
    }
    public function add_acesso(){
		date_default_timezone_set('Europe/Lisbon');
		$date = date('Y-m-d H:i:s');

		$data = array(
			'cardnumber' => $this -> input->post('cardnumber'),
			'building' => $this -> input->post('edificio'),
			'floornumber' => $this -> input->post('piso'),
			'door' => $this -> input->post('porta'),
			'date' => $date
			);
		$query = $this->db->insert('acessos',$data);
		if($query){
			return true;
		} else{
			return false;
		}

    }
    
}
?>