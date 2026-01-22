# TODO: Corrección de error 500 en asociar_casos

## Problema
- Error HTTP 500 en POST /asociar_casos
- Botón queda en "Asociando..." porque AJAX no maneja errores
- El caso sí se asocia correctamente

## Solución

### 1. Modelo: Corregir `asociar_nuevo_caso()` - RETORNO BOOLEANO ✅
- [x] Modificar para retornar `true/false` en lugar de entero
- [x] Usar schema consistente `public.sgc_caso_punto_cuenta`

### 2. Modelo: Corregir `verificar_caso_existente()` - RETORNO BOOLEANO ✅
- [x] Cambiar de retornar array a retornar booleano (empty/exists)

### 3. JavaScript: Agregar `error handler` en AJAX ✅
- [x] Agregar callback `error` en `$.ajax` para manejar HTTP 500
- [x] Mostrar mensaje de error apropiado
- [x] Rehabilitar botón en caso de error

### 4. Controlador: Agregar try-catch con logging ✅
- [x] Capturar excepciones y loguear errores

## Archivos modificados
- `/var/www/html/siac_v2/app/Models/Punto_Cuenta_Model.php`
- `/var/www/html/siac_v2/public/custom/js/punto_cuenta/punto_cuenta.js`
- `/var/www/html/siac_v2/app/Controllers/Punto_Cuenta_Controler.php`

## Próximo paso
Verificar los logs de errores en:
```
/var/www/html/siac_v2/writable/logs/
```

