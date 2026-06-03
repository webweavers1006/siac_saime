<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Tipo_Beneficiario_Model;
use CodeIgniter\RESTful\ResourceController;

class Tipo_Beneficiarios_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_tipo_Beneficiarios()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('tipo_de_beneficiario/content.php');
			echo view('template/footer');
			echo view('tipo_de_beneficiario/footer_beneficiarios.php');
		} else {
			return redirect()->to('/');
		}
	}

	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
    */
	public function Listar_Tipo_Beneficiarios()
	{
		$model = new Tipo_Beneficiario_Model();
		$query = $model->Listar_Tipo_Beneficiarios();
		
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		return $this->response->setJSON($atencion);
	}

	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION ACTIVOS
    */
	public function Listar_Tipo_Beneficiarios_filtro()
	{
		$model = new Tipo_Beneficiario_Model();
		$query = $model->Listar_Tipo_Beneficiarios_filtro();
		if (empty($query)) {
			$Beneficiarios = [];
		} else {
			$Beneficiarios = $query;
		}
		return $this->response->setJSON($Beneficiarios);
	}




	//Metodo para añadir tipo de atencion
	public function add_Tipo_Beneficiarios()
	{
		$model = new Tipo_Beneficiario_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales de las Direccion
			$beneficiarios["tipo_beneficiario_nombre"]     = $datos["descripcion"];
			$beneficiarios["tipo_beneficiario_requiere_cedula"] = isset($datos["requiere_cedula"]) ? filter_var($datos["requiere_cedula"], FILTER_VALIDATE_BOOLEAN) : true;
			//Realizamos la insercion en la tabla
			$query_insertar_beneficiarios = $model->add_beneficiarios($beneficiarios);
			if (isset($query_insertar_beneficiarios)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'INGRESO EL TIPO DE BENEFICIARIO : ' . '(' . ' ' . $beneficiarios["tipo_beneficiario_nombre"] . ' ' . ')';
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

	//Metodo para ACTUALIZAR Direcciones
	public function editTipoBeneficiario()
	{
		$model = new Tipo_Beneficiario_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales de las Direccion
			$Beneficiarios["tipo_beneficiario_nombre"]     = $datos["descripcion"];
			$Beneficiarios["tipo_beneficiario_requiere_cedula"] = isset($datos["requiere_cedula"]) ? filter_var($datos["requiere_cedula"], FILTER_VALIDATE_BOOLEAN) : true;
			$Beneficiarios["tipo_beneficiario_borrado"]     = $datos["borrado"];
			$Beneficiarios["tipo_beneficiario_id"]     = $datos["id_beneficiario"];
			//Realizamos la actualizacion en la tabla
			$query_editar_Beneficiarios = $model->editTipoBeneficiario($Beneficiarios);
			if (isset($query_editar_Beneficiarios)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = ' EL TIPO DE Beneficiarios :' . ' ' . '(' . ' ' . $Beneficiarios["tipo_beneficiario_nombre"] . ')' . ' ' . ' FUE ACTUALIZADO';
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
