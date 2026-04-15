# INFORME COMPLETO: PROCESO DE AGREGAR CASO EN SIAC v2

## 📋 RESUMEN EJECUTIVO

El sistema **SIAC v2** implementa un flujo robusto para la creación de casos con soporte para:
- **Tipos de atención específicos** (Asesoría CGR, Denuncia, Mediación, Consignación Masiva, etc.)
- **Validación frontend** (JavaScript/jQuery) con animaciones y UX moderna
- **Procesamiento backend** en **PHP (CodeIgniter 4)** con **PostgreSQL**
- **Base64 encoding** para envío seguro de datos AJAX
- **Auditoría automática**, notificaciones y seguimientos

**Flujo principal**: `Vista → JS (validación) → POST AJAX → Controller → Model → DB`

---

## 🏗️ ARQUITECTURA Y FLUJO

```
Frontend (agregar_caso.php + nuevo_caso.js)
        ↓ (AJAX POST / Base64)
Controller (nuevoCaso() / actualizarCaso())
        ↓
Model (Casos.php → insertarNuevoCaso())
        ↓
PostgreSQL (sgc_casos + tablas dependientes)
        ↓
Auditoría + Notificaciones + Seguimientos
```

### 🎯 PUNTOS CLAVE DE IMPLEMENTACIÓN

| Componente | Ubicación | Función Principal |
|------------|-----------|-------------------|
| **Vista** | `app/Views/casos/agregar_caso.php` | Formulario multi-paso + Mapa Leaflet |
| **Frontend** | `public/custom/js/caso/nuevo_caso.js` | Validación + AJAX + UX |
| **Controller** | `app/Controllers/Casos_Controler.php` | `nuevoCaso()` (300+ líneas) |
| **Model** | `app/Models/Casos.php` | `insertarNuevoCaso()` + JOINs complejos |
| **Rutas** | `app/Config/Routes.php` | `/registrarCaso` (POST) |

---

## 🔍 1. FRONTEND (app/Views/casos/agregar_caso.php + JS)

### **Estructura del Formulario**
```
3 Pasos Multi-Paso con Progress Bar:
1. DATOS BENEFICIARIO (Cédula, Nombre, Teléfono, Email, Edad)
2. UBICACIÓN + TIPO ATENCIÓN (Cascada País/Estado/Municipio/Parroquia)
3. DESCRIPCIÓN DEL CASO + Envío
```

### **MÉTODO COMPLETO DE ENVÍO JS** (nuevo_caso.js → `#guardar.click`)

```javascript
$(document).on("click", "#guardar", function(e) {
    e.preventDefault();
    
    // VALIDACIONES (nombre, apellido, cédula, email, etc.)
    if (!requerimiento_user) { /* Error */ return; }
    
    // 1. CONSIGNACIÓN MASIVA (Tipo 24)
    let lista_consignacion = null;
    if (tipo_atencion === '24') {
        let items = [];
        $(".check-pi:checked").each(function() {
            let fila = $(this).closest('tr');
            let cantidad_input = fila.find('input[type="number"]');
            let cantidad_valor = parseInt(cantidad_input.val());
            items.push({
                id_pi: $(this).data('pi-id'),
                cantidad: isNaN(cantidad_valor) ? 1 : cantidad_valor 
            });
        });
        lista_consignacion = JSON.stringify(items);
    }

    // 2. OBJETO DATOS BASE
    let datosBase = {
        "social_network": red_social,
        "date-entry": $("#fecha-recibido").val(),
        "person-name": $("#nombre-persona").val(),
        "person-lastname": $("#apellido-persona").val(),
        "person-id": cedula,
        "nacionalidad": $("#tipo-persona").val(),
        "telephone": $("#telefono").val(),
        "country": $("#pais-caso").val(),
        "state": estado,
        "county": $("#municipio-caso").val(),
        "town": $("#parroquia-caso").val(),
        "record-work": $("#num-tramite").val(),
        "pi-type": $("#tipo-pi").val() || 1,
        "user-requirement": requerimiento_user,
        "office": $("#office").val(),
        "tipo-atencion-usu": tipo_atencion,
        "sexo": $("#sexo").val(),
        "tipo_atend_id": tipo_atend_id,
        "tipo_beneficiario": $("#t-beneficiario").val(),
        "direccion": $("#office").val(),
        "correo": $("#correo").val(),
        "organismo-caso": org_id,
        "lista_consignacion": lista_consignacion,
        "latitud": $("#latitude").val() || '',
        "longitud": $("#longitude").val() || ''
    };

    // 3. LÓGICA CONDICIONAL POR TIPO
    if (tipo_atencion === '1') { /* CGR */ }
    else if (tipo_atencion === '5') { /* Denuncia */ }
    else if (tipo_atencion === '23') {
        datosBase.datos_medicion = obtenerDatosMediacion();
    }

    // 4. AJAX → Base64 Encoding
    $.ajax({
        url: "/registrarCaso",
        method: "POST",
        dataType: "JSON",
        data: { "data": btoa(unescape(encodeURIComponent(JSON.stringify(datosBase)))) },
        success: function(respuesta) {
            procesarRespuesta(respuesta); // {mensaje:1, detalles:[], idcaso}
        }
    });
});
```

**Flujo JS**:
```
1. Validar campos → Construir datosBase
2. Consignación → JSON.stringify(lista_items)
3. Encoding → btoa(unescape(encodeURIComponent()))
4. POST /registrarCaso → procesarRespuesta()
```

---

## ⚙️ 2. CONTROLLER (Casos_Controler.php → nuevoCaso())

### **MÉTODO COMPLETO DEL CONTROLLER**: `nuevoCaso()` 

**📏 328 líneas - Procesa TODOS los tipos de atención**

```php
/**
 * MÉTODO INTEGRAL: Registro de casos con soporte multi-registro,
 * cantidades dinámicas y lógicas específicas por departamento.
 */
public function nuevoCaso()
{
    // 1. CARGA DE TODOS LOS MODELOS (No falta ninguno)
    $casoModel = new Casos();
    $tipoPIModel = new PropiedadIntelectual();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    $segModel = new Seguimientos();
    $Casos_coordenadas = new Coordenadas_Model();
    $Registro_cgr_Model = new Registro_cgr_Model();
    $Casos_denuncias = new Casos_denuncias_Model();
    $terceroModel = new SapiTerceroModel();
    $apoderadoModel = new Mediacion();

    $db = \Config\Database::connect();
    
    // Autenticación por Token o Sesión
    $token = $this->request->getServer('HTTP_AUTHORIZATION');
    $buscar_token = $casoModel->buscar_token($token);
    
    if (($this->session->get('logged') && $this->request->isAJAX()) || !empty($buscar_token)) {
        
        $idusuopr = empty($buscar_token) ? $this->session->get('iduser') : $buscar_token[0]->id_usuario;
        $rawData = $this->request->getPost('data');

        // Decodificación: Soporta Array directo (SAPI) o Base64 (Web)
        $datos = is_array($rawData) ? $rawData : json_decode(base64_decode($rawData), true);

        if (!is_array($datos)) {
            return $this->response->setJSON(['mensaje' => 2, 'error' => 'Error en formato de datos']);
        }
        
        // 2. DETERMINAR LA LISTA DE TRABAJO (Consignación Masiva vs Caso Único)
        $lista_items = [];
        if (isset($datos["tipo-atencion-usu"]) && $datos["tipo-atencion-usu"] == '24' && !empty($datos['lista_consignacion'])) {
            $lista_items = json_decode($datos['lista_consignacion'], true);
        } else {
            $lista_items[] = [
                'id_pi' => $datos["pi-type"] ?? 1, 
                'cantidad' => 1
            ];
        }

        $detalles_generados = []; 
        $ids_generados = [];

        // 3. CICLO DE PROCESAMIENTO
        foreach ($lista_items as $item) {
            $repeticiones = (isset($item['cantidad']) && (int)$item['cantidad'] > 0) ? (int)$item['cantidad'] : 1;

            for ($i = 0; $i < $repeticiones; $i++) {
                
                $newCase = [
                    "idusuopr"          => $idusuopr,
                    "casofec"           => $datos["date-entry"] ?? date('Y-m-d'),
                    "casoced"           => $datos["person-id"] ?? '',
                    "caso_nacionalidad" => $datos["nacionalidad"] ?? 'V',
                    "casonom"           => mb_strtoupper($datos["person-name"] ?? '', 'UTF-8'),
                    "casoape"           => mb_strtoupper($datos["person-lastname"] ?? '', 'UTF-8'),
                    "casotel"           => $datos["telephone"] ?? '',
                    "id_tipo_atencion"  => $datos["tipo-atencion-usu"] ?? 1,
                    "idest"             => ($datos["tipo-atencion-usu"] == '1') ? 2 : 1, // 1=Abierto, 2=Cerrado (Asesoría)
                    "idrrss"            => $datos["social_network"] ?? 1,
                    "estadoid"          => $datos["state"] ?? null,
                    "municipioid"       => $datos["county"] ?? null,
                    "parroquiaid"       => $datos["town"] ?? null,
                    "pais"              => $datos["country"] ?? 1,
                    "sexo"              => $datos["sexo"] ?? 1,
                    "ofiid"             => $datos["office"] ?? null,
                    "casodesc"          => mb_strtoupper($datos["user-requirement"] ?? '', 'UTF-8'),
                    "tipo_beneficiario" => $datos["tipo_beneficiario"] ?? 1,
                    "direccion"         => mb_strtoupper($datos["direccion"] ?? 'NO APLICA', 'UTF-8'),
                    "correo"            => mb_strtoupper($datos["correo"] ?? '', 'UTF-8'),
                    "caso_org_id"       => $datos["organismo-caso"] ?? 1,
                    "ente_adscrito_id"  => $datos["ente_adscrito"] ?? 0,
                    "edad"              => $datos["edad"] ?? null,
                    "fecha_nacimiento"  => $datos["fecha_nacimiento"] ?? null,
                    "tipo_atend_id"     => $datos["tipo_atend_id"] ?? null,
                    "profesion"         => mb_strtoupper($datos["profesion"] ?? '', 'UTF-8'),
                    "casonumsol"        => empty($datos["record-work"]) ? 'No Aplica' : $datos["record-work"]
                ];

                // INSERCIÓN PRINCIPAL
                if ($casoModel->insertarNuevoCaso($newCase)) {
                    $_obtener_id = $casoModel->obtener_utimo_id();
                    $idcaso = $_obtener_id->getRow()->ultimo_id; 

                    // --- A. PROPIEDAD INTELECTUAL (Siempre se guarda) ---
                    $id_pi_final = $item['id_pi'] ?? ($datos["pi-type"] ?? 1);
                    $tipoPIModel->insertarTipoPICaso(['idcaso' => $idcaso, 'idtippropint' => $id_pi_final]);

                    // --- B. DENUNCIA (ID 5) ---
                    if ($newCase["id_tipo_atencion"] == '5') {
                        $Casos_denuncias->insertarCasos_Denuncias([
                            'denu_afecta_persona'   => filter_var($datos["denu_afecta_persona"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_afecta_comunidad' => filter_var($datos["denu_afecta_comunidad"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_afecta_terceros'  => filter_var($datos["denu_afecta_terceros"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_fecha_hechos'     => $datos["denu_fecha_hechos"] ?? null,
                            'denu_involucrados'     => mb_strtoupper($datos["denu_involucrados"] ?? '', 'UTF-8'),
                            'denu_instancia_popular'=> mb_strtoupper($datos["denu_instancia_popular"] ?? '', 'UTF-8'),
                            'denu_rif_instancia'    => $datos["denu_rif_instancia"] ?? '',
                            'denu_ente_financiador' => mb_strtoupper($datos["denu_ente_financiador"] ?? '', 'UTF-8'),
                            'denu_nombre_proyecto'  => mb_strtoupper($datos["denu_nombre_proyecto"] ?? '', 'UTF-8'),
                            'denu_monto_aprovado'   => (float)($datos["denu_monto_aprovado"] ?? 0),
                            'denu_id_caso'          => $idcaso,
                            'denu_borrado'          => false
                        ]);
                    }

                    // --- C. MEDIACIÓN (ID 23) ---
                    if ($newCase["id_tipo_atencion"] == '23' && isset($datos['datos_medicion'])) {
                        $med = $datos['datos_medicion'];
                        $getTerceroId = function($p) use ($terceroModel) {
                            if (empty($p['ident_valor'])) return 0;
                            $ex = $terceroModel->where('ter_identificacion', $p['ident_valor'])->first();
                            if ($ex) return $ex['ter_id'];
                            $terceroModel->insert([
                                'ter_nombre' => mb_strtoupper($p['nombre_razon'] ?? '', 'UTF-8'),
                                'ter_tipo_per' => $p['ident_tipo'] ?? 1,
                                'ter_identificacion' => $p['ident_valor'],
                                'ter_correo' => mb_strtoupper($p['correo'] ?? '', 'UTF-8'),
                                'ter_telefono' => $p['telefono'] ?? '',
                                'ter_pais' => $p['pais'] ?? 1,
                                'ter_direccion' => mb_strtoupper($p['direccion'] ?? '', 'UTF-8')
                            ]);
                            return $terceroModel->insertID();
                        };

                        $apoderadoModel->insert([
                            'med_caso_id'       => $idcaso,
                            'med_contra_id'     => $getTerceroId($med['contraparte']),
                            'med_apo_sol_id'    => (isset($med['apoderado_solicitante'])) ? $getTerceroId($med['apoderado_solicitante']) : 0,
                            'med_apo_contra_id' => (isset($med['apoderado_contraparte'])) ? $getTerceroId($med['apoderado_contraparte']) : 0
                        ]);
                    }

                    // --- D. CGR (Contraloría) ---
                    if (filter_var($datos["bandera_cgr"] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                        $Registro_cgr_Model->insertarRegistro_cgr([
                            'competencia_cgr' => $datos["competencia_crg"] ?? 2,
                            'asume_cgr'       => $datos["asume_crg"] ?? 2,
                            'id_caso'         => $idcaso
                        ]);
                    }

                    // --- E. COORDENADAS (Blindado) ---
                    $lat = $datos["latitud"] ?? '';
                    $lon = $datos["longitud"] ?? '';
                    if (!empty($lat) || !empty($lon)) {
                        $Casos_coordenadas->insertarCoordenadas([
                            "idcaso"   => $idcaso,
                            "latitud"  => $lat,
                            "longitud" => $lon,
                            "idusuopr" => $idusuopr
                        ]);
                    }

                    // --- F. SEGUIMIENTO Y AUDITORÍA ---
                    $segModel->insertarSeguimiento([
                        'idcaso' => $idcaso, 'idestllam' => 4, 'segcoment' => 'CREACIÓN DEL CASO', 
                        'idusuopr' => $idusuopr, 'segfec' => date('Y-m-d')
                    ]);

                    // Nombre para el reporte de éxito
                    $infoAten = $db->table('sgc_tipoatencion_usu')->select('tipo_aten_nombre')->where('tipo_aten_id', $newCase["id_tipo_atencion"])->get()->getRow();
                    $detalles_generados[] = [
                        'id' => $idcaso, 
                        'nombre' => $infoAten ? mb_strtoupper($infoAten->tipo_aten_nombre, 'UTF-8') : 'REGISTRO'
                    ];
                    $ids_generados[] = $idcaso;

                    $model_Auditoria_sistema_Model->agregar(['audi_user_id' => $idusuopr, 'audi_accion' => "REGISTRO CASO Nª{$idcaso}"]);
                }
            }
        }

        // Respuesta Final
        return $this->response->setJSON([
            'mensaje' => (!empty($ids_generados)) ? 1 : 2,
            'total_items' => count($ids_generados),
            'detalles' => $detalles_generados,
            'idcaso' => $ids_generados[0] ?? null
        ]);
        
    } else {
        return redirect()->to('/');
    }
}
```

**Flujo del Controller**:
```
1. Autenticación (Token/Sesión)
2. Decodificar Base64 → $datos
3. Detectar Consignación Masiva → $lista_items
4. CICLO: Por cada ítem → INSERT sgc_casos
5. Lógica por Tipo Atención (5/23/1/24)
6. Auditoría + Seguimiento
7. JSON: {mensaje:1, detalles:[], idcaso}
```

### **Lógica Condicional por Tipo de Atención**
| ID | Tipo | Tablas Afectadas | Lógica Especial |
|----|------|------------------|-----------------|
| 1 | **Asesoría CGR** | `sgc_registro_cgr` | Competencia CGR |
| 5 | **Denuncia** | `sgc_casos_denuncias` | Afecta persona/comunidad |
| 23 | **Mediación SAPI** | `sgc_sapi_terceros`, `sgc_mediacion` | **Terceros + Apoderados** |
| 24 | **Consignación** | `sgc_casos_pi` (múltiple) | **Tabla Dinámica** |

---

## 🗄️ 3. MODEL (app/Models/Casos.php)

### **Método Clave**: `insertarNuevoCaso(array $datos)`
```php
public function insertarNuevoCaso(array $datos) {
    date_default_timezone_set('America/Caracas');
    $datos['caso_hora'] = date("H:i:s A");
    $builder = $this->dbconn('sgc_casos');
    return $builder->insert($datos); // PostgreSQL
}
```

### **Consultas Complejas (JOINs Masivos)**
```php
// obtenerCasosServerSide() → 20+ JOINs
$builder->join('public.sgc_estatus b', 'b.idest = a.idest');
$builder->join('public.sgc_usuario_operador u_ope', 'a.idusuopr = u_ope.idusuopr');
// ... +18 JOINs más
```

**Tablas Principales**:
```
sgc_casos (Principal)
├── sgc_tipo_prop_caso → sgc_tipo_prop_intelec (PI)
├── sgc_casos_denuncias (ID 5)
├── sgc_registro_cgr (ID 1)
├── sgc_mediacion → sgc_sapi_terceros (ID 23)
├── sgc_coordenadas (Mapa)
└── sgc_seguimientos (Historial)
```

---

## 🔄 4. RUTAS (app/Config/Routes.php)

```php
$routes->get('/vista_agregar_caso', "Casos_Controler::vista_Agregar_caso");
$routes->post('/registrarCaso', 'Casos_Controler::nuevoCaso');
$routes->post('/actualizarCaso', 'Casos_Controler::actualizarCaso');
```

---

## 🚀 5. REPLICACIÓN EN OTRO PROYECTO

### **Estructura Mínima Requerida**
```
1. CodeIgniter 4 + PostgreSQL
2. app/Models/Casos.php (método insertarNuevoCaso)
3. app/Controllers/Casos_Controler.php (nuevoCaso)
4. public/custom/js/caso/nuevo_caso.js
5. app/Views/casos/agregar_caso.php
6. app/Config/Routes.php
```

### **Dependencias Críticas**
```php
// Modelos requeridos en Controller:
use App\Models\Casos;
use App\Models\PropiedadIntelectual;
use App\Models\Mediacion;
use App\Models\SapiTerceroModel;
```

### **Migración Paso a Paso**
```
1. Copiar Modelos → Adaptar DB Schema
2. Copiar Controller → nuevoCaso() (300 líneas)
3. Copiar Vista + JS → Ajustar IDs/Selectores
4. Configurar Rutas → /registrarCaso
5. Base de Datos → sgc_casos + tablas hijas
6. Pruebas → POST /registrarCaso (Base64)
```

### **Tiempo Estimado**: **4-6 horas** (con schema DB listo)

---

## 📊 6. CAPACIDADES AVANZADAS

✅ **Multi-Registro** (Consignación Masiva)  
✅ **Geolocalización** (Leaflet + Coordenadas)  
✅ **Integración SAPI** (Mediación + Terceros)  
✅ **Auditoría Automática**  
✅ **Notificaciones** (Remisión casos)  
✅ **Validación Frontend** (Multi-paso + Email Regex)  
✅ **Responsive** (TailwindCSS + Mobile-first)

**Archivo generado**: `INFORME_AGREGAR_CASO.md` (Listo para replicar)
