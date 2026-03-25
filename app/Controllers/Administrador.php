<?php

namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Roles;
use CodeIgniter\API\ResponseTrait;
use App\Models\Auditoria_sistema_Model;
use App\Models\Ubi_Admini_Model;

class Administrador extends BaseController
{
	use ResponseTrait;
	//Metodo que carga la vista de los usuarios registrados en el sistema
	public function adminUsers()
	{
		$rolModel = new Roles();
		$idrol = (session('userrol'));
		// Realiza la solicitud a la API para obtener los datos
		$session = session();
		$token = $session->get('token');
		// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);
		
		$rows = array();
		if ($this->session->get('userrol') == 1 or $this->session->get('userrol') == 5 ) {
			//Preguntamos por los roles de los usuarios
			$query = $rolModel->getRoles($idrol);
			
			$nivel_rol = json_decode(file_get_contents("https://siac.sapi.gob.ve/api/audiencia/roles",false, $contexto), true);

			
			//Generamos los option para los formularios
			$opt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$opt .= '<option value="' . $row->idrol . '">' . $row->rolnom . '</option>';
				}
			}
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

			$data["roles"] = $opt;
			$data["nivel_rol"] = $nivel_rol;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('administrador/usuarios/content', $data);
			echo view('template/footer');
			echo view('administrador/usuarios/footer.php');
		} else {
			return redirect()->to('/403');
		}
	}
	//Metodo queo obtiene  los usuarios registrados en el sistema
	// public function Get_All_Usuarios()
	// {
	// 	$model = new Usuarios();
	// 	$query = $model->getAllUsers_operadores();
	// 	if (empty($query->getResult())) {
	// 		$usuarios = [];
	// 	} else {
	// 		$usuarios = $query->getResultArray();
	// 	}
	// 	echo json_encode($usuarios);
	// }

	public function Get_All_Usuarios()
	{
		$model = new Usuarios();
		$usuarios = $model->getAllUsers_operadores();
		return $this->respond($usuarios, 200);
	}

	//Metodo que obtiene los roles del usuarios
	public function listar_Combo_Roles()
	{
		$idrol = (session('userrol'));
		
		
		$rolModel = new Roles();
		$query = $rolModel->getRoles($idrol);
		if (empty($query->getResult())) {
			$roles = [];
		} else {
			$roles = $query->getResultArray();
		}
		echo json_encode($roles);
	}

	//Metodo para añadir usuarios

	public function addUsuarios()
	{
		$model = new Usuarios();
		$model_buscarusuario = new Usuarios();

		if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
			$datos = json_decode(base64_decode($this->request->getPost('data')), true);
			$query_usuarios = $model_buscarusuario->obtenerUsuario($datos["useremail"]);

			if (!empty($query_usuarios)) {
				$mensaje = 0;
				return json_encode($mensaje);
			} else {
				$query = $model->addUsuario(
					array(
						"usuopnom" => $datos["username"],
						"usuopape" => $datos["userlastname"],
						"usuoppass" => password_hash($datos["userpass"], PASSWORD_BCRYPT),
						"idrol"    => $datos["userrol"],
						"usuopemail" => $datos["useremail"],
						"usercargo" => $datos["usercargo"],
						"acceso_audi" => $datos["acceso_audi"],
						"id_direccion_administrativa" => $datos["id_direccion_administrativa"]
					)
				);

				

			if ($datos["userrol"]=='9'or $datos["userrol"]==9 or $datos["acceso_audi"]==true)
			{
				$ultimo_id_insertado = $model_buscarusuario->ultimo_id_insertado();
				$last_value = $ultimo_id_insertado;
			
				if (isset($query)) {
					$mensaje = 1;
					$mensaje = $last_value;
					return json_encode($mensaje);
				} else {
					$mensaje = 2;
					return json_encode($mensaje);
				}
			}else
			{
				if (isset($query)) {
					$mensaje = 1;
					return json_encode($mensaje);
				} else {
					$mensaje = 2;
					return json_encode($mensaje);
				}

			}
	
			}
		} else {
			return $this->respond(["message" => "No autorizado"], 401);
		}
	}

	//Metodo para obtener un usuario para la edicion
	// public function obtenerUsuario()
	// {
	// 	$model = new Usuarios();
	// 	$data = array();
	// 	if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
	// 		$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
	// 		$query = $model->obtenerUsuarioPorId($datos["userid"]);
	// 		if (isset($query)) {
	// 			foreach ($query->getResult() as $row) {
	// 				$data["iduser"]   = $row->idusuopr;
	// 				$data["name"]     = $row->usuopnom;
	// 				$data["lastname"] = $row->usuopape;
	// 				$data["email"]    = $row->usuopemail;
	// 				$data["rol"]      = $row->idrol;
	// 			}
	// 			return $this->respond(["message" => "success", "data" => $data], 200);
	// 		} else {
	// 			return $this->respond(["message" => "not found"], 404);
	// 		}
	// 	} else {
	// 		return $this->respond(["message" => "No autorizado"], 403);
	// 	}
	// }

	public function obtenerUsuario()
	{
		$model = new Usuarios();
		$data = array();
		if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
			$datos = json_decode(base64_decode($this->request->getPost('data')), true);
			$query = $model->obtenerUsuarioPorId($datos["userid"]);
			if ($query->getNumRows() > 0) {
				foreach ($query->getResult() as $row) {
					$data["iduser"]   = $row->idusuopr;
					$data["name"]     = $row->usuopnom;
					$data["lastname"] = $row->usuopape;
					$data["email"]    = $row->usuopemail;
					$data["rol"]      = $row->idrol;
				}
				return $this->respond(["message" => "success", "data" => $data], 200);
			} else {
				return $this->respond(["message" => "not found"], 404);
			}
		} else {
			return $this->respond(["message" => "No autorizado"], 403);
		}
	}

	//Metodo para guardar los datos del usuario editado
	// public function editarUsuario()
	// {
	// 	$model = new Usuarios();
	// 	$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
	// 	if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
	// 		$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
	// 		$cambio_clave = $datos["modulo_clave"];
	// 		if ($cambio_clave == 'true') {
	// 			$query = $model->actualizarUsuario(array(
	// 				"idusuopr"   => $datos["userid"],
	// 				"usuopnom"   => $datos["username"],
	// 				"usuopape"   => $datos["userlastname"],
	// 				"usuopemail" => $datos["useremail"],
	// 				"usuopborrado" => $datos["usuopborrado"],
	// 				"usercargo" => $datos["usercargo"],
	// 				"idrol"      => $datos["userrol"],
	// 				"id_direccion_administrativa"      => $datos["id_direccion_administrativa"],
	// 				"usuoppass" => password_hash($datos["usuoppass"], PASSWORD_BCRYPT),
	// 			));
	// 		} else {

	// 			$query = $model->actualizarUsuario(array(
	// 				"idusuopr"   => $datos["userid"],
	// 				"usuopnom"   => $datos["username"],
	// 				"usuopape"   => $datos["userlastname"],
	// 				"usuopemail" => $datos["useremail"],
	// 				"usercargo" => $datos["usercargo"],
	// 				"usuopborrado" => $datos["usuopborrado"],
	// 				"id_direccion_administrativa"      => $datos["id_direccion_administrativa"],
	// 				"idrol"      => $datos["userrol"],
	// 			));
	// 		}
	// 		if (isset($query)) {
	// 			/// REGISTRO EN AUDITORIA LA Edicion del usuario
	// 			$auditoria['audi_user_id']   = session('iduser');
	// 			$auditoria['audi_accion']   = 'MODIFICO LOS DATOS PERSONALES DE  ' . '  ' . '  ' . $datos["username"] . ' ' . $datos["userlastname"];
	// 			$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
	// 			return $this->respond(["message" => "success"], 200);
	// 		} else {
	// 			return $this->respond(["message" => "error"], 500);
	// 		}
	// 	} else {
	// 		return $this->respond(["message" => "No autorizado"], 401);
	// 	}
	// }

	public function editarUsuario()
{
    $model = new Usuarios();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
        $datos = json_decode(base64_decode($this->request->getPost('data')), true);
        $cambio_clave = $datos["modulo_clave"];
        if ($cambio_clave == 'true') {
            $datos_a_actualizar = array(
                "idusuopr"   => $datos["userid"],
                "usuopnom"   => $datos["username"],
                "usuopape"   => $datos["userlastname"],
                "usuopemail" => $datos["useremail"],
                "usuopborrado" => $datos["usuopborrado"],
                "usercargo" => $datos["usercargo"],
                "idrol"      => $datos["userrol"],
				"acceso_audi"      => $datos["acceso_audi"],
                "id_direccion_administrativa"      => $datos["id_direccion_administrativa"],
                "usuoppass" => password_hash($datos["usuoppass"], PASSWORD_BCRYPT),
            );
        } else {
            $datos_a_actualizar = array(
                "idusuopr"   => $datos["userid"],
                "usuopnom"   => $datos["username"],
                "usuopape"   => $datos["userlastname"],
                "usuopemail" => $datos["useremail"],
                "usercargo" => $datos["usercargo"],
                "usuopborrado" => $datos["usuopborrado"],
                "id_direccion_administrativa"      => $datos["id_direccion_administrativa"],
				"acceso_audi"      => $datos["acceso_audi"],
                "idrol"      => $datos["userrol"],
            );
        }


        if ($model->actualizarUsuario($datos_a_actualizar)) {
            // Registro en auditoria la edición del usuario
            $auditoria['audi_user_id']   = session('iduser');
            $auditoria['audi_accion']   = 'MODIFICO LOS DATOS PERSONALES DE  ' . '  ' . '  ' . $datos["username"] . ' ' . $datos["userlastname"];
            $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
            return $this->respond(["message" => "success"], 200);
        } else {
            return $this->respond(["message" => "error"], 500);
        }
    } else {
        return $this->respond(["message" => "No autorizado"], 401);
    }
}

	//Metodo para guardar los datos del usuario editado
	// public function Bloquear_User()
	// {
	// 	$model = new Usuarios();
	// 	if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
	// 		$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
			
	// 		$query = $model->actualizarUsuario(array(
	// 			"idusuopr"   => $datos["idusuopr"],
	// 			"usuopborrado"   => $datos["usuopborrado"],
	// 		));
	// 		if (isset($query)) {
	// 			return $this->respond(["message" => "success"], 200);
	// 		} else {
	// 			return $this->respond(["message" => "error"], 500);
	// 		}
	// 	} else {
	// 		return $this->respond(["message" => "No autorizado"], 401);
	// 	}
	// }

	public function Bloquear_User()
{
    $model = new Usuarios();
    if ($this->request->isAJAX() and $this->session->get('userrol') == 1 or $this->session->get('userrol') == 5) {
        $datos = json_decode(base64_decode($this->request->getPost('data')), true);
        
        $query = $model->actualizarUsuario(array(
            "idusuopr"   => $datos["idusuopr"],
            "usuopborrado"   => $datos["usuopborrado"],
        ));
        if ($query->affectedRows() > 0) {
            return $this->respond(["message" => "success"], 200);
        } else {
            return $this->respond(["message" => "error"], 500);
        }
    } else {
        return $this->respond(["message" => "No autorizado"], 401);
    }
}
}
