<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __contruct(){
		parent::__contruct();
        $this->load->model('Users_model');

	}
	public function index()
	{
		if($this->session->userdata('is_logged_in_admin')){
			$this->load->model('Acessos_model');
			$sensores = $this->Acessos_model->sensores_avariados();
			$data['sensores'] = $sensores;
			$data1['rebelde'] = $this->Acessos_model->get_top1_aluno_mes();
			$data['rebeldeWK'] = $this->Acessos_model->get_top1_aluno_semana();
			$data1['top10'] = $this->Acessos_model->get_top10_alunos();
			$data1['num_sensores'] = $sensores;
			$data1['num_acessos_hj'] = $this->Acessos_model->get_num_acessos_hj();
			$data1['num_acessos_corrigidos_hj'] = $this->Acessos_model->get_num_acessos_corrigidos_hj();
			$data1['num_alunos_nao_passou_cartao'] = sizeof($this->Acessos_model->get_num_vezes_aluno_nao_passou_cartao_24h());			
			$this->load->view('nav',$data);
			$this->load->view('admin_dashboard',$data1);
			$this->load->view('footer');
		}
		else{
			redirect('Main/login');
		}
	}

	public function dashboard()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		$this->load->model('Acessos_model');
		$data['rebelde'] = $this->Acessos_model->get_top1_aluno_mes();
		$data['rebeldeWK'] = $this->Acessos_model->get_top1_aluno_semana();
		$data['top10'] = $this->Acessos_model->get_top10_alunos();
		$data['num_sensores'] = $this->Acessos_model->sensores_avariados();
		$data['num_acessos_hj'] = $this->Acessos_model->get_num_acessos_hj();
		$data['num_acessos_corrigidos_hj'] = $this->Acessos_model->get_num_acessos_corrigidos_hj();
		$data['num_alunos_nao_passou_cartao'] = sizeof($this->Acessos_model->get_num_vezes_aluno_nao_passou_cartao_24h());
		$this->load->view('admin_dashboard',$data);
	}
	public function tabela_alunos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
  		$this->load->view('tabela_alunos',array());

	}
	public function tabela_docentes()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
  		$this->load->view('tabela_docentes',array());

	}

	
	public function grafico_alunos_por_departamento()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

		$this->load->model('Users_model');
		$data['alunos_departamento']  = $this->Users_model->get_num_alunos_por_departamento();
		$this->load->view('grafico_alunos_departamento',$data);

	}

	public function gerar_acessos()

	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

		$this->load->view('gerar_acessos');
	}
	public function gerar_acessos_detalhados()

	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

		$this->load->view('gerar_acessos_detalhados');
	}
	public function gerar_acessos_detalhados_aluno()

	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

		$this->load->view('gerar_acessos_detalhados_aluno');
	}
	public function tabela_acessos_alunos_corrigidos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		// $this->load->model('Acessos_model');
	 //    if($this->Acessos_model->ha_novos_acessos_alunos()){
	 //     	if($this->Acessos_model->corrige_acessos_alunos()){
	 //     		$this->load->view('tabela_acessos_alunos_corrigidos',array());
	     	
	 //     	}
	 //     	else{
	 //          	echo "Erro a corrigir acessos";

	 //     	}
	 //    }
	 //    else{
	     	$this->load->view('tabela_acessos_alunos_corrigidos',array());
	     
	}
		public function tabela_acessos_alunos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

	    $this->load->view('tabela_acessos_alunos',array());
	     
	}
	public function tabela_acessos_docentes_corrigidos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		/*$this->load->model('Acessos_model');
	    if($this->Acessos_model->ha_novos_acessos_docentes()){
	     	if($this->Acessos_model->corrige_acessos_docentes()){
	     		$this->load->view('tabela_acessos_docentes_corrigidos',array());
	     	
	     	}
	     	else{
	          	echo "Erro a corrigir acessos";

	     	}
	    }
	    else{*/
	     	$this->load->view('tabela_acessos_docentes_corrigidos',array());
	     // }
	}
		public function tabela_acessos_docentes()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

	    $this->load->view('tabela_acessos_docentes',array());
	     
	}
	public function tabela_acessos_naoDocentes_corrigidos()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
/*		$this->load->model('Acessos_model');
	    if($this->Acessos_model->ha_novos_acessos_nao_docentes()){
	     	if($this->Acessos_model->corrige_acessos_nao_docentes()){
	     		$this->load->view('tabela_acessos_NaoDocentes_corrigidos',array());
	     	
	     	}
	     	else{
	          	echo "Erro a corrigir acessos";

	     	}
	    }
	    else{*/
	     	$this->load->view('tabela_acessos_NaoDocentes_corrigidos',array());
	 //    }
	}
	
	public function tabela_acessos_naoDocentes()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

	    $this->load->view('tabela_acessos_NaoDocentes',array());
	     
	}
	
	public function grafico_acessos24()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		$this->load->model('Acessos_model');
		
	    $data['acessos24'] = $this->Acessos_model->acessos24();
	    $this->load->view('grafico_acessos24',$data);
	     
	}
	public function grafico_acessos6m()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}
		$this->load->model('Acessos_model');
		
	    $data['acessos6m'] = $this->Acessos_model->acessos6m();
	    $this->load->view('grafico_acessos6m',$data);
	     
	}
	public function tabela_alertas()
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		{ redirect('Admin');}

	    $this->load->view('tabela_alertas',array());
	     
	}

	public function teste()
	{
	
$this->load->model('Users_model');
echo $this->Users_model->get_avg_percentagem_por_disciplina_docentes();
	}
}
?>