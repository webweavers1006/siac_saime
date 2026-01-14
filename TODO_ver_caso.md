# Plan de Mejora Visual - Ver Caso

## Objetivo
Mejorar la apariencia visual de la vista "ver_caso" manteniendo todos los IDs y clases importantes intactos.

## Cambios Implementados

### 1. Unificar diseño Bootstrap (content.php)
- [x] Eliminar clases Tailwind mezcladas incorrectamente
- [x] Reemplazar con clases Bootstrap equivalentes
- [x] Mejorar panel de información general (primer panel - con acc_participantes='t')

### 2. Mejorar panel de información general
- [x] Mejorar espaciado y márgenes
- [x] Agregar bordes y sombras suaves
- [x] Mejorar jerarquía visual de la información
- [x] Usar tarjetas con mejor diseño

### 3. Mejorar segundo panel de información general
- [x] Mejorar cuando acc_participantes no es 't'
- [x] Aplicar misma estructura de tarjeta

## Cambios Pendientes

### 4. Mejorar tablas
- [ ] Mejorar diseño de encabezados
- [ ] Agregar bordes suaves
- [ ] Mejorar espaciado de filas
- [ ] Agregar estados hover

### 5. Mejorar modales
- [ ] Organizar mejor los campos en formularios
- [ ] Mejorar espaciado y márgenes
- [ ] Mejorar diseño de botones

### 6. Mejorar CSS (ver_caso.css)
- [x] Agregar estilos para mejor apariencia
- [x] Mejorar diseño del panel de información
- [x] Mejorar tablas y formularios
- [ ] Optimizar estilos existentes

## Notas Importantes
- NO modificar IDs importantes: `id_caso`, `table_seguimientos`, `table_participantes`, `listar_seguimientos`, `listar_participantes`, `docu-casos`, etc.
- NO modificar clases importantes: `card`, `card-body`, `modal`, `table`, etc.
- Mantener funcionalidad existente intacta

