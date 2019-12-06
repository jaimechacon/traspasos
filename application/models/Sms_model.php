<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function agregarSMS($username, $password, $ani, $dnis, $message, $other_messages, $rut, $serie, $tipo_documento, $telefono, $folio)
	{
		$query2 = $this->db->query("call `traspasosdb`.`agregarSMS`('".$username."', '".$password."', '".$ani."', '".$dnis."', '".$message."', '".$other_messages."', '".$rut."', '".$serie."', ".$tipo_documento.", '".$telefono."', '".$folio."');");

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

	public function agregarLog($idUsuario, $idSms, $mensaje)
	{
		$query = $this->db->query("call `traspasosdb`.`agregarLog`(".$idUsuario.", ".$idSms.", '".$mensaje."');");
		return $query->result_array();
	}

	public function listarTraspasosPendientesRut($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosPendientesRut`(".$idUsuario.");");
		return $query->result_array();
	}
}