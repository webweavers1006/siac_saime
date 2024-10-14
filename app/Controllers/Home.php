<?php

namespace App\Controllers;

use App\Models\Casos;
use CodeIgniter\HTTP\IncomingRequest;
use TheSeer\Tokenizer\Token;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
	//--------------------------------------------------------------------
	// //Todas las vistas deben ser cargadas aqui
	public function login()
	{
		$session = session();
		$session->destroy();
	
		echo view('template/header');
		echo view('login/content');
		echo view('login/footer');
	}
	//Vista principal
	public function dashboard()
	{

	
		if ($this->session->get('logged')) {

			$token = $_COOKIE['token'];
			$nivel_rol = $_COOKIE['nivel_rol'];
  			$session = session();
			
			//MONTO EN SESSION EL TOKEN
 			$session->set('token', $token);
		    $session->set('nivel_rol', $nivel_rol);
			$token = $session->get('token');
			$nivel_rol = $session->get('nivel_rol');
			
			// // BUSCO LOS PERMISOS DEL ROL
			// $url = "http://172.16.0.46:70/roles/".$nivel_rol;
			// $ch = curl_init($url);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			// 	'Content-Type: application/json',
			// 	'Authorization: Bearer ' . $token
			// ));
			// $response = curl_exec($ch);
			// $error_number = curl_errno($ch);
			// $error_message = curl_error($ch);
			// curl_close($ch);
			// if ($error_number) {
			// 	echo "Error: $error_message";
			// } else {
			// 	$permisos = json_decode($response, true);

			// }
		
			
			//ESTO TIENE TOLO LO DEL USUARIO EN SESION
			$userdata = $session->get();
			

			// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
			$contexto = stream_context_create([
				'http' => [
					'method' => 'GET',
					'header' => "Authorization: Bearer $token"
				]
			]);
			
			$estado = json_decode(file_get_contents("http://172.16.0.46:70/requerimientos/byEstados", false, $contexto), true);
		$data['estatus'] = $estado;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('dashboard/content',$data);
			echo view('template/footer');
			echo view('dashboard/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Vista principal
	public function pantalla_bienvenida()
	{
		
		if (session('logged')==TRUE) {


			$token = $_COOKIE['token'];
			$nivel_rol = $_COOKIE['nivel_rol'];
  			$session = session();
			
			//MONTO EN SESSION EL TOKEN
 			$session->set('token', $token);
		    $session->set('nivel_rol', $nivel_rol);
			$token = $session->get('token');
			$nivel_rol = $session->get('nivel_rol');
			
			// BUSCO LOS PERMISOS DEL ROL
			$url = "http://172.16.0.46:70/roles/".$nivel_rol;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
			));
			$response = curl_exec($ch);
			$error_number = curl_errno($ch);
			$error_message = curl_error($ch);
			curl_close($ch);
			if ($error_number) {
				echo "Error: $error_message";
			} else {
				$permisos = json_decode($response, true);

			}
			$session->set('permisos', $permisos);
			
			//ESTO TIENE TODO LO DEL USUARIO EN SESION
			$userdata = $session->get();
			
			

			//ESTO TIENE TOLO LO DEL USUARIO EN SESION
			
			//Pasamos la tabla como parametro para la vista
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('pantalla_bienvenida/content.php');
			echo view('template/footer');
			echo view('pantalla_bienvenida/footer_bienvenida.php');
		} else {
			return redirect()->to('/');
		}
	}

//Vista principal
public function pantalla1()
{
	//var_dump(session('nombre'));
	//die();
	if (session('logged')==TRUE) {
		//Pasamos la tabla como parametro para la vista
		echo view('template1/header');
		echo view('template1/nav_bar');
		echo view('pantalla_bienvenida/content.php');
		echo view('template1/footer');
		echo view('pantalla_bienvenida/footer_bienvenida.php');
	} else {
		return redirect()->to('/');
	}
}

//Vista principal
public function pantalla2()
{
	//var_dump(session('nombre'));
	//die();
	if (session('logged')==TRUE) {
		//Pasamos la tabla como parametro para la vista
		echo view('template2/header');
		echo view('template2/nav_bar');
		echo view('pantalla_bienvenida/content.php');
		echo view('template2/footer');
		echo view('pantalla_bienvenida/footer_bienvenida.php');
	} else {
		return redirect()->to('/');
	}
}






}
