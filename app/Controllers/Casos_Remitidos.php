<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Casos;
use App\Models\PropiedadIntelectual;
use App\Models\Oficinas;
use App\Models\Estatus;
use App\Models\RequerimientoUsuario;
use App\Models\Auditoria_sistema_Model;
use App\Models\Ubi_Admini_Model;
use App\Models\Seguimientos;
use App\Models\Casos_remitidos_Model;
use App\Models\Registro_cgr_Model;
use App\Models\Casos_denuncias_Model;
use App\Models\Documentos_casos_Model;
use App\Models\NizaClasses;
require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use VARIANT;

class Casos_Remitidos extends BaseController
{





	//Metodo que muestra la vista de los casos
	public function vista_casos_remitidos()
	{
		
		$id_direccion = (session('id_direccion_administrativa'));

		$casoModel = new Documentos_casos_Model();
		if ($this->session->get('logged')) {
			$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->buscar_correo($id_direccion);
			
			foreach ($query->getResult() as $row) 
			{
				$direccion=$row->descripcion;	
			}
			$data["mensaje"] = '';
			$data["direccion"] = $direccion;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos_remitidos/content', $data);
			echo view('template/footer');
			//echo view('administrador/usuarios/footer.php');
			echo view('/casos_remitidos/footer_casos.php');
		} else {
			return redirect()->to('/');
		}
	}
	


	//Vista de carga de un caso
	public function vercaso($id)
	{
		$casoModel = new Casos();
		$segModel = new Seguimientos();
		$estModel = new Estatus();
		$direccionesModel = new Ubi_Admini_Model();
		//Arreglo para los detalles del caso
		$data = array();
		//TimeLine para los seguimientos
		$tlSeguimientos = '';
		//estatus del caso
		$idEstatusCaso = '';
		if ($this->session->get('logged')) {
			//Consultamos los detalles del caso
			$query = $casoModel->detalleCaso($id);
			if (isset($query)) {
				foreach ($query as $row) {
					$data["idcaso"] = $id;
					$data["nombre"] = ucwords(strtolower($row->casonom) . ' ' . strtolower($row->casoape));
					$data["estado"] = ucfirst(strtolower($row->estadonom));
					$data["municipio"] = ucfirst(strtolower($row->municipionom));
					$data["parroquia"] = ucfirst(strtolower($row->parroquianom));
					$data["casodesc"] = ucfirst(strtolower($row->casodesc));
					$data["correo"] = ucfirst(strtolower($row->correo));
					$data["fecha_caso"] = $row->casofec;
					$data["usuario_operador"] = $row->user_name;
					$data["unidad_administrativa"] = $row->unidad_administrativa;
					$data["direccion"] = $row->direccion;
					$data["correo_beneficiario"] = $row->correo;
					//$idEstatusCaso = $row->idest;
				}
				//Obtenemos los estatus de las llamadas para el select del seguimiento
				unset($query);
				$query = $estModel->estatusLlamadas();
				$estopt = '';
				if (isset($query)) {
					foreach ($query->getResult() as $row) {
						$estopt .= '<option value="' . $row->idestllam . '">' . ucfirst(strtolower($row->estllamnom)) . '</option>';
					}
				} else {
					$estopt .= '<option value="NULL">Sin estatus</option>';
				}
				$data["estatus"] = $estopt;
				//Obtenemos los estatus de los casos para mostrarlos en el modal
				unset($query);
				$estopt = '';
				$query = $estModel->estatusCaso();
				if (isset($query)) {
					foreach ($query->getResult() as $row) {
						if ($row->idest == $idEstatusCaso) {
							$estopt .= '<option selected value="' . $row->idest . '">' . ucfirst(strtolower($row->estnom)) . '</option>';
						} else {
							$estopt .= '<option value="' . $row->idest . '">' . ucfirst(strtolower($row->estnom)) . '</option>';
						}
					}
				} else {
					$estopt .= '<option value="NULL">Sin estatus</option>';
				}
				$data["estatus_llamadas"] = $estopt;
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('casos/ver_caso/content.php', $data);
				echo view('template/footer');
				echo view('casos/ver_caso/footer.php');
			} else {
				return redirect()->to('/404');
			}
		} else {
			return redirect()->to('/');
		}
	}

	

	//Metodo queo obtiene  los todos los casos disponibles
	public function listar_Casos_Remitidos()

	{
		$id_direccion = (session('id_direccion_administrativa'));
		
		
		$model = new Casos();
		$query = $model->listar_Casos_Remitidos($id_direccion);	
		
		if (empty($query)) {
				$casos_remitidos = [];
		} else {
				$casos_remitidos = $query;
		}
		echo json_encode($casos_remitidos);
		
		
	}

	




public function buscar_datos_usuarios()
{
	$casoModel = new Casos();
	if ($this->session->get('logged') and $this->request->isAJAX()) {
		//Obtenemos los datos del formulario
		$data = json_decode(base64_decode($this->request->getPost('data')));
		$datos['usuario']   = $data->cedula_existente;
		$query_buscar_usuario = $casoModel->buscar_usuario($datos);
		if (empty($query_buscar_usuario->getResult())) {
			$data = 0;
			return json_encode($data);
		} else {
			$usuarios = $query_buscar_usuario->getResultArray();
		}
		echo json_encode($usuarios);
		
	} else {
		return redirect()->to('/');
	}
}


// 
}

