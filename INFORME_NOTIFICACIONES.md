# INFORME DETALLADO DEL SISTEMA DE NOTIFICACIONES <!-- Bandeja de Notificaciones -->

## 1. RESUMEN EJECUTIVO

El sistema de notificaciones del SIAC (Sistema de Atención al Ciudadano) es un módulo completo que permite informar a los usuarios sobre eventos importantes relacionados con casos. El sistema notifica principalmente tres tipos de eventos:

- **REMISIÓN**: Cuando un caso es remitido a una dirección administrativa
- **SEGUIMIENTO**: Cuando se agrega un nuevo seguimiento a un caso
- **CAMBIO DE ESTATUS**: Cuando se actualiza el estatus de un caso

---

## 2. ARQUITECTURA DEL SISTEMA

### 2.1 Diagrama de Flujo General

```
┌─────────────────────────────────────────────────────────────────┐
│                    EVENTO TRIGGER                               │
│  (Remisión, Seguimiento, Cambio de Estatus)                     │
└─────────────────────┬───────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────────┐
│                  CONTROLADOR                                     │
│  (Casos_Controler, Seguimiento_Controler, Estatus)              │
└─────────────────────┬───────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────────┐
│                    MODELO                                        │
│              (Notificaciones_Model)                              │
└─────────────────────┬───────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────────┐
│                   BASE DE DATOS                                  │
│              (sgc_notificaciones)                                │
└─────────────────────┬───────────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────────┐
│               VISTA / FRONTEND                                   │
│        (nav_bar.php - Bandeja de Notificaciones)                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 3. CONTROLADORES INVOLUCRADOS

### 3.1 **Notificaciones_Controler.php**

Este es el controlador principal que maneja todas las operaciones CRUD de notificaciones.

**Ubicación**: `app/Controllers/Notificaciones_Controler.php`

**Métodos**:

| Método | Tipo | Descripción | Parámetros |
|--------|------|-------------|------------|
| `obtenerMisNotificaciones()` | GET | Recupera las notificaciones del usuario logueado | Ninguno |
| `contarNotificaciones()` | GET | Cuenta las notificaciones no leídas | Ninguno |
| `marcarLeida()` | POST | Marca una notificación específica como leída | `id_notificacion` |
| `marcarTodasLeidas()` | POST | Marca todas las notificaciones como leídas | Ninguno |
| `crearNotificacion()` | Público | Método helper para crear notificaciones | Array `$datos` |
| `obtenerNotificacionesAlerta()` | GET | Obtiene notificaciones para mostrar al inicio (SweetAlert) | Ninguno |

**Lógica de Filtrado por Roles**:

```php
// Roles que pueden ver seguimientos: 1, 3, 5
$roles_permitidos = [1, 3, 5];
$puede_ver_seguimientos = in_array($userrol, $roles_permitidos);

if ($puede_ver_seguimientos) {
    // Puede ver REMISION y SEGUIMIENTO
    $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos);
} else {
    // Solo puede ver REMISION
    $notificaciones = $model->obtenerNotificacionesPorUsuario($id_usuario, []);
}
```

---

### 3.2 **Casos_Controler.php**

Maneja las notificaciones cuando se remite un caso a otra dirección.

**Ubicación**: `app/Controllers/Casos_Controler.php`

**Método Principal**:

| Método | Tipo | Descripción | Trigger |
|--------|------|-------------|---------|
| `crearNotificacionRemision()` | Privado | Crea notificación de remisión de caso | Llamado desde `remitirCaso()` |

**Flujo de Ejecución**:

```php
public function remitirCaso() {
    // ... lógica de remisión ...
    
    // CREAR NOTIFICACIÓN DE REMISIÓN DE CASO
    $this->crearNotificacionRemision($datos["id_caso"], $datos["direccion"], $nombre_direccion["nombre_direccion"]);
}
```

**Proceso de Notificación de Remisión**:

1. Obtiene información del caso
2. Obtiene la dirección de origen (quien remite)
3. Construye el mensaje: `"Se le ha remitido el caso #ID de: Beneficiario a su dirección (nombre). Remitido por: Origen"`
4. Obtiene usuarios de la dirección destino
5. Crea una notificación para cada usuario de la dirección

---

### 3.3 **Seguimiento_Controler.php**

Maneja las notificaciones cuando se agrega un seguimiento a un caso.

**Ubicación**: `app/Controllers/Seguimiento_Controler.php`

**Método Principal**:

| Método | Tipo | Descripción | Trigger |
|--------|------|-------------|---------|
| `crearNotificacionSeguimiento()` | Privado | Crea notificación de nuevo seguimiento | Llamado desde `addSeguimiento()` |

**Flujo de Ejecución**:

```php
public function addSeguimiento() {
    // Inserta el seguimiento
    
    if (isset($query)) {
        // Crear notificación para usuarios con roles 1, 3, 5
        $this->crearNotificacionSeguimiento($datos["caseid"], $datos["segcomment"]);
        
        return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
    }
}
```

**Proceso de Notificación de Seguimiento**:

1. Obtiene información del caso
2. Obtiene la dirección del usuario que agrega el seguimiento
3. Construye el mensaje: `"Nuevo seguimiento en el caso #ID - Beneficiario. Agregado por: Dirección"`
4. Obtiene usuarios con roles 1, 3, 5
5. Crea una notificación para cada usuario con esos roles

---

### 3.4 **Estatus.php**

Maneja las notificaciones cuando se cambia el estatus de un caso.

**Ubicación**: `app/Controllers/Estatus.php`

**Método Principal**:

| Método | Tipo | Descripción | Trigger |
|--------|------|-------------|---------|
| `crearNotificacionCambioEstatus()` | Privado | Crea notificación de cambio de estatus | Llamado desde `cambioEstatus()` |

**Flujo de Ejecución**:

```php
public function cambioEstatus() {
    // Cambia el estatus del caso
    
    // Crear notificación para usuarios con roles 1, 3, 5
    $this->crearNotificacionCambioEstatus($datos["caseid"], $data['idest']);
}
```

**Proceso de Notificación de Cambio de Estatus**:

1. Obtiene información del caso y el nuevo estatus
2. Construye el mensaje: `"El caso #ID - Beneficiario fue actualizado al estatus: Estatus. Actualizado por: Dirección"`
3. Obtiene usuarios con roles 1, 3, 5
4. Crea una notificación para cada usuario
5. Incluye logging detallado en `/var/www/html/siac_v2/writable/logs/debug_notificaciones.log`

---

## 4. MODELOS INVOLUCRADOS

### 4.1 **Notificaciones_Model.php**

Modelo principal que interactúa con la tabla de notificaciones.

**Ubicación**: `app/Models/Notificaciones_Model.php`

**Métodos**:

| Método | Descripción | Retorna |
|--------|-------------|---------|
| `insertarNotificacion(array $datos)` | Inserta una nueva notificación | bool |
| `obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos)` | Recupera notificaciones filtradas por usuario y roles | Array de objetos |
| `obtenerNotificacionesNoLeidas($id_usuario)` | Obtiene solo las notificaciones no leídas | Array de objetos |
| `contarNoLeidas($id_usuario, $roles_permitidos)` | Cuenta las notificaciones no leídas | int |
| `marcarComoLeida($id_notificacion)` | Marca una notificación como leída | bool |
| `marcarTodasComoLeidas($id_usuario)` | Marca todas las notificaciones como leídas | bool |
| `obtenerUsuariosPorDireccion($id_direccion)` | Obtiene usuarios de una dirección administrativa | Array de objetos |
| `obtenerUsuariosPorRoles($roles)` | Obtiene usuarios por roles específicos | Array de objetos |
| `eliminarNotificacion($id_notificacion)` | Elimina una notificación | bool |
| `obtenerNombreDireccion($id_direccion)` | Obtiene el nombre de una dirección administrativa | string |

**Consultas SQL Principales**:

```php
// Obtener notificaciones por usuario (con filtrado por tipo)
public function obtenerNotificacionesPorUsuario($id_usuario, $roles_permitidos = [])
{
    $builder->select('n.*');
    $builder->select('dir_origen.descripcion as direccion_origen_nombre');
    
    if (!empty($roles_permitidos)) {
        // Puede ver REMISION y SEGUIMIENTO
        $builder->groupStart();
        $builder->where('n.tipo_notificacion', 'REMISION');
        $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
        $builder->groupEnd();
    } else {
        // Solo puede ver REMISION
        $builder->where('n.tipo_notificacion', 'REMISION');
    }
    
    $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
    $builder->where('n.id_usuario_destino', $id_usuario);
    $builder->orderBy('n.fecha_creacion', 'DESC');
    $builder->limit(50);
}

// Contar notificaciones no leídas
public function contarNoLeidas($id_usuario, $roles_permitidos = [])
{
    $builder->selectCount('n.id', 'total');
    $builder->where('n.id_usuario_destino', $id_usuario);
    $builder->where('n.leida', false);
    
    if (!empty($roles_permitidos)) {
        $builder->groupStart();
        $builder->where('n.tipo_notificacion', 'REMISION');
        $builder->orWhere('n.tipo_notificacion', 'SEGUIMIENTO');
        $builder->groupEnd();
    } else {
        $builder->where('n.tipo_notificacion', 'REMISION');
    }
}
```

---

## 5. ESTRUCTURA DE LA BASE DE DATOS

### 5.1 Tabla: `sgc_notificaciones`

**Ubicación**: `DB_Sala_situacional/sgc_notificaciones.sql`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | Identificador único de la notificación |
| `id_caso` | int | ID del caso relacionado |
| `tipo_notificacion` | varchar(20) | Tipo: REMISION, SEGUIMIENTO |
| `mensaje` | text | Contenido de la notificación |
| `leida` | boolean | Estado de lectura |
| `fecha_creacion` | datetime | Fecha de creación |
| `id_usuario_destino` | int | Usuario que recibe la notificación |
| `direccion_origen` | int | Dirección que origina la notificación |

---

## 6. INTERFAZ DE USUARIO (FRONTEND)

### 6.1 **nav_bar.php**

**Ubicación**: `app/Views/template/nav_bar.php`

**Componentes Visuales**:

1. **Icono de Campana**: Muestra el ícono de campana con badge de contador
2. **Menú Desplegable**: Lista de notificaciones con scroll
3. **Botón "Marcar todas como leídas"**
4. **Elementos de Notificación**: Muestran tipo, mensaje y fecha

**Funciones JavaScript**:

| Función | Descripción |
|---------|-------------|
| `toggleNotifications()` | Muestra/oculta el dropdown de notificaciones |
| `cargarNotificaciones()` | Obtiene notificaciones del servidor |
| `renderNotificaciones(notificaciones)` | Renderiza las notificaciones en el DOM |
| `actualizarContador()` | Actualiza el badge del contador |
| `verNotificacion(id, tipo, idCaso)` | Maneja el clic en una notificación |
| `marcarTodasLeidas()` | Envía solicitud para marcar todas como leídas |
| `formatDate(dateString)` | Formatea la fecha relativa |
| `mostrarAlertaNotificaciones()` | Muestra alerta automática al cargar |

**Flujo de Interacción**:

```
Usuario hace clic en campana
    │
    ▼
toggleNotifications()
    │
    ▼
cargarNotificaciones()
    │
    ▼
fetch('/notificaciones/obtenerMisNotificaciones')
    │
    ▼
renderNotificaciones(data.data)
    │
    ▼
Mostrar notificaciones en dropdown
```

---

## 7. RUTAS DE LA API

**Ubicación**: `app/Config/Routes.php`

```php
// Obtener notificaciones del usuario
$routes->get('/notificaciones/obtenerMisNotificaciones', 'Notificaciones_Controler::obtenerMisNotificaciones');

// Contar notificaciones
$routes->get('/notificaciones/contarNotificaciones', 'Notificaciones_Controler::contarNotificaciones');

// Marcar una como leída
$routes->post('/notificaciones/marcarLeida', 'Notificaciones_Controler::marcarLeida');

// Marcar todas como leídas
$routes->post('/notificaciones/marcarTodasLeidas', 'Notificaciones_Controler::marcarTodasLeidas');
```

---

## 8. PERMISOS Y ROLES

### 8.1 Roles que pueden ver seguimientos: **1, 3, 5**

- **Rol 1**: Administrador
- **Rol 3**: Supervisor/Analista
- **Rol 5**: Gerente

### 8.2 Permisos por Rol

| Rol | Notificaciones visibles |
|-----|------------------------|
| 1, 3, 5 | REMISION + SEGUIMIENTO |
| 2, 4, 10 | Solo REMISION |

---

## 9. MEJORES PRÁCTICAS OBSERVADAS

1. **Control de Acceso por Sesión**: Todos los endpoints verifican `$this->session->get('logged')`

2. **Validación de Roles**: Se filtran las notificaciones según el rol del usuario

3. **Auditoría**: Se registra en logs cada operación crítica

4. **Control de Concurrencia**: Uso de transacciones para operaciones múltiples

5. **Sanitización**: Uso de `base64_decode()` y validación de datos

---

## 10. ARCHIVOS RELACIONADOS

| Archivo | Tipo | Descripción |
|---------|------|-------------|
| `app/Controllers/Notificaciones_Controler.php` | Controlador | Controlador principal de notificaciones |
| `app/Models/Notificaciones_Model.php` | Modelo | Modelo de notificaciones |
| `app/Controllers/Casos_Controler.php` | Controlador | Remisión de casos |
| `app/Controllers/Seguimiento_Controler.php` | Controlador | Seguimientos de casos |
| `app/Controllers/Estatus.php` | Controlador | Cambio de estatus |
| `app/Views/template/nav_bar.php` | Vista | Interfaz de usuario |
| `app/Config/Routes.php` | Configuración | Rutas de la API |
| `DB_Sala_situacional/sgc_notificaciones.sql` | SQL | Estructura de la tabla |

---

## 11. DIAGRAMA DE SECUENCIA - REMISIÓN DE CASO

```
┌─────────┐     ┌──────────────┐     ┌─────────────────────┐     ┌──────────────────┐
│ Usuario │     │Casos_Control │     │Notificaciones_Model │     │Base de Datos     │
└────┬────┘     └───────┬──────┘     └──────────┬──────────┘     └────────┬─────────┘
     │                  │                       │                        │
     │ remitirCaso()    │                       │                        │
     │─────────────────>│                       │                        │
     │                  │                       │                        │
     │                  │ crearNotificacionRem()│                        │
     │                  │──────────────────────>│                        │
     │                  │                       │                        │
     │                  │                       │ insertarNotificacion() │
     │                  │                       │────────────────────────>
     │                  │                       │                        │
     │                  │                       │                        INSERT
     │                  │                       │<────────────────────────
     │                  │                       │                        │
     │                  │    return true        │                        │
     │                  │<──────────────────────│                        │
     │                  │                       │                        │
     │   return json    │                       │                        │
     │<─────────────────│                       │                        │
     │                  │                       │                        │
```

---

## 12. CONCLUSIÓN

El sistema de notificaciones del SIAC es un módulo robusto y bien estructurado que:

1. **Separa responsabilidades** entre controladores, modelos y vistas
2. **Implementa control de acceso** basado en roles de usuario
3. **Proporciona feedback visual** al usuario mediante badges y dropdowns
4. **Mantiene trazabilidad** mediante logs de auditoría
5. **Es escalable** para agregar nuevos tipos de notificaciones

---

*Informe generado el: 2024*
*Versión del Sistema: SIAC v2*

