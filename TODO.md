# TODO - Extensión PDF para Formación (id_tipo_atencion = 7)

## Paso 1: Modelo
- [ ] Editar `app/Models/Talleres_Participantes_Model.php`
  - [ ] Agregar método `getParticipantesPorCaso($id_caso)` con JOIN entre `public.sgc_talleres_participantes` y `public.sgc_participantes` (filtrando por `tp.id_caso`).
  - [ ] Seleccionar: nombre, apellido, cédula, tipo_beneficiario, edad, teléfono y sexo (con alias listos para la vista/tabla).

## Paso 2: Controlador
- [ ] Editar `app/Controllers/PdfController.php`
  - [ ] Agregar rama `else if ($id_tipo_atencion == 7)`.
  - [ ] Usar el render base existente (`Header_Planilla` + `Content_planilla`).
  - [ ] Insertar la lógica de consulta y render de la tabla **justo después** de la sección donde se dibuja la descripción (`casodesc`) dentro del flujo usado para el tipo 7.

## Paso 3: Render de tabla en FPDF
- [ ] Implementar tabla FPDF con estilo limpio/profesional
  - [ ] Cabecera con 7 columnas
  - [ ] Ajuste de anchos para que quepan en el ancho útil (~190mm)
  - [ ] Truncar texto largo si es necesario y manejar paginación/altura de filas.

## Paso 4: Validación
- [ ] Probar en navegador con un `idcaso` con `id_tipo_atencion = 7`
- [ ] Verificar que no se modifiquen cabecera/logos/datos del solicitante.
- [ ] Verificar ubicación exacta (después de la descripción y su respuesta) y que no rompa el footer.

