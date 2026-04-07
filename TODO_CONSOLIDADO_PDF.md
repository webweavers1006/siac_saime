# TODO: Consolidado PDF - Add Filtered Records Count + Landscape [0/5] ⏳

**Approved Plan:** User confirmed "SI" ✅

## Steps:

### 1. ✅ [COMPLETED] Create this TODO.md

### 2. ✅ [COMPLETED] Edit `public/custom/js/reportes/reporte_consolidado.js` ✅
   - Add global `window.recordsFiltered = 0;`
   - In DataTable `ajax success/error`: `window.recordsFiltered = json.recordsFiltered;`
   - In `customize(doc)`: Append `' | Cantidad Registros Filtrados: ' + window.recordsFiltered` to header text
   - Confirm `orientation: 'landscape'`

### 3. ✅ [COMPLETED] Verify `app/Views/reportes/general/content.php` exists + correct ✓
   - Ensure DataTable `#table_casos` + filters (like operador/content.php)

### 4. [ ] **Test**:
   ```
   Visit http://siac_v2.com/consolidado
   Apply filter → Export PDF → Check header shows "Cantidad: X" + landscape
   ```

### 5. [ ] Update TODO.md → Mark complete → `attempt_completion()`
