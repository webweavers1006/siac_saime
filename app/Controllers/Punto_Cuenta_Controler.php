<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Punto_Cuenta_Model;
use CodeIgniter\RESTful\ResourceController;

class Punto_Cuenta_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo que muestra la vista de los tipos de direcciones
	public function vista_Punto_Cuenta()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('punto_de_cuenta/content.php');
			echo view('template/footer');
			echo view('punto_de_cuenta/footer_punto_cuenta.php');
		} else {
			return redirect()->to('/');
		}
	}

	
	public function Listar_Punto_Cuenta()
	{
		$model = new Punto_Cuenta_Model();
		$query = $model->Listar_Punto_Cuenta();
		if (empty($query)) {
			$punto = [];
		} else {
			$punto = $query;
		}
		echo json_encode($punto);
	}


	//Metodo para añadir tipo de atencion
	public function add_Punto_Cuenta()
{

    $model = new Punto_Cuenta_Model(); 
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') && $this->request->isAJAX()) {
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $punto_cuenta = [
            'numero_punto_cuenta' => $datos["numero_punto_cuenta"],
            'fecha_punto_cuenta'  => $datos["fecha_punto_cuenta"],
            'nombre'              => $datos["nombre"],
            'apellido'            => $datos["apellido"],
            'monto_aprobado'      => $datos["monto_aprobado"],
            'causa_beneficio'     => $datos["causa_beneficio"],
        ];
        $query_insertar_punto_cuenta = $model->agregar($punto_cuenta);
        
        if ($query_insertar_punto_cuenta) {
            $auditoria['audi_user_id'] = session('iduser');
            // Descripción de la auditoría clara
            $auditoria['audi_accion']  = 'INGRESO EL PUNTO DE CUENTA CON NÚMERO: ' . 
                                         '(' . $punto_cuenta["numero_punto_cuenta"] . ') para el beneficiario: ' . 
                                         $punto_cuenta["nombre"] . ' ' . $punto_cuenta["apellido"];
            
            $model_Auditoria_sistema_Model->agregar($auditoria);
            $mensaje = 1; // Éxito
            return json_encode($mensaje);
        } else {
            $mensaje = 2; // Error de inserción
            return json_encode($mensaje);
        }
    } else {
        // Si no está logueado o no es AJAX
        return redirect()->to('/');
    }
}
 // Método para asociar un caso a punto de cuenta
  
    public function asociar_casos()
{
    // 1. Inicialización de Modelos y Respuesta
    $puntoCuentaModel = new \App\Models\Punto_Cuenta_Model(); 
    $auditoriaModel = new \App\Models\Auditoria_sistema_Model(); 
    $respuesta = ['success' => false, 'message' => '']; 
    
    // 2. Comprobación de seguridad/AJAX
    if (!$this->session->get('logged') || !$this->request->isAJAX()) {
         $respuesta['message'] = 'Acceso no autorizado o sesión caducada.';
         // Devuelve 401: Unauthorized
         return $this->response->setJSON($respuesta)->setStatusCode(401); 
    }
    
    // 3. Obtener y validar datos de entrada
    $id_punto_cuenta = (int)$this->request->getPost('id_punto_cuenta');
    $id_caso = (int)$this->request->getPost('id_caso');
    
    if (empty($id_punto_cuenta) || empty($id_caso)) {
        $respuesta['message'] = 'Faltan IDs en la solicitud.';
        return $this->response->setJSON($respuesta);
    }
    
    // 4. Verificar si el caso ya está asociado (el modelo devuelve un array, no un booleano)
    $existe = $puntoCuentaModel->verificar_caso_existente($id_punto_cuenta, $id_caso);

    if (!empty($existe)) {
        // Ya existe
        $respuesta['message'] = 'El Caso ID: ' . $id_caso . ' ya está asociado a este Punto de Cuenta.';
        
    } else {
        // 5. Asociar nuevo caso
        $datosAsociacion = [
            'id_punto_cuenta' => $id_punto_cuenta,
            'id_caso' => $id_caso,
        ];
        
        $insertado = $puntoCuentaModel->asociar_nuevo_caso($datosAsociacion);

        if ($insertado) { 
            
            // Lógica de Auditoría
            $descripcion = "Caso ID: $id_caso asociado al Punto de Cuenta ID: $id_punto_cuenta.";
            $auditoriaModel->agregar([
                'audi_user_id'  => $this->session->get('id_usuario'),
                'audi_accion' => $descripcion,
            ]);

             $respuesta['success'] = true;
             $respuesta['message'] = 'Caso ID: ' . $id_caso . ' asociado correctamente.';

        } else {
            // Falla en la inserción
            $respuesta['message'] = 'Error de base de datos al asociar el caso.';
        }
    }
    // 6. Devolver la respuesta como JSON
    return $this->response->setJSON($respuesta);

}

 // $query_insertar_punto_cuenta = $model->agregar($punto_cuenta);
        
        // if ($query_insertar_punto_cuenta) {
        //     $auditoria['audi_user_id'] = session('iduser');
        //     // Descripción de la auditoría clara
        //     $auditoria['audi_accion']  = 'INGRESO EL PUNTO DE CUENTA CON NÚMERO: ' . 
        //                                  '(' . $punto_cuenta["numero_punto_cuenta"] . ') para el beneficiario: ' . 
        //                                  $punto_cuenta["nombre"] . ' ' . $punto_cuenta["apellido"];
            
        //     $model_Auditoria_sistema_Model->agregar($auditoria);
        //     $mensaje = 1; // Éxito
        //     return json_encode($mensaje);
        // } else {
        //     $mensaje = 2; // Error de inserción
        //     return json_encode($mensaje);
        // }


	//Metodo para editar Punto de Cuenta
	public function edit_Punto_Cuenta()
{
    $model = new Punto_Cuenta_Model(); 
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') && $this->request->isAJAX()) {
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $punto_cuenta = [
            'id'                  => $datos["id"], 
            'numero_punto_cuenta' => $datos["numero_punto_cuenta"],
            'fecha_punto_cuenta'  => $datos["fecha_punto_cuenta"],
            'nombre'              => $datos["nombre"],
            'apellido'            => $datos["apellido"],
            'monto_aprobado'      => $datos["monto_aprobado"],
            'causa_beneficio'     => $datos["causa_beneficio"],
            'borrado'             => ($datos["borrado"] === 'true') ? true : false, // Convertir 'true'/'false' a booleano real si tu DB lo requiere
        ];
        
        $registro_id = $punto_cuenta['id'];
        $query_editar_punto_cuenta = $model->update_p_cuenta($registro_id, $punto_cuenta);
        if ($query_editar_punto_cuenta !== false) {
            $auditoria['audi_user_id'] = session('iduser');
            $auditoria['audi_accion']  = 'EL PUNTO DE CUENTA CON ID: ' . $punto_cuenta["id"] . 
                                         ' y NÚMERO: ' . $punto_cuenta["numero_punto_cuenta"] . 
                                         ' FUE ACTUALIZADO.';
            
            $model_Auditoria_sistema_Model->agregar($auditoria);
            
            $mensaje = 1; // Éxito
            return json_encode($mensaje);
        } else {
            $mensaje = 2; // Error de actualización o no se encontró el registro
            return json_encode($mensaje);
        }
    } else {
        // Si no está logueado o no es AJAX
        return redirect()->to('/');
    }
}


	public function cargarCasosAsociados($id_punto_cuenta=null)
	{
        
		$model = new Punto_Cuenta_Model();
		$query = $model->cargarCasosAsociados($id_punto_cuenta);
		if (empty($query)) {
			$casos_asociados = [];
		} else {
			$casos_asociados = $query;
		}
		echo json_encode($casos_asociados);
	}



	public function verificar_caso($inputnuevocaso=null)
	{
        
		$model = new Punto_Cuenta_Model();
		$query = $model->verificar_caso($inputnuevocaso);
		if (empty($query)) {
			$informacion = [];
		} else {
			$informacion = $query;
		}
		echo json_encode($informacion);
	}




}
