// map-api.js
(function (global) {
  // Versión simplificada de map-api.js
  var url = ruta+'Listar_Casos_Ayuda';

  function parseNumber(v) {
    if (v === undefined || v === null) return NaN;
    if (typeof v === 'string') v = v.trim().replace(/,/g, '.');
    return parseFloat(v);
  }

  // Convierte un array de items en GeoJSON usando preferentemente
  // 'latitud_caso' y 'longitud_caso'. Las propiedades quedan vacías.
  // Nota: eliminada la heurística compleja. Se hará match directo entre
  // la `key` definida en ModalConfig.default.fields y las claves que llegan
  // en el objeto `item` del API (con normalización simple).

  function toGeoJSON(items) {
    if (!Array.isArray(items)) items = [];

    // campos definidos en la configuración (dinámico)
    var configFields = (window.ModalConfig && window.ModalConfig.default && window.ModalConfig.default.fields) || [];

    var features = items.map(function (item, i) {
      var lat = parseNumber(item.latitud_caso || item.latitud);
      var lng = parseNumber(item.longitud_caso || item.longitud);
      if (isNaN(lat) || isNaN(lng)) {
        console.warn('toGeoJSON: invalid coords at index', i, { lat: item.latitud_caso || item.latitud, lng: item.longitud_caso || item.longitud });
        return null;
      }

      // construir properties dinámicamente a partir de ModalConfig.default.fields
      // Buscaremos una coincidencia directa entre la key de la config y la key
      // del item usando una normalización: lowercase y quitar guiones bajos/espacios.
      var props = {};
      // construir un mapa de claves normalizadas -> clave original
      var keyMap = {};
      Object.keys(item || {}).forEach(function(k){
        var nk = String(k).toLowerCase().replace(/[_\s]+/g, '');
        if (!keyMap[nk]) keyMap[nk] = k;
      });

      for (var j = 0; j < configFields.length; j++) {
        var fk = configFields[j] && configFields[j].key;
        if (!fk) continue;
        var norm = String(fk).toLowerCase().replace(/[_\s]+/g, '');
        // prioridad: clave exacta tal cual en el objeto
        if (item.hasOwnProperty(fk)) {
          props[fk] = item[fk];
        } else if (keyMap[norm]) {
          // coincidencia exacta normalizada
          props[fk] = item[keyMap[norm]];
        } else {
          // intento relajado: buscar una clave cuya versión normalizada contenga
          // la norma buscada o viceversa (ej. rutasdocumentos vs rutasdocumentoscaso)
          var matchKey = null;
          Object.keys(keyMap).some(function(nk){
            if (nk === norm) { matchKey = nk; return true; }
            if (nk.indexOf(norm) !== -1) { matchKey = nk; return true; }
            if (norm.indexOf(nk) !== -1) { matchKey = nk; return true; }
            return false;
          });
          if (matchKey) {
            props[fk] = item[keyMap[matchKey]];
          } else {
            props[fk] = null;
          }
        }
      }

      // Normalizadores: asegurar que ciertos campos siempre tengan formato consistente
      function tryParseJSON(val) {
        if (typeof val !== 'string') return val;
        try {
          return JSON.parse(val);
        } catch (e) {
          return val;
        }
      }

      function normalizeArrayOfObjects(val) {
        val = tryParseJSON(val);
        if (val === undefined || val === null) return [];
        // If it's already an array
        if (Array.isArray(val)) {
          return val.map(function(el){
            if (el === undefined || el === null) return {};
            return (typeof el === 'object') ? el : { value: el };
          });
        }
        // If it's an object where values are objects (e.g. { '0': {...}, '1': {...} })
        if (typeof val === 'object') {
          var keys = Object.keys(val || {});
          // if the object appears to be an index-keyed collection, return its values
          var hasObjectValue = keys.some(function(k){ return typeof val[k] === 'object'; });
          if (hasObjectValue) {
            return keys.map(function(k){
              var v = val[k];
              return (v === undefined || v === null) ? {} : (typeof v === 'object' ? v : { value: v });
            });
          }
          // otherwise treat the whole object as a single item
          return [val];
        }
        // primitive value -> wrap
        return [{ value: val }];
      }

      // Normalize puntos_cuenta specifically (and other similar fields if needed)
      if (props.hasOwnProperty('puntos_cuenta')) {
        try {
          props.puntos_cuenta = normalizeArrayOfObjects(props.puntos_cuenta);
        } catch (e) {
          props.puntos_cuenta = [];
        }
      }

      return { type: 'Feature', properties: props, geometry: { type: 'Point', coordinates: [lng, lat] } };
    }).filter(Boolean);

    console.debug('toGeoJSON: created', features.length, 'features from', items.length);
    return { type: 'FeatureCollection', features: features };
  }

  // Llama al API y convierte la respuesta a GeoJSON.
  function fetchGeoJSON() {
    return fetch(url)
      .then(function (res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
      })
      .then(function (data) {
        console.debug('fetchGeoJSON: received', Array.isArray(data) ? data.length : 0, 'items');
        return toGeoJSON(data);
      })
      .catch(function (err) {
        console.error('fetchGeoJSON error:', err);
        return { type: 'FeatureCollection', features: [] };
      });
  }

  global.MapAPI = global.MapAPI || {};
  global.MapAPI.fetchGeoJSON = fetchGeoJSON;
})(window);
