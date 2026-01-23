-- Script SQL para crear la tabla de notificaciones (CORREGIDO)
-- Ejecutar en PostgreSQL

-- Tabla para almacenar las notificaciones del sistema
CREATE TABLE IF NOT EXISTS public.sgc_notificaciones (
    id SERIAL PRIMARY KEY,
    id_caso INTEGER REFERENCES public.sgc_casos(idcaso) ON DELETE CASCADE,
    tipo_notificacion VARCHAR(50) NOT NULL DEFAULT 'REMISION', -- 'REMISION' o 'SEGUIMIENTO'
    mensaje TEXT NOT NULL,
    leida BOOLEAN NOT NULL DEFAULT FALSE,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_usuario_destino INTEGER NOT NULL REFERENCES public.sgc_usuario_operador(idusuopr) ON DELETE CASCADE,
    direccion_origen INTEGER REFERENCES public.sgc_direcciones_administrativas(id) ON DELETE SET NULL
);

-- Crear índice para búsquedas rápidas
CREATE INDEX IF NOT EXISTS idx_notificaciones_usuario ON public.sgc_notificaciones(id_usuario_destino);
CREATE INDEX IF NOT EXISTS idx_notificaciones_leida ON public.sgc_notificaciones(leida);
CREATE INDEX IF NOT EXISTS idx_notificaciones_tipo ON public.sgc_notificaciones(tipo_notificacion);
CREATE INDEX IF NOT EXISTS idx_notificaciones_fecha ON public.sgc_notificaciones(fecha_creacion DESC);

-- Agregar comentario a la tabla
COMMENT ON TABLE public.sgc_notificaciones IS 'Almacena las notificaciones del sistema para usuarios';
COMMENT ON COLUMN public.sgc_notificaciones.id IS 'Identificador único de la notificación';
COMMENT ON COLUMN public.sgc_notificaciones.id_caso IS 'ID del caso relacionado con la notificación';
COMMENT ON COLUMN public.sgc_notificaciones.tipo_notificacion IS 'Tipo de notificación: REMISION o SEGUIMIENTO';
COMMENT ON COLUMN public.sgc_notificaciones.mensaje IS 'Contenido del mensaje de la notificación';
COMMENT ON COLUMN public.sgc_notificaciones.leida IS 'Indica si la notificación ha sido leída';
COMMENT ON COLUMN public.sgc_notificaciones.fecha_creacion IS 'Fecha y hora de creación de la notificación';
COMMENT ON COLUMN public.sgc_notificaciones.id_usuario_destino IS 'ID del usuario que recibe la notificación';
COMMENT ON COLUMN public.sgc_notificaciones.direccion_origen IS 'ID de la dirección administrativa que origina la notificación';

-- Ejemplo de inserción para probar:
-- INSERT INTO public.sgc_notificaciones (id_caso, tipo_notificacion, mensaje, id_usuario_destino, direccion_origen)
-- VALUES (123, 'REMISION', 'Se le ha remitido el caso #123 de: Juan Pérez a su dirección (Dirección de Atención). Remitido por: Dirección de Coordinación', 5, 25);

