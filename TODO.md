# TODO - Fix "Error de Conexión" + Coordenadas No Guardadas (Aprobado por Usuario)

## ✅ PLAN APROBADO
**Cambios confirmados por usuario:**
1. **UPSERT coordenadas** (si existe → UPDATE, sino → INSERT)
2. **AJAX timeout 45s** + bloqueo botón
3. **Error handling** mejorado (timeout warning)

## 📋 PASOS (Pendientes ✓)

### 1. ✅ Crear este TODO.md [COMPLETADO]

### 2. ✅ Editar app/Controllers/Casos_Controler.php [COMPLETADO]
- Reemplazar lógica duplicados coords en `nuevoCaso()`
```
if (!empty($lat) || !empty($lon)) {
    $coordData = ["idcaso" => $idcaso, "latitud" => $lat, "longitud" => $lon, "idusuopr" => $idusuopr];
    $existsCoord = $Casos_coordenadas->buscar_caso_coordenadas($coordData);
    if ($existsCoord) {
        $Casos_coordenadas->Actualizar_coordenadas($coordData);  // UPDATE
    } else {
        $Casos_coordenadas->insertarCoordenadas($coordData);     // INSERT
    }
}
```

### 3. ✅ Editar public/custom/js/caso/nuevo_caso.js [COMPLETADO]
```
$('#guardar').prop('disabled', true).text('Guardando...');
$.ajax({
    timeout: 45000,  // 45s
    error: function(xhr, status, error) {
        $('#guardar').prop('disabled', false).text('Guardar');
        if (status === 'timeout') {
            Swal.fire('Timeout', 'Caso pudo guardarse. Verifique lista antes de reintentar.', 'warning');
        } else {
            Swal.fire('Error de Conexión', 'No se pudo procesar la solicitud.', 'error');
        }
    }
});
```

### 4. ✗ VERIFICACIONES POST-FIX
```
cd /var/www/html/siac_v2
# 1. Test creación caso con mapa → Ver DB coords
# 2. Test doble-submit rápido → coords actualizadas
# 3. Network tab → Ver tiempo respuesta /registrarCaso
```

**Próximo paso: Editar Casos_Controler.php → Confirmar éxito → Siguiente archivo**

