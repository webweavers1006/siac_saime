<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Via_Tipo_Atencion_Model;
use CodeIgniter\RESTful\ResourceController;

class Via_Tipo_Atencion_Controler extends BaseController
{
	use ResponseTrait;

	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
    */
	public function buscar_via_tipo_atencion($id_red_social=NULL)
	{
		$model = new Via_Tipo_Atencion_Model();
		$query = $model->buscar_via_tipo_atencion($id_red_social);
		
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		return $this->response->setJSON($atencion);
	}

}
