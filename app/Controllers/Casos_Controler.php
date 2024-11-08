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

class Casos_Controler extends BaseController
{


	public function pruebacasos()
	{
		
		$casoModel = new Documentos_casos_Model();
		if ($this->session->get('logged')) {
			
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/pruebacasos');
			echo view('template/footer');
			//echo view('administrador/usuarios/footer.php');
			echo view('/casos/footer_casos.php');
		} else {
			return redirect()->to('/');
		}
	}



	//Metodo que muestra la vista de los casos
	public function casos()
	{
		
		$casoModel = new Documentos_casos_Model();
		if ($this->session->get('logged')) {
			$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->listar_direcciones_administrativas();
			$direccionesopt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
				}
			} else {
				$direccionesopt .= '<option value="NULL">Sin estatus</option>';
			}
			$data["mensaje"] = '';
			$data["direcciones"] = $direccionesopt;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/content', $data);
			echo view('template/footer');
			//echo view('administrador/usuarios/footer.php');
			echo view('/casos/footer_casos.php');
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo que muestra la vista de agregar casos
	public function vista_Agregar_caso()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/agregar_caso');
			echo view('template/footer');
			echo view('casos/footer_agregar_caso');
		} else {
			return redirect()->to('/');
		}
	}



//Metodo queo obtiene  la informacion de los usuarios para le web 
public function Informacion_Usuarios($casoced=null)

{
	

	$casoModel = new Casos();
	$token=$this->request->getServer('HTTP_AUTHORIZATION');

	$casoModel = new Casos();
	$token=$this->request->getServer('HTTP_AUTHORIZATION');

	$ch = curl_init("https://siac.sapi.gob.ve/api/audiencia/auth/token/verificacion");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: ' . $token
	));

	$response = curl_exec($ch);

	// Verificar si hubo un error en la ejecución de cURL
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		// Obtener el código de estado HTTP
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//echo 'Código de estado HTTP: ' . $httpCode . PHP_EOL;

		// Decodificar la respuesta JSON
		$datos = json_decode($response, true);

		// Comprobar si el código de estado HTTP es 200
		if ($httpCode === 200) {
			// Comprobar si la verificación fue exitosa
			if (isset($datos['verificacion']) && $datos['verificacion'] === true) {
				// El token es válido, proceder a obtener la información del usuario
				$query = $casoModel->Informacion_Usuarios($casoced);
				
				if (empty($query)) {
					$casos = [];
				} else {
					$casos = $query;
				}
				echo json_encode($casos);
			} else {
				// Mostrar mensaje de no autorizado
				echo 'No Autorizado.';
			}
		} else {
			// Mostrar mensaje de error según el código de estado
			echo 'No Autorizado.';
		}
	}

curl_close($ch);
	
	// 	
	
		
}




	//Metodo para generar un nuevo caso
	public function nuevoCaso()
	{
		$casoModel = new Casos();
		$tipoPIModel = new PropiedadIntelectual();
		$oficina = new Oficinas();
		$reqModel = new RequerimientoUsuario();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		$segModel = new Seguimientos();
		$Registro_cgr_Model = new Registro_cgr_Model();
		$Casos_denuncias = new Casos_denuncias_Model();
		//Arreglo para añadir el nuevo caso
		$newCase = array();

		$casos_existentes = array();
		//Arreglo de direccion de casos
		$dirCaso = array();
		//Arreglo con el tipo de propiedad intelectual
		$tipoPI = array();
		$datosSeguimiento = array();
		//Arreglo para el requerimiento del usuario
		$reqUsuario = array();
		//OJO
		$token=$this->request->getServer('HTTP_AUTHORIZATION');
		$buscar_token = $casoModel->buscar_token($token);
		if (($this->session->get('logged') and $this->request->isAJAX())||!empty($buscar_token)) {
			$newCase["idusuopr"]    = empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
			//Obtenemos los datos del formulario
			$datos = empty($buscar_token)?json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE):$this->request->getPost('data');
			//llenamos los datos iniciales del caso
			$newCase["casofec"]     = $datos["date-entry"];
			$newCase["casoced"]     = $datos["person-id"];
			$newCase["caso_nacionalidad"]     = $datos["nacionalidad"];
			$newCase["casonom"] = strtoupper($datos["person-name"]);
			$newCase["casoape"] = strtoupper($datos["person-lastname"]);
			$newCase["casotel"]     = $datos["telephone"];
			$newCase["idest"]       = 1;
			$newCase["idrrss"]      = $datos["social_network"];
			$newCase["idusuopr"]    = empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
			$newCase["estadoid"]    = $datos["state"];
			$newCase["municipioid"] = $datos["county"];
			$newCase["sexo"] = $datos["sexo"];
			$newCase["parroquiaid"] = $datos["town"];
			$newCase["ofiid"]       = $datos["office"];
			$newCase["casodesc"]    = $datos["user-requirement"];
			$newCase["id_tipo_atencion"]    = $datos["tipo-atencion-usu"];
			$newCase["tipo_beneficiario"]    = $datos["tipo_beneficiario"];
			$newCase["direccion"]    = $datos["direccion"];
			$newCase["correo"]    = $datos["correo"];
			$newCase["ente_adscrito_id"]    = $datos["ente_adscrito"];
			$newCase["edad"]    = $datos["edad"];
			$newCase["fecha_nacimiento"]    = $datos["fecha_nacimiento"];
			$casos_existentes["fecha_nacimiento"]    = $datos["fecha_nacimiento"];
			$casos_existentes["casoced"]     = $datos["person-id"];
			$casos_existentes["profesion"]     = $datos["profesion"];
			$casos_existentes["edad"]     = $datos["edad"];
			$newCase["profesion"]    = $datos["profesion"];
			$bandera_cgr["bandera_cgr"]    = $datos["bandera_cgr"];
			$bandera_denuncia["bandera_denuncia"]    = $datos["bandera_denuncia"];
			$pi_type = $datos["pi-type"];
			if (empty($datos["record-work"])) {
				$newCase["casonumsol"] = 'No Aplica';
			} else {
				$newCase["casonumsol"] = $datos["record-work"];
			}

			//VERIFICO SI EXISTEN CASOS ANTERIOSRES EN FUNCION DE LA CEDULA , PARA ACTUALIZAR LA FECHA DE NACIMIENTO Y LA PROFECION
			$query_BuscarCasosExistentes= $casoModel->BuscarCasosExistentes($casos_existentes);
			if ($query_BuscarCasosExistentes)
			{
				//ACTUALIZO LA FECHA DE VENCIMIENTO
				$query_ActualizarFechaNacimiento= $casoModel->ActualizarFechaNacimiento($casos_existentes);
			}

				$query_insertar_caso = $casoModel->insertarNuevoCaso($newCase);
				if (isset($query_insertar_caso)) {
					//Obtenemos el id insertado
					$_obtener_utimo_id = $casoModel->obtener_utimo_id();
					//Armamos el arreglo para insertar el tipo de propiedad intelectual del caso
					if (empty($_obtener_utimo_id->getResult())) {
						$tipoPI[] = '0';
					} else {
						foreach ($_obtener_utimo_id->getResult() as $fila) {
							$tipoPI['idcaso']      = $fila->ultimo_id;
							$tipoPI['idtippropint']  = $pi_type;
						}
					}

					//HACEMOS EL INSERT DE CREACION EN EL SEGUIMIENTO DEL CASO
					$datosSeguimiento['idcaso']      = $tipoPI['idcaso'];
					$datosSeguimiento['idestllam']    = 4;
					$datosSeguimiento['segcoment']    = 'CREACIÓN DEL CASO';
					$datosSeguimiento['idusuopr']    = 	empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
					$datosSeguimiento['segfec']    = 	date('Y-m-d');
					//Hacemos la insercion
					$query_Inset_seguimientos = $segModel->insertarSeguimiento($datosSeguimiento);
					//$repuesta[] = '0';
					//VERIFICAMOS SI ES UN  CASO DE ASESORIA PARA HACER LA INSERCION
					if ($bandera_cgr["bandera_cgr"] == 'true') 
					{
						$cgr['competencia_cgr']  = $datos["competencia_crg"];
						$cgr['asume_cgr']      = $datos["asume_crg"];
						$cgr['id_caso']      = $tipoPI['idcaso'];
						$idcaso=$tipoPI['idcaso'];
						//Verificamos si ya existe si existe el id del caso antes de hacer el insert 
						$query_verificacion_cgr_Model = $Registro_cgr_Model->verificar_id_caso_CGR($idcaso);
						if (empty($query_verificacion_cgr_Model))
						{
							//Hacemos la insercion
							$query_Registro_cgr_Model = $Registro_cgr_Model->insertarRegistro_cgr($cgr);

							//verificacion que se hiso la insercion del cgr
							if (isset($query_Registro_cgr_Model)) 
							{
								//si se hiso la insercion del cgr , hacemos la insercion en el  tipo de propiedad intelectual para el  caso
								$query_tipopimodel = $tipoPIModel->insertarTipoPICaso($tipoPI);
								if (isset($query_tipopimodel)) {
									$repuesta['mensaje']      = 1;
									$repuesta['idcaso']  = $fila->ultimo_id;
									$auditoria['audi_user_id']   = empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
									$auditoria['audi_accion']   = 'INGRESO UN NUEVO CASO Nª' . $tipoPI['idcaso'];
									$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
									return json_encode($repuesta);
								} else {
									$repuesta['mensaje'] = 2;
									return json_encode($repuesta);
								}
							}
						}else
						{
							$repuesta['mensaje'] = 7;
							return json_encode($repuesta);

						}
						
							
						
					}
					//VERIFICAMOS SI ES UN  CASO ES DE DENUNCIA PARA HACER LA INSERCION
					if ($bandera_denuncia["bandera_denuncia"]  == 'true') 
					{
						$denuncia['denu_afecta_persona']  = $datos["option_personal"];
						$denuncia['denu_afecta_comunidad']      = $datos["option_comunidad"];
						$denuncia['denu_afecta_terceros']  = $datos["option_terceros"];
						$denuncia['denu_fecha_hechos']      = $datos["fecha_hechos"];
						$denuncia['denu_involucrados']  = $datos["denu_involucrados"];
						$denuncia['denu_instancia_popular']      = $datos["nombre_instancia"];
						$denuncia['denu_rif_instancia']  = $datos["rif_instancia"];
						$denuncia['denu_ente_financiador']      = $datos["ente_financiador"];
						$denuncia['denu_nombre_proyecto']  = $datos["nombre_proyecto"];
						$denuncia['denu_monto_aprovado']      = $datos["monto_aprovado"];
						$denuncia['denu_id_caso']      = $tipoPI['idcaso'];
						//Hacemos la insercion
						$query_Casos_denuncias = $Casos_denuncias->insertarCasos_Denuncias($denuncia);
						//verificacion que se hiso la insercion de los casos de denuncias
						if (isset($query_Casos_denuncias)) {
							//si se hiso la insercion del cgr , hacemos la insercion en el  tipo de propiedad intelectual para el  caso
							$query_tipopimodel = $tipoPIModel->insertarTipoPICaso($tipoPI);
							if (isset($query_tipopimodel)) {
								$repuesta['mensaje']      = 1;
								$repuesta['idcaso']  = $fila->ultimo_id;
								$auditoria['audi_user_id']   = empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
								$auditoria['audi_accion']   = 'INGRESO UN NUEVO CASO Nª' . $tipoPI['idcaso'];
								$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
								return json_encode($repuesta);
							} else {
								$repuesta['mensaje'] = 2;
								return json_encode($repuesta);
							}
						}
					} else
					{
						$query_TipoPICaso = $tipoPIModel->insertarTipoPICaso($tipoPI);
						if (isset($query_TipoPICaso)) {
							$repuesta['mensaje']      = 1;
							$repuesta['idcaso']  = $fila->ultimo_id;
							$auditoria['audi_user_id']   = empty($buscar_token)?$this->session->get('iduser'):$buscar_token[0]->id_usuario;
							$auditoria['audi_accion']   = 'INGRESO UN NUEVO CASO Nª' . $tipoPI['idcaso'];
							$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
							return json_encode($repuesta);
						} else {
							$repuesta['mensaje'] = 2;
							return json_encode($repuesta);
						}
					}
				}
		
		} else {

			return redirect()->to('/');
		}
	}
	//Metodo para ElIMINAR  UN CASO 
	public function eliminar_Caso()
	{
		$casoModel = new Casos();
		$tipoPIModel = new PropiedadIntelectual();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		$oficina = new Oficinas();
		$reqModel = new RequerimientoUsuario();
		$segModel = new Seguimientos();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales del caso
			$newCase["idcaso"]    = $datos["idcaso"];
			$newCase["borrado"]    = $datos["borrado"];
			//Realizamos la actualizacion en la tabla
			$query_actualizar_caso = $casoModel->actualizarCaso($newCase);
			if (isset($query_actualizar_caso)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'ElIMINO EL CASO 	Nª' . $datos["idcaso"];
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

	//Metodo para ACTUALIZAR UN CASO 
	public function actualizarCaso()
	{
		$casoModel = new Casos();
		$tipoPIModel = new PropiedadIntelectual();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		$oficina = new Oficinas();
		$reqModel = new RequerimientoUsuario();
		$segModel = new Seguimientos();
		$Registro_cgr_Model = new Registro_cgr_Model();
		$Casos_denuncias = new Casos_denuncias_Model();
		//Arreglo para añadir el nuevo caso
		$newCase = array();
		$denuncia = array();
		//Arreglo de direccion de casos
		$dirCaso = array();
		//Arreglo con el tipo de propiedad intelectual
		$tipoPI = array();
		//Arreglo para el requerimiento del usuario
		$reqUsuario = array();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			$newCase["id_tipo_atencion"]    = $datos["tipo-atencion-usu"];
			$tipoPI["idtippropint"]    = $datos["pi-type"];
			$tipoPI["idcaso"]    = $datos["idcaso"];
			//llenamos los datos iniciales del caso
			if ($newCase["id_tipo_atencion"] !== 5 && $newCase["id_tipo_atencion"] !== 1) {
				$newCase["idcaso"]    = $datos["idcaso"];
				$newCase["casofec"]     = $datos["date-entry"];
				$newCase["casoced"]     = $datos["person-id"];
				$newCase["caso_nacionalidad"]     = $datos["nacionalidad"];
				$newCase["casonom"]     = $datos["person-name"];
				$newCase["casoape"]     = $datos["person-lastname"];
				$newCase["casotel"]     = $datos["telephone"];
				$newCase["idest"]       = 1;
				$newCase["idrrss"]      = $datos["social_network"];
				$newCase["idusuopr"]    = $this->session->get('iduser');
				$newCase["estadoid"]    = $datos["state"];
				$newCase["municipioid"] = $datos["county"];
				$newCase["sexo"] = $datos["sexo"];
				$newCase["parroquiaid"] = $datos["town"];
				$newCase["ofiid"]       = $datos["office"];
				$newCase["casodesc"]    = $datos["user-requirement"];
				$newCase["id_tipo_atencion"]    = $datos["tipo-atencion-usu"];
				$newCase["tipo_beneficiario"]    = $datos["tipo_beneficiario"];
				$newCase["direccion"]    = $datos["direccion"];
				$newCase["correo"]    = $datos["correo"];
				$newCase["ente_adscrito_id"]    = $datos["ente_adscrito_id"];
				$newCase["edad"]    = $datos["edad"];
				$newCase["fecha_nacimiento"]    = $datos["fecha_nacimiento"];
				$newCase["profesion"]    = $datos["profesion"];
				//$newCase["campos_modificados"]    = $datos["campos_modificados"];
				if (empty($datos["record-work"])) {
					$newCase["casonumsol"] = 'No Aplica';
				} else {
					$newCase["casonumsol"] = $datos["record-work"];
				}
				//REALIZAMOS LA ACTUALIZACION EN LA TABLA
				$query_actualizar_caso = $casoModel->actualizarCaso($newCase);

				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'LOS SIGUIENTES CAMPOS  DE EL CASO 	Nª' . $datos["idcaso"] . ' ' . 'FUERON MODIFICADOS  :' . ' ' . $datos["campos_modificados"];
				$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
			} else if ($newCase["id_tipo_atencion"] == 5) {
				//SI ES UNA DENUNCIA ARMAMOS EL ARRAY 
				$denuncia["denu_afecta_persona"]    = $datos["denu_afecta_persona"];
				$denuncia["denu_afecta_comunidad"]    = $datos["denu_afecta_comunidad"];
				$denuncia["denu_afecta_terceros"]    = $datos["denu_afecta_terceros"];
				$denuncia["denu_fecha_hechos"]    = $datos["denu_fecha_hechos"];
				$denuncia["denu_involucrados"]    = $datos["denu_involucrados"];
				$denuncia['denu_instancia_popular']      = $datos["denu_instancia_popular"];
				$denuncia["denu_rif_instancia"]    = $datos["denu_rif_instancia"];
				$denuncia['denu_ente_financiador']      = $datos["denu_ente_financiador"];
				$denuncia["denu_nombre_proyecto"]    = $datos["denu_nombre_proyecto"];
				$denuncia["denu_monto_aprovado"]    = $datos["denu_monto_aprovado"];
				$denuncia['denu_id_caso']      = $tipoPI['idcaso'];
				$denuncia["denu_borrado"]    = false;
				$idcaso = $tipoPI['idcaso'];
				//BUSCAMOS EL ID EN LA TABLA DE DENUNCIAS , SI NO EXISTE PROCEDEMOS CON EL INSERT
				$query_buscarid_denuncia = $Casos_denuncias->verificar_id_caso_denuncia($idcaso);
				if (empty($query_buscarid_denuncia)) {
					$query_Casos_denuncias = $Casos_denuncias->insertarCasos_Denuncias($denuncia);
					$newCase["idcaso"]    = $datos["idcaso"];
					$newCase["casofec"]     = $datos["date-entry"];
					$newCase["casoced"]     = $datos["person-id"];
					$newCase["caso_nacionalidad"]     = $datos["nacionalidad"];
					$newCase["casonom"]     = $datos["person-name"];
					$newCase["casoape"]     = $datos["person-lastname"];
					$newCase["casotel"]     = $datos["telephone"];
					$newCase["idest"]       = 1;
					$newCase["idrrss"]      = $datos["social_network"];
					$newCase["idusuopr"]    = $this->session->get('iduser');
					$newCase["estadoid"]    = $datos["state"];
					$newCase["municipioid"] = $datos["county"];
					$newCase["sexo"] = $datos["sexo"];
					$newCase["parroquiaid"] = $datos["town"];
					$newCase["ofiid"]       = $datos["office"];
					$newCase["casodesc"]    = $datos["user-requirement"];
					$newCase["id_tipo_atencion"]    = $datos["tipo-atencion-usu"];
					$newCase["tipo_beneficiario"]    = $datos["tipo_beneficiario"];
					$newCase["direccion"]    = $datos["direccion"];
					$newCase["correo"]    = $datos["correo"];
					$newCase["ente_adscrito_id"]    = $datos["ente_adscrito_id"];
					$newCase["edad"]    = $datos["edad"];
					$newCase["fecha_nacimiento"]    = $datos["fecha_nacimiento"];
					$newCase["profesion"]    = $datos["profesion"];
					//$newCase["campos_modificados"]    = $datos["campos_modificados"];
					if (empty($datos["record-work"])) {
						$newCase["casonumsol"] = 'No Aplica';
					} else {
						$newCase["casonumsol"] = $datos["record-work"];
					}
					//REALIZAMOS LA ACTUALIZACION EN LA TABLA
					$query_actualizar_caso = $casoModel->actualizarCaso($newCase);
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'REGISTRO EN LA TABLA DE denunciaS EL CASO 	Nª' . $datos["idcaso"];
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				} else {
					$newCase["idcaso"]    = $datos["idcaso"];
					$newCase["casofec"]     = $datos["date-entry"];
					$newCase["casoced"]     = $datos["person-id"];
					$newCase["caso_nacionalidad"]     = $datos["nacionalidad"];
					$newCase["casonom"]     = $datos["person-name"];
					$newCase["casoape"]     = $datos["person-lastname"];
					$newCase["casotel"]     = $datos["telephone"];
					$newCase["idest"]       = 1;
					$newCase["idrrss"]      = $datos["social_network"];
					$newCase["idusuopr"]    = $this->session->get('iduser');
					$newCase["estadoid"]    = $datos["state"];
					$newCase["municipioid"] = $datos["county"];
					$newCase["sexo"] = $datos["sexo"];
					$newCase["parroquiaid"] = $datos["town"];
					$newCase["ofiid"]       = $datos["office"];
					$newCase["casodesc"]    = $datos["user-requirement"];
					$newCase["id_tipo_atencion"]    = $datos["tipo-atencion-usu"];
					$newCase["tipo_beneficiario"]    = $datos["tipo_beneficiario"];
					$newCase["direccion"]    = $datos["direccion"];
					$newCase["correo"]    = $datos["correo"];
					$newCase["ente_adscrito_id"]    = $datos["ente_adscrito_id"];
					$newCase["edad"]    = $datos["edad"];
					$newCase["fecha_nacimiento"]    = $datos["fecha_nacimiento"];
					$newCase["profesion"]    = $datos["profesion"];
					//$newCase["campos_modificados"]    = $datos["campos_modificados"];
					if (empty($datos["record-work"])) {
						$newCase["casonumsol"] = 'No Aplica';
					} else {
						$newCase["casonumsol"] = $datos["record-work"];
					}
					//REALIZAMOS LA ACTUALIZACION EN LA TABLA
					$query_actualizar_caso = $casoModel->actualizarCaso($newCase);
					// SI EXISTE EL REGISTRO HACEMOS UN UPDATE EN FUNSION DEL ID 
					$denuncia["denu_afecta_persona"]    = $datos["denu_afecta_persona"];
					$denuncia["denu_afecta_comunidad"]    = $datos["denu_afecta_comunidad"];
					$denuncia["denu_afecta_terceros"]    = $datos["denu_afecta_terceros"];
					$denuncia["denu_fecha_hechos"]    = $datos["denu_fecha_hechos"];
					$denuncia["denu_involucrados"]    = $datos["denu_involucrados"];
					$denuncia['denu_instancia_popular']      = $datos["denu_instancia_popular"];
					$denuncia["denu_rif_instancia"]    = $datos["denu_rif_instancia"];
					$denuncia['denu_ente_financiador']      = $datos["denu_ente_financiador"];
					$denuncia["denu_nombre_proyecto"]    = $datos["denu_nombre_proyecto"];
					$denuncia["denu_monto_aprovado"]    = $datos["denu_monto_aprovado"];
					$denuncia['denu_id_caso']      = $tipoPI['idcaso'];
					$denuncia["denu_borrado"]    = false;
					$query_actualizara_Casos_denuncias = $Casos_denuncias->AtualizarCasos_Denuncias($denuncia);
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'LOS SIGUIENTES CAMPOS  DE EL CASO 	Nª' . $datos["idcaso"] . ' ' . 'FUERON MODIFICADOS  :' . ' ' . $datos["campos_modificados"];
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				}
				//LUEGO BUSCAMOS EL ID DEL CASO  EN LA TABLA DE CRG PARA HACER EL BORRADO LOGICO SI EXISTE EL REGISTRO
				$query_buscarid_CGR = $Registro_cgr_Model->verificar_id_caso_CGR($idcaso);
				if (!empty($query_buscarid_CGR)) {
					$cgr["borrado_cgr"]    = true;
					$cgr['id_caso']      = $tipoPI['idcaso'];
					$query_buscarid_CGR = $Registro_cgr_Model->AtualizarCasos_cgr($cgr);
				}
				//SI ES UNA ASESORIA ARMAMOS EL ARRAY 
			} else if ($newCase["id_tipo_atencion"] == 1) {
				$idcaso = $tipoPI['idcaso'];
				//BUSCAMOS EL ID EN LA TABLA DE CRG , SI NO EXISTE PROCEDEMOS CON EL INSERT
				$query_buscarid_CGR = $Registro_cgr_Model->verificar_id_caso_CGR($idcaso);
				if (empty($query_buscarid_CGR)) {
					$cgr["competencia_cgr"]    = $datos["competencia_cgr"];
					$cgr["asume_cgr"]    = $datos["asume_cgr"];
					$cgr['id_caso']      = $tipoPI['idcaso'];
					$query_Registro_cgr_Model = $Registro_cgr_Model->insertarRegistro_cgr($cgr);
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'REGISTRO EN LA TABLA DE CGR EL CASO 	Nª' . $datos["idcaso"];
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				} else {
					// SI EXISTE EL REGISTRO HACEMOS UN UPDATE EN FUNSION DEL ID 
					$cgr["competencia_cgr"]    = $datos["competencia_cgr"];
					$cgr["asume_cgr"]    = $datos["asume_cgr"];
					$cgr["borrado_cgr"]    = false;
					$cgr['id_caso']      = $tipoPI['idcaso'];
					$query_actualizara_Casos_cgr = $Registro_cgr_Model->AtualizarCasos_cgr($cgr);
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'LOS SIGUIENTES CAMPOS DE EL CASO 	Nª' . $datos["idcaso"] . ' ' . 'FUERON MODIFICADOS  :' . ' ' . $datos["campos_modificados"];
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				}
				//LUEGO BUSCAMOS EL ID DEL CASO  EN LA TABLA DE DENUNCIAS PARA HACER EL BORRADO LOGICO SI EXISTE EL REGISTRO
				$query_buscarid_denuncia = $Casos_denuncias->verificar_id_caso_denuncia($idcaso);
				if (!empty($query_buscarid_denuncia)) {
					$denuncia["denu_borrado"]    = true;
					$denuncia['denu_id_caso']      = $tipoPI['idcaso'];
					$query_actualizar_denuncia = $Casos_denuncias->AtualizarCasos_Denuncias($denuncia);
				}
			}
			// // //Hacemos la la actualizacion 
			$query_tipopimodel = $tipoPIModel->ActualizarTipoPICaso($tipoPI);
			if (isset($query_tipopimodel)) {
				// $auditoria['audi_user_id']   = session('iduser');
				// $auditoria['audi_accion']   = 'ACTUALIZO EL CASO 	Nª' . $datos["idcaso"];
				// $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
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

	//Metodo para ACTUALIZAR UN CASO 
	public function remitirCaso()
	{

		$documentos_casos = new Documentos_casos_Model();
		// Obtener la fecha actual
		$segfec = date('Y-m-d');
		$casoModel = new Casos();
		$caso_remitido = new Casos_remitidos_Model();
		$seguimientos=new Seguimientos();
		$direcciones=new Ubi_Admini_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		//Arreglo para remitir un caso
		$remitirCase = array();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			//llenamos los datos iniciales del caso
			$remitirCase["casos_id"]    = $datos["id_caso"];
			$remitirCase["direccion_id"]     = $datos["direccion"];
			$nombre_direccion["nombre_direccion"]     = utf8_decode($datos["nombre_direccion"]);
			$remitirCase["idusuop"]    = $this->session->get('iduser');
			//verificamos si el caso habia sido remitido anteriormente  
			$buscar_caso_remitido = $caso_remitido->buscar_caso_remitido($datos["id_caso"]);
			//Si no a sido remitido hacemor un insert	
			if (empty($buscar_caso_remitido->getResult())) 
			{
				$repuesta[] = '0';
				$query_remitir_caso = $caso_remitido->remitirCaso($remitirCase);
				//Realizamos la Insercion en la tabla Auditoria 
				if (isset($query_remitir_caso)) 
				{
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'REMITIO EL CASO Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
					//Realizamos la insercion en la tabla de Seguimientos
					$datosSeguimiento['idcaso'] =$datos["id_caso"] ;
					$datosSeguimiento['idestllam'] ='4';
					$datosSeguimiento['segcoment']   = 'REMITIO EL CASO Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
					$datosSeguimiento['segfec'] =$segfec ;
					$datosSeguimiento['idusuopr']   = session('iduser');
					$seguimientos_caso = $seguimientos->insertarSeguimiento($datosSeguimiento);
					//BUSCAMOS LA DESCRIPCION DEL CASO 
					$buscar_descripcioncaso=$casoModel->buscar_correo($datos["id_caso"]);
					if(empty($buscar_descripcioncaso->getResult()))
					{
						echo('Esta vacio el correo');
						die();
					}
					else
					{
						foreach ($buscar_descripcioncaso->getResult() as $row) 
						{
						$desc_caso=utf8_decode($row->casodesc);	
						}
						//BUSCAMOS EL CORREO DE LA DIRECCION AL CUAL FUE REMITIDO EL CASO
						$buscar_correo=	$direcciones->buscar_correo($datos["direccion"]);
						//BUSCAMOS LOS ARCHIVOS ADJUNTOS AL CASO 
						$buscar_archivos=$documentos_casos->buscar_documentos($datos["id_caso"]);
						if (isset($buscar_correo)) 
						{
							foreach ($buscar_correo->getResult() as $row) 
							{
							$correo=$row->correo;	
							}
							if ($correo==NULL)
							{
								$repuesta['mensaje']      = 3;
								return json_encode($repuesta);
							}
							else 
							{
								//Enviamos un correo a la direccion Remitida 
								$mail = new PHPMailer();
								$dataEmail = array();

								$dataEmail["idcaso"]=$datos["id_caso"];
								$dataEmail["nombredireccion"]=$nombre_direccion["nombre_direccion"];
								$dataEmail["timestamp_generate"] = strtotime(date('Y-m-d H:i:s'));
								$dataEmail["timestamp_expire"] = strtotime("5 minutes", $dataEmail["timestamp_generate"]);
								$dataEmail["desc_caso"] = $desc_caso;
								//Codificamos el JSON y lo encriptamos
								$urlData = base64_encode(json_encode($dataEmail));
								$dataEmail["urldata"] = $urlData;
								$el_servidor  = "172.16.0.161";
								$el_puerto    = "587";
								$el_remitente = "adminsistemas@sapi.gob.ve";
								$el_pass      = "As.12345";
								try {
									$smtpOptions = array(
										'ssl' => array(
											'verify_peer' => false,
											'verify_peer_name' => false,
											'allow_self_signed' => true
										)
									);
								$correo=$correo;		
								$io_mail = new PHPMailer();
								$io_mail->isSMTP();
								$io_mail->Host = $el_servidor;
								$io_mail->Port = $el_puerto;
								$io_mail->SMTPAuth = true;
								$io_mail->Username = $el_remitente;
								$io_mail->Password = $el_pass;
								$io_mail->SMTPOptions = $smtpOptions;
								$io_mail->setFrom($el_remitente);
								$io_mail->AddAddress($correo); // Agrega la dirección de correo de destino
								$io_mail->FromName = "No Reply";
								$io_mail->Subject = utf8_decode("CASO Nª".' '.$datos["id_caso"].' '.' HA SIDO REMITIDO A SU DIRECCIÓN');
								$io_mail->Body = view('mail/recover', $dataEmail);
								$io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
								$archivos=array();										
								foreach ($buscar_archivos as $buscar_archivos) 
								{
										$archivos[]=$buscar_archivos->docu_ruta;				
								}
								foreach ($archivos as $archivo) 
								{
										$io_mail->AddAttachment(WRITEPATH.$archivo);
								}
								$rutaDestino = WRITEPATH ;
								
								if ($io_mail->send()) {
									$url = base_url('mail/recover');
									$link = "<a href='$url' </a>";
									//return $this->respond(["message" => "Revisa tu correo para seguir los pasos de recuperación. $link"], 200);
								} else {
									$repuesta['mensaje']      = 2;
									return json_encode($repuesta);
									//return $this->respond(["message" => "No se pudo enviar el correo, pongase en contacto con el administrador del sistema para más información"], 404);
								}
								} catch (Exception $e) {
									echo 'Error al establecer la conexión SMTP: ' . $e->getMessage();
								}
								$repuesta['mensaje']      = 1;
								$repuesta['idcaso']  = $datos["id_caso"];
								return json_encode($repuesta);		
							}
						}  
					} 	
				}
			//Si  a sido remitido hacemos un update y luego un isnsert	
			}else
			{
						//BUSCAMOS LA DESCRIPCION DEL CASO 
						$buscar_descripcioncaso=$casoModel->buscar_correo($datos["id_caso"]);
						//BUSCAMOS LOS ARCHIVOS ADJUNTOS AL CASO 
						$buscar_archivos=$documentos_casos->buscar_documentos($datos["id_caso"]);
						if(empty($buscar_descripcioncaso->getResult()))
						{
							echo('Esta vacio el correo');
							die();

						}
						else
						{
							foreach ($buscar_descripcioncaso->getResult() as $row) 
							{
							$desc_caso=utf8_decode($row->casodesc);	
							}
							$actualizar_datos['casos_id']=$datos["id_caso"];
							$actualizar_datos['vigencia']=false;
							$actualizar_caso_remitido = $caso_remitido->actualizar_caso_remitido($actualizar_datos);
							if (isset($actualizar_caso_remitido))
							{
								$repuesta[] = '0';
								$query_remitir_caso = $caso_remitido->remitirCaso($remitirCase);
								//Realizamos la Insercion en la tabla Auditoria 
								if (isset($query_remitir_caso)) 
								{
									$auditoria['audi_user_id']   = session('iduser');
									$auditoria['audi_accion']   = 'REMITIO EL CASO 	Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
									$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
									//Realizamos la insercion en la tabla de Seguimientos
									$datosSeguimiento['idcaso'] =$datos["id_caso"] ;
									$datosSeguimiento['idestllam'] ='4';
									$datosSeguimiento['segcoment']   = 'REMITIO EL CASO 	Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
									$datosSeguimiento['segfec'] =$segfec ;
									$datosSeguimiento['idusuopr']   = session('iduser');
									$seguimientos_caso = $seguimientos->insertarSeguimiento($datosSeguimiento);
									//BUSCAMOS EL CORREO DE LA DIRECCION AL CUAL FUE REMITIDO EL CASO
									$buscar_correo=	$direcciones->buscar_correo($datos["direccion"]);
									if (isset($buscar_correo)) 
									{
										foreach ($buscar_correo->getResult() as $row) 
										{
										$correo=$row->correo;	
										}
										if ($correo==NULL)
										{
											$repuesta['mensaje']      = 3;
											return json_encode($repuesta);
										}
										else 
										{
											//Enviamos un correo a la direccion Remitida 
											$mail = new PHPMailer();
											$dataEmail = array();
											$dataEmail["idcaso"]=$datos["id_caso"];
											$dataEmail["nombredireccion"]=$nombre_direccion["nombre_direccion"];
											$targetDir = WRITEPATH; // Directorio donde se guardarán los archivos subidos
											$dataEmail["desc_caso"] = $desc_caso;
											$dataEmail["timestamp_generate"] = strtotime(date('Y-m-d H:i:s'));
											$dataEmail["timestamp_expire"] = strtotime("5 minutes", $dataEmail["timestamp_generate"]);
											//Codificamos el JSON y lo encriptamos
											$urlData = base64_encode(json_encode($dataEmail));
											$dataEmail["urldata"] = $urlData;
											$el_servidor  = "172.16.0.161";
											$el_puerto    = "587";
											$el_remitente = "adminsistemas@sapi.gob.ve";
											$el_pass      = "As.12345";
											try {
												$smtpOptions = array(
													'ssl' => array(
														'verify_peer' => false,
														'verify_peer_name' => false,
														'allow_self_signed' => true
													)
												);
											$correo=$correo;		
											$io_mail = new PHPMailer();
											$io_mail->isSMTP();
											$io_mail->Host = $el_servidor;
											$io_mail->Port = $el_puerto;
											$io_mail->SMTPAuth = true;
											$io_mail->Username = $el_remitente;
											$io_mail->Password = $el_pass;
											$io_mail->SMTPOptions = $smtpOptions;
											$io_mail->setFrom($el_remitente);
											$io_mail->AddAddress($correo); // Agrega la dirección de correo de destino
											$io_mail->FromName = "No Reply";
											$io_mail->Subject = utf8_decode("CASO Nª".' '.$datos["id_caso"].' '.' HA SIDO REMITIDO A SU DIRECCIÓN');
											$io_mail->Body = view('mail/recover', $dataEmail);
											$io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
											$archivos=array();										
											foreach ($buscar_archivos as $buscar_archivos) {
												$archivos[]=$buscar_archivos->docu_ruta;
												
											}
											foreach ($archivos as $archivo) {
												$io_mail->AddAttachment(WRITEPATH.$archivo);
											}
											
								
											if ($io_mail->send()) {
												
												$url = base_url('mail/recover');
												$link = "<a href='$url' </a>";
												//return $this->respond(["message" => "Revisa tu correo para seguir los pasos de recuperación. $link"], 200);
											} else {
												$repuesta['mensaje']      = 2;
												return json_encode($repuesta);
												//return $this->respond(["message" => "No se pudo enviar el correo, pongase en contacto con el administrador del sistema para más información"], 404);
											}
											} catch (Exception $e) {
												echo 'Error al establecer la conexión SMTP: ' . $e->getMessage();
											}
											$repuesta['mensaje']      = 1;
											$repuesta['idcaso']  = $datos["id_caso"];
											return json_encode($repuesta);		
										}
									}   	
								}
							}
				}
			}
			
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo queo obtiene  los todos los casos disponibles
	public function listar_Casos_Usuarios()

	{
		$idrol = (session('userrol'));
		$idusur = (session('iduser'));
		
		$model = new Casos();
		if($idrol==1 or  $idrol ==3 or  $idrol ==5)
		{ 
			$query = $model->obtenerCasos();
			
			
		if (empty($query)) {
				$casos = [];
			} else {
				$casos = $query;
			}
			echo json_encode($casos);
		}
		else
		{
			$query = $model->obtenerCasos_filtrados_por_usuario($idusur);
			
			if (empty($query)) {
				$casos = [];
			} else {
				$casos = $query;
			}
			echo json_encode($casos);
		}
		
	}

	













	//Metodo queo obtiene  los Ultimos_Casos  disponibles
	public function listar_Ultimos_Casos()
	{
		$iduser = (session('iduser'));
		$model = new Casos();
		$query = $model->obtener_ultimos_casos($iduser);
		if (empty($query)) {
			$ultimos_casos = [];
		} else {
			$ultimos_casos = $query;
		}
		echo json_encode($ultimos_casos);
	}

// Método para subir archivos
public function upload()
{
    $model = new Casos();
    $id_caso_pdf = $_POST['id_caso_pdf'] ?? '';
    $archivo = $_FILES['archivo'] ?? null;

    // LISTA BLANCA
	$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx|mp4|mp3|MPEG-4|MOV|WMV|AVI|MKV|SWF|odt';
    $tamañoMaximo = 10 * 1024 * 1024; // 10MB en bytes

    // Verificar si se ha subido un archivo
    if ($archivo && $archivo["name"] != '') 
    {
        // Limpiar el nombre del archivo
        $nombreArchivo = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', strtolower($id_caso_pdf . '_' . trim($archivo['name'])));
        $archivoTemporal = trim($archivo['tmp_name']);
        $rutaDestino = WRITEPATH . trim($nombreArchivo);
        $targetDir = WRITEPATH; // Directorio donde se guardarán los archivos subidos
        $targetFile = $targetDir . basename($nombreArchivo);

        // Comprobar si hay extensiones dobles
        $partesArchivo = explode('.', $nombreArchivo);
        if (count($partesArchivo) > 2) {
            return json_encode(8); // Nombre de archivo inválido. Las extensiones dobles no están permitidas.
        }

        // Obtener la extensión del archivo
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar si el archivo tiene una extensión permitida
        if (!in_array($fileType, explode('|', $config['allowed_types']))) {
            return json_encode(5); // Tipo de archivo no permitido
        }

        // Verificar el tamaño del archivo
        if ($archivo["size"] > $tamañoMaximo) {
            return json_encode(1); // Archivo demasiado grande
        }

        // Verificar el tipo MIME del archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $archivoTemporal);
        finfo_close($finfo);

        // Verificar si el MIME type coincide con la extensión
		$mimeTypes = [
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'pdf' => 'application/pdf',
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'mp4' => 'video/mp4',
			'mp3' => 'audio/mpeg',
			'mov' => 'video/quicktime',
			'wmv' => 'video/x-ms-wmv',
			'avi' => 'video/x-msvideo',
			'mkv' => 'video/x-matroska',
			'swf' => 'application/x-shockwave-flash',
			'odt' => 'application/vnd.oasis.opendocument.text', 
		];

        if (!array_key_exists($fileType, $mimeTypes) || $mimeTypes[$fileType] !== $mimeType) {
            return json_encode(6); // Tipo de archivo no coincide con el contenido
        }

        // Verificar si el archivo ya existe
        if (file_exists($targetFile)) {
            return json_encode(0); // El archivo ya existe
        }

        // Verificar contenido para imágenes
        if ($fileType === 'jpg' || $fileType === 'jpeg' || $fileType === 'png') {
            $img = @imagecreatefromstring(file_get_contents($archivoTemporal));
            if (!$img) {
                return json_encode(9); // El archivo no es una imagen válida
            }
        }

        // Mover el archivo a la ubicación deseada
        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $documentos_casos['docu_id_caso'] = $id_caso_pdf;
            $documentos_casos['docu_ruta'] = $nombreArchivo;

            // Intentar agregar la información del documento a la base de datos
            $query_docu_casos = $model->agregar_docu_casos($documentos_casos);
            
                      // Verificar si la consulta fue exitosa
					  if ($query_docu_casos) {
						return json_encode(2); // Archivo subido y registrado en la base de datos
					} else {
						return json_encode(7); // Error al agregar a la base de datos
					}
				} else {
					return json_encode(3); // Error al subir el archivo
				}
			} else {
				return json_encode(4); // No se subió ningún archivo
			}
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

