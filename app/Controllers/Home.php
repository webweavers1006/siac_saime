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
	//Vista principal de operadores aud
	public function dashboard()
	{
		if ($this->session->get('logged')) {

			$session = session();
			$userdata = $session->get();
			$data = [];

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('dashboard/content', $data);
			echo view('template/footer');
			echo view('dashboard/footer');
		} else {
			return redirect()->to('/');
		}
	}

	//Vista principal de los trabajadores
	public function pantalla_bienvenida()
	{
		if (session('logged') == TRUE) {
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
