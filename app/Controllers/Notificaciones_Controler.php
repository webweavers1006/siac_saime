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
            $id_direccion = $this->session->get('id_direccion_administrativa');
            
            // Obtener parámetros de paginación
            $pagina = $this->request->getGet('pagina') ?? 1;
            $por_pagina = $this->request->getGet('por_pagina') ?? 10;
            
            // Depuración temporal
            log_message('debug', "===== DEBUG NOTIFICACIONES =====");
            log_message('debug', "Usuario ID: " . $id_usuario);
            log_message('debug', "User Rol: " . $userrol);
            log_message('debug', "Direccion: " . $id_direccion);
            log_message('debug', "Pagina: " . $pagina . ", Por pagina: " . $por_pagina);
            
            // Roles de supervisión
            $roles_supervision = [1, 3, 5];
            $es_supervision = in_array($userrol, $roles_supervision);
            $es_rol2 = ($userrol == 2);
            
            log_message('debug', "Es supervision: " . ($es_supervision ? 'SI' : 'NO'));
            log_message('debug', "Es Rol 2: " . ($es_rol2 ? 'SI' : 'NO'));
            
            // Determinar filtros según el rol
            if ($es_supervision) {
                // Roles 1, 3, 5: Ver seguimientos y remisiones de otras direcciones
                // Excluir autoacciones
                $resultado = $model->obtenerNotificacionesPorUsuario(
                    $id_usuario, 
                    $roles_supervision,
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            } elseif ($es_rol2) {
                // Rol 2: Ver solo seguimientos de sus casos
                $resultado = $model->obtenerNotificacionesPorUsuario(
                    $id_usuario, 
                    [2], // Marcar como rol 2
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            } else {
                // Otras direcciones: Solo remisiones a su dirección
                $resultado = $model->obtenerNotificacionesPorUsuario(
                    $id_usuario, 
                    [],
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            }
            
            log_message('debug', "Notificaciones encontradas: " . count($resultado['data']));
            log_message('debug', "Total paginas: " . $resultado['total_paginas']);
            log_message('debug', "===== FIN DEBUG NOTIFICACIONES =====");
            
            return $this->respond([
                "message" => "success",
                "data" => $resultado['data'],
                "pagination" => [
                    "total" => $resultado['total'],
                    "pagina" => $resultado['pagina'],
                    "por_pagina" => $resultado['por_pagina'],
                    "total_paginas" => $resultado['total_paginas']
                ]
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
            $id_direccion = $this->session->get('id_direccion_administrativa');
            
            // Roles de supervisión
            $roles_supervision = [1, 3, 5];
            $es_supervision = in_array($userrol, $roles_supervision);
            $es_rol2 = ($userrol == 2);
            
            $count = 0;
            
            if ($es_supervision) {
                // Roles 1, 3, 5: Contar seguimientos y remisiones
                $count = $model->contarNoLeidas($id_usuario, $roles_supervision, $id_direccion, $userrol);
            } elseif ($es_rol2) {
                // Rol 2: Contar solo seguimientos de sus casos
                $count = $model->contarNoLeidas($id_usuario, [2], $id_direccion, $userrol);
            } else {
                // Otras direcciones: Contar solo remisiones
                $count = $model->contarNoLeidas($id_usuario, [], $id_direccion, $userrol);
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
     * Obtener todas las notificaciones (leídas y no leídas)
     */
    public function obtenerTodasMisNotificaciones()
    {
        if ($this->session->get('logged')) {
            $model = new Notificaciones_Model();
            $id_usuario = $this->session->get('iduser');
            $userrol = $this->session->get('userrol');
            $id_direccion = $this->session->get('id_direccion_administrativa');
            
            // Obtener parámetros de paginación
            $pagina = $this->request->getGet('pagina') ?? 1;
            $por_pagina = $this->request->getGet('por_pagina') ?? 10;
            
            // Roles de supervisión
            $roles_supervision = [1, 3, 5];
            $es_supervision = in_array($userrol, $roles_supervision);
            $es_rol2 = ($userrol == 2);
            
            $resultado = [];
            
            if ($es_supervision) {
                $resultado = $model->obtenerTodasLasNotificaciones(
                    $id_usuario, 
                    $roles_supervision,
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            } elseif ($es_rol2) {
                $resultado = $model->obtenerTodasLasNotificaciones(
                    $id_usuario, 
                    [2],
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            } else {
                $resultado = $model->obtenerTodasLasNotificaciones(
                    $id_usuario, 
                    [],
                    $id_direccion,
                    $userrol,
                    $pagina,
                    $por_pagina
                );
            }
            
            return $this->respond([
                "message" => "success",
                "data" => $resultado['data'],
                "pagination" => [
                    "total" => $resultado['total'],
                    "pagina" => $resultado['pagina'],
                    "por_pagina" => $resultado['por_pagina'],
                    "total_paginas" => $resultado['total_paginas']
                ]
            ], 200);
        } else {
            return redirect()->to('/');
        }
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

