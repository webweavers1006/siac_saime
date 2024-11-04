<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/audiencias.css">
<?php
$session = session();
$userdata = $session->get();

?>

<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }



  
</style>

<div class="content-wrapper">
  <main class="content">
    <div class="container-fluid ml-0 rounded-pill">
      <div class="row">
        <div class="col-lg-10"> <!-- Tarjeta principal -->
          <div class="card card_table">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary text-center">
                  <i class="fas fa-angle-double-right"></i>
                  Listado de Audiencias
                </h3>
                <?php
                if (isset($userdata['permisos']['permisos']) && in_array('requerimientos.create', $userdata['permisos']['permisos'])) {
                    // Habilitar el botón
                    $estado_boton = 'enabled';
                } else {
                    // Inhabilitar el botón
                    $estado_boton = 'disabled';
                }
                ?>

                <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-direcciones" <?php echo $estado_boton; ?>>
                    Agregar (+)
                </button>
              </div>
            </div>
            <div class="card-body">
            <div class="col-lg-12 col-sm-12 col-md-12 ">
                    
            <?php
              if (isset($userdata['permisos']['permisos']) && in_array('requerimientos.read', $userdata['permisos']['permisos'])) {
                  // Mostrar la tabla
                  ?>
                  <table class="display table-responsive" id="table_audiencia" style="width:100%" style="margin-top: 20px">
                      <thead>
                        <tr>
                          <td class="text-center ant-table-cell" style="width: 1%;" >Estatus</td>
                          <td class="text-center" style="width: 4%;">Numero de audiencia</td>
                          <td class="text-center" style="width: 5%;">Pais</td>
                          <td class="text-center" style="width: 8%;">Estatus del caso</td>
                          <td class="text-center" style="width: 3%;">Area</td>
                          <td class="text-center" style="width: 8%;">Usuario</td>
                          <td class="text-center" style="width: 5%;">Acciones</td>
                        </tr>
                      </thead>
                      <tbody id="listar_audencias">
                      </tbody>
                  </table>
                  <?php
              } else {
                  // Mostrar el mensaje de no permisos
                  ?>
                  <p>NO TIENE PERMISOS PARA VISUALIZAR LOS REQUERIMIENTOS</p>
                  <?php
              }
              ?>
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2"> 
          <!-- Tarjeta pequeña con interruptores y botón de exportar -->
          <div class="card interructores">
            <div class="card-body">
              <label class="form-check-label text-left" for="pdf"><b>Exportación</b></label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="pdf" />
                <label class="form-check-label" for="pdf">PDF</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="excel" />
                <label class="form-check-label" for="excel">Excel</label>
              </div>
              <button class="btn btn-primary btn-block exportar " id="exportar">Exportar</button>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
  <div class="col-4">
    <div class="box_estatus">
      <div class="card estatus">
        <div class="card-body">
          <div><span class="legend-items">
            <span class="ant-badge ant-badge-status ant-badge-not-a-wrapper css-2i2tap">
            <span class="legend-item leyend1">Nuevo</span>
          <div><span class="legend-items">
          <span class="legend-item leyend2">En proceso</span>
          <div><span class="legend-items">
          <span class="legend-item leyend3">Resuelto</span>
        </div>
      </div>
    </div>
  </div>
</div>



      
<!-- Modal para añadir una audiencia a un bufete -->
<div class="modal fade" id="asignar_bufete">
        <div class="modal-dialog  modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Usuarios Areas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
           
              <div class="modal-body">
              <input type="hidden" id="id_caso" autocomplete="off">
              <input type="hidden" id="id_usuario_bufete" autocomplete="off">
              
              <div class="form-group">
                  <label for="user-name">Bufete</label>
                  <select name="id_bufete" id="id_bufete">
                          <option value="0" selected>---Seleccione ---</option>
                  </select>
              </div>

            
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary r" id="guardar" type="button">Guardar</button>
                <button class="btn btn-sm  btn-primary "id="actualizar"  type="button" style="display: none;">Actualizar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
         
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



    </div> 
  </main>

<script>
const exportarButton = document.getElementById('exportar');
exportarButton.addEventListener('click', exportData);

function exportData() {
  const pdfCheckbox = document.getElementById('pdf');
  const excelCheckbox = document.getElementById('excel');
  const table = document.getElementById('table_audiencia');
  const datatable = $(table).DataTable(); // Accedemos a la instancia de DataTable existente

  if (pdfCheckbox.checked) {
    datatable.buttons('.buttons-pdf').trigger(); // Activamos el botón de exportación a PDF
  }

  if (excelCheckbox.checked) {
    datatable.buttons('.buttons-excel').trigger(); // Activamos el botón de exportación a Excel
  }
}
</script> 
</div>