<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Tipo_Atencion_Usu_Model;
use CodeIgniter\RESTful\ResourceController;

class Tipo_Atencion_Usu_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_tipo_atencion()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('tipo_de_atencion/content.php');
			echo view('template/footer');
			echo view('tipo_de_atencion/footer_atencion.php');
		} else {
			return redirect()->to('/');
		}
	}

	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
    */
	public function Listar_Tipo_Atencion()
	{
		$model = new Tipo_Atencion_Usu_Model();
		$query = $model->Listar_Tipo_Atencion_edit();
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		echo json_encode($atencion);
	}

	/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION ACTIVOS
    */
	public function Listar_Tipo_Atencion_filtro()
	{
		$model = new Tipo_Atencion_Usu_Model();
		$query = $model->Listar_Tipo_Atencion_filtro();
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		echo json_encode($atencion);
	}

/*
       FUNCION PARA OBTENER LOS TIPOS DE ATENCION ACTIVOS Y SIN FORMACION
    */
	public function Listar_Tipo_Atencion_Sin_Formacion()
	{
		$model = new Tipo_Atencion_Usu_Model();
		$query = $model->Listar_Tipo_Atencion_Sin_Formacion();
		if (empty($query)) {
			$atencion = [];
		} else {
			$atencion = $query;
		}
		echo json_encode($atencion);
	}



	//Metodo para añadir tipo de atencion
	public function add_Tipo_Atencion()
	{
		$model = new Tipo_Atencion_Usu_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$atencion["tipo_aten_nombre"]     = $datos["descripcion"];
			$atencion["act_pro_int"]     = $datos["act_pro_int"];
			$atencion["acc_participantes"]     = $datos["acc_participantes"];
			$atencion["env_correo"]     = $datos["env_correo"];
			$atencion["organismo_pp"]     = $datos["organismo_pp"];
			//Realizamos la insercion en la tabla
			$query_insertar_atencion = $model->add_Atencion($atencion);
			if (isset($query_insertar_atencion)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'INGRESO EL TIPO DE ATENCION : ' . '(' . ' ' . $atencion["tipo_aten_nombre"] . ' ' . ')';
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

	//Metodo para ACTUALIZAR ATENCIONES
	public function editTipoAtencion()
	{
		$model = new Tipo_Atencion_Usu_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales de las Direccion
			$atencion["tipo_aten_nombre"]     = $datos["descripcion"];
			$atencion["tipo_aten_borrado"]     = $datos["borrado"];
			$atencion["tipo_aten_id"]     = $datos["id_atencion"];
			$atencion["act_pro_int"]     = $datos["act_pro_int"];
			$atencion["acc_participantes"]     = $datos["acc_participantes"];
			$atencion["env_correo"]     = $datos["env_correo"];
			$atencion["organismo_pp"]     = $datos["organismo_pp"];
			//Realizamos la actualizacion en la tabla
			$query_editar_atencion = $model->editTipoAtencion($atencion);
			if (isset($query_editar_atencion)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = ' EL TIPO DE ATENCION :' . ' ' . '(' . ' ' . $atencion["tipo_aten_nombre"] . ')' . ' ' . ' FUE ACTUALIZADO';
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
