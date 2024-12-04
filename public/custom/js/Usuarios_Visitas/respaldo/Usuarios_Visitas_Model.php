<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuarios_Visitas_Model extends BaseModel
{


	public function insertarIP($newCase)
	{
		
		date_default_timezone_set('America/Caracas');
		$hora = date("H:i:s A");
		$newCase['hora'] = $hora;
		$builder = $this->dbconn('public.sta_usuarios_visitas ');
		$query = $builder->insert($newCase);
		return $query;
	}


 //CONTAMOS LAS VISITAS
 public function ContarUsuariosVisitas($desde, $hasta)
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sta_usuarios_visitas');
    $builder->select("TO_CHAR(fecha, 'Day') AS dia_semana_completo, fecha, COUNT(user_requests_ip) AS num_requests");
    if ($desde !== 'null' && $hasta !== 'null') {
        $builder->where('fecha >=', $desde);
        $builder->where('fecha <=', $hasta);
    }
    $builder->groupBy('fecha, TO_CHAR(fecha, \'Day\')');
    $builder->orderBy('fecha', 'ASC');
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}


 






	
}
