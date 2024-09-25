<?php

namespace App\Models;

use CodeIgniter\Model;

class Roles_Model extends BaseModel
{
	//Metodo para insertar una Direccion Administrativa
	public function add_Rol($roles)
	{
		$builder = $this->dbconn("public.sgc_roles ");
		$query = $builder->insert($roles);
		return $query;
	}

	//Metodo para actualizar una Direccion Administrativa
	public function editRol($roles)
	{
		$builder = $this->dbconn("public.sgc_roles ");
		$query = $builder->update($roles, 'idrol = ' . $roles["idrol"]);
		return $query;
	}

	public function listar_roles()
	{
		$builder = $this->dbconn('public.sgc_roles as r');
		$builder->select(
			"r.idrol,r.rolnom,case when r.borrado='f' then 'Activo ' else 'Inactivo 'end as borrado "
		);
		//$builder->where(['direc.borrado' => false]);
		$query = $builder->get();
		return $query;
	}
	public function listar_direcciones_administrativas()
	{
		$builder = $this->dbconn('public.public.sgc_roles  as direc');
		$builder->select(
			"direc.id,direc.descripcion,case when direc.borrado='false' then 'Activo' else 'Inactivo' end as borrado "
		);
		$builder->where(['direc.borrado' => false]);
		$query = $builder->get();
		return $query;
	}
	public function buscar_correo($direccion)
	{
		$builder = $this->dbconn('public.public.sgc_roles  as direc');
		$builder->select(
			"direc.id,direc.descripcion,direc.correo "
		);
		$builder->where(['direc.id' => $direccion]);
		$query = $builder->get();
		return $query;
	}

}
