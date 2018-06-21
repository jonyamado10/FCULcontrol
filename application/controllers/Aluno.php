<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {

	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{
		if($this->session->userdata('is_logged_in_aluno')){
			$this->load->view('nav_aluno');
			$this->load->view('aluno_dashboard');
			$this->load->view('footer_aluno');
		}
		else{
			redirect('Main/login');
		}
	}
	public function dashboard()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}

		$this->load->view('aluno_dashboard');
	}
	public function tabela_meus_acessos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
  		$this->load->view('tabela_meus_acessos_aluno');

	}
	public function grafico_acessos24()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		$this->load->model('Acessos_model');
		
	    $data['acessos24'] = $this->Acessos_model->user_aluno_acessos24();
	    $this->load->view('aluno_grafico_acessos24',$data);     
	}
	public function minhasDisciplinas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
	    $this->load->view('tabela_disciplinas');     
	}

}
