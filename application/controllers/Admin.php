<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __contruct(){
		parent::__contruct();

	}
	public function index()
	{

		$this->load->view('admin_dashboard');
	}
	public function dashboard()
	{
		if($this->session->userdata('is_logged_in') and $this->session->userdata('is_admin')){
			$this->load->view('admin_dashboard');
		}
		else{
			echo "sem permissao";
		}
	}
	public function table()
	{
		$this->load->view('admin_dashboard');
	}
	
	public function chart()
	{
		$this->load->view('simulador');
	}
}
