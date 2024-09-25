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
	 $db      = \Config\Database::connect();

 
	 $strQuery = "SELECT 
                case 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Sunday' THEN 'Domingo' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Monday' THEN 'Lunes' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Tuesday' THEN 'Martes' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Wednesday' THEN 'Miércoles' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Thursday' THEN 'Jueves' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Friday' THEN 'Viernes' 
                    WHEN Trim(TO_CHAR(generated_fecha, 'Day')) = 'Saturday' THEN 'Sábado' 
                end as dia_semana_completo, 
                TO_CHAR(generated_fecha,'yyyy/mm/dd') as fecha, 
                TO_CHAR(generated_fecha,'dd/mm/yyyy') as fecha_convertida , 
                COALESCE(COUNT(public.sta_usuarios_visitas.user_requests_ip), 0) AS num_requests 
            FROM generate_series('$desde'::date, '$hasta'::date, '1 day'::interval) AS generated_fecha
            LEFT JOIN public.sta_usuarios_visitas ON generated_fecha = public.sta_usuarios_visitas.fecha
            GROUP BY generated_fecha
            ORDER BY generated_fecha ASC;";
	$query = $db->query($strQuery);
	$resultado = $query->getResult();
	  return $resultado;
 }


	
}
