# FPDF Checkbox Overflow Fix - Header_Planilla [0/6] ⏳

**Approved Plan:** User confirmed "SI PROCEDE" ✅

## Steps:

### 1. [ ] Create this TODO.md (IN PROGRESS)

### 2. ✅ [COMPLETED] Edit app/ThirdParty/fpdf/fpdf.php:
```
- Font: SetFont('Arial', 'B', 7) → SetFont('Arial', 'B', 6)
- Text Cell(19, 5, ...) → Cell(16, 5, ...)
- Spacer Cell(8, 5, '') → Cell(4, 5, '')
```

### 3. ✅ [COMPLETED] Verify dimensions:
- Text: 16mm x6 = 96mm
- Box: 4mm x6 = 24mm  
- Spacer: 4mm x5 = 20mm
- **TOTAL: 140mm** ✓ (safe in 180mm)

### 4. [ ] Test PDF generation:
```
php spark routes | grep pdf
# Visit /generar_pdf/[ID_CASO] with tipo_atencion=24 (CONSIGNACIÓN)
# Verify: single line, no overflow
```

### 5. [ ] Update this TODO.md → Mark [4/5] ✅

### 6. [ ] attempt_completion()

**Preserved:** SetX(10), iconv CP1252, ZapfDingbats chr(51), single horizontal line ✓

