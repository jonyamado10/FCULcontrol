<?php 

class Login extends CI_Controller{
	

	public function login_validation(){
        $this->load->model('Alunos_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|md5');
		if($this->form_validation->run()){
			$userInfo = $this->Alunos_model->get_userInfo($this->input->post('email'));
			$data = array('email' =>$this->input->post('email'), 'is_logged_in'=> 1, 'id' => $userInfo ->id, 'nome' => $userInfo->nome, 'Apelido' => $userInfo->apelido, 'Num aluno' => $userInfo->num_aluno  );
			print_r($data);
			print_r($userInfo);
			
			$this->session->set_userdata($userInfo);
			$this->session->sess_expiration = '14400';// expires in 4 hour
            print_r($this->session->userdata());
            
		}
		else{
			$this->load->view('login');

		}
	}
	public function validate_credentials(){
		$this->load->model('Alunos_model');

		if($this->Alunos_model->can_log_in()){
			return true;
		}
	
		else{
			$this->form_validation->set_error_delimiters('<p style= "color:red">Email / Palavra-chave Incorrectos.<br>','<br></p>');
			$this->form_validation->set_message('validate_credentials',' Tente Novamente');
			return false;
		}


	}

	public function logout(){

		$this->session->sess_destroy();
		redirect('Main/login');
	}

	
}





?>
