<?php

namespace App\Controllers;

use App\Models\Roles_Model;
use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class Categorias_Audiencias_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de las direcciones 
	public function vista_Categorias_audiencias()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('audiencias/categorias_audiencias/content.php');
			echo view('template/footer');
			echo view('audiencias/categorias_audiencias/footer_categoria.php');
		} else {
			return redirect()->to('/');
		}
	}


	public function listar_roles()
	{

		$model = new Roles_Model();
		$query = $model->listar_roles();
		
		if (empty($query->getResult())) {
			$roles = [];
		} else {
			$roles = $query->getResultArray();
		}
		echo json_encode($roles);
	}
	//Metodo para añadir Direcciones
	public function add_Rol()
	{
		$model = new Roles_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$roles["rolnom"]     = $datos["descripcion"];
			//Realizamos la insercion en la tabla
			$query_insertar_caso = $model->add_Rol($roles);
			if (isset($query_insertar_caso)) {
				$repuesta['mensaje']      = 1;
				return json_encode($repuesta);
			} else {
				$repuesta['mensaje']      = 2;
				return json_encode($repuesta);
			}
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo para ACTUALIZAR Direcciones
	public function editRol()
	{
		$model = new Roles_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$roles["rolnom"]     = $datos["descripcion"];
			$roles["borrado"]     = $datos["borrado"];
			$roles["idrol"]     = $datos["id_rol"];
			//Realizamos la actualizacion en la tabla
			$query_editar_roles = $model->editRol($roles);
			if (isset($query_editar_roles)) {

				$mensaje = 1;
				return json_encode($mensaje);
			} else {
				$mensaje = 2;
				return json_encode($mensaje);
			}
		} else {
			return redirect()->to('/');
		}
	}
}
