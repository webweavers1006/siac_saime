# 📋 SISTEMA DE NOTIFICACIONES - DOCUMENTACIÓN TÉCNICA

## 📌 Resumen del Proyecto

Sistema completo de gestión de notificaciones con filtros avanzados (No leídas, Todas) y paginación, desarrollado en **CodeIgniter 4** con **JavaScript vanilla**.

---

## 🗂️ Estructura de Archivos Modificados

```
app/
├── Controllers/
│   └── Notificaciones_Controler.php    ✅ Endpoint para obtener todas las notificaciones
├── Models/
│   └── Notificaciones_Model.php        ✅ Nuevo método obtenerTodasLasNotificaciones()
└── Views/
    └── template/
        └── nav_bar.php                  ✅ Interfaz completa con filtros y paginación
```

---

## 🔧 FUNCIONALIDADES IMPLEMENTADAS

### 1. Filtros de Visualización

| Filtro | Descripción | Endpoint |
|--------|-------------|----------|
| **No leídas** | Muestra solo notificaciones pendientes de leer | `/notificaciones/obtenerMisNotificaciones` |
| **Todas** | Muestra notificaciones leídas y no leídas | `/notificaciones/obtenerTodasMisNotificaciones` |

### 2. Paginación

- **Items por página:** 10 notificaciones
- **Controles:** Anterior | Números | Siguiente
- **Info:** "Mostrando X-Y de Z notificaciones"
- **Visibilidad:** Solo se muestra cuando hay registros

### 3. Ordenamiento

- **Orden:** ASC (de la más antigua a la más reciente)
- **Campo:** `fecha_creacion`

### 4. Indicadores Visuales

| Elemento | Descripción |
|----------|------------|
| ⦿ Punto azul | Notificación no leída |
| ✓ Check verde | Notificación leída |
| 🔵 Badge "REMISIÓN" | Tipo de notificación |
| 🟡 Badge "SEGUIMIENTO" | Tipo de notificación |
| 🔴 Badge "CIERRE" | Tipo de notificación |

---

## 📐 ARQUITECTURA DEL SISTEMA

### A. MODELO (`Notificaciones_Model.php`)

#### Método Nuevo: `obtenerTodasLasNotificaciones()`

```php
/**
 * Obtener TODAS las notificaciones (leídas y no leídas) por usuario
 * 
 * @param int $id_usuario ID del usuario logueado
 * @param array $roles_permitidos Roles con permisos de supervisión
 * @param int|null $id_direccion_usuario ID de dirección administrativa
 * @param int|null $userrol Rol del usuario
 * @return array Lista de notificaciones
 */
public function obtenerTodasLasNotificaciones($id_usuario, $roles_permitidos = [], $id_direccion_usuario = null, $userrol = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_notificaciones n');
    
    // SELECT con JOINs
    $builder->select('n.*');
    $builder->select('dir_origen.descripcion as direccion_origen_nombre');
    $builder->join('sgc_casos c', 'n.id_caso = c.idcaso', 'left');
    $builder->join('sgc_usuario_operador autor_caso', 'n.id_caso_autor = autor_caso.idusuopr', 'left');
    $builder->join('sgc_usuario_operador usuario_accion', 'n.id_usuario_accion = usuario_accion.idusuopr', 'left');
    $builder->join('sgc_direcciones_administrativas dir_origen', 'n.direccion_origen = dir_origen.id', 'left');
    
    // Reglas de visualización por rol (igual que obtenerNotificacionesPorUsuario)
    // ... lógica de filtros según rol (supervisión, autor, dirección, etc.)
    
    // ⚠️ DIFERENCIA CLAVE: NO filtra por leida = false
    $builder->where('n.id_usuario_destino', $id_usuario);
    // ❌ Sin: $builder->where('n.leida', false);
    
    $builder->orderBy('n.fecha_creacion', 'ASC');
    $builder->limit(100); // Mayor límite para todas
    
    return $query->getResult();
}
```

#### Método Existente: `obtenerNotificacionesPorUsuario()`

```php
// Este método YA filtra por no leídas (leida = false)
$builder->where('n.leida', false);  // ← Filtro clave
$builder->orderBy('n.fecha_creacion', 'ASC');
$builder->limit(50);
```

---

### B. CONTROLADOR (`Notificaciones_Controler.php`)

#### Endpoint Nuevo: `obtenerTodasMisNotificaciones()`

```php
/**
 * Obtener todas las notificaciones (leídas y no leídas)
 */
public function obtenerTodasMisNotificaciones()
{
    if ($this->session->get('logged')) {
        $model = new Notificaciones_Model();
        $id_usuario = $this->session->get('iduser');
        $userrol = $this->session->get('userrol');
        $id_direccion = $this->session->get('id_direccion_administrativa');
        
        // Roles de supervisión
        $roles_supervision = [1, 3, 5];
        $es_supervision = in_array($userrol, $roles_supervision);
        $es_rol2 = ($userrol == 2);
        
        $notificaciones = [];
        
        if ($es_supervision) {
            $notificaciones = $model->obtenerTodasLasNotificaciones(
                $id_usuario, 
                $roles_supervision,
                $id_direccion,
                $userrol
            );
        } elseif ($es_rol2) {
            $notificaciones = $model->obtenerTodasLasNotificaciones(
                $id_usuario, 
                [2],
                $id_direccion,
                $userrol
            );
        } else {
            $notificaciones = $model->obtenerTodasLasNotificaciones(
                $id_usuario, 
                [],
                $id_direccion,
                $userrol
            );
        }
        
        return $this->respond([
            "message" => "success",
            "data" => $notificaciones
        ], 200);
    }
    
    return redirect()->to('/');
}
```

---

### C. VISTA (`nav_bar.php`)

#### 1. Variables Globales JavaScript

```javascript
// Estado de la aplicación de notificaciones
let currentFilter = 'unread';  // 'unread' | 'all'
let allNotifications = [];    // Cache de todas las notificaciones
let currentPage = 1;
const ITEMS_PER_PAGE = 10;
let paginationData = null;
```

#### 2. Función: `cargarNotificaciones()`

```javascript
function cargarNotificaciones() {
    let endpoint;
    
    if (currentFilter === 'unread') {
        endpoint = '/notificaciones/obtenerMisNotificaciones';
    } else {
        endpoint = '/notificaciones/obtenerTodasMisNotificaciones';
    }
    
    fetch(endpoint, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'success') {
            allNotifications = data.data;
            currentPage = 1;
            renderNotificaciones(paginarNotificaciones(allNotifications, currentPage));
            actualizarPaginacion();
        }
    });
}
```

#### 3. Función: `filtrarNotificaciones()`

```javascript
function filtrarNotificaciones(tipo) {
    currentFilter = tipo;
    currentPage = 1;
    
    // Actualizar botones visualmente
    document.getElementById('filter-unread').classList.toggle('active', tipo === 'unread');
    document.getElementById('filter-all').classList.toggle('active', tipo === 'all');
    
    // Recargar notificaciones
    cargarNotificaciones();
}
```

#### 4. Función: `paginarNotificaciones()`

```javascript
function paginarNotificaciones(notificaciones, pagina) {
    // Filtrar según el filtro actual
    let filtered = notificaciones.filter(notif => {
        if (currentFilter === 'unread') {
            return notif.leida !== true && notif.leida !== 't' && notif.leida !== 'true';
        }
        return true; // Mostrar todas
    });
    
    // Calcular paginación
    const totalItems = filtered.length;
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
    const startIndex = (pagina - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;
    
    // Guardar datos de paginación para uso en UI
    paginationData = {
        currentPage: pagina,
        totalPages: totalPages,
        total: totalItems,
        startIndex: startIndex,
        endIndex: Math.min(endIndex, totalItems)
    };
    
    return filtered.slice(startIndex, endIndex);
}
```

#### 5. Función: `renderizarPaginador()`

```javascript
function renderizarPaginador() {
    const container = document.getElementById('notification-pagination');
    const controlsContainer = container.querySelector('.pagination-controls');
    const infoContainer = container.querySelector('.pagination-info');
    
    // Ocultar si no hay datos
    if (!paginationData || paginationData.total === 0) {
        container.style.display = 'none';
        return;
    }
    
    container.style.display = 'flex';
    
    // Info: "Mostrando X-Y de Z notificaciones"
    infoContainer.textContent = `Mostrando ${paginationData.startIndex + 1}-${paginationData.endIndex} de ${paginationData.total}`;
    
    // Generar botones
    let html = '';
    
    // Botón Anterior
    html += `<button class="pagination-btn" onclick="irPagina(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
        <i class="fas fa-chevron-left"></i>
    </button>`;
    
    // Números de página
    for (let i = 1; i <= paginationData.totalPages; i++) {
        html += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="irPagina(${i})">${i}</button>`;
    }
    
    // Botón Siguiente
    html += `<button class="pagination-btn" onclick="irPagina(${currentPage + 1})" ${currentPage === paginationData.totalPages ? 'disabled' : ''}>
        <i class="fas fa-chevron-right"></i>
    </button>`;
    
    controlsContainer.innerHTML = html;
}
```

#### 6. Función: `irPagina()`

```javascript
function irPagina(pagina) {
    if (pagina < 1 || pagina > paginationData.totalPages) return;
    
    currentPage = pagina;
    renderNotificaciones(paginarNotificaciones(allNotifications, currentPage));
    actualizarPaginacion();
}
```

#### 7. Función: `renderNotificaciones()`

```javascript
function renderNotificaciones(notificaciones) {
    const container = document.getElementById('notification-list');
    
    if (!notificaciones || notificaciones.length === 0) {
        container.innerHTML = `
            <div class="empty-notifications">
                <i class="fas fa-bell-slash"></i>
                <p>${currentFilter === 'all' ? 'No hay notificaciones registradas' : 'No hay notificaciones sin leer'}</p>
            </div>`;
        return;
    }
    
    let html = '';
    notificaciones.forEach(notif => {
        const estaLeida = notif.leida === true || notif.leida === 't' || notif.leida === 'true';
        
        // Si el filtro es 'unread', solo mostrar no leídas
        if (currentFilter === 'unread' && estaLeida) return;
        
        const tipoClass = notif.tipo_notificacion === 'REMISION' ? 'text-primary' : 
                         (notif.tipo_notificacion === 'CIERRE' ? 'text-danger' : 'text-warning');
        const tipoIcon = notif.tipo_notificacion === 'REMISION' ? 'fa-file-import' : 
                        (notif.tipo_notificacion === 'CIERRE' ? 'fa-check-circle' : 'fa-tasks');
        
        const leidaClass = estaLeida ? 'read' : 'unread';
        const leidaIcon = estaLeida ? '<i class="fas fa-check" style="color: #28a745; margin-left: 5px;"></i>' : '';
        
        html += `
            <div class="notification-item ${leidaClass}" onclick="verNotificacion(${notif.id}, '${notif.tipo_notificacion}', ${notif.id_caso})">
                <h6>
                    <span class="leida-indicator"></span>
                    <span class="notif-negrilla-azul"><i class="fas ${tipoIcon} ${tipoClass}"></i> ${notif.tipo_notificacion}</span>${leidaIcon}
                </h6>
                <p class="notif-message">${notif.mensaje}</p>
                <div class="time">${formatDate(notif.fecha_creacion)}</div>
            </div>`;
    });
    
    container.innerHTML = html;
}
```

---

## 🎨 ESTILOS CSS PRINCIPALES

```css
/* Contenedor del menú */
.notification-menu {
    width: 420px;
    max-height: 70vh;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

/* Header con gradiente */
.dropdown-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    padding: 16px 18px;
}

/* Botones de filtro */
.notification-filter-btn {
    padding: 8px 12px;
    border: 1px solid #007bff;
    border-radius: 20px;
    background: white;
    color: #007bff;
}

.notification-filter-btn.active {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

/* Notificación no leída */
.notification-item.unread {
    background-color: #e8f4fd;
    border-left: 4px solid #007bff;
}

/* Indicador de leída */
.leida-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
}

.notification-item.unread .leida-indicator {
    background-color: #007bff;
}

.notification-item.read .leida-indicator {
    background-color: #28a745;
}
```

---

## 🔄 FLUJO DE DATOS

```
┌─────────────────────────────────────────────────────────────┐
│                    USUARIO HACE CLIC                        │
│                      en campana 🛎️                          │
└─────────────────────────┬───────────────────────────────────┘
                          ▼
┌─────────────────────────────────────────────────────────────┐
│              toggleNotifications()                           │
│              ↓                                              │
│              cargarNotificaciones()                          │
│              ↓                                              │
│         ¿currentFilter = 'unread'?                          │
│         /                    \                               │
│        SÍ                    NO                             │
│        ↓                      ↓                              │
│   /notificaciones/     /notificaciones/                    │
│   obtenerMisNotificaciones  obtenerTodasMisNotificaciones   │
│        ↓                      ↓                              │
│   [Solo no leídas]        [Todas (leídas + no leídas)]      │
│        ↓                      ↓                              │
│              renderNotificaciones(data)                     │
│              ↓                                              │
│              paginarNotificaciones()                         │
│              ↓                                              │
│              renderizarPaginador()                           │
└─────────────────────────────────────────────────────────────┘
```

---

## 📊 COMPARACIÓN DE ENDPOINTS

| Aspecto | No Leídas | Todas |
|---------|-----------|-------|
| **Endpoint** | `/obtenerMisNotificaciones` | `/obtenerTodasMisNotificaciones` |
| **Filtro SQL** | `WHERE leida = false` | Sin filtro leida |
| **Límite SQL** | 50 registros | 100 registros |
| **Filtro JS** | No necesario | No necesario |
| **Cache JS** | `allNotifications` | `allNotifications` |

---

## 🚀 CÓMO REPLICAR EN OTRO PROYECTO

### Paso 1: Agregar método al Modelo

```php
// En tu modelo de notificaciones
public function obtenerTodasLasNotificaciones($id_usuario, $roles = [], $direccion = null, $rol = null)
{
    $builder = $this->db->table('tu_tabla_notificaciones n');
    $builder->select('n.*');
    $builder->join('tu_tabla_casos c', 'n.id_caso = c.id', 'left');
    $builder->where('n.id_usuario', $id_usuario);
    // ⚠️ NO agregar: $builder->where('n.leida', false);
    $builder->orderBy('n.fecha_creacion', 'ASC');
    $builder->limit(100);
    
    return $builder->get()->getResult();
}
```

### Paso 2: Agregar endpoint al Controlador

```php
// En tu controlador de notificaciones
public function obtenerTodasMisNotificaciones()
{
    if (session()->get('logged')) {
        $model = new TuModelo();
        $id_usuario = session()->get('id');
        
        $data = $model->obtenerTodasLasNotificaciones($id_usuario);
        
        return $this->respond(["success" => true, "data" => $data]);
    }
    return redirect()->to('/login');
}
```

### Paso 3: Agregar botones de filtro en HTML

```html
<div class="notification-filters">
    <button class="notification-filter-btn active" id="filter-unread" onclick="filtrarNotificaciones('unread')">
        <i class="fas fa-envelope"></i> No leídas
    </button>
    <button class="notification-filter-btn" id="filter-all" onclick="filtrarNotificaciones('all')">
        <i class="fas fa-inbox"></i> Todas
    </button>
</div>
```

### Paso 4: Agregar JavaScript

Copia todas las funciones JavaScript del archivo `nav_bar.php`:
- `let currentFilter = 'unread';`
- `cargarNotificaciones()`
- `filtrarNotificaciones(tipo)`
- `paginarNotificaciones()`
- `renderizarPaginador()`
- `irPagina(pagina)`
- `renderNotificaciones()`

### Paso 5: Agregar CSS

Copia las clases CSS del `<style>` en `nav_bar.php`:
- `.notification-menu`
- `.notification-filters`
- `.notification-filter-btn`
- `.notification-item`
- `.notification-pagination`
- `.pagination-btn`

---

## 📝 Notas Importantes

1. **Orden ASC:** Las notificaciones más antiguas aparecen primero
2. **Filtro JS adicional:** Aunque el endpoint "Todas" trae todo, el filtro JS en `paginarNotificaciones()` filtra por `leida = false` cuando `currentFilter === 'unread'`
3. **Cache:** Se usa `allNotifications` para no hacer requests innecesarios al cambiar de página
4. **Límites:** 50 para no leídas, 100 para todas (ajustar según necesidades)

---

## ✅ Verificación de Funcionalidad

| Test | Resultado |
|------|-----------|
| Click en campana → abre dropdown | ✅ |
| Botón "No leídas" activo por defecto | ✅ |
| Muestra notificaciones no leídas | ✅ |
| Click en "Todas" → cambia vista | ✅ |
| Muestra notificaciones leídas y no leídas | ✅ |
| Paginador visible con registros | ✅ |
| Click en número de página → cambia vista | ✅ |
| Click en notificación → redirige al caso | ✅ |
| Badge contador muestra total no leídas | ✅ |

---

**Documentación generada:** $(date +%Y-%m-%d)
**Versión del sistema:** 1.0
**Framework:** CodeIgniter 4
