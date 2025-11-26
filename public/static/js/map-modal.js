// map-modal.js
(function (global) {
  const modalOverlay = document.getElementById('modalOverlay');
  const modalBody = document.getElementById('modalBody');
  const modal = document.getElementById('modal');
  const modalCloseBtn = document.getElementById('modalClose');

  function openModal(contentObj) {
    if (!modalOverlay) return;
    // contentObj: { properties, coordinates, configKey }
    var props = contentObj && contentObj.properties ? contentObj.properties : {};
    var coords = contentObj && contentObj.coordinates ? contentObj.coordinates : null;
    var configKey = contentObj && contentObj.configKey ? contentObj.configKey : 'default';
    var config = window.ModalConfig && window.ModalConfig[configKey] ? window.ModalConfig[configKey] : (window.ModalConfig ? window.ModalConfig.default : null);
    var html = '';
    // Helper: escape HTML to avoid injection
    function escapeHtml(str) {
      return String(str === undefined || str === null ? '' : str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    // Helper: format values (primitive, array, object) for safe display
    function formatValueForDisplay(v) {
      if (v === undefined || v === null) return '';
      if (typeof v === 'string' || typeof v === 'number' || typeof v === 'boolean') return escapeHtml(v);
      if (Array.isArray(v)) {
        if (v.length === 0) return '<span class="empty-array">(vacío)</span>';
        var allPrimitive = v.every(function(el){ return (typeof el !== 'object'); });
        if (allPrimitive) return escapeHtml(v.join(', '));
        return '<pre>' + escapeHtml(JSON.stringify(v, null, 2)) + '</pre>';
      }
      // object -> pretty JSON
      try {
        return '<pre>' + escapeHtml(JSON.stringify(v, null, 2)) + '</pre>';
      } catch (e) {
        return escapeHtml(String(v));
      }
    }

    // Render an attachments grid for value which can be array, object or string
    function renderAttachmentsGrid(value, field) {
      if (value === undefined || value === null) return '<div class="attachments-empty">No hay elementos</div>';
      var items = Array.isArray(value) ? value : [value];

      function isImageUrl(u) {
        return typeof u === 'string' && /\.(jpe?g|png|gif|webp|svg)(\?|$)/i.test(u);
      }

      var cards = items.map(function(item){
        var label = '';
        var url = null;
        if (typeof item === 'string') {
          label = item;
          if (/^(https?:\/\/|\/|\.\.?\/)/i.test(item)) url = item;
        } else if (typeof item === 'object' && item !== null) {
          var urlKeys = ['url','ruta','path','link','archivo','archivo_url','ruta_archivo','file','archivo_path'];
          for (var k=0;k<urlKeys.length;k++){
            var uk = urlKeys[k];
            if (item[uk]) { url = item[uk]; break; }
          }
          var labelKeys = ['name','nombre','title','titulo','label','descripcion','descripcion_caso','filename','nombre_archivo'];
          for (var j=0;j<labelKeys.length;j++){
            var lk = labelKeys[j];
            if (item[lk]) { label = item[lk]; break; }
          }
          if (!label) {
            var keys = Object.keys(item || {});
            if (keys.length === 1) label = String(item[keys[0]]);
            else label = keys.slice(0,3).map(function(k){ return k + ': ' + String(item[k]); }).join(' | ');
          }
        } else {
          label = String(item);
        }

        var safeLabel = escapeHtml(label || 'Archivo');
        // compute file type for icon/thumbnail decisions
        function fileExtOf(u) {
          if (!u) return '';
          var m = String(u).split('?')[0].match(/\.([0-9a-zA-Z]+)$/);
          return m ? m[1].toLowerCase() : '';
        }
        var ext = fileExtOf(url || (typeof item === 'string' ? item : ''));
        var isImage = isImageUrl(url || (typeof item === 'string' ? item : ''));

        var cardHtml = '<div class="attachment-card" data-type="' + (isImage ? 'image' : (ext || 'file')) + '">';

        // If no url found but the field requests link construction, try to build it
        if (!url && field && field.link) {
          // try to get a filename-like value from item
          var candidate = null;
          if (typeof item === 'string') candidate = item;
          else if (typeof item === 'object' && item !== null) {
            var filenameKeys = ['filename','nombre_archivo','file','archivo','path','ruta','ruta_archivo'];
            for (var fk=0; fk<filenameKeys.length; fk++) {
              if (item[filenameKeys[fk]]) { candidate = item[filenameKeys[fk]]; break; }
            }
          }
          if (candidate) {
            // determine base from `window.ruta` or global `ruta` const
            var base = (typeof window !== 'undefined' && window.ruta) ? window.ruta : (typeof ruta !== 'undefined' ? ruta : '');
            var prefix = '';
            if (base) prefix = base.replace(/\/$/, '') + '/';
            if (field.carpet) prefix += String(field.carpet).replace(/^\//, '').replace(/\/$/, '') + '/';
            // join carefully
            var candStr = String(candidate).replace(/^\/*/, '');
            url = prefix + candStr;
          }
        }

        // Build a structured card: thumb/icon + info
        var safeUrlFinal = url ? escapeHtml(url) : null;
        cardHtml += '<div class="attachment-thumb">';
        if (safeUrlFinal && isImage) {
          cardHtml += '<a href="' + safeUrlFinal + '" target="_blank" rel="noopener noreferrer">';
          cardHtml += '<img src="' + safeUrlFinal + '" alt="' + safeLabel + '" loading="lazy">';
          cardHtml += '</a>';
        } else if (safeUrlFinal) {
          // show a file icon with extension
          cardHtml += '<a class="attachment-link" href="' + safeUrlFinal + '" target="_blank" rel="noopener noreferrer">';
          cardHtml += '<div class="file-icon">' + escapeHtml(ext ? ext.toUpperCase() : 'FILE') + '</div>';
          cardHtml += '</a>';
        } else {
          cardHtml += '<div class="file-icon file-icon--blank">' + escapeHtml((ext || '').toUpperCase() || 'DOC') + '</div>';
        }
        cardHtml += '</div>';

        cardHtml += '<div class="attachment-info">';
        if (safeUrlFinal) {
          cardHtml += '<a class="attachment-label" href="' + safeUrlFinal + '" target="_blank" rel="noopener noreferrer">' + safeLabel + '</a>';
          cardHtml += '<div class="attachment-meta">Abrir en nueva pestaña</div>';
        } else {
          cardHtml += '<div class="attachment-label">' + safeLabel + '</div>';
        }
        cardHtml += '</div>';

        cardHtml += '</div>';
        return cardHtml;
      }).join('');

      return '<div class="attachments-grid">' + cards + '</div>';
    }

    // Render an array of structured elements according to a `field.elements` config
    function renderElementsForArray(field, value) {
      var items = Array.isArray(value) ? value : (value === undefined || value === null ? [] : [value]);

      function formatValueForDisplay(v) {
        if (v === undefined || v === null) return '';
        if (typeof v === 'string' || typeof v === 'number' || typeof v === 'boolean') return escapeHtml(v);
        if (Array.isArray(v)) {
          if (v.length === 0) return '<span class="empty-array">(vacío)</span>';
          // join primitives, otherwise JSON stringify
          var allPrimitive = v.every(function(el){ return (typeof el !== 'object'); });
          if (allPrimitive) return escapeHtml(v.join(', '));
          return '<pre>' + escapeHtml(JSON.stringify(v, null, 2)) + '</pre>';
        }
        // object -> pretty JSON
        try {
          return '<pre>' + escapeHtml(JSON.stringify(v, null, 2)) + '</pre>';
        } catch (e) {
          return escapeHtml(String(v));
        }
      }

      function normalizeKeyMap(obj) {
        var m = {};
        Object.keys(obj || {}).forEach(function(k){ m[String(k).toLowerCase().replace(/[_\s]+/g,'')] = k; });
        return m;
      }

      function findValueInItem(item, key) {
        if (!item) return undefined;
        if (Object.prototype.hasOwnProperty.call(item, key)) return item[key];
        var nk = String(key).toLowerCase().replace(/[_\s]+/g,'');
        var km = normalizeKeyMap(item);
        if (km[nk]) return item[km[nk]];
        // relaxed match
        var match = Object.keys(km).find(function(k){ return k.indexOf(nk) !== -1 || nk.indexOf(k) !== -1; });
        if (match) return item[km[match]];
        return undefined;
      }

      var html = '<div class="elements-grid">';
      items.forEach(function(it, idx){
        html += '<div class="element-card">';
        html += '<div class="element-card-header">' + (field.elementTitle ? escapeHtml(String(field.elementTitle).replace('{index}', idx+1)) : ('#' + (idx+1))) + '</div>';
        html += '<div class="element-card-body">';
        var elems = field.elements || {};
        Object.keys(elems).forEach(function(k){
          var def = elems[k] || {};
          var v = findValueInItem(it, def.key || k);
          if (def.grip) {
            html += '<div class="element-row"><strong>' + escapeHtml(def.label || def.key || k) + ':</strong>' + renderAttachmentsGrid(v, def) + '</div>';
          } else {
            html += '<div class="element-row"><span class="element-label">' + escapeHtml(def.label || def.key || k) + ':</span> <span class="element-value">' + formatValueForDisplay(v) + '</span></div>';
          }
        });
        html += '</div>';
        html += '</div>';
      });
      html += '</div>';
      return html;
    }

    if (config && config.fields) {
      html += '<div class="modal-fields">';
      config.fields.forEach(function(field) {
        // If the field defines `elements`, render structured element cards (array items)
        if (field.elements) {
          var val = props[field.key];
          if (val !== undefined) {
            if (field.section) {
              var secIdEl = 'section_' + escapeHtml(field.key) + '_el';
              html += '<div class="modal-section">';
              html += '<div class="section-header"><button type="button" class="section-toggle" data-target="' + secIdEl + '" aria-expanded="true">' + escapeHtml(field.label || field.key) + ' <span class="section-icon">▾</span></button></div>';
              html += '<div id="' + secIdEl + '" class="section-body">' + renderElementsForArray(field, val) + '</div>';
              html += '</div>';
            } else {
              html += '<div class="modal-field"><strong>' + escapeHtml(field.label || field.key) + ':</strong>' + renderElementsForArray(field, val) + '</div>';
            }
          }
          return; // skip further processing for this field
        }

        // If field has 'grip' (grid) set, render an attachments grid regardless of show flag
        if (field.grip) {
          var val = props[field.key];
          if (val !== undefined) {
            // If this field is a section, render a collapsible block
            if (field.section) {
              var secId = 'section_' + escapeHtml(field.key);
              html += '<div class="modal-section">';
              html += '<div class="section-header"><button type="button" class="section-toggle" data-target="' + secId + '" aria-expanded="true">' + escapeHtml(field.label || field.key) + ' <span class="section-icon">▾</span></button></div>';
              html += '<div id="' + secId + '" class="section-body">' + renderAttachmentsGrid(val, field) + '</div>';
              html += '</div>';
            } else {
              html += '<div class="modal-field"><strong>' + escapeHtml(field.label || field.key) + ':</strong>' + renderAttachmentsGrid(val, field) + '</div>';
            }
          }
          return; // skip default rendering for this field
        }

        if (field.show && props[field.key] !== undefined) {
          html += '<div class="modal-field--small"><strong>' + escapeHtml(field.label || field.key) + ':</strong> ' + formatValueForDisplay(props[field.key]) + '</div>';
        }
      });
      html += '</div>';
    } else {
      html += '<pre>' + escapeHtml(JSON.stringify(props, null, 2)) + '</pre>';
    }
    if (config && config.showCoordinates && coords) {
      html += '<div class="modal-coords">Coordenadas: ' + String(coords) + '</div>';
    }
    modalBody.innerHTML = html;
    // Attach toggle handlers for any collapsible sections rendered
    try {
      var toggles = modalBody.querySelectorAll('.section-toggle');
      toggles.forEach(function(btn){
        var targetId = btn.getAttribute('data-target');
        var target = document.getElementById(targetId);
        if (!target) return;
        btn.addEventListener('click', function(){
          var expanded = btn.getAttribute('aria-expanded') === 'true';
          if (expanded) {
            btn.setAttribute('aria-expanded', 'false');
            target.classList.add('section-collapsed');
            var icon = btn.querySelector('.section-icon'); if (icon) icon.textContent = '▸';
          } else {
            btn.setAttribute('aria-expanded', 'true');
            target.classList.remove('section-collapsed');
            var icon = btn.querySelector('.section-icon'); if (icon) icon.textContent = '▾';
          }
        });
      });
    } catch (e) {
      console.warn('section toggle setup failed', e);
    }
    modalOverlay.classList.add('show');
    modal.classList.add('showModal');
    modalOverlay.setAttribute('aria-hidden', 'false');
  }

  function closeModal() {
    if (!modalOverlay) return;
    modalOverlay.classList.remove('show');
    modal.classList.remove('showModal');
    modalOverlay.setAttribute('aria-hidden', 'true');
  }

  if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
  if (modalOverlay) modalOverlay.addEventListener('click', function (e) {
    if (e.target === modalOverlay) closeModal();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  global.MapApp = global.MapApp || {};
  global.MapApp.openModal = openModal;
  global.MapApp.closeModal = closeModal;
})(window);