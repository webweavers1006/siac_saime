# Plan de Corrección del DataTable de Casos

## Problemas Identificados

### Problema 1: Error 500 al ordenar por columnas
- **Causa**: El array `$columns` en el método `listar_Casos_Usuarios` solo tenía 5 elementos, pero DataTables intentaba ordenar por la columna 8 (`user_name`), causando un índice fuera de rango.
- **Solución**: Crear un mapeo completo de todas las columnas que DataTables puede solicitar.

### Problema 2: user_name es un ALIAS, no existe físicamente
- **Causa**: `user_name` es un alias creado con `CONCAT(u_oper.usuopnom, ' ', u_oper.usuopape)`, por lo que PostgreSQL no puede resolver `ORDER BY user_name` directamente.
- **Solución**: Usar la expresión completa `CONCAT(u_oper.usuopnom, ' ', u_oper.usuopape)` en el mapeo de columnas.

### Problema 3: Esquema inconsistente en los JOINs
- **Causa**: Algunos JOINs usaban el esquema `public.` y otros no, causando que PostgreSQL no pudiera resolver las tablas en el ORDER BY.
- **Solución**: Agregar `public.` a todos los JOINs del método `buildBaseQuery()`.

### Problema 4: JOIN mal formado en denuncias
- **Causa**: El JOIN de `sgc_casos_denuncias` estaba mal escrito (`a.idcaso = denu_id_caso`).
- **Solución**: Corregir a `a.idcaso = denu.denu_id_caso`.

## Cambios Realizados

### 1. Corregido `app/Controllers/Casos_Controler.php`
- ✅ Modificado el método `listar_Casos_Usuarios()`:
  - Creado un array `$columns` completo con 10 elementos (índices 0-9)
  - Agregada validación para verificar que el índice de columna solicitado exista
  - Implementado valor por defecto si el índice no existe
  - **CORRECCIÓN CLAVE**: La columna 8 ahora usa la expresión completa:
    - Antes: `'u_ope.user_name'` (alias que no existe)
    - Después: `'CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape)'` (expresión real)

### 2. Corregido `app/Models/Casos.php` - Método `buildBaseQuery()`
- ✅ Agregado esquema `public.` a TODOS los JOINs:
  ```php
  // Antes
  $builder->join('sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
  
  // Después
  $builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
  ```

- ✅ Corregido JOIN de denuncias:
  ```php
  // Antes (MAL)
  $builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left');
  
  // Después (CORRECTO)
  $builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left');
  ```

### 3. Corregido `app/Models/Casos.php` - Métodos de búsqueda
- ✅ Modificado el método `obtenerCasosServerSide()`:
  - Aplicado `LOWER()` a todos los campos en la cláusula WHERE de búsqueda
  - Convertido el término de búsqueda a minúsculas antes de escapar
  - Sanitizado el nombre de columna para ordenamiento (`order_column_safe`)

- ✅ Modificado el método `obtenerCasos_filtrados_por_usuario_serverSide()`:
  - Aplicado `LOWER()` a todos los campos en la cláusula WHERE de búsqueda
  - Convertido el término de búsqueda a minúsculas antes de escapar
  - Sanitizado el nombre de columna para ordenamiento (`order_column_safe`)

## Resumen de Cambios

### Controlador (`Casos_Controler.php`):
```php
// Antes (INCORRECTO - user_name es un alias, no existe físicamente)
$columns = [
    8 => 'u_ope.user_name',  // ❌ Esto causaba el error 500
];

// Después (CORRECTO - usamos la expresión completa CONCAT)
$columns = [
    8 => 'CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape)',  // ✅ Expresión real
];
```

### Modelo (`Casos.php` - buildBaseQuery):
```php
// Antes (esquema inconsistente)
$builder->join('sgc_usuario_operador u_ope', '...');
$builder->join('sgc_estatus b', '...');
$builder->join('sgc_casos_denuncias denu', 'a.idcaso = denu_id_caso', 'left'); // ❌ Faltaba alias

// Después (esquema consistente y JOIN corregido)
$builder->join('public.sgc_usuario_operador u_ope', '...');
$builder->join('public.sgc_estatus b', '...');
$builder->join('public.sgc_casos_denuncias denu', 'a.idcaso = denu.denu_id_caso', 'left'); // ✅ Con alias
```

## Estado de Progreso
- [x] Corregir array de columnas en Casos_Controler.php
- [x] Validar columna de ordenamiento antes de usar
- [x] Usar expresión CONCAT completa para user_name en lugar del alias
- [x] Agregar esquema 'public.' a todos los JOINs en buildBaseQuery
- [x] Corregir JOIN de denuncias (faltaba alias 'denu.')
- [x] Aplicar LOWER() en búsquedas de Casos.php (método 1)
- [x] Aplicar LOWER() en búsquedas de Casos.php (método 2)
- [ ] Verificar funcionamiento (pendiente de prueba en navegador)

## URL de error original
```
GET http://siac_v2.com/listar_Casos_Usuarios?draw=3&...&order[0][column]=8&order[0][dir]=desc&...
```
- Columna 8 = `user_name` - causaba error 500

