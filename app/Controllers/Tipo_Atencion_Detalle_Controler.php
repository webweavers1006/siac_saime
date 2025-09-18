<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Tipo_Atencion_Detalle_Model;
use CodeIgniter\RESTful\ResourceController;

class Tipo_Atencion_Detalle_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_detalle_atencion()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('tipo_atencion_detalle/content.php');
			echo view('template/footer');
			echo view('tipo_atencion_detalle/footer_tipo_atencion_detalle.php');
		} else {
			return redirect()->to('/');
		}
	}



	/*
       FUNCION PARA OBTENER LOS TIPOS DE solicitud
    */
	public function Listar_Detalle_Atencion()
	{
		$model = new Tipo_Atencion_Detalle_Model();
		$query = $model->Listar_Detalle_Atencion();
		if (empty($query)) {
			$detalle = [];
		} else {
			$detalle = $query;
		}
		echo json_encode($detalle);
	}

	/*
       FUNCION PARA OBTENER LOS TIPOS DE solicitud ACTIVOS
    */
	public function Listar_Detalle_Atencion_filtro()
	{
		$model = new Tipo_Atencion_Detalle_Model();
		$query = $model->Listar_Detalle_Atencion_filtro();
		if (empty($query)) {
			$detalle = [];
		} else {
			$detalle = $query;
		}
		echo json_encode($detalle);
	}

//Metodo que buscar_hijos_detalle_atencion
public function buscar_hijos_detalle_atencion($id_tipo_atencion=null)

{
	$model = new Tipo_Atencion_Detalle_Model();
	$query = $model->buscar_hijos_detalle_atencion($id_tipo_atencion);	
	if (empty($query)) 
	{
			$hijos = [];
	} else 
	{
			$hijos = $query;
	}
	echo json_encode($hijos);
		
}


	//Metodo para añadir Detalle Atencion
	public function add_Detalle_Atencion()
	{
		$model = new Tipo_Atencion_Detalle_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$detalle["tipo_atend_nombre"]     = $datos["tipo_atend_nombre"];
			$detalle["tipo_aten_id"]     = $datos["tipo_aten_id"];
			//Realizamos la insercion en la tabla
			$query_insertar_detalle = $model->add_detalle($detalle);
			if (isset($query_insertar_detalle)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'INGRESO EL  DETALLE DE ATENCION: ' . '(' . ' ' . $detalle["tipo_atend_nombre"] . ' ' . ')';
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

	//Metodo para ACTUALIZAR EL TIPO DE solicitud 
	public function editDetalle_Atencion()
	{
		$model = new Tipo_Atencion_Detalle_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$detalle["tipo_atend_nombre"]     = $datos["tipo_atend_nombre"];
			$detalle["tipo_atend_borrado"]     = $datos["tipo_atend_borrado"];
			$detalle["tipo_atend_id"]     = $datos["tipo_atend_id"];
			$detalle["tipo_aten_id"]     = $datos["tipo_aten_id"];
			//Realizamos la actualizacion en la tabla
			$query_editar_detalle = $model->editDetalle_Atencion($detalle);
			if (isset($query_editar_detalle)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = ' EL TIPO DE DETALLE :' . ' ' . '(' . ' ' . $detalle["tipo_atend_nombre"] . ')' . ' ' . ' FUE ACTUALIZADO';
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
