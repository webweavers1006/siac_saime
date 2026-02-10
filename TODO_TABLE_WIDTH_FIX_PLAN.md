# Plan para Arreglar el Ancho de la Tabla

## Problema
"La tabla se ve muy pequeña y comprimida hacia la izquierda. No está aprovechando el ancho disponible de la pantalla."

## Cambios Requeridos

### 1. Arreglar conflictos en casos.js
**Archivo**: `public/custom/js/caso/casos.js`

**Cambio**: Eliminar el segundo `autoWidth: true` que contradice el `autoWidth: false`

**Ubicación**: Línea ~448 en la configuración de DataTable
```javascript
// ACTUAL (CONFLICTO):
"autoWidth": true,  // CONFLICTO: Contradice el autoWidth: false de línea ~427

// DEBERÍA SER:
"autoWidth": false, // Mantener consistencia
```

### 2. Optimizar configuración DataTable
**Cambios adicionales**:
- Eliminar `scrollX: true` si no es necesario (puede causar compresión)
- Mantener `width: '100%'`
- Asegurar que `scrollCollapse: true` no comprima la tabla

### 3. Mejorar CSS en mejoras_casos.css
**Archivo**: `public/css_paginas/mejoras_casos.css`

**Patrón UX recomendado**: Buscador a la derecha (estándar), Selector a la izquierda

**Nuevos estilos a agregar**:
```css
/* Contenedor del DataTable */
.dataTables_wrapper {
    width: 100% !important;
    max-width: 100% !important;
}

/* Selector de registros (Mostrar X) - ALINEACIÓN ESTÁNDAR UX */
.dataTables_wrapper .dataTables_length {
    float: left;
    margin-bottom: 10px;
}

/* Buscador (Search) - ALINEACIÓN ESTÁNDAR UX */
.dataTables_wrapper .dataTables_filter {
    float: right;
    margin-bottom: 10px;
    text-align: right;
}

/* Forzar que la tabla ocupe todo el espacio */
table.dataTable {
    width: 100% !important;
    margin: 15px 0 !important;
    clear: both;
}

/* Info a la izquierda */
.dataTables_wrapper .dataTables_info {
    float: left;
    padding-top: 0.5em;
}

/* Paginación a la derecha */
.dataTables_wrapper .dataTables_paginate {
    float: right;
    margin-top: 10px;
}

/* Limpiar floats después de los elementos */
.dataTables_wrapper::after {
    content: "";
    display: table;
    clear: both;
}

/* Alineación de los botones de acción en una sola fila */
table.dataTable td:last-child {
    white-space: nowrap;
    text-align: center;
}
```

### 4. Actualizar estilos inline en content.php
**Archivo**: `app/Views/casos/content.php`

**Mejoras**:
- Simplificar los estilos inline para DataTables
- Mejorar el selector de columnas para mejor distribución proporcional

### 5. Ajustar anchos de columnas
**Cambios sugeridos**:
- Usar `width` percentages más equilibrados
- Permitir que algunas columnas usen `auto` para mejor distribución

## Archivos a Modificar

1. ✅ `public/custom/js/caso/casos.js` - Arreglar conflicto autoWidth
2. ✅ `public/css_paginas/mejoras_casos.css` - Agregar estilos de alineación
3. ✅ `app/Views/casos/content.php` - Optimizar estilos inline

## Estado de Tareas

- [x] 1. Corregir conflicto autoWidth en casos.js
- [x] 2. Agregar estilos de alineación en mejoras_casos.css
- [x] 3. Optimizar estilos inline en content.php

## Resultado Esperado

✅ La tabla ocupará el 100% del ancho disponible
✅ Las columnas se distribuirán proporcionalmente (table-layout: auto)
✅ El selector de registros (Mostrar X) se alineará a la izquierda
✅ El buscador (Search) se alineará a la derecha
✅ El texto no se verá comprimido

