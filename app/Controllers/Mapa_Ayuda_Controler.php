<?php

namespace App\Controllers;

use App\Models\Estatus as Status;
use App\Models\Mapa_Ayuda_Model;
use App\Models\Casos;
use CodeIgniter\API\ResponseTrait;
use App\Models\Auditoria_sistema_Model;


require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use VARIANT;
class Mapa_Ayuda_Controler extends BaseController
{
    use ResponseTrait;




/*
   FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
*/
 public function Listar_Casos_Ayuda()
    {
        $model = new Mapa_Ayuda_Model();
        $casos = $model->Listar_Casos_Ayuda();
       

        if (empty($casos)) {
            $response = [];
        } else {
            $response = $casos;
        }

        return $this->response->setJSON($response);
    }

}