<?php

namespace App\Controllers;


use CodeIgniter\API\ResponseTrait;
use App\Models\Pais_Model;
use CodeIgniter\RESTful\ResourceController;

class Pais_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LOS pais
    */
	public function llenar_pais()
	{
		$model = new Pais_Model();
		$query = $model->llenar_pais();
		if (empty($query)) {
			$pais = [];
		} else {
			$pais = $query;
		}
		return $this->response->setJSON($pais);
	}
}
