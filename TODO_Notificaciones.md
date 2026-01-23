# Plan de Implementación: Sistema de Notificaciones y Cintillo

## Objetivo
1. Hacer el cintillo más ancho
2. Crear sistema de notificaciones con dos fases:
   - FASE 1: Notificaciones cuando una dirección remite un caso
   - FASE 2: Notificaciones de seguimientos visibles para roles 1, 3, 5

## Tareas Realizadas ✅

### 1. ✅ Modificar CSS del Cintillo (navar.css)
- ✅ Aumentar el ancho del cintillo (height: 70px, container flex)
- ✅ Agregar estilos para el dropdown de notificaciones
- ✅ Estilos para notificaciones leídas/no leídas

### 2. ✅ Actualizar el Navbar (nav_bar.php)
- ✅ Icono de campana con contador de notificaciones
- ✅ Lista desplegable de notificaciones
- ✅ CDN de SweetAlert2 para alertas emergentes
- ✅ FontAwesome para iconos
- ✅ Funcionalidad JavaScript completa

### 3. ✅ Crear Modelo de Notificaciones (Notificaciones_Model.php)
- ✅ Métodos para insertar notificaciones
- ✅ Métodos para obtener notificaciones por usuario
- ✅ Métodos para marcar notificaciones como leídas
- ✅ Método para contar notificaciones no leídas
- ✅ Métodos para obtener usuarios por dirección/roles

### 4. ✅ Crear Controlador de Notificaciones (Notificaciones_Controler.php)
- ✅ Endpoint para obtener notificaciones
- ✅ Endpoint para marcar como leída
- ✅ Endpoint para obtener contador

### 5. ✅ Modificar Seguimiento_Controler.php
- ✅ Al agregar seguimiento, crear notificación
- ✅ Notificar a usuarios con roles 1, 3, 5

### 6. ✅ Modificar Casos_Controler.php
- ✅ Al remitir caso, crear notificación
- ✅ Notificar a usuarios de la dirección destino
- ✅ Agregar método privado crearNotificacionRemision()

### 7. ✅ Agregar rutas (Routes.php)
- ✅ /notificaciones/obtenerMisNotificaciones
- ✅ /notificaciones/contarNotificaciones
- ✅ /notificaciones/marcarLeida
- ✅ /notificaciones/marcarTodasLeidas

### 8. ✅ Crear script SQL
- ✅ Script para crear la tabla sgc_notificaciones

## Dependencias
- SweetAlert2 para alertas emergentes
- FontAwesome para iconos

## Notas
- Los usuarios con roles 1, 3, 5 ven todas las notificaciones
- El resto de usuarios solo ven notificaciones de casos remitidos

## Pasos para Instalar
1. Ejecutar el script SQL: `DB_Sala_situacional/sgc_notificaciones.sql`
2. Verificar que los archivos fueron actualizados correctamente
3. Probar el sistema de notificaciones

