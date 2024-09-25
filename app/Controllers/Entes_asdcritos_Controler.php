<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Entes_asdcritos_Model;
use CodeIgniter\RESTful\ResourceController;

class Entes_asdcritos_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LAS REDES SOCIALES
    */
	public function listar_Entes_asdcritos()
	{
		$model = new Entes_asdcritos_Model();
		$query = $model->listar_Entes_asdcritos();
		if (empty($query)) {
			$entes_asdcritos = [];
		} else {
			$entes_asdcritos = $query;
		}
		echo json_encode($entes_asdcritos);
	}
}
