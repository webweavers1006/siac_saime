<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Municipios_Model;
use CodeIgniter\RESTful\ResourceController;

class Municipios_Controler extends BaseController
{
	use ResponseTrait;
	/*
       FUNCION PARA OBTENER LOS MUNICIPIOS
    */
	public function listar_Municipios()
	{
		$model = new Municipios_Model();
		$opt = '';
		if ($this->request->isAJAX() and $this->session->get('logged')) {
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);

			$query = $model->listar_Municipios($datos["id_estado"]);
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$opt .= '<option value="' . $row->municipioid . '">' . ucfirst(strtolower($row->municipionom)) . '</option>';
				}
				unset($model);
				return $this->respond(["message" => "success", "data" => $opt], 200);
			} else {
				unset($model);
				return $this->respond(["message" => "not found"], 404);
			}
		} else {
			unset($model);
			return redirect()->to('/');
		}
	}

	//Metodo para obtener las parroquias de acuerdo al municipio
	public function listar_Parroquias()
	{
		$model = new Municipios_Model();
		$opt = '';
		if ($this->request->isAJAX() and $this->session->get('logged')) {
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			$query = $model->listar_Parroquias($datos["id_municipio"]);
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$opt .= '<option value="' . $row->parroquiaid . '">' . ucfirst(strtolower($row->parroquianom)) . '</option>';
				}
				unset($model);
				return $this->respond(["message" => "success", "data" => $opt], 200);
			} else {
				unset($model);
				return $this->respond(["message" => "not found"], 404);
			}
		} else {
			unset($model);
			return redirect()->to('/');
		}
	}
}
