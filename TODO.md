# TODO: Agregar fila total casos a crear en tabla Propiedad Intelectual

## Plan aprobado - Pasos a completar:

- [x] **Paso 1**: Editar `public/custom/js/caso/nuevo_caso.js` ✅
  - Modificar `generarTablaPropiedadIntelectual()` → Agregar `<tfoot>` con total
  - Crear función `actualizarTotalCasosPI()`
  - Agregar event handlers delegated para `.check-pi` y `.qty-pi`

- [ ] **Paso 2**: Probar funcionalidad
  - Navegar a http://siac_v2.com/vista_agregar_caso
  - Seleccionar Tipo Atención 24 (consignación)
  - Verificar tabla genera con total inicial=0
  - Check items → Total actualiza dinámicamente
  - Cambiar cantidades → Total se recalcula
  - Save → Verificar lista_consignacion correcta

- [x] **Plan confirmado y aprobado por usuario**
- [ ] **Task completed** → attempt_completion
