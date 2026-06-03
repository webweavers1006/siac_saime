<?php

namespace App\Controllers;

use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Red_Social_Model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Auditoria_sistema_Model;
use App\Models\Via_Tipo_Atencion_Model;


class Red_Social_Controler extends BaseController
{
	use ResponseTrait;


	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_via_atencion()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('via_de_atencion/content.php');
			echo view('template/footer');
			echo view('via_de_atencion/footer_atencion.php');
		} else {
			return redirect()->to('/');
		}
	}

/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
    */
	public function Listar_Via_Atencion()
	{
		$model = new Red_Social_Model();
		$query = $model->Listar_Via_Atencion();
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		return $this->response->setJSON($atencion);
	}


	/*
       FUNCION PARA OBTENER LAS REDES SOCIALES
    */
	public function listar_Red_Social()
	{
		$model = new Red_Social_Model();
		$query = $model->listar_Red_Social();
		if (empty($query)) {
			$red_social = [];
		} else {
			$red_social = $query;
		}
		return $this->response->setJSON($red_social);
	}

	public function listar_Red_Social_filtro()
	{
		$model = new Red_Social_Model();
		$query = $model->listar_Red_Social_filtro();
		if (empty($query)) {
			$red_social = [];
		} else {
			$red_social = $query;
		}
		return $this->response->setJSON($red_social);
	}

	public function buscar_formacion_red_social($id_red_social=null)
	{
		
		$model = new Red_Social_Model();
		$query = $model->buscar_formacion_red_social($id_red_social);
		
		if (empty($query)) {
			$f_red_social = [];
		} else {
			$f_red_social = $query;
		}
		return $this->response->setJSON($f_red_social);
	}

//Metodo para añadir via de atencion
public function add_Via_Atencion()
{
	$model = new Red_Social_Model();
	$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
	if ($this->session->get('logged') and $this->request->isAJAX()) {
		//Obtenemos los datos del formulario
		$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
		//llenamos los datos iniciales de las Direccion
		$atencion["red_s_nom"]     = $datos["red_s_nom"];
		

		//Realizamos la insercion en la tabla
		$query_insertar_atencion = $model->add_ViaAtencion($atencion);
		if (isset($query_insertar_atencion)) {
			$auditoria['audi_user_id']   = session('iduser');
			$auditoria['audi_accion']   = 'INGRESO LA VIA  DE ATENCION : ' . '(' . ' ' . $atencion["red_s_nom"] . ' ' . ')';
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


//METODO PARA ACTUALIZAR LOS TIPOS DE ATENCIONES
public function editViaAtencion()
{
	$model = new Red_Social_Model();
	$model_via_atencion = new Via_Tipo_Atencion_Model();
	$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
	if ($this->session->get('logged') and $this->request->isAJAX()) 
	{
		//Obtenemos los datos del formulario
		$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
		//llenamos los datos iniciales de las Direccion
		$atencion["red_s_nom"]     = $datos["red_s_nom"];
		$atencion["red_s_borrado"]     = $datos["borrado"];
		$atencion["red_s_id"]     = $datos["red_s_id"];


		
		$selectedValues = $datos["selectedValues"];
		$deletedElements = $datos["deletedElements"];
		$ViaAtencionId=$datos["red_s_id"];
		//Realizamos la actualizacion en la tabla
		$query_editar_atencion = $model->editViaAtencion($atencion);
		

		if (isset($query_editar_atencion)) 
		{
			$auditoria['audi_user_id']   = session('iduser');
			$auditoria['audi_accion']   = ' LA VIA  DE ATENCION :' . ' ' . '(' . ' ' . $atencion["red_s_nom"] . ')' . ' ' . ' FUE ACTUALIZADO';
			//Guardamos la auditoria en la tabla
			$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
			
			/// SI NO SELECCIONO NINGUNO , ENTONCES ELIMINAMOS LOS REGISTROS DE LA TABLA sgc_via_tipo_atencion
			if (empty($selectedValues))
			{
				//VERIFICO SI TIENE HIJOS ASOCIADAS
				$query_hijos_Asociados=$model_via_atencion->hijos_Asociadas($ViaAtencionId);
				if (empty($query_hijos_Asociados)) 
				{
					$mensaje = 2;
				}else
				{
					$query_actualizar_Hijos_existentes=$model_via_atencion->Eliminar_hijos_Asociadas($deletedElements,$ViaAtencionId);		
					$mensaje = 1;
				}
				return json_encode($mensaje);
				
			} else 

				// SI HAY REGISTROS SELECCIONADOS ENTONCES RECORREMOS ($selectedValues) 
				{
					$results = [];
					$datos2 = array();
					foreach ($selectedValues as $tipo_atencion_id) {
						$combinacion = array(
							'via_atencion_id' => $ViaAtencionId,
							'tipo_atencion_id' => $tipo_atencion_id
						);
						$datos2[] = $combinacion;
					}

					// BUSCAMOS SI YA EXISTE ESA TIPO DE ATENCION PARA ESTA VIA DE ATENCION 
					$query_hijos_existentes = $model_via_atencion->hijos_existentes($datos2);
					$hijos_a_activar = []; // Inicializamos el array para almacenar los hijos a activar
					$tipos_existentes = []; // Para almacenar los tipos de atención existentes

					foreach ($query_hijos_existentes as $existentes) {
						$tipos_existentes[] = $existentes->tipo_atencion_id; // Guardamos el tipo de atención existente
						$borrado = $existentes->borrado;
						if ($borrado === 't') {
							// Si está borrado, lo agregamos a la lista de hijos a activar
							$hijos_a_activar[] = [
								'via_atencion_id' => $existentes->via_atencion_id,
								'tipo_atencion_id' => $existentes->tipo_atencion_id,
							];
						}
					}

					// Activamos los hijos asociados si hay alguno que activar
					if (!empty($hijos_a_activar)) {
						$model_via_atencion->Activar_hijos_Asociadas($hijos_a_activar);
					}

					// Ahora, verificamos si hay registros nuevos para insertar
					foreach ($datos2 as $nuevo_dato) {
						// Solo insertamos si no existe en los tipos existentes
						if (!in_array($nuevo_dato['tipo_atencion_id'], $tipos_existentes)) {
							$results[] = $model_via_atencion->agregar([$nuevo_dato]);
						}
					}

					// Si hay elementos eliminados, los eliminamos
					if (!empty($deletedElements)) {
						$model_via_atencion->Eliminar_hijos_Asociadas($deletedElements, $ViaAtencionId);
					}

					$mensaje = 1;
					return json_encode($mensaje);
				}
								
		}		
				

	} else {
		return redirect()->to('/');
	}
}


public function buscar_hijos_via_atencion($id_Via_Atencion=null)
	{
		
	
		$model = new Red_Social_Model();
		$query = $model->buscar_hijos_via_atencion($id_Via_Atencion);
		
		if (empty($query)) {
			$hijos_red_social = [];
		} else {
			$hijos_red_social = $query;
		}
		return $this->response->setJSON($hijos_red_social);
	}
	
}
