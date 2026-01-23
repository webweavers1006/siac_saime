<?php

namespace App\Models;

class Notificaciones_Model extends BaseModel
{
    /**
     * Insertar una nueva notificación
     */
    public function insertarNotificacion(array $datos)
    {
        $builder = $this->dbconn('sgc_notificaciones');
        $query = $builder->insert($datos);
        return $query;
    }

    /**
     * Obtener notificaciones por usuario
     */
    public function obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        
        // Si tiene roles permitidos, puede ver seguimientos
        if (!empty($roles_permitidos)) {
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->groupEnd();
        } else {
            $builder->where('n.tipo_notificacion', 'REMISION');
        }
        
        $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $builder->limit(50);
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtener notificaciones sin leídas por usuario
     */
    public function obtenerNotificacionesNoLeidas($id_usuario)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*, c.casonom, c.casoape');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->where('n.leida', false);
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Contar notificaciones no leídas
     */
    public function contarNoLeidas($id_usuario, $roles_permitidos = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->selectCount('n.id', 'total');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->where('n.leida', false);
        
        // Si tiene roles permitidos, puede ver seguimientos
        if (!empty($roles_permitidos)) {
            // Mostrar tanto REMISION como SEGUIMIENTO para estos roles
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->groupEnd();
        } else {
            // Solo mostrar REMISION para otros roles
            $builder->where('n.tipo_notificacion', 'REMISION');
        }
        
        $query = $builder->get();
        $result = $query->getRow();
        
        // Depuración
        log_message('debug', 'SQL Contar: ' . $db->getLastQuery());
        
        return $result->total ?? 0;
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarComoLeida($id_notificacion)
    {
        $builder = $this->dbconn('sgc_notificaciones');
        $builder->set('leida', true);
        $builder->where('id', $id_notificacion);
        $query = $builder->update();
        return $query;
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasComoLeidas($id_usuario)
    {
        $builder = $this->dbconn('sgc_notificaciones');
        $builder->set('leida', true);
        $builder->where('id_usuario_destino', $id_usuario);
        $query = $builder->update();
        return $query;
    }

    /**
     * Obtener usuarios por dirección administrativa
     */
    public function obtenerUsuariosPorDireccion($id_direccion)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_usuario_operador');
        $builder->select('idusuopr, idrol');
        $builder->where('id_direccion_administrativa', $id_direccion);
        $builder->where('usuopborrado', false);
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtener usuarios por roles específicos
     */
    public function obtenerUsuariosPorRoles($roles = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_usuario_operador');
        $builder->select('idusuopr, id_direccion_administrativa');
        $builder->whereIn('idrol', $roles);
        $builder->where('usuopborrado', false);
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Eliminar notificación
     */
    public function eliminarNotificacion($id_notificacion)
    {
        $builder = $this->dbconn('sgc_notificaciones');
        $builder->where('id', $id_notificacion);
        $query = $builder->delete();
        return $query;
    }

    /**
     * Obtener nombre de dirección administrativa por ID
     */
    public function obtenerNombreDireccion($id_direccion)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_direcciones_administrativas');
        $builder->select('descripcion');
        $builder->where('id', $id_direccion);
        $query = $builder->get();
        $row = $query->getRow();
        return $row ? $row->descripcion : 'Sin dirección';
    }
}

