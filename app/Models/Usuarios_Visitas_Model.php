<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuarios_Visitas_Model extends BaseModel
{


	public function insertarIP($newCase)
	{
		

		$hora = date("H:i:s A");
		$newCase['hora'] = $hora;
		$builder = $this->dbconn('public.sta_usuarios_visitas ');
		$query = $builder->insert($newCase);
		return $query;
	}


public function ContarUsuariosVisitas($desde, $hasta)
{
    $db = \Config\Database::connect();

    // Sanitizar fechas en PHP
    $desdeDate = date('Y-m-d', strtotime($desde));
    $hastaDate = date('Y-m-d', strtotime($hasta));

    // Usar SQL puro en vez de query builder mixto
    $sql = "
        SELECT 
            CASE 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Sunday'    THEN 'Domingo' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Monday'    THEN 'Lunes' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Tuesday'   THEN 'Martes' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Wednesday' THEN 'Miércoles' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Thursday'  THEN 'Jueves' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Friday'    THEN 'Viernes' 
                WHEN TRIM(TO_CHAR(generated_fecha, 'Day')) = 'Saturday'  THEN 'Sábado' 
            END AS dia_semana_completo,
            TO_CHAR(generated_fecha, 'yyyy/mm/dd') AS fecha,
            TO_CHAR(generated_fecha, 'dd/mm/yyyy') AS fecha_convertida,
            COALESCE(COUNT(v.user_requests_ip), 0) AS num_requests
        FROM generate_series(" . $db->escape($desdeDate) . "::date, " . $db->escape($hastaDate) . "::date, '1 day'::interval) AS generated_fecha
        LEFT JOIN sta_usuarios_visitas v ON generated_fecha = v.fecha
        GROUP BY generated_fecha
        ORDER BY generated_fecha ASC
    ";

    return $db->query($sql)->getResult();
}

	
}
