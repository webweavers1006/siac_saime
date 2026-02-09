# Plan: Agregar filtro de notificaciones (Todas/Leídas/No Leídas)

## Objetivo
Permitir al usuario ver todas las notificaciones (leídas y no leídas) con opciones de filtro.

## Cambios realizados

### 1. Modelo (Notificaciones_Model.php) ✅
- [x] Agregar método `obtenerTodasLasNotificaciones($id_usuario, $roles_permitidos, $id_direccion, $userrol)` 
- [x] Este método traerá notificaciones sin filtrar por `leida = false`
- [x] Límite de 100 notificaciones para mostrar todas

### 2. Controlador (Notificaciones_Controler.php) ✅
- [x] Agregar endpoint `obtenerTodasMisNotificaciones()` que llame al nuevo método del modelo
- [x] Mantener compatibilidad con el endpoint existente

### 3. Vista (nav_bar.php) ✅
- [x] Agregar botones/toggle para filtrar notificaciones:
  - Opción "No leídas" (por defecto, actual)
  - Opción "Todas" (leídas + no leídas)
- [x] Modificar función `cargarNotificaciones()` para aceptar parámetro de tipo
- [x] Agregar lógica para mostrar/ocultar notificaciones según el filtro
- [x] Estilos CSS para notificaciones leídas (apariencia atenuada)
- [x] Indicador visual de notificación leída (checkmark verde)

## Funcionalidades implementadas

### Frontend:
- ✅ Botones de filtro con estilos activos/inactivos
- ✅ Visualización diferenciada de notificaciones leídas (opacidad reducida)
- ✅ Indicador de "Leída" con checkmark verde
- ✅ Contador de notificaciones no leídas separado
- ✅ Mensajes personalizados según el filtro

### Backend:
- ✅ Endpoint separado para obtener todas las notificaciones
- ✅ Mismas reglas de visualización por rol
- ✅ Logs de depuración para troubleshooting

---
**Fecha creación:** 2024
**Estado:** ✅ Completado

