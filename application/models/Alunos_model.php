<?php  
class Alunos_model extends CI_model{

	public function can_log_in(){

		$this->db->where('email',$this->input->post('email'));
		$password = $this->input->post('password');
		$custo = '08';
		$salt = 'Cf1f11ePArKlBJomM0F6aJ';
		// Gera um hash baseado em bcrypt
		$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
		$this->db->where('password',$hash);
		$query = $this->db->get('alunos');

		if($query->num_rows()==1){
				return true;
		}
		else{

			return false;
		}
	}
	public function can_log_in_admin(){

		$this->db->where('username',$this->input->post('username'));
		$this->db->where('password',md5($this->input->post('password')));
		$query = $this->db->get('admin');

		if($query->num_rows()==1){
				return true;

		}
		else{

			return false;
		}
	}
    
    function get_userInfo($email){
        $this->db->where('email',$email);
        $query = $this->db->get('alunos');       
        foreach ($query->result() as $row)
            {
               return $row;
            }
          
		return "Not Found";
	}

}





?>