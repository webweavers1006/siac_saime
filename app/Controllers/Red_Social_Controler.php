<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Red_Social_Model;
use CodeIgniter\RESTful\ResourceController;

class Red_Social_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LAS REDES SOCIALES
    */
	public function listar_Red_Social()
	{
		$model = new Red_Social_Model();
		$query = $model->listar_Red_Social();
		if (empty($query)) {
			$red_social = [];
		} else {
			$red_social = $query;
		}
		echo json_encode($red_social);
	}

	public function listar_Red_Social_filtro()
	{
		$model = new Red_Social_Model();
		$query = $model->listar_Red_Social_filtro();
		if (empty($query)) {
			$red_social = [];
		} else {
			$red_social = $query;
		}
		echo json_encode($red_social);
	}


	
}
