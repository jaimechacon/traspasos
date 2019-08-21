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

	public function actualizarOTPrevired($idUsuario, $idSms, $nombres, $apellidoP, $apellidoM, $genero, $institucion)
	{
		$query = $this->db->query("call `traspasosdb`.`actualizarOTPrevired`(".$idUsuario.", ".$idSms.", '".$nombres."', '".$apellidoP."', '".$apellidoM."', ".$genero.", '".$institucion."');");
		return $query->result_array();
	}
}