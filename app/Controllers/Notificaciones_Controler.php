<?php

namespace App\Controllers;

use App\Models\Notificaciones_Model;
use App\Models\Usuarios;
use CodeIgniter\API\ResponseTrait;

class Notificaciones_Controler extends BaseController
{
    use ResponseTrait;

    /**
     * Obtener notificaciones del usuario logueado - CON DEPURACIÓN
     */
    public function obtenerMisNotificaciones()
    {
        if ($this->session->get('logged')) {
            $model = new Notificaciones_Model();
            $id_usuario = $this->session->get('iduser');
            $userrol = $this->session->get('userrol');
            
            // Depuración temporal
            log_message('debug', "===== DEBUG NOTIFICACIONES =====");
            log_message('debug', "Usuario ID: " . $id_usuario);
            log_message('debug', "User Rol: " . $userrol);
            
            // Roles que pueden ver seguimientos: 1, 3, 5
            $roles_permitidos = [1, 3, 5];
            $puede_ver_seguimientos = in_array($userrol, $roles_permitidos);
            
            log_message('debug', "Puede ver seguimientos: " . ($puede_ver_seguimientos ? 'SI' : 'NO'));
            
            if ($puede_ver_seguimientos) {
                // Pasar los roles permitidos para que muestre seguimientos
                $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos);
            } else {
                // No pasar roles, solo verá REMISION
                $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, []);
            }
            
            log_message('debug', "Notificaciones encontradas: " . count($notificaciones));
            
            return $this->respond([
                "message" => "success",
                "data" => $notificaciones
            ], 200);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Contar notificaciones no leídas
     */
    public function contarNotificaciones()
    {
        if ($this->session->get('logged')) {
            $model = new Notificaciones_Model();
            $id_usuario = $this->session->get('iduser');
            $userrol = $this->session->get('userrol');
            
            // Roles que pueden ver seguimientos: 1, 3, 5
            $roles_permitidos = [1, 3, 5];
            $puede_ver_seguimientos = in_array($userrol, $roles_permitidos);
            
            if ($puede_ver_seguimientos) {
                $count = $model->contarNoLeidas($id_usuario, $roles_permitidos);
            } else {
                $count = $model->contarNoLeidas($id_usuario, []);
            }
            
            return $this->respond([
                "message" => "success",
                "total" => $count
            ], 200);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida()
    {
        if ($this->session->get('logged') && $this->request->isAJAX()) {
            $model = new Notificaciones_Model();
            $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            
            if (isset($datos['id_notificacion'])) {
                $query = $model->marcarComoLeida($datos['id_notificacion']);
                if ($query) {
                    return $this->respond(["message" => "Notificación marcada como leída"], 200);
                } else {
                    return $this->respond(["message" => "Error al actualizar"], 500);
                }
            } else {
                return $this->respond(["message" => "ID de notificación no proporcionado"], 400);
            }
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasLeidas()
    {
        if ($this->session->get('logged') && $this->request->isAJAX()) {
            $model = new Notificaciones_Model();
            $id_usuario = $this->session->get('iduser');
            
            $query = $model->marcarTodasComoLeidas($id_usuario);
            if ($query) {
                return $this->respond(["message" => "Todas las notificaciones marcadas como leídas"], 200);
            } else {
                return $this->respond(["message" => "Error al actualizar"], 500);
            }
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Crear notificación (usado por otros controladores)
     */
    public function crearNotificacion($datos)
    {
        $model = new Notificaciones_Model();
        $query = $model->insertarNotificacion($datos);
        return $query;
    }

    /**
     * Obtener notificaciones para mostrar al inicio (para SweetAlert)
     */
    public function obtenerNotificacionesAlerta()
    {
        if ($this->session->get('logged')) {
            $model = new Notificaciones_Model();
            $id_usuario = $this->session->get('iduser');
            $userrol = $this->session->get('userrol');
            
            // Roles que pueden ver seguimientos: 1, 3, 5
            $roles_permitidos = [1, 3, 5];
            $puede_ver_seguimientos = in_array($userrol, $roles_permitidos);
            
            if ($puede_ver_seguimientos) {
                $notificaciones = $model->obtenerNotificacionesNoLeidas($id_usuario);
            } else {
                $db = \Config\Database::connect();
                $builder = $db->table('sgc_notificaciones n');
                $builder->select('n.*');
                $builder->where('n.id_usuario_destino', $id_usuario);
                $builder->where('n.leida', false);
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orderBy('n.fecha_creacion', 'DESC');
                $query = $builder->get();
                $notificaciones = $query->getResult();
            }
            
            return $notificaciones;
        } else {
            return [];
        }
    }
}

