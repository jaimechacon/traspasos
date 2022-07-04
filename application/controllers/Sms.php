<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sms_model');
		$this->load->model('App_model');
		$this->load->library('excel');
		//$this->load->library('NuSoap_lib');
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

	public function validarRut()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$validacionesPendientes = $this->Sms_model->listarTraspasosPendientesRut($usuario['id_usuario']);
			$usuario['validacionesPendientes'] = $validacionesPendientes;
			$usuario['controller'] = 'sms';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('validarRut', $usuario);
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

			$rut = "";
			$dv = "";
			$rut_completo = "";
			if(!is_null($this->input->post('rut')) && $this->input->post('rut') != "-1" && $this->input->post('rut') != "")
				{
					$rut_completo = $this->input->post('rut');
					$rut = substr($rut_completo, 0, (strlen($rut_completo)-1));
					$dv = substr($rut, (strlen($rut)-1), 1);
				}

			$serie = "";
			if(!is_null($this->input->post('serie')) && $this->input->post('serie') != "-1" && $this->input->post('serie') != "")
				$serie = $this->input->post('serie');

			$tipo_doc = "";
			if(!is_null($this->input->post('tipo_doc')) && $this->input->post('tipo_doc') != "-1" && $this->input->post('tipo_doc') != "")
				$tipo_doc = $this->input->post('tipo_doc');

			$tipo = "";
			if(!is_null($this->input->post('tipo')) && $this->input->post('tipo') != "-1" && $this->input->post('tipo') != "")
				$tipo = $this->input->post('tipo');

			$validarRut = null;
			if(!is_null($this->input->post('validarRut')) && $this->input->post('validarRut') == "1" && $this->input->post('validarRut') != "")
				$validarRut = $this->input->post('validarRut');

			//var_dump($validarRut);

		

			if (is_null($validarRut)) {

				for ($o=0; $o < 3; $o++) {
					
					$username = "u9PfV4nzdlu2JTWYcnovAOzQhv5PkpP";
					$password = "KUs0QJdYZ6DGLaNK";
					$host = "https://api.minsal.cl/v1/personas/srcei/verificaciones/identidades?codTipoDocumento=C&numRUN=".$rut."&numSerie=".$serie;
					$token = $this->getToken();

					//var_dump($token);

					$headers = array(
				        'Content-Type:application/json',
				        'Authorization: Bearer '. $token // place your auth details here
				    );

					$ch = curl_init($host);
					// To save response in a variable from server, set headers;
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					// Get response
					$response = curl_exec($ch);
					// Decode
					$result = json_decode($response);

					if($result)
					{
						$tipo_result = "null";
						$estado = "null";
						$cod_codigo = "null";
						$accion = "null";
						$aplicacion = "null";
						$parametros_api = "null";
						$ruta = "null";
						$uri = "null";
						$cod_estado_respuesta = "null";
						$desc_estado_respuesta = "null";
						$runPersona_resultado = "null";
						$dvPersona_resultado = "null";
						$codTipoDocumento_resultado = "null";
						$codClaseDocumento_resultado = "null";
						$numDocumento_resultado = "null";
						$numSerie_resultado = "null";
						$indVigencia_resultado = "null";
						$fhoVcto_resultado = "null";
						$indBloqueo_resultado = "null";
						$obs_respuesta = "null";
						$error_respuesta = "null";
						$tiempo = "null";
						$organizacion = "null";
						$ip = "null";
						$id = "null";
						$cod_obs_respuesta = "null";
						$descripcion_obs_respuesta = "null";

						if (isset($result->tipo)) {
							$tipo_result = $result->tipo;
							$estado = $result->estado;
							$cod_codigo = $result->codigo;
							$accion = $result->accion;
							$aplicacion = $result->aplicacion;
							$parametros_api = $result->parametros;
							$ruta = $result->ruta;
							$uri = $result->uri;

							if($estado == 200)
							{
								$o = 3;
								$cod_estado_respuesta = $result->respuesta->estado->codigo;
								$desc_estado_respuesta = $result->respuesta->estado->descripcion;

								//$resultado_respuesta = $result->respuesta->resultado;
								if ($cod_estado_respuesta == "OK") {
									$runPersona_resultado = $result->respuesta->resultado->runPersona;  
									$dvPersona_resultado = $result->respuesta->resultado->dvPersona;
									$codTipoDocumento_resultado = $result->respuesta->resultado->codTipoDocumento;
									$codClaseDocumento_resultado = $result->respuesta->resultado->codClaseDocumento;
									$numDocumento_resultado = $result->respuesta->resultado->numDocumento;
									$numSerie_resultado = $result->respuesta->resultado->numSerie;
									$indVigencia_resultado = $result->respuesta->resultado->indVigencia;
									$fhoVcto_resultado = $result->respuesta->resultado->fhoVcto;
									$indBloqueo_resultado = $result->respuesta->resultado->indBloqueo;
									$obs_respuesta = $result->respuesta->observaciones;

									if ($indVigencia_resultado == "S" && $indBloqueo_resultado == "NO BLOQUEADO") {
										$tipo = 5;
									}else
									{
										if ($indVigencia_resultado == "S" && $indBloqueo_resultado == "BLOQUEADO") {
											$tipo = 6;
										}else
										{
											if ($indVigencia_resultado != "S") {
												$tipo = 7;
											}
										}
									}
								}else
								{
									$cod_obs_respuesta = $result->respuesta->observaciones[0]->codigo;
									$descripcion_obs_respuesta = $result->respuesta->observaciones[0]->descripcion;
									$error_respuesta = $result->respuesta->error;
									$tiempo = $result->tiempo;
									$organizacion = $result->organizacion;
									$ip = $result->ip;
									$id = $result->id;
									$tipo = "1";
								}
							}else
							{
								if($o == 2)
								{
									$tipo = "1";
								}
							}
						}

						//var_dump($o);
						
						//if ($o > 0 && $o != 3)
							

						$resultado_cedula = $this->Sms_model->agregarLogCedula($tipo_result, $estado, $cod_codigo, $accion, $aplicacion, $parametros_api, $ruta, $uri, $cod_estado_respuesta, $desc_estado_respuesta, $runPersona_resultado, $dvPersona_resultado, $codTipoDocumento_resultado, $codClaseDocumento_resultado, $numDocumento_resultado, $numSerie_resultado, $indVigencia_resultado, $fhoVcto_resultado, $indBloqueo_resultado, $obs_respuesta, $error_respuesta, $tiempo, $organizacion, $ip, $id, $cod_obs_respuesta, $descripcion_obs_respuesta, $id_sms);
						mysqli_next_result($this->db->conn_id);
					}
				}

				//mysqli_next_result($this->db->conn_id);
				$resultado = $this->Sms_model->validarRCOT($usuario["id_usuario"], $id_sms, $tipo);

				//var_dump($resultado);
				if(isset($resultado))
				{
					//var_dump('entro a resultados <br/>');
					if(isset($resultado[0]))
					{
						//var_dump('entro a resultados   [0] <br/>');
						if(isset($resultado[0]['rut_afiliado']) && isset($resultado[0]['periodo']) && isset($resultado[0]['telefono']))
						{
							//var_dump('entro a resultados   [0]   [rut_afiliado] <br/>');
							$telefono = $resultado[0]['telefono'];
							$rut_afiliado = (substr($resultado[0]['rut_afiliado'], 0, ((strlen($resultado[0]['rut_afiliado']))-1)).'-'.substr($resultado[0]['rut_afiliado'], ((strlen($resultado[0]['rut_afiliado']))-1), 1));

							$mensaje = "";

							//var_dump($telefono);

							if($tipo == "1" || $tipo == "2" || $tipo == 5 || $tipo == 2)
							{
								$mensaje = "ProVida AFP Confirma la recepción de tus datos. El código de validación es ".$id_sms.".";
							}

							//if($tipo == "2")
							//{
							//	$mensaje = "Afiliado NO VIGENTE";
							//}

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
							//var_dump('llego a obtener datos previred <br/>');
							try {
								$periodo = $resultado[0]['periodo'];
								$this->obtenerDatosPrevired($id_sms, $rut_afiliado, $periodo, $tipo);
								echo json_encode($resultado[0]["resultado"]);
							} catch (Exception $e) {

							    $errores_ = 'Excepción capturada: '.$e->getMessage();
								mysqli_next_result($this->db->conn_id);
								$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Error Servicio Previred'.$id_sms), $errores_);
							}

							//echo json_encode($mensaje);
						}
					}
				}
			}else
			{	
				$resultado = $this->Sms_model->validarRCOT($usuario["id_usuario"], $id_sms, $tipo);
				
				if(isset($resultado))
				{
					if(isset($resultado[0]))
					{
						if(isset($resultado[0]['rut_afiliado']) && isset($resultado[0]['periodo']) && isset($resultado[0]['telefono']))
						{
							$mensaje = "";
							echo json_encode($resultado[0]["resultado"]);
						}
					}
				}
			}
			
		}else
		{
			redirect('Login');
		}
	}

	private function getToken()
    {
        $url = 'https://api.minsal.cl/oauth/token';
        $data = array('grant_type' => 'client_credentials');
		$client_id = "u9PfV4nzdIu2JTWYcnvovAOzQhv5PkpP";
		$client_secret = "KUs0QJdYZ6DGLaNK";
		$str_base64 = base64_encode($client_id.':'.$client_secret);
        $options = array(
                'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n".
									 "Authorization: Basic ".$str_base64,
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                )
        );
		
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        //if ($result === FALSE) { /* error */ }

        $authObj = json_decode($result);
    	
    	//$accessToken = $authObj['accessToken'];
   		//var_dump($authObj);
    	$accessToken = $authObj->access_token;
        //$accessToken = $authObj->accessToken;
        
        return $accessToken;
	}

	private function obtenerDatosPrevired($id_sms, $rut_afiliado, $periodo, $tipo) {

		try {
			$usuario = $this->session->userdata();
			if(isset($usuario['id_usuario'])){
				$post = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
				$post .= '<peticion llave="2vUR4BV2iS">';
				$post .= '<peticionservicio tipo="AUT">';
				$post .= '<parametro nombre="usuario" valor="76391999-4" />';
				$post .= '<parametro nombre="password" valor="2vUR4BV2iS" />'; //ProvidaPrevired2019" />';
				$post .= '</peticionservicio>';
				$post .= '<peticionservicio tipo="CAF">';
			    $post .= '<parametro nombre="rut" valor="'.$rut_afiliado.'" />';
			    $post .= '<parametro nombre="periodo" valor="'.$periodo.'" />';
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

				if(isset($simpleXml) && isset($simpleXml->control) && isset($simpleXml->control['codigo']) && sizeof(((string)$simpleXml->control['codigo'][0])) > 0)
				{
					$codigo = (string)$simpleXml->control['codigo'];

					if($codigo == "9000")
					{
						$mensajese = (string)$response;						
						mysqli_next_result($this->db->conn_id);
						$query = $this->App_model->agregarLog($usuario['id_usuario'], 'XML Cliente', $mensajese);

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
											$rut = "";
											$nombres = "";
											$apellido_Paterno = "";
											$apellid_Materno = "";
											$cod_AFP = "";
											$nombre_AFP = "";
											$fecha_Nac = "";
											$genero = "";
											$fecha_Ing = "";
											$fecha_Sub = "";
											$fecha_Inc = "";
											$tipo_Solicitud = "";
											$situacion = "";
											$cta_Personales = "";
											
											$mensaje = $servicio->respuestacaf->children();
											$xml = simplexml_load_string($mensaje);
											$json = json_encode($mensaje);
											$array = json_decode($json,TRUE);
											$cant = sizeof($array['linea']);

											//var_dump($array);

											if ($cant > 1) {
												for ($i=0; $i < $cant; $i++) {
													$codigo_cuenta_personal = $array['linea'][$i]['@attributes']['cuentaspersonales'];
													$es_cta_obligatoria = substr($codigo_cuenta_personal, 0, 1);
													if ($es_cta_obligatoria == "1") {
							$rut = $array['linea'][$i]['@attributes']['rut'];
							$nombres = $array['linea'][$i]['@attributes']['nombres'];
							$apellido_Paterno = $array['linea'][$i]['@attributes']['apellidopaterno'];
							$apellid_Materno = $array['linea'][$i]['@attributes']['apellidomaterno'];
							$cod_AFP = $array['linea'][$i]['@attributes']['codafp'];
							$nombre_AFP = $array['linea'][$i]['@attributes']['nomafp'];
							$fecha_Nac = $array['linea'][$i]['@attributes']['fechanacimiento'];
							$genero = $array['linea'][$i]['@attributes']['sexo'];
							$fecha_Ing = $array['linea'][$i]['@attributes']['fechaingreso'];
							$fecha_Sub = $array['linea'][$i]['@attributes']['fechasubscripcion'];
							$fecha_Inc = $array['linea'][$i]['@attributes']['fechaincorporacion'];
							$tipo_Solicitud = $array['linea'][$i]['@attributes']['tiposolicitud'];
							$situacion = $array['linea'][$i]['@attributes']['situacion'];
							$cta_Personales = $array['linea'][$i]['@attributes']['cuentaspersonales'];
							break;
													}
												}
											}else
											{
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
											}

											$es_hombre = ($genero == "M" ? 1 : ($genero == "F" ? 0 : null));
											mysqli_next_result($this->db->conn_id);
											$resultado = $this->Sms_model->actualizarOTPrevired($usuario['id_usuario'], $id_sms, $nombres, $apellido_Paterno, $apellid_Materno, $es_hombre, $nombre_AFP, $cod_AFP, $cta_Personales, date("Y-m-d", strtotime($fecha_Nac)), date("Y-m-d", strtotime($fecha_Ing)), date("Y-m-d", strtotime($fecha_Sub)), date("Y-m-d", strtotime($fecha_Inc)), $tipo_Solicitud, $situacion);

											$mensaje = $codigo_servicio.'|'.$id_sms.'|Se ingreso correctamente los datos de previred|';
											mysqli_next_result($this->db->conn_id);
											$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Codigo Servicio CAF: '.$codigo_servicio), $mensaje);

											if(isset($resultado))
											{
												if(isset($resultado[0]))
												{
													if(isset($resultado[0]) == "1")
													{
							
													}else
													{

													}
												}
											}


										}else
										{
											$mensaje = $codigo_servicio.'|'.$id_sms.'|Hubo un error en el codigo de servicio previred|';
											mysqli_next_result($this->db->conn_id);
											$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Error Codigo Servicio: '.$codigo_servicio), $mensaje);
										}
									}
								}else{
									$codigo_servicio_aut = (string)$servicio->control['codigo'];
									if ($codigo_servicio_aut == "9050") {
										$mensaje = $codigo_servicio_aut.'|'.$id_sms.'|Codigo Servicio AUT previred|';
										mysqli_next_result($this->db->conn_id);
										$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Codigo Servicio AUT: '.$codigo_servicio_aut), $mensaje);
									}else
									{
										$mensaje = $codigo_servicio_aut.'|'.$id_sms.'|Hubo un error en el codigo de servicio AUT previred|';
										mysqli_next_result($this->db->conn_id);
										$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Error Codigo Servicio AUT: '.$codigo_servicio_aut), $mensaje);
									}
								}
							}
						}
					}else
					{
						$mensaje = $codigo.'|'.$id_sms.'|Hubo un error al ejecutar el servicio previred|';
						mysqli_next_result($this->db->conn_id);
						$query = $this->App_model->agregarLog($usuario['id_usuario'], ('Error Servicio: '.$codigo), $mensaje);
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
		$datos = null;
		if($json != null)
		{
			$data = json_decode($json);
			if($data != null && $data->username != null && $data->password != null)
			{
				if($data->username == "Sglo2019" && $data->password == "Sg.2019$$##")
				{
					if (strpos($data->message, "_") > 1) {
						$datos = explode("_", $data->message);
					}else
					{
						if (strpos($data->message, "$") > 1) {
							$datos = explode("$", $data->message);
						}else{
							if (strlen($data->message) == 54) {
								$rut = substr($data->message, 0, 9);
								$serie = substr($data->message, 9, 10);
								$tipo_doc = substr($data->message, 19, 1);
								$telefono = substr($data->message, 20, 9);
								$folio = substr($data->message, 29, 7);
								$latitud = substr($data->message, 36, 9);
								$longitud = substr($data->message, 45, 9);

								if (substr($rut, 0, 1) == "0") {
									$rut = substr($rut, 1, strlen($rut) - 1);
								}

								if (substr($serie, 0, 1) == "0") {
									$serie = substr($serie, 1, strlen($serie) - 1);
								}
								
								$datos[0] = $rut;
								$datos[1] = $serie;
								$datos[2] = $tipo_doc;
								$datos[3] = $telefono;
								$datos[4] = $folio;
								$datos[5] = $latitud;
								$datos[6] = $longitud;
							}
						}
					}

					
					
					if(sizeof($datos) >= 5){
						$rut = $datos[0];
						$serie = $datos[1];
						$tipo_documento = (int)$datos[2];
						$telefono = $datos[3];
						$folio = $datos[4];
						$latitud = "null";
						$longitud = "null";

						if (sizeof($datos) >= 6) {
							$latitud = $datos[5];
							$longitud = $datos[6];
						}

						//$mensaje = $rut.';'.$serie.';'.$tipo_documento.';'.$telefono.';'.$folio.';'.$latitud.';'.$longitud.';';
						$mensaje = $data->message.strlen($data->message);
						

						$query = $this->Sms_model->agregarLogSMS($data->username, $data->ani, $data->dnis, $data->message, $data->other_messages, 1);
						//$query = $this->Sms_model->agregarLogSMS($data->username, $data->ani, $data->dnis, $mensaje, $data->other_messages, 1);

						mysqli_next_result($this->db->conn_id);
						$query = $this->Sms_model->agregarSMS($data->username, $data->password, $data->ani, $data->dnis, $data->message, $data->other_messages, $rut, $serie, $tipo_documento, $telefono, $folio, $latitud, $longitud);

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
					}else
					{
						$query = $this->Sms_model->agregarLogSMS($data->username, $data->ani, $data->dnis, $data->message, $data->other_messages, 0);
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
	    $client = new SoapClient('https://ida.itdchile.cl/services/smsApiService?wsdl');

	    $array_ws = array('in0' => 'jchacon',
	                      'in1' => 'Provida2020$$',
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

    	public function listarTraspasosValidados()
	{
		$usuario = $this->session->userdata();
		if (isset($usuario['id_usuario'])) {
			$traspasos = null;
			$mes = null;
			$anio = null;
			$anio_defecto = date('Y');
			$mes_defecto = date('m');

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$mes = "null";
				$anio = "null";
				$fecha = null;

				if(!is_null($this->input->post('fecha')) && $this->input->post('fecha') != "-1" && $this->input->post('fecha') != ""
				)
					$fecha = (trim($this->input->post('fecha')) == "" ? "''" : $this->input->post('fecha'));

				if (!is_null($fecha) && strpos($fecha, '-') > 0) {
					$anio = substr($fecha, 0, strpos($fecha, '-'));
					$mes = substr($fecha, strpos($fecha, '-')+1, 2);

					$traspasos = $this->Sms_model->listarTraspasosValidados($usuario['id_usuario'], $mes, $anio);

					if(isset($traspasos))
					{
						$mensaje = '';
						$resultado = 1;
						$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
						echo json_encode($datos);
					}else{
						$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos.';
						$resultado = 0;
						$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
						echo json_encode($datos);
					}

				}else{
					$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos, debe seleccionar mes y año.';
					$resultado = 0;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}


			}else{
				$traspasos = $this->Sms_model->listarTraspasosValidados($usuario['id_usuario'], $mes_defecto, $anio_defecto);
				$usuario['traspasos'] = $traspasos;
				#var_dump($traspasos);
				$usuario['controller'] = 'sms';
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarTraspasosValidados', $usuario);
				$this->load->view('temp/footer', $usuario);
			}



			
		}else
		{
			redirect('Inicio');
		}
		
	}



	public function exportarexcelTV(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			
		     	$traspasos = null;
			$mes = null;
			$anio = null;
			$anio_defecto = date('Y');
			$mes_defecto = date('m');

			if ($_SERVER['REQUEST_METHOD'] === 'GET') {

				$mes = "null";
				$anio = "null";
				$fecha = null;

				if(!is_null($this->input->get('fecha')) && $this->input->get('fecha') != "-1" && $this->input->get('fecha') != ""
				)
					$fecha = (trim($this->input->get('fecha')) == "" ? "''" : $this->input->get('fecha'));

				if (!is_null($fecha) && strpos($fecha, '-') > 0) {
					$anio = substr($fecha, 0, strpos($fecha, '-'));
					$mes = substr($fecha, strpos($fecha, '-')+1, 2);

					$traspasos = $this->Sms_model->listarTraspasosValidados($usuario['id_usuario'], $mes, $anio);

					if(isset($traspasos))
					{
						$mensaje = '';
						$resultado = 1;
						#$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
						#echo json_encode($datos);


						
						$fecha_prueba = new DateTime();
						$fecha_prueba->setDate($anio, $mes, 1);

						$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

						#var_dump($meses[$fecha_prueba->format('m')-1]);
						#var_dump($fecha_prueba);
						#echo $fecha_prueba->format('M');

						$nombre_mes = $meses[$fecha_prueba->format('m')-1];
						$nombre_pestaña = $nombre_mes.'_'.$anio;


						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setName('test_img');
						$objDrawing->setDescription('test_img');
						#$objDrawing->setPath('../images/logo.png');
						$objDrawing->setPath('./assets/img/zenweb.png');
						$objDrawing->setCoordinates('A2');
						//setOffsetX works properly
						$objDrawing->setOffsetX(3);
						$objDrawing->setOffsetY(3);
						//set width, height
						$objDrawing->setWidth(70); 
						$objDrawing->setHeight(70); 
						$objDrawing->setWorksheet($this->excel->getActiveSheet());

						$this->excel->getActiveSheet()->setTitle($nombre_pestaña);
					        
					        //$this->excel->getActiveSheet()->setCellValue("A1", 'ID OT');
							//$this->excel->getActiveSheet()->setCellValue("B1", 'Sucursal');
							//$this->excel->getActiveSheet()->setCellValue("C1", 'Celular Origen');
							
							//$this->excel->getActiveSheet()->setCellValue("F1", 'Perfil');
							#$this->excel->getActiveSheet()->setCellValue("A1", 'Folio');
							#$this->excel->getActiveSheet()->setCellValue("B1", 'Rut Afiliado');
							#$this->excel->getActiveSheet()->setCellValue("C1", 'AFP Origen');
							#$this->excel->getActiveSheet()->setCellValue("D1", 'Fecha');
							#$this->excel->getActiveSheet()->setCellValue("E1", 'Usuario');


							#$titulo = "LISTADO DE LLAMADAS SERVICIO API REGISTRO CIVIL ". PHP_EOL." ".$nombre_mes.' '.$anio;
					        	$titulo = "LISTADO DE LLAMADAS SERVICIO API REGISTRO CIVIL \n".$nombre_mes.' '.$anio;

							$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(12.4);
							$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
							$this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(12.4);


							$this->excel->getActiveSheet()->setCellValue('A2', $titulo);
							$this->excel->getActiveSheet()->mergeCells('A2:AD5');

							$style = array(
								'alignment' => array(
									'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
								),
								'font' => [
									'size' => 20
								],
								'borders' => array(
								    'allborders' => array(
								      'style' => PHPExcel_Style_Border::BORDER_THIN
								    )
								)
							);

							$style_negrita = array(
								'font' => array(
									'name' => 'Helvetica Neue',
									'bold' => true
								)
							);


							

							$this->excel->getActiveSheet()->getStyle("A2:AD5")->applyFromArray($style);
							$this->excel->getActiveSheet()->getStyle('A2:AD5')->getAlignment()->setWrapText(true);
							$this->excel->getActiveSheet()->getStyle('A7:AD7')->applyFromArray($style_negrita);
							$this->excel->getActiveSheet()->setCellValue("A7", 'id_log_api_cedula');
							$this->excel->getActiveSheet()->setCellValue("B7", 'tipo_result');
							$this->excel->getActiveSheet()->setCellValue("C7", 'estado');
							$this->excel->getActiveSheet()->setCellValue("D7", 'cod_codigo');
							$this->excel->getActiveSheet()->setCellValue("E7", 'accion');
							$this->excel->getActiveSheet()->setCellValue("F7", 'aplicacion');
							$this->excel->getActiveSheet()->setCellValue("G7", 'parametros');
							$this->excel->getActiveSheet()->setCellValue("H7", 'ruta');
							$this->excel->getActiveSheet()->setCellValue("I7", 'uri');
							$this->excel->getActiveSheet()->setCellValue("J7", 'cod_estado_respuesta');
							$this->excel->getActiveSheet()->setCellValue("K7", 'desc_estado_respuesta');
							$this->excel->getActiveSheet()->setCellValue("L7", 'runPersona_resultado');
							$this->excel->getActiveSheet()->setCellValue("M7", 'dvPersona_resultado');
							$this->excel->getActiveSheet()->setCellValue("N7", 'codTipoDocumento_resultado');
							$this->excel->getActiveSheet()->setCellValue("O7", 'codClaseDocumento_resultado');
							$this->excel->getActiveSheet()->setCellValue("P7", 'numDocumento_resultado');
							$this->excel->getActiveSheet()->setCellValue("Q7", 'numSerie_resultado');
							$this->excel->getActiveSheet()->setCellValue("R7", 'indVigencia_resultado');
							$this->excel->getActiveSheet()->setCellValue("S7", 'fhoVcto_resultado');
							$this->excel->getActiveSheet()->setCellValue("T7", 'indBloqueo_resultado');
							$this->excel->getActiveSheet()->setCellValue("U7", 'obs_respuesta');
							$this->excel->getActiveSheet()->setCellValue("V7", 'error_respuesta');
							$this->excel->getActiveSheet()->setCellValue("W7", 'tiempo');
							$this->excel->getActiveSheet()->setCellValue("X7", 'organizacion');
							$this->excel->getActiveSheet()->setCellValue("Y7", 'ip');
							$this->excel->getActiveSheet()->setCellValue("Z7", 'id');
							$this->excel->getActiveSheet()->setCellValue("AA7", 'fecha');
							$this->excel->getActiveSheet()->setCellValue("AB7", 'cod_obs_respuesta');
							$this->excel->getActiveSheet()->setCellValue("AC7", 'descripcion_obs_respuesta');
							$this->excel->getActiveSheet()->setCellValue("AD7", 'id_sms');

							$this->excel->getActiveSheet()->getStyle("A7:AD7")->getFont()->setSize(10);


							
							
							
					        //Definimos la data del cuerpo.        
					        $contador = 7;
					        foreach($traspasos as $registro){
					           //Incrementamos una fila más, para ir a la siguiente.
					           $contador++;
					           //Informacion de las filas de la consulta.
					           	$this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_log_api_cedula']);
							$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['tipo_result']);
							$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['estado']);
							$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['cod_codigo']);
							$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['accion']);
							$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['aplicacion']);
							$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['parametros']);
							$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['ruta']);
							$this->excel->getActiveSheet()->setCellValue("I{$contador}", $registro['uri']);
							$this->excel->getActiveSheet()->setCellValue("J{$contador}", $registro['cod_estado_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("K{$contador}", $registro['desc_estado_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("L{$contador}", $registro['runPersona_resultado']);
							$this->excel->getActiveSheet()->setCellValue("M{$contador}", $registro['dvPersona_resultado']);
							$this->excel->getActiveSheet()->setCellValue("N{$contador}", $registro['codTipoDocumento_resultado']);
							$this->excel->getActiveSheet()->setCellValue("O{$contador}", $registro['codClaseDocumento_resultado']);
							$this->excel->getActiveSheet()->setCellValue("P{$contador}", $registro['numDocumento_resultado']);
							$this->excel->getActiveSheet()->setCellValue("Q{$contador}", $registro['numSerie_resultado']);
							$this->excel->getActiveSheet()->setCellValue("R{$contador}", $registro['indVigencia_resultado']);
							$this->excel->getActiveSheet()->setCellValue("S{$contador}", $registro['fhoVcto_resultado']);
							$this->excel->getActiveSheet()->setCellValue("T{$contador}", $registro['indBloqueo_resultado']);
							$this->excel->getActiveSheet()->setCellValue("U{$contador}", $registro['obs_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("V{$contador}", $registro['error_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("W{$contador}", $registro['tiempo']);
							$this->excel->getActiveSheet()->setCellValue("X{$contador}", $registro['organizacion']);
							$this->excel->getActiveSheet()->setCellValue("Y{$contador}", $registro['ip']);
							$this->excel->getActiveSheet()->setCellValue("Z{$contador}", $registro['id']);
							$this->excel->getActiveSheet()->setCellValue("AA{$contador}", $registro['fecha']);
							$this->excel->getActiveSheet()->setCellValue("AB{$contador}", $registro['cod_obs_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("AC{$contador}", $registro['descripcion_obs_respuesta']);
							$this->excel->getActiveSheet()->setCellValue("AD{$contador}", $registro['id_sms']);
					        }

					        $style_contenido = array(
							'font' => array(
								'name' => 'Calibri',
								'size' => 12
							)
						);
						
						$texto = 'A8:AD'.$contador;
						#var_dump($texto);
						#exit();

						$this->excel->getActiveSheet()->getStyle($texto)->applyFromArray($style_contenido);

					        //Le ponemos un nombre al archivo que se va a generar.
					        $archivo = "API REGISTRO CIVIL {$nombre_mes} - {$anio}.xls";
					        header('Content-Type: application/force-download');
					        header('Content-Disposition: attachment;filename="'.$archivo.'"');
					        header('Cache-Control: max-age=0');

					        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					        //Hacemos una salida al navegador con el archivo Excel.
					        $objWriter->save('php://output'); 
					}else{
						$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos.';
						$resultado = 0;
						$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
						echo json_encode($datos);
					}

				}else{
					$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos, debe seleccionar mes y año.';
					$resultado = 0;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}
			}
		}
		else
		{
			redirect('Login');
		}
    	}	
	
}