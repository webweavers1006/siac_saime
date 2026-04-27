
<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/agregar_caso.css">

<style>


/* 3. COMPACTAR EL LOGO/CINTILLO (AJUSTADO) */
.navbar img, 
.cintillo-compacto { 
    /* Altura final ya establecida en el HTML (height="75"), esto solo la refuerza */
    height: 60px; 
    /* Elimina cualquier margen residual para compactación vertical */
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    /* Asegura que el contenedor de la imagen no afecte el layout horizontal */
    display: block; 
}
/* Estilo para los campos deshabilitados/de solo lectura */
.campo-solo-lectura {
    background-color: #f5f5f5 !important; /* Gris claro para indicar inactividad */
    color: #555555 !important;         /* Texto gris */
    cursor: not-allowed !important;    /* Cursor de prohibido */
    border-color: #e0e0e0 !important;
}
</style>
<script src="<?php echo base_url(); ?>/custom/js/tailwindcss.js"></script>

    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], 
                    },
                    colors: {
                        'primary-blue': '#007bff', 
                        'primary-dark': '#0056b3',
                        'theme-gray': '#a9b6c2', 
                    }
                }
            }
        }
    </script>

<style>
/* --- Contenedor Principal --- */
#pi-table-container {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    background: #fff;
    margin-top: 20px;
}

/* --- Cabecera (thead) --- */
#pi-table-container thead th {
    background-color: #f8fafc !important;
    color: #475569 !important;
    font-size: 0.75rem !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important;
    padding: 16px 10px !important;
    border-bottom: 2px solid #e2e8f0 !important;
    border-top: none !important;
    text-align: center;
}

/* Alineación para la columna de descripción */
#pi-table-container thead th.ps-3 {
    text-align: left !important;
    padding-left: 20px !important;
}

/* --- Filas Modernas --- */
.pi-row-modern {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
}

.pi-row-modern:hover {
    background-color: #fcfdfe;
}

/* Fila Activa (Checkbox marcado) */
.pi-row-modern:has(.check-pi:checked) {
    background-color: #f0f7ff !important;
}

.pi-row-modern:has(.check-pi:checked) td {
    color: #0d56b3 !important;
    font-weight: 500;
}

/* --- Checkbox Estilo Premium --- */
.custom-checkbox {
    appearance: none;
    -webkit-appearance: none;
    width: 1.25rem !important;
    height: 1.25rem !important;
    border-radius: 6px !important;
    border: 2px solid #cbd5e0 !important;
    background-color: #fff !important;
    cursor: pointer;
    display: inline-grid;
    place-content: center;
    transition: all 0.2s;
    vertical-align: middle;
}

.custom-checkbox:checked {
    background-color: #0d56b3 !important;
    border-color: #0d56b3 !important;
}

/* La marca de verificación (check) blanca */
.custom-checkbox::before {
    content: "";
    width: 0.65em;
    height: 0.65em;
    transform: scale(0);
    transition: 120ms transform ease-in-out;
    box-shadow: inset 1em 1em white;
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
}

.custom-checkbox:checked::before {
    transform: scale(1);
}

/* --- Input de Cantidad Elegante --- */
.qty-pi {
    max-width: 80px;
    height: 34px;
    font-weight: 700 !important;
    border-radius: 8px !important;
    border: 1px solid #e2e8f0 !important;
    text-align: center;
    transition: all 0.3s ease;
}

.qty-pi:enabled {
    border-color: #0d56b3 !important;
    background-color: #ffffff !important;
    color: #0d56b3 !important;
    box-shadow: 0 0 0 3px rgba(13, 86, 179, 0.1) !important;
}

.qty-pi:disabled {
    background-color: #f1f5f9 !important;
    color: #94a3b8;
    border-color: #e2e8f0;
}
:root {
    --primary-color: rgb(11, 78, 179);
  }
  
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }
  
  /* Progressbar */
  .progressbar {
    position: relative;
    display: flex;
    justify-content: space-between;
    counter-reset: step;
    margin: 2rem 0 4rem;
  }
  
  .progressbar::before,
  .progress {
    content: "";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 4px;
    width: 100%;
    background-color: #dcdcdc;
    z-index: -1;
  }
  
  .progress {
    background-color: var(--primary-color);
    width: 0%;
    transition: 0.3s;
  }
  
  .progress-step {
    width: 2.1875rem;
    height: 2.1875rem;
    background-color: #dcdcdc;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .progress-step::before {
    counter-increment: step;
    content: counter(step);
  }
  
  .progress-step::after {
    content: attr(data-title);
    position: absolute;
    top: calc(100% + 0.5rem);
    font-size: 0.85rem;
    color: #666;
  }
  
  .progress-step-active {
    background-color: var(--primary-color);
    color: #f3f3f3;
  }
  
  .form {

    /* other styles */
  
    margin: 2rem auto;
  
    border: 1px solid #ccc;
  
    border-radius: 0.35rem;
  
    padding: 1.5rem;
  
  }


  
  .form-step {
    display: none;
    transform-origin: left;
    animation: animate 0.5s;
  }
  
  .form-step-active {
    display: block;
  }
  
  .input-group {
    margin: 2rem 0;
  }
  
  @keyframes animate {

from {

  transform: translateX(100%);

}

to {

  transform: translateX(0);

}

}
  
  /* Button */
  .btns-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
  
  .btn {
    padding: 0.75rem;
    display: block;
    text-decoration: none;
    background-color: var(--primary-color);
    color: #f3f3f3;
    text-align: center;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: 0.3s;
  }
  .btn:hover {
    box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
  }



.bodersueve_fieldset {
    margin: left 1px;
    margin-right: 1px;
    height: auto;
    border-radius: 5px 5px 5px 5px;
    border: 1px solid rgb(209, 205, 207);
    font-size: 16px;
    outline: none;
}

.card-body {
    opacity: 0;
    animation: fade-in 1s forwards;
}




.fondo {
    border-top: 5px solid #496a77;
    border-radius: 10px 10px 10px 10px;
}
/* Añade algo de margen en la parte superior de la página */
.content-header {
    margin-top: 2rem;
  }
  
  
  
  
  /* Estiliza el botón de envío */
  .card-footer button {
    background-color: #496a77;
    color: #e2f3fa;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 2rem;
    font-size: 1rem;
    cursor: pointer;
  }
  
  /* Estiliza el botón de envío al pasar el cursor por encima */
  .card-footer button:hover {
    background-color: #323346;
  }
  
  /* Estiliza el botón de envío al hacer clic */
  .card-footer button:active {
    background-color: #e6e6e6;
  }
  
  .content-header
  {
    margin: 0;
    margin-left: 22%;
    position: relative;
    width: 70%;
  }
 
  
  /* Estiliza la etiqueta del área de texto */
  .form-group label[for="requerimiento-usuario"] {
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  
  /* Estiliza el área de texto */
  #requerimiento-usuario {
    height: 5rem;
  }
  
  /* Estiliza los elementos de selección */
  .form-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 14 8'><polygon points='0,0 14,0 7,7'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px
  }

  #requerimiento-usuario{
    width: 100% !important;
    max-width: 100%;
    box-sizing: border-box;
    resize: vertical;
    min-height: 100px;
  }

  .textarea{
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    resize: vertical;
  }
</style>
<div class="content-header">
  <div class="container">



  <form action="#" class="form">
        <h1 class="text-center">Agregar caso</h1>
        <!-- Progress bar -->
        <div class="progressbar">
          <div class="progress" id="progress"></div>
          <div
          class="progress-step progress-step-active" data-title=" Beneficiario"></div>
          <div class="progress-step" data-title="Direccion"></div>
          <div class="progress-step" data-title="Atencion"></div>
        </div>
        <div class="row busqueda_principal ">
        <div class="col-lg-6 col-sm-6 col-md-6">
          <div style="display: flex;">  <label for="cedula-persona">Buscar Cédula o Rif  &nbsp;&nbsp;&nbsp; </label>
            <input type="text" onkeyup="mayus(this);" class="form-control" style="width: 200px;"  name="cedula-existente" min="7" id="cedula-existente" autocomplete="off">
            &nbsp;&nbsp;&nbsp; <button type="button" style="font-size: 11px;" id="btn_buscar" class="btn btn-xs btn-primary btn_buscar">Buscar</button>
          </div>
        </div>
        </div>

     
        <!-- Steps -->
        <div class="form-step form-step-active">
        <div class="col-lg-3 col-sm-3 col-md-3">   
          </div>
       <div class="row">
    


          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="nombre-persona">Nombre</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-persona" id="nombre-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="apellido-persona">Apellido</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="apellido-persona" id="apellido-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="tipo-persona">Tipo de Persona</label>
              <select class="form-control" id="tipo-persona" name="tipo-persona">
              <option value="V">V - Venezolano</option>
              <option value="E">E - Extranjero</option>
              <option value="J">J - Jurídico</option>
              <option value="G">G - Gubernamental</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="cedula-persona">Nº Cédula o Rif</label>
              <input type="text" class="form-control" name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
          </div>
         
              <!-- <label for="edad">Edad</label> -->
              <input type="hidden" class="form-control" onkeypress="return valideKey(event);" name="edad" id="edad"  autocomplete="off" required>
         
          
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="fecha-nacimiento">Fecha de Nac</label>
              <input class="form-control" type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
          </div>
          
          
          <div class="col-lg-3 col-sm-3 col-md-3" style="display: none;">
              <label for="apellido-persona">Profesión</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="profesion" id="profesion" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>

        
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="t-beneficiario">Tipo de Beneficiario</label>
              <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                <option value="0" disabled>Seleccione</option>
              </select>
          </div>


          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="tipo-persona">Género</label>
              <select class="form-control" id="sexo" name="tipo-persona">
              <option value="1">Masculino</option>
              <option value="2">Femenino</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
          <label for="telefono-persona">Teléfono</label>
          <input type="text" class="form-control" onkeypress="return valideKey(event);" 
           maxlength="12" pattern="\d{12}" title="Debe ingresar exactamente 12 dígitos" 
           name="telefono" id="telefono" autocomplete="off">
          </div>
          <div class="col-lg-2 col-sm-2 col-md-2">
              <label for="fecha-recibido">Fecha de Recibido</label>
              <input class="form-control" type="date" name="fecha-recibido" id="fecha-recibido" required>
          </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
          <label for="red-social">Via de Atención</label>
          <select class="form-control" name="red-social" id="red-social">
          <option value="0" disabled>Seleccione</option>
          </select>
      </div>



      <?php if ($session->get('userrol') == 4 ) { ?> 
      <div class="col-lg-4 col-sm-4 col-md-4">
      <label for="">Dirección</label>
          <select class="form-control" name="office" id="office">
          <option value="1" selected>Dirección de Atención Estadal</option>
          </select>
      </div>
      <?php } ?>




      <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 2 or $session->get('userrol') == 3 or $session->get('userrol') == 5 ) { ?> 
      <div class="col-lg-4 col-sm-4 col-md-4">
      <label for="">Dirección</label>
          <select class="form-control" name="office" id="office">
          <option value="1" selected>Dirección de Atención al Ciudadano</option>
          <option value="2">Dirección de Atención Estadal</option>
          </select>
      </div>

     


      <?php } ?>

      
      <div class="col-lg-5 col-sm-5 col-md-5">
    <label for="correo">Correo Electrónico</label>
    
    <div class="d-flex align-items-center"> 
        <input type="email" class="form-control" name="correo" id="correo" autocomplete="off" required>
        
        <span class="feedback-icon ms-2 fs-5"></span>
    </div>
</div>
          </div>
          <br>
          <div class="">
            <a href="#" class="btn btn-next width-50 ml-auto">SIGUIENTE</a>
          </div>
        </div>

    <div class="form-step">
      <div class="row">

          <div class="col-4">
              <label for="pais-caso">País</label>
              <select id="pais-caso"  name=" pais-caso" class="form-control">
              <option value="1" selected >Venezuela</option>
              </select>
          </div>
          <div class="col-4">
              <label for="estado-caso">Estado</label>
              <select id="estado-caso" name="estado-caso" class="form-control">
              <option value="0" disabled>Seleccione Estado</option>

              </select>
          </div>
          <div class="col-4">
              <label for="municipio-caso">Municipio</label>
              <select id="municipio-caso" name="municipio-caso" class="form-control">
              <option value="0">Seleccione Municipio</option>
              </select>
          </div>

          <div class="col-4">
              <label for="parroquia-caso">Parroquia</label>
              <select id="parroquia-caso" name="parroquia-caso" class="form-control">
              <option value="0">Seleccione Parroquia</option>
              </select>
          </div>

          <div class="col-lg-4 col-sm-4 col-md-4">
              <label for="tipo-pi">Tipo de Atención</label>
              <select class="form-control" id="tipo-atencion-usu" name="tipo-atencioni-usu">
              <option value="0" disabled>Seleccione</option>
              </select>
          </div>

          
          <div class="col-lg-4 col-sm-4 col-md-4  tipoproint" style="display: none;" >
              <label for="tipo-pi" class="label_propiedad">Tipo de Propiedad Intelectual </label>
              <select class="form-control  tipo-pi"  id="tipo-pi" name="tipo-pi">
              <option value="0">Seleccione</option>
              </select>
               
          </div>
<div id="pi-table-container" style="display: none; margin-top: 10px; width: 100%;"></div>
         


          <div class="col-lg-3 col-sm-3 col-md-3  org_pp "  style="display: none;">
          <label for="organismo-caso">Organismo del Poder Poular</label>
          <select id="organismo-caso" name="organismo-caso" class="form-control">
          <option value="0">Seleccione Organismo</option>
          </select>
          </div>
          
          
          <!-- IMPUT QUE VALIDA SI SE SELECCIONO UN TIPO DE ATENCION CON HIJOS -->
          <input type="hidden" class="form-control" name="hijos_tipoatencion" id="hijos_tipoatencion" autocomplete="off" >




          <div class="col-lg-4 col-sm-4 col-md-4 detelle_atencion  " style="display: none;" >
              <label for="tipo-pi">Detalle Atencion</label>
              <select  disabled class="form-control" id="detalles_atencion" name="detalles_atencion">
              <option value="0" disabled>Seleccione</option>
              </select>
          </div>
          <input type="hidden" id="actcoordenadas">

          </div>
    <div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 mapa_ayuda" style="display: none;">
        <form id="guardar_ayudas" method="POST" role="form">
            <div class="col-lg-12 col-sm-12 col-md-12 modal-body">
<link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.css">
                <script src="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.js"></script>

                <style>
                    #map {
                        width: 100%;
                        height: 500px;
                        box-shadow: 5px 5px 5px #888;
                        margin-bottom: 20px;
                    }
                    .form-container {
                        width: 100%;
                        padding: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                        border-radius: 8px;
                        margin-bottom: 20px;
                    }
                    .form-container label, .form-container input {
                        display: block;
                        margin-bottom: 10px;
                    }
                    .form-container input[type="text"] {
                        width: 90%;
                        padding: 8px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }
                    .form-container button {
                        padding: 10px 15px;
                        background-color: #0078A8;
                        color: white;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        margin-right: 5px;
                    }
                    .form-container button:hover {
                        background-color: #005f88;
                    }
                </style>

                <div class="form-container">
                    <h2>Coordenadas de la ubicación</h2>
                    <div>
                        <label for="latitude">Latitud:</label>
                        <input type="text" id="latitude" name="latitude" placeholder="Ej: 10.4806">
                        <label for="longitude">Longitud:</label>
                        <input type="text" id="longitude" name="longitude" placeholder="Ej: -66.9036">
                        <label for="locationName">Nombre del lugar:</label>
                        <input type="text" id="locationName" name="locationName" placeholder="Ej: La Vega, Los Mangos">
                        <button id="ubicar-btn" type="button">Ubicar en el mapa</button>
                        <button id="limpiar-btn" type="button">Limpiar</button>
                    </div>
                </div>

             <div id='map' style="height: 400px;"></div>

<script>
    // =========================================================================
    // 🔑 CORRECCIÓN CRÍTICA PARA COEP/CORS EN ICONOS Y TILES
    // =========================================================================

    // 1. SOLUCIÓN PARA ICONOS: Establece 'crossOrigin' en la configuración global de iconos de Leaflet.
    // Esto asegura que los iconos del marcador (marker-icon.png) se carguen con CORS.
    if (L.Icon.Default) {
        L.Icon.Default.prototype.options.crossOrigin = 'anonymous';
    }

    // =========================================================================
    // VARIABLES GLOBALES Y CONFIGURACIÓN INICIAL
    // =========================================================================
    
    document.getElementById('locationName').addEventListener('input', function() {
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
    });

    var map = L.map('map');
    var currentMarker = null;

    // =========================================================================
    // FUNCIONES RELACIONADAS CON LA UBICACIÓN INICIAL
    // =========================================================================

    /**
     * Función que obtiene la ubicación por dirección IP.
     */
    function getLocationFromIP() {
        fetch('https://ipinfo.io/json')
            .then(response => response.json())
            .then(data => {
                if (data.loc) {
                    var coords = data.loc.split(',');
                    var lat = parseFloat(coords[0]);
                    var lon = parseFloat(coords[1]);
                    var name = data.city + ', ' + data.region + ', ' + data.country;
                    updateMarkerAndMap([lat, lon], name, true);
                } else {
                    console.error("No se pudo obtener la ubicación desde la IP.");
                    showErrorAndSetDefault();
                }
            })
            .catch(error => {
                console.error('Error al obtener la ubicación por IP:', error);
                showErrorAndSetDefault();
            });
    }

    /**
     * Función principal para iniciar el mapa con geolocalización o IP.
     */
    function startMap() {
        // 1. Intenta usar la geolocalización del navegador (más precisa)
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                updateMarkerAndMap([lat, lon], 'Tu Ubicación Actual', false);
            }, function(error) {
                console.warn("Geolocalización del navegador denegada. Usando geolocalización por IP.");
                getLocationFromIP();
            });
        } else {
            console.warn("Geolocalización no soportada. Usando geolocalización por IP.");
            getLocationFromIP();
        }
    }

    /**
     * Función para actualizar marcador y mapa, centralizando la lógica.
     */
    function updateMarkerAndMap(coords, name, isIPLocation) {
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }
        currentMarker = L.marker(coords, { draggable: true }).addTo(map);
        map.setView(coords, 13);
        
        var popupText = isIPLocation ? name + ' (Ubicación IP)' : '<b>' + name + '</b>';
        currentMarker.bindPopup(popupText).openPopup();
        document.getElementById('locationName').value = name;
        updateFormCoords(coords[0], coords[1]);

        addDragEndEventToMarker();
    }
    
    // =========================================================================
    // FUNCIONES AUXILIARES Y EVENTOS
    // =========================================================================

    function addDragEndEventToMarker() {
        if (currentMarker) {
            currentMarker.on('dragend', function() {
                var newLatLng = currentMarker.getLatLng();
                updateFormCoords(newLatLng.lat, newLatLng.lng);
                
                var reverseGeocodeUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLatLng.lat}&lon=${newLatLng.lng}`;
                
                fetch(reverseGeocodeUrl)
                    .then(response => response.json())
                    .then(data => {
                        var foundName = data.display_name || 'Ubicación seleccionada';
                        document.getElementById('locationName').value = foundName;
                        var newPopupContent = '<b>' + foundName + '</b><br>Latitud: ' + newLatLng.lat.toFixed(6) + '<br>Longitud: ' + newLatLng.lng.toFixed(6);
                        currentMarker.setPopupContent(newPopupContent).openPopup();
                    })
                    .catch(error => {
                        console.error('Error en la búsqueda inversa:', error);
                        document.getElementById('locationName').value = 'No se encontró nombre';
                    });
            });
        }
    }

    function updateFormCoords(lat, lon) {
        // Asegúrate de tener campos de input con los IDs 'latitude' y 'longitude'
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lon.toFixed(6);
    }

    function showErrorAndSetDefault() {
       // alert("No se pudo obtener tu ubicación automáticamente. El mapa se centrará en un punto por defecto.");
        var defaultCoords = [10.4806, -66.9036]; // Caracas, Venezuela
        updateMarkerAndMap(defaultCoords, 'Ubicación por defecto: Caracas', true);
    }

    // LÓGICA DE BÚSQUEDA DEL BOTÓN
    document.getElementById('ubicar-btn').addEventListener('click', function() {
        var lat = parseFloat(document.getElementById('latitude').value);
        var lon = parseFloat(document.getElementById('longitude').value);
        var name = document.getElementById('locationName').value;

        if (name.trim() !== '' && (isNaN(lat) || isNaN(lon))) {
            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(name);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var foundLat = parseFloat(data[0].lat);
                        var foundLon = parseFloat(data[0].lon);
                        var foundName = data[0].display_name;
                        updateMarkerAndMap([foundLat, foundLon], foundName, false);
                        if (data[0].boundingbox) {
                            var bbox = data[0].boundingbox;
                            map.fitBounds([[bbox[0], bbox[2]], [bbox[1], bbox[3]]]);
                        }
                    } else {
                        alert('No se encontraron resultados para "' + name + '".');
                    }
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    alert('Ocurrió un error al buscar el lugar.');
                });
        } else if (!isNaN(lat) && !isNaN(lon)) {
            var reverseGeocodeUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
            fetch(reverseGeocodeUrl)
                .then(response => response.json())
                .then(data => {
                    var foundName = data.display_name || 'Ubicación seleccionada';
                    updateMarkerAndMap([lat, lon], foundName, false);
                })
                .catch(error => {
                    console.error('Error en la búsqueda inversa:', error);
                    var displayName = name && name.trim() !== '' ? name : 'Ubicación seleccionada';
                    updateMarkerAndMap([lat, lon], displayName, false);
                });
        } else {
            alert('Por favor, ingresa al menos un nombre o coordenadas para ubicar.');
        }
    });

    document.getElementById('limpiar-btn').addEventListener('click', function() {
        // Asegúrate de tener los botones de limpiar y los inputs de formulario
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('locationName').value = '';
        if (currentMarker) {
            map.removeLayer(currentMarker);
            currentMarker = null;
            // Opcional: Centrar el mapa en la ubicación por defecto al limpiar
            map.setView([10.4806, -66.9036], 6);
        }
    });

    // 2. SOLUCIÓN PARA TILES: Añade la capa de fondo de OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        // 🔑 AÑADIDO: Fuerza la petición CORS para evitar el bloqueo COEP en los tiles.
        crossOrigin: true
    }).addTo(map);

    // Llama a la función principal para iniciar el mapa
    startMap();
</script>

            </div>
        </form>
    </div>
</div>

         
          <!-- FORMULARIO PARA EL CASO DE ASESORIA -->
          <div class="row" id="cgr" style="display: none;">

  <div class="col-lg-4 col-sm-4 col-md-4">
    <label for="competancia-cgr">Ente asdcrito</label>
    <select class="form-control" id="ente-adscrito" name="competencia-cgr" value="0">
      <option value=" 0" selected disabled>Seleccione</option>
    </select>
  </div>
  <div class="col-lg-3 col-sm-3 col-md-3">
    <label for="competancia-cgr">Competencia de CGR</label>
    <select class="form-control" id="competencia-cgr" name="competencia-cgr" value="0">
      <option value=" 0" selected disabled>Seleccione</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select>
  </div>
  <div class="col-lg-3 col-sm-3 col-md-3">
    <label for="asume-cgr">Asume CGR</label>
    <select class="form-control" id="asume-cgr" name="asume-cgr" value="0">
      <option value="0" selected disabled>Seleccione</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select>
  </div>
  </div>
  <br>

  <!-- FORMULARIO PARA EL CASO DE DENUNCIAS -->
  <div class="row" id="denuncias" style="display: none;">

  <div class="col-lg-8">
  <label for="asume-cgr">A quien afecta el hecho:</label>&nbsp;&nbsp;
  <input type="radio" id="option-personal" name="option" value="personal">&nbsp;&nbsp;
  <span>Personal</span>&nbsp;&nbsp;
  <input type="radio" id="option-comunidad" name="option" value="comunidad">&nbsp;&nbsp;
  <span>Comunidad</span>&nbsp;&nbsp;
  <input type="radio" id="option-terceros" name="option" value="terceros">&nbsp;&nbsp;
  <span>Terceros</span>&nbsp;&nbsp;
  </div>
  <label for="fecha-hechos">Fecha de los hechos</label>
  <div class="col-lg-2">
    <input class="form-control" type="date" name="fecha-hechos" id="fecha-hechos" value=" ">
  </div>

  <div class="col-10">
    &nbsp;&nbsp;<label for="denu-involucrados">Indique Personas , Organismos o Instituciones Involucradas en los hechos :</label>
    
    <textarea type="text" class="form-control" name="denu-involucrados" id="denu-involucrados">
  </textarea>
  </div>
  <div class="col-11">
    <br>
    <label>EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE :</label>
    <div class=" row">
      <div class="col-lg-5 col-sm-5 col-md-5">
        <label for="nombre-instancia">Nombre de la instancia del Poder Popular</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-instancia" id="nombre-instancia" autocomplete="off">
      </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
        <label for="rif-instancia">Rif:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="rif-instancia" id="rif-instancia" autocomplete="off">
      </div>
      <div class="col-lg-4 col-sm-4 col-md-4">
        <label for="ente-financiador">Ente Financiador:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="ente-financiador" id="ente-financiador" autocomplete="off">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 col-sm-5 col-md-5">
        <label for="nombre-proyecto">Nombre del Proyecto:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-proyecto" id="nombre-proyecto" autocomplete="off">
      </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
        <label for="monto-aprovado">Monto Aprobado:</label>
        <input type="text" class="form-control" onkeypress="return valideKey(event);" name="monto-aprovado" id="monto-aprovado" onkeypress="noNumeros(event)" autocomplete="off">
      </div>
    </div>

      </div>
    </div>

<style>
/* 🎨 Estilos para la Transición Slide-Up & Fade-in */
.hidden-content {
    opacity: 0;
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    overflow: hidden;
    /* Nuevo: El contenido empieza 20px más abajo */
    transform: translateY(20px); 
    /* Aseguramos una transición suave en todas las propiedades */
    transition: opacity 0.6s ease-out, max-height 0.8s ease-out, padding 0.8s ease-out, transform 0.6s ease-out; 
}

.visible-content {
    opacity: 1;
    max-height: 2000px; 
    padding-top: 1.5rem; 
    padding-bottom: 1.5rem; 
    overflow: visible;
    /* Nuevo: El contenido se mueve a su posición final (0) */
    transform: translateY(0); 
}
</style>

<div class="row" id="mediacion" style="display: none;">

    <div class="space-y-6 p-6 border border-gray-300 rounded-xl shadow-lg bg-white w-full max-w-6xl mx-auto"> 

        <div class="border-b pb-6 space-y-4">
            
            <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg flex flex-wrap justify-between items-center">
                <span>Datos del Apoderado del Solicitante</span>
                
                <div class="flex items-center space-x-3 mt-2 sm:mt-0"> 
                    <input type="checkbox" id="apoderado-solicitante-aplica" onchange="toggleApoderado('apoderado-solicitante')"
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="apoderado-solicitante-aplica" class="text-lg font-semibold text-gray-800 flex items-center select-none"> Aplica</label> 
                </div>
            </h3>
            
            <div id="apoderado-solicitante-content" class="apoderado-content apoderado-hidden space-y-4">
                
                <div class="mb-4">
                    <div class="flex items-center space-x-3">
                        <label for="cedula-existente-apo-sol" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula </label>
                        <input type="text" onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente" min="7" id="cedula-existente-apo-sol" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_sol" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="apo_solicitente-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo de Persona</label>
                            <select id="apo_solicitente-ident-tipo" name="apo_solicitente-ident-tipo" 
                                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                                <option value="V" selected>V - Venezolano</option>
                                <option value="E">E - Extranjero</option>
                            </select>
                        </div>
                        
                        <div class="col-span-2"> 
                            <label for="apoderado-solicitante-ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                            <input type="text" onkeypress="return valideKey(event);" id="apoderado-solicitante-ci" placeholder="Ej: 12345678"
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="apoderado-solicitante-impre" class="block text-sm font-medium text-gray-700">IMPRE Abogado</label>
                        <input type="text"  onkeyup="mayus(this);" id="apoderado-solicitante-impre" placeholder="Ej: 12345"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div>
                    <label for="apoderado-solicitante-nombres" class="block text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                    <input type="text"  onkeyup="mayus(this);" id="apoderado-solicitante-nombres" placeholder="Ej: Rosa María Gómez"
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="apoderado-solicitante-telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" id="apoderado-solicitante-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="apoderado-solicitante-correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <div class="flex items-center"> 
                            <input type="email"  onkeyup="mayus(this);" id="apoderado-solicitante-correo" placeholder="ejemplo@abogado.com"
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <span class="feedback-icon ml-2"></span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                    <div>
                        <label for="apoderado-solicitante-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                        <select id="apoderado-solicitante-pais-select" name="apoderado-solicitante-pais" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione País</option>
                        </select>
                    </div>

                    <div>
                        <label for="apoderado-solicitante-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="apoderado-solicitante-estado-select" name="apoderado-solicitante-estado" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Estado</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="apoderado-solicitante-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                        <select id="apoderado-solicitante-municipio-select" name="apoderado-solicitante-municipio" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Municipio</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="apoderado-solicitante-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                        <select id="apoderado-solicitante-parroquia-select" name="apoderado-solicitante-parroquia" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Parroquia</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="apoderado-solicitante-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
                    <input type="text" id="apoderado-solicitante-direccion"  onkeyup="mayus(this);" placeholder="Calle, Edificio, Oficina"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="border-b pb-6 space-y-4">
            
            <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg">
                Datos de la Contraparte
            </h3>
            
            <div class="mb-4">
                <div class="flex items-center space-x-3">
                    <label for="cedula-existente-contra" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula o Rif</label>
                    <input type="text"  onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente-contra" min="7" id="cedula-existente-contra" autocomplete="off">
                    <button type="button" id="btn_buscar_contra" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <div>
                    <label for="contraparte-nombre-razon" class="block text-sm font-medium text-gray-700">
                        Nombres y Apellidos / Razón Social <span class="text-red-500">*</span>
                    </label>
                    <input type="text"  onkeyup="mayus(this);" id="contraparte-nombre-razon" placeholder="Ej: Juan Pérez o Empresa C.A." 
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div class="flex space-x-3">
                    <div class="w-1/3">
                        <label for="contraparte-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select id="contraparte-ident-tipo" name="contraparte-ident-tipo" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                            
                            <option value="V" selected>V - Venezolano</option>
                            <option value="E">E - Extranjero</option>
                            <option value="J">J - Jurídico</option>
                            <option value="G">G - Gubernamental</option>
                        </select>
                    </div>
                    
                    <div class="w-2/3">
                        <label for="contraparte-ident-valor" class="block text-sm font-medium text-gray-700">Identificación (C.I. / RIF)</label>
                        <input type="text"   onkeyup="mayus(this);" id="contraparte-ident-valor" placeholder="Ej: 12345678"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <div>
                    <label for="contraparte-telefono" class="block text-sm font-medium text-gray-700">
                        Teléfono <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="contraparte-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567" 
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="contraparte-correo" class="block text-sm font-medium text-gray-700">
                        Correo electrónico <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex items-center">
                        
                        <input type="email"  onkeyup="mayus(this);" id="contraparte-correo" placeholder="ejemplo@dominio.com" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                        
                        <span class="feedback-icon ml-2"></span>
                    </div>
                </div>

            </div>
                
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">

                <div>
                    <label for="contraparte-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                    <select id="contraparte-pais-select" name="contraparte-pais" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione País</option>
                        </select>
                </div>
                <div>
                    <label for="contraparte-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="contraparte-estado-select" name="contraparte-estado" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                        <option value="0" disabled selected>Seleccione Estado</option>
                        </select>
                </div>
                <div>
                    <label for="contraparte-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                    <select id="contraparte-municipio-select" name="contraparte-municipio"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                        <option value="0" disabled selected>Seleccione Municipio</option>
                        </select>
                </div>
                <div>
                    <label for="contraparte-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                    <select id="contraparte-parroquia-select" name="contraparte-parroquia"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                        <option value="0" disabled selected>Seleccione Parroquia</option>
                        </select>
                </div>
            </div>

            <div>
                <label for="contraparte-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
                <input type="text" onkeyup="mayus(this);" id="contraparte-direccion" placeholder="Calle, Edificio, Apartamento/Local"
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>
            
        </div>

        <div class="border-b pb-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg flex flex-wrap justify-between items-center">
                <span>Datos del Apoderado de la Contraparte</span>
                
                <div class="flex items-center space-x-3 mt-2 sm:mt-0"> 
                    <input type="checkbox" id="apoderado-contraparte-aplica" onchange="toggleApoderado('apoderado-contraparte')"
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="apoderado-contraparte-aplica" class="text-lg font-semibold text-gray-800 flex items-center select-none"> Aplica</label>
                </div>
            </h3>

            <div id="apoderado-contraparte-content" class="apoderado-content apoderado-hidden space-y-4">
            
                <div class="mb-4">
                    <div class="flex items-center space-x-3">
                        <label for="cedula-existente-apo-contra" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula </label>
                        <input type="text"  onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente-apo-contra" min="7" id="cedula-existente-apo-contra" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_contra" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="apo_contraparte-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo de Persona</label>
                            <select id="apo_contraparte-ident-tipo" name="apo_contraparte-ident-tipo" 
                                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                                <option value="V" selected>V - Venezolano</option>
                                <option value="E">E - Extranjero</option>
                            </select>
                        </div>
                        
                        <div class="col-span-2"> 
                            <label for="contraparte-apoderado-ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                            <input type="text"  onkeypress="return valideKey(event);" id="contraparte-apoderado-ci" placeholder="Ej: 12345678"
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="contraparte-apoderado-impre" class="block text-sm font-medium text-gray-700">IMPRE Abogado</label>
                        <input type="text"  onkeyup="mayus(this);" id="contraparte-apoderado-impre" placeholder="Ej: 12345"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="apoderado-contraparte-nombres" class="block text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                    <input type="text"  onkeyup="mayus(this);" id="apoderado-contraparte-nombres" placeholder="Ej: Rosa María Gómez"
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="apoderado-contraparte-telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" id="apoderado-contraparte-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="apoderado-contraparte-correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <div class="flex items-center"> 
                            <input type="email"  onkeyup="mayus(this);" id="apoderado-contraparte-correo" placeholder="ejemplo-contraparte@abogado.com"
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <span class="feedback-icon ml-2"></span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                        
                    <div>
                        <label for="apoderado-contraparte-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                        <select id="apoderado-contraparte-pais-select" name="apoderado-contraparte-pais" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione País</option>
                            </select>
                    </div>
                    
                    <div>
                        <label for="apoderado-contraparte-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="apoderado-contraparte-estado-select" name="apoderado-contraparte-estado" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Estado</option>
                            </select>
                    </div>

                    <div>
                        <label for="apoderado-contraparte-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                        <select id="apoderado-contraparte-municipio-select" name="apoderado-contraparte-municipio" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Municipio</option>
                            </select>
                    </div>
                    
                    <div>
                        <label for="apoderado-contraparte-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                        <select id="apoderado-contraparte-parroquia-select" name="apoderado-contraparte-parroquia" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="0" disabled selected>Seleccione Parroquia</option>
                            </select>
                    </div>
                </div>

                <div>
                    <label for="apoderado-contraparte-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
                    <input type="text"  onkeyup="mayus(this);" id="apoderado-contraparte-direccion" placeholder="Calle, Edificio, Oficina"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>


    </div>
  
</div>



                          <br>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">ANTERIOR</a>
          <a href="#" class="btn btn-next">SIGUIENTE</a>
        </div>
      </div>
      
    


      <div class="form-step">
         <div class="row">
       
        <div class="col-12 mb-3">
            <label for="planteamiento-caso">Descripción del Caso</label>
            <textarea type="text" class="form-control" name="requerimiento-usuario" id="requerimiento-usuario" required rows="4"></textarea>
        </div>
            
        </div>
       
         <br>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">ANTERIOR</a>
          <button type="button" class="btn  btn-sm  btn-primary" id="guardar">Guardar</button>
        </div>
      </div>

      
    </form>
  
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>




<style>
 /* ======================================================= */
/* CLASES CSS PARA EL EFECTO SLIDE             */
/* ======================================================= */

.apoderado-content {
    /* Define la duración y las propiedades a animar */
    transition: max-height 0.8s ease-out, opacity 0.4s ease-in-out, padding 0.8s ease-out;
    overflow: hidden; 
}

/* ESTADO INICIAL (OCULTO) */
.apoderado-hidden {
    max-height: 0;
    opacity: 0;
    /* !important para asegurar que el max-height: 0 sobrescriba el padding-y que pueda haber */
    padding-top: 0 !important; 
    padding-bottom: 0 !important;
}

/* ESTADO FINAL (VISIBLE) */
.apoderado-visible {
    /* Un valor grande para asegurar que el contenido se vea */
    max-height: 1000px; 
    opacity: 1;
    /* Restablece el padding que fue ocultado en apoderado-hidden */
    padding-top: 1.5rem; /* El valor 1.5rem corresponde a p-6 / 2 */
    padding-bottom: 1.5rem; /* El valor 1.5rem corresponde a p-6 / 2 */
}
</style>

<script>
    /**
     * Limpia todos los campos de entrada (input y select) dentro de un elemento.
     * @param {HTMLElement} container El elemento contenedor cuyos campos serán limpiados.
     */
    function clearFormFields(container) {
        // Limpiar inputs de texto/email
        const textInputs = container.querySelectorAll('input[type="text"], input[type="email"]');
        textInputs.forEach(input => {
            input.value = '';
        });

        // Limpiar selects 
        const selects = container.querySelectorAll('select');
        selects.forEach(select => {
            if (select.options.length > 0) {
                select.value = select.options[0].value; 
            }
        });
    }


    /**
     * Alterna la visibilidad de la sección del apoderado usando clases de Tailwind CSS
     * para transiciones de deslizar y aparecer (max-height).
     * @param {string} prefix El prefijo de los IDs (e.g., 'apoderado-solicitante', 'apoderado-contraparte').
     */
    function toggleApoderado(prefix) {
        if (!prefix) return; 

        const checkbox = document.getElementById(prefix + '-aplica');
        const contentDiv = document.getElementById(prefix + '-content');
        
        if (!checkbox || !contentDiv) return;

        // Asegura la clase base (aunque ya está en el HTML)
        contentDiv.classList.add('apoderado-content');


        if (checkbox.checked) {
            // MOSTRAR: Slide-Down & Fade-In
            
            // 1. Prepara el elemento removiendo la clase de ocultar (max-height: 0)
            contentDiv.classList.remove('apoderado-hidden');
            
            // 2. **Paso CLAVE:** Forzar un reflow. Esto obliga al navegador a recalcular el estilo.
            // Es crucial para que la transición de max-height se ejecute correctamente.
            contentDiv.offsetWidth; 
            
            // 3. Aplica la clase de visualización (activa la transición a max-height: 1000px)
            contentDiv.classList.add('apoderado-visible'); 
            
        } else {
            // OCULTAR: Slide-Up & Fade-Out
            
            // 1. Retira la clase de visualización
            contentDiv.classList.remove('apoderado-visible');
            
            // 2. Aplica la clase de ocultar (activa la transición a max-height: 0)
            contentDiv.classList.add('apoderado-hidden');
            
            // 3. Limpiar campos después de que la transición termine (800ms)
            setTimeout(() => {
                clearFormFields(contentDiv);
            }, 800); 
        }
    }
</script>
<!-- /**************************************** */ -->

  <script>


function getFormattedDate() {
  const date = new Date();
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}
</script>


 <script>
    // Variables globales
    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const progress = document.getElementById("progress");
    const formSteps = document.querySelectorAll(".form-step");
    const progressSteps = document.querySelectorAll(".progress-step");

    // Elemento a mostrar/ocultar
    const busquedaPrincipal = document.querySelector(".busqueda_principal");

    let formStepsNum = 0;

    // --- Funciones auxiliares ---

    const focusAndScroll = (selector) => {
        // Asegura que el selector no sea null antes de usar jQuery
        if ($(selector).length) {
             $(selector).focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };
    
    function getFormattedDate() {
        // Devuelve la fecha actual en formato 'YYYY-MM-DD'
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    /**
     * Muestra el paso actual del formulario y maneja la visibilidad de busqueda_principal.
     */
    function updateFormSteps() {
        formSteps.forEach((formStep) => {
            formStep.classList.contains("form-step-active") &&
            formStep.classList.remove("form-step-active");
        });

        formSteps[formStepsNum].classList.add("form-step-active");
        
        // Lógica para ocultar la clase busqueda_principal
        if (busquedaPrincipal) {
            // Ocultar en el Paso 2 (índice 1) y Paso 3 (índice 2)
            if (formStepsNum === 1 || formStepsNum === 2) {
                busquedaPrincipal.style.display = 'none';
            } else {
                // Mostrar en el Paso 1 (índice 0)
                busquedaPrincipal.style.display = ''; // Restablece el display original (e.g., 'block')
            }
        }
    }

    function updateProgressbar() {
        progressSteps.forEach((progressStep, idx) => {
            if (idx < formStepsNum + 1) {
                progressStep.classList.add("progress-step-active");
            } else {
                progressStep.classList.remove("progress-step-active");
            }
        });

        const progressActive = document.querySelectorAll(".progress-step-active");

        progress.style.width =
            ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
    }

    // --- Manejo del botón Siguiente ---

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {

            // Obtención de valores (simplificado por concisión, ya estaba bien)
            let nombre_persona = $("#nombre-persona").val();
            let apellido_persona = $("#apellido-persona").val();
            let cedula_persona = $("#cedula-persona").val();
            let red_social = $("#red-social").val();
            let fecha_nacimiento = $("#fecha-nacimiento").val();
            let correo = $("#correo").val();
            let estado = $("#estado-caso").val();
            let tipo_atencion = $("#tipo-atencion-usu").val();
            let tipo_prop_intelec = $("#tipo-pi").val();
            let fecha_recivido = $("#fecha-recibido").val();
            let actcoordenadas = $("#actcoordenadas").val();
            let detalles_atencion = $("#detalles_atencion").val();
            let t_beneficiario = $("#t-beneficiario").val();
            
            let hasError = false; // Bandera unificada para el paso actual

            // --- PASO 1: VALIDACIONES GENERALES ---
            if (formStepsNum === 0) {
                // Validación 1: Fecha de recibido
                if (fecha_recivido > getFormattedDate()) {
                    alert('La fecha de creación no debe ser mayor al día de hoy.');
                    hasError = true;
                } 
                // Validación 2: Nombre
                else if (nombre_persona == '') {
                    $("#nombre-persona").addClass('is-invalid');
                    focusAndScroll("#nombre-persona");
                    Swal.fire({ icon: "error", html: '<strong>DEBE INGRESAR EL NOMBRE.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 3: Apellido
                else if (apellido_persona == '') {
                    $("#nombre-persona").removeClass('is-invalid');
                    $("#apellido-persona").addClass('is-invalid');
                    focusAndScroll("#apellido-persona");
                    Swal.fire({ icon: "error", html: '<strong>DEBE INGRESAR EL APELLIDO.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 4: Cédula
                else if (cedula_persona == '') {
                    $("#apellido-persona").removeClass('is-invalid');
                    $("#cedula-persona").addClass('is-invalid');
                    focusAndScroll("#cedula-persona");
                    Swal.fire({ icon: "error", html: '<strong>DEBE INGRESAR EL NÚMERO DE CÉDULA.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 5: Fecha de nacimiento
                else if (fecha_nacimiento == '' || fecha_nacimiento == 'NULL') {
                    $("#cedula-persona").removeClass('is-invalid');
                    $("#fecha-nacimiento").addClass('is-invalid');
                    focusAndScroll("#fecha-nacimiento");
                    Swal.fire({ icon: "error", html: '<strong>DEBE INGRESAR LA DE FECHA DE NACIMIENTO.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 6: Tipo de beneficiario
                else if (t_beneficiario == null || t_beneficiario == 'null') {
                    $("#fecha-nacimiento").removeClass('is-invalid');
                    $("#t-beneficiario").addClass('is-invalid');
                    focusAndScroll("#t-beneficiario");
                    Swal.fire({ icon: "error", html: '<strong>DEBE SELECCIONAR EL TIPO DE BENEFICIARIO.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 7: Vía de atención
                else if (red_social == null) {
                    $("#t-beneficiario").removeClass('is-invalid');
                    $("#red-social").addClass('is-invalid');
                    focusAndScroll("#red-social");
                    Swal.fire({ icon: "error", html: '<strong>DEBE SELECCIONAR LA VÍA DE ATENCIÓN.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 8: Correo
                else if (correo == '') {
                    $("#red-social").removeClass('is-invalid');
                    $("#correo").addClass('is-invalid');
                    focusAndScroll("#correo");
                    Swal.fire({ icon: "error", html: '<strong>DEBE INGRESAR EL CORREO ELECTRÓNICO.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                }
            }

            // --- PASO 2: VALIDACIONES ESPECÍFICAS ---
            if (formStepsNum === 1 && !hasError) {
                
                // Validación 1: Estado del caso
                if (estado == null) 
                {
                    $("#correo").removeClass('is-invalid');
                    $("#estado-caso").addClass('is-invalid');
                    focusAndScroll("#estado-caso");
                    Swal.fire({ icon: "error", html: '<strong>EL CAMPO ESTADO ES OBLIGATORIO.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
                // Validación 2: Tipo de atención
                else if (tipo_atencion == null) 
                {
                    $("#estado-caso").removeClass('is-invalid');
                    $("#tipo-atencion-usu").addClass('is-invalid');
                    focusAndScroll("#tipo-atencion-usu");
                    Swal.fire({ icon: "error", html: '<strong>EL USUARIO DEBE TENER ALGÚN TIPO DE ATENCIÓN.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;
                } 
// --- VALIDACIÓN DINÁMICA PASO 2: Propiedad Intelectual ---
                else if ($('.tipoproint').is(':visible')) {
                    let tieneSeleccion = false;
                    let tipo_atencion = $("#tipo-atencion-usu").val();

                    if (tipo_atencion == 24) {
                        // Para Consignación, validamos que haya al menos un check en la tabla
                        tieneSeleccion = $('.check-pi:checked').length > 0;
                    } else {
                        // Para los demás, validamos el select normal
                        let valPi = $("#tipo-pi").val();
                        tieneSeleccion = (valPi !== null && valPi !== '0' && valPi !== '');
                    }

                    if (!tieneSeleccion) {
                        $("#tipo-atencion-usu").removeClass('is-invalid');
                        
                        // Si es 24, resaltamos la tabla, si no, el select
                        if (tipo_atencion == 24) {
                            $("#pi-table-container").addClass('is-invalid');
                            focusAndScroll("#pi-table-container");
                        } else {
                            $("#tipo-pi").addClass('is-invalid');
                            focusAndScroll("#tipo-pi");
                        }

                        Swal.fire({ 
                            icon: "error", 
                            html: '<strong>DEBE SELECCIONAR AL MENOS UN TIPO DE PROPIEDAD INTELECTUAL.</strong>', 
                            toast: true, 
                            position: "center", 
                            showConfirmButton: false, 
                            timer: 3500 
                        });
                        hasError = true;
                    }
                } 
                // Validación 4: Tipo de atención 23 (Lógica de contraparte)
                else if (tipo_atencion == 23) {
                    
                    $("#tipo-atencion-usu").removeClass('is-invalid');
                    
                    let hasErrorTipo23 = false;
                    const REGEX_IDENTIFICACION_ESTRICTA = /^\d{5,}(?:-\d{1})?$/; 

                    // --- 2.1. Validar Propiedad Intelectual ---
                    if (tipo_prop_intelec == null) {
                        $("#tipo-pi").addClass('is-invalid').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
                        Swal.fire({ icon: "error", html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500, focusConfirm: false, allowOutsideClick: true });
                        hasErrorTipo23 = true;
                    } else {
                        $("#tipo-pi").removeClass('is-invalid');

                        let $ident = $("#contraparte-ident-valor");
                        let $nombre = $("#contraparte-nombre-razon");
                        let $telefono = $("#contraparte-telefono");
                        let $correo = $("#contraparte-correo");
                        
                        let contraparte_nombre = $nombre.val();
                        let contraparte_telefono = $telefono.val();
                        let contraparte_correo = $correo.val();
                        let contraparte_ident = $ident.val();

                        // 2.2. Validar Nombre/Razón Social (Obligatorio)
                        if (contraparte_nombre == null || contraparte_nombre.trim() === '')
                        {
                            $nombre.removeClass('border-gray-300').addClass('border-red-500').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' }); 
                            $ident.removeClass('border-red-500').addClass('border-gray-300');
                            $telefono.removeClass('border-red-500').addClass('border-gray-300');
                            $correo.removeClass('border-red-500').addClass('border-gray-300');

                            Swal.fire({ icon: "error", html: '<strong>DEBE INDICAR EL NOMBRE o RAZÓN SOCIAL DE LA CONTRAPARTE.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500, focusConfirm: false, allowOutsideClick: true });
                            hasErrorTipo23 = true;
                        } else {
                            $nombre.removeClass('border-red-500').addClass('border-gray-300');

                            // 2.3. Validar Teléfono (Obligatorio)
                            if (contraparte_telefono == null || contraparte_telefono.trim() === '') {
                                $telefono.removeClass('border-gray-300').addClass('border-red-500').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' }); 
                                $ident.removeClass('border-red-500').addClass('border-gray-300');
                                $correo.removeClass('border-red-500').addClass('border-gray-300');

                                Swal.fire({ icon: "error", html: '<strong>DEBE INDICAR EL TELÉFONO DE LA CONTRAPARTE.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500, focusConfirm: false, allowOutsideClick: true });
                                hasErrorTipo23 = true;
                            } else {
                                $telefono.removeClass('border-red-500').addClass('border-gray-300');

                                // 2.4. Validar Correo (Obligatorio)
                                if (contraparte_correo == null || contraparte_correo.trim() === '') {
                                    $correo.removeClass('border-gray-300').addClass('border-red-500').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' }); 
                                    $ident.removeClass('border-red-500').addClass('border-gray-300');
                                    
                                    Swal.fire({ icon: "error", html: '<strong>DEBE INDICAR EL CORREO DE LA CONTRAPARTE.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500, focusConfirm: false, allowOutsideClick: true });
                                    hasErrorTipo23 = true;
                                } else {
                                    $correo.removeClass('border-red-500').addClass('border-gray-300');

                                    // 2.5. Validar Identificación Estricta (Opcional) 
                                    const ident_valor_trimmed = contraparte_ident.trim();

                                    if (ident_valor_trimmed !== '') {
                                        let valor_a_validar = ident_valor_trimmed.replace(/[. ]/g, '').toUpperCase();
                                        
                                        if (!REGEX_IDENTIFICACION_ESTRICTA.test(valor_a_validar)) {
                                            $ident.removeClass('border-gray-300').addClass('border-red-500').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' }); 
                                            Swal.fire({ icon: "error", html: '<strong>Identificación inválida. Formato: Mínimo 5 dígitos (ej: 12345) o 12345678-2..</strong>', toast: true, position: "center", showConfirmButton: false, timer: 4000, focusConfirm: false, allowOutsideClick: true });
                                            hasErrorTipo23 = true;
                                        } else {
                                            $ident.removeClass('border-red-500').addClass('border-gray-300');
                                        }
                                    } else {
                                         $ident.removeClass('border-red-500').addClass('border-gray-300');
                                    }
                                }
                            }
                        }
                    }
                    
                    // Si NO hay errores en este bloque específico, avanza
                    if (!hasErrorTipo23) {
                        formStepsNum++;
                        updateFormSteps();
                        updateProgressbar();
                    }
                    return; // Salir después de manejar la validación 23
                }
                // Validación 5: Coordenadas y Detalles
                else if (actcoordenadas == 't' && detalles_atencion == null) 
                {
                    $("#tipo-atencion-usu").removeClass('is-invalid');
                    $("#detalles_atencion").addClass('is-invalid');
                    focusAndScroll("#detalles_atencion");
                    Swal.fire({ icon: "error", html: '<strong>DEBE SELECCIONAR UN DETALLE DE ATENCIÓN.</strong>', toast: true, position: "center", showConfirmButton: false, timer: 3500 });
                    hasError = true;

                } 
                // Validación 6: Tipo de atención 5 (Denuncia)
                else if (tipo_atencion === '5') {
                    let denu_involucrados = $('#denu-involucrados').val().trim();
                    let fecha_hechos = $('#fecha-hechos').val();
                    let option_personal = document.getElementById('option-personal').checked;
                    let option_comunidad = document.getElementById('option-comunidad').checked;
                    let option_terceros = document.getElementById('option-terceros').checked;

                    if (!option_personal && !option_comunidad && !option_terceros) {
                        alert('Debe indicar a quien afecta el hecho');
                        hasError = true;
                    } else if (fecha_hechos == '') {
                        alert('Debe seleccionar la fecha en que ocurrieron los hechos');
                        hasError = true;
                    } else if (denu_involucrados === '') {
                        $("#denu-involucrados").addClass('is-invalid');
                        alert('Este campo es requerido, por favor introduzca la información solicitada');
                        hasError = true;
                    }
                    
                    if (!hasError) {
                        formStepsNum++;
                        updateFormSteps();
                        updateProgressbar();
                    }
                    return; // Salir después de manejar la validación 5
                }

                // Lógica de avance final para el Paso 2 (si no es 23 ni 5)
                if (!hasError) {
                    formStepsNum++;
                    updateFormSteps();
                    updateProgressbar();
                }
            }


            // --- LÓGICA DE AVANCE GENÉRICA ---
            // Solo avanza si estamos en el Paso 1 (formStepsNum=0) Y NO hubo errores.
            if (formStepsNum === 0 && !hasError) {
                formStepsNum++;
                updateFormSteps();
                updateProgressbar();
            }
        });
    });
        
    // --- Manejo del botón Anterior ---

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            formStepsNum--;
            updateFormSteps();
            updateProgressbar();
        });
    });

    // Llama a updateFormSteps al cargar para asegurar el estado inicial
    updateFormSteps();
</script>
  
</html>

     
      <!-- ***** FUNCION PARA SOLO LETRAS***-** -->
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>


      
<!-- ***** FUNCION PARA SOLO NUMEROS***-** -->
<script type="text/javascript">
  function valideKey(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;
    if (code == 8) { // backspace.
      return true;
    } else if (code >= 48 && code <= 57) { // is a number.
      return true;
    } else { // other keys.
      return false;
    }
  }
</script>

     

      <script>
      document.addEventListener('DOMContentLoaded', function() {
      const textarea = document.getElementById('denu-involucrados');
      textarea.addEventListener('click', function() {
      if (textarea.value.trim() === '') {
      textarea.setSelectionRange(0, 0);
      } else {
      textarea.setSelectionRange(textarea.value.length, textarea.value.length);
      }
      });
      });
      </script>

      <script>
        function valideKey(evt) {
    // Permitir solo números
    var code = (evt.which) ? evt.which : evt.keyCode;
    if (code < 48 || code > 57) {
        evt.preventDefault();
    }

    // Limitar a 12 dígitos
    var input = document.getElementById("telefono");
    if (input.value.length >= 12) {
        evt.preventDefault();
    }
}
      </script>