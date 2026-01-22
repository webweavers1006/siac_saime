# Plan de Corrección - Error 500 en Estadísticas (Production)

## Problema
Las consultas en el modelo `Casos.php` usan inconsistentemente el esquema `public.`:
- Algunas tablas SÍ usan `public.` (ej: `public.sgc_red_social`)
- Otras NO usan el prefijo (ej: `sgc_estatus`, `sgc_casos`)

## Solución Implementada

### 1. Configuración de Base de Datos (`app/Config/Database.php`)
- ✅ Agregado `'schema' => 'public'` en la configuración PostgreSQL

### 2. Modelo Casos (`app/Models/Casos.php`)
- ✅ Corregidas todas las consultas para usar `public.` de forma consistente:
  - `sgc_estatus` → `public.sgc_estatus`
  - `sgc_usuario_operador` → `public.sgc_usuario_operador`
  - `sgc_tipo_prop_caso` → `public.sgc_tipo_prop_caso`
  - `sgc_tipo_prop_intelec` → `public.sgc_tipo_prop_intelec`
  - `sgc_registro_cgr` → `public.sgc_registro_cgr`
  - `sgc_tipoatenciondetalle` → `public.sgc_tipoatenciondetalle`
  - `sgc_casos_denuncias` → `public.sgc_casos_denuncias`
  - `sgc_tipo_beneficiarios` → `public.sgc_tipo_beneficiarios`
  - `sgc_tipoatencion_usu` → `public.sgc_tipoatencion_usu`
  - `sgc_casos_remitidos` → `public.sgc_casos_remitidos`
  - `sgc_direcciones_administrativas` → `public.sgc_direcciones_administrativas`
  - `sgc_red_social` → `public.sgc_red_social`
  - `sgc_municipio` → `public.sgc_municipio`
  - `sgc_estados` → `public.sgc_estados`
  - `sgc_parroquias` → `public.sgc_parroquias`
  - `sgc_org_pod_popular` → `public.sgc_org_pod_popular`
  - `sgc_paises` → `public.sgc_paises`
  - `sgc_usuario_token` → `public.sgc_usuario_token`
  - `sgc_seguimiento_caso` → `public.sgc_seguimiento_caso`
  - `sta_usuarios_visitas` → `public.sta_usuarios_visitas`

## Resultado
Las consultas ahora usan un esquema consistente, lo que debería resolver el error 500 en producción.

## Nota
Para ver errores detallados en producción temporalmente, verificar los logs en:
- `writable/logs/`

