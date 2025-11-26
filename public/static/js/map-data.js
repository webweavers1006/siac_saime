// map-data.js
(function (global) {
  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function renderGeoJSON(geojson) {
    var map = global.MapApp.map;
    var openModal = global.MapApp.openModal;
    var config = window.ModalConfig && window.ModalConfig.default ? window.ModalConfig.default : {};
    var legendField = config.legend && config.legend.field ? config.legend.field : 'type';
    var legendEnabled = config.legend && config.legend.enabled;
    var palette = config.legend && config.legend.colorPalette ? config.legend.colorPalette : ['#3388ff', '#888'];
    var assignedColors = config.legend && config.legend.assignedColors ? config.legend.assignedColors : {};
    var nextColorIndex = config.legend ? config.legend.nextColorIndex : 0;

    // Recolectar todos los valores únicos del campo de leyenda y asignar colores si no existen
    var legendValues = {};
    geojson.features.forEach(function(f) {
      var val = f.properties && f.properties[legendField] ? f.properties[legendField] : 'default';
      legendValues[val] = true;
      if (!assignedColors[val]) {
        assignedColors[val] = palette[nextColorIndex % palette.length];
        nextColorIndex++;
      }
    });
    // Guardar el mapeo y el índice en la config para persistencia
    if (config.legend) {
      config.legend.assignedColors = assignedColors;
      config.legend.nextColorIndex = nextColorIndex;
    }
    var legendKeys = Object.keys(legendValues);

    // Agrupar los puntos por tipo usando LayerGroup
    var typeGroups = {};
    legendKeys.forEach(function(type){
      typeGroups[type] = L.layerGroup();
    });

    geojson.features.forEach(function(feature){
      var val = feature.properties && feature.properties[legendField] ? feature.properties[legendField] : 'default';
      var color = assignedColors[val] || palette[0];
      var coords = feature.geometry && feature.geometry.coordinates;
      var latlng = coords ? [coords[1], coords[0]] : null;
      if (!latlng) return;
      var marker = L.circleMarker(latlng, { radius: 7, fillColor: color, color: '#fff', weight: 1, fillOpacity: 0.9 });
      marker.feature = feature;
      marker.on('click', function () {
        var props = feature && feature.properties ? feature.properties : {};
        var configKey = props && props.name ? props.name.replace(/\s/g, '') : 'default';
        openModal({ properties: props, coordinates: coords, configKey: configKey });
      });
      typeGroups[val].addLayer(marker);
    });

    // Guardar los grupos en MapApp para control de visibilidad
    window.MapApp.typeGroups = typeGroups;

    // Agregar todos los grupos al mapa inicialmente
    legendKeys.forEach(function(type){
      typeGroups[type].addTo(map);
    });

    // Crear leyenda si está habilitada
    if (legendEnabled) {
      createLegend(legendKeys, assignedColors, legendField);
    }

    // Ajustar el mapa a los bounds de todos los puntos
    var allLayers = [];
    legendKeys.forEach(function(type){
      allLayers = allLayers.concat(typeGroups[type].getLayers());
    });
    if (allLayers.length > 0) {
      var group = L.featureGroup(allLayers);
      var bounds = group.getBounds();
      if (bounds && bounds.isValid && bounds.isValid()) {
        map.fitBounds(bounds, { maxZoom: 12, padding: [40, 40] });
      }
    }
  }

  function createLegend(keys, colors, field) {
    var legendId = 'mapLegend';
    var old = document.getElementById(legendId);
    var map = document.getElementById('map');
    if (old) old.remove();
    var legend = document.createElement('div');
    legend.id = legendId;
    legend.className = 'map-legend';
    legend.innerHTML = '<div class="legend-title">Leyenda</div>' +
      keys.map(function(k) {
        var color = colors[k] || colors['default'] || '#3388ff';
        return '<div class="legend-item" data-type="' + k + '" style="cursor:pointer;user-select:none;">'
          + '<span class="legend-color" style="background:' + color + '"></span>'
          + '<span class="legend-label" data-type="' + k + '">' + k + '</span>'
          + '</div>';
      }).join('');
    map.appendChild(legend);

    // Estado de visibilidad por tipo
    window.MapApp = window.MapApp || {};
    window.MapApp.legendVisibility = window.MapApp.legendVisibility || {};
    keys.forEach(function(k){ window.MapApp.legendVisibility[k] = true; });

    // Evento para activar/desactivar al hacer clic en el nombre
    legend.querySelectorAll('.legend-label').forEach(function(label){
      label.addEventListener('click', function(e){
        var type = e.target.getAttribute('data-type');
        window.MapApp.legendVisibility[type] = !window.MapApp.legendVisibility[type];
        updateLayerVisibility();
        updateLegendStyle(type);
      });
    });

    // Estilo visual para tipos desactivados
    function updateLegendStyle(type) {
      var item = legend.querySelector('.legend-item[data-type="' + type + '"]');
      if (!item) return;
      if (!window.MapApp.legendVisibility[type]) {
        item.style.opacity = '0.45';
        item.style.textDecoration = 'line-through';
      } else {
        item.style.opacity = '1';
        item.style.textDecoration = 'none';
      }
    }
    // Inicializar estilos
    keys.forEach(updateLegendStyle);
  }

  function updateLayerVisibility() {
    var map = window.MapApp.map;
    var typeGroups = window.MapApp.typeGroups || {};
    var legendVisibility = window.MapApp.legendVisibility || {};
    Object.keys(typeGroups).forEach(function(type){
      var group = typeGroups[type];
      var visible = legendVisibility[type];
      if (visible === undefined) visible = true;
      if (visible) {
        if (!map.hasLayer(group)) map.addLayer(group);
      } else {
        if (map.hasLayer(group)) map.removeLayer(group);
      }
    });
  }

  function fetchAndRenderData() {
    global.MapApp.setStatus('Obteniendo datos del API...');
    // Usar el módulo MapAPI si está disponible
    if (window.MapAPI && typeof window.MapAPI.fetchGeoJSON === 'function') {
      window.MapAPI.fetchGeoJSON()
        .then(function (geojson) {
          console.log(geojson)
          if (!geojson || !Array.isArray(geojson.features) || geojson.features.length === 0) {
            global.MapApp.setStatus('No hay datos en la respuesta.');
            return;
          }
          renderGeoJSON(geojson);
          global.MapApp.setStatus('Datos renderizados desde API o fallback.');
        })
        .catch(function (err) {
          console.error('MapAPI error:', err);
          global.MapApp.setStatus('Error al procesar datos del API.');
        });
    } else {
      console.warn('MapAPI no está disponible. Llamando a renderización local si existe.');
      global.MapApp.setStatus('MapAPI no disponible. Usando datos locales.');
      // Si MapAPI no está disponible, intenta usar el método anterior si está presente
      try {
        // No hay sample aquí — renderGeoJSON espera un GeoJSON; dejar que el resto del código maneje el caso.
      } catch (e) {
        console.error('Error fallback:', e);
      }
    }
  }

  global.MapApp = global.MapApp || {};
  global.MapApp.fetchAndRenderData = fetchAndRenderData;
  global.MapApp.renderGeoJSON = renderGeoJSON;
})(window);

(function () {
  window.MapApp.setStatus('Creando mapa...');
  window.MapApp.setStatus('Mapa listo. Preparado para recibir datos.');
  window.MapApp.fetchAndRenderData();
})();