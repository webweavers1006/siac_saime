<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Participantes_Model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Mediacion;
use App\Models\SapiTerceroModel;
class Participantes_Mediacion_Controler extends BaseController
{
	use ResponseTrait;



    public function Vista_Participantes_Mediacion()
	{
		
		
		if ($this->session->get('logged')) {
			
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('participantes_mediacion/content.php');
			echo view('template/footer');
			echo view('participantes_mediacion/footer.php');
           
		} else {
			return redirect()->to('/');
		}
	}

	
	/*
       FUNCION PARA OBTENER LOS PARTICIPANTES 
    */
	public function listar_participantes_Mediacion()
	{
		$model = new SapiTerceroModel();
		$query = $model->listar_participantes_Mediacion();
		
		
		if (empty($query)) {
			$participantes = [];
		} else {
			$participantes = $query;
		}
		echo json_encode($participantes);
	}


   // Metodo para ACTUALIZAR LA INFORMACION DEL PARTICIPANTE DE MEDIACION
public function edit_participante()
{
    $model = new SapiTerceroModel();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') && $this->request->isAJAX()) {
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $ter_id = $datos['ter_id'] ?? null;
        
        if (empty($ter_id)) {
            // Error: ID no proporcionado o es nulo
            return $this->response->setJSON(['status' => 2, 'message' => 'ID del participante es requerido.']); 
        }
        $participante_data = $datos;
        unset($participante_data['ter_id']); 
        $query_editar_participante = $model->update($ter_id, $participante_data);
        
        if ($query_editar_participante) {
            
            // Lógica de Auditoría
            $nombre_participante = $datos['ter_nombre'] ?? 'Participante Desconocido';
            $auditoria['audi_user_id'] = session('iduser');
            $auditoria['audi_accion']  = 'Los Datos de: ' . $nombre_participante . ' (ID: ' . $ter_id . ') fueron ACTUALIZADOS.';
            
            // Guardar en el modelo de Auditoría
            $model_Auditoria_sistema_Model->agregar($auditoria); 
            
            // Respuesta exitosa
            return $this->response->setJSON(1); 
            
        } 
    } else {
        // No es AJAX o no está logueado
        return redirect()->to('/');
    }
}





	/*
       FUNCION PARA OBTENER LOS PARTICIPANTES DE MEDIACION  EN FUNCION DEL CASO
    */
	public function buscar_Info_Mediacion($idcaso)
	{
		
		$model = new Mediacion();
		$query = $model->buscar_Info_Mediacion($idcaso);
		
		if (empty($query)) {
			$participantes = [];
		} else {
			$participantes = $query;
		}
		echo json_encode($participantes);
	}

/*
       FUNCION PARA OBTENER LOS PARTICIPANTES DE MEDIACION  EN FUNCION DEL LA CEDULA
    */
	public function buscar_datos_cedula_mediacion($cedula_existente)
    {
        if (empty($cedula_existente)) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['error' => 'La cédula de identificación es requerida.']);
        }

        $model = new SapiTerceroModel();
        $query = $model->buscar_datos_cedula_mediacion($cedula_existente);
        
        if (empty($query)) {
            // Si no se encuentra, devuelve un objeto vacío (200 OK sin datos)
            $participante = (object)[]; 
        } else {
            // Devuelve el primer resultado
            $participante = $query[0]; 
        }
        
        // Devuelve la respuesta en formato JSON
        return $this->response->setJSON($participante);
    }
	

}
