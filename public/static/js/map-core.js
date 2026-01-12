// map-core.js
(function (global) {
  const initialCenter = [10.4806, -66.9036];
  const initialZoom = 6;
  const map = L.map('map').setView(initialCenter, initialZoom);
  L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>',
    crossOrigin: true
  }).addTo(map);
  global.MapApp = global.MapApp || {};
  global.MapApp.map = map;
  global.MapApp.setStatus = function (msg) {
    var statusEl = document.getElementById('status');
    if (statusEl) statusEl.textContent = msg;
    console.log('[MAP STATUS]', msg);
  };
})(window);