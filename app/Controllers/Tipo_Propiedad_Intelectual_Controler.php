<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Tipo_Propiedad_Intelectual_Model;
use CodeIgniter\RESTful\ResourceController;

class Tipo_Propiedad_Intelectual_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
    */
	public function Listar_Propiedad_Intelectual()
	{
		$model = new Tipo_Propiedad_Intelectual_Model();
		$query = $model->Listar_Propiedad_Intelectual();
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		return $this->response->setJSON($atencion);
	}


	public function Listar_Propiedad_Intelectual_MOD()
	{
		$model = new Tipo_Propiedad_Intelectual_Model();
		$query = $model->Listar_Propiedad_Intelectual_MOD();
		
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		return $this->response->setJSON($atencion);
	}


	

}
