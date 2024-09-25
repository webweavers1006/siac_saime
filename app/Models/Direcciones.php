<?php namespace App\Models;

class Direcciones extends BaseModel{

	//Metodo para obtener todas las direcciones
	public function getDirecciones(){
		$builder = $this->dbconn('sgc_direccion_correspondiente a');
		$query = $builder->get();
		return $query;
	}

	//Metodo para insertar todas las direcciones que corresponden los casos
	public function insertarDireccionCaso(Array $datos){
		$builder = $this->dbconn('sgc_dir_cor_caso');
		$query = $builder->insertBatch($datos);
		return $query;
	}
}