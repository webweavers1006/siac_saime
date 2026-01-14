# Plan de Mejora: Funcionalidad de Seguimientos en Casos

## Objetivo
Corregir y mejorar la funcionalidad de seguimientos cuando se crea un caso con `id_tipo_atencion = 1` (Asesoría CGR), asegurando que se inserten tanto el seguimiento de creación como el seguimiento de cierre.

## Problema Identificado
- El seguimiento de cierre no se está guardando correctamente en la base de datos
- Falta el campo `idusuopr` en el seguimiento de cierre
- Mejores prácticas de código para evitar confusión

## Cambios a Implementar

### 1. En el método `nuevoCaso()` del Casos_Controler.php:

#### Cambio 1.1: Mejorar el seguimiento de cierre
- **Ubicación**: Línea donde se crea el seguimiento de cierre (después del seguimiento inicial)
- **Cambio**: Agregar `idusuopr` faltante
- **Cambio**: Usar variable diferente para evitar sobrescritura

### 2. Código Actual (Problemático):
```php
if ($newCase["id_tipo_atencion"] == '1')
{
    // 3.4. SEGUIMIENTO DE CIERRE PARA EL CASO DE ASESORIA
    $datosSeguimiento = [
        'idcaso' => $idcaso,
        "idestllam" => 2,
        "segcoment" => "Cambiado a estatus Cerrado el dia " . date('d-m-Y'),
        "segfec" => date('Y-m-d'),
    ];
    $segModel->insertarSeguimiento($datosSeguimiento);
}
```

### 3. Código Mejorado:
```php
if ($newCase["id_tipo_atencion"] == '1')
{
    // 3.4. SEGUIMIENTO DE CIERRE PARA EL CASO DE ASESORIA
    $datosSeguimientoCierre = [
        'idcaso' => $idcaso,
        'idestllam' => 2,
        'idusuopr' => $idusuopr,  // AGREGADO: Campo faltante
        'segcoment' => 'Cambiado a estatus Cerrado el dia ' . date('d-m-Y'),
        'segfec' => date('Y-m-d'),
    ];
    $resultadoCierre = $segModel->insertarSeguimiento($datosSeguimientoCierre);
    
    // Verificación de éxito
    if (!$resultadoCierre) {
        log_message('error', 'Error al insertar seguimiento de cierre para caso: ' . $idcaso);
    }
}
```

## Pasos de Implementación

1. ✅ Leer el archivo del controlador
2. ✅ Analizar el código actual
3. ✅ Identificar los problemas
4. ✅ Implementar los cambios
5. ✅ Verificar la sintaxis
6. 🔄 Probar la funcionalidad (si es posible)

## Resultado Esperado
Cuando se cree un caso con `id_tipo_atencion = 1`:
- El caso se creará con `idest = 2` (Cerrado)
- Se insertará un seguimiento con `idestllam = 4` (Creación)
- Se insertará un segundo seguimiento con `idestllam = 2` (Cierre)
- Ambos seguimientos tendrán el `idusuopr` correcto

## Notas Adicionales
- La mejora mantiene la compatibilidad con el código existente
- No afecta otros tipos de atención
- Agrega capacidad de debugging mediante logs

