<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {

	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{
		if($this->session->userdata('is_logged_in_aluno')){
			$this->load->model('Users_model');
			$this->load->model('Acessos_model');
			$data["n_acessos"]=$this->Acessos_model->get_num_acessos_24_user_aluno();
			$data["percentagem"]=$this->Users_model->get_avg_percentagem_por_disciplina_user_aluno();
			$data["n_aulas"]=$this->Users_model->get_num_aulas_hoje_aluno();
			$data["n_nao_passou_cartao"]=$this->Acessos_model->get_num_vezes_aluno_n_passou_cartao_semana();
			$data["graf_assiduidades"] = $this->Users_model->grafico_assiduidades_user_aluno();

			$this->load->view('nav_aluno');
			$this->load->view('aluno_dashboard',$data);
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
		$this->load->model('Users_model');
		$this->load->model('Acessos_model');
		$data["n_acessos"]=$this->Acessos_model->get_num_acessos_24_user_aluno();
		$data["percentagem"]=$this->Users_model->get_avg_percentagem_por_disciplina_user_aluno();
		$data["n_aulas"]=$this->Users_model->get_num_aulas_hoje_aluno();
		$data["n_nao_passou_cartao"]=$this->Acessos_model->get_num_vezes_aluno_n_passou_cartao_semana();
		$data["graf_assiduidades"] = $this->Users_model->grafico_assiduidades_user_aluno();

		$this->load->view('aluno_dashboard',$data);
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
		{ redirect('Aluno');}
		$this->load->model('Acessos_model');
		
	    $data['acessos24'] = $this->Acessos_model->user_aluno_acessos24();
	    $this->load->view('aluno_grafico_acessos24',$data);     
	}
	public function minhasDisciplinas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
	    $this->load->view('aluno_disciplinas');     
	}
	public function aulasPorDisciplinaLicenciatura($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('aluno_aulas_disciplina_licenciatura',$data);

	}
	public function aulasPorDisciplinaMestrado($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('aluno_aulas_disciplina_mestrado',$data);

	}
	public function aulasPorDisciplinaPosGraduacao($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('aluno_aulas_disciplina_pos_graduacao',$data);

	}
	public function tabela_assiduidades_medias()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
	    $this->load->view('tabela_media_assiduidades_aluno');
	     
	}
	public function minhasAulas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Aluno');}
	    $this->load->view('aluno_aulas');
	     
	}

}
