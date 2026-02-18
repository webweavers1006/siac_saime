# Task Analysis: Data Inconsistency Between /casos and /consolidado Endpoints

## Problem Identified
From the HTTP requests provided:
- **Endpoint `/casos`** (listar_Casos_Usuarios):
  - recordsTotal: 47703
  - recordsFiltered: 816
  - Search: "web"

- **Endpoint `/consolidado`** (reporte_consolidado):
  - recordsTotal: 47703
  - recordsFiltered: 820
  - Search: "web"

Both endpoints return the same total records (47703), but they return different filtered counts (816 vs 820) when using the same search term "web". This indicates an inconsistency in the filtering logic between the two endpoints.

## Root Cause Analysis
Looking at the code:

1. **Endpoint `/casos`** uses `obtenerCasosServerSide()` method in `app/Models/Casos.php`
2. **Endpoint `/consolidado`** uses `getReporteData()` method in `app/Models/Casos.php`

The search WHERE clauses are different between these two methods:

### In `obtenerCasosServerSide()`:
```php
$whereClause = "
    CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
    LOWER(TRIM(a.casoced)) LIKE '{$searchPattern}' OR
    LOWER(a.casonom) LIKE '{$searchPattern}' OR
    LOWER(a.casoape) LIKE '{$searchPattern}' OR
    LOWER(b.estnom) LIKE '{$searchPattern}' OR
    LOWER(COALESCE(t_antusu.tipo_aten_nombre, '')) LIKE '{$searchPattern}' OR
    LOWER(COALESCE(CAST(d.tipo_atend_borrado AS TEXT), '')) LIKE '{$searchPattern}' OR
    LOWER(COALESCE(tpinte.tipo_prop_nombre, '')) LIKE '{$searchPattern}' OR
    LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)) LIKE '{$searchPattern}' OR
    LOWER(u_ope.usuopnom) LIKE '{$searchPattern}' OR
    LOWER(u_ope.usuopape) LIKE '{$searchPattern}'
";
```

### In `getReporteData()`:
```php
$whereClause = "
    CAST(a.idcaso AS TEXT) LIKE '{$searchPattern}' OR
    COALESCE(TRIM(a.casoced), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(a.casonom), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(a.casoape), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(b.estnom), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(t_antusu.tipo_aten_nombre), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(tpinte.tipo_prop_nombre), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(t_bene.tipo_beneficiario_nombre), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(CONCAT(u_ope.usuopnom, ' ', u_ope.usuopape)), '') LIKE '{$searchPattern}' OR
    COALESCE(LOWER(rs.red_s_nom), '') LIKE '{$searchPattern}'
";
```

## Key Differences Found:
1. `getReporteData()` includes additional search fields:
   - `t_bene.tipo_beneficiario_nombre`
   - `rs.red_s_nom` (vía de atención)

2. Different use of COALESCE:
   - `obtenerCasosServerSide` uses `LOWER()` without COALESCE for some fields
   - `getReporteData` uses `COALESCE(LOWER(...), '')` consistently

3. The first method includes search on `d.tipo_atend_borrado` which is not in the second method.

## Solution Plan
To fix the inconsistency, we need to make the search logic consistent between the two methods. The recommended approach is:

1. Update `obtenerCasosServerSide()` in `app/Models/Casos.php` to match the search logic of `getReporteData()`:
   - Add missing search fields: `tipo_beneficiario_nombre`, `via_atencion_nombre` (red_s_nom)
   - Use consistent COALESCE patterns

2. Verify the fix returns consistent recordsFiltered values between both endpoints.

## Files to Modify
- `app/Models/Casos.php` - Update `obtenerCasosServerSide()` and `obtenerCasos_filtrados_por_usuario_serverSide()` methods

