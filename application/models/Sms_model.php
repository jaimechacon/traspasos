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

		//$message = $query2->result_array();

		//$query = $this->db->insert('sms', array('username' => $username, 'password' => $password, 'ani' => $ani, 'dnis' => $dnis, 'message' => $message, 'other_messages' => $other_messages, 'id_estado' => 1, 'fecha' => '2019-08-12', 'rut' => $rut, 'serie' => $serie, 'tipo_documento' => $tipo_documento, 'telefono' => $telefono, 'folio' => $folio));
		//return $query;
		//$query = $this->db->query("call `traspasosdb`.`agregarSMS`('".$username."', '".$password."', '".$ani."', '".$dnis."', '".$message."', '".$other_messages."', '".$rut."', '".$serie."', ".$tipo_documento.", '".$telefono."', '".$folio."');");
		//return $query->result_array();	
	}

	public function listarTraspasosPendientes($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosPendientes`(".$idUsuario.");");
		return $query->result_array();
	}
}