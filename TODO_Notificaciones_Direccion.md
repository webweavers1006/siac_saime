# TODO - Mejoras en Notificaciones

## Objetivo
Incluir la información de la Dirección que origina las notificaciones en:
1. Notificaciones de REMISIÓN de casos
2. Notificaciones de SEGUIMIENTO de casos

## Tareas Pendientes

### 1. Notificaciones_Model.php
- [x] Agregar método `obtenerNombreDireccion($id_direccion)` para obtener el nombre de una dirección por su ID
- [x] Modificar `obtenerNotificacionesNoLeidas()` para incluir JOIN con direcciones y devolver `nombre_direccion_origen`
- [x] Modificar `obtenerNotificacionesPorUsuario()` para incluir JOIN con direcciones

### 2. Casos_Controler.php
- [x] Modificar método `crearNotificacionRemision()` para incluir el nombre de la dirección origen en el mensaje

### 3. Seguimiento_Controler.php
- [x] Modificar método `crearNotificacionSeguimiento()` para incluir el nombre de la dirección del usuario en el mensaje

### 4. Seguimientos.php
- [x] Modificar método `obtenerSeguimientoDeCaso()` para incluir la dirección del usuario que hizo el seguimiento

### 5. nav_bar.php
- [x] Modificar función `renderNotificaciones()` para mostrar la dirección origen en las notificaciones

### 6. add_seguimiento.js
- [x] Agregar columna `direccion_usuario` en la tabla de seguimientos

## Cambios Realizados

### Cambio 1: Notificaciones_Model.php
- Nuevo método `obtenerNombreDireccion($id_direccion)` agregado
- JOIN con `sgc_direcciones_administrativas` agregado en consultas de notificaciones
- Campo `direccion_origen_nombre` ahora se devuelve en las notificaciones

### Cambio 2: Casos_Controler.php
- Mensaje de notificación de remisión ahora incluye:
  - "Remitido por: [dirección_origen]"

### Cambio 3: Seguimiento_Controler.php
- Mensaje de notificación de seguimiento ahora incluye:
  - "Agregado por: [direccion_usuario]"
- Cambiado "caso" por "el caso" en el mensaje según requerimiento

### Cambio 4: Seguimientos.php
- JOIN con `sgc_direcciones_administrativas` agregado
- Campo `direccion_usuario` ahora se devuelve en los seguimientos

### Cambio 5: nav_bar.php
- Función `renderNotificaciones()` modificada para construir mensaje completo con dirección origen
- Diferentes sufijos según tipo de notificación (REMISION: "Remitido por:", SEGUIMIENTO: "Agregado por:")

### Cambio 6: add_seguimiento.js
- Columna `direccion_usuario` agregada a la tabla DataTable de seguimientos

## Estado de Progreso
- [x] Tarea 1 completada
- [x] Tarea 2 completada
- [x] Tarea 3 completada
- [x] Tarea 4 completada
- [x] Tarea 5 completada
- [x] Tarea 6 completada

