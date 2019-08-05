<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function saveSms($username, $password, $ani, $dnis, $message, $other_messages)#, $rut, $serie, $tipo_documento, $telefono, $folio)
	{
		$query = $this->db->insert('sms', array('username' => $username, 'password' => $password, 'ani' => $ani, 'dnis' => $dnis, 'message' => $message, 'other_messages' => $other_messages, 'id_estado' => 1, 'fecha' => date())); #, 'rut' => $rut, 'serie' => $serie, 'tipo_documento' => $tipo_documento, 'telefono' => $telefono, 'folio' => $folio));
		return $query;
	}
}