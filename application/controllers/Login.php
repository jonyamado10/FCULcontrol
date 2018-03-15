<?php 


class Login extends CI_Controller{
	

	public function login_validation(){
        $this->load->model('Users_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|md5');
		if($this->form_validation->run()){
			

			if($this->Users_model->is_aluno($this->input->post('email'))){
				$data = array( 'is_logged_in'=> 1);
				$userInfo = $this->Users_model->get_alunoInfo($this->input->post('email'));
				$this->session->set_userdata($data);
				$this->session->sess_expiration = '14400';// expires in 4 hour
				redirect(base_url('Main/aluno'));
				exit();
            	print_r($this->session->userdata());

            	echo "pagina aluno";
            
			}
			else{// se não é aluno, é funcionario
				$userInfo = $this->Users_model->get_funcionarioInfo($this->input->post('email'));
		
				$this->session->sess_expiration = '14400';// expires in 4 hours
            	if($this->Users_model->is_admin($userInfo['id'])){
            		$userInfo['is_logged_in_admin'] = 1;
            		$this->session->set_userdata($userInfo);	
            		redirect('Admin/dashboard');
            	}
            	else{
            		$userInfo['is_logged_in_docente'] = 1;
            		$this->session->set_userdata($userInfo);
            		echo "pagina funcionario";
            	}
            	
            
			}

			
		}
		else{
			$this->load->view('login');

		}
	}
	public function validate_credentials(){
		$this->load->model('Users_model');

		if($this->Users_model->can_log_in()){
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
