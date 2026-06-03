<?php

namespace App\Models;

use CodeIgniter\Model;

class Auditoria_sistema_Model extends BaseModel
{


	public function listar_auditoria_sistema($direccion_ip = null, $dispositivo = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_auditoria_sistema as s');
    $builder->select('s.audi_id');
    $builder->select("'$direccion_ip' as direccion_ip");
    $builder->select("'$dispositivo' as dispositivo");
    $builder->select("CONCAT(usu.usuopnom, ' ', usu.usuopape) as nombre");
    $builder->select('s.audi_accion');
    $builder->select('s.audi_hora');
    $builder->select('s.audi_fecha as fecha_normal');
    $builder->select("to_char(s.audi_fecha, 'dd-mm-yyyy') as fecha");
    $builder->join('sgc_usuario_operador as usu', 's.audi_user_id = usu.idusuopr');
    $builder->orderBy('s.audi_id', 'DESC');
    $query = $builder->get();
    return $query->getResult();
}

	public function agregar($auditoria)
	{
		$auditoria['audi_fecha'] = date('Y-m-d');
		$auditoria['audi_hora']  = date("H:i:s A");
		$builder = $this->dbconn('public.sgc_auditoria_sistema ');
		$query = $builder->insert($auditoria);
		return $query;
	}
}
