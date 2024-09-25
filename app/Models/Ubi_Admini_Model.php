<?php

namespace App\Models;

use CodeIgniter\Model;

class Ubi_Admini_Model extends BaseModel
{
	//Metodo para insertar una Direccion Administrativa
	public function add_Direccion($direcciones)
	{
		$builder = $this->dbconn("sgc_direcciones_administrativas");
		$query = $builder->insert($direcciones);
		return $query;
	}

	//Metodo para actualizar una Direccion Administrativa
	public function editDirecciones($direcciones)
	{
		$builder = $this->dbconn("sgc_direcciones_administrativas");
		$query = $builder->update($direcciones, 'id = ' . $direcciones["id"]);
		return $query;
	}

	public function listar_Ubicacion_Administrativa()
	{
		$builder = $this->dbconn('public.sgc_direcciones_administrativas as direc');
		$builder->select(
			"direc.id,direc.descripcion,direc.correo,case when direc.borrado='false' then 'Activo' else 'Inactivo' end as borrado "
		);
		//$builder->where(['direc.borrado' => false]);
		$query = $builder->get();
		return $query;
	}
	public function listar_direcciones_administrativas()
	{
		$builder = $this->dbconn('public.sgc_direcciones_administrativas as direc');
		$builder->select(
			"direc.id,direc.descripcion,direc.correo,case when direc.borrado='false' then 'Activo' else 'Inactivo' end as borrado "
		);
		$builder->where(['direc.borrado' => false]);
		$query = $builder->get();
		return $query;
	}
	public function listar_direcciones_user_create($act_aud)
	{
    	$builder = $this->dbconn('public.sgc_direcciones_administrativas as direc');
		$builder->select([
			'direc.id',
			'direc.descripcion',
			'direc.correo',
			"CASE WHEN direc.borrado = 'false' THEN 'Activo' ELSE 'Inactivo' END AS borrado"
		]);
    	$builder->where([
			'direc.borrado' => false,
			'direc.act_aud' => $act_aud
    		]);
   		 $query = $builder->get();
    	return $query;
}

	



	public function buscar_correo($direccion)
	{
		$builder = $this->dbconn('public.sgc_direcciones_administrativas as direc');
		$builder->select(
			"direc.id,direc.descripcion,direc.correo "
		);
		$builder->where(['direc.id' => $direccion]);
		$query = $builder->get();
		return $query;
	}

}
