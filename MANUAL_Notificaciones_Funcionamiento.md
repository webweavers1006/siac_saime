# MANUAL TÉCNICO: Sistema de Notificaciones - Bandeja de Notificaciones

## 📋 Resumen General

El sistema de notificaciones implementa reglas de visualización según el rol del usuario, optimizado para PHP 8.4.

---

## 🎯 REGLAS DE NEGOCIO IMPLEMENTADAS

### Rol 1, 3, 5 - Supervisión
| Regla | Descripción |
|-------|-------------|
| Visibilidad | Ve seguimientos, remisiones y cierres de OTRAS direcciones |
| Autocierre | ❌ No ve notificaciones de SUS PROPIAS acciones |
| Cierre Rol 2 | ❌ No ve casos cerrados por usuarios con Rol 2 |

### Rol 2 - Autor del Caso
| Regla | Descripción |
|-------|-------------|
| Visibilidad | Solo ve seguimientos de casos que ÉL CREÓ |
| Ejemplo | Si crea "Caso A" → remite a "Dirección X" → cuando "Dirección X" agrega avance → Rol 2 recibe notificación |

### Otras Direcciones
| Regla | Descripción |
|-------|-------------|
| Visibilidad | Solo ve casos REMITIDOS a SU dirección |
| Historial | Acceso a seguimientos mientras el caso esté bajo su cargo |

---

## 🔄 FLUJO COMPLETO DE NOTIFICACIONES

### 1. ESCENARIO: REMISIÓN DE CASO

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   USUARIO A     │     │   SISTEMA       │     │  USUARIO B      │
│   (Remite)      │     │                 │     │  (Recibe)       │
└────────┬────────┘     └─────────────────┘     └────────┬────────┘
         │                                               ▲
         │ POST /casos/remitirCaso()                     │
         │                                               │
         │ Datos del caso:                               │
         │ - id_caso: 123                               │
         │ - id_usuario_accion: A (quien remite)       │
         │ - id_rol_accion: [rol de A]                  │
         │ - id_caso_autor: [autor original del caso]   │
         │                                               │
         ▼                                               │
┌───────────────────────────────────────────────────────┐
│           Casos_Controler::crearNotificacionRemision()│
│                                                       │
│  1. Obtener datos del caso                            │
│  2. Identificar autor original del caso               │
│  3. Crear notificaciones:                             │
│     a) Usuarios de DIRECCIÓN DESTINO                   │
│     b) Autor original (SI tiene Rol 2)                 │
│                                                       │
└───────────────────────────────────────────────────────┘
         │
         │ INSERT INTO sgc_notificaciones (...)
         │
         ▼
┌───────────────────────────────────────────────────────┐
│               TRIGGERS DE VISUALIZACIÓN               │
│  (Se activan cuando el usuario consulta sus notifs)  │
│                                                       │
│  Si usuario_destino es Rol 1,3,5:                    │
│    - WHERE id_usuario_accion != usuario_actual        │
│    - Excluir cierres por Rol 2                       │
│                                                       │
│  Si usuario_destino es Rol 2:                         │
│    - WHERE id_caso_autor = usuario_actual             │
│    - Solo ve seguimientos                             │
└───────────────────────────────────────────────────────┘
```

### 2. ESCENARIO: AGREGAR SEGUIMIENTO

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   USUARIO X     │     │   SISTEMA       │     │  ROLES 1,3,5    │
│   (Agrega)      │     │                 │     │  (Supervisión)  │
└────────┬────────┘     └─────────────────┘     └────────┬────────┘
         │                                               ▲
         │ POST /seguimientos/addSeguimiento()            │
         │                                               │
         │ Datos:                                        │
         │ - id_caso: 123                                │
         │ - id_usuario_accion: X (quien agrega)         │
         │ - id_rol_accion: [rol de X]                   │
         │ - id_caso_autor: [autor original]             │
         │                                               │
         ▼                                               │
┌───────────────────────────────────────────────────────┐
│      Seguimiento_Controler::crearNotificacionSeg()   │
│                                                       │
│  1. Obtener usuarios con Rol 1, 3, 5                  │
│  2. Para CADA usuario de supervisión:                  │
│     - INSERT INTO sgc_notificaciones                   │
│     - NO incluir si es el mismo usuario               │
│                                                       │
│  3. SI autor_original != usuario_actual Y autor=Rol 2:│
│     - INSERT INTO sgc_notificaciones (autor)          │
└───────────────────────────────────────────────────────┘
         │
         ▼
    USUARIO B (Autor original, Rol 2)
    └─ Recibe notificación especial:
       "Nuevo avance en SU caso #123..."
```

### 3. ESCENARIO: CAMBIO DE ESTATUS

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   USUARIO Y     │     │   SISTEMA       │     │  ROLES 1,3,5    │
│   (Cambia)      │     │                 │     │  (Supervisión)  │
└────────┬────────┘     └─────────────────┘     └────────┬────────┘
         │                                               ▲
         │ POST /estatus/cambioEstatus()                  │
         │                                               │
         │ Datos:                                        │
         │ - id_caso: 123                                │
         │ - nuevo_estatus: [1=Abierto, 2=Cerrado]      │
         │ - id_usuario_accion: Y                        │
         │ - id_rol_accion: [rol de Y]                   │
         │                                               │
         ▼                                               │
┌───────────────────────────────────────────────────────┐
│     Estatus::crearNotificacionCambioEstatus()        │
│                                                       │
│  CASO ESPECIAL: CIERRE POR ROL 2                    │
│  ─────────────────────────────────                     │
│  SI (nuevo_estatus == 2) AND (id_rol_accion == 2):   │
│     → NO enviar notificación a supervisión              │
│     → Implementa regla: "No visualizar casos          │
│       cerrados por usuarios con Rol 2"                 │
│                                                       │
│  CASO NORMAL:                                        │
│  → Enviar a Roles 1,3,5                              │
│  → SI autor != usuario_actual Y autor=Rol 2:          │
│     → Enviar notificación especial al autor            │
└───────────────────────────────────────────────────────┘
```

---

## 📊 ESTRUCTURA DE LA TABLA

```sql
CREATE TABLE sgc_notificaciones (
    id              SERIAL PRIMARY KEY,
    id_caso         INTEGER,
    tipo_notificacion VARCHAR(50) DEFAULT 'REMISION', -- 'REMISION' | 'SEGUIMIENTO'
    mensaje         TEXT NOT NULL,
    leida           BOOLEAN DEFAULT FALSE,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Destinatario (quién debe verla)
    id_usuario_destino INTEGER NOT NULL,
    
    -- Campos para reglas de visualización (NUEVOS)
    id_usuario_accion INTEGER NOT NULL,   -- Quién generó la acción
    id_rol_accion     INTEGER NOT NULL,   -- Rol de quien generó la acción
    id_caso_autor    INTEGER NOT NULL,   -- Autor original del caso
    direccion_origen  INTEGER
);
```

---

## 🔍 CONSULTA DE NOTIFICACIONES POR ROL

### Para Roles 1, 3, 5 (Supervisión):
```sql
SELECT * FROM sgc_notificaciones n
JOIN sgc_casos c ON n.id_caso = c.idcaso
WHERE n.id_usuario_destino = :idusuario
  AND n.id_usuario_accion != :idusuario  -- Excluir auto-acciones
  -- Excluir cierres por Rol 2 (se hace al crear la notificación)
  AND (n.tipo_notificacion IN ('REMISION', 'SEGUIMIENTO'))
ORDER BY n.fecha_creacion DESC;
```

### Para Rol 2 (Autor):
```sql
SELECT * FROM sgc_notificaciones n
JOIN sgc_casos c ON n.id_caso = c.idcaso
WHERE n.id_usuario_destino = :idusuario
  AND c.idusuopr = :idusuario  -- Solo casos que YO creé
  AND n.id_usuario_accion != :idusuario  -- Excluir mis propias acciones
  AND n.tipo_notificacion = 'SEGUIMIENTO'  -- Solo seguimientos
ORDER BY n.fecha_creacion DESC;
```

### Para Otras Direcciones:
```sql
SELECT * FROM sgc_notificaciones n
WHERE n.id_usuario_destino = :idusuario
  AND n.tipo_notificacion = 'REMISION'  -- Solo remisiones
ORDER BY n.fecha_creacion DESC;
```

---

## 📋 CASOS DE USO RESUMIDOS

| Escenario | Rol Emisor | Roles Notificados | Mensaje |
|-----------|------------|-------------------|---------|
| Caso remitido | Cualquiera | Dirección destino + Autor (si es Rol 2) | "Se le ha remitido el caso..." |
| Seguimiento agregado | Cualquiera | Roles 1,3,5 + Autor (si es Rol 2) | "Nuevo seguimiento en el caso..." |
| Caso cerrado | Rol 2 | SOLO Autor | "Su caso fue cerrado..." |
| Caso cerrado | Otro rol | Roles 1,3,5 + Autor (si es Rol 2) | "El caso fue cerrado por..." |
| Estatus cambiado | Cualquiera | Roles 1,3,5 + Autor (si es Rol 2) | "El caso fue actualizado al estatus..." |

---

## 🛠️ MÉTODOS DEL MODELO

### `Notificaciones_Model.php`

```php
// Insertar notificación
insertarNotificacion(array $datos): bool

// Obtener notificaciones con filtros por rol
obtenerNotificacionesPorUsuario(
    $id_usuario, 
    $roles_permitidos = [],    // [1,3,5] o [2] o []
    $id_direccion_usuario = null,
    $userrol = null
): array

// Contar no leídas con filtros
contarNoLeidas(
    $id_usuario, 
    $roles_permitidos = [],
    $id_direccion_usuario = null,
    $userrol = null
): int

// Verificar si el caso fue cerrado por Rol 2
verificarCierrePorRol2($id_caso): bool

// Obtener usuario por ID
obtenerUsuarioPorId($idusuopr): object|null

// Obtener nombre de dirección
obtenerNombreDireccion($id_direccion): string
```

---

## 📁 ARCHIVOS MODIFICADOS

| Archivo | Cambios Principales |
|---------|-------------------|
| `Notificaciones_Model.php` | Filtros por rol en consultas |
| `Casos_Controler.php` | Nuevo campo `id_caso_autor`, notificación a autor Rol 2 |
| `Seguimiento_Controler.php` | Notificación a supervisión y autor |
| `Estatus.php` | Regla especial para cierres por Rol 2 |
| `Notificaciones_Controler.php` | Lógica de filtros en endpoints |

---

## ⚠️ NOTAS IMPORTANTES

1. **Los campos ya existen** en la tabla `sgc_notificaciones`
2. **No hay migración necesaria** si los campos ya están agregados
3. **Logging en**: `/writable/logs/` con tag `debug`
4. **PHP 8.4**: Código optimizado con null coalescing y match expressions

---

## 🧪 PRUEBAS RECOMENDADAS

1. ✅ Usuario Rol 1 remite caso → Usuario Rol 3 debe ver notificación
2. ✅ Usuario Rol 2 crea caso → Lo remite → Usuario Rol 4 agrega seguimiento → Rol 2 debe ver notificación
3. ✅ Usuario Rol 2 cierra caso → Roles 1,3,5 NO deben ver notificación
4. ✅ Usuario Rol 1 agrega seguimiento → NO debe verse a sí mismo
5. ✅ Contador de notificaciones debe reflejar solo las visibles

---

## 📞 SOPORTE

Para depuración, revisar los logs en:
```
/var/www/html/siac_v2/writable/logs/
```

Buscar mensajes con tag `DEBUG` y contenido relacionado a notificaciones.
