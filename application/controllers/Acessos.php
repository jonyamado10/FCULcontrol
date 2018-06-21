<?php 

class Acessos extends CI_Controller{
	
	public function acessos_validation(){

		$this->load->model('Acessos_model');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('data', 'data', 'required|trim');
		if($this->form_validation->run()){
		   if($this->Acessos_model->gerar_acessos()){
		    $sucess = "Acessos gerados com sucesso!";
          	echo $sucess;
           
		   }
		   else{
		   	echo "Erro interno, a gerar Acessos, tente novamente!";
		   	return false;
		   }

			}
		else{

			echo "Data Invalida, Tente novamente!";
			return false;
			}

	}
	public function acessos_detalhados_validation(){

		$this->load->model('Acessos_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('data', 'data', 'required|trim');
		$this->form_validation->set_rules('hora_inicial', 'hora_inicial', 'required|trim');
		$this->form_validation->set_rules('hora_final', 'hora_final', 'required|trim');
		$this->form_validation->set_rules('num_acessos', 'num_acessos', 'required|trim');

		if($this->form_validation->run()){
			if($this->Acessos_model->num_aluno_existe($this->input->post("num_aluno"))){
			   if($this->Acessos_model->gerar_acessos_detalhados()){
			    $sucess = "Acessos gerados com sucesso!";
	          	echo $sucess;
	           
			   }
			   else{
			   	echo "Erro interno, a gerar Acessos, Tente novamente!";
			   	return false;
			   }

			}
			else{
				echo "Número de Aluno Introduzido não existe.";
			}
		}
		else{

 			echo "Todos os Campos tem que ser preenchidos, Tente novamente!";
			return false;
		}

	}
		public function acessos_detalhados_aluno_validation(){

		$this->load->model('Acessos_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('data', 'data', 'required|trim');
		$this->form_validation->set_rules('hora_inicial', 'hora_inicial', 'required|trim');
		$this->form_validation->set_rules('hora_final', 'hora_final', 'required|trim');
		$this->form_validation->set_rules('num_acessos', 'num_acessos', 'required|trim');
		$this->form_validation->set_rules('num_aluno', 'num_aluno', 'required|trim');
		if($this->form_validation->run()){
		   if($this->Acessos_model->gerar_acessos_detalhados_aluno()){
		    $sucess = "Acessos gerados com sucesso!";
          	echo $sucess;
           
		   }
		   else{
		   	echo "Erro interno, a gerar Acessos, Tente novamente!";
		   	return false;
		   }

		}
		else{

 			echo "Todos os Campos tem que ser preenchidos, Tente novamente!";
			return false;
		}

	}

}



?>
