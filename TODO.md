# PLAN DE CORRECCIÓN - APODERADOS MEDIACIÓN

## ✅ PASOS COMPLETADOS
- [x] Diagnóstico completo
- [x] Plan validado

## 🔧 PASOS PENDIENTES (EJECUTAR EN ORDEN)

### 1. Crear TODO.md ✅ **HECHO**

### 2. EDITAR app/Controllers/Casos_Controler.php ✅ **COMPLETADO**
```
Método: nuevoCaso() - Línea ~280
AGREGAR campo 'ter_impre_abogado' en insert sgc_terceros
```

### 3. EDITAR app/Models/Mediacion.php ✅ **COMPLETADO**
```
SELECT: AGREGAR ter_sol.ter_impre_abogado, ter_apo_contra.ter_impre_abogado
```

### 4. VERIFICAR app/Models/Casos.php
```
detalleCaso(): AGREGAR JOIN sgc_mediacion + terceros
```

### 5. PROBAR
```
1. Crear nuevo caso mediación 24
2. Verificar BD: sgc_mediacion → IDs > 0 + IMPRE
3. Editar caso 24 → Datos aparecen
```

### 6. LIMPIAR
```
rm TODO.md
```

---

**ESTADO: Pendiente aprobación para editar archivos**

