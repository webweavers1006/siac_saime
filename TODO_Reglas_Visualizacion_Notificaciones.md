# TODO: Implementación de Reglas de Visualización - Bandeja de Notificaciones

## Estado General
**Estado:** EN PROGRESO  
**Fecha de Inicio:** $(date)

---

## Lista de Tareas

### 1. Modificar Notificaciones_Model.php ✅ COMPLETADO
- [x] Modificar `obtenerNotificacionesPorUsuario()` - Agregar filtros por rol
- [x] Modificar `contarNoLeidas()` - Aplicar mismos filtros
- [x] Agregar método `verificarCierrePorRol2($id_caso)`
- [x] Agregar método `obtenerUsuarioPorId($idusuopr)`
- [x] Agregar método `obtenerInfoCaso($id_caso)`
- [x] Agregar logging estructurado

### 2. Modificar Casos_Controler.php ✅ COMPLETADO
- [x] Modificar `crearNotificacionRemision()` - Agregar nuevos campos y lógica de autoría
- [x] Verificar que el autor original (Rol 2) reciba notificaciones
- [x] Agregar logging estructurado

### 3. Modificar Seguimiento_Controler.php ✅ COMPLETADO
- [x] Modificar `crearNotificacionSeguimiento()` - Agregar nuevos campos y lógica de autoría
- [x] Notificar a Roles 1, 3, 5 y al autor original (Rol 2)
- [x] Agregar logging estructurado

### 4. Modificar Estatus.php ✅ COMPLETADO
- [x] Modificar `crearNotificacionCambioEstatus()` - Aplicar nueva lógica
- [x] Verificar notificación al autor original (Rol 2)
- [x] Implementar restricción: No notificar cierres por Rol 2 a supervisión

### 5. Modificar Notificaciones_Controler.php ✅ COMPLETADO
- [x] Modificar `obtenerMisNotificaciones()` - Mejorar lógica de filtros por rol
- [x] Modificar `contarNotificaciones()` - Aplicar mismos filtros
- [x] Agregar logging estructurado

### 6. Script SQL de Migración ✅ COMPLETADO
- [x] Crear script `migracion_notificaciones_reglas.sql`
- [x] Agregar campos: id_usuario_accion, id_rol_accion, id_caso_autor
- [x] Crear índices optimizados
- [x] Actualizar registros existentes

### 7. Verificación ⬜ PENDIENTE DE PRUEBAS
- [ ] Probar con Rol 1, 3, 5 (Supervisión)
- [ ] Probar con Rol 2 (Autor)
- [ ] Probar con Otras Direcciones
- [ ] Verificar que no hay auto-notificaciones
- [ ] Verificar que el contador de notificaciones funciona correctamente
- [ ] Ejecutar script de migración en base de datos

---

## Reglas de Negocio Implementadas

### Roles de Supervisión (Roles 1, 3, 5)
- ✅ Visibilidad: Seguimientos, remisiones o cierres realizados por otras direcciones
- ✅ Restricción: No visualizar casos cerrados por ellos mismos (autocierre)
- ✅ Restricción: No visualizar casos cerrados por usuarios con Rol 2

### Rol de Autoría (Rol 2)
- ✅ Trazabilidad: Ver todos los seguimientos y acciones que otras direcciones realicen sobre casos creados por él
- ✅ Ejemplo: Si Rol 2 crea el "Caso A" y lo remite a la "Dirección X", cuando "Dirección X" agregue un avance, el Rol 2 recibirá la notificación

### Roles de Destino (Otras Direcciones)
- ✅ Casos Asignados: Solo ven casos que han sido remitidos a su dirección específica
- ✅ Historial Local: Acceso a los seguimientos generados mientras el caso esté bajo su cargo

---

## Nuevos Campos en Tabla sgc_notificaciones

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id_usuario_accion` | INT | Quién genera la notificación |
| `id_rol_accion` | INT | Rol de quien genera |
| `id_caso_autor` | INT | Creador original del caso |

---

## Dependencias
- Tabla `sgc_notificaciones` debe tener los nuevos campos

## Notas
- Optimizado para PHP 8.4
- Se evita doble notificación verificando si el usuario es el autor original

