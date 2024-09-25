<?php namespace App\Models;

class RedSocial extends BaseModel{
	//Metodo para obtener todas las redes sociales
	public function getAllSocialNet(){
		$builder = $this->dbconn('sgc_red_social');
		$query = $builder->get();
		return $query;
	}
}