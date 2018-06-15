<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller {

	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{
		if($this->session->userdata('is_logged_in_docente')){
			$this->load->view('nav_docente');
			$this->load->view('docente_dashboard');
			$this->load->view('footer_docente');
		}
		else{
			redirect('Main/login');
		}
	}
	public function dashboard()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}

		$this->load->view('docente_dashboard');
	}
	public function tabela_meus_acessos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
  		$this->load->view('tabela_meus_acessos_docente');

	}
	public function minhasDisciplinas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
  		$this->load->view('docente_disciplinas');

	}
	public function minhasAulas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
  		$this->load->view('docente_aulas');

	}
	public function aulasPorDisciplinaLicenciatura($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('docente_aulas_disciplina_licenciatura',$data);

	}
	public function aulasPorDisciplinaMestrado($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('docente_aulas_disciplina_mestrado',$data);

	}
	public function aulasPorDisciplinaPosGraduacao($id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
		$data['id_disciplina']=$id_disciplina;
  		$this->load->view('docente_aulas_disciplina_pos_graduacao',$data);

	}
	public function presencasAulaLicenciatura($id_aula, $id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_aula']=$id_aula;
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_licenciatura($id_disciplina);
  		$this->load->view('docente_presencas_alunos_aula_licenciatura',$data);

	}
	public function presencasAulaMestrado($id_aula, $id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_aula']=$id_aula;
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_mestrado($id_disciplina);
  		$this->load->view('docente_presencas_alunos_aula_mestrado',$data);

	}
	public function presencasAulaPosGraduacao($id_aula, $id_disciplina)
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_aula']=$id_aula;
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_pos_graduacao($id_disciplina);
  		$this->load->view('docente_presencas_alunos_aula_pos_graduacao',$data);

	}
	public function alunosInscDisciplinaLicenciatura($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_licenciatura($id_disciplina);
  		$this->load->view('docente_alunos_inscritos_disciplina_licenciatura',$data);

	}
	public function totalAlunosInscDisciplinaLicenciatura($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_licenciatura($id_disciplina);
  		$this->load->view('docente_total_alunos_inscritos_disciplina_licenciatura',$data);

	}
	public function alunosInscDisciplinaMestrado($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_mestrado($id_disciplina);
  		$this->load->view('docente_alunos_inscritos_disciplina_mestrado',$data);

	}
	public function totalAlunosInscDisciplinaMestrado($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_mestrado($id_disciplina);
  		$this->load->view('docente_total_alunos_inscritos_disciplina_mestrado',$data);

	}
	public function alunosInscDisciplinaPosGraduacao($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_pos_graduacao($id_disciplina);
  		$this->load->view('docente_alunos_inscritos_disciplina_pos_graduacao',$data);

	}
	public function totalAlunosInscDisciplinaPosGraduacao($id_disciplina){
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Docente');}
	    $this->load->model('Users_model');
		$data['id_disciplina']=$id_disciplina;
		$data['disciplina']= $this->Users_model->get_designacao_disciplina_pos_graduacao($id_disciplina);
  		$this->load->view('docente_total_alunos_inscritos_disciplina_pos_graduacao',$data);

	}
}
