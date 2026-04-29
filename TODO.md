# TODO: Corregir direcciones largas en PDF Mediación

## ✅ Plan Aprobado y Desglosado en Pasos
**Archivo objetivo**: app/ThirdParty/fpdf/fpdf.php → Content_Planilla_SAPI()

### Pasos a Completar:
- [ ] **Paso 0**: Crear este TODO.md detallado ✓
- [✅] **Paso 1**: Editar Content_Planilla_SAPI() ✓
- [ ] **Paso 2**: Probar PDF Mediación (generar PDF y verificar direcciones largas)
- [ ] **Paso 3**: Validar otros formatos (Asesoría, Denuncia) no se rompen
- [ ] **Paso 4**: Marcar como Completado

**Estado**: Paso 1 completado. Esperando prueba de PDF Mediación...

## Cambios en fpdf.php (Paso 1)
```
✅ Sección B: Cell() → MultiCell(145,4) para B_direccion, B_ubicacion_completa
✅ Eliminados SetFont/SetXY duplicados
✅ Ajustes Ln() para alineación
✅ Detección direcciones en $print_section preservada/mejorada
```

**Siguiente**: Paso 2 - Genera un PDF Mediación con direcciones largas para verificar.
