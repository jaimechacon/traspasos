<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

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
			$validacionesPendientes = $this->Sms_model->listarTraspasosPendientes($usuario['id_usuario']);
			$usuario['validacionesPendientes'] = $validacionesPendientes;
			$usuario['controller'] = 'sms';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarValidacionesPendientes', $usuario);
			$this->load->view('temp/footer', $usuario);
			//$this->add_customer();
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarValidacionesPendientes()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$validacionesPendientes = $this->Sms_model->listarTraspasosPendientes($usuario['id_usuario']);
			$usuario['validacionesPendientes'] = $validacionesPendientes;
			$usuario['controller'] = 'sms';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarValidacionesPendientes', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Inicio');
		}
	}

	public function validarRCOT()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$id_sms = "null";
			if(!is_null($this->input->post('id_sms')) && $this->input->post('id_sms') != "-1" && $this->input->post('id_sms') != "")
				$id_sms = $this->input->post('id_sms');

			$tipo = "null";
			if(!is_null($this->input->post('tipo')) && $this->input->post('tipo') != "-1" && $this->input->post('tipo') != "")
				$tipo = $this->input->post('tipo');


			$resultado = $this->Sms_model->validarRCOT($usuario["id_usuario"], $id_sms, $tipo);
			

			if(isset($resultado))
			{
				if(isset($resultado[0]))
				{
					if(isset($resultado[0]['rut_afiliado']) && isset($resultado[0]['periodo']) && isset($resultado[0]['telefono']))
					{
						$telefono = $resultado[0]['telefono'];
						$rut_afiliado = (substr($resultado[0]['rut_afiliado'], 0, ((strlen($resultado[0]['rut_afiliado']))-1)).'-'.substr($resultado[0]['rut_afiliado'], ((strlen($resultado[0]['rut_afiliado']))-1), 1));

						$mensaje = "";
						if($tipo == "1" || $tipo == "2")
						{
							$mensaje = "ProVida AFP Confirma la recepción de tus datos. El código de validación es ".$id_sms.".";
						}

						/*if($tipo == "2")
						{
							$mensaje = "Afiliado NO VIGENTE";
						}*/

						if($tipo == "3")
						{
							$mensaje = "ProVida no pudo validar los datos de tu cédula de identidad. Por favor revísalos con el ejecutivo.";
						}

						if($tipo == "4" && $resultado[0]['enviar_sms'] == "1")
						{
							$mensaje = "ProVida no pudo validar los datos de tu cédula de identidad. Por favor revísalos con el ejecutivo.";
						}

						if($mensaje != "")
						{
							$parametros['celular'] = $telefono;
							$parametros['mensaje'] = $mensaje;
							$se_envio = $this->enviarSms($parametros);
						}

						//var_dump($se_envio, $telefono, $mensaje, $tipo);

						$periodo = $resultado[0]['periodo'];
						$this->obtenerDatosPrevired($id_sms, $rut_afiliado, $periodo, $tipo);
						echo json_encode($resultado[0]["resultado"]);
					}
					


				}
			}
		}else
		{
			redirect('Login');
		}
	}

	private function obtenerDatosPrevired($id_sms, $rut_afiliado, $periodo, $tipo) {

		try {
			$usuario = $this->session->userdata();
			if(isset($usuario['id_usuario'])){
				$post = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
				$post .= '<peticion llave="ProvidaPrevired2019">';
				$post .= '<peticionservicio tipo="AUT">';
				$post .= '<parametro nombre="usuario" valor="76265736-8" />';
				$post .= '<parametro nombre="password" valor="ProvidaPrevired2019" />';
				$post .= '</peticionservicio>';
				$post .= '<peticionservicio tipo="CAF">';
			    $post .= '<parametro nombre="rut" valor="'.$rut_afiliado.'" />';
			    $post .= '<parametro nombre="periodo" valor="'.$periodo.'" />';
		        $post .= '</peticionservicio>';
		     	$post .= '</peticion>';

		     	$cliente = new nusoap_client("https://qagintegracion.previred.com/wIntegracion/axis/services/MonitorPrevired?wsdl", true);
		     	//$cliente = new nusoap_client("https://wbackend.previred.com/axis/services/MonitorPrevired?wsdl", true);
		     	$array_ws = array('xml' => $post);
		     	$respuesta = $cliente->call('ejecuta', array('xml' => $post));

				$simpleXml = simplexml_load_string($respuesta);

				mysqli_next_result($this->db->conn_id);
				$resultado = $this->Sms_model->agregarLog($usuario['id_usuario'], $id_sms, $simpleXml);

				$cant = 0;
				$cantNod = 0;

				if(isset($simpleXml) && isset($simpleXml->control) && isset($simpleXml->control['codigo']) && sizeof(((string)$simpleXml->control['codigo'][0])) > 0)
				{
					$codigo = (string)$simpleXml->control['codigo'];
					if($codigo == "9000")
					{
						foreach ($simpleXml->respuestaservicio as $servicio) {
							if(isset($servicio) && isset($servicio->attributes()['tipo']) && sizeof((string)$servicio->attributes()['tipo']) > 0)
							{
								//var_dump(isset($servicio->attributes()['tipo']));
								$tipo_servicio = (string)$servicio->attributes()['tipo'];
								if($tipo_servicio == 'CAF')
								{
									if(isset($servicio) && isset($servicio->control) && isset($servicio->control['codigo']) && sizeof(((string)$servicio->control['codigo'])) > 0)
									{
										$codigo_servicio = (string)$servicio->control['codigo'];
										if($codigo_servicio == '9050' && isset($servicio->respuestacaf->linea))
										{
											// sin errores
											//var_dump(''.(string)$servicio->respuestacaf->linea->attributes());
											/*var_dump('Rut: '.(string)$servicio->respuestacaf->linea->attributes()['rut'].'<br/>');
											var_dump('Nombres: '.(string)$servicio->respuestacaf->linea->attributes()['nombres'].'<br/>');
											var_dump('Apellido_Paterno: '.(string)$servicio->respuestacaf->linea->attributes()['apellidopaterno'].'<br/>');
											var_dump('Apellid_Materno: '.(string)$servicio->respuestacaf->linea->attributes()['apellidomaterno'].'<br/>');
											var_dump('Cod_AFP: '.(string)$servicio->respuestacaf->linea->attributes()['codafp'].'<br/>');
											var_dump('Nombre_AFP: '.(string)$servicio->respuestacaf->linea->attributes()['nomafp'].'<br/>');
											var_dump('Fecha_Nac: '.(string)$servicio->respuestacaf->linea->attributes()['fechanacimiento'].'<br/>');
											var_dump('Genero: '.(string)$servicio->respuestacaf->linea->attributes()['sexo'].'<br/>');
											var_dump('Fecha_Ing: '.(string)$servicio->respuestacaf->linea->attributes()['fechaingreso'].'<br/>');
											var_dump('Fecha_Sub: '.(string)$servicio->respuestacaf->linea->attributes()['fechasubscripcion'].'<br/>');
											var_dump('Fecha_Inc: '.(string)$servicio->respuestacaf->linea->attributes()['fechaincorporacion'].'<br/>');
											var_dump('Tipo_Solicitud: '.(string)$servicio->respuestacaf->linea->attributes()['tiposolicitud'].'<br/>');
											var_dump('Situacion: '.(string)$servicio->respuestacaf->linea->attributes()['situacion'].'<br/>');
											var_dump('Cta_Personales: '.(string)$servicio->respuestacaf->linea->attributes()['cuentaspersonales'].'<br/>');*/

											$rut = (string)$servicio->respuestacaf->linea->attributes()['rut'];
											$nombres = (string)$servicio->respuestacaf->linea->attributes()['nombres'];
											$apellido_Paterno = (string)$servicio->respuestacaf->linea->attributes()['apellidopaterno'];
											$apellid_Materno = (string)$servicio->respuestacaf->linea->attributes()['apellidomaterno'];
											$cod_AFP = (string)$servicio->respuestacaf->linea->attributes()['codafp'];
											$nombre_AFP = (string)$servicio->respuestacaf->linea->attributes()['nomafp'];
											$fecha_Nac = (string)$servicio->respuestacaf->linea->attributes()['fechanacimiento'];
											$genero = (string)$servicio->respuestacaf->linea->attributes()['sexo'];
											$fecha_Ing = (string)$servicio->respuestacaf->linea->attributes()['fechaingreso'];
											$fecha_Sub = (string)$servicio->respuestacaf->linea->attributes()['fechasubscripcion'];
											$fecha_Inc = (string)$servicio->respuestacaf->linea->attributes()['fechaincorporacion'];
											$tipo_Solicitud = (string)$servicio->respuestacaf->linea->attributes()['tiposolicitud'];
											$situacion = (string)$servicio->respuestacaf->linea->attributes()['situacion'];
											$cta_Personales = (string)$servicio->respuestacaf->linea->attributes()['cuentaspersonales'];

											//var_dump($servicio->respuestacaf);
											$es_hombre = ($genero == "M" ? 1 : ($genero == "F" ? 0 : null));
											mysqli_next_result($this->db->conn_id);
											$resultado = $this->Sms_model->actualizarOTPrevired($usuario['id_usuario'], $id_sms, $nombres, $apellido_Paterno, $apellid_Materno, $es_hombre, $nombre_AFP, $cod_AFP, $cta_Personales, date("Y-m-d", strtotime($fecha_Nac)), date("Y-m-d", strtotime($fecha_Ing)), date("Y-m-d", strtotime($fecha_Sub)), date("Y-m-d", strtotime($fecha_Inc)), $tipo_Solicitud, $situacion, $situacion);

											if(isset($resultado))
											{
												if(isset($resultado[0]))
												{
													if(isset($resultado[0]) == "1")
													{
														
														/*$mensaje = "";
														$telefono = $resultado[0]['telefono'];

														if($tipo == "1")
														{
															$mensaje = "Afiliado VIGENTE, institucion: ".$cod_AFP.' - '.$nombre_AFP;
														}

														if($tipo == "2")
														{
															$mensaje = "Afiliado NO VIGENTE";
														}

														if($tipo == "3" || $tipo == "4")
														{
															$mensaje = "Afiliado PENDIENTE DE VALIDACION";
														}

														$parametros['celular'] = $telefono;
														$parametros['mensaje'] = $mensaje;
														$se_envio = $this->enviarSms($parametros);*/
													}else
													{

													}
												}
											}


										}else
										{
											if($codigo_servicio == '9060')
											{
												//Error en el tipo de servicio indicado.
											}else
											{
												if ($codigo_servicio == '9070') {
													//El usuario no tiene permisos para ejecutar este servicio
												} else {
													//Error no identificado
												}
											}
										}
									}
									
								}
							}

							//var_dump((string)$value->attributes()['tipo']);

						}
						//var_dump('exito');
					}else
					{
						var_dump('error en el formato del xml');
					}
				}
			}else{
				redirect('Login');
			}
		} catch (Exception $e) {
			
		}
	}

	public function Parse($url) {

		$fileContents= $url;

		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);

		$fileContents = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $fileContents);

		$simpleXml = simplexml_load_string($fileContents);

		$json = json_encode($simpleXml);

		return $json;

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
					$datos = explode("_", $data->message);
					if(sizeof($datos) == 5){
						$rut = $datos[0];
						$serie = $datos[1];
						$tipo_documento = (int)$datos[2];
						$telefono = $datos[3];
						$folio = $datos[4];


						$query = $this->Sms_model->agregarSMS($data->username, $data->password, $data->ani, $data->dnis, $data->message, $data->other_messages, $rut, $serie, $tipo_documento, $telefono, $folio);

						if($query != null && $query[0]['resultado'] == "1")
						{
							//validar con previred
						}else{
							$mensaje = $query[0]['mensaje'];
							$parametros['celular'] = $data->ani;
							$parametros['mensaje'] = $mensaje;
							$se_envio = $this->enviarSms($parametros);

							if($se_envio === 0){
								for ($intentos=0; $intentos < 3; $intentos++) { 
									if($se_envio === 0){
										$se_envio = $this->enviarSms($parametros);
									}
								}
							}
						}
					}
				}
			}
		}
	}

	private function enviarSms($parametros){
	    $codsms=null;
	    #$nombre = explode(" ", $parametros['nombres'])[0];
	    #$apellido = explode(" ", $parametros['apellidos'])[0];

	    #$mensaje = 'Provida: Estimado '.$nombre.' '.$apellido.', verifica tu identidad en la url: '.base_url().'Traspaso/verificarIdentidadCliente/'.$parametros['idTraspaso'].' .';
	    $mensaje =  $parametros['mensaje'];

	    // echo $idllamada; exit();
	    ini_set("soap.wsdl_cache_enabled", "0"); 

	    //$mensaje = "Número de Atención: ".$idllamada." Rut Cliente: ".$rut;

	    //$client = new SoapClient(WS_URL_ITD);
	    $client = new SoapClient('http://ida.itdchile.cl/services/smsApiService?wsdl');

	    $array_ws = array('in0' => 'jchacon',
	                      'in1' => 'chacon8049',
	                      'in2' => $parametros['celular'],
	                      'in3' => $mensaje);

	    $response = $client->sendSms($array_ws);
	    //var_dump($response); exit();
	    $codsms = $response->out->entry[1]->value;
	    //var_dump($response);
	    //echo $codsms; exit();

	    if ($codsms != null and $codsms != '' and $codsms != '-1') {       
	    return 1;
	      }else{
	    return 0;
	      } 
    }
	
}