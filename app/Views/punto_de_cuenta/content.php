<?php
$session = session();
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  /* Estilo base para DataTables */
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }

  /*
  ==========================================
  CORRECCIONES PARA SCROLL Y POSICIONAMIENTO DE MODALES 🛠️
  ==========================================
  */

  /* 1. Evita que la página salte al abrir el modal (el principal culpable del mal posicionamiento). 
     Fuerza el scroll del body y elimina el padding-right que añade Bootstrap al ocultar el scrollbar. */
  .modal-open {
    overflow: auto !important;
    padding-right: 0px !important;
  }

  /* 2. Asegura que el modal siempre use su propio scroll si su contenido es largo,
     y que se posicione correctamente. */
  .modal {
    overflow-y: auto !important;
    padding: 0 !important;
    /* Usar 'fade' en el div del modal ayuda a la transición y el cálculo del tamaño */
  }
  
  /* Estilo para hacer que el texto general del modal-body sea ligeramente más grande */
  .modal-body-lg-text {
      font-size: 0.95rem; /* Talla ligeramente más grande que el estándar */
  }

  /* Ajuste para que la tabla y el resumen de casos también tengan un tamaño legible */
  #lista-casos-asociados, #resumen-financiero {
      font-size: 0.9rem;
  }

  /* Asegurar que los detalles del punto de cuenta sean claros */
  #modal-casos .card-body dl {
      font-size: 0.95rem; /* Aumenta el texto dentro de la lista de detalles */
  }

  /* ... Mantener el resto de tu CSS para DataTables ... */
  #lista-casos-asociados table {
      width: 100% !important;
  }
  #lista-casos-asociados .dataTables_wrapper {
      padding: 10px;
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
  }
  
  /* Estilo adicional para un borde superior más grueso y colorido en card-detalle-caso */
  #card-detalle-caso {
      border-top: 3px solid #28a745 !important; /* success color */
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><div class="col-sm-6">
        </div></div></div></div>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Punto de Cuenta 
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-punto-cuenta">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_punto_cuenta" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 10%;">Numero</td>
                              <td class="text-center" style="width: 2%;">Fecha P Cuenta</td>
                              <td class="text-center" style="width: 15%;">Nombre</td>
                              <td class="text-center" style="width: 6%;">Monto Aprobado</td>
                              <td class="text-center" style="width: 2%;">Causa</td>
                              <td class="text-center" style="width: 3%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_punto_cuenta">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="add-punto-cuenta" tabindex="-1" role="dialog" aria-labelledby="addPuntoCuentaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content shadow-lg rounded-3">
      
      <div class="modal-header bg-light border-bottom p-3">
        <h5 class="modal-title fw-bold" id="addPuntoCuentaTitle">Agregar Punto de Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="form-add-punto-cuenta" method="POST" role="form"> 
        
        <div class="modal-body p-4">
          
          <h6 class="text-secondary fw-bold text-uppercase mb-3">Datos del Punto de Cuenta</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="numero_punto_cuenta" class="form-label fw-semibold">Número de Punto de Cuenta</label>
                <input type="text" onkeyup="mayus(this);" name="numero_punto_cuenta" id="numero_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="fecha_punto_cuenta" class="form-label fw-semibold">Fecha de Punto de Cuenta</label>
                <input type="date" name="fecha_punto_cuenta" id="fecha_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required> 
              </div>
            </div>
          </div>
          
          <div class="d-flex align-items-center mb-3">
              <div class="flex-grow-1"><hr class="m-0"></div>
              <h6 class="text-secondary fw-bold text-uppercase text-center mx-3 mb-0">Aprobador</h6>
              <div class="flex-grow-1"><hr class="m-0"></div>
          </div>
          
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="nombre_beneficiario" class="form-label">Nombre</label>
                <input type="text" onkeyup="mayus(this);" name="nombre_beneficiario" id="nombre_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="apellido_beneficiario" class="form-label">Apellido</label>
                <input type="text" onkeyup="mayus(this);" name="apellido_beneficiario" id="apellido_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="monto_aprobado" class="form-label">Monto Aprobado</label>
                <input type="text" onkeypress="return valideKey(event);" name="monto_aprobado" id="monto_aprobado" class="form-control form-control-sm" step="0.01" min="0" autocomplete="off" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-0">
                <label for="causa_beneficiario" class="form-label">Causa del Beneficiario</label>
                <input type="text" onkeyup="mayus(this);" name="causa_beneficiario" id="causa_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>
          
      
          </div>
        
        <div class="modal-footer d-flex justify-content-end border-top bg-light p-3">
          <button class="btn btn-sm btn-secondary me-2" type="reset">Limpiar</button>
          
          <button type="button" class="btn btn-sm btn-danger me-2" data-dismiss="modal">Cerrar</button>

          <button class="btn btn-sm btn-success" type="submit">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

      <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="editarPuntoCuentaTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarPuntoCuentaTitulo">
                    <i class="fas fa-edit me-2"></i> Editar Punto de Cuenta
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-edit-punto-cuenta" method="POST" role="form">
                <input type="hidden" name="id_punto_cuenta_editar" id="id_punto_cuenta_editar" class="form-control">

                <div class="modal-body">

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-file-invoice me-2"></i> Información Principal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_numero_punto_cuenta" class="form-label">Número de Punto de Cuenta</label>
                                        <input type="text" onkeyup="mayus(this);" name="numero_punto_cuenta" id="edit_numero_punto_cuenta" class="form-control" autocomplete="off" required placeholder="Escribe el número aquí">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_fecha_punto_cuenta" class="form-label">Fecha de Punto de Cuenta</label>
                                        <input type="date" name="fecha_punto_cuenta" id="edit_fecha_punto_cuenta" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-user-tie me-2"></i> Datos del Aprobador y Monto
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_nombre_beneficiario" class="form-label">Nombre del Aprobador</label>
                                        <input type="text" onkeyup="mayus(this);" name="nombre_beneficiario" id="edit_nombre_beneficiario" class="form-control" autocomplete="off" required placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_apellido_beneficiario" class="form-label">Apellido del Aprobador</label>
                                        <input type="text"  onkeyup="mayus(this);" name="apellido_beneficiario" id="edit_apellido_beneficiario" class="form-control" autocomplete="off" required placeholder="Apellido">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_monto_aprobado" class="form-label">Monto Aprobado</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="text" onkeypress="return valideKey(event);" name="monto_aprobado" id="edit_monto_aprobado" class="form-control" step="0.01" min="0" autocomplete="off" required placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_causa_beneficiario" class="form-label">Causa/Motivo</label>
                                        <input type="text" onkeyup="mayus(this);" name="causa_beneficiario" id="edit_causa_beneficiario" class="form-control" autocomplete="off" required placeholder="Breve descripción de la causa">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-paperclip me-2"></i> Gestión de Documentos
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Subir Nuevo Documento</h6>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="archivo" name="archivo" aria-describedby="btn_subir_archivos">
                                <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">
                                <button type="button" id="subir_archivos" class="btn btn-info">
                                    <i class="fas fa-cloud-upload-alt me-1"></i> Subir Archivo
                                </button>
                            </div>
                            
                            <h6 class="card-subtitle mb-2 text-muted">Documentos del Punto de Cuenta</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-12">
                                    <select class="form-control" id="docu-punto" name="docu-punto">
                                        <option value="0" selected disabled>Seleccione un documento adjunto...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="borrado" name="borrado" value='false'>
                        <label class="form-check-label fw-bold" for="borrado">Punto de Cuenta Activo</label>
                        <small class="text-muted d-block">Desactivar para marcar como inactivo o borrado.</small>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" type="reset">
                        <i class="fas fa-eraser me-1"></i> Limpiar Campos
                    </button>
                    <div>
                        <button type="button" class="btn btn-danger me-2" data-dismiss="modal">
                            <i class="fas fa-times-circle me-1"></i> Cerrar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-save me-1"></i> Actualizar Punto
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>


     <div class="modal fade" id="modal-casos" tabindex="-1" role="dialog" aria-labelledby="modalCasosTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header bg-primary text-white p-3 border-bottom-0 rounded-top-lg">
                <h5 class="modal-title font-weight-bold" id="modalCasosTitle">
                    <i class="fas fa-link mr-2"></i> Gestión de Casos Asociados
                </h5>
                <button type="button" class="close text-white opacity-100" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true" class="h3 font-weight-light">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 modal-body-lg-text"> 
                
                <div class="card shadow-sm mb-4 border-left-primary">
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <h6 class="card-title text-primary m-0 font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i> Detalles del Punto de Cuenta
                        </h6>
                         <span id="detalle-numero-cuenta" class="badge badge-info ml-2 font-weight-bold p-2"></span>
                    </div>
                    <div class="card-body p-3 informacion">
                        <dl class="row mb-0"> 
                            <dt class="col-sm-3 text-secondary">Nombre Aprobador:</dt>
                            <dd class="col-sm-9 font-weight-bold text-dark"><span id="detalle-nombre-completo"></span></dd>
                            
                            <dt class="col-sm-3 text-secondary">Causa:</dt>
                            <dd class="col-sm-9 text-muted text-wrap"><span id="detalle-causa"></span></dd>
                            
                            <dt class="col-sm-3 text-secondary">Fecha:</dt>
                            <dd class="col-sm-3"><span id="detalle-fecha" class="badge badge-light border text-secondary p-1 font-weight-normal"></span></dd>

                            <dt class="col-sm-3 text-secondary">Monto Aprobado:</dt>
                            <dd class="col-sm-3 text-success font-weight-bolder">
                                <i class="fas fa-money-bill-wave mr-1"></i> <span id="detalle-monto"></span>
                            </dd>
                        </dl>
                        <h6 class="card-subtitle mb-2 text-muted">Documentos del Punto de Cuenta</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-12">
                                    <select class="form-control" id="docu-punto-deta" name="docu-punto">
                                        <option value="0" selected disabled>Seleccione un documento adjunto...</option>
                                    </select>
                                </div>
                            </div>
                        <input type="hidden" id="caso-id-punto-cuenta">
                    </div>
                </div>

                <h6 class="mt-4 mb-3 text-primary border-bottom pb-2 font-weight-bold">
                    <i class="fas fa-list-alt mr-2"></i> Casos Actualmente Asociados
                </h6>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="lista-casos-asociados">
                            <p class="text-muted m-0 p-4 border rounded"><i class="fas fa-sync fa-spin mr-2 text-primary"></i> Cargando casos...</p> 
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="resumen-financiero" class="mt-3">
                            </div>
                    </div>
                </div>
                
                <hr class="my-4"> 

                <h6 class="mb-3 text-success font-weight-bold">
                    <i class="fas fa-link mr-2"></i> Asociar Nuevo Caso
                </h6>
                <form id="form-asociar-caso">
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-5">
                            <label for="input-nuevo-caso">Número/Referencia del Caso</label>
                            <div class="input-group shadow-sm">
                                <input type="text" id="inputnuevocaso" onkeypress="return valideKey(event);" name="referencia_caso" class="form-control" placeholder="Ej: 2023-012345" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="btnverificarcaso">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-lg border-0 border-top-success mt-3" id="card-detalle-caso" style="display: none;">
    
                        <div class="card-header bg-white p-2">
                            <h3 class="text-success m-0 font-weight-bold small">
                                <i class="fas fa-check-circle mr-2"></i> Informacion del Caso
                            </h3>
                        </div>
                        
                        <div class="card-body p-3 pt-2">
                            <dl class="row mb-0 small">
                                
                                <dt class="col-sm-3 text-muted text-truncate">Nombre:</dt>
                                <dd class="col-sm-9 font-weight-bolder text-dark mb-1">
                                    <input type="text" id="campo-nombre" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
                                </dd>
                                
                                <dt class="col-sm-3 text-muted">Cédula:</dt>
                                <dd class="col-sm-3 font-weight-normal text-muted mb-1">
                                    <input type="text" id="campo-cedula" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
                                </dd>
                                
                                <dt class="col-sm-3 text-muted">Teléfono:</dt>
                                <dd class="col-sm-3 font-weight-normal text-muted mb-1">
                                    <input type="text" id="campo-telefono" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
                                </dd>

                                <dt class="col-sm-3 text-muted">Tipo de Atención:</dt>
                                <dd class="col-sm-9 font-weight-semibold text-primary mb-1">
                                    <input type="text" id="campo-tipo-atencion" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
                                </dd>
                                
                            </dl>
                        </div>
                    </div>

                  <div id="mensaje-punto-cuenta" class="mt-2" style="display: none;"></div> 
                    <button type="submit" id="btn-asociar-caso" class="btn btn-success btn-block mt-3 py-2 shadow-sm" disabled>
                        <i class="fas fa-plus-circle mr-2"></i> Asociar Caso
                    </button>
                </form>
            </div>
            
            <div class="modal-footer d-flex justify-content-end p-3 bg-light border-top-0 rounded-bottom-lg"> 
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
      <script type="text/javascript">
        function valideKey(evt) {
          var code = (evt.which) ? evt.which : evt.keyCode;
          if (code == 8) { // backspace.
            return true;
          } else if (code >= 48 && code <= 57) { // is a number.
            return true;
          } else { // other keys.
            return false;
          }
        }
      </script>
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>