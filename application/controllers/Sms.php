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
		$usuario = $this->session->userdata();
		if($usuario){
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
				$username = $this->input->POST('username');

			if($this->input->POST('password'))
				$password = $this->input->POST('password');

			if($this->input->POST('ani'))
				$ani = $this->input->POST('ani');

			if($this->input->POST('dnis'))
				$dnis = $this->input->POST('dnis');

			if($this->input->POST('message'))
				$message = $this->input->POST('message');

			if($this->input->POST('other_messages'))
				$other_messages = $this->input->POST('other_messages');

			$todo = $this->Sms_model->saveSms($username, $password, $ani, $dni, $message, $other_messages);
		}
	}
	
}