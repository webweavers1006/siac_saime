<?php



namespace App\Controllers;
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
use Config\Services;
use App\Models\Roles_Model;
use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class Audiencias_Controler extends BaseController
{
	use ResponseTrait;


	public function vista_audiencias()
	{
		
		if ($this->session->get('logged')) {
			
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('audiencias/content.php');
			echo view('template/footer');
			echo view('audiencias/footer.php');
			
		} else {
			return redirect()->to('/');
		}
	}

	public function vista_solicitudes()
	{
		
		if ($this->session->get('logged')) {
			
			$session = session();
			$token = $session->get('token');
			$userdata = $session->get();
			// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
			$contexto = stream_context_create([
				'http' => [
					'method'  => 'GET',
					'header'  => "Authorization: Bearer $token\r\n"
				]
			]);
			
		
		///SOLICITUDES POR TRABAJADOR
		$ch = curl_init("http://siac.sapi.gob.ve/api/audiencia/solicitudes/workers/".$userdata["iduser"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		$response = curl_exec($ch);
		curl_close($ch);
		$datos = json_decode($response, true);

		if ($datos['solicitudes']) 
		{
			$id_requerimiento = $datos['solicitudes'][0]['id_requerimiento'];
			$ch = curl_init("http://siac.sapi.gob.ve/api/audiencia/solicitudes/".$id_requerimiento);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
			));
			$response = curl_exec($ch);
			curl_close($ch);
			$mensajes = json_decode($response, true);
		}else {
			$mensajes  = '';
		}



		 // Pasa los datos a la vista
		 $data['datos'] = $datos;
		 $data['mensajes'] = $mensajes;
		
		 echo view('template/header');
		 echo view('template/nav_bar');
		 echo view('audiencias/listado_solicitudes', $data);
		 echo view('template/footer');
		 echo view('audiencias/footer_lista_solicitudes.php');
	 } else {
 
		 return redirect()->to('/');
 
	  }
	}





	public function detalles_requerimientos($idcaso)
	{
		
		if ($this->session->get('logged')) {
			$session = session();
			$token = $session->get('token');
			// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
			$contexto = stream_context_create([
				'http' => [
					'method'  => 'GET',
					'header'  => "Authorization: Bearer $token\r\n"
				]
			]);
		// Realiza la solicitud y decodifica la respuesta JSON
		$datos2 = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$idcaso, false, $contexto), true);


		$responsable = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/usuarios_areas", false, $contexto), true);
		
		//********************************************************************
       

		$ch = curl_init("http://siac.sapi.gob.ve/api/audiencia/solicitudes/".$idcaso);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		));
		$response = curl_exec($ch);
		curl_close($ch);
		$datos = json_decode($response, true);

		//********************************************************************
		

  		// ******************************OTROS DATOS***************************
		  $ch = curl_init("http://siac.sapi.gob.ve/api/audiencia/solicitudes/".$idcaso);
			curl_setopt_array($ch, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $token
				)
			));
			$response = curl_exec($ch);
			if (curl_errno($ch)) {
				$error_message = curl_error($ch);
				$otrosdatos = array(
					'error' => true,
					'mensaje' => $error_message
				);
			} else {
				$response = json_decode($response, true);
				if (isset($response['error'])) {
					$otrosdatos = array(
						'error' => true,
						'mensaje' => $response['error']['message']
					);
				} elseif (!empty($response)) {
					$otrosdatos = array(
						'error' => false,
						'mensaje' => '',
						'informacion' => $response
					);
				} else {
					$otrosdatos = array(
						'error' => true,
						'mensaje' => 'No hay datos disponibles'
					);
				}
			}
			curl_close($ch);
		//********************************************************************


		// Procesar los datos


		// ******************************CITAS***************************
		$url = "http://siac.sapi.gob.ve/api/audiencia/citas/ByRequerimiento/".$idcaso;
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
			$cita = json_decode($response, true);

		}

			// ************INFORMACION DE EMPRESA OBUFECTE***************************
			$url = "http://siac.sapi.gob.ve/api/audiencia/usuarios_bufetes/".$idcaso;
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
				$info_emp_buf = json_decode($response, true);

			}

			
		
		 // Pasa los datos a la vista
		 $data['datos'] = $datos;
		 $data['datos2'] = $datos2;
		 $data['otrosdatos'] = $otrosdatos;
		 $data['responsable'] = $responsable;
		 $data['cita'] = $cita;
		 $data['info_emp_buf'] = $info_emp_buf;
		 echo view('template/header');
		 echo view('template/nav_bar');
		 echo view('audiencias/detalles_requerimientos', $data);
		 echo view('template/footer');
		 echo view('audiencias/footer_detalles_requerimientos.php');
	 } else {
 
		 return redirect()->to('/');
 
	 }
	}

	public function actualizar_audiencia($idcaso)
	{
		if ($this->session->get('logged')) {

			$session = session();
			$token = $session->get('token');
		// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);

		 // Realiza la solicitud a la API para obtener los datos
		 $datos2 = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$idcaso, false, $contexto), true);
		
		 $pais = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/paises", false, $contexto), true);
		 $estados = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/estados_paises", false, $contexto), true);



		 // Pasa los datos a la vista
		 $data['estados'] = $estados;
		 $data['pais'] = $pais;
		 $data['datos2'] = $datos2;
		 echo view('template/header');
		 echo view('template/nav_bar');
		 echo view('audiencias/actualizar_audiencia', $data);
		 echo view('template/footer');
		 echo view('audiencias/footer_actualizar_audiencia.php');
	 } else {
 
		 return redirect()->to('/');
 
	 }
	}


	public function actualizar_solicitud($idcaso)
	{
		
		if ($this->session->get('logged')) {

			$session = session();
			$token = $session->get('token');
		// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);
		 // Realiza la solicitud a la API para obtener los datos
		 $responsable = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/usuarios_areas", false, $contexto), true);
		 $datos = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/solicitudes/unicas/".$idcaso, false, $contexto), true);
		

		 $pais = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/paises", false, $contexto), true);
		 $estados = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/estados_paises", false, $contexto), true);
		 // Pasa los datos a la vista
		 $data['responsable'] = $responsable;
		 $data['datos'] = $datos;
		 $data['estados'] = $estados;
		 $data['pais'] = $pais;
		// $data['datos2'] = $datos2;
		 echo view('template/header');
		 echo view('template/nav_bar');
		 echo view('audiencias/actualizar_solicitud', $data);
		 echo view('template/footer');
		 echo view('audiencias/footer_actualizar_solicitud.php');
	 } else {
 
		 return redirect()->to('/');
 
	 }
	}



	//Metodo que muestra la vista de las direcciones 
	public function detalles_solicitudes($id)
	{
		if ($this->session->get('logged'))
	{


		
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

		$datos = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/solicitudes/unicas/".$id, false, $contexto), true);

	
		$info_empresa_y_titulares = array(); // Inicializa la variable como un arreglo vacío

		if ($datos['id_area']==1) {
			$info_empresa_y_titulares = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/solicitudes/consulta/".$datos['num_solicitud']."/M/info", false, $contexto), true);
		} else if ($datos['id_area']==2) {
			$info_empresa_y_titulares = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/solicitudes/consulta/".$datos['num_solicitud']."/P/info", false, $contexto), true);
		}

		
		
		////MENSAJES
		$mensajes = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/mensajes/$id/1/100", false, $contexto), true);
		
		

		
		
		////CRONOLOGIA
		$url = "http://siac.sapi.gob.ve/api/audiencia/solicitudes/crono/".$id;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $token
		));
		$response = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);

		if ($error) {
			echo "Error: $error";
		} else {
			$cronologia = json_decode($response, true);

			if (isset($cronologia['error'])) {
				$cronologia['solicitudes']=array();
			}
			// ...
		}

		$responsable = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/usuarios_areas", false, $contexto), true);
		
		// Pasa los datos a la vista
		$data['datos'] = $datos;
		$data['info_empresa_y_titulares'] = $info_empresa_y_titulares;
		$data['cronologia'] = $cronologia;
		$data['responsable'] = $responsable;
		$data['mensajes'] = $mensajes;
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('audiencias/detalles_solicitudes.php', $data);
	//	echo view('template/footer');
		echo view('audiencias/footer_detalles_solicitudes.php', $data);
			
		} else {
			return redirect()->to('/');
		}
	}

//Metodo que muestra la vista de las direcciones 
public function citas()
{
	if ($this->session->get('logged')) {

		$session = session();
		$token = $session->get('token');
	// Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
	$contexto = stream_context_create([
		'http' => [
			'method'  => 'GET',
			'header'  => "Authorization: Bearer $token\r\n"
		]
	]);

	// Realiza la solicitud a la API para obtener los datos
	$datos = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/citas/1/100000000000", false, $contexto), true);
	// Pasa los datos a la vista
	$data['datos'] = $datos;
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('audiencias/citas.php',$data);
		//echo view('template/footer');
		echo view('audiencias/footer_citas.php');
	} else {
		return redirect()->to('/');
	}
}

public function actualizar_citas($idcaso)
	{
		if ($this->session->get('logged')) {

		$session = session();
		$token = $session->get('token');
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);

		// Realiza la solicitud a la API para obtener los datos
		//$datos2 = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$idcaso, false, $contexto), true);
		$cita = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/citas/".$idcaso, false, $contexto), true);
		
	
	 	// Pasa los datos a la vista
	 	//$data['datos2'] = $datos2;
		$data['cita'] = $cita;

		
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('audiencias/actualizar_citas.php',$data);
		echo view('template/footer');
		echo view('audiencias/footer_actualizar_citas.php');
	} else {
		return redirect()->to('/');
	}
	}

	//Metodo que muestra la vista de las direcciones 
	public function vista_agregar_requerimientos()
	{
		if ($this->session->get('logged')) {
			$session = session();
			$token = $session->get('token');
			$contexto = stream_context_create([
				'http' => [
					'method'  => 'GET',
					'header'  => "Authorization: Bearer $token\r\n"
				]
			]);


		// Realiza la solicitud a la API para obtener los datos
		$pais = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/paises", false, $contexto), true);
		$estados = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/estados_paises", false, $contexto), true);
		$categorias = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/categorias", false, $contexto), true);
		// Pasa los datos a la vista
		$data['estados'] = $estados;
		$data['pais'] = $pais;
		$data['categorias'] = $categorias;
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('audiencias/agregar_requerimientos.php',$data);
		echo view('template/footer');
		echo view('audiencias/footer_agregar_requerimientos.php');
		} else {
			return redirect()->to('/');
		}
	}

	


public function agregar_solicitudes($idcaso)
{
	if ($this->session->get('logged')) {

		$session = session();
			$token = $session->get('token');
			$contexto = stream_context_create([
				'http' => [
					'method'  => 'GET',
					'header'  => "Authorization: Bearer $token\r\n"
				]
			]);
	// Realiza la solicitud a la API para obtener los datos
	$datos2 = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$idcaso, false, $contexto), true);
	
	$categorias = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/categorias", false, $contexto), true);
	$data['categorias'] = $categorias;
	$data['datos2'] = $datos2;
	echo view('template/header');
	echo view('template/nav_bar');
	echo view('audiencias/agregar_solicitudes.php',$data);
	echo view('template/footer');
	echo view('audiencias/footer_agregar_solicitudes.php');
	} else {
		return redirect()->to('/');
	}
}
public function citas_otorgadas($año)
{
    if ($this->session->get('logged')) {
        $session = session();
        $token = $session->get('token');
        $contexto = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: Bearer $token\r\n"
            ]
        ]);

        // Asignar el año actual si $año es la cadena "null"
        if ($año === 'null') {
            $año = date('Y');
        }

		// Convertir a número

        $año = intval($año);
       
        
        // Realiza la solicitud a la API para obtener los datos
        $url = "http://siac.sapi.gob.ve/api/audiencia/citas/byMeses/" . $año;
        $citas = json_decode(file_get_contents($url, false, $contexto), true);
        
        $data['citas'] = $citas;
        echo view('template/header');
        echo view('template/nav_bar');
        echo view('audiencias/estadisticas/citas_otorgadas.php', $data);
        echo view('template/footer');
        echo view('audiencias/estadisticas/footer_citas_otorgadas.php');
    } else {
        return redirect()->to('/');
    }
}




public function casos_categorias()
{
	if ($this->session->get('logged')) {


		$session = session();
		$token = $session->get('token');
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);


	// Realiza la solicitud a la API para obtener los datos
	$casos = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/solicitudes/byCategorias", false, $contexto), true);
	$data['casos'] = $casos;
	
	echo view('template/header');
	echo view('template/nav_bar');
	echo view('audiencias/estadisticas/casos_categorias.php',$data);
	echo view('template/footer');
	echo view('audiencias/estadisticas/footer_casos_categorias.php');
	} else {
		return redirect()->to('/');
	}
}


public function estadisticas_audiencias()
{
	if ($this->session->get('logged')) {


		$session = session();
		$token = $session->get('token');
		$contexto = stream_context_create([
			'http' => [
				'method'  => 'GET',
				'header'  => "Authorization: Bearer $token\r\n"
			]
		]);

	$estado = json_decode(file_get_contents("http://siac.sapi.gob.ve/api/audiencia/requerimientos/byEstados", false, $contexto), true);
	$data['estatus'] = $estado;
	echo view('template/header');
	echo view('template/nav_bar');
	echo view('audiencias/estadisticas/audiencias.php',$data);
	echo view('template/footer');
	echo view('audiencias/estadisticas/footer_estadisticas_audiencias.php');
	} else {
		return redirect()->to('/');
	}
}


	
}
