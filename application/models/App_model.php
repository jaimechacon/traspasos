<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function agregarLog($idUsuario, $funcion, $mensaje)
	{
		$query2 = $this->db->query("call `traspasosdb`.`agregarLog`(".$idUsuario.", '".$funcion."', '".$mensaje."');");

		return $query2->result_array();
	}
}