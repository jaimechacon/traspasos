<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('inicio_model');
	}

	public function index()
	{
		$usuario = $this->session->userdata();

		if($this->session->has_userdata('id_usuario'))
		{			
			$perfil = $this->usuario_model->traerPerfilUsu($usuario["id_usuario"]);
			$usuario['controller'] = 'inicio';
			$usuario['perfil'] = $perfil[0];
			if($perfil[0]['analista'] == "4")
			{
				redirect('Sms');
			}else{
				/*eliminar desde aca 
				try {
					$post = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
					$post .= '<peticion llave="2vUR4BV2iS">';
					$post .= '<peticionservicio tipo="AUT">';
					$post .= '<parametro nombre="usuario" valor="76391999-4" />';
					$post .= '<parametro nombre="password" valor="2vUR4BV2iS" />'; //ProvidaPrevired2019" />';
					$post .= '</peticionservicio>';
					$post .= '<peticionservicio tipo="CAF">';
				    $post .= '<parametro nombre="rut" valor="43781383" />';
				    $post .= '<parametro nombre="periodo" valor="202001" />';
			        $post .= '</peticionservicio>';
			     	$post .= '</peticion>';


			     	$wsdl = 'https://wbackend.previred.com/axis/services/MonitorPrevired?wsdl';
					$url = 'https://wbackend.previred.com/axis/services/MonitorPrevired';
		

					$soapx = new SoapClient($wsdl,
					    array(
					    	'trace' => true,
							'cache_wsdl' => WSDL_CACHE_NONE,
							'location' => $url,
							'xml' => $post
							)
					);

			     	$response = $soapx->__soapCall("ejecuta", array('xml' => $post));

			     	$simpleXml = simplexml_load_string($response);
			     	
					$cant = 0;
					$cantNod = 0;

					var_dump($simpleXml);
				
				} catch (Exception $e) {
					
				}*/

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('inicioSesion', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}else
		{
			$this->session->sess_destroy();
			$login['login'] = 0;
			$this->load->view('temp/header_index', $login);
			$this->load->view('temp/menu_index');
			$this->load->view('inicio');
			$this->load->view('temp/footer');
		}
	}

	public function inicio()
	{
		$usuario = $this->session->userdata();
		if(!$usuario){
			$this->session->sess_destroy();
		}else
		{
			$login['login'] = 0;
			$this->load->view('temp/header_index', $login);
			$this->load->view('temp/menu_index');
			$this->load->view('inicio');
			$this->load->view('temp/footer');
		}

	}

	public function politica_de_confidencialidad()
	{
		$mi_pdf = 'assets/doc/Precheck-ProVida-AFP-Politicas-de-Confidencialidad-y-Seguridad-de-la-app.pdf'; 
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="'.$mi_pdf.'"');
		readfile($mi_pdf); 
	}
}
