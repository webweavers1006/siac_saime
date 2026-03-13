# INFORME TÉCNICO: FUNCIONAMIENTO DE SELECTS - VÍA DE ATENCIÓN, TIPO DE ATENCIÓN Y DETALLE DE ATENCIÓN

## 1. RESUMEN GENERAL

Este documento explica cómo funciona la cascada de selects en el módulo "Agregar Caso" del sistema SIAC SAPI. La relación es jerárquica:

```
VÍA DE ATENCIÓN (Red Social)
        ↓
TIPO DE ATENCIÓN (depende de la Vía seleccionada)
        ↓
DETALLE DE ATENCIÓN (opcional, depende del Tipo seleccionado)
```

---

## 2. ESTRUCTURA DE LA CASCADA DE SELECTS

### 2.1 Relación entre Tablas

El sistema utiliza tres tablas principales en la base de datos:

| Tabla | Descripción |
|-------|-------------|
| `sgc_redes_sociales` | Contiene las Vías de Atención |
| `sgc_tipoatencion_usu` | Contiene los Tipos de Atención |
| `sgc_tipoatenciondetalle` | Contiene los Detalles de Atención (hijos) |
| `sgc_via_tipo_atencion` | Tabla relacional many-to-many |

### 2.2 Diagrama de Relaciones

```
┌─────────────────────────────┐
│   sgc_redes_sociales       │
│   (Vía de Atención)        │
│   - red_s_id               │
│   - red_s_nom              │
└──────────────┬──────────────┘
               │
               │ 1:N
               ▼
┌─────────────────────────────┐
│   sgc_via_tipo_atencion   │
│   (Tabla Relacional)       │
│   - via_atencion_id        │──────────► FK: red_s_id
│   - tipo_atencion_id       │──────────► FK: tipo_aten_id
│   - borrado                │
└──────────────┬──────────────┘
               │
               │ N:1
               ▼
┌─────────────────────────────┐
│   sgc_tipoatencion_usu    │
│   (Tipo de Atención)       │
│   - tipo_aten_id           │
│   - tipo_aten_nombre       │
│   - act_pro_int            │
│   - organismo_pp           │
│   - act_coordenadas        │
│   - act_punto_cuenta       │
└──────────────┬──────────────┘
               │
               │ 1:N
               ▼
┌─────────────────────────────┐
│   sgc_tipoatenciondetalle │
│   (Detalle de Atención)    │
│   - tipo_atend_id          │
│   - tipo_atend_nombre      │
│   - tipo_aten_id           │──────────► FK: tipo_aten_id
└─────────────────────────────┘
```

---

## 3. FLUJO DE DATOS (FRONTEND → BACKEND)

### 3.1 Paso 1: Seleccionar Vía de Atención

Cuando el usuario selecciona una **Vía de Atención** (Red Social), se dispara el evento `change` que carga los Tipos de Atención asociados.

#### Código JavaScript (nuevo_caso.js):

```javascript
// Evento al cambiar la Vía de Atención
$("#red-social").on('change', function() {
    $("#red-social").removeClass('is-invalid');
    let id_red_social = $('#red-social').val();
    llenar_Tipo_Atencion(id_red_social);   
});
```

#### Función que carga los Tipos de Atención:

```javascript
function llenar_Tipo_Atencion(idRedSocial) {
    if (!idRedSocial) {
        let $select = $("#tipo-atencion-usu");
        $select.empty();
        $select.append("<option value='0' selected disabled>Seleccione</option>");
        return;
    }
    
    let url = "/buscar_via_tipo_atencion/" + idRedSocial;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            let $select = $("#tipo-atencion-usu");
            $select.empty();
            $select.append("<option value='0' selected disabled>Seleccione</option>");
            $.each(data, function(index, item) {
                $select.append($('<option></option>')
                    .val(item.tipo_atencion_id)
                    .text(item.tipo_aten_nombre)
                    .attr('data-act-pro-int', item.act_pro_int)
                    .attr('data-organismo_pp', item.organismo_pp)
                );
            });
        }
    });
}
```

---

### 3.2 Paso 2: Seleccionar Tipo de Atención

Cuando el usuario selecciona un **Tipo de Atención**, ocurren varios procesos:

1. Se muestra el modal de ayuda (`#ayudas`)
2. Se verifica si tiene hijos (Detalle de Atención)
3. Se verifica si tiene coordenadas habilitadas
4. Se muestran las secciones dinámicas correspondientes

#### Código JavaScript:

```javascript
$("#tipo-atencion-usu").on('change', function(e) {
    $("#ayudas").modal("show");
    document.getElementById("detalles_atencion").disabled = false;
    $("#hijos_tipoatencion").val('NO');
    
    let idTipoAtencion = $(this).val(); 
    let selectedOption = $(this).find('option:selected');

    // Obtener data attributes
    let actProInt = selectedOption.data('act-pro-int');
    let organismoPp = selectedOption.data('organismo_pp');
    
    // 1. Ocultar todas las secciones condicionales al inicio
    $("#mediacion").hide();
    $("#cgr").hide();

    // 2. Lógica de visibilidad exclusiva basada en el ID
    if (idTipoAtencion == 5 || idTipoAtencion == 1) {
        $("#denuncias").toggle(idTipoAtencion == 5); 
    } else if (idTipoAtencion == 23) {
        $("#mediacion").show();
        $("#denuncias").hide();
    } else {
        $("#denuncias").hide();
    }
    
    // 3. Lógica Común basada en Data Attributes
    $(".tipoproint").toggle(actProInt === 't');
    document.getElementById("tipo-pi").disabled = (actProInt !== 't');
    $(".org_pp").toggle(organismoPp === 't');
    document.getElementById("organismo-caso").disabled = (organismoPp !== 't');

    // 4. Verificar si tiene coordenadas habilitadas
    $.ajax({
        url: `/Listar_Tipo_Atencion_act_coordenadas/${idTipoAtencion}`,
        method: 'GET',
        dataType: 'json',
    })
    .done((response) => {
        const tipoAtencion = response[0]; 
        if (tipoAtencion && tipoAtencion.act_coordenadas === 't') {
            $(".mapa_ayuda").show();
            $("#actcoordenadas").val('t');
            map.invalidateSize();
        } else {
            $(".mapa_ayuda").hide();
            $("#actcoordenadas").val('f');
        }
    });

    // 5. Cargar detalles de atención (hijos)
    llenar_detalle_atencion(e, idTipoAtencion);
});
```

---

### 3.3 Paso 3: Cargar Detalle de Atención (Opcional)

Si el Tipo de Atención tiene hijos asociados, se habilita el select de Detalle de Atención.

#### Código JavaScript:

```javascript
function llenar_detalle_atencion(e, idTipoAtencion) {
    if (e && e.preventDefault) e.preventDefault();
    
    url = '/Listar_Detalle_Atencion_filtro';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length >= 1) {
                $('#detalles_atencion').empty();
                $('#detalles_atencion').append('<option value=0  selected disabled>Seleccione</option>');
                
                // Filtrar por tipo de atención si se proporciona
                if (idTipoAtencion !== undefined) {
                    data = data.filter(dato => dato.tipo_aten_id == idTipoAtencion);
                }
                
                $.each(data, function(i, item) {
                    $(".detelle_atencion").show();
                    $("#hijos_tipoatencion").val('SI');
                    $('#detalles_atencion').append(
                        '<option value=' + item.tipo_atend_id + '>' + item.tipo_atend_nombre + '</option>'
                    );
                });
            }
        }
    });
}
```

---

## 4. CONSULTAS SQL (BACKEND)

### 4.1 Obtener Tipos de Atención por Vía (buscar_via_tipo_atencion)

**Ubicación:** `app/Models/Via_Tipo_Atencion_Model.php`

```php
public function buscar_via_tipo_atencion($id_red_social = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('sgc_via_tipo_atencion as vt_atencion');
    
    // Selecciona los campos necesarios incluyendo los flags de comportamiento
    $builder->select(' 
        tu.organismo_pp,
        tu.act_pro_int, 
        tu.tipo_aten_nombre, 
        vt_atencion.id, 
        vt_atencion.via_atencion_id, 
        vt_atencion.tipo_atencion_id, 
        vt_atencion.borrado
    ');
    
    // Join con la tabla de tipos de atención
    $builder->join('sgc_tipoatencion_usu tu', 'vt_atencion.tipo_atencion_id = tu.tipo_aten_id');
    
    // Solo mostrar tipos de atención NO borrados
    $builder->where('vt_atencion.borrado', false);
    
    // Filtrar por vía de atención si se proporciona
    if ($id_red_social !== null) {
        $builder->where('vt_atencion.via_atencion_id', $id_red_social);
    }
    
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
```

#### SQL Generado (ejemplo para vía=1):

```sql
SELECT 
    tu.organismo_pp,
    tu.act_pro_int, 
    tu.tipo_aten_nombre, 
    vt_atencion.id, 
    vt_atencion.via_atencion_id, 
    vt_atencion.tipo_atencion_id, 
    vt_atencion.borrado
FROM sgc_via_tipo_atencion as vt_atencion
INNER JOIN sgc_tipoatencion_usu tu 
    ON vt_atencion.tipo_atencion_id = tu.tipo_aten_id
WHERE vt_atencion.borrado = false
    AND vt_atencion.via_atencion_id = 1;
```

---

### 4.2 Obtener Detalle de Atención por Tipo (buscar_hijos_detalle_atencion)

**Ubicación:** `app/Models/Tipo_Atencion_Detalle_Model.php`

```php
public function buscar_hijos_detalle_atencion($id_tipo_atencion = null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_tipoatenciondetalle as d');
    
    $builder->select('d.tipo_atend_id, d.tipo_atend_nombre, d.tipo_aten_id');
    $builder->select("CASE WHEN d.tipo_atend_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as tipo_atend_borrado");
    
    if ($id_tipo_atencion !== null) {
        $builder->where('d.tipo_aten_id', $id_tipo_atencion);
    }
    
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
```

#### SQL Generado (ejemplo para tipo=23):

```sql
SELECT 
    d.tipo_atend_id, 
    d.tipo_atend_nombre, 
    d.tipo_aten_id,
    CASE WHEN d.tipo_atend_borrado = 'f' THEN 'Activo' ELSE 'Inactivo' END as tipo_atend_borrado
FROM public.sgc_tipoatenciondetalle as d
WHERE d.tipo_aten_id = 23;
```

---

### 4.3 Verificar Flags de Comportamiento del Tipo de Atención

**Ubicación:** `app/Models/Tipo_Atencion_Usu_Model.php`

```php
public function Listar_Tipo_Atencion_act_coordenadas($idTipoAtencion=null)
{
    $db = \Config\Database::connect();
    $builder = $db->table('public.sgc_tipoatencion_usu as a_usu');    
    
    $builder->select('
        a_usu.act_punto_cuenta,
        a_usu.act_coordenadas, 
        a_usu.act_pro_int, 
        a_usu.tipo_aten_id, 
        a_usu.tipo_aten_nombre
    ');
    
    $builder->where('a_usu.tipo_aten_id', $idTipoAtencion);
    
    $query = $builder->get();
    $resultado = $query->getResult();
    return $resultado;
}
```

---

## 5. FLAGS DE COMPORTAMIENTO

Cada Tipo de Atención tiene campos booleanos que determinan su comportamiento en el formulario:

| Campo | Tabla | Descripción |
|-------|-------|-------------|
| `act_pro_int` | sgc_tipoatencion_usu | Muestra el select de Tipo de Propiedad Intelectual |
| `organismo_pp` | sgc_tipoatencion_usu | Muestra el select de Organismo del Poder Popular |
| `act_coordenadas` | sgc_tipoatencion_usu | Muestra el mapa de coordenadas |
| `act_punto_cuenta` | sgc_tipoatencion_usu | Habilita la opción de punto de cuenta |

### Ejemplo de Data Attributes en el Select:

```html
<select id="tipo-atencion-usu">
    <option value="1" data-act-pro-int="t" data-organismo_pp="f">Asesoría</option>
    <option value="5" data-act-pro-int="f" data-organismo_pp="t">Denuncias</option>
    <option value="23" data-act-pro-int="t" data-organismo_pp="f">Mediación</option>
</select>
```

---

## 6. EJEMPLO PRÁCTICO

### Escenario: Seleccionar "Red Social = 1" (Presencial)

1. **Usuario selecciona**: Vía de Atención = "Presencial" (ID=1)
2. **Sistema carga**: Tipos de Atención asociados a esa vía
3. **Usuario selecciona**: Tipo de Atención = "Mediación" (ID=23)
4. **Sistema verifica**:
   - `act_pro_int = 't'` → Muestra select "Tipo de Propiedad Intelectual"
   - `organismo_pp = 'f'` → Oculta select "Organismo del Poder Popular"
   - `act_coordenadas = ?` → Muestra/Oculta mapa de coordenadas
   - Consulta si tiene hijos → Carga "Detalle de Atención" si existe

---

## 7. RUTAS DEL CONTROLADOR

| Método | Ruta | Descripción |
|--------|-----|-------------|
| GET | `/buscar_via_tipo_atencion/{id_red_social}` | Obtiene tipos de atención por vía |
| GET | `/Listar_Tipo_Atencion_act_coordenadas/{id_tipo_atencion}` | Verifica flags de comportamiento |
| GET | `/buscar_hijos_detalle_atencion/{id_tipo_atencion}` | Obtiene detalles de atención |

---

## 8. DIAGRAMA DE FLUJO COMPLETO

```
┌──────────────────────────────────────────────────────────────┐
│                    USUARIO SELECCIONA                       │
│                    VÍA DE ATENCIÓN                         │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│  EVENTO: change en #red-social                              │
│  ► Llama a llenar_Tipo_Atencion(id_red_social)             │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│  AJAX: GET /buscar_via_tipo_atencion/1                     │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│  CONSULTA SQL:                                             │
│  SELECT * FROM sgc_via_tipo_atencion                       │
│  WHERE via_atencion_id = 1 AND borrado = false            │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│  LLENA SELECT: #tipo-atencion-usu                           │
│  CON DATA ATTRIBUTES: act_pro_int, organismo_pp            │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│                    USUARIO SELECCIONA                       │
│                    TIPO DE ATENCIÓN                         │
└─────────────────────────────┬────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│  EVENTO: change en #tipo-atencion-usu                      │
│  ► Oculta/Muestra secciones (#cgr, #denuncias, #mediacion) │
│  ► Verifica data-attributes (act_pro_int, organismo_pp)     │
│  ► AJAX: /Listar_Tipo_Atencion_act_coordenadas/23          │
│  ► AJAX: /buscar_hijos_detalle_atencion/23                 │
└─────────────────────────────┬────────────────────────────────┘
                              │
           ┌──────────────────┴──────────────────┐
           │                                     │
           ▼                                     ▼
┌─────────────────────┐               ┌─────────────────────┐
│ TIENE COORDENADAS  │               │  TIENE HIJOS        │
│ act_coordenadas=t  │               │  Detalle != null    │
└─────────┬───────────┘               └─────────┬───────────┘
          │                                     │
          ▼                                     ▼
┌─────────────────────┐               ┌─────────────────────┐
│ MUESTRA: .mapa_ayuda│               │ MUESTRA: #detalles_ │
│                    │               │ _atencion           │
└─────────────────────┘               └─────────────────────┘
```

---

*Documento generado automáticamente basado en el análisis del código fuente del sistema SIAC SAPI.*

