<?php namespace App\Models;

class Estatus extends BaseModel{

	//Metodo para obtener los estatus de los casos
	public function estatusCaso(){
		$builder = $this->dbconn('sgc_estatus');
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los estatus de las llamadas
	public function estatusLlamadas(){
		$builder = $this->dbconn('sgc_estatus_llamadas');
		$query = $builder->get();
		return $query;
	}

	//Metodo para cambiar el estatus de un caso
	public function cambioEstatusCaso(Array $datos){
		$builder = $this->dbconn('sgc_casos');
		$query = $builder->update(["idest" => $datos["idest"]],"idcaso = ".$datos["idcaso"]);
		return $query;
	}

}