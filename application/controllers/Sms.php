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
			$this->load->view('listarValidacionesPendientes', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			redirect('Inicio');
		}
	}

	public function receiveSMS()
	{
		$json = file_get_contents('php://input');

		if($json != null)
		{
			$data = json_decode($json);

			if($data != null && $data->username != null && $data->password != null)
			{
				if($data->username == "Sglo2019" && $data->password == "Sg.2019$$##")
				{
					var_dump(explode("_",'175903267_107311071_1_89233272_1234'));
					var_dump(sizeof(explode("_",'175903267_107311071_1_89233272_1234')));
					$datos = explode("_", $data->message);
					if(sizeof($datos) == 5){
						$rut = $datos[0];
						$serie = $datos[1];
						$tipo_documento = (int)$datos[2];
						$telefono = $datos[3];
						$folio = $datos[4];

						$query = $this->Sms_model->saveSms($data->username, $data->password, $data->ani, $data->dnis, $data->message, $data->other_messages, $rut, $serie, $tipo_documento, $telefono);#, $folio);
					}
				}
			}
		}
	}
	
}