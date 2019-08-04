<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('perfil_model');
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

	public function listarUsuarios()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuarios = $this->usuario_model->buscarUsuario('', (int)$usuario["id_usuario"]);
			$usuario['usuarios'] = $usuarios;
			$usuario['controller'] = 'usuario';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarUsuarios', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
	}

	public function buscarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$filtroUsuario = "";
			if($this->input->POST('usuario'))
				$filtroUsuario = $this->input->POST('usuario');
			echo json_encode($this->usuario_model->buscarUsuario($filtroUsuario, (int)$usuario["id_usuario"]));
		}
	}

	public function agregarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuario['titulo'] = 'Agregar Usuario';
			$usuario['controller'] = 'usuario';
			
			$perfiles =  $this->perfil_model->obtenerPerfiles($usuario["id_usuario"]);
			if($perfiles)
				$usuario['perfiles'] = $perfiles;

			mysqli_next_result($this->db->conn_id);


			$empresas =  $this->usuario_model->obtenerEmpresasUsu($usuario["id_usuario"]);
			if($empresas)
			{
				$usuario['empresas'] = $empresas;
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarUsuario', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
	}

	public function guardarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if(!is_null($this->input->POST('nombres')))
			{
				if(!is_null($this->input->POST('apellidos')))
				{
					$rut = "null";
					if(!is_null($this->input->POST('rut')) && trim($this->input->POST('rut')) != "")
						$rut = trim($this->input->POST('rut'));

					$idEmpresa = "null";
					if(!is_null($this->input->POST('idEmpresa')) && trim($this->input->POST('idEmpresa')) != "")
						$idEmpresa = trim($this->input->POST('idEmpresa'));

					$nombres = "null";
					if(!is_null($this->input->POST('nombres')) && trim($this->input->POST('nombres')) != "")
						$nombres = trim($this->input->POST('nombres'));

					$apellidos = "null";
					if(!is_null($this->input->POST('apellidos')) && trim($this->input->POST('apellidos')) != "")
						$apellidos = trim($this->input->POST('apellidos'));
						
					$email = "null";
					if(!is_null($this->input->POST('email')) && trim($this->input->POST('email')) != "")
						$email = trim($this->input->POST('email'));

					$codUsuario = "null";
					if(!is_null($this->input->POST('codUsuario')) && trim($this->input->POST('codUsuario')) != "")
						$codUsuario = trim($this->input->POST('codUsuario'));

					$idPerfil = "null";
					if(!is_null($this->input->POST('idPerfil')) && trim($this->input->POST('idPerfil')) != "")
						$idPerfil = trim($this->input->POST('idPerfil'));

					$contabilizar = "null";
					if(!is_null($this->input->POST('contabilizar')) && trim($this->input->POST('contabilizar')) != "")
						$contabilizar = trim($this->input->POST('contabilizar'));

					$accion = 'agregado';
					
					$idUsuario = 'null';
					if(!is_null($this->input->POST('idUsuario')) && is_numeric($this->input->POST('idUsuario')))
					{
						$idUsuario = $this->input->POST('idUsuario');
						$accion = 'modificado';
					}

					$respuesta = 0;
					$mensaje = '';

					$resultado = $this->usuario_model->guardarUsuario($idUsuario, $rut, $idEmpresa, $nombres, $apellidos, $email, $codUsuario, $contabilizar, $idPerfil,  $usuario["id_usuario"]);

					if($resultado[0] > 0)
					{

						if($resultado[0]['idUsuario'])
						{
							if($idUsuario == 'null')
								$idUsuario = (int)$resultado[0]['idUsuario'];
							
							$respuesta = 1;
							$mensaje = 'Se ha '.$accion.' el usuario exitosamente.';
						}
					}else
					{
						if($resultado === 0)
						{
							$mensaje = 'Ha ocurrido un error al '.$accion.' la categor&iacute;a, la categor&iacute;a no se encuentra registrado.';
						}
					}
					$data['respuesta'] = $respuesta;
					$data['mensaje'] = $mensaje;
					echo json_encode($data);
				}
			}
		}
	}

	public function eliminarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idUsuario = null;
			if($this->input->POST('idUsuario'))
				$idUsuario = $this->input->POST('idUsuario');
			$resultado = $this->usuario_model->eliminarUsuario($idUsuario, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function modificarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuario['titulo'] = 'Modificar Usuario';
			$usuario['controller'] = 'usuario';

			if($this->input->GET('idUsuario') && $this->input->GET('idUsuario'))
			{
				//mysqli_next_result($this->db->conn_id);
				$idUsuario = $this->input->GET('idUsuario');
				$usuarioSeleccionado =  $this->usuario_model->obtenerUsuario($idUsuario);
				$usuario['usuarioSeleccionado'] = $usuarioSeleccionado[0];

				mysqli_next_result($this->db->conn_id);
				$perfiles =  $this->perfil_model->obtenerPerfiles($usuario["id_usuario"]);
				if($perfiles)
					$usuario['perfiles'] = $perfiles;

				mysqli_next_result($this->db->conn_id);

				$empresas =  $this->usuario_model->obtenerEmpresasUsu($usuario["id_usuario"]);
				if($empresas)
				{
					$usuario['empresas'] = $empresas;
				}


				//var_dump($equipo[0]);
				
				//$eacs = array_unique(array_column($equipo, 'nombre'), array_column($equipo, 'abreviacion'), array_column($equipo, 'descripcion'));
				//$eacs = array_unique(array_map("serialize", $equipo));
				//var_dump($temp);
				/*$cat_pauta = array_intersect_key($pauta, $temp);
				$usuario['cat_pauta'] = $cat_pauta;*/
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarUsuario', $usuario);
			$this->load->view('temp/footer');
		}
	}
	
}