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
class Estatus extends BaseController
{
    use ResponseTrait;
    public function cambioEstatus()
    {
        $estatusModel = new Status();
        $segModel = new Seguimientos();
        $segQuery = '';
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
            $data = array(
                "idcaso" => $datos["caseid"],
                "idest" => $datos["casestatus"]
            );
            $query = $estatusModel->cambioEstatusCaso($data);
            if (isset($query)) {
                //Cambiamos el estatus a Abierto
                switch (intval($data['idest'])) {
                    case 1:
                        $segQuery = $segModel->insertarSeguimiento(
                            array(
                                "idcaso" => $datos["caseid"],
                                "idestllam" => 2,
                                "segcoment" => "Cambiado a estatus Abierto el dia " . date('d-m-Y'),
                                "segfec" => date('Y-m-d'),
                                "idusuopr" => $this->session->get('iduser')
                            )
                        );
                        break;
                    //Cambiamos el estatus a Cerrado    
                    case 2:
                        $segQuery = $segModel->insertarSeguimiento(
                            array(
                                "idcaso" => $datos["caseid"],
                                "idestllam" => 2,
                                "segcoment" => "Cambiado a estatus Cerrado el dia " . date('d-m-Y'),
                                "segfec" => date('Y-m-d'),
                                "idusuopr" => $this->session->get('iduser')
                            )
                        );
                    //Enviamos un correo al usuario
                    $mail = new PHPMailer();
                    $correo = new casos();
                    //Buscamos el correo del Usuario , el  nombre del usuario 
                    $buscar_correo=	$correo->buscar_correo($datos["caseid"]);
                    if (isset($buscar_correo)) {
                        foreach ($buscar_correo->getResult() as $row) {
                            $correo=$row->correo;	
                            $nombre=$row->casonom.' '.' '.$row->casoape;
                        }
                        if ($correo==NULL) { 
                           $repuesta['mensaje']      = 3;
                           return json_encode($repuesta);
                        }else 
                        {


                    $dataEmail = array();
                    $dataEmail["idcaso"]=$datos["caseid"];
                    $dataEmail["nombre"]=$nombre;


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
                       
                        $correo=$correo;		
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
                        $io_mail->Subject = utf8_decode("SU CASO Nª".' '.$datos["caseid"].' '.' HA SIDO CERRADO');
                        $io_mail->Body = view('email_caso_cerrado/recover',$dataEmail);
                        $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
                        if ($io_mail->send()) {
                            $url = base_url('email_caso_cerrado/recover');
                            $link = "<a href='$url' </a>";
                            //return $this->respond(["message" => "Revisa tu correo para seguir los pasos de recuperación. $link"], 200);
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

                break;
       
                }


                if (isset($segQuery)) {
                    $repuesta['mensaje']      = 1;
                    return json_encode($repuesta);
                    //return $this->respond(["message" => "Estatus cambiado exitosamente"], 200);
                } else {
                    $repuesta['mensaje']      = 2;
                    return json_encode($repuesta);
                    //return $this->respond(["message" => "Hubo un error al cambiar el estatus"], 500);
                }
            } else {
                return $this->respond(["message" => "Hubo un error al cambiar el estatus"], 500);
            }
        }
    }

    public function enviar_correo_portal($caseid,$tipocorreo)
    {

        // CORREO PARA SIAC 
        if ($tipocorreo=='1'||$tipocorreo==1)
        {
            //Enviamos un correo al usuario
          $mail = new PHPMailer();
          $correo = new casos();
          //Buscamos el correo del Usuario , el  nombre del usuario 
          $buscar_correo=	$correo->buscar_correo($caseid);
          if (isset($buscar_correo)) {
              foreach ($buscar_correo->getResult() as $row) {
                  $correo=$row->correo;	
                  $nombre=$row->casonom.' '.' '.$row->casoape;
              }
              if ($correo==NULL) { 
                 $repuesta['mensaje']      = 3;
                 return json_encode($repuesta);
              }else 
              {
          $dataEmail = array();
          $dataEmail["idcaso"]=$caseid;
          $dataEmail["nombre"]=$nombre;
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
             
              $correo=$correo;		
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
              $io_mail->Subject = utf8_decode("SU CASO Nª".' '.$caseid.' '.' HA SIDO CREADO');
              $io_mail->Body = view('email_caso_creado/recover',$dataEmail);
              $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
              if ($io_mail->send()) {
                  $url = base_url('email_caso_creado/recover');
                  $link = "<a href='$url' </a>";
                  //return $this->respond(["message" => "Revisa tu correo para seguir los pasos de recuperación. $link"], 200);
              } else {
                  $repuesta['mensaje']      = 4;
                  return json_encode($repuesta);
                  //return $this->respond(["message" => "No se pudo enviar el correo, pongase en contacto con el administrador del sistema para más información"], 404);
              }
          } catch (Exception $e) {
              echo 'Error al establecer la conexión SMTP: ' . $e->getMessage();
          }
                 
              }
          }  
           
        }
        // CORREO PARA AUDIENCIAS
        else if ($tipocorreo=='2'||$tipocorreo==2)
        {
            $token=$this->request->getServer('HTTP_AUTHORIZATION');
        
        // Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorización
        $contexto = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => "Authorization: $token\r\n"
            ]
        ]);

		// Realiza la solicitud y decodifica la respuesta JSON
		$datos2 = json_decode(file_get_contents("https://siac.sapi.gob.ve/api/audiencia/requerimientos/unique/".$caseid, false, $contexto), true);
        
                // Crear un nuevo arreglo con los campos deseados
                $resultado = [
                    'nombre_contacto' => $datos2['nombre_contacto'],
                    'apellido_contacto' => $datos2['apellido_contacto'],
                    'correo_contacto' => $datos2['correo_contacto']
                ];
                
                   //Enviamos un correo al usuario
                    $mail = new PHPMailer();
                   
                    $dataEmail = array();
                    $dataEmail["caso"]=$caseid;
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
}
