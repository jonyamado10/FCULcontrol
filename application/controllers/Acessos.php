<?php 

class Acessos extends CI_Controller{
	
	public function acessos_validation(){

		$this->load->model('Acessos_model');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cardnumber', 'cardnumber', 'required|trim');
		$this->form_validation->set_rules('edificio', 'building', 'required|trim');
		$this->form_validation->set_rules('piso', 'floornumber', 'required|trim');
		$this->form_validation->set_rules('porta', 'door', 'required|trim');
		if($this->form_validation->run()){
		   if($this->Acessos_model->add_acesso()){
		    $sucess = "Entrada simulada com sucesso";
            echo $sucess;
		   }
		   else{
		   	echo "erro a adcionar";
		   }

			}
		else{
			echo "erro nos argumentos";
			}

	}


}



?>
