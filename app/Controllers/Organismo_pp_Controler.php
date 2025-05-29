<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Organismo_pp_Model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Auditoria_sistema_Model;


class Organismo_pp_Controler extends BaseController
{
	use ResponseTrait;

 	/**
     * Muestra la vista de los tipos de organismos.
     */
	public function vista_organismo_pp()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('organismo_pp/content.php');
			echo view('template/footer');
			echo view('organismo_pp/footer_organismo_pp.php');
		} else {
			return redirect()->to('/');
		}
	}

 	/**
     * Obtiene la lista de organismos.
     */
	public function Listar_organismo_pp()
	{
		$model = new Organismo_pp_Model();
		$query = $model->Listar_organismo_pp();
		if (empty($query)) {
			$organismo = [];
		} else {
			$organismo = $query;
		}
		echo json_encode($organismo);
	}


	

	/**
     * Añade un nuevo organismo.
     */
	public function add_organismo_pp()
	{
		$model = new Organismo_pp_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$organismo["org_nombre"]     = $datos["org_nombre"];
			

			//Realizamos la insercion en la tabla
			$query_insertar_organismo = $model->add_organismo($organismo);
			if (isset($query_insertar_organismo)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'INGRESO EL ORGANISMO : ' . '(' . ' ' . $organismo["org_nombre"] . ' ' . ')';
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


	/**
	 * Actualiza un organismo existente.
	 */
	public function edit_organimo_pp()
	{
		$model = new Organismo_pp_Model();
		$model_via_organismo = new Organismo_pp_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) 
		{
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$organismo["org_nombre"]     = $datos["org_nombre"];
			$organismo["org_borrado"]     = $datos["borrado"];
			$organismo["org_id"]     = $datos["org_id"];
			$query_editar_organismo = $model->edit_organimo_pp($organismo);
			
			if (isset($query_editar_organismo)) 
			{
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = ' El organismo :' . ' ' . '(' . ' ' . $organismo["org_nombre"] . ')' . ' ' . ' FUE ACTUALIZADO';
				$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				$mensaje = 1;	
				return json_encode($mensaje);	
			} else 
			{

				$mensaje = 2;
				return json_encode($mensaje);
			}
									
		}				
		else {
			return redirect()->to('/');
		}
	}

	/**
	 * Obtiene la lista de organismos que no estee borrados .
	 */

	public function Listar_Organismo_PP_filtro()
	{
		$model = new Organismo_pp_Model();
		$query = $model->Listar_Organismo_PP_filtro();
		if (empty($query)) {
			$organismos = [];
		} else {
			$organismos = $query;
		}
		echo json_encode($organismos);
	}
	
}


// /*
    //    FUNCION PARA OBTENER LAS REDES SOCIALES
    // */
	// public function listar_Red_Social()
	// {
	// 	$model = new Organismo_pp_Model();
	// 	$query = $model->listar_Red_Social();
	// 	if (empty($query)) {
	// 		$red_social = [];
	// 	} else {
	// 		$red_social = $query;
	// 	}
	// 	echo json_encode($red_social);
	// }

	

	// public function buscar_formacion_red_social($id_red_social=null)
	// {
		
	// 	$model = new Organismo_pp_Model();
	// 	$query = $model->buscar_formacion_red_social($id_red_social);
		
	// 	if (empty($query)) {
	// 		$f_red_social = [];
	// 	} else {
	// 		$f_red_social = $query;
	// 	}
	// 	echo json_encode($f_red_social);
	// }