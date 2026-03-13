# INFORME TÉCNICO: MÓDULO AGREGAR CASO - SIAC SAPI

## 1. RESUMEN GENERAL

El módulo "Agregar Caso" (`vista_agregar_caso`) es un formulario wizard de 3 pasos que permite registrar nuevos casos en el sistema SIAC (Sistema de Atención al Ciudadano). El comportamiento del formulario cambia dinámicamente según el **Tipo de Atención** seleccionado.

---

## 2. ESTRUCTURA DE ARCHIVOS

| Archivo | Descripción |
|---------|-------------|
| `app/Views/casos/agregar_caso.php` | Vista principal con el formulario HTML |
| `public/custom/js/caso/nuevo_caso.js` | Lógica JavaScript (validaciones, AJAX, comportamiento dinámico) |
| `app/Controllers/Casos_Controler.php` | Controlador que procesa el registro del caso |

---

## 3. PASOS DEL FORMULARIO (WIZARD)

### 📌 Paso 1: Datos del Beneficiario

Contiene los siguientes campos:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| Nombre | Input Text | Primer nombre del beneficiario |
| Apellido | Input Text | Apellido del beneficiario |
| Tipo de Persona | Select | V (Venezolano), E (Extranjero), J (Jurídico), G (Gubernamental) |
| Nº Cédula o Rif | Input Text | Número de identificación |
| Fecha de Nac | Input Date | Fecha de nacimiento |
| Tipo de Beneficiario | Select | Tipo de beneficiario |
| Género | Select | Masculino/Femenino |
| Teléfono | Input Text | Teléfono de contacto |
| Fecha de Recibido | Input Date | Fecha de creación del caso |
| Vía de Atención | Select | Red social o vía de entrada |
| Dirección | Select | Dirección de atención (estatal/ciudadano) |
| Correo | Input Email | Correo electrónico |

---

### 📌 Paso 2: Dirección y Tipo de Atención

Contiene los siguientes campos:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| País | Select | País (por defecto Venezuela) |
| Estado | Select | Estado de residencia |
| Municipio | Select | Municipio de residencia |
| Parroquia | Select | Parroquia de residencia |
| **Tipo de Atención** | Select | **CAMPO CLAVE** - Dispara secciones dinámicas |
| Tipo de Propiedad Intelectual | Select | (Solo si act_pro_int = 't') |
| Organismo del Poder Popular | Select | (Solo si organismo_pp = 't') |
| Detalle Atención | Select | (Solo si el tipo tiene hijos) |

---

### 📌 Paso 3: Descripción del Caso

Contiene un campo de texto para describir el caso y el botón de guardar.

---

## 4. COMPORTAMIENTO POR TIPO DE ATENCIÓN

Esta es la lógica principal que maneja qué secciones se muestran según el Tipo de Atención seleccionado:

```javascript
$("#tipo-atencion-usu").on('change', function(e) {
    let idTipoAtencion = $(this).val(); 
    
    // Ocultar todas las secciones condicionales al inicio
    $("#mediacion").hide();
    $("#cgr").hide();

    // Lógica de visibilidad exclusiva basada en el ID
    if (idTipoAtencion == 5 || idTipoAtencion == 1) {
        $("#denuncias").toggle(idTipoAtencion == 5); 
    } else if (idTipoAtencion == 23) {
        $("#mediacion").show();
        $("#denuncias").hide();
    } else {
        $("#denuncias").hide();
    }
    
    // Lógica Común basada en Data Attributes
    $(".tipoproint").toggle(actProInt === 't');
    $(".org_pp").toggle(organismoPp === 't');
});
```

### 📊 Tabla de Comportamiento

| ID Tipo Atención | Nombre | Sección Mostrada | Descripción |
|------------------|--------|------------------|-------------|
| **1** | Asesoría | `#cgr` | Formulario CGR (Ente Adscrito, Competencia, Asume) |
| **5** | Denuncias | `#denuncias` | Formulario de Denuncias (Afectados, Hechos, Involucrados) |
| **23** | Mediación | `#mediacion` | Formulario de Mediación (Apoderados, Contraparte) |
| **Otro** | Otro | - | Solo datos básicos |

---

## 5. DETALLE DE SECCIONES POR TIPO

### 5.1 SECCIÓN ASESORÍA (ID = 1) - `#cgr`

```html
<div class="row" id="cgr" style="display: none;">
    <!-- Ente Adscrito -->
    <div class="col-lg-4">
        <label>Ente asdcrito</label>
        <select id="ente-adscrito">...</select>
    </div>
    <!-- Competencia CGR -->
    <div class="col-lg-3">
        <label>Competencia de CGR</label>
        <select id="competencia-cgr">
            <option value="1">Si</option>
            <option value="2">No</option>
        </select>
    </div>
    <!-- Asume CGR -->
    <div class="col-lg-3">
        <label>Asume CGR</label>
        <select id="asume-cgr">
            <option value="1">Si</option>
            <option value="2">No</option>
        </select>
    </div>
</div>
```

---

### 5.2 SECCIÓN DENUNCIAS (ID = 5) - `#denuncias`

```html
<div class="row" id="denuncias" style="display: none;">
    <!-- Radio buttons: ¿A quién afecta? -->
    <div class="col-lg-8">
        <label>A quien afecta el hecho:</label>
        <input type="radio" id="option-personal" name="option" value="personal">
        <input type="radio" id="option-comunidad" name="option" value="comunidad">
        <input type="radio" id="option-terceros" name="option" value="terceros">
    </div>
    
    <!-- Fecha de los hechos -->
    <div class="col-lg-2">
        <label>Fecha de los hechos</label>
        <input type="date" id="fecha-hechos">
    </div>
    
    <!-- Involucrados -->
    <div class="col-10">
        <label>Indique Personas, Organismos o Instituciones Involucradas:</label>
        <textarea id="denu-involucrados"></textarea>
    </div>
    
    <!-- Instancia del Poder Popular (opcional) -->
    <div class="col-11">
        <label>EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE:</label>
        <input type="text" id="nombre-instancia" placeholder="Nombre">
        <input type="text" id="rif-instancia" placeholder="RIF">
        <input type="text" id="ente-financiador" placeholder="Ente Financiador">
        <input type="text" id="nombre-proyecto" placeholder="Nombre del Proyecto">
        <input type="text" id="monto-aprovado" placeholder="Monto Aprobado">
    </div>
</div>
```

---

### 5.3 SECCIÓN MEDIACIÓN (ID = 23) - `#mediacion`

Esta es la sección más completa con tres sub-secciones:

```html
<div class="row" id="mediacion" style="display: none;">
    
    <!-- 5.3.1 Datos del Apoderado del Solicitante (Opcional) -->
    <div class="space-y-6">
        <h3>Datos del Apoderado del Solicitante</h3>
        <input type="checkbox" id="apoderado-solicitante-aplica"> Aplica
        
        <div id="apoderado-solicitante-content">
            <!-- Búsqueda por Cédula -->
            <input type="text" id="cedula-existente-apo-sol">
            <button id="btn_buscar_apo_sol">Buscar</button>
            
            <!-- Datos Personales -->
            <select id="apo_solicitente-ident-tipo"><option value="V">V</option></select>
            <input type="text" id="apoderado-solicitante-ci">
            <input type="text" id="apoderado-solicitante-impre">
            <input type="text" id="apoderado-solicitante-nombres">
            <input type="text" id="apoderado-solicitante-telefono">
            <input type="email" id="apoderado-solicitante-correo">
            
            <!-- Ubicación -->
            <select id="apoderado-solicitante-pais-select"></select>
            <select id="apoderado-solicitante-estado-select"></select>
            <select id="apoderado-solicitante-municipio-select"></select>
            <select id="apoderado-solicitante-parroquia-select"></select>
            <input type="text" id="apoderado-solicitante-direccion">
        </div>
    </div>
    
    <!-- 5.3.2 Datos de la Contraparte (OBLIGATORIO) -->
    <div class="space-y-6">
        <h3>Datos de la Contraparte</h3>
        
        <!-- Búsqueda -->
        <input type="text" id="cedula-existente-contra">
        <button id="btn_buscar_contra">Buscar</button>
        
        <!-- Datos Personales -->
        <input type="text" id="contraparte-nombre-razon" required>
        
        <select id="contraparte-ident-tipo">
            <option value="V">V - Venezolano</option>
            <option value="E">E - Extranjero</option>
            <option value="J">J - Jurídico</option>
            <option value="G">G - Gubernamental</option>
        </select>
        <input type="text" id="contraparte-ident-valor">
        
        <input type="text" id="contraparte-telefono" required>
        <input type="email" id="contraparte-correo" required>
        
        <!-- Ubicación -->
        <select id="contraparte-pais-select"></select>
        <select id="contraparte-estado-select"></select>
        <select id="contraparte-municipio-select"></select>
        <select id="contraparte-parroquia-select"></select>
        <input type="text" id="contraparte-direccion">
    </div>
    
    <!-- 5.3.3 Datos del Apoderado de la Contraparte (Opcional) -->
    <div class="space-y-6">
        <h3>Datos del Apoderado de la Contraparte</h3>
        <input type="checkbox" id="apoderado-contraparte-aplica"> Aplica
        
        <div id="apoderado-contraparte-content">
            <!-- Mismos campos que Apoderado del Solicitante -->
            <input type="text" id="cedula-existente-apo-contra">
            <button id="btn_buscar_apo_contra">Buscar</button>
            <!-- ... (campos similares) -->
        </div>
    </div>
    
</div>
```

---

### 5.4 CAMPOS COMUNES (TODOS LOS TIPOS)

Estos campos aparecen según la configuración del Tipo de Atención en la base de datos:

| Campo | ID CSS | Condición |
|-------|--------|-----------|
| Tipo de Propiedad Intelectual | `.tipoproint` | `act_pro_int = 't'` en la BD |
| Organismo del Poder Popular | `.org_pp` | `organismo_pp = 't'` en la BD |
| Mapa de Coordenadas | `.mapa_ayuda` | `act_coordenadas = 't'` en la BD |

---

### 5.5 MAPA DE COORDENADAS

Cuando el tipo de atención tiene configurado `act_coordenadas = 't'`, se muestra la sección del mapa:

```html
<div class="col-lg-12 col-sm-12 col-md-12 mapa_ayuda" style="display: none;">
    <!-- Formulario de coordenadas -->
    <div class="form-container">
        <h2>Coordenadas de la ubicación</h2>
        <label>Latitud:</label>
        <input type="text" id="latitude" placeholder="Ej: 10.4806">
        
        <label>Longitud:</label>
        <input type="text" id="longitude" placeholder="Ej: -66.9036">
        
        <label>Nombre del lugar:</label>
        <input type="text" id="locationName" placeholder="Ej: La Vega, Los Mangos">
        
        <button id="ubicar-btn">Ubicar en el mapa</button>
        <button id="limpiar-btn">Limpiar</button>
    </div>
    
    <!-- Contenedor del mapa Leaflet -->
    <div id="map" style="height: 400px;"></div>
</div>
```

#### Lógica de Visualización:

```javascript
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
})
```

---

## 6. FLUJO DE DATOS

### 6.1 Recolección de Datos en JavaScript

Cuando el usuario hace clic en "Guardar", el JavaScript recolecta los datos según el tipo de atención:

```javascript
// Ejemplo para Mediación (tipo_atencion === '23')
const datos_medicion = obtenerDatosMediacion();

const datos = {
    datos_medicion: datos_medicion,
    "social_network": $("#red-social").val(),
    "date-entry": $("#fecha-recibido").val(),
    "person-name": $("#nombre-persona").val(),
    // ... más campos
    "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
    "act_coordenadas": $("#actcoordenadas").val(),
    "latitud": $("#latitude").val(),
    "longitud": $("#longitude").val(),
    "nombre": $("#locationName").val(),
};

// Envío por AJAX
$.ajax({
    url: "/registrarCaso",
    method: "POST",
    data: { "data": btoa(JSON.stringify(datos)) },
    // ...
});
```

### 6.2 Procesamiento en el Controlador

El controlador `Casos_Controler.php` recibe los datos y los procesa según el tipo de atención, guardando en las tablas correspondientes.

---

## 7. VALIDACIONES IMPLEMENTADAS

### Paso 1 (Datos del Beneficiario):
- ✅ Fecha de recibido no mayor a hoy
- ✅ Nombre obligatorio
- ✅ Apellido obligatorio
- ✅ Cédula obligatoria
- ✅ Fecha de nacimiento obligatoria
- ✅ Tipo de beneficiario obligatorio
- ✅ Vía de atención obligatoria
- ✅ Correo electrónico obligatorio (formato válido)

### Paso 2 (Dirección y Tipo de Atención):
- ✅ Estado obligatorio
- ✅ Tipo de atención obligatorio
- ✅ Tipo de PI obligatorio (si tipo atención = 1)
- ✅ Tipo de PI obligatorio (si tipo atención = 23)
- ✅ Datos de contraparte obligatorios (si tipo atención = 23)
- ✅ Detalle de atención obligatorio (si act_coordenadas = 't')
- ✅ Datos de denuncia obligatorios (si tipo atención = 5)

### Paso 3 (Descripción):
- ✅ Descripción del caso obligatoria

---

## 8. DIAGRAMA DE FLUJO

```
                    ┌─────────────────────────────┐
                    │   AGREGAR CASO - SIAC SAPI   │
                    └──────────────┬──────────────┘
                                   │
                    ┌──────────────▼──────────────┐
                    │     1. Datos Beneficiario   │
                    │   (Nombre, Apellido, C.I., │
                    │   Teléfono, Correo, etc.)   │
                    └──────────────┬──────────────┘
                                   │
                    ┌──────────────▼──────────────┐
                    │  2. Dirección y Tipo Aten. │
                    │   (Estado, Municipio,      │
                    │    Tipo de Atención)        │
                    └──────────────┬──────────────┘
                                   │
              ┌────────────────────┼────────────────────┐
              │                    │                    │
   ┌──────────▼──────────┐ ┌──────▼───────┐ ┌──────────▼──────────┐
   │   Tipo = 1 (Asesoría)│ │ Tipo=5(Denunc)│ │ Tipo=23(Mediación) │
   │   Muestra: #cgr     │ │ Muestra:     │ │ Muestra: #mediacion │
   │   - Ente Adscrito   │ │ #denuncias   │ │ - Apoderado Solic.  │
   │   - Competencia CGR │ │ - Afectados │ │ - Contraparte       │
   │   - Asume CGR       │ │ - Hechos    │ │ - Apoderado Contra. │
   └─────────────────────┘ │ - Involuc.  │ └─────────────────────┘
                           └─────────────┘
                                   │
                    ┌──────────────▼──────────────┐
                    │    3. Descripción Caso     │
                    │   ( textarea + Guardar )   │
                    └────────────────────────────┘
```

---

## 9. NOTAS IMPORTANTES

1. **Sección de Coordenadas**: El mapa de coordenadas se muestra SIEMPRE que el tipo de atención tenga configurado `act_coordenadas = 't'` en la base de datos, independientemente del ID del tipo de atención.

2. **Validaciones Específicas**: 
   - Para Denuncias (ID=5): Requiere indicar a quién afecta, fecha de hechos e involucrados.
   - Para Mediación (ID=23): Requiere datos de la contraparte (nombre, teléfono, correo).

3. **Búsqueda de Cédula**: El sistema permite buscar terceros existentes en la base de datos para autocompletar los campos de mediación.

4. **Transiciones UI**: Las secciones de mediación tienen efectos de transición (slide-up/slide-down) para mostrar/ocultar los campos opcionales de apoderos.

---

*Documento generado automáticamente basado en el análisis del código fuente del módulo Agregar Caso del sistema SIAC SAPI.*

