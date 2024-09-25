<?php

namespace App\Controllers;

use App\Models\Casos;
use App\Models\Usuarios;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
	use ResponseTrait;
	//Metodo para iniciar la sesion
	public function autenticar()
	{
		$model = new Usuarios();
		$session = session();
		$userdata = array();
		if ($this->request->isAJAX()) {
			$datos = json_decode(base64_decode($this->request->getGet('data')), TRUE);
			$query = $model->obtenerUsuario($datos["username"]);
			if (empty($query))
			{
				$mensaje = 3;
				return json_encode($mensaje);
			}else
			{
				foreach ($query as $row) {
					if (password_verify($datos["userpass"], $row->usuoppass)) {
						$userdata["nombre"] = ucwords($row->usuopnom) . ' ' . ucwords($row->usuopape);
						$userdata["userrol"] = $row->idrol;
						$userdata["iduser"] = $row->idusuopr;
						$userdata["usuopborrado"] = $row->usuopborrado;
						$userdata["usercargo"] = $row->usercargo;
						$userdata["usuopemail"] = $row->usuopemail;
						$userdata["id_direccion_administrativa"] = $row->id_direccion_administrativa;
						if ($userdata["usuopborrado"] == 't') {
							$mensaje = 0;
							return json_encode($mensaje);
						} else {
							$userdata["logged"] = TRUE;
							$session->set($userdata);
							$mensaje = 1;
							return json_encode($mensaje);
							//return $this->respond(["message" => "Iniciando sesion"], 200);
						}
					} else {
						$mensaje = 2;
						return json_encode($mensaje);
						//return $this->respond(["message" => "Clave incorrecta"], 401);
					}
				}
			}
				
			
		} else  {
			return redirect()->to('/');
		}
	}

	//Metodo para cerrar la sesion
	public function logout()
	{
		$this->session->destroy();
		return redirect()->to('/');
	}

	public function cerrarSesion()

    {
        session()->destroy();
        return redirect()->to('/');
    }


	public function buscar_rol_correo($correo)
	{

		$model = new Usuarios();
		$query = $model->obtenerUsuario($correo);
		if (empty($query))
		{
			$corr = [];
		} else {
			$corr = $query;
		}
		echo json_encode($corr);
	}

	





}
