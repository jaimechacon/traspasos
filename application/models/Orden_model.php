<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orden_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarTraspasosUsuario($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosUsuario`(".$idUsuario.");");
		return $query->result_array();
	}
}