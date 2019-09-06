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

	public function listarTraspasosUsuarioCall($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosUsuarioCall`(".$idUsuario.");");
		return $query->result_array();
	}

	public function insertCRMNeotel($idSucursal, $idUsuarioVendedor, $id_estado_rc, $fecha_inicio, $fecha_fin, $id_estado_certificacion, $idUsuario, $por_defecto)
	{
		$query = $this->db->query("call `traspasosdb`.`sp_insertCRMNeotel`(".$idSucursal.", ".$idUsuarioVendedor.", ".$id_estado_rc.", ".$fecha_inicio.", ".$fecha_fin.", ".$id_estado_certificacion.", ".$idUsuario.", ".$por_defecto.");");
		return $query->result_array();
	}
}