<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends CI_Controller {

	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{
		if($this->session->userdata('is_logged_in_docente')){
			$this->load->model("Users_model");
			$this->load->model("Acessos_model");
			$data["n_acessos"]=$this->Acessos_model->get_num_acessos_24_user_docente();
			$data["percentagem"]=$this->Users_model->get_avg_percentagem_por_disciplina_user_docente();
			$data["n_aulas"]=$this->Users_model->get_num_aulas_hoje();
			$data["n_nao_passou_cartao"]=$this->Acessos_model->get_num_vezes_docente_n_passou_cartao_semana();

			
			$this->load->view('nav_docente');
			$this->load->view('docente_dashboard',$data);
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
		$this->load->model("Users_model");
		$this->load->model("Acessos_model");
		$data["n_nao_passou_cartao"]=$this->Acessos_model->get_num_vezes_docente_n_passou_cartao_semana();
		$data["n_acessos"]=$this->Acessos_model->get_num_acessos_semana_user_docente();
		$data["percentagem"]=$this->Users_model->get_avg_percentagem_por_disciplina_user_docente();
		$data["n_aulas"]=$this->Users_model->get_num_aulas_hoje();

		$this->load->view('docente_dashboard',$data);
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
	public function grafico_acessos24()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		$this->load->model('Acessos_model');
		
	    $data['acessos24'] = $this->Acessos_model->user_docente_acessos24();
	    $this->load->view('docente_grafico_acessos24',$data);
	     
	}
	public function tabela_assiduidades_medias()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
	    $this->load->view('tabela_media_assiduidades');
	     
	}
	public function teste(){
		date_default_timezone_set("Europe/Lisbon"); 
		$hora = date("G:i");
		$myhora = (string)$hora;
		echo sizeof($hora);
		if(sizeof($myhora)<=3){
			$myhora = "0".$hora;
		}
		echo $myhora;
		
	}
}
