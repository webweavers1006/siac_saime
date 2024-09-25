<?php
namespace App\Models;

/*
	Modelo de la Division politico territorial de los paises
*/

class Dpt extends BaseModel{

	//Metodo para obtener todos los paises
	public function getAllCountries(){
		$builder = $this->dbconn('sgc_paises');
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener todos los estados
	public function getAllStates(){
		$builder = $this->dbconn('sgc_estados');
		$query = $builder->get();
		return $query;	
	}

	//Metodo para obtener todos los municipios
	public function getAllMunicipios(){
		$builder = $this->dbconn('sgc_municipio');
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener todas las parroquias
	public function getAllParroquias(){
		$builder = $this->dbconn('sgc_parroquias');
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener los municipios por estado
	public function getMunicipiosByState(String $id_estado){
		$builder = $this->dbconn('sgc_municipio');
		$builder->where('estadoid', $id_estado);
		$query = $builder->get();
		return $query;
	}

	//Metodo para obtener las parroquias de acuerdo al municipio
	public function getParroquiaByMunicipio($id_municipio){
		$builder = $this->dbconn('sgc_parroquias');
		$builder->where('municipioid', $id_municipio);
		$query = $builder->get();
		return $query;
	}
}