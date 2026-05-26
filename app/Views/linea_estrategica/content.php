<?php $session = session(); ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">

<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
  
  /* Fuerza visualmente que todo lo que se escriba en los inputs de texto sea mayúscula */
  input[type="text"] {
    text-transform: uppercase;
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary">
                  <i class="fas fa-angle-double-right"></i> Línea estratégica
                  <button type="button" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-linea-estrategica">
                    Agregar
                  </button>
                </h3>
              </div>
            </div> <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <table class="display table-responsive" id="table_linea_estrategica" style="width:100%" >
                        <thead>
                          <tr>
                            <td class="text-center" style="width: 1%;">ID</td>
                            <td class="text-center" style="width: 70%;">Descripción</td>
                            <td class="text-center" style="width: 10%;">Estatus</td>
                            <td class="text-center" style="width: 19%;">Acciones</td>
                          </tr>
                        </thead>
                        <tbody id="listar_linea_estrategica"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div></div></div></div></div></div></div><div class="modal fade" id="add-linea-estrategica" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Línea estratégica</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="new-linea-estrategica" method="POST" role="form">
        <div class="modal-body">
          <div class="form-group">
            <label for="linea-estrategica-descripcion">Descripción</label>
            <input type="text" name="descripcion" id="linea-estrategica-descripcion" class="form-control" placeholder="Ej: INNOVACIÓN SOCIAL" oninput="this.value = this.value.toUpperCase()" autocomplete="off" required>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
          <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-linea-estrategica" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title font-weight-bold text-secondary">Editar Línea Estratégica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="edit-linea-estrategica-form" method="POST" role="form">
        <div class="modal-body p-4">
          <input type="hidden" id="id-linea-estrategica" name="id" value="">

          <div class="form-group">
            <label for="linea-estrategica-descripcion-edit" class="font-weight-bold text-muted">Descripción</label>
            <input type="text" name="descripcion" id="linea-estrategica-descripcion-edit" class="form-control" oninput="this.value = this.value.toUpperCase()" autocomplete="off" required>
          </div>

          <div class="form-group mt-3">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input borrado" id="borrado-edit" name="borrado" value="false">
              <label class="custom-control-label font-weight-bold text-muted" for="borrado-edit">Activo</label>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-hidden d-flex justify-content-end">
          <button class="btn btn-sm btn-light mr-auto" type="reset">Limpiar</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-sm btn-primary px-3" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>