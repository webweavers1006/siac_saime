# PLAN DE IMPLEMENTACIÓN: REGLAS DE VISUALIZACIÓN - BANDEJA DE NOTIFICACIONES

## Objetivo
Implementar las reglas de visualización de notificaciones según los roles de usuario, optimizado para PHP 8.4.

## Reglas de Negocio

### 1. Roles de Supervisión (Roles 1, 3, 5)
- **Visibilidad**: Seguimientos, remisiones o cierres realizados por otras direcciones
- **Restricciones**:
  - ❌ No visualizar casos cerrados por ellos mismos (autocierre)
  - ❌ No visualizar casos cerrados por usuarios con Rol 2

### 2. Rol de Autoría (Rol 2)
- **Trazabilidad**: Ver todos los seguimientos y acciones que otras direcciones realicen sobre casos creados por él
- **Ejemplo**: Si Rol 2 crea el "Caso A" y lo remite a la "Dirección X", cuando "Dirección X" agregue un avance, el Rol 2 recibirá la notificación

### 3. Roles de Destino (Otras Direcciones)
- **Visibilidad operativa**: Basada en la ubicación actual del expediente
- **Casos Asignados**: Solo ven casos que han sido remitidos a su dirección específica
- **Historial Local**: Acceso a los seguimientos generados mientras el caso esté bajo su cargo

---

## Cambios por Archivo

### A. `app/Models/Notificaciones_Model.php`

#### 1. Modificar `obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos)`
```php
public function obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos = [])
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_notificaciones n');
    $builder->select('n.*');
    $builder->select('dir_origen.descripcion as direccion_origen_nombre');
    $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
    
    // JOIN con casos para verificar autoría y cierres
    $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
    
    // Determinar el rol del usuario
    $esSupervision = in_array($this->session->get('userrol'), [1, 3, 5]);
    $esRol2 = $this->session->get('userrol') == 2;
    $id_direccion_usuario = $this->session->get('id_direccion_administrativa');
    
    if ($esSupervision) {
        // ROLES 1, 3, 5: Supervisión
        // Excluir autoacciones (el usuario no ve sus propias acciones)
        $builder->where('n.id_usuario_accion !=', $id_usuario);
        
        // Excluir cierres por Rol 2 (si el caso fue cerrado por Rol 2)
        // Nota: Esto requiere verificar el estatus del caso en el momento de la notificación
        // Se implementa verificando el seguimiento de cierre
        
        $builder->groupStart();
        $builder->where('n.tipo_notificacion', 'REMISION');
        $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
        $builder->groupEnd();
        
    } elseif ($esRol2) {
        // ROL 2: Autor del caso
        // Ver seguimientos/remisiones de casos que ÉL creó
        $builder->where('c.idusuopr', $id_usuario); // El usuario es el autor del caso
        
        // Excluir sus propias acciones
        $builder->where('n.id_usuario_accion !=', $id_usuario);
        
    } else {
        // OTRAS DIRECCIONES: Solo casos asignados a su dirección
        // Nota: La notificación ya se crea con id_usuario_destino específico
        // Solo filtramos por el destinatario
    }
    
    $builder->where('n.id_usuario_destino', $id_usuario);
    $builder->orderBy('n.fecha_creacion', 'DESC');
    $builder->limit(50);
    
    $query = $builder->get();
    return $query->getResult();
}
```

#### 2. Modificar `contarNoLeidas($id_usuario, $roles_permitidos)`
Aplicar la misma lógica de filtros que `obtenerNotificacionesPorUsuario()`.

#### 3. Agregar método `verificarCierrePorRol2($id_caso)`
```php
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
```

---

### B. `app/Controllers/Casos_Controler.php`

#### Modificar `crearNotificacionRemision($id_caso, $direccion_id, $nombre_direccion)`
```php
private function crearNotificacionRemision($id_caso, $direccion_id, $nombre_direccion)
{
    $notifModel = new Notificaciones_Model();
    $casoModel = new Casos();
    
    // Obtener información del caso
    $caso = $casoModel->obtenerCaso_id($id_caso);
    if (!$caso) return;
    
    // Datos del usuario actual (quien remite)
    $idusuopr_actual = $this->session->get('iduser');
    $id_rol_actual = $this->session->get('userrol');
    $direccion_origen_id = $this->session->get('id_direccion_administrativa');
    $nombre_direccion_origen = $notifModel->obtenerNombreDireccion($direccion_origen_id);
    
    // Autor original del caso
    $id_caso_autor = $caso->idusuopr;
    
    // Mensaje
    $nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;
    $mensaje = "Se le ha remitido el caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " a su dirección (" . $nombre_direccion . "). Remitido por: " . $nombre_direccion_origen;
    
    // 1. Notificar a usuarios de la dirección DESTINO
    $usuarios_direccion = $notifModel->obtenerUsuariosPorDireccion($direccion_id);
    foreach ($usuarios_direccion as $usuario) {
        $notifModel->insertarNotificacion([
            "id_caso" => $id_caso,
            "tipo_notificacion" => "REMISION",
            "mensaje" => $mensaje,
            "leida" => false,
            "fecha_creacion" => date('Y-m-d H:i:s'),
            "id_usuario_destino" => $usuario->idusuopr,
            "direccion_origen" => $direccion_origen_id,
            "id_usuario_accion" => $idusuopr_actual,
            "id_rol_accion" => $id_rol_actual,
            "id_caso_autor" => $id_caso_autor
        ]);
    }
    
    // 2. Notificar al AUTOR ORIGINAL del caso (Rol 2)
    // Solo si el autor es diferente de quien remite
    if ($id_caso_autor != $idusuopr_actual) {
        // Verificar si el autor tiene Rol 2
        $autor = $notifModel->obtenerUsuarioPorId($id_caso_autor);
        if ($autor && $autor->idrol == 2) {
            $notifModel->insertarNotificacion([
                "id_caso" => $id_caso,
                "tipo_notificacion" => "REMISION",
                "mensaje" => "Su caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " ha sido remitido a la dirección: " . $nombre_direccion . ". Remitido por: " . $nombre_direccion_origen,
                "leida" => false,
                "fecha_creacion" => date('Y-m-d H:i:s'),
                "id_usuario_destino" => $id_caso_autor,
                "direccion_origen" => $direccion_origen_id,
                "id_usuario_accion" => $idusuopr_actual,
                "id_rol_accion" => $id_rol_actual,
                "id_caso_autor" => $id_caso_autor
            ]);
        }
    }
}
```

---

### C. `app/Controllers/Seguimiento_Controler.php`

#### Modificar `crearNotificacionSeguimiento($id_caso, $comentario)`
```php
private function crearNotificacionSeguimiento($id_caso, $comentario)
{
    $notifModel = new Notificaciones_Model();
    $casoModel = new \App\Models\Casos();
    
    // Obtener información del caso
    $caso = $casoModel->obtenerCaso_id($id_caso);
    if (!$caso) return;
    
    // Datos del usuario actual (quien agrega seguimiento)
    $idusuopr_actual = $this->session->get('iduser');
    $id_rol_actual = $this->session->get('userrol');
    $direccion_usuario_id = $this->session->get('id_direccion_administrativa');
    $nombre_direccion_usuario = $notifModel->obtenerNombreDireccion($direccion_usuario_id);
    
    // Autor original del caso
    $id_caso_autor = $caso->idusuopr;
    
    $nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;
    $mensaje = "Nuevo seguimiento en el caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . ". Agregado por: " . $nombre_direccion_usuario;
    
    // 1. Notificar a Roles de Supervisión (1, 3, 5)
    $usuarios_supervision = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);
    foreach ($usuarios_supervision as $usuario) {
        // Excluir auto-notificación
        if ($usuario->idusuopr != $idusuopr_actual) {
            $notifModel->insertarNotificacion([
                "id_caso" => $id_caso,
                "tipo_notificacion" => "SEGUIMIENTO",
                "mensaje" => $mensaje,
                "leida" => false,
                "fecha_creacion" => date('Y-m-d H:i:s'),
                "id_usuario_destino" => $usuario->idusuopr,
                "direccion_origen" => $direccion_usuario_id,
                "id_usuario_accion" => $idusuopr_actual,
                "id_rol_accion" => $id_rol_actual,
                "id_caso_autor" => $id_caso_autor
            ]);
        }
    }
    
    // 2. Notificar al AUTOR ORIGINAL del caso (Rol 2)
    // Solo si el autor es diferente de quien agrega el seguimiento
    if ($id_caso_autor != $idusuopr_actual) {
        $autor = $notifModel->obtenerUsuarioPorId($id_caso_autor);
        if ($autor && $autor->idrol == 2) {
            $notifModel->insertarNotificacion([
                "id_caso" => $id_caso,
                "tipo_notificacion" => "SEGUIMIENTO",
                "mensaje" => "Nuevo avance en su caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . ". Agregado por: " . $nombre_direccion_usuario,
                "leida" => false,
                "fecha_creacion" => date('Y-m-d H:i:s'),
                "id_usuario_destino" => $id_caso_autor,
                "direccion_origen" => $direccion_usuario_id,
                "id_usuario_accion" => $idusuopr_actual,
                "id_rol_accion" => $id_rol_actual,
                "id_caso_autor" => $id_caso_autor
            ]);
        }
    }
}
```

---

### D. `app/Controllers/Estatus.php`

#### Modificar `crearNotificacionCambioEstatus($id_caso, $nuevo_estatus)`
Aplicar la misma lógica que en `crearNotificacionSeguimiento()`.

---

### E. `app/Controllers/Notificaciones_Controler.php`

#### Modificar `obtenerMisNotificaciones()`
```php
public function obtenerMisNotificaciones()
{
    if ($this->session->get('logged')) {
        $model = new Notificaciones_Model();
        $id_usuario = $this->session->get('iduser');
        $userrol = $this->session->get('userrol');
        
        // Roles que pueden ver seguimientos: 1, 3, 5
        $roles_supervision = [1, 3, 5];
        $es_supervision = in_array($userrol, $roles_supervision);
        $es_rol2 = ($userrol == 2);
        
        if ($es_supervision) {
            // Roles 1, 3, 5: Ver seguimientos y remisiones de otros
            $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, $roles_supervision);
        } elseif ($es_rol2) {
            // Rol 2: Ver seguimientos de sus casos
            $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, [2]);
        } else {
            // Otras direcciones: Solo remisiones a su dirección
            $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, []);
        }
        
        return $this->respond([
            "message" => "success",
            "data" => $notificaciones
        ], 200);
    }
}
```

---

## Resumen de Cambios

| Archivo | Cambios |
|---------|---------|
| `Notificaciones_Model.php` | Modificar `obtenerNotificacionesPorUsuario()`, `contarNoLeidas()`, agregar `verificarCierrePorRol2()` |
| `Casos_Controler.php` | Modificar `crearNotificacionRemision()` con nuevos campos y lógica de autoría |
| `Seguimiento_Controler.php` | Modificar `crearNotificacionSeguimiento()` con nuevos campos y lógica de autoría |
| `Estatus.php` | Modificar `crearNotificacionCambioEstatus()` con nueva lógica |
| `Notificaciones_Controler.php` | Modificar lógica de filtros por rol |

---

## Dependencias
- Tabla `sgc_notificaciones` con campos: `id_usuario_accion`, `id_rol_accion`, `id_caso_autor`

## Fecha de creación: $(date)
## Estado: PENDIENTE DE APROBACIÓN

