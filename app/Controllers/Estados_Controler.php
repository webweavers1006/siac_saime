<?php

namespace App\Controllers;


use CodeIgniter\API\ResponseTrait;
use App\Models\Estados_Model;
use CodeIgniter\RESTful\ResourceController;

class Estados_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LOS ESTADOS
    */
	public function listar_Estados()
	{
		$model = new Estados_Model();
		$query = $model->listar_Estados();
		if (empty($query)) {
			$estados = [];
		} else {
			$estados = $query;
		}
		return $this->response->setJSON($estados);
	}
}
