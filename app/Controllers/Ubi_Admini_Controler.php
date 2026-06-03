<?php

namespace App\Controllers;

use App\Models\Ubi_Admini_Model;
use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class Ubi_Admini_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de las direcciones 
	public function vista_direcciones_admin()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('direcciones_admini/content.php');
			echo view('template/footer');
			echo view('direcciones_admini/footer_direcciones.php');
		} else {
			return redirect()->to('/');
		}
	}
	public function listar_Ubicacion_Administrativa()
	{

		$model = new Ubi_Admini_Model();
		$query = $model->listar_Ubicacion_Administrativa();

		if (empty($query->getResult())) {
			$ubicacion = [];
		} else {
			$ubicacion = $query->getResultArray();
		}
		return $this->response->setJSON($ubicacion);
	}

	public function listar_direcciones_administrativas()
	{

		$model = new Ubi_Admini_Model();
		$query = $model->listar_direcciones_administrativas();

		if (empty($query->getResult())) {
			$direcciones = [];
		} else {
			$direcciones = $query->getResultArray();
		}
		return $this->response->setJSON($direcciones);
	}

	public function listar_direcciones_user_create($act_aud=null)
	{

		$model = new Ubi_Admini_Model();
		$query = $model->listar_direcciones_user_create($act_aud);

		if (empty($query->getResult())) {
			$direcciones = [];
		} else {
			$direcciones = $query->getResultArray();
		}
		return $this->response->setJSON($direcciones);
	}
	

	







	//Metodo para añadir Direcciones
	public function add_Direccion()
	{
		$model = new Ubi_Admini_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales de las Direccion
			$direcciones["descripcion"]     = $datos["descripcion"];
			$direcciones["correo"]     = $datos["correo"];
			//Realizamos la insercion en la tabla
			$query_insertar_caso = $model->add_Direccion($direcciones);
			if (isset($query_insertar_caso)) {
				$repuesta['mensaje']      = 1;
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'INGRESO LA  DIRECCION :' . '(' . ' ' . $direcciones["descripcion"] . ' ' . ')';
				$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
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
	public function editDirecciones()
	{
		$model = new Ubi_Admini_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales de las Direccion
			$direcciones["descripcion"]     = $datos["descripcion"];
			$direcciones["borrado"]     = $datos["borrado"];
			$direcciones["id"]     = $datos["id_direccion"];
			$direcciones["correo"]     = $datos["correo"];
			//Realizamos la actualizacion en la tabla
			$query_editar_caso = $model->editDirecciones($direcciones);
			if (isset($query_editar_caso)) {

				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = ' La  DIRECCION :' . ' ' . '(' . ' ' . $direcciones["descripcion"] . '' . ' )' . ' ' . 'FUE ACTUALIZADA';
				$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
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
