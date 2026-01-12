// map-core.js
(function (global) {
  const initialCenter = [10.4806, -66.9036];
  const initialZoom = 6;
  const map = L.map('map').setView(initialCenter, initialZoom);
  L.tileLayer('https://tile.openstreetmap.de/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
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