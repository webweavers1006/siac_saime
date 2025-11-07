
<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/agregar_caso.css">



<style>


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
    width: 80%;
  }

  .textarea{
    width: 80%;
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
        <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6">
          <div style="display: flex;">  <label for="cedula-persona">Buscar Cédula o Rif  &nbsp;&nbsp;&nbsp; </label>
            <input type="text" class="form-control" style="width: 200px;"  name="cedula-existente" min="7" id="cedula-existente" autocomplete="off">
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
              <input type="text" class="form-control" onkeypress="return valideKey(event);"name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
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

          <!-- <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="t-beneficiario">Tipo de Beneficiario</label>
              <select class="form-control" id="t-beneficiario" name="t-beneficiario">
              <option value="1" selected>Usuario</option>
              <option value="2">Emprendedor</option>
              </select>
          </div> -->
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
          <input type="email" class="form-control" name="correo" id="correo" autocomplete="off" required>
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
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                      crossorigin=""/>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                        crossorigin=""></script>

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
        alert("No se pudo obtener tu ubicación automáticamente. El mapa se centrará en un punto por defecto.");
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
 <div class="row">
          <div class="col-lg-4 col-sm-4 col-md-4  tipoproint" style="display: none;" >
              <label for="tipo-pi">Tipo de Propiedad Intelectual </label>
              <select class="form-control  tipo-pi"  id="tipo-pi" name="tipo-pi">
              <option value="0">Seleccione</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3  org_pp "  style="display: none;">
          <label for="organismo-caso">Organismo del Poder Poular</label>
          <select id="organismo-caso" name="organismo-caso" class="form-control">
          <option value="0">Seleccione Organismo</option>
          </select>
          </div>
          
          
          <!-- IMPUT QUE VALIDA SI SE SELECCIONO UN TIPO DE ATENCION CON HIJOS -->
          <input type="hidden" class="form-control" name="hijos_tipoatencion" id="hijos_tipoatencion" autocomplete="off" >


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
                          <br>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">ANTERIOR</a>
          <a href="#" class="btn btn-next">SIGUIENTE</a>
        </div>
      </div>
      
    


      <div class="form-step">
         <div class="row">
       
        <div>
            <label for="planteamiento-caso">Descripción del Caso</label>
            <textarea type="text" class="form-control"     style="width: 1000px;"      name="requerimiento-usuario" id="requerimiento-usuario" required>
            </textarea>
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

const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {

    let nombre_persona = $("#nombre-persona").val();
    let apellido_persona = $("#apellido-persona").val();
    let cedula_persona = $("#cedula-persona").val();
    let red_social = $("#red-social").val();
    //let edad = $("#edad").val();
    let fecha_nacimiento = $("#fecha-nacimiento").val();
    let profesion = $("#profesion").val();
    let correo = $("#correo").val();
    let estado = $("#estado-caso").val();
    let tipo_atencion = $("#tipo-atencion-usu").val();
    let tipo_prop_intelec = $("#tipo-pi").val();
    let fecha_recivido=$("#fecha-recibido").val();
    let actcoordenadas=$("#actcoordenadas").val();
    let detalles_atencion=$("#detalles_atencion").val();
    let t_beneficiario=$("#t-beneficiario").val();

     
    if (fecha_recivido>getFormattedDate()) 
    {
     alert('La fecha de creación no debe ser mayor al dia de hoy ')
    }else if (nombre_persona == '') {
        $("#nombre-persona").addClass('is-invalid');

        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL NOMBRE.</strong>',

            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    } else if (apellido_persona == '') {
        $("#nombre-persona").removeClass('is-invalid');
        $("#apellido-persona").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL APELLIDO.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    } else if (cedula_persona == '') {
        $("#apellido-persona").removeClass('is-invalid');
        $("#cedula-persona").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL NÚMERO DE CEDULA.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
      
      // else if (edad == '') {
      //   $("#apellido-persona").removeClass('is-invalid');
      //   $("#edad").addClass('is-invalid');
      //   Swal.fire({
      //       icon: "success",
      //       type: 'error',
      //       html: '<strong>DEBE INGRESAR LA EDAD </strong>',
      //       toast: true,
      //       position: "center",
      //       showConfirmButton: false,
      //       timer: 3500,
      //   });
    
      // } 
      else if (fecha_nacimiento == '' ||fecha_nacimiento == 'NULL'  ) {
        //$("#edad").removeClass('is-invalid');
        $("#fecha-nacimiento").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR LA DE FECHA DE NACIMIENTO </strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
     


      else if (t_beneficiario == null ||t_beneficiario == 'null'  ) {
         $("#fecha-nacimiento").removeClass('is-invalid');
        $("#t-beneficiario").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE SELECCIONAR EL TIPO DE BENEFICIARIO </strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
      
      
      
      
      
      else if (red_social == null) {
         $("#t-beneficiario").removeClass('is-invalid');
        $("#red-social").addClass('is-invalid');
        $("#cedula-persona").removeClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE SELECCIONAR LA VIA DE ATENCION.</strong>',

            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    }else if (correo == '') {
      $("#red-social").removeClass('is-invalid');
        $("#correo").addClass('is-invalid');

        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL CORREO ELECTRONICO.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    }
    
 
    

    else
    {
      if (formStepsNum>0) {
        if (estado == null) 
        {
          $("#correo").removeClass('is-invalid');
          $("#estado-caso").addClass('is-invalid');
          Swal.fire({
              icon: "success",
              type: 'error',
              html: '<strong>EL CAMPO ESTADO ES OBLIGATORIO.</strong>',
              toast: true,
              position: "center",
              showConfirmButton: false,
              timer: 3500,
          });
        }else if (tipo_atencion == null) 
        {
          $("#estado-caso").removeClass('is-invalid');
          $("#tipo-atencion-usu").addClass('is-invalid');
          Swal.fire({
              icon: "success",
              type: 'error',
              html: '<strong>EL USUARIO DEBE TENER ALGUN TIPO DE ATENCION</strong>',
              toast: true,
              position: "center",
              showConfirmButton: false,
              timer: 3500,
          })
        }else if (tipo_atencion == 1&& tipo_prop_intelec==null) 
        {
            $("#tipo-atencion-usu").removeClass('is-invalid');
              $("#tipo-pi").addClass('is-invalid');
              Swal.fire({
                  icon: "success",
                  type: 'error',
                  html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>',
                  toast: true,
                  position: "center",
                  showConfirmButton: false,
                  timer: 3500,
              });

        }

        else if (actcoordenadas =='t' && detalles_atencion==null) 
        {
            $("#tipo-atencion-usu").removeClass('is-invalid');
              $("#detalles_atencion").addClass('is-invalid');
              Swal.fire({
                  icon: "success",
                  type: 'error',
                  html: '<strong>DEBE SELECCIONAR UN DETALLE DE ATENCION.</strong>',
                  toast: true,
                  position: "center",
                  showConfirmButton: false,
                  timer: 3500,
              });

        }
        
        
        
        
        else  if (tipo_atencion === '5') 
          {
            let denu_involucrados = $('#denu-involucrados').val();
            let fecha_hechos = $('#fecha-hechos').val();
            denu_involucrados = denu_involucrados.trim();
            if (document.getElementById('option-personal').checked) {
                option_personal = true
            } else {
                option_personal = false
            }
            if (document.getElementById('option-comunidad').checked) {
                option_comunidad = true
            } else {
                option_comunidad = false
            }
            if (document.getElementById('option-terceros').checked) {
                option_terceros = true
            } else {
                option_terceros = false
            }

            if (option_personal == false && option_comunidad == false && option_terceros == false) {
                alert('Debe indicar a quien afecta el hecho');
            }else {
               

                if (fecha_hechos == '') {
                    alert('Debe selecciar la fecha en que ocurrieron los hechos');

                } else if (denu_involucrados === '') {
                    $("#denu-involucrados").addClass('is-invalid');
                    alert('Este campo es requerido , por favor introduzca la informacion solicitada');
                }else
                {
                  formStepsNum++;
                  updateFormSteps();
                  updateProgressbar();
                }
              }
          } else
                {
                  formStepsNum++;
                  updateFormSteps();
                  updateProgressbar();
                }
         



      }else
      {
        formStepsNum++;
       updateFormSteps();
      updateProgressbar();
      }
   


    }

  });
});
    
prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum--;
  
    updateFormSteps();
    updateProgressbar();
    
  });
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
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