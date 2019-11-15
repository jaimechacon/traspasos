<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sms_model');
		$this->load->library('NuSoap_lib');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$data = base_url().'assets/doc/providasms.apk';
			$name = "Precheck.apk";
			///readfile($data);
			//force_download($data, NULL);
			//exit;
			header("Content-Type: application/force-download");
		    header('Content-Disposition: attachment; filename='.$name);
		    readfile($data);
		}else
		{
			redirect('Inicio');
		}
	}


}