# Plan: Bloquear notificaciones para Roles 4, 6, 9

## Objetivo
Los usuarios con rol 4, 6 y 9 NO deben ver ninguna notificación en el sistema.

## Archivos a modificar

### 1. app/Controllers/Notificaciones_Controler.php
- [x] Agregar variable `$roles_bloqueados = [4, 6, 9]` 
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerMisNotificaciones()`
- [x] Verificar si el usuario tiene rol bloqueado en `contarNotificaciones()`
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerTodasMisNotificaciones()`
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerNotificacionesAlerta()`

### 2. app/Models/Notificaciones_Model.php
- [x] Agregar variable `$roles_bloqueados = [4, 6, 9]`
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerNotificacionesPorUsuario()` - retornar array vacío
- [x] Verificar si el usuario tiene rol bloqueado en `contarNoLeidas()` - retornar 0
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerTodasLasNotificaciones()` - retornar array vacío
- [x] Verificar si el usuario tiene rol bloqueado en `contarTodasLasNotificaciones()` - retornar 0
- [x] Verificar si el usuario tiene rol bloqueado en `obtenerNotificacionesNoLeidas()` - retornar array vacío

## Comportamiento esperado

| Rol | Notificaciones visibles |
|-----|------------------------|
| 1, 3, 5 (Supervisión) | REMISION, SEGUIMIENTO, CIERRE (excepto cierres de Rol 2) |
| 2 (Autor) | Notificaciones de sus casos |
| 10 (Dirección) | REMISION, SEGUIMIENTO |
| 4, 6, 9 (Bloqueados) | NINGUNA |
| Otros | Solo REMISION |

## Estado
✅ Implementación completada - Roles 4, 6, 9 bloqueados de ver notificaciones

## Resumen de cambios

### 1. app/Controllers/Notificaciones_Controler.php
- ✅ Agregada variable `$roles_bloqueados = [4, 6, 9]`
- ✅ Verificación en `obtenerMisNotificaciones()` - retorna array vacío
- ✅ Verificación en `contarNotificaciones()` - retorna 0
- ✅ Verificación en `obtenerTodasMisNotificaciones()` - retorna array vacío
- ✅ Verificación en `obtenerNotificacionesAlerta()` - retorna array vacío

### 2. app/Models/Notificaciones_Model.php
- ✅ Agregada variable `$roles_bloqueados = [4, 6, 9]`
- ✅ Verificación en `obtenerNotificacionesPorUsuario()` - retorna array vacío
- ✅ Verificación en `contarNoLeidas()` - retorna 0
- ✅ Verificación en `obtenerNotificacionesNoLeidas()` - retorna array vacío
- ✅ Verificación en `obtenerTodasLasNotificaciones()` - retorna array vacío
- ✅ Verificación en `contarTodasLasNotificaciones()` - retorna 0

### 3. app/Views/template/nav_bar.php
- ✅ Variables JavaScript para roles bloqueados desde PHP
- ✅ Verificación en `mostrarAlertaNotificaciones()` - no abre dropdown automático
- ✅ Verificación en `actualizarContador()` - no consulta API
- ✅ Verificación en `DOMContentLoaded()` - no ejecuta funciones de notificaciones
- ✅ Ocultación PHP del ícono de notificaciones para roles bloqueados

