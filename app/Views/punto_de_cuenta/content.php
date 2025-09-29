<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content  fluid-->
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
      <!-- /.content-wrapper -->
      <!-- Modal -->
<!-- Este modal usa 'role="dialog"' y 'data-dismiss' para mantener la compatibilidad con tu JS de Bootstrap 4/3 -->
<div class="modal fade" id="add-punto-cuenta" tabindex="-1" role="dialog" aria-labelledby="addPuntoCuentaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content shadow-lg rounded-3">
      
      <!-- Encabezado del Modal con estilo B5 (bg-light, p-3) -->
      <div class="modal-header bg-light border-bottom p-3">
        <h5 class="modal-title fw-bold" id="addPuntoCuentaTitle">Agregar Punto de Cuenta</h5>
        <!-- Se mantiene la estructura 'close' y 'data-dismiss' de Bootstrap 4/3 -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="form-add-punto-cuenta" method="POST" role="form"> 
        
        <!-- Cuerpo del Modal: Compacto (p-4) -->
        <div class="modal-body p-4">
          
          <!-- Sección 1: Datos principales -->
          <h6 class="text-secondary fw-bold text-uppercase mb-3">Datos del Punto de Cuenta</h6>
          <!-- g-3 hace la fila más compacta -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="numero_punto_cuenta" class="form-label fw-semibold">Número de Punto de Cuenta</label>
                <!-- form-control-sm para reducir altura -->
                <input type="text" name="numero_punto_cuenta" id="numero_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="fecha_punto_cuenta" class="form-label fw-semibold">Fecha de Punto de Cuenta</label>
                <!-- form-control-sm para reducir altura -->
                <input type="date" name="fecha_punto_cuenta" id="fecha_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required> 
              </div>
            </div>
          </div>
          
          <!-- Separador de Sección: Beneficiario (Compacto y estético) -->
          <div class="d-flex align-items-center mb-3">
              <div class="flex-grow-1"><hr class="m-0"></div>
              <h6 class="text-secondary fw-bold text-uppercase text-center mx-3 mb-0">Aprobador</h6>
              <div class="flex-grow-1"><hr class="m-0"></div>
          </div>
          
          <!-- Sección 2: Datos del Beneficiario -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="nombre_beneficiario" class="form-label">Nombre</label>
                <input type="text" name="nombre_beneficiario" id="nombre_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="apellido_beneficiario" class="form-label">Apellido</label>
                <input type="text" name="apellido_beneficiario" id="apellido_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="monto_aprobado" class="form-label">Monto Aprobado</label>
                <!-- Usamos type="number" para mejor UX y validación -->
                <input type="text" name="monto_aprobado" id="monto_aprobado" class="form-control form-control-sm" step="0.01" min="0" autocomplete="off" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-0">
                <label for="causa_beneficiario" class="form-label">Causa del Beneficiario</label>
                <input type="text" name="causa_beneficiario" id="causa_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>
          
          <!-- Separador de Sección: Documentación -->
          <div class="d-flex align-items-center mb-3">
              <div class="flex-grow-1"><hr class="m-0"></div>
              <h6 class="text-secondary fw-bold text-uppercase text-center mx-3 mb-0">Documentación</h6>
              <div class="flex-grow-1"><hr class="m-0"></div>
          </div>
          
          <!-- Sección 3: Subida y Selección de Archivos (Integrada y Compacta) -->
          <div class="row align-items-center g-3"> 
              
              <!-- Columna de Subida de Archivos -->
              <div class="col-md-6">
                  <form id="miFormulario" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center">
                      <label class="btn btn-outline-secondary btn-sm mb-0 me-2 shadow-sm">
                          <input type="file" id="archivo" name="archivo" style="display: none;">
                          <i class="fas fa-paperclip me-1"></i> Seleccionar archivo
                      </label>
                      &nbsp;&nbsp;
                      <input 
                          type="button" 
                          id="subir_archivos" 
                          class="btn btn-sm btn-primary mb-0 shadow-sm" 
                          value="Subir archivo"
                      >
                      <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">
                  </form>
              </div>
              
              <!-- Columna de Selector de Documentos -->
              <div class="col-md-6">
                  <div class="d-flex align-items-center">
                      <label for="docu-casos" class="col-form-label fw-bold me-3 mb-0 text-uppercase text-nowrap">
                          Documentos Caso
                      </label>&nbsp;&nbsp;
                      <!-- form-select-sm para reducir altura -->
                      <select class="form-select form-select-sm w-auto shadow-sm" id="docu-casos" name="docu-casos">
                          <option value="0" selected disabled>Seleccione</option>
                      </select>
                  </div>
              </div>
          </div>
          <!-- Fin Sección 3 -->

        </div>
        
        <!-- Pie de Modal (Footer) más compacto -->
        <div class="modal-footer d-flex justify-content-end border-top bg-light p-3">
          <!-- 'type="reset"' funciona con HTML5 y cualquier versión de Bootstrap -->
          <button class="btn btn-sm btn-secondary me-2" type="reset">Limpiar</button>
          
          <!-- Se mantiene 'data-dismiss="modal"' para asegurar el cierre -->
          <button type="button" class="btn btn-sm btn-danger me-2" data-dismiss="modal">Cerrar</button>

          <button class="btn btn-sm btn-success" type="submit">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

      <!-- /.modal -->
      <!-- Modal para editar punto de cuenta -->

      <div class="modal fade" id="editar">
        <div class="modal-dialog modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar punto de cuenta </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
             <input type="hidden" name="id_punto_cuenta_editar" id="id_punto_cuenta_editar" class="form-control">
            <form id="form-edit-punto-cuenta" method="POST" role="form"> 
        
        <div class="modal-body">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="numero_punto_cuenta">Número de Punto de Cuenta</label>
                <input type="text" name="numero_punto_cuenta" id="edit_numero_punto_cuenta" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha_punto_cuenta">Fecha de Punto de Cuenta</label>
                <input type="date" name="fecha_punto_cuenta" id="edit_fecha_punto_cuenta" class="form-control" autocomplete="off" required> 
              </div>
            </div>
          </div>
          
          <hr>
          <h6>Datos del Aprobador</h6>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre_beneficiario">Nombre</label>
                <input type="text" name="nombre_beneficiario" id="edit_nombre_beneficiario" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="apellido_beneficiario">Apellido</label>
                <input type="text" name="apellido_beneficiario" id="edit_apellido_beneficiario" class="form-control" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="monto_aprobado">Monto Aprobado</label>
                <input type="text" name="monto_aprobado" id="edit_monto_aprobado" class="form-control" step="0.01" min="0" autocomplete="off" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="causa_beneficiario">Causa del Beneficiario</label>
                <input type="text" name="causa_beneficiario" id="edit_causa_beneficiario" class="form-control" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input borrado" id="borrado" name="borrado" value='false'>
            <label class="form-check-label" for="borrado">Activo</label>
        </div>

        </div>
        
        <div class="modal-footer">
          <button class="btn btn-sm btn-secondary" type="reset">Limpiar</button>
          
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>

          <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
        </div>
      </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



     <style>
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
</style>
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
                    <div class="card-body p-3">
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
        <h6 class="text-success m-0 font-weight-bold small">
            <i class="fas fa-check-circle mr-2"></i> Caso Verificado
        </h6>
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

<style>
/* Estilo adicional para un borde superior más grueso y colorido,
   dando un efecto "pill" o "ribbon" sutil de éxito */
#card-detalle-caso {
    border-top: 3px solid #28a745 !important; /* success color */
}
</style>

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
      <!-- ***** FUNCION PARA SOLO NUMEROS***-** -->
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
      <!-- ***** FUNCION PARA SOLO LETRAS***-** -->
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>



