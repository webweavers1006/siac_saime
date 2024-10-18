<?php

namespace App\Controllers;

use App\Models\Roles_Model;
use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class Permisos_Audiencias_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de las direcciones 
	public function vista_Permisos_audiencias()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('audiencias/permisos_audiencias/content.php');
			echo view('template/footer');
			echo view('audiencias/permisos_audiencias/footer_permisos.php');
		} else {
			return redirect()->to('/');
		}
	}

	
}
