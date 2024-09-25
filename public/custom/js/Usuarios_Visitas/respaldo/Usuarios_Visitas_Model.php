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



	 $strQuery = " SELECT ";
	 $strQuery .= "  TO_CHAR(fecha, 'Day') AS dia_semana_completo, fecha,";
	 $strQuery .= " COUNT(user_requests_ip) AS num_requests";
	 $strQuery .= "  FROM ";
	 $strQuery .= " public.sta_usuarios_visitas";
	 if ($desde != 'null' and $hasta != 'null') {
		 $strQuery .= " where  fecha BETWEEN '$desde' AND '$hasta' ";  # code...
	 }
	 $strQuery .= " GROUP BY ";
	 $strQuery .= " fecha, TO_CHAR(fecha, 'Day')";
	 $strQuery .= " ORDER BY ";
	 $strQuery .= " fecha ASC;"; // Ordenar en orden ascendente
	 $query = $db->query($strQuery);
	 $resultado = $query->getResult();
	 return $resultado;
 }


 






	
}
