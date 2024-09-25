<?php 
namespace App\Models;

class Roles extends BaseModel{

	//Metodo para obtener los roles registrados

	public function getRoles($idrol){
		$builder = $this->dbconn('sgc_roles r');
		if ($idrol!=5) {
			$where = "r.idrol!=5";
			$builder->where($where);
		}
		$query = $builder->get();
		return $query;
	}
}