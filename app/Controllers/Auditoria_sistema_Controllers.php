<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;


use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class Auditoria_sistema_Controllers extends BaseController
{
	use ResponseTrait;

	public function auditoria_sistema()
	{

		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('auditoria_sistema/content_Auditoria_sistema');
			echo view('template/footer');
			echo view('/auditoria_sistema/footer_Auditoria_sistema');
		} else {
			return redirect()->to('/');
		}
	}
	/*
      * Función parar cargar los registros del Módulo en el Data Table o en las Persianas
      */

	public function listar_auditoria_sistema($direccion_ip = null, $dispositivo = null)
	{
		if ($this->session->get('logged')) {
			$model = new Auditoria_sistema_Model();
			$query = $model->listar_auditoria_sistema($direccion_ip, $dispositivo);
		
			if (empty($query)) {
				$auditoria = [];
			} else {
				$auditoria = $query;
			}
			return $this->response->setJSON($auditoria);
		}
	}
}
