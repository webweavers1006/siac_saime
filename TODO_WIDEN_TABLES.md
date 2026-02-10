# Plan: Widening the Tables in Casos View

## Objetivo
Aumentar el ancho de las tablas en la vista de casos para una mejor visualización de los datos.

## Cambios a Realizar

### 1. Modificar `app/Views/casos/content.php`
- [x] Aumentar anchos de columnas en el elemento `<thead>`
- [x] Actualizar estilos inline de las columnas

### 2. Modificar `public/css_paginas/mejoras_casos.css`
- [x] Aumentar anchos de celdas `tbody td:nth-child()`
- [x] Ajustar `min-width` del contenedor de tabla
- [x] Modificar anchos específicos por columna

### 3. Modificar `public/custom/js/caso/casos.js`
- [x] Eliminar `scrollX: true` de la configuración DataTable
- [x] Permitir que la tabla use todo el ancho disponible

## Nuevos Anchos de Columnas Propuestos

| Columna | Ancho Actual | Ancho Nuevo |
|---------|-------------|------------|
| Nº | 50px | 50px (sin cambio) |
| Cédula | 90px | 100px |
| Beneficiario | min-width 200px | 280px |
| Teléfono | 100px | 120px |
| Propiedad Intelectual | 120px | 140px |
| Tipo de Atención | 120px | 150px |
| Fecha | 90px | 90px (sin cambio) |
| Estatus | 100px | 110px |
| Operador | 100px | 120px |
| Acciones | 140px | 140px (sin cambio) |

## Estado de Progreso
- [x] TODO creado
- [x] Modificado content.php
- [x] Modificado mejoras_casos.css
- [x] Modificado casos.js
- [x] Verificación completada

---
*Creado: 2025-01-09*
*Completado: 2025-01-09*

