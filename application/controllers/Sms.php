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
		//$usuario = $this->session->userdata();
		//$usuarios = $this->usuario_model->buscarUsuario('', (int)$usuario["id_usuario"]);
		//$usuario['usuarios'] = $usuarios;
		//$usuario['controller'] = 'usuario';

		$username = "";
		$password = "";
		$ani = "";
		$dnis = "";
		$message = "";
		$other_messages = "";


		if($this->input->POST('username'))
			$username = json_decode($this->input->POST('username'));

		if($this->input->POST('password'))
			$password = json_decode($this->input->POST('password'));

		if($this->input->POST('ani'))
			$ani = json_decode($this->input->POST('ani'));

		if($this->input->POST('dnis'))
			$dnis = json_decode($this->input->POST('dnis'));

		if($this->input->POST('message'))
			$message = json_decode($this->input->POST('message'));

		if($this->input->POST('other_messages'))
			$other_messages = json_decode($this->input->POST('other_messages'));
		
		$query = $this->Sms_model->saveSms($username, $password, $ani, $dnis, $message, $other_messages);

		return 'hola'.$query;
		//$this->load->view('listarUsuarios', $usuario);

	}
	
}