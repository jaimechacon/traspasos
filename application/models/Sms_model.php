<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function agregarSMS($username, $password, $ani, $dnis, $message, $other_messages, $rut, $serie, $tipo_documento, $telefono, $folio, $latitud, $longitud)
	{
		$query2 = $this->db->query("call `traspasosdb`.`agregarSMS`('".$username."', '".$password."', '".$ani."', '".$dnis."', '".$message."', '".$other_messages."', '".$rut."', '".$serie."', ".$tipo_documento.", '".$telefono."', '".$folio."',  ".($latitud == "null" ? $latitud : ("'".$latitud."'")).", ".($longitud == "null" ? $longitud : ("'".$longitud."'")).");");

		return $query2->result_array();
	}

	public function listarTraspasosPendientes($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosPendientes`(".$idUsuario.");");
		return $query->result_array();
	}

	public function validarRCOT($idUsuario, $idSms, $idEstado)
	{
		$query = $this->db->query("call `traspasosdb`.`validarRCOT`(".$idUsuario.", ".$idSms.", ".$idEstado.");");
		return $query->result_array();
	}

	public function actualizarOTPrevired($idUsuario, $idSms, $nombres, $apellidoP, $apellidoM, $genero, $institucion, $cod_institucion, $cuentas_personales_institucion, $fecha_nac, $fecha_ingreso, $fecha_subscripcion, $fecha_incorporacion, $tipo_solicitud, $situacion)
	{
		$query = $this->db->query("call `traspasosdb`.`actualizarOTPrevired`(".$idUsuario.", ".$idSms.", '".$nombres."', '".$apellidoP."', '".$apellidoM."', ".$genero.", '".$institucion."', '".$cod_institucion."', '".$cuentas_personales_institucion."', '".$fecha_nac."', '".$fecha_ingreso."', '".$fecha_subscripcion."', '".$fecha_incorporacion."', '".$tipo_solicitud."', '".$situacion."');");
		return $query->result_array();
	}

	public function listarTraspasosPendientesRut($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosPendientesRut`(".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarLogSMS($username, $ani, $dnis, $message, $other_messages, $correcto)
	{
		$query2 = $this->db->query("call `traspasosdb`.`agregarLogSMS`('".$username."', '".$ani."', '".$dnis."', '".$message."', '".$other_messages."', ".$correcto.");");
		return $query2->result_array();
	}

	public function agregarLogCedula($tipo_result, $estado, $cod_codigo, $accion, $aplicacion, $parametros, $ruta, $uri, $cod_estado_respuesta, $desc_estado_respuesta, $runPersona_resultado, $dvPersona_resultado, $codTipoDocumento_resultado, $codClaseDocumento_resultado, $numDocumento_resultado, $numSerie_resultado, $indVigencia_resultado, $fhoVcto_resultado, $indBloqueo_resultado, $obs_respuesta, $error_respuesta, $tiempo, $organizacion, $ip, $id, $cod_obs_respuesta, $descripcion_obs_respuesta)
	{
		$query2 = $this->db->query("CALL `traspasosdb`.`agregarLogCedula`(".($tipo_result == "null" ? $tipo_result : ("'".$tipo_result."'")).", ".($estado == "null" ? $estado : ("'".$estado."'")).", ".($cod_codigo == "null" ? $cod_codigo : ("'".$cod_codigo."'")).", ".($accion == "null" ? $accion : ("'".$accion."'")).", ".($aplicacion == "null" ? $aplicacion : ("'".$aplicacion."'")).", ".($parametros == "null" ? $parametros : ("'".$parametros."'")).", ".($ruta == "null" ? $ruta : ("'".$ruta."'")).", ".($uri == "null" ? $uri : ("'".$uri."'")).", ".($cod_estado_respuesta == "null" ? $cod_estado_respuesta : ("'".$cod_estado_respuesta."'")).", ".($desc_estado_respuesta == "null" ? $desc_estado_respuesta : ("'".$desc_estado_respuesta."'")).", ".($runPersona_resultado == "null" ? $runPersona_resultado : ("'".$runPersona_resultado."'")).", ".($dvPersona_resultado == "null" ? $dvPersona_resultado : ("'".$dvPersona_resultado."'")).", ".($codTipoDocumento_resultado == "null" ? $codTipoDocumento_resultado : ("'".$codTipoDocumento_resultado."'")).", ".($codClaseDocumento_resultado == "null" ? $codClaseDocumento_resultado : ("'".$codClaseDocumento_resultado."'")).", ".($numDocumento_resultado == "null" ? $numDocumento_resultado : ("'".$numDocumento_resultado."'")).", ".($numSerie_resultado == "null" ? $numSerie_resultado : ("'".$numSerie_resultado."'")).", ".($indVigencia_resultado == "null" ? $indVigencia_resultado : ("'".$indVigencia_resultado."'")).", ".($fhoVcto_resultado == "null" ? $fhoVcto_resultado : ("'".$fhoVcto_resultado."'")).", ".($indBloqueo_resultado == "null" ? $indBloqueo_resultado : ("'".$indBloqueo_resultado."'")).", ".($obs_respuesta == "null" ? $obs_respuesta : ("'".$obs_respuesta."'")).", ".($error_respuesta == "null" ? $error_respuesta : ("'".$error_respuesta."'")).", ".($tiempo == "null" ? $tiempo : ("'".$tiempo."'")).", ".($organizacion == "null" ? $organizacion : ("'".$organizacion."'")).", ".($ip == "null" ? $ip : ("'".$ip."'")).", ".($id == "null" ? $id : ("'".$id."'")).", ".($cod_obs_respuesta == "null" ? $cod_obs_respuesta : ($cod_obs_respuesta)).", ".($descripcion_obs_respuesta == "null" ? $descripcion_obs_respuesta : ("'".$descripcion_obs_respuesta."'")).");");
		return $query2->result_array();
	}
}