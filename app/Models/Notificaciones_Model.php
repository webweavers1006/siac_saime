<?php

namespace App\Models;

class Notificaciones_Model extends BaseModel
{
    // Roles que NO deben ver notificaciones
    private $roles_bloqueados = [4, 6, 9];

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
    public function obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null, $pagina = 1, $por_pagina = 10)
    {
        // Verificar si el rol está bloqueado de ver notificaciones
        if (in_array($userrol, $this->roles_bloqueados)) {
            return [
                'data' => [],
                'total' => 0,
                'pagina' => $pagina,
                'por_pagina' => $por_pagina,
                'total_paginas' => 0
            ];
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        // FILTRO: Solo mostrar notificaciones de casos NO borrados
        $builder->where('c.borrado', false);
        
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
            // === ROL 10: DIRECCIÓN ===
            
            // Ver notificaciones donde es destinatario directo
            // Cuando roles_permitidos contiene 10, permitir ver REMISION Y SEGUIMIENTO
            // Esto permite que el Rol 10 vea seguimientos de casos en su dirección
            if (!empty($roles_permitidos) && in_array(10, $roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                // Comportamiento por defecto: solo remisiones (compatibilidad hacia atrás)
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
        
        // Contar total para paginación
        $total = $builder->countAllResults(false);
        
        // Aplicar orden DESC (más recientes primero) y paginación
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $offset = ($pagina - 1) * $por_pagina;
        $builder->limit($por_pagina, $offset);
        
        $query = $builder->get();
        $result = $query->getResult();
        
        log_message('debug', 'SQL Notificaciones: ' . $db->getLastQuery());
        log_message('debug', 'Notificaciones encontradas para usuario ' . $id_usuario . ' (Rol ' . $rol_usuario . '): ' . count($result));
        
        return [
            'data' => $result,
            'total' => $total,
            'pagina' => $pagina,
            'por_pagina' => $por_pagina,
            'total_paginas' => ceil($total / $por_pagina)
        ];
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
        // Verificar si el rol está bloqueado de ver notificaciones
        if (in_array($userrol, $this->roles_bloqueados)) {
            return 0;
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->selectCount('n.id', 'total');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->where('n.leida', false);
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        // FILTRO: Solo contar notificaciones de casos NO borrados
        $builder->where('c.borrado', false);
        
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
        // Verificar si el rol está bloqueado de ver notificaciones
        if (in_array($userrol, $this->roles_bloqueados)) {
            return [];
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*, c.casonom, c.casoape');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        // FILTRO: Solo mostrar notificaciones de casos NO borrados
        $builder->where('c.borrado', false);
        $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
        $builder->where('n.id_usuario_destino', $id_usuario);
        $builder->where('n.leida', false);
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtener TODAS las notificaciones (leidas y no leidas) por usuario
     */
    public function obtenerTodasLasNotificaciones($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null, $pagina = 1, $por_pagina = 10)
    {
        // Verificar si el rol está bloqueado de ver notificaciones
        if (in_array($userrol, $this->roles_bloqueados)) {
            return [
                'data' => [],
                'total' => 0,
                'pagina' => $pagina,
                'por_pagina' => $por_pagina,
                'total_paginas' => 0
            ];
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->select('n.*');
        $builder->select('dir_origen.descripcion as direccion_origen_nombre');
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        // FILTRO: Solo mostrar notificaciones de casos NO borrados
        $builder->where('c.borrado', false);
        
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
        
        // APLICAR REGLAS DE VISUALIZACION (igual que en obtenerNotificacionesPorUsuario)
        if ($es_supervision) {
            // === ROLES 1, 3, 5: SUPERVISION ===
            
            // Excluir autoacciones: el usuario no ve notificaciones de sus propias acciones
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
            
            $builder->where('c.idusuopr', $id_usuario);
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->orWhere('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'CIERRE');
            $builder->groupEnd();
            
        } elseif ($es_rol10) {
            // === ROL 10: DIRECCION ===
            
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
            
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
        }
        
        // Filtro comun: solo notificaciones del usuario destinatario (SIN filtrar por leida)
        $builder->where('n.id_usuario_destino', $id_usuario);
        
        // Contar total para paginación
        $total = $builder->countAllResults(false);
        
        // Aplicar orden y paginación
        $builder->orderBy('n.fecha_creacion', 'DESC');
        $offset = ($pagina - 1) * $por_pagina;
        $builder->limit($por_pagina, $offset);
        
        $query = $builder->get();
        $result = $query->getResult();
        
        log_message('debug', 'SQL Todas Notificaciones: ' . $db->getLastQuery());
        log_message('debug', 'Notificaciones para usuario ' . $id_usuario . ' (Pag ' . $pagina . '/' . ceil($total / $por_pagina) . '): ' . count($result));
        
        return [
            'data' => $result,
            'total' => $total,
            'pagina' => $pagina,
            'por_pagina' => $por_pagina,
            'total_paginas' => ceil($total / $por_pagina)
        ];
    }

    /**
     * Contar todas las notificaciones (leídas y no leídas)
     */
    public function contarTodasLasNotificaciones($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null)
    {
        // Verificar si el rol está bloqueado de ver notificaciones
        if (in_array($userrol, $this->roles_bloqueados)) {
            return 0;
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('sgc_notificaciones n');
        $builder->selectCount('n.id', 'total');
        
        // JOIN con casos para verificar autoria
        $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
        // FILTRO: Solo contar notificaciones de casos NO borrados
        $builder->where('c.borrado', false);
        
        // Determinar el rol del usuario
        $rol_usuario = $userrol ?? ($this->session->get('userrol') ?? 0);
        $es_supervision = in_array($rol_usuario, [1, 3, 5]);
        $es_rol2 = ($rol_usuario == 2);
        $es_rol10 = ($rol_usuario == 10);
        
        if ($es_supervision) {
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            $builder->groupStart();
            $builder->where("NOT (n.id_rol_accion = 2 AND n.tipo_notificacion = 'CIERRE')", null, false);
            $builder->groupEnd();
            
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
            $builder->where('c.idusuopr', $id_usuario);
            $builder->where('n.id_usuario_accion !=', $id_usuario);
            
            $builder->groupStart();
            $builder->where('n.tipo_notificacion', 'SEGUIMIENTO');
            $builder->orWhere('n.tipo_notificacion', 'REMISION');
            $builder->orWhere('n.tipo_notificacion', 'CIERRE');
            $builder->groupEnd();
        } elseif ($es_rol10) {
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
        } else {
            if (!empty($roles_permitidos)) {
                $builder->groupStart();
                $builder->where('n.tipo_notificacion', 'REMISION');
                $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
                $builder->groupEnd();
            } else {
                $builder->where('n.tipo_notificacion', 'REMISION');
            }
        }
        
        $builder->where('n.id_usuario_destino', $id_usuario);
        
        $query = $builder->get();
        $result = $query->getRow();
        
        return $result->total ?? 0;
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

