<?php



namespace App\Controllers;

use App\Models\Seguimientos;
use App\Models\Auditoria_sistema_Model;
use App\Models\Notificaciones_Model;
use CodeIgniter\API\ResponseTrait;

class Seguimiento_Controler extends BaseController
{

    use ResponseTrait;


    //Metodo queo obtiene  los todos los seguimientos disponibles
    public function listar_Seguimientos($id_caso)
    {
        $model_seguimientos = new Seguimientos();
        $query = $model_seguimientos->obtenerSeguimientoDeCaso($id_caso);
        if (empty($query)) {
            $seguimientos = [];
        } else {
            $seguimientos = $query;
        }
        echo json_encode($seguimientos);
    }

    
    //Metodo para añadir seguimientos 
    public function addSeguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        $notifModel = new Notificaciones_Model();
        
        if ($this->request->isAJAX() and $this->session->get('logged')) {
              //$datos = json_decode(base64_decode($this->request->getPost('data')));
             
           $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            if (strlen($datos["segcomment"]) < 1) {
                return $this->respond(["message" => "El comentario no debe estar en blanco"], 500);
            } else {
                $query = $segModel->insertarSeguimiento(array(
                    "idcaso" => $datos["caseid"],
                    "idestllam" => $datos["callid"],
                    "segcoment" =>  strtoupper($datos["segcomment"]),
                    "segfec" => date('Y-m-d'),
                    "idusuopr" => $this->session->get('iduser')
                ));
                if (isset($query)) {
                    $auditoria['audi_user_id']   = session('iduser');
                    $auditoria['audi_accion']   = 'INGRESO UN NUEVO SEGUIMIENTO';
                    $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                    
                    // Crear notificación para usuarios con roles 1, 3, 5
                    $this->crearNotificacionSeguimiento($datos["caseid"], $datos["segcomment"]);
                    
                    return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
                } else {
                    return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Crear notificación de seguimiento para usuarios con roles 1, 3, 5 Y al autor original del caso (Rol 2)
     * 
     * Reglas implementadas:
     * 1. Notificar a Roles de Supervisión (1, 3, 5) - GLOBAL
     * 2. Notificar al AUTOR ORIGINAL del caso (si tiene Rol 2)
     * 3. Evitar auto-notificaciones
     */
    private function crearNotificacionSeguimiento($id_caso, $comentario)
    {
        $notifModel = new Notificaciones_Model();
        $casoModel = new \App\Models\Casos();
        
        // Obtener información del caso
        $caso = $casoModel->obtenerCaso_id($id_caso);
        if (!$caso) {
            log_message('warning', "No se pudo obtener información del caso {$id_caso} para crear notificación de seguimiento");
            return;
        }
        
        // Datos del usuario actual (quien agrega el seguimiento)
        $idusuopr_actual = $this->session->get('iduser');
        $id_rol_actual = $this->session->get('userrol');
        $direccion_usuario_id = $this->session->get('id_direccion_administrativa');
        $nombre_direccion_usuario = $notifModel->obtenerNombreDireccion($direccion_usuario_id);
        
        // Autor original del caso
        $id_caso_autor = $caso->idusuopr ?? 0;
        
        // Verificar si el autor es diferente de quien agrega el seguimiento
        $autor_es_diferente = ($id_caso_autor != $idusuopr_actual);
        
        $nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;
        $mensaje_supervision = "Nuevo seguimiento en el caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . ". Agregado por: " . $nombre_direccion_usuario;
        
        log_message('debug', "=== CREAR NOTIFICACIÓN SEGUIMIENTO ===");
        log_message('debug', "Caso ID: {$id_caso}");
        log_message('debug', "Autor original: {$id_caso_autor}");
        log_message('debug', "Usuario actual: {$idusuopr_actual}");
        log_message('debug', "Autor diferente: " . ($autor_es_diferente ? 'SÍ' : 'NO'));
        
        $notificaciones_creadas = 0;
        $usuarios_supervision = [];
        
        // 1. NOTIFICAR A ROLES DE SUPERVISIÓN (1, 3, 5) - GLOBAL
        // Supervisión SIEMPRE recibe notificación de seguimiento para auditar movimientos
        $usuarios_supervision = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);
        
        foreach ($usuarios_supervision as $usuario) {
            // Excluir auto-notificación
            if ($usuario->idusuopr == $idusuopr_actual) {
                log_message('debug', "Skipping self-notification for supervision user: {$idusuopr_actual}");
                continue;
            }
            
            $insertado = $notifModel->insertarNotificacion([
                "id_caso" => $id_caso,
                "tipo_notificacion" => "SEGUIMIENTO",
                "mensaje" => $mensaje_supervision,
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
        
        log_message('debug', "Notificaciones creadas para supervisión: " . count($usuarios_supervision) . " (enviadas: {$notificaciones_creadas})");
        
        // 2. NOTIFICAR AL AUTOR ORIGINAL DEL CASO (ROL 2)
        // Solo si el autor es diferente de quien agrega el seguimiento Y el autor tiene Rol 2
        if ($autor_es_diferente && $id_caso_autor > 0) {
            $autor = $notifModel->obtenerUsuarioPorId($id_caso_autor);
            
            // Validar que el autor existe, tiene Rol 2, y NO está borrado
            if ($autor && isset($autor->idrol) && $autor->idrol == 2 && !(isset($autor->usuopborrado) && $autor->usuopborrado === true)) {
                // El autor tiene Rol 2, necesita recibir notificación de seguimiento
                $mensaje_autor = "Nuevo avance en su caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . ". Agregado por: " . $nombre_direccion_usuario;
                
                // No crear duplicado si ya fue notificado como supervisor
                $ya_notificado = false;
                foreach ($usuarios_supervision as $usuario) {
                    if ($usuario->idusuopr == $id_caso_autor) {
                        $ya_notificado = true;
                        break;
                    }
                }
                
                if (!$ya_notificado) {
                    $insertado = $notifModel->insertarNotificacion([
                        "id_caso" => $id_caso,
                        "tipo_notificacion" => "SEGUIMIENTO",
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
                        log_message('debug', "Notificación de seguimiento enviada al autor (Rol 2): {$id_caso_autor}");
                    }
                } else {
                    log_message('debug', "Autor (Rol 2) ya notificado como supervisor");
                }
            } else {
                $razon = "desconocida";
                if (!$autor) {
                    $razon = "no existe";
                } elseif (!isset($autor->idrol) || $autor->idrol != 2) {
                    $razon = "no tiene Rol 2";
                } elseif (isset($autor->usuopborrado) && $autor->usuopborrado === true) {
                    $razon = "usuopborrado = true";
                }
                log_message('debug', "Autor {$id_caso_autor} NO notificado: {$razon}");
            }
        }
        
        log_message('debug', "Total notificaciones de seguimiento creadas: {$notificaciones_creadas}");
        log_message('debug', "=== FIN CREAR NOTIFICACIÓN SEGUIMIENTO ===");
    }

    //Metodo para  actualizar Seguimientos
    public function  actualizar_Seguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            if (strlen($datos["segcomment"]) < 1) {
                return $this->respond(["message" => "El comentario no debe estar en blanco"], 500);
            } else {
                $query = $segModel->actualizarSeguimiento(array(
                    "idcaso" => $datos["caseid"],
                    "idestllam" => $datos["callid"],
                    "segcoment" => $datos["segcomment"],
                    "idsegcas" => $datos["idsegcas"],
                    "segfec" => date('Y-m-d'),
                    "idusuopr" => $this->session->get('iduser')

                ));
                if (isset($query)) {
                    $auditoria['audi_user_id']   = session('iduser');
                    $auditoria['audi_accion']   = 'HA ACTUALIZADO EL SEGUIMIENTO Nª' . $datos["idsegcas"];
                    $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                    return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
                } else {
                    return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    //Metodo para  eliminar seguimiento
    public function  eliminar_seguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_decode(base64_decode($this->request->getPost('data'))), TRUE);
            $query = $segModel->eliminarSeguimiento(array(
                "idsegcas" => $datos["idsegcas"],
                "borrado" => $datos["borrado"],
                "segcoment" => 'HA ELIMINADO EL SEGUIMIENTO Nª' . $datos["idsegcas"],
                "segfec" => date('Y-m-d'),
                "idusuopr" => $this->session->get('iduser')
            ));
            if (isset($query)) {
                $auditoria['audi_user_id']   = session('iduser');
                $auditoria['audi_accion']   = 'Ha eliminado el seguimiento Nª' . $datos["idsegcas"];
                $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
            } else {
                return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
            }
        } else {
            return redirect()->to('/');
        }
    }


    public function obtenerTL()
    {
        $segModel = new Seguimientos();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
            $query = $segModel->obtenerSeguimientoDeCaso($datos["data"]);
            if (isset($query)) {

                return $this->respond(["message" => "success", "data" => $this->getSeguimientos($query)], 200);
            } else {
                return $this->respond(["message" => "No se encontraron seguimientos"], 404);
            }
        } else {
            return redirect()->to('/');
        }
    }
}
