<?php

namespace App\Models;

use CodeIgniter\Model;

class Auditoria_sistema_Model extends BaseModel
{


	public function listar_auditoria_sistema($direccion_ip = null, $dispositivo = null)
	{
		$db      = \Config\Database::connect();
		$strQuery = "";
		$strQuery .= "SELECT";
		$strQuery .= " s.audi_id ";
		$strQuery .= ", '$direccion_ip' as direccion_ip ";
		$strQuery .= ", '$dispositivo' as dispositivo ";
		$strQuery .= ",CONCAT(usu.usuopnom,' ',usu.usuopape) as nombre ";
		$strQuery .= ",s.audi_accion ";
		$strQuery .= ",s.audi_hora ";
		$strQuery .= ",s.audi_fecha as fecha_normal ";
		$strQuery .= ",to_char(s.audi_fecha,'dd-mm-yyyy') as fecha ";
		$strQuery .= "FROM ";
		$strQuery .= "  public.sgc_auditoria_sistema as s";
		$strQuery .= "  JOIN sgc_usuario_operador as usu on  s.audi_user_id=usu.idusuopr";
		$strQuery .= "  ORDER BY s.audi_id DESC";
		$query = $db->query($strQuery);
		$resultado = $query->getResult();
		return $resultado;
	}

	public function agregar($auditoria)
	{

		date_default_timezone_set('America/Caracas');
		$hora = date("H:i:s A");
		$auditoria['audi_hora'] = $hora;
		$builder = $this->dbconn('public.sgc_auditoria_sistema ');
		$query = $builder->insert($auditoria);
		return $query;
	}
}
