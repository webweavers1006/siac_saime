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


public function ContarUsuariosVisitas($desde, $hasta)
{
    $db = \Config\Database::connect();

    $sql = "SELECT * FROM generate_series(?, ?::date, '1 day'::interval) AS generated_fecha";
    $query = $db->query($sql, [$desde, $hasta]);

    $builder = $db->table($query->getResult());

    $builder->select([
        "CASE 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Sunday' THEN 'Domingo' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Monday' THEN 'Lunes' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Tuesday' THEN 'Martes' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Wednesday' THEN 'Miércoles' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Thursday' THEN 'Jueves' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Friday' THEN 'Viernes' 
            WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Saturday' THEN 'Sábado' 
        END AS dia_semana_completo",
        "TO_CHAR(generated_fecha, 'yyyy/mm/dd') AS fecha",
        "TO_CHAR(generated_fecha, 'dd/mm/yyyy') AS fecha_convertida",
        "COALESCE(COUNT(sta_usuarios_visitas.user_requests_ip), 0) AS num_requests"
    ]);

    $builder->join('sta_usuarios_visitas', 'generated_fecha = sta_usuarios_visitas.fecha', 'LEFT');
    $builder->groupBy('generated_fecha');
    $builder->orderBy('generated_fecha', 'ASC');

    $resultado = $builder->get()->getResult();
    return $resultado;
}

	
}
