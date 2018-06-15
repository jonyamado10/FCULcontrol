<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{

		if($this->session->userdata('is_logged_in_admin')){
			redirect('Admin');
		}
		elseif ($this->session->userdata('is_logged_in_docente')){
			redirect('Docente');
		}
		elseif($this->session->userdata('is_logged_in_aluno')){
			redirect('Aluno');
		}
		else {
			$this->load->view('login');
		}
	}
	public function login()
	{
		if($this->session->userdata('is_logged_in_admin')){
			redirect('Admin');
		}
		elseif ($this->session->userdata('is_logged_in_docente')){
			redirect('Docente');
		}
		elseif($this->session->userdata('is_logged_in_aluno')){
			redirect('Aluno');
		}
		else {
			$this->load->view('login');
		}
	}
	
	public function simulador()
	{
		$this->load->view('simulador');
	}
		public function aluno()
	{
		print_r($this->session->userdata());
	}

}
