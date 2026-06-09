/**
 * Mapa de Estadísticas — Leaflet + API SIAC
 * Reemplaza la implementación anterior de public/static/.
 *
 * Dependencias (cargadas por content.php):
 *   - Leaflet CSS/JS desde theme/plugins/leaflet/dist/
 *   - mapa.css para estilos del modal y leyenda
 */
(function () {
    'use strict';

    // ── Configuración ────────────────────────────────────────────
    const CONFIG = {
        center:        [10.4806, -66.9036],
        zoom:          6,
        tileLayer:     'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
        attribution:   '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>',
        maxZoom:       19,
        markerRadius:  7,
        legendField:   'nombre_tipo_atencion_detalle',
        palette: [
            '#3388ff', '#e67e22', '#27ae60', '#8e44ad', '#c0392b',
            '#f1c40f', '#16a085', '#34495e', '#e84393', '#00b894',
            '#6c5ce7', '#fd79a8', '#fdcb6e', '#0984e3', '#d63031',
            '#00cec9', '#a29bfe', '#fab1a0', '#81ecec', '#ffeaa7',
            '#dfe6e9', '#b2bec3', '#636e72', '#2d3436', '#e17055',
            '#74b9ff', '#55efc4', '#ff7675', '#a3cb38', '#ef5777'
        ]
    };

    // ── Centroides geográficos de los estados de Venezuela ───────
    const STATE_CENTROIDS = {
        'Distrito Capital':      [10.4806, -66.9036],
        'Amazonas':              [3.5000,  -66.0000],
        'Anzoátegui':            [9.0000,  -64.5000],
        'Apure':                 [7.0000,  -68.5000],
        'Aragua':                [10.0000, -67.5000],
        'Barinas':               [8.0000,  -69.5000],
        'Bolívar':               [6.5000,  -63.5000],
        'Carabobo':              [10.0000, -68.0000],
        'Cojedes':               [9.0000,  -68.5000],
        'Delta Amacuro':         [8.5000,  -61.5000],
        'Falcón':                [11.0000, -69.5000],
        'Guárico':               [8.5000,  -66.5000],
        'Lara':                  [10.0000, -69.5000],
        'Mérida':                [8.0000,  -71.0000],
        'Miranda':               [10.0000, -66.5000],
        'Monagas':               [9.0000,  -63.0000],
        'Nueva Esparta':         [11.0000, -64.0000],
        'Portuguesa':            [9.0000,  -69.5000],
        'Sucre':                 [10.5000, -63.5000],
        'Táchira':               [7.5000,  -72.0000],
        'Trujillo':              [9.5000,  -70.5000],
        'Vargas':                [10.5000, -66.9000],
        'Yaracuy':               [10.0000, -69.0000],
        'Zulia':                 [10.0000, -72.0000],
        'La Guaira':             [10.5000, -66.9000],
        'Dependencias Federales': [11.5000, -66.5000]
    };

    // Campos que se muestran en el modal
    const MODAL_FIELDS = [
        { key: 'nombre_solicitante',       label: 'Nombre' },
        { key: 'apellido_solicitante',      label: 'Apellido' },
        { key: 'descripcion_caso',          label: 'Descripción' },
        { key: 'nombre_tipo_atencion_detalle', label: 'Detalle de ayuda' },
        { key: 'nombre_tipo_atencion',      label: 'Tipo de atención' },
        { key: 'correo_solicitante',        label: 'Correo' },
        { key: 'telefono_solicitante',      label: 'Teléfono' },
        { key: 'nombre_estado',             label: 'Estado' },
        { key: 'nombre_municipio',          label: 'Municipio' },
        { key: 'nombre_parroquia',          label: 'Parroquia' }
    ];

    // ── Estado global ─────────────────────────────────────────────
    let map;
    const typeGroups    = {};
    const visibility    = {};
    const assignedColors = {};

    // ── Helpers ───────────────────────────────────────────────────
    const $  = (sel, ctx) => (ctx || document).querySelector(sel);
    const $$ = (sel, ctx) => Array.from((ctx || document).querySelectorAll(sel));

    function esc(str) {
        return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function parseNum(v) {
        if (v == null) return NaN;
        return parseFloat(String(v).trim().replace(/,/g, '.'));
    }

    // ── Inicializar mapa ─────────────────────────────────────────
    function initMap() {
        map = L.map('map').setView(CONFIG.center, CONFIG.zoom);
        L.tileLayer(CONFIG.tileLayer, {
            maxZoom:     CONFIG.maxZoom,
            attribution: CONFIG.attribution,
            crossOrigin: true
        }).addTo(map);
    }

    // ── Obtener datos del API ────────────────────────────────────
    async function fetchData() {
        const url = window.location.origin + '/Listar_Casos_Ayuda';
        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            return Array.isArray(data) ? data : [];
        } catch (err) {
            console.error('[Mapa] Error al obtener datos:', err);
            return [];
        }
    }

    // ── Convertir casos a features (con fallback a centroide) ────
    function buildFeatures(items) {
        const features = [];

        for (const item of items) {
            const estado = item.nombre_estado || '';

            // Coordenadas reales si existen; si no, centroide del estado
            let lat = parseNum(item.latitud_caso);
            let lng = parseNum(item.longitud_caso);

            if (isNaN(lat) || isNaN(lng)) {
                const centroid = STATE_CENTROIDS[estado];
                if (centroid) {
                    lat = centroid[0];
                    lng = centroid[1];
                } else {
                    continue; // sin coordenadas ni centroide conocido
                }
            }

            const props = {};
            for (const f of MODAL_FIELDS) {
                props[f.key] = item[f.key] ?? null;
            }
            // Campo display para colorear: detalle si existe, si no el tipo principal
            props._tipo_display = item.nombre_tipo_atencion_detalle || item.nombre_tipo_atencion || 'Sin clasificar';
            props.rutas_documentos_caso = item.rutas_documentos_caso ?? [];
            props.puntos_cuenta          = item.puntos_cuenta ?? {};
            // Guardar el item completo por si se necesita
            props._raw = item;

            features.push({
                type:       'Feature',
                properties: props,
                geometry:   { type: 'Point', coordinates: [lng, lat] }
            });
        }

        return features;
    }

    // ── Renderizar un marcador por caso ───────────────────────────
    function renderMarkers(features) {
        Object.values(typeGroups).forEach(g => map.removeLayer(g));
        for (const key of Object.keys(typeGroups)) delete typeGroups[key];
        for (const key of Object.keys(visibility)) delete visibility[key];

        for (const feat of features) {
            const [lng, lat] = feat.geometry.coordinates;
            const tipo       = feat.properties._tipo_display || 'Sin clasificar';
            const color      = getColor(tipo);

            const marker = L.circleMarker([lat, lng], {
                radius:      CONFIG.markerRadius,
                fillColor:   color,
                color:       '#fff',
                weight:      1,
                fillOpacity: 0.9
            });

            marker.on('click', () => openModal(feat.properties, [lat, lng]));

            if (!typeGroups[tipo]) {
                typeGroups[tipo] = L.layerGroup();
                visibility[tipo] = true;
            }
            typeGroups[tipo].addLayer(marker);
        }

        for (const group of Object.values(typeGroups)) {
            group.addTo(map);
        }

        const allLayers = Object.values(typeGroups).flatMap(g => g.getLayers());
        if (allLayers.length) {
            const bounds = L.featureGroup(allLayers).getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds, { maxZoom: 12, padding: [40, 40] });
            }
        }

        renderLegend();
    }

    // ── Asignar color por tipo de atención ────────────────────────
    function getColor(tipo) {
        const val = tipo || 'Sin clasificar';
        if (!assignedColors[val]) {
            const idx = Object.keys(assignedColors).length;
            assignedColors[val] = CONFIG.palette[idx % CONFIG.palette.length];
        }
        return assignedColors[val];
    }

    // ── Leyenda ───────────────────────────────────────────────────
    function renderLegend() {
        const old = document.getElementById('mapLegend');
        if (old) old.remove();

        const types = Object.keys(typeGroups);
        if (types.length === 0) return;

        const legend = document.createElement('div');
        legend.id = 'mapLegend';
        legend.className = 'map-legend';
        legend.innerHTML =
            '<div class="legend-title">Tipos de Atención</div>' +
            types.map(t =>
                '<div class="legend-item" data-type="' + esc(t) + '">' +
                '<span class="legend-color" style="background:' + getColor(t) + '"></span>' +
                '<span class="legend-label" data-type="' + esc(t) + '">' + esc(t) + '</span>' +
                '</div>'
            ).join('');

        document.getElementById('map').appendChild(legend);

        $$('.legend-label', legend).forEach(label => {
            label.addEventListener('click', function () {
                const type = this.getAttribute('data-type');
                visibility[type] = !visibility[type];
                updateLayerVisibility();
                updateLegendStyle(type);
            });
        });

        types.forEach(updateLegendStyle);
    }

    function updateLayerVisibility() {
        for (const [type, group] of Object.entries(typeGroups)) {
            if (visibility[type]) {
                if (!map.hasLayer(group)) group.addTo(map);
            } else {
                if (map.hasLayer(group)) map.removeLayer(group);
            }
        }
    }

    function updateLegendStyle(type) {
        const item = $('.legend-item[data-type="' + type + '"]');
        if (!item) return;
        item.style.opacity        = visibility[type] ? '1' : '0.45';
        item.style.textDecoration = visibility[type] ? 'none' : 'line-through';
    }

    // ── Modal de caso individual ──────────────────────────────────
    function openModal(props, coords) {
        const overlay = $('#modalOverlay');
        const body    = $('#modalBody');
        if (!overlay || !body) return;

        let html = '<div class="modal-fields">';

        for (const field of MODAL_FIELDS) {
            const val = props[field.key];
            if (val != null && val !== '') {
                html += '<div class="modal-field--small">' +
                    '<strong>' + esc(field.label) + ':</strong> ' + esc(val) +
                    '</div>';
            }
        }

        const docs = props.rutas_documentos_caso;
        if (Array.isArray(docs) && docs.length > 0) {
            html += renderSection('Archivos Adjuntos', renderDocGrid(docs, 'documentos_casos'));
        }

        const pc = props.puntos_cuenta;
        if (pc && typeof pc === 'object' && Object.keys(pc).length > 0) {
            html += renderSection('Punto de Cuenta', renderPuntosCuenta(pc));
        }

        html += '</div>';

        if (coords) {
            html += '<div class="modal-coords">Coordenadas: ' +
                Number(coords[0]).toFixed(6) + ', ' + Number(coords[1]).toFixed(6) +
                '</div>';
        }

        body.innerHTML = html;

        $$('.section-toggle', body).forEach(btn => {
            btn.addEventListener('click', function () {
                const target = document.getElementById(this.getAttribute('data-target'));
                if (!target) return;
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', String(!expanded));
                target.classList.toggle('section-collapsed', expanded);
                const icon = this.querySelector('.section-icon');
                if (icon) icon.textContent = expanded ? '▸' : '▾';
            });
        });

        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
    }

    function renderSection(title, bodyHtml) {
        const id = 'sec_' + Math.random().toString(36).slice(2, 8);
        return '<div class="modal-section">' +
            '<div class="section-header">' +
            '<button type="button" class="section-toggle" data-target="' + id + '" aria-expanded="true">' +
            esc(title) + ' <span class="section-icon">▾</span></button>' +
            '</div>' +
            '<div id="' + id + '" class="section-body">' + bodyHtml + '</div>' +
            '</div>';
    }

    function renderDocGrid(items, folder) {
        if (!items || items.length === 0) return '<div class="attachments-empty">Sin documentos</div>';
        const base = window.location.origin + '/';
        return '<div class="attachments-grid">' + items.map(item => {
            const name = typeof item === 'string' ? item : (item.ruta || item.nombre || 'Documento');
            const url  = typeof item === 'string'
                ? base + folder + '/' + item.replace(/^\//, '')
                : (item.ruta ? base + folder + '/' + item.ruta.replace(/^\//, '') : '#');
            const isImg = /\.(jpe?g|png|gif|webp|svg)(\?|$)/i.test(name);
            return '<div class="attachment-card">' +
                '<div class="attachment-thumb">' +
                (isImg
                    ? '<a href="' + url + '" target="_blank" rel="noopener"><img src="' + url + '" alt="' + esc(name) + '" loading="lazy"></a>'
                    : '<a class="attachment-link" href="' + url + '" target="_blank" rel="noopener"><div class="file-icon">' + getExt(name) + '</div></a>'
                ) +
                '</div>' +
                '<div class="attachment-info">' +
                '<a class="attachment-label" href="' + url + '" target="_blank" rel="noopener">' + esc(name) + '</a>' +
                '</div>' +
                '</div>';
        }).join('') + '</div>';
    }

    function renderPuntosCuenta(pc) {
        const entries = Object.values(pc);
        if (!entries.length) return '<div class="attachments-empty">Sin puntos de cuenta</div>';
        let html = '<div class="elements-grid">';
        entries.forEach((item, i) => {
            html += '<div class="element-card">' +
                '<div class="element-card-header">#' + (i + 1) + '</div>' +
                '<div class="element-card-body">' +
                '<div class="element-row"><span class="element-label">Nombre:</span> <span class="element-value">' + esc(item.nombre || '') + '</span></div>' +
                '<div class="element-row"><span class="element-label">Apellido:</span> <span class="element-value">' + esc(item.apellido || '') + '</span></div>' +
                '<div class="element-row"><span class="element-label">Monto Aprobado:</span> <span class="element-value">' + esc(item.monto_aprobado || '') + '</span></div>' +
                '<div class="element-row"><span class="element-label">Causa/Beneficio:</span> <span class="element-value">' + esc(item.causa_beneficio || '') + '</span></div>';

            const pcDocs = item.documentos_pc;
            if (pcDocs && typeof pcDocs === 'object' && Object.keys(pcDocs).length > 0) {
                html += '<div class="element-row"><strong>Documentos:</strong>' +
                    renderDocGrid(Object.values(pcDocs), 'documentos_punto_cuenta') + '</div>';
            }

            html += '</div></div>';
        });
        html += '</div>';
        return html;
    }

    function getExt(name) {
        const m = String(name).split('?')[0].match(/\.([0-9a-zA-Z]+)$/);
        return (m ? m[1].toUpperCase() : 'FILE');
    }

    function closeModal() {
        const overlay = $('#modalOverlay');
        if (!overlay) return;
        overlay.classList.remove('show');
        overlay.setAttribute('aria-hidden', 'true');
    }

    // ── Eventos del modal ────────────────────────────────────────
    function bindModalEvents() {
        const overlay  = $('#modalOverlay');
        const closeBtn = $('#modalClose');
        if (!overlay) return;

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    }

    // ── Punto de entrada ─────────────────────────────────────────
    async function init() {
        initMap();
        bindModalEvents();
        const items    = await fetchData();
        console.log('[Mapa] Casos recibidos:', items.length);
        const features = buildFeatures(items);
        console.log('[Mapa] Features generadas:', features.length);
        renderMarkers(features);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();