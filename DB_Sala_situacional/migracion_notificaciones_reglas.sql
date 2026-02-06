-- Script de Migración: Agregar campos para Reglas de Visualización de Notificaciones
-- Fecha: $(date)
-- Objetivo: Implementar reglas de visualización según rol de usuario

-- ============================================
-- 1. AGREGAR NUEVOS CAMPOS A LA TABLA
-- ============================================

-- Agregar campos solo si no existen
ALTER TABLE public.sgc_notificaciones 
ADD COLUMN IF NOT EXISTS id_usuario_accion INTEGER;

ALTER TABLE public.sgc_notificaciones 
ADD COLUMN IF NOT EXISTS id_rol_accion INTEGER;

ALTER TABLE public.sgc_notificaciones 
ADD COLUMN IF NOT EXISTS id_caso_autor INTEGER;

-- ============================================
-- 2. AGREGAR COMENTARIOS A LOS CAMPOS
-- ============================================

COMMENT ON COLUMN public.sgc_notificaciones.id_usuario_accion IS 'ID del usuario que realiza la acción (seguimiento/remisión/cierre)';
COMMENT ON COLUMN public.sgc_notificaciones.id_rol_accion IS 'Rol que tenía el usuario al momento de la acción';
COMMENT ON COLUMN public.sgc_notificaciones.id_caso_autor IS 'ID del creador original del caso (para que el Rol 2 vea avances)';

-- ============================================
-- 3. AGREGAR LLAVES FORÁNEAS (OPCIONAL)
-- ============================================

-- ALTER TABLE public.sgc_notificaciones 
-- ADD CONSTRAINT sgc_notificaciones_id_usuario_accion_fkey 
-- FOREIGN KEY (id_usuario_accion) REFERENCES public.sgc_usuario_operador(idusuopr) ON DELETE SET NULL;

-- ALTER TABLE public.sgc_notificaciones 
-- ADD CONSTRAINT sgc_notificaciones_id_caso_autor_fkey 
-- FOREIGN KEY (id_caso_autor) REFERENCES public.sgc_usuario_operador(idusuopr) ON DELETE SET NULL;

-- ============================================
-- 4. CREAR ÍNDICES OPTIMIZADOS
-- ============================================

-- Índice para filtrar notificaciones por autor (para Rol 2)
CREATE INDEX IF NOT EXISTS idx_notif_autor_caso 
ON public.sgc_notificaciones (id_caso_autor) 
WHERE id_caso_autor IS NOT NULL;

-- Índice para evitar auto-acciones
CREATE INDEX IF NOT EXISTS idx_notif_evitar_autoaccion 
ON public.sgc_notificaciones (id_usuario_accion, id_usuario_destino);

-- Índice para ordenamiento por fecha
CREATE INDEX IF NOT EXISTS idx_notif_fecha_creacion 
ON public.sgc_notificaciones (fecha_creacion DESC);

-- ============================================
-- 5. ACTUALIZAR REGISTROS EXISTENTES
-- ============================================

-- Actualizar id_usuario_accion para notificaciones existentes
-- Asumimos que el usuario_destino es quien realizó la acción en registros anteriores
UPDATE public.sgc_notificaciones 
SET id_usuario_accion = id_usuario_destino 
WHERE id_usuario_accion IS NULL;

-- Actualizar id_caso_autor basándose en el caso
UPDATE public.sgc_notificaciones n
SET id_caso_autor = c.idusuopr
FROM public.sgc_casos c
WHERE n.id_caso = c.idcaso 
AND n.id_caso_autor IS NULL;

-- ============================================
-- 6. VERIFICACIÓN
-- ============================================

-- Verificar que los campos fueron agregados
SELECT column_name, data_type 
FROM information_schema.columns 
WHERE table_name = 'sgc_notificaciones' 
AND column_name IN ('id_usuario_accion', 'id_rol_accion', 'id_caso_autor')
ORDER BY column_name;

-- Verificar conteo de registros
SELECT 
    COUNT(*) AS total_notificaciones,
    COUNT(id_usuario_accion) AS con_usuario_accion,
    COUNT(id_caso_autor) AS con_caso_autor
FROM public.sgc_notificaciones;

-- ============================================
-- NOTAS:
-- ============================================
-- 1. Este script es compatible con PostgreSQL
-- 2. Los campos son opcionales (nullable) para compatibilidad hacia atrás
-- 3. Las FK no se crean por defecto para evitar errores si los registros no existen
-- 4. Los índices condicionados mejoran el rendimiento de consultas específicas
-- 5. Para producción, se recomienda:
--    - Respaldar la base de datos antes de ejecutar
--    - Probar en un entorno de desarrollo primero
--    - Ejecutar durante horas de bajo uso

