<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sms_model');
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
					$this->obtenerDatosPrevired($id_sms, $tipo);
					echo json_encode($resultado[0]["resultado"]);
				}
			}
			
			//redirect('Sms')
		}else
		{
			redirect('Login');
		}
	}	

	private function obtenerDatosPrevired($id_sms, $tipo)
	{

		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$nombresH = array("1"=>"Santiago",
							"2"=>"Ricardo",
							"3"=>"Alfonso",
							"4"=>"Rafael",
							"5"=>"Iñaki",
							"6"=>"Iren",
							"7"=>"Evan",
							"8"=>"Clemente",
							"9"=>"Quirze",
							"10"=>"Marcos",
							"11"=>"Boris",
							"12"=>"Emilio",
							"13"=>"Luis",
							"14"=>"Leónidas",
							"15"=>"Gonzalo",
							"16"=>"Joan",
							"17"=>"Michel",
							"18"=>"Fabián",
							"19"=>"Manuel",
							"20"=>"Galván",
							"21"=>"Jonathan",
							"22"=>"Esteve",
							"23"=>"Antolino",
							"24"=>"Pablo",
							"25"=>"Felipe",
							"26"=>"Eladio",
							"27"=>"Xob",
							"28"=>"Iker",
							"29"=>"Eugenio",
							"30"=>"Jordi",
							"31"=>"Aitor",
							"32"=>"Alfredo",
							"33"=>"Daniel",
							"34"=>"Javier",
							"35"=>"Goio",
							"36"=>"Leonardo",
							"37"=>"Óscar",
							"38"=>"Anxo",
							"39"=>"Arnau",
							"40"=>"Moisés",
							"41"=>"Brayan",
							"42"=>"Ángel",
							"43"=>"Gabriel",
							"44"=>"Gaizka",
							"45"=>"Enrique",
							"46"=>"Roberto",
							"47"=>"Adrián",
							"48"=>"Manel",
							"49"=>"Ismael",
							"50"=>"Julio",
							"51"=>"Cristián",
							"52"=>"Marcial",
							"53"=>"Facundo",
							"54"=>"Kurt",
							"55"=>"Tirso",
							"56"=>"Nacho",
							"57"=>"Alejo",
							"58"=>"Alejandro",
							"59"=>"Jose María",
							"60"=>"Ximo",
							"61"=>"Renato",
							"62"=>"Damián",
							"63"=>"Simón",
							"64"=>"Enio",
							"65"=>"Nicolás",
							"66"=>"Amadeo",
							"67"=>"Thiago",
							"68"=>"Arseni",
							"69"=>"Erick",
							"70"=>"Dionisio",
							"71"=>"Antonio",
							"72"=>"Esteban",
							"73"=>"Ignacio",
							"74"=>"Diego",
							"75"=>"Mario",
							"76"=>"Gabin",
							"77"=>"Camilo",
							"78"=>"Kamil",
							"79"=>"Adonis",
							"80"=>"Braulio",
							"81"=>"Andreu",
							"82"=>"Reinaldo",
							"83"=>"Alberto",
							"84"=>"Guzmán",
							"85"=>"Elvio",
							"86"=>"Jeremías",
							"87"=>"Miguel",
							"88"=>"Isidoro",
							"89"=>"Gorka",
							"90"=>"Abelardo",
							"91"=>"Ezio",
							"92"=>"Aleixandre",
							"93"=>"Guillermo",
							"94"=>"Juan",
							"95"=>"Pedro",
							"96"=>"Pepe",
							"97"=>"Gil",
							"98"=>"Ulises");

			$nombresM = array("1"=>"Cristina",
							"2"=>"Alicia",
							"3"=>"Lara",
							"4"=>"Celeste",
							"5"=>"Frida",
							"6"=>"Carolina",
							"7"=>"Estela",
							"8"=>"Begoña",
							"9"=>"Isabel",
							"10"=>"Esperanza",
							"11"=>"Aurora",
							"12"=>"Matilde",
							"13"=>"Lourdes",
							"14"=>"Inés",
							"15"=>"Olaia",
							"16"=>"Agatha",
							"17"=>"Rita",
							"18"=>"Rebeca",
							"19"=>"Melania",
							"20"=>"Silvia",
							"21"=>"Esmeralda",
							"22"=>"Victoria",
							"23"=>"Elsa",
							"24"=>"Fiona",
							"25"=>"Francisca",
							"26"=>"Erica",
							"27"=>"Rut",
							"28"=>"Natalia",
							"29"=>"Tatiana",
							"30"=>"Raquel",
							"31"=>"Amparo",
							"32"=>"Cora",
							"33"=>"Miriam",
							"34"=>"Diamante",
							"35"=>"Azucena",
							"36"=>"Luisa",
							"37"=>"Agatha",
							"38"=>"Rita",
							"39"=>"Rebeca",
							"40"=>"Melania",
							"41"=>"Silvia",
							"42"=>"Esmeralda",
							"43"=>"Victoria",
							"44"=>"Elsa",
							"45"=>"Fiona",
							"46"=>"Francisca",
							"47"=>"Erica",
							"48"=>"Rut",
							"49"=>"Natalia",
							"50"=>"Tatiana",
							"51"=>"Raquel",
							"52"=>"Amparo",
							"53"=>"Cora",
							"54"=>"Miriam",
							"55"=>"Diamante",
							"56"=>"Azucena",
							"57"=>"Luisa",
							"58"=>"Adela",
							"59"=>"Alegría",
							"60"=>"Teresa",
							"61"=>"Nuria",
							"62"=>"Olalla",
							"63"=>"Belén",
							"64"=>"Hirune",
							"65"=>"Julia",
							"66"=>"Marta",
							"67"=>"Idoia",
							"68"=>"Ariadna",
							"69"=>"Ginebra",
							"70"=>"Catalina",
							"71"=>"Chantal",
							"72"=>"María",
							"73"=>"Débora",
							"74"=>"Alana",
							"75"=>"Zulema",
							"76"=>"Amaia",
							"77"=>"Natacha",
							"78"=>"Carmen",
							"79"=>"Magdalena",
							"80"=>"Bea",
							"81"=>"Cloé",
							"82"=>"Montserrat",
							"83"=>"Lucrecia",
							"84"=>"Jasmina",
							"85"=>"Izaskun",
							"86"=>"Carla",
							"87"=>"Fabricia",
							"88"=>"Alina",
							"89"=>"Paquita",
							"90"=>"Patricia",
							"91"=>"Dayana",
							"92"=>"Ivet",
							"93"=>"Delia",
							"94"=>"Emilia",
							"95"=>"Sandra",
							"96"=>"Marlena",
							"97"=>"Noelia",
							"98"=>"Anabel");

			$apellidos = array("1"=>"GARCIA",
							"2"=>"GONZALEZ",
							"3"=>"FERNANDEZ",
							"4"=>"PEREZ",
							"5"=>"LOPEZ",
							"6"=>"RODRIGUEZ",
							"7"=>"MARTINEZ",
							"8"=>"SANCHEZ",
							"9"=>"GOMEZ",
							"10"=>"ALVAREZ",
							"11"=>"MARTIN",
							"12"=>"DIAZ",
							"13"=>"ALONSO",
							"14"=>"RUIZ",
							"15"=>"HERNANDEZ",
							"16"=>"GUTIERREZ",
							"17"=>"BLANCO",
							"18"=>"JIMENEZ",
							"19"=>"MORENO",
							"20"=>"MUÑOZ",
							"21"=>"VAZQUEZ",
							"22"=>"GIL",
							"23"=>"DOMINGUEZ",
							"24"=>"CASTRO",
							"25"=>"RAMOS",
							"26"=>"ROMERO",
							"27"=>"TORRES",
							"28"=>"IGLESIAS",
							"29"=>"NAVARRO",
							"30"=>"RUBIO",
							"31"=>"SERRANO",
							"32"=>"SANTOS",
							"33"=>"CALVO",
							"34"=>"PRIETO",
							"35"=>"SUAREZ",
							"36"=>"NUÑEZ",
							"37"=>"ORTIZ",
							"38"=>"ORTEGA",
							"39"=>"DELGADO",
							"40"=>"SANZ",
							"41"=>"DIEZ",
							"42"=>"SAN",
							"43"=>"MENDEZ",
							"44"=>"PEÑA",
							"45"=>"VIDAL",
							"46"=>"GARRIDO",
							"47"=>"MORALES",
							"48"=>"VEGA",
							"49"=>"LORENZO",
							"50"=>"CASTILLO",
							"51"=>"GALLEGO",
							"52"=>"LOZANO",
							"53"=>"MOLINA",
							"54"=>"CRUZ",
							"55"=>"RAMIREZ",
							"56"=>"FUENTES",
							"57"=>"HERRERO",
							"58"=>"MARIN",
							"59"=>"ARIAS",
							"60"=>"PASCUAL",
							"61"=>"CAMPOS",
							"62"=>"CRESPO",
							"63"=>"NIETO",
							"64"=>"CANO",
							"65"=>"VICENTE",
							"66"=>"PARDO",
							"67"=>"MIGUEL",
							"68"=>"LEON",
							"69"=>"IBAÑEZ",
							"70"=>"MONTERO",
							"71"=>"CORTES",
							"72"=>"REY",
							"73"=>"MEDINA",
							"74"=>"SOTO",
							"75"=>"GUERRERO",
							"76"=>"ESTEBAN",
							"77"=>"CABALLERO",
							"78"=>"SAEZ",
							"79"=>"ANDRES",
							"80"=>"FUENTE",
							"81"=>"MARCOS",
							"82"=>"VELASCO",
							"83"=>"HERRERA",
							"84"=>"VILLAR",
							"85"=>"SIERRA",
							"86"=>"CARRASCO",
							"87"=>"DURAN",
							"88"=>"GIMENEZ",
							"89"=>"OTERO",
							"90"=>"HIDALGO",
							"91"=>"ROMAN",
							"92"=>"RIO",
							"93"=>"MONTES",
							"94"=>"MERINO",
							"95"=>"RIVAS",
							"96"=>"FERRER",
							"97"=>"REDONDO",
							"98"=>"BRAVO",
							"99"=>"FLORES",
							"100"=>"IZQUIERDO");

			$afps = array('1' => '1003 Cuprum', '1' => '1005 Habitat', '1' => '1032 Planvital', '1' => '1033 Capital', '1' => '1034 Modelo');

			$nombreHSel = array_rand($nombresH,2);
			$nombres_hombre = strtolower($nombresH[$nombreHSel[0]]." ".$nombresH[$nombreHSel[1]]);

			$nombreMSel = array_rand($nombresM,2);
			$nombres_mujer = strtolower($nombresM[$nombreMSel[0]]." ".$nombresM[$nombreMSel[1]]);
			
			$apellidoSel = array_rand($apellidos,2);

			$afpSel = array_rand($afps,1);

			$opciones = array('1' => 1, '2' => 2);

			$se_valida = '1';#array_rand($opciones,1);

			$generos = array('0' => 0, '1' => 1);

			$es_hombre = array_rand($generos,1);

			if ($se_valida == '1' && $tipo <> 4 && $tipo <> 2)
			{
				$nombres_afiliado = "";
				if($es_hombre == "1")
					$nombres_afiliado = $nombres_hombre;
				else
					$nombres_afiliado = $nombres_mujer;

				$institucion = $afps[$afpSel];

				mysqli_next_result($this->db->conn_id);
				$resultado = $this->Sms_model->actualizarOTPrevired($usuario['id_usuario'], $id_sms, $nombres_afiliado, $apellidos[$apellidoSel[0]], $apellidos[$apellidoSel[1]], $es_hombre, $institucion);

				if(isset($resultado))
				{
					if(isset($resultado[0]))
					{
						//if(isset($resultado[0]) == "1")
						//{
							$mensaje = "";
							$telefono = $resultado[0]['u_celular'];
							if($tipo == "1" && $se_valida = "1")
							{
								$mensaje = "Afiliado VIGENTE, institucion: ".$institucion;
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
							$se_envio = $this->enviarSms($parametros);
						//}
					}
				}
			}
		}else
		{
			redirect('Login');
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
					$datos = explode("_", $data->message);
					if(sizeof($datos) == 5){
						$rut = $datos[0];
						$serie = $datos[1];
						$tipo_documento = (int)$datos[2];
						$telefono = $datos[3];
						$folio = $datos[4];

						var_dump($data);

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
										var_dump($se_envio);
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