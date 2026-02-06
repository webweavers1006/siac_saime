<?php

namespace App\Controllers;

use App\Models\Seguimientos;
use App\Models\Documentos_casos_Model;
use CodeIgniter\API\ResponseTrait;

class Documentos_casos_Controler extends BaseController
{

    use ResponseTrait;


    // //Metodo queo obtiene  los todos los seguimientos disponibles
public function ver_documentos($idcaso = null)
{    
    $model_docu_casos = new Documentos_casos_Model();
   
    $query = $model_docu_casos->buscar_documentos($idcaso);
      $response = array_values($query);
    // 1. Establece la cabecera HTTP para indicar que el contenido es JSON
    header('Content-Type: application/json');

   return $this->response->setJSON($response);
}

    //Metodo para obtener documentos_casos
    public function buscar_documentos_casos()
    {
        $model_docu_casos = new Documentos_casos_Model();
        $opt = '';
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
            $query = $model_docu_casos->buscar_documentos_casos($datos["idcaso"]);

            if (isset($query)) {
                $opt .= '<option value="" selected disabled>Seleccione</option>';
                foreach ($query->getResult() as $row) {

                    $opt .= '<option value="' . $row->docu_ruta . '">' . ucfirst(strtolower($row->docu_ruta)) . '</option>';
                }
                unset($model);
                return $this->respond(["message" => "success", "data" => $opt], 200);
            } else {
                unset($model);
                return $this->respond(["message" => "not found"], 404);
            }
        } else {
            unset($model);
            return redirect()->to('/');
        }
    }
}
