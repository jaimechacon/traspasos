<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('App_model');
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

			$resultado = $this->App_model->agregarLog($usuario['id_usuario'], 'Descarga APK', 'Descarga APK');

				if(isset($resultado))
				{
					if(isset($resultado[0]))
					{
						if(isset($resultado[0]['resultado']) && $resultado[0]['resultado'] == "1")
						{
							header("Content-Type: application/force-download");
						    header('Content-Disposition: attachment; filename='.$name);
						    readfile($data);
						}
					}
				}
		}else
		{
			redirect('Inicio');
		}
	}


}