
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/mapa.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link href="/static/css/styles.css" rel="stylesheet">
  <style>
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
  </style>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Estadisticas </h3>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">  

                                <div id="modalOverlay" class="modal-overlay" aria-hidden="true">
                                    <div class="modals" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
                                    <div class="modal-header">
                                        <h3 id="modalTitle">Información</h3>
                                        <button id="modalClose" class="modal-close" aria-label="Cerrar">✕</button>
                                    </div>
                                    <div id="modalBody" class="modal-body">Cargando...</div>
                                    </div>
                                </div>
                                
                                <div id="map">
                                    
                                </div>
                                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                                crossorigin=""></script>
                                <script src="/static/js/ruta.js"></script>
                                <script src="/static/js/map-core.js"></script>
                                <script src="/static/js/modal-config.js"></script>
                                <script src="/static/js/map-modal.js"></script>
                                <script src="/static/js/map-api.js"></script>
                                <script src="/static/js/map-data.js"></script>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
  </div>
</div>