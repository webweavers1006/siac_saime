# Plan de Implementación: Notificaciones de Cambio de Estatus

## Objetivo
Hacer que las notificaciones lleguen a los roles 1, 3, 5 cuando un operador cambia el estatus de un caso.

## Problema Identificado
El método `cambioEstatus()` en `Estatus.php` crea un seguimiento pero NO genera ninguna notificación para los roles 1, 3, 5.

## Solución Implementada

### 1. Modificar `app/Controllers/Estatus.php` ✅
- [x] Importar `Notificaciones_Model`
- [x] Crear método privado `crearNotificacionCambioEstatus()`
- [x] Llamar el método después de insertar el seguimiento en `cambioEstatus()`

### 2. Modificar `app/Models/Estatus.php` ✅
- [x] Agregar método `obtenerEstatusPorId($idest)` para obtener el nombre del estatus

### 3. Verificar Modelo `Notificaciones_Model.php`
- [x] El modelo ya tiene el método `obtenerUsuariosPorRoles([1, 3, 5])`
- [x] El modelo ya tiene el método `insertarNotificacion()`
- [x] El modelo ya tiene el método `obtenerNombreDireccion()`

## Cambios Realizados

### En `app/Controllers/Estatus.php`:

1. **Agregar use statement:**
```php
use App\Models\Notificaciones_Model;
```

2. **Agregar método privado para crear notificación:**
```php
private function crearNotificacionCambioEstatus($id_caso, $nuevo_estatus)
{
    $notifModel = new Notificaciones_Model();
    $casoModel = new Casos();

    // Obtener información del caso
    $caso = $casoModel->obtenerCaso_id($id_caso);
    if ($caso) {
        $nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;

        // Obtener nombre del estatus
        $estatusModel = new Status();
        $estatus = $estatusModel->obtenerEstatusPorId($nuevo_estatus);
        $nombre_estatus = $estatus ? $estatus->estnom : 'Estatus #' . $nuevo_estatus;

        // Obtener nombre de la dirección del usuario que realiza el cambio
        $direccion_usuario_id = $this->session->get('id_direccion_administrativa');
        $nombre_direccion_usuario = $notifModel->obtenerNombreDireccion($direccion_usuario_id);

        // Incluir el ID del caso, el nuevo estatus y la dirección en el mensaje
        $mensaje = "El caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " ha cambiado al estatus: " . $nombre_estatus . ". Actualizado por: " . $nombre_direccion_usuario;

        // Obtener usuarios con roles 1, 3, 5
        $usuarios_roles = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);

        // Crear notificación para cada usuario
        foreach ($usuarios_roles as $usuario) {
            $notifModel->insertarNotificacion([
                "id_caso" => $id_caso,
                "tipo_notificacion" => "SEGUIMIENTO",
                "mensaje" => $mensaje,
                "leida" => false,
                "fecha_creacion" => date('Y-m-d H:i:s'),
                "id_usuario_destino" => $usuario->idusuopr,
                "direccion_origen" => $direccion_usuario_id
            ]);
        }
    }
}
```

3. **Llamar el método en `cambioEstatus()` después de insertar el seguimiento:**
```php
// Crear notificación para usuarios con roles 1, 3, 5
$this->crearNotificacionCambioEstatus($datos["caseid"], $data['idest']);
```

### En `app/Models/Estatus.php`:

1. **Agregar método para obtener estatus por ID:**
```php
public function obtenerEstatusPorId($idest){
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_estatus');
    $builder->select('*');
    $builder->where('idest', $idest);
    $query = $builder->get();
    return $query->getRow();
}
```

## Verificación
- [ ] Probar cambiando el estatus de un caso
- [ ] Verificar que lleguen notificaciones a usuarios con roles 1, 3, 5
- [ ] Verificar que el contador de notificaciones se actualice correctamente

