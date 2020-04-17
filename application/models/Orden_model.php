<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orden_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarTraspasosUsuario($idUsuario, $idSucursal, $idUsuarioVendedor, $fechaDesde, $fechaHasta, $idEstadoRC, $idEstadoC, $idTipoDoc)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosUsuario`(".$idUsuario.", ".$idSucursal.", ".$idUsuarioVendedor.", ".($fechaDesde == "null" ? $fechaDesde : ("'".$fechaDesde."'")).", ".($fechaHasta == "null" ? $fechaHasta : ("'".$fechaHasta."'")).", ".$idEstadoRC.", ".$idEstadoC.", ".$idTipoDoc.");");
		return $query->result_array();
	}

	public function listarTraspasosUsuarioCall($idUsuario, $idSucursal, $idUsuarioVendedor, $fechaDesde, $fechaHasta, $idEstadoRC, $idEstadoC)
	{
		$query = $this->db->query("call `traspasosdb`.`listarTraspasosUsuarioCall`(".$idUsuario.", ".$idSucursal.", ".$idUsuarioVendedor.", ".($fechaDesde == "null" ? $fechaDesde : ("'".$fechaDesde."'")).", ".($fechaHasta == "null" ? $fechaHasta : ("'".$fechaHasta."'")).", ".$idEstadoRC.", ".$idEstadoC.");");
		return $query->result_array();
	}

	public function insertCRMNeotel($idSucursal, $idUsuarioVendedor, $id_estado_rc, $fecha_inicio, $fecha_fin, $id_estado_certificacion, $idUsuario, $por_defecto)
	{
		$query = $this->db->query("call `traspasosdb`.`sp_insertCRMNeotel`(".$idSucursal.", ".$idUsuarioVendedor.", ".$id_estado_rc.", ".($fecha_inicio == "null" ? $fecha_inicio : ("'".$fecha_inicio."'")).", ".($fecha_fin == "null" ? $fecha_fin : ("'".$fecha_fin."'")).", ".$id_estado_certificacion.", ".$idUsuario.", ".$por_defecto.");");
		return $query->result_array();
	}

	public function listarSucursalesUsuCall($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarSucursalesUsuCall`(".$idUsuario.");");
		return $query->result_array();
	}

	public function listarVendedorUsuCall($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarVendedorUsuCall`(".$idUsuario.");");
		return $query->result_array();
	}

	public function listarCertificadosUsuCall($idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`listarCertificadosUsuCall`(".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarOrdenTraspaso($rut, $serie, $tipoDoc, $telefono, $folio, $latitud, $longitud, $idUsuario)
	{
		$query = $this->db->query("call `traspasosdb`.`agregarOrdenTraspaso`(".($rut == "null" ? $rut : ("'".$rut."'")).", ".($serie == "null" ? $serie : ("'".$serie."'")).", ".$tipoDoc.", ".($telefono == "null" ? $telefono : ("'".$telefono."'")).", ".($folio == "null" ? $folio : ("'".$folio."'")).", ".($latitud == "null" ? $latitud : ("'".$latitud."'")).", ".($longitud == "null" ? $longitud : ("'".$longitud."'")).", ".$idUsuario.");");
		return $query->result_array();
	}
	
}