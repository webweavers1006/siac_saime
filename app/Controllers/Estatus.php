<?php

namespace App\Controllers;

use App\Models\Estatus as Status;
use App\Models\Seguimientos;
use App\Models\Casos;
use CodeIgniter\API\ResponseTrait;
use App\Models\Auditoria_sistema_Model;
use App\Models\Notificaciones_Model;


require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use VARIANT;
class Estatus extends BaseController
{
    use ResponseTrait;

//Metodo que muestra la vista de los tipos de direcciones
public function vista_tipo_Estatus()
{
    if ($this->session->get('logged')) {
        echo view('template/header');
        echo view('template/nav_bar');
        echo view('tipo_de_estatus/content.php');
        echo view('template/footer');
        echo view('tipo_de_estatus/footer_estatus.php');
    } else {
        return redirect()->to('/');
    }
}

/*
   FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
*/
public function Listar_Tipo_Estatus()
{
    $model = new Status();
    $query = $model->Listar_Tipo_Estatus();
    if (empty($query)) {
        $estatus = [];
    } else {
        $estatus = $query;
    }
    echo json_encode($estatus);
}

/*
   FUNCION PARA OBTENER LOS TIPOS DE ATENCION ACTIVOS
*/
public function Listar_Tipo_Atencion_filtro()
{
    $model = new Status();
    $query = $model->Listar_Tipo_Atencion_filtro();
    if (empty($query)) {
        $atencion = [];
    } else {
        $atencion = $query;
    }
    echo json_encode($atencion);
}

//Metodo para añadir tipo de atencion
public function add_Tipo_Estatus()
{
    $model = new Status();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') and $this->request->isAJAX()) {
        //Obtenemos los datos del formulario
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        //llenamos los datos iniciales de las Direccion
        $estatus["estnom"]     = $datos["descripcion"];
        //Realizamos la insercion en la tabla
        $query_insertar_estatus = $model->add_estatus($estatus);
        if (isset($query_insertar_estatus)) {
            $auditoria['audi_user_id']   = session('iduser');
            $auditoria['audi_accion']   = 'INGRESO EL TIPO DE ESTATUS : ' . '(' . ' ' . $estatus["estnom"] . ' ' . ')';
            $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
            $mensaje = 1;
            return json_encode($mensaje);
        } else {
            $mensaje = 2;
            return json_encode($mensaje);
        }
    } else {
        return redirect()->to('/');
    }
}

//Metodo para ACTUALIZAR Direcciones
public function editTipoEstatus()
{
    $model = new Status();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    if ($this->session->get('logged') and $this->request->isAJAX()) {
        //Obtenemos los datos del formulario
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        //llenamos los datos iniciales de las Direccion
        $estatus["estnom"]     = $datos["estnom"];
        $estatus["borrado"]     = $datos["borrado"];
        $estatus["idest"]     = $datos["idest"];
        //Realizamos la actualizacion en la tabla
        $query_editar_estatus = $model->editTipoEstatus($estatus);
        if (isset($query_editar_estatus)) {
            $auditoria['audi_user_id']   = session('iduser');
            $auditoria['audi_accion']   = ' EL TIPO DE estatus :' . ' ' . '(' . ' ' . $estatus["estnom"] . ')' . ' ' . ' FUE ACTUALIZADO';
            $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
            $mensaje = 1;
            return json_encode($mensaje);
        } else {
            $mensaje = 2;
            return json_encode($mensaje);
        }
    } else {
        return redirect()->to('/');
    }
}

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
            $correo = array(
                "env_correo" => $datos["env_correo"],
            );

            $query = $estatusModel->cambioEstatusCaso($data);
            if (isset($query)) {
                //Cambiamos el estatus a Abierto
                switch (intval($data['idest']))
                {
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

                    //VERIFICAMOS SI ESA ATENCION ENVIA CORREO O NO
                    if ($correo["env_correo"] == "t")
                    {
                        //Enviamos un correo al usuario
                        $mail = new PHPMailer();
                        $correo = new casos();
                        //Buscamos el correo del Usuario , el  nombre del usuario 
                        $buscar_correo=	$correo->buscar_correo($datos["caseid"]);
                        if (isset($buscar_correo)) 
                        {
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
                                    $io_mail->AddAddress($correo);
                                    $io_mail->FromName = "No Reply";
                                    $io_mail->Subject = utf8_decode("SU CASO Nª".' '.$datos["caseid"].' '.' HA SIDO CERRADO');
                                    $io_mail->Body = view('email_caso_cerrado/recover',$dataEmail);
                                    $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
                                    if ($io_mail->send()) {
                                        $url = base_url('email_caso_cerrado/recover');
                                        $link = "<a href='$url' </a>";
                                    } else {
                                    
                                    }
                            } catch (Exception $e) {
                                echo 'Error al establecer la conexion SMTP: ' . $e->getMessage();
                            }
                                
                                }
                            }  
                    }   

                        break;

                }

                    // Crear notificacion para usuarios con roles 1, 3, 5
                    $this->crearNotificacionCambioEstatus($datos["caseid"], $data['idest']);

                    if (isset($segQuery)) {
                        $repuesta['mensaje']      = 1;
                        return json_encode($repuesta);
                    } else {
                        $repuesta['mensaje']      = 2;
                        return json_encode($repuesta);
                    }
            } else {
                return $this->respond(["message" => "Hubo un error al cambiar el estatus"], 500);
            }
        }
    }

    /**
     * Crear notificacion de cambio de estatus
     * 
     * REGLAS FINALES:
     * 1. Seguimiento: 1,3,5 SIEMPRE + Rol 2 (autor) si es diferente
     * 2. Remision: 1,3,5 SIEMPRE + Rol 2 (autor) SIEMPRE + Nuevo Destino
     * 3. Cierre Rol 2: Nadie
     * 4. Cierre Rol 10: 1,3,5 + Rol 2 (autor) - OBLIGATORIO
     */
    private function crearNotificacionCambioEstatus($id_caso, $nuevo_estatus)
    {
        $notifModel = new Notificaciones_Model();
        $casoModel = new Casos();
        $estatusModel = new Status();
        
        log_message('debug', "=== INICIO crearNotificacionCambioEstatus ===");
        log_message('debug', "id_caso: $id_caso, nuevo_estatus: $nuevo_estatus");
        
        // Obtener informacion del caso
        $caso = $casoModel->obtenerCaso_id($id_caso);
        if (!$caso) {
            log_message('warning', "No se encontro el caso: $id_caso");
            return;
        }
        
        // Datos del usuario actual (quien realiza el cambio de estatus)
        $idusuopr_actual = $this->session->get('iduser');
        $id_rol_actual = $this->session->get('userrol');
        $direccion_usuario_id = $this->session->get('id_direccion_administrativa');
        $nombre_direccion_usuario = $notifModel->obtenerNombreDireccion($direccion_usuario_id);
        
        // Autor original del caso
        $id_caso_autor = $caso->idusuopr ?? 0;
        
        $nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;
        
        // Obtener nombre del estatus
        $estatus = $estatusModel->obtenerEstatusPorId($nuevo_estatus);
        $nombre_estatus = $estatus ? $estatus->estnom : 'Estatus #' . $nuevo_estatus;
        
        // Determinar tipo de notificacion
        $es_cierre = ($nuevo_estatus == 2);
        $tipo_notificacion = "CIERRE";
        
        // Mensaje base
        $mensaje_base = "El caso #$id_caso - Beneficiario: $nombre_beneficiario fue actualizado al estatus: $nombre_estatus. Actualizado por: $nombre_direccion_usuario";
        
        log_message('debug', "Autor original: $id_caso_autor");
        log_message('debug', "Usuario actual: $idusuopr_actual");
        log_message('debug', "Es cierre: " . ($es_cierre ? 'SI' : 'NO'));
        log_message('debug', "Rol del usuario que cierra: $id_rol_actual");
        
        $notificaciones_creadas = 0;
        $usuarios_supervision = [];
        
        // =====================================================================
        // REGLA: Si NO es cierre, notificar a supervision (igual que seguimiento)
        // =====================================================================
        if (!$es_cierre) {
            $usuarios_supervision = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);
            
            foreach ($usuarios_supervision as $usuario) {
                // REGLA 3: Self-exclusion
                if ($usuario->idusuopr == $idusuopr_actual) {
                    continue;
                }
                
                $insertado = $notifModel->insertarNotificacion([
                    "id_caso" => $id_caso,
                    "tipo_notificacion" => $tipo_notificacion,
                    "mensaje" => $mensaje_base,
                    "leida" => false,
                    "fecha_creacion" => date('Y-m-d H:i:s'),
                    "id_usuario_destino" => $usuario->idusuopr,
                    "direccion_origen" => $direccion_usuario_id,
                    "id_usuario_accion" => $idusuopr_actual,
                    "id_rol_accion" => $id_rol_actual,
                    "id_caso_autor" => $id_caso_autor
                ]);
                
                if ($insertado) {
                    $notificaciones_creadas++;
                }
            }
        }
        
        // =====================================================================
        // REGLA DE CIERRE: Depende del rol de quien cierra
        // =====================================================================
        if ($es_cierre) {
            
            // -----------------------------------------------------------------------------
            // ESCENARIO 1: CIERRE POR ROL 2 -> No notificar a nadie
            // -----------------------------------------------------------------------------
            if ($id_rol_actual == 2) {
                log_message('debug', "Cierre por Rol 2 - No se notifica a supervision ni al autor");
            }
            
            // -----------------------------------------------------------------------------
            // ESCENARIO 2: CIERRE POR ROL 10 (o cualquier otro rol excepto 2)
            // REGLA: Notificar a 1,3,5 (supervision) Y al Rol 2 (autor original)
            // -----------------------------------------------------------------------------
            else {
                log_message('debug', "Cierre por Rol 10 u otro - Notificando a supervision Y autor");
                
                // 2A. Notificar a Supervision (1,3,5)
                $usuarios_supervision = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);
                
                foreach ($usuarios_supervision as $usuario) {
                    // REGLA 3: Self-exclusion
                    if ($usuario->idusuopr == $idusuopr_actual) {
                        continue;
                    }
                    
                    $insertado = $notifModel->insertarNotificacion([
                        "id_caso" => $id_caso,
                        "tipo_notificacion" => $tipo_notificacion,
                        "mensaje" => $mensaje_base,
                        "leida" => false,
                        "fecha_creacion" => date('Y-m-d H:i:s'),
                        "id_usuario_destino" => $usuario->idusuopr,
                        "direccion_origen" => $direccion_usuario_id,
                        "id_usuario_accion" => $idusuopr_actual,
                        "id_rol_accion" => $id_rol_actual,
                        "id_caso_autor" => $id_caso_autor
                    ]);
                    
                    if ($insertado) {
                        $notificaciones_creadas++;
                    }
                }
                
                // 2B. Notificar al Autor Original (Rol 2)
                // REGLA: El autor SIEMPRE debe saber cuando su caso es cerrado por otro
                if ($id_caso_autor > 0 && $id_caso_autor != $idusuopr_actual) {
                    $autor = $notifModel->obtenerUsuarioPorId($id_caso_autor);
                    
                    if ($autor && isset($autor->idrol) && $autor->idrol == 2 && !(isset($autor->usuopborrado) && $autor->usuopborrado === true)) {
                        $mensaje_autor = "Su caso #$id_caso - Beneficiario: $nombre_beneficiario fue CERRADO por: $nombre_direccion_usuario";
                        
                        $insertado = $notifModel->insertarNotificacion([
                            "id_caso" => $id_caso,
                            "tipo_notificacion" => $tipo_notificacion,
                            "mensaje" => $mensaje_autor,
                            "leida" => false,
                            "fecha_creacion" => date('Y-m-d H:i:s'),
                            "id_usuario_destino" => $id_caso_autor,
                            "direccion_origen" => $direccion_usuario_id,
                            "id_usuario_accion" => $idusuopr_actual,
                            "id_rol_accion" => $id_rol_actual,
                            "id_caso_autor" => $id_caso_autor
                        ]);
                        
                        if ($insertado) {
                            $notificaciones_creadas++;
                            log_message('debug', "Notificacion de CIERRE enviada al autor (Rol 2): {$id_caso_autor}");
                        }
                    }
                }
            }
        }
        
        log_message('debug', "Total notificaciones creadas: {$notificaciones_creadas}");
        log_message('debug', "=== FIN crearNotificacionCambioEstatus ===");
    }

    public function enviar_correo_portal($caseid,$tipocorreo)
    {
        $caseid = trim(urldecode($caseid));
        // CORREO PARA SIAC 
        if ($tipocorreo=='1'||$tipocorreo==1)
        {
            //Enviamos un correo al usuario
          $mail = new PHPMailer();
          $correo = new casos();
          //Buscamos el correo del Usuario , el  nombre del usuario 
          $buscar_correo=	$correo->buscar_correo($caseid);
         
          if (isset($buscar_correo))
           {
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
                        $io_mail->AddAddress($correo);
                        $io_mail->FromName = "No Reply";
                        $io_mail->Subject = utf8_decode("SU CASO Nª".' '.$caseid.' '.' HA SIDO CREADO');
                        $io_mail->Body = view('email_caso_creado/recover',$dataEmail);
                        $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
                        if ($io_mail->send()) {
                            $url = base_url('email_caso_creado/recover');
                            $link = "<a href='$url' </a>";
                        } else {
                           $repuesta['mensaje']      = 4;
                           return json_encode($repuesta);
                        }
                    } catch (Exception $e) {
                        echo 'Error al establecer la conexion SMTP: ' . $e->getMessage();
                    }              
                }
          }  
           
        }
        // CORREO PARA AUDIENCIAS
        else if ($tipocorreo=='2'||$tipocorreo==2)
        {
            $token=$this->request->getServer('HTTP_AUTHORIZATION');
            // Crea un contexto de flujo para realizar una solicitud GET con el token como encabezado de autorizacion
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
                        $io_mail->AddAddress($correo);
                        $io_mail->FromName = "No Reply";
                        $io_mail->Subject = utf8_decode("SU AUDIENCIA N".''.$dataEmail["caso"].' '.' HA SIDO REGISTRADA');
                        $io_mail->Body = view('email_audiencia_creada/audiencia_creada',$dataEmail);
                        $io_mail->AltBody = 'Este es un mensaje de prueba enviado desde el servidor SMTP';
                        if ($io_mail->send()) {
                            $url = base_url('email_audiencia_creada/audiencia_creada');
                            $link = "<a href='$url' </a>";
                            return $this->respond(["message" => "REGISTRO EXISTOSO."], 200);
                        } else {
                           $repuesta['mensaje']      = 4;
                           return json_encode($repuesta);
                        }
                    } catch (Exception $e) {
                        echo 'Error al establecer la conexion SMTP: ' . $e->getMessage();
                    }
        }
          
    }
}
