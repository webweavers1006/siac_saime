# Plan: Mobile Expander for Acciones Column

## Objetivo
Hacer visible la columna "Acciones" en todas las pantallas, usando un expander (expandible/plegable) para dispositivos móviles.

## Cambios a Realizar

### 1. Modificar `public/custom/js/caso/casos.js`
- [ ] Eliminar `scrollX: true` de la configuración DataTable
- [ ] Agregar configuración `responsive: true` o `responsive: { details: { type: 'column' } }`
- [ ] Implementar renderizado personalizado para la columna de acciones con expander en móvil
- [ ] Crear función para manejar el expander de filas

### 2. Modificar `public/css_paginas/mejoras_casos.css`
- [ ] Agregar estilos para el expander de filas en móvil
- [ ] Estilos para el botón de expandir/contraer (+/-)
- [ ] Estilos para el contenido oculto que se muestra al expandir
- [ ] Media queries para mostrar/ocultar elementos según el tamaño de pantalla

### 3. Modificar `app/Views/casos/content.php`
- [ ] Verificar que la columna "Acciones" tenga el ancho correcto
- [ ] Agregar clase CSS para el botón de expander

## Lógica del Expander

### Desktop (> 768px):
- Los botones de acción se muestran inline en la columna "Acciones"

### Mobile (< 768px):
- La columna "Acciones" se convierte en un botón de expander (+/-)
- Al hacer clic, se expande la fila mostrando los botones de acción en formato vertical

## Estado de Progreso
- [x] Plan creado
- [ ] Modificado casos.js
- [ ] Modificado mejoras_casos.css
- [ ] Verificación completada

---
*Creado: 2025-01-09*

