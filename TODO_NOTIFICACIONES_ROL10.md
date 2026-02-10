# Plan de Implementación: Notificaciones de Seguimiento para Rol 10

## Objetivo
Habilitar que usuarios con Rol 10 (Dirección) reciban notificaciones de seguimientos agregados a casos que fueron remitidos a su dirección administrativa.

## Cambios Realizados ✅

### 1. Modificado `app/Controllers/Seguimiento_Controler.php`
**Objetivo**: Notificar a usuarios de la dirección administrativa del caso cuando se agrega un seguimiento

**Cambios realizados**:
- En el método `crearNotificacionSeguimiento()`:
  - Se obtiene la dirección administrativa del caso (`id_direccion_caso`)
  - Se compara con la dirección del usuario actual para verificar si son diferentes
  - Se obtiene la lista de usuarios de la dirección del caso
  - Se envía notificación a cada usuario (evitando duplicados con quienes ya fueron notificados como supervisor o autor)
  - Se agregaron logs de depuración para rastrear las notificaciones

### 2. Modificado `app/Controllers/Notificaciones_Controler.php`
**Objetivo**: Corregir lógica de consulta para Rol 10

**Cambios realizados**:
- En `obtenerMisNotificaciones()`: Agregada condición `elseif ($es_rol10)` que pasa `[10]` como roles_permitidos
- En `contarNotificaciones()`: Agregada condición `elseif ($es_rol10)` que pasa `[10]` como roles_permitidos
- En `obtenerTodasMisNotificaciones()`: Agregada condición `elseif ($es_rol10)` que pasa `[10]` como roles_permitidos
- Se agregaron logs de depuración para identificar cuando es Rol 10

### 3. Modificado `app/Models/Notificaciones_Model.php`
**Objetivo**: Asegurar que la consulta permita ver seguimientos para Rol 10

**Cambios realizados**:
- En el método `obtenerNotificacionesPorUsuario()`:
  - Modificada la condición para Rol 10: ahora verifica `if (!empty($roles_permitidos) && in_array(10, $roles_permitidos))`
  - Cuando roles_permitidos contiene 10, permite ver REMISION Y SEGUIMIENTO
  - Cuando está vacío, mantiene el comportamiento original (solo REMISION)

### 4. Modificado `app/Models/Casos.php`
**Objetivo**: Obtener la dirección administrativa del caso para las notificaciones

**Cambios realizados**:
- En el método `obtenerCaso_id()`:
  - Agregado JOIN con `sgc_casos_remitidos` para obtener la dirección de remisión
  - Agregado campo `id_direccion_administrativa` que usa COALESCE:
    - Si el caso fue remitido y tiene vigencia, usa `cr.direccion_id`
    - Si no, usa la dirección del usuario operador original (`u_ope.id_direccion_administrativa`)

## Flujo de Notificaciones (Después de los cambios)

1. **Se agrega un seguimiento a un caso**:
   - Se notifica a Roles de Supervisión (1, 3, 5) - GLOBAL
   - Se notifica al Autor Original del caso (Rol 2) - Si aplica
   - **NUEVO**: Se notifica a la **Dirección Administrativa del caso (Rol 10)** - Si la dirección es diferente del usuario que agrega el seguimiento

2. **El Rol 10 puede ver**:
   - Notificaciones de REMISIÓN (comportamiento original)
   - **NUEVO**: Notificaciones de SEGUIMIENTO de casos en su dirección

## Dependencias
- Ninguna, solo modificaciones en los archivos mencionados

## Testing
- [ ] Verificar que al agregar seguimiento a un caso remitido:
  - [ ] Supervisión (1,3,5) reciba notificación
  - [ ] Autor (Rol 2) reciba notificación
  - [ ] **Dirección (Rol 10) del caso reciba notificación**
- [ ] Verificar que no haya duplicados
- [ ] Verificar que el Rol 10 pueda ver las notificaciones de seguimientos en su panel

## Notas
- El código existente ya tiene lógica para evitar auto-notificaciones
- Se reutiliza el método `obtenerUsuariosPorDireccion()` existente
- La dirección del caso se obtiene de la tabla `sgc_casos_remitidos` (si fue remitido) o del usuario operador original

