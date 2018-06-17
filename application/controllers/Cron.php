<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __contruct(){
		parent::__contruct();
        $this->load->model('Users_model');

	}

	public function corrige_acessos()
	{

		$this->load->model('Acessos_model');
	    if($this->Acessos_model->ha_novos_acessos_alunos()){
	     	$this->Acessos_model->corrige_acessos_alunos();
	     	echo "OK ALUNOS";
	    }
	   	if($this->Acessos_model->ha_novos_acessos_docentes()){
	     	$this->Acessos_model->corrige_acessos_docentes();
	     	echo "OK ALUNOS";
	    }
	   	if($this->Acessos_model->ha_novos_acessos_nao_docentes()){
	     	$this->Acessos_model->corrige_acessos_nao_docentes();
	     	echo "OK ALUNOS";
	    }

	}

}
?>