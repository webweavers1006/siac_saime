<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Ubi_Admini_Model;
use App\Models\Casos;
use App\Models\Talleres_Participantes_Model;
use CodeIgniter\RESTful\ResourceController;

class Talleres_Participantes_Controler extends BaseController
{
	use ResponseTrait;




//Metodo que muestra la vista de los tipos de direcciones
public function Talleres_Participantes()
{
	if ($this->session->get('logged')) {

		$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->listar_Ubicacion_Administrativa();
		
			$direccionesopt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
				}
			} else {
				$direccionesopt .= '<option value="NULL">Sin estatus</option>';
			}
		$data["direcciones"] = $direccionesopt;
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('reportes/talleres_participantes/content.php',$data);
		echo view('template/footer');
		echo view('reportes/talleres_participantes/footer.php');
	} else {
		return redirect()->to('/');
	}
}



// Metodo que obtiene todos los casos disponibles
public function listar_talleres_participantes(
    $desde = null, 
    $hasta = null, 
    $tipo_pi = null, 
    $tipo_atencion_usu = null, 
    $sexo = null, 
    $via_atencion = null, 
    $direcciones_caso = null, 
    $tipo_beneficiario = 0, 
    $atencion_cuidadano = 0, 
    $estatus = 0,
    $id_estado = 0,
    $id_municipio = 0,
    $id_parroquia = 0,
    $edad_min = null,
    $edad_max = null,
    $detalle_atencion = 0,
    $org_id = 0,
    $operador = 0
) {
    // 1. Normalizar cadenas y fechas
    $desde             = ($desde === 'null' || $desde === '') ? null : $desde;
    $hasta             = ($hasta === 'null' || $hasta === '') ? null : $hasta;
    $sexo              = ($sexo === 'null' || $sexo === '' || $sexo === '0' || $sexo == 0) ? null : $sexo;
    $direcciones_caso  = ($direcciones_caso === 'null' || $direcciones_caso === '' || $direcciones_caso === '0' || $direcciones_caso == 0) ? null : $direcciones_caso;
    $edad_min          = ($edad_min === 'null' || $edad_min === '') ? null : (int)$edad_min;
    $edad_max          = ($edad_max === 'null' || $edad_max === '') ? null : (int)$edad_max;

    // 2. Normalizar IDs y selectores numéricos (Si vienen en 0, '' o 'null', pasan a ser NULL real)
    $tipo_pi           = ($tipo_pi === 'null' || $tipo_pi === '' || $tipo_pi == 0 || $tipo_pi === '0') ? null : (int)$tipo_pi;
    $tipo_atencion_usu = ($tipo_atencion_usu === 'null' || $tipo_atencion_usu === '' || $tipo_atencion_usu == 0 || $tipo_atencion_usu === '0') ? null : (int)$tipo_atencion_usu;
    $via_atencion      = ($via_atencion === 'null' || $via_atencion === '' || $via_atencion == 0 || $via_atencion === '0') ? null : (int)$via_atencion;
    $tipo_beneficiario  = ($tipo_beneficiario === 'null' || $tipo_beneficiario === '' || $tipo_beneficiario == 0 || $tipo_beneficiario === '0') ? null : (int)$tipo_beneficiario;
    $atencion_cuidadano = ($atencion_cuidadano === 'null' || $atencion_cuidadano === '' || $atencion_cuidadano == 0 || $atencion_cuidadano === '0') ? null : (int)$atencion_cuidadano;
    $estatus            = ($estatus === 'null' || $estatus === '' || $estatus == 0 || $estatus === '0') ? null : (int)$estatus;
    $id_estado          = ($id_estado === 'null' || $id_estado === '' || $id_estado == 0 || $id_estado === '0') ? null : (int)$id_estado;
    $id_municipio       = ($id_municipio === 'null' || $id_municipio === '' || $id_municipio == 0 || $id_municipio === '0') ? null : (int)$id_municipio;
    $id_parroquia       = ($id_parroquia === 'null' || $id_parroquia === '' || $id_parroquia == 0 || $id_parroquia === '0') ? null : (int)$id_parroquia;
    $detalle_atencion   = ($detalle_atencion === 'null' || $detalle_atencion === '' || $detalle_atencion == 0 || $detalle_atencion === '0') ? null : (int)$detalle_atencion;
    $org_id             = ($org_id === 'null' || $org_id === '' || $org_id == 0 || $org_id === '0') ? null : (int)$org_id;
    $operador           = ($operador === 'null' || $operador === '' || $operador == 0 || $operador === '0') ? null : (int)$operador;

    // 3. Instanciar modelo y ejecutar consulta
    $model = new Talleres_Participantes_Model();
    $query = $model->listar_talleres_participantes(
        $desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, 
        $via_atencion, $direcciones_caso, $tipo_beneficiario, 
        $atencion_cuidadano, $estatus, $id_estado, $id_municipio, 
        $id_parroquia, $edad_min, $edad_max, $detalle_atencion, 
        $org_id, $operador
    );

    $participantes = is_array($query) ? $query : [];

    // 4. Retornar respuesta en formato JSON
    return $this->response->setJSON($participantes);
}

	



}
