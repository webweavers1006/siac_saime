<?php

namespace App\Models;

use CodeIgniter\Model;

class Via_Tipo_Atencion_Model extends BaseModel
{


		public function hijos_Asociadas($ViaAtencionId = null)
	{
		$db = \Config\Database::connect();
		$builder = $db->table('sgc_via_tipo_atencion as vt_atencion');
		$builder->select('vt_atencion.id, vt_atencion.via_atencion_id, vt_atencion.tipo_atencion_id, vt_atencion.borrado');
		if ($ViaAtencionId !== null) {
			$builder->where('vt_atencion.via_atencion_id', $ViaAtencionId);
		}
		$query = $builder->get();
		$resultado = $query->getResult();
		return $resultado;
	}


	public function buscar_via_tipo_atencion($id_red_social = null)
	{
		
		
		$db = \Config\Database::connect();
		$builder = $db->table('sgc_via_tipo_atencion as vt_atencion');
		$builder->select(' tu.organismo_pp,tu.act_pro_int, tu.tipo_aten_nombre, vt_atencion.id, vt_atencion.via_atencion_id, vt_atencion.tipo_atencion_id, vt_atencion.borrado');
		$builder->join('sgc_tipoatencion_usu tu', 'vt_atencion.tipo_atencion_id = tu.tipo_aten_id');
		if ($id_red_social !== null) {
			$builder->where('vt_atencion.via_atencion_id', $id_red_social);
		}
		$query = $builder->get();
		$resultado = $query->getResult();
		return $resultado;
	}


	// public function buscar_via_tipo_atencion($ViaAtencionId = null)
	// {
		
	// 	$db = \Config\Database::connect();
	// 	$builder = $db->table('sgc_via_tipo_atencion as vt_atencion');
	// 	$builder->select('tu.act_pro_int, tu.tipo_aten_nombre, vt_atencion.id, vt_atencion.via_atencion_id, vt_atencion.tipo_atencion_id, vt_atencion.borrado');
	// 	$builder->join('sgc_tipoatencion_usu tu', 'vt_atencion.tipo_atencion_id = tu.tipo_aten_id');
	// 	if ($ViaAtencionId !== null) {
	// 		$builder->where('vt_atencion.via_atencion_id', $ViaAtencionId);
	// 	}
	// 	$query = $builder->get();
	// 	$resultado = $query->getResult();
	// 	return $resultado;
	// }
	public function hijos_existentes($datos2 = null)
	{
		// Verificamos si $datos2 no es nulo y contiene al menos un elemento
		if ($datos2 && isset($datos2[0])) {
			$viaAtencionId = $datos2[0]['via_atencion_id'];
			$tipoAtencionId = $datos2[0]['tipo_atencion_id'];
			$db = \Config\Database::connect();
			$builder = $db->table('sgc_via_tipo_atencion as vt_atencion');
			$builder->select('vt_atencion.id, vt_atencion.via_atencion_id, vt_atencion.tipo_atencion_id, vt_atencion.borrado');
			$builder->where('vt_atencion.via_atencion_id', $viaAtencionId);
			//$builder->where('vt_atencion.tipo_atencion_id', $tipoAtencionId);
			$query = $builder->get();
			$resultado = $query->getResult();
			return $resultado;
		}
		return null;
	}







    // METODO QUE ELIMINA LOS HIJOS ASOSCIADOS
	public function Eliminar_hijos_Asociadas($deletedElements,$ViaAtencionId)
	{
		{

			$builder = $this->dbconn(' sgc_via_tipo_atencion');
			foreach ($deletedElements as $Row)
			{	
				$builder->where('via_atencion_id',$ViaAtencionId);
				$builder->where('tipo_atencion_id',$Row);
				$query = $builder->update([
					'borrado' => true,
				]);
			}
			return $query;
		}

	}








// MÉTODO QUE ACTIVA LOS HIJOS ASOCIADOS 
public function Activar_hijos_Asociadas($hijos)
{
    $builder = $this->dbconn('sgc_via_tipo_atencion');

    foreach ($hijos as $hijo) {
        // Verificamos que los índices existan en el array
        if (isset($hijo['via_atencion_id']) && isset($hijo['tipo_atencion_id'])) {
            $builder->where('via_atencion_id', $hijo['via_atencion_id']);
            $builder->where('tipo_atencion_id', $hijo['tipo_atencion_id']);
            $builder->update(['borrado' => false]);
        }
    }

    return true; // O el resultado que desees
}
	




	public function agregar($datos)
	{

		
		$builder = $this->dbconn('sgc_via_tipo_atencion');
		// Variable para almacenar el resultado de las inserciones
		$resultado = true;
		// Iterar sobre cada elemento del array de datos
		foreach ($datos as $dato) {
			$query = $builder->insert($dato);
			// Si alguna inserción falla, cambiar el resultado a false
			if (!$query) {
				$resultado = false;
				break; // Salir del bucle si hay un error
			}
		}
		return $resultado;
	}
   
}
