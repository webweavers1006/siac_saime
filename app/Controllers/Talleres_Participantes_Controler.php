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





//Metodo queo obtiene  los todos los casos disponibles
public function listar_talleres_participantes($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0,$id_estado = 0,$id_municipio = 0,$id_parroquia = 0,$edad_min=null,$edad_max=null,$detalle_atencion=0,$org_id=0)
{
	
	$model = new Talleres_Participantes_Model();
	$query = $model->listar_talleres_participantes($desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, $via_atencion, $direcciones_caso, $tipo_beneficiario, $atencion_cuidadano, $estatus,$id_estado,$id_municipio,$id_parroquia,$edad_min,$edad_max,$detalle_atencion,$org_id);
	if (empty($query)) {
		$participantes = [];
	} else {
		$participantes = $query;
	}
	echo json_encode($participantes);
}



	



}
