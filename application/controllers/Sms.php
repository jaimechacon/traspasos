<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sms_model');
		//$this->load->model('perfil_model');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarUsuarios', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function receiveSMS()
	{
		$username = "";
		$password = "";
		$ani = "";
		$dnis = "";
		$message = "";
		$other_messages = "";
		
		$json = file_get_contents('php://input');

		if($json != null)
		{
			$data = json_decode($json);
			if($data != null && $data->username != null && $data->password != null)
			{
				if($data->username == "Sglo2019" && $data->username == "Sg.2019$$##")
				{
					$query = $this->Sms_model->saveSms($data->username, $data->password, $data->ani, $data->dnis, $data->message, $data->other_messages);
				}
			}
		}
	}
	
}