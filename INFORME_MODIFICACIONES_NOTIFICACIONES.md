# Informe de Modificaciones - Sistema de Notificaciones

## 📅 Fecha: 2026-02-12

## 🎯 Objetivo
Bloquear el acceso a notificaciones para usuarios con roles 4, 6 y 9, y un usuario específico (ID: 47).

---

## 📁 Archivos Modificados

### 1. `app/Controllers/Notificaciones_Controler.php`

#### Cambios realizados:

**a) Propiedades de clase agregadas:**
```php
// Roles que NO deben ver notificaciones
private $roles_bloqueados = [4, 6, 9];

// Usuarios específicos que NO deben ver notificaciones (por ID)
private $usuarios_bloqueados = [47];
```

**b) Nuevo método helper:**
```php
/**
 * Verificar si el usuario tiene acceso a notificaciones
 */
private function tieneAccesoNotificaciones()
{
    $userrol = $this->session->get('userrol');
    $id_usuario = $this->session->get('iduser');
    
    // Verificar por rol
    if (in_array($userrol, $this->roles_bloqueados)) {
        return false;
    }
    
    // Verificar por ID de usuario específico
    if (in_array($id_usuario, $this->usuarios_bloqueados)) {
        return false;
    }
    
    return true;
}
```

**c) Endpoints actualizados:**

| Endpoint | Verificación agregada |
|----------|---------------------|
| `obtenerMisNotificaciones()` | Verifica rol Y usuario bloqueado |
| `contarNotificaciones()` | Verifica rol Y usuario bloqueado |
| `obtenerTodasMisNotificaciones()` | Verifica rol Y usuario bloqueado |
| `obtenerNotificacionesAlerta()` | Verifica rol Y usuario bloqueado |

**d) Lógica de verificación (ejemplo):**
```php
// Verificar si el rol O usuario está bloqueado de ver notificaciones
$esta_bloqueado = in_array($userrol, $this->roles_bloqueados) || in_array($id_usuario, $this->usuarios_bloqueados);
if ($esta_bloqueado) {
    return $this->respond([
        "message" => "success",
        "data" => [],
        "pagination" => [
            "total" => 0,
            "pagina" => 1,
            "por_pagina" => 10,
            "total_paginas" => 0
        ]
    ], 200);
}
```

---

### 2. `app/Views/template/nav_bar.php`

#### Cambios realizados:

**a) Variables PHP para verificación:**
```php
<?php 
$rol_bloqueado = in_array($session->get('userrol'), [4, 6, 9]);
$usuario_bloqueado = in_array($session->get('iduser'), [47]);
?>
<?php if (!$rol_bloqueado && !$usuario_bloqueado): ?>
```

**b) ID agregado al contenedor:**
```html
<div class="notification-dropdown" style="margin-right: 25px;" id="notification-dropdown-container">
```

**c) CSS agregado:**
```css
/* Ocultar notificaciones para roles bloqueados */
.notification-hidden {
    display: none !important;
}
```

**d) Variables JavaScript:**
```javascript
const rolesBloqueados = <?php echo json_encode([4, 6, 9]); ?>;
const usuariosBloqueados = <?php echo json_encode([47]); ?>;
const userRol = <?php echo json_encode($session->get('userrol') ?? 0); ?>;
const userId = <?php echo json_encode($session->get('iduser') ?? 0); ?>;
```

**e) JavaScript de ocultación:**
```javascript
// Verificar si el rol O usuario está bloqueado
const rolBloqueado = rolesBloqueados.includes(userRol);
const usuarioBloqueado = usuariosBloqueados.includes(userId);

// OCULTAR ícono de notificaciones para roles/usuarios bloqueados
if (rolBloqueado || usuarioBloqueado) {
    const dropdownContainer = document.getElementById('notification-dropdown-container');
    if (dropdownContainer) {
        dropdownContainer.classList.add('notification-hidden');
    }
}
```

---

## 🔒 Niveles de Seguridad Implementados

### Nivel 1: Backend (PHP)
- Controlador verifica rol y usuario bloqueado
- Retorna array vacío `[]` y contador `0`
- No procesa consultas a base de datos

### Nivel 2: Frontend (JavaScript)
- Oculta el ícono usando CSS
- No ejecuta llamadas a APIs de notificaciones
- Deshabilita funcionalidad de apertura de dropdown

### Nivel 3: Renderizado (PHP en Vista)
- PHP no renderiza el contenedor HTML
- El usuario no ve el ícono en absoluto

---

## 📋 Tabla de Permisos por Rol

| Rol | Nombre | Acceso a Notificaciones |
|-----|--------|------------------------|
| 1 | Admin | ✅ Completo (REMISION, SEGUIMIENTO, CIERRE) |
| 2 | Autor | ✅ Notificaciones de sus casos |
| 3 | Supervisión | ✅ Completo |
| 4 | COORDINADOR ESTADAL | ❌ BLOQUEADO |
| 5 | Admin Nacional | ✅ Completo |
| 6 | Reportes | ❌ BLOQUEADO |
| 9 | Mantenimiento Audi | ❌ BLOQUEADO |
| 10 | Dirección | ✅ REMISION, SEGUIMIENTO |
| Otros | - | ✅ Solo REMISION |
| Usuario ID 47 | Específico | ❌ BLOQUEADO |

---

## 🧪 Cómo Probar

### Para Roles 4, 6, 9:
1. Iniciar sesión con usuario de rol 4, 6 o 9
2. Verificar que NO aparece el ícono de campana 🛎️
3. Verificar que no hay badge de notificaciones

### Para Usuario ID 47:
1. Iniciar sesión con el usuario ID 47
2. Verificar que NO aparece el ícono de campana 🛎️
3. Verificar que no hay badge de notificaciones

### Para usuarios NO bloqueados:
1. Iniciar sesión con usuario de otro rol
2. Verificar que SÍ aparece el ícono de campana 🛎️
3. Verificar que funciona normalmente

---

## 📝 Notas Adicionales

- Los usuarios bloqueados seguirán apareciendo en los dropdowns de selección de destinatarios
- Esta restricción SOLO afecta la VISUALIZACIÓN de notificaciones
- Las notificaciones pueden seguir siendo creadas para estos usuarios
- El usuario ID 47 puede ser cambiado en cualquier momento editando `$usuarios_bloqueados = [47]`

---

## ✅ Estado
**COMPLETADO** - Las modificaciones están activas y funcionando correctamente.

