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
        
        if (!$query) {
            log_message('error', 'Error al insertar notificacion: ' . json_encode($datos));
        } else {
            log_message('debug', 'Notificacion insertada correctamente: ' . json_encode($datos));
        }
        
        return $query;
    }

    /**
     * Obtener notificaciones por usuario con filtros de visualizacion segun rol
     * 
     * Reglas de Visualizacion:
     * - Roles 1, 3, 5 (Supervision): Ver registros donde id_usuario_destino sea el usuario actual 
     *   Y id_usuario_accion sea diferente al usuario actual. Ademas, EXCLUIR registros donde 
     *   id_rol_accion == 2 Y tipo_notificacion == 'CIERRE'.
     * - Rol 2 (Autor): Ver registros donde id_caso_autor sea el usuario actual 
     *   Y id_usuario_accion sea diferente al usuario actual.
     * - Rol 10: Ver registros donde id_usuario_destino sea el usuario actual.
     */
    public function obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        
        // JOIN con usuario operador para verificar rol del autor del caso
        $builder->join('sgc_usuario_operador autor_caso', 'n.id_caso_autor = autor_caso.idusuopr', 'left');
        
        // JOIN con usuario operador para verificar rol del usuario que realiza la accion
        $builder->join('sgc_usuario_operador usuario_accion', 'n.id_usuario_accion = usuario_accion.idusuopr', 'left');
        
        $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
        
        // Determinar el rol del usuario (usar parametro o sesion)
        $rol_usuario = $userrol ?? ($this->session->get('userrol') ?? 0);
        $direccion_usuario = $id_direccion_usuario ?? ($this->session->get('id_direccion_administrativa') ?? 0);
        
        $es_supervision = in_array($rol_usuario, [1, 3, 5]);
        $es_rol2 = ($rol_usuario == 2);
        $es_rol10 = ($rol_usuario == 10);
        
        // APLICAR REGLAS DE VISUALIZACION
        if ($es_supervision) {
            // === ROLES 1, 3, 5: SUPERVISION ===
            
            // Excluir autoacciones: el usuario no ve notificaciones de sus propias acciones
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            // REGLA CLAVE: Excluir registros donde id_rol_accion == 2 Y tipo_notificacion == 'CIERRE'
            // Los supervisores ignoran los cierres automaticos de los Analistas (Rol 2)
            $builder->groupStart();
            $builder->where("NOT (n.id_rol_accion = 2 AND n.tipo_notificacion = 'CIERRE')", null, false);
            $builder->groupEnd();
            
            // Supervision puede ver REMISION, SEGUIMIENTO Y CIERRE (excepto cierres de Rol 2)
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->orWhere('n.tipo_notificacion', 'CIERRE');
                $builder->groupEnd();
            } else {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->orWhere('n.tipo_notificacion', 'CIERRE');
                $builder->groupEnd();
            }
            
        } elseif ($es_rol2) {
            // === ROL 2: AUTOR DEL CASO ===
            
            // Ver seguimientos, remisiones Y cierres de casos que EL creo
            // Esto requiere que n.id_caso_autor coincida con el usuario
            $builder->where('c.idusuopr', $id_usuario);
            
            // Excluir sus propias acciones
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            // Ver seguimientos, remisiones Y cierres
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->orWhere('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'CIERRE');
            $builder->groupEnd();
            
        } elseif ($es_rol10) {
            // === ROL 10: DIRECCION ===
            
            // Ver notificaciones donde es destinatario directo
            // Solo ver remisiones Y seguimientos de casos asignados a su direccion
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
            
        } else {
            // === OTRAS DIRECCIONES ===
            
            // Solo ver notificaciones donde es destinatario
            // Solo ver remisiones a su direccion (y seguimientos de casos asignados)
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
        }
        
        // Filtro comun: solo notificaciones del usuario destinatario
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $builder->limit(50);
        
        $query = $builder->get();
        $result = $query->getResult();
        
        log_message('debug', 'SQL Notificaciones: ' . $db->getLastQuery());
        log_message('debug', 'Notificaciones encontradas para usuario ' . $id_usuario . ' (Rol ' . $rol_usuario . '): ' . count($result));
        
        return $result;
    }

    /**
     * Contar notificaciones no leidas con filtros de visualizacion segun rol
     * 
     * Reglas de Visualizacion:
     * - Roles 1, 3, 5 (Supervision): Excluir autoacciones Y Excluir id_rol_accion == 2 Y tipo_notificacion == 'CIERRE'
     * - Rol 2 (Autor): Ver seguimientos/remisiones/cierres de sus casos, excluir autoacciones
     * - Rol 10: Ver notificaciones donde es destinatario
     */
    public function contarNoLeidas($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->selectCount('n.id', 'total');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->where('n.leida', false);
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        
        // Determinar el rol del usuario
        $rol_usuario = $userrol ?? ($this->session->get('userrol') ?? 0);
        $es_supervision = in_array($rol_usuario, [1, 3, 5]);
        $es_rol2 = ($rol_usuario == 2);
        $es_rol10 = ($rol_usuario == 10);
        
        if ($es_supervision) {
            // Roles 1, 3, 5: Excluir autoacciones
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            // REGLA CLAVE: Excluir registros donde id_rol_accion == 2 Y tipo_notificacion == 'CIERRE'
            $builder->groupStart();
            $builder->where("NOT (n.id_rol_accion = 2 AND n.tipo_notificacion = 'CIERRE')", null, false);
            $builder->groupEnd();
            
            // Supervision puede ver REMISION, SEGUIMIENTO Y CIERRE
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->orWhere('n.tipo_notificacion', 'CIERRE');
                $builder->groupEnd();
            } else {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->orWhere('n.tipo_notificacion', 'CIERRE');
                $builder->groupEnd();
            }
            
        } elseif ($es_rol2) {
            // === ROL 2: AUTOR DEL CASO ===
            
            // Ver seguimientos, remisiones Y cierres de sus casos
            $builder->where('c.idusuopr', $id_usuario);
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            // Ver seguimientos, remisiones Y cierres
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->orWhere('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'CIERRE');
            $builder->groupEnd();
            
        } elseif ($es_rol10) {
            // Rol 10: Ver notificaciones donde es destinatario
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
            
        } else {
            // Otras direcciones
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
        }
        
        $query = $builder->get();
        $result = $query->getRow();
        
        log_message('debug', 'Count NoLeidas para usuario ' . $id_usuario . ' (Rol ' . $rol_usuario . '): ' . ($result->total ?? 0));
        
        return $result->total ?? 0;
    }

    /**
     * Obtener notificaciones no leidas por usuario (para alertas)
     */
    public function obtenerNotificacionesNoLeidas($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null)
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
     * Verificar si un caso fue cerrado por un usuario con Rol 2
     */
    public function verificarCierrePorRol2($id_caso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_seguimiento_caso s');
        $builder->select('s.idusuopr, u.idrol');
        $builder->join('sgc_usuario_operador u', 's.idusuopr = u.idusuopr');
        $builder->where('s.idcaso', $id_caso);
        $builder->where('s.idestllam', 2); // Estatus de cierre
        $builder->orderBy('s.idsegcas', 'DESC');
        $builder->limit(1);
        
        $query = $builder->get();
        $result = $query->getRow();
        
        return ($result && $result->idrol == 2);
    }

    /**
     * Obtener usuario por ID
     */
    public function obtenerUsuarioPorId($idusuopr)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_usuario_operador');
        $builder->select('idusuopr, idrol, id_direccion_administrativa');
        $builder->where('idusuopr', $idusuopr);
        $builder->where('usuopborrado', false);
        
        $query = $builder->get();
        return $query->getRow();
    }

    /**
     * Marcar notificacion como leida
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
     * Marcar todas las notificaciones como leidas
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
     * Obtener usuarios por direccion administrativa
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
     * Obtener usuarios por roles especificos
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
     * Eliminar notificacion
     */
    public function eliminarNotificacion($id_notificacion)
    {
        $builder = $this->dbconn('sgc_notificaciones');
        $builder->where('id', $id_notificacion);
        $query = $builder->delete();
        return $query;
    }

    /**
     * Obtener nombre de direccion administrativa por ID
     */
    public function obtenerNombreDireccion($id_direccion)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_direcciones_administrativas');
        $builder->select('descripcion');
        $builder->where('id', $id_direccion);
        $query = $builder->get();
        $row = $query->getRow();
        return $row ? $row->descripcion : 'Sin direccion';
    }

    /**
     * Obtener informacion completa del caso para notificaciones
     */
    public function obtenerInfoCaso($id_caso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_casos c');
        $builder->select('c.idcaso, c.idusuopr, CONCAT(c.casonom, \' \', c.casoape) as nombre');
        $builder->select('c.idest, e.estnom');
        $builder->join('sgc_estatus e', 'c.idest = e.idest', 'left');
        $builder->where('c.idcaso', $id_caso);
        $builder->where('c.borrado', false);
        
        $query = $builder->get();
        return $query->getRow();
    }
}
