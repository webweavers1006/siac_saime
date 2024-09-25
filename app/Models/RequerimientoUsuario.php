<?php namespace App\Models;

class RequerimientoUsuario extends BaseModel{

	//Metodo que obtiene los requerimientos del usuario
	public function getTipoRequerimiento(){
		$builder = $this->dbconn('sgc_tipo_req_usu');
		$query = $builder->get();
		return $query;
	}

	//Metodo para registrar los requerimientos de los usuarios
	public function insertarRequerimientoUsuario(Array $datos){
		$builder = $this->dbconn('sgc_tipo_req_usu_caso');
		$query = $builder->insertBatch($datos);
		return $query;
	}
}