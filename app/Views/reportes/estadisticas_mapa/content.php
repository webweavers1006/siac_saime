
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/mapa.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.css">
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
                                
                                <div id="map"></div>

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

<script src="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.js"></script>