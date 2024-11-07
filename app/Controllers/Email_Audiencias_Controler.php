<?php

namespace App\Controllers;

use App\Models\Estatus as Status;
use App\Models\Seguimientos;
use App\Models\Casos;
use CodeIgniter\API\ResponseTrait;
require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use VARIANT;
class Email_Audiencias_Controler extends BaseController
{
    use ResponseTrait;
    public function Correo_Audiencias_Create($id_caso)
    {
        
        $token=$this->request->getServer('HTTP_AUTHORIZATION');

        $session = session();
        
        // Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
        $contexto = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => "Authorization: $token\r\n"
            ]
        ]);

		// Realiza la solicitud y decodifica la respuesta JSON
		$datos2 = json_decode(file_get_contents("https://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$id_caso, false, $contexto), true);
        
                // Crear un nuevo arreglo con los campos deseados
                $resultado = [
                    'nombre_contacto' => $datos2['nombre_contacto'],
                    'apellido_contacto' => $datos2['apellido_contacto'],
                    'correo_contacto' => $datos2['correo_contacto']
                ];

      
                    //Enviamos un correo al usuario
                    $mail = new PHPMailer();
                   
                    $dataEmail = array();
                    $dataEmail["caso"]=$id_caso;
                    $dataEmail["nombre"]=$resultado['nombre_contacto'].' '.$resultado['apellido_contacto'];
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
                       
                        $correo=$resultado['correo_contacto'];		
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
                        $io_mail->Subject = utf8_decode("SU AUDIENCIA Nº".''.$dataEmail["caso"].' '.' HA SIDO REGISTRADA');
                        $io_mail->Body = view('email_audiencia_creada/audiencia_creada',$dataEmail);
                        $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
                        if ($io_mail->send()) {
                            $url = base_url('email_audiencia_creada/audiencia_creada');
                            $link = "<a href='$url' </a>";
                            return $this->respond(["message" => "REGISTRO EXISTOSO."], 200);
                        } else {
                           // $repuesta['mensaje']      = 4;
                           // return json_encode($repuesta);
                            //return $this->respond(["message" => "No se pudo enviar el correo, pongase en contacto con el administrador del sistema para más información"], 404);
                        }
                    } catch (Exception $e) {
                        echo 'Error al establecer la conexión SMTP: ' . $e->getMessage();
                    }
                           
              
                     
   
    }

   
}
