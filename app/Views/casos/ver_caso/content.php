 <?php
$session = session();
?>
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }

  /* Small separation between table and general information */
  #tl {
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px dashed #cbd5e1;
  }
  


  /* Encabezados de tablas: color blanco y estilo más agradable */
  table.dataTable thead tr th,
  table.dataTable thead tr td,
  table thead tr th,
  table thead tr td {
    color: #ffffff !important;
 
    font-weight: 600;
    letter-spacing: 0.3px;
    border: none;
  }
  
</style>

<link rel="stylesheet" href="<?= base_url(); ?>/css_paginas/ver_caso.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <input type="hidden" id="rol_usuario" value="<?= $session->get('userrol'); ?>">
  <input type="hidden" id="id_usuario" value="<?= $session->get('iduser'); ?>">
  <input type="hidden" id="acceso_taller" value="<?= $acc_participantes; ?>">
  <input type="hidden" id="fecha_taller" value="<?php echo $fecha_caso?>">
  <input type="hidden" id="estado_taller" value="<?php echo $estado?>">
  <input type="hidden" id="municipio_taller" value="<?php echo $municipio?>">
  <input type="hidden" id="parroquia_taller" value="<?php echo $parroquia?>">
  
  <input type="hidden" id="id_caso" value="<?= $idcaso; ?>">

  <!-- Main content -->
  <section class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="d-flex flex-wrap align-items-center">
          <h3 class="text-secondary mb-0 mr-3">
            <i class="fas fa-angle-double-right"></i> Seguimientos del Caso Nº 
            <span class="text-dark"><?= $idcaso; ?></span>
          </h3>
          <a data-toggle="modal" data-target="#add-seguimiento" class="btn btn-sm btn-primary">Añadir Seguimiento</a>
          <?php if ($acc_participantes == 't') : ?>
            <a data-toggle="modal" data-target="#add-participantes" class="btn btn-sm btn-success ml-2" id="btn-add-participantes">Añadir Participantes</a>
          <?php endif; ?>
          <?php if (in_array($session->get('userrol'), [1, 2,3, 5, 10])) : ?>
            <a data-toggle="modal" data-target="#cambiar-estatus" class="btn btn-sm btn-dark ml-2">Cambiar estatus</a>
          <?php endif; ?>
        </div>
        
        <?php if ($acc_participantes == 't') : ?>
          <br>
          <div class="row">
          <div class="col-lg-7 col-md-7 col-sm-7">
              <h3 class="text-secondary">
                  Nombre de la Actividad:
              </h3>
              <h4 class="text-dark mb-0"><?= htmlspecialchars($casodesc); ?></h4>
              <input type="hidden" id="descripcion_actividad" value="<?php echo htmlspecialchars($casodesc); ?>">
          </div>
              <div class="col-lg-1 col-md-1 col-sm-1">
                 
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 d-flex align-items-center">
                  <label for="informacion" class="mr-2"><h3>Información</h3></label>&nbsp;&nbsp;
                  <select class="form-control" id="informacion" name="tipo-atencioni-usu">
                      <option value="0" disabled>Seleccione</option>
                      <option value="1">Seguimientos</option>
                      <option value="2" selected>Participantes</option>
                  </select>
              </div>
          </div>
          

         
          

          <div class="card-body seguimientos d-none">
            <div class="row">
              <div class="col-lg-8 col-md-8 col-12 order-2 order-md-1" id="tl">
                <div class="card-body">
                <table class="display table-responsive" id="table_seguimientos" style="width: 100%; margin-top: 20px; ">
                    <thead>
                      <tr>
                        <td class="text-center" style="width: 1%;">Nº</td>
                        <td class="text-center" style="width: 1%;">F_Seguimiento</td>
                        <td class="text-center" style="width: 4%;">Estatus/llamada</td>
                        <td class="text-center" style="width: 4%;">Usuario Operador</td>
                        <td class="text-center" style="width: 7%;">Comentario</td>
                        <td class="text-center" style="width: 1%;">Acciones</td>
                      </tr>
                    </thead>
                    <tbody id="listar_seguimientos">
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="col-lg-1 col-md-1 col-12 order-1 order-md-2"> </div>
             <!--Detalles del caso-->
            <div class="col-lg-3 col-md-3 col-12 order-1 order-md-2 info-general-left">
                <div class="card card-info shadow-sm h-100" style="border: none; border-radius: 12px;">
                  <div class="card-header bg-gradient-info" style="border-radius: 12px 12px 0 0; border: none;">
                    <h3 class="card-title text-white font-weight-bold">
                      <i class="fas fa-info-circle mr-2"></i>
                      Información General 
                    </h3>
                  </div>
                  <div class="card-body" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);">
                    <input type="hidden" id="id-caso" name="id-caso" value="<?= $idcaso ?>">
                    
                    <div class="info-section">
                      <!-- Fecha del caso -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-info-light">
                            <i class="far fa-calendar-alt text-info"></i>
                          </div>
                          <div>
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Fecha del caso</span>
                            <div class="font-weight-semibold text-dark info-value"><?= !empty($fecha_caso) ? $fecha_caso : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Nombre y Apellido -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-success-light">
                            <i class="fas fa-user text-success"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Nombre y Apellido</span>
                            <div class="font-weight-semibold text-dark info-value"><?= !empty($nombre) ? $nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Correo -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-warning-light">
                            <i class="fas fa-envelope text-warning"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Correo</span>
                            <div class="text-dark info-value" style="word-break: break-all;"><?= !empty($correo) ? $correo : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Ubicación -->
                      <div class="info-item-custom bg-light rounded-lg p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-start">
                          <div class="icon-wrapper bg-primary">
                            <i class="fas fa-map-marker-alt text-white"></i>
                          </div>
                          <div>
                            <span class="text-primary small text-uppercase font-weight-bold info-label">Ubicación</span>
                            <div class="text-dark font-weight-medium info-value">
                              <?= (!empty($estado) || !empty($municipio) || !empty($parroquia)) ? "$estado, $municipio, $parroquia" : 'No Aplica' ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Tipo de Atención -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="far fa-handshake text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Tipo de Atención</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_aten_nombre) ? $tipo_aten_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>


                       <!-- Detalle de Atención -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="far fa-handshake text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Detalle de Atención</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_atend_nombre) ? $tipo_atend_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Propiedad Intelectual -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="far fa-lightbulb text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Propiedad Intelectual</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_prop_nombre) ? $tipo_prop_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Motivo -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                            <i class="fas fa-tag text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Motivo</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($motivo_nombre) ? $motivo_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Operador -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-secondary">
                            <i class="fas fa-user-shield text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Operador</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($usuario_operador) ? $usuario_operador : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Descripción del caso -->
                       <div class="info-item-custom bg-light rounded-lg p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-start">
                          <div class="icon-wrapper bg-white">
                            <i class="fas fa-clipboard-list text-primary"></i>
                          </div>


                          <div>
                            <span class="text-primary small text-uppercase font-weight-bold info-label">Descripción del Caso </span>
                            <div class="text-white font-weight-medium info-value" style="line-height: 1.5;">
                               <div class="text-dark font-weight-medium info-value">
                              "<?= !empty($casodesc) ? $casodesc : 'No Aplica' ?>"
                            </div>
                          </div>
                           </div>

                        </div>
                      </div>

                      <!-- Remitido a -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-success">
                            <i class="fas fa-paper-plane text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Remitido a</span>
                            <div>
                              <span class="badge badge-lg badge-pill" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 6px 12px;"><?= !empty($unidad_administrativa) ? $unidad_administrativa : 'No Aplica' ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Documentos Caso -->
                      <div class="info-item-custom mt-3">
                        <label for="docu-casos" class="text-muted small text-uppercase font-weight-bold d-block info-label" style="margin-bottom: 8px;">Documentos Caso</label>
                        <select id="docu-casos" name="docu-casos" class="form-control custom-select" style="border-radius: 8px; border: 2px solid #e9ecef; background: #fff;">
                          <option value="0" selected disabled>Seleccione documento...</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>

         
        <div class="card-body participantes">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 ">
              <div class="card-body">
              
                <table class="display table-responsive" id="table_participantes" style="width: 100%; margin-top: 20px; ">
                  <thead>
                    <tr>
                      <td class="text-center" style="width: 1%;">Nº</td>
                      <td class="text-center" style="width: 11%;">Nombres y Apellidos</td>
                      <td class="text-center" style="width: 2%;">cedula</td>
                      <td class="text-center" style="width: 1%;">Nac</td>
                      <td class="text-center" style="width: 2%;">T_Beneficiario</td>
                      <td class="text-center" style="width: 1%;">Pais</td>
                      <td class="text-center" style="width: 1%;">Estado</td>
                      <td class="text-center" style="width: 1%;">Municipio</td>
                      <td class="text-center" style="width: 1%;">Parroquia</td>
                      <td class="text-center" style="width: 1%;">Telefono</td>
                      <td class="text-center" style="width: 1%;">Acciones</td>
                    </tr>
                  </thead>
                  <tbody id="listar_participantes">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php else : ?>


          <div class="card-body seguimientos" >
        <div class="row">
          <div class="col-lg-8 col-md-8 col-12 order-2 order-md-1" id="tl">
            <div class="card-body">
            <table class="display table-responsive" id="table_seguimientos" style="width: 100%; margin-top: 20px; ">
                <thead>
                  <tr>
                    <td class="text-center" style="width: 1%;">Nº</td>
                    <td class="text-center" style="width: 1%;">F_Seguimiento</td>
                    <td class="text-center" style="width: 4%;">Estatus/llamada</td>
                    <td class="text-center" style="width: 4%;">Usuario Operador</td>
                    <td class="text-center" style="width: 7%;">Comentario</td>
                    <td class="text-center" style="width: 1%;">Acciones</td>
                  </tr>
                </thead>
                <tbody id="listar_seguimientos">
                </tbody>
              </table>
            </div>
          </div>
           <div class="col-lg-1 col-md-1 col-12 order-1 order-md-2"> </div>
          <!--Detalles del caso-->
            <div class="col-lg-3 col-md-3 col-12 order-1 order-md-2 info-general-left">
                <div class="card card-info shadow-sm h-100" style="border: none; border-radius: 12px;">
                  <div class="card-header bg-gradient-info" style="border-radius: 12px 12px 0 0; border: none;">
                    <h3 class="card-title text-white font-weight-bold">
                      <i class="fas fa-info-circle mr-2"></i>
                      Información General 
                    </h3>
                  </div>
                  <div class="card-body" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);">
                    <input type="hidden" id="id-caso" name="id-caso" value="<?= $idcaso ?>">
                    
                    <div class="info-section">
                      <!-- Fecha del caso -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-info-light">
                            <i class="far fa-calendar-alt text-info"></i>
                          </div>
                          <div>
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Fecha del caso</span>
                            <div class="font-weight-semibold text-dark info-value"><?= !empty($fecha_caso) ? $fecha_caso : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Nombre y Apellido -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-success-light">
                            <i class="fas fa-user text-success"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Nombre y Apellido</span>
                            <div class="font-weight-semibold text-dark info-value"><?= !empty($nombre) ? $nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Correo -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-warning-light">
                            <i class="fas fa-envelope text-warning"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Correo</span>
                            <div class="text-dark info-value" style="word-break: break-all;"><?= !empty($correo) ? $correo : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Ubicación -->
                      <div class="info-item-custom bg-light rounded-lg p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-start">
                          <div class="icon-wrapper bg-primary">
                            <i class="fas fa-map-marker-alt text-white"></i>
                          </div>
                          <div>
                            <span class="text-primary small text-uppercase font-weight-bold info-label">Ubicación</span>
                            <div class="text-dark font-weight-medium info-value">
                              <?= (!empty($estado) || !empty($municipio) || !empty($parroquia)) ? "$estado, $municipio, $parroquia" : 'No Aplica' ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Tipo de Atención -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="far fa-handshake text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Tipo de Atención</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_aten_nombre) ? $tipo_aten_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>


                       <!-- Detalle de Atención -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="far fa-handshake text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Detalle de Atención</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_atend_nombre) ? $tipo_atend_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Propiedad Intelectual -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="far fa-lightbulb text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Propiedad Intelectual</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($tipo_prop_nombre) ? $tipo_prop_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Motivo -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper" style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
                            <i class="fas fa-tag text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Motivo</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($motivo_nombre) ? $motivo_nombre : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Operador -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-secondary">
                            <i class="fas fa-user-shield text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Operador</span>
                            <div class="text-dark font-weight-medium info-value"><?= !empty($usuario_operador) ? $usuario_operador : 'No Aplica' ?></div>
                          </div>
                        </div>
                      </div>

                      <!-- Descripción del caso -->
                       <div class="info-item-custom bg-light rounded-lg p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-start">
                          <div class="icon-wrapper bg-white">
                            <i class="fas fa-clipboard-list text-primary"></i>
                          </div>


                          <div>
                            <span class="text-primary small text-uppercase font-weight-bold info-label">Descripción del Caso </span>
                            <div class="text-white font-weight-medium info-value" style="line-height: 1.5;">
                               <div class="text-dark font-weight-medium info-value">
                              "<?= !empty($casodesc) ? $casodesc : 'No Aplica' ?>"
                            </div>
                          </div>
                           </div>

                        </div>
                      </div>

                      <!-- Remitido a -->
                      <div class="info-item-custom">
                        <div class="d-flex align-items-center">
                          <div class="icon-wrapper bg-success">
                            <i class="fas fa-paper-plane text-white"></i>
                          </div>
                          <div class="flex-grow-1">
                            <span class="text-muted small text-uppercase font-weight-bold info-label">Remitido a</span>
                            <div>
                              <span class="badge badge-lg badge-pill" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 6px 12px;"><?= !empty($unidad_administrativa) ? $unidad_administrativa : 'No Aplica' ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Documentos Caso -->
                      <div class="info-item-custom mt-3">
                        <label for="docu-casos" class="text-muted small text-uppercase font-weight-bold d-block info-label" style="margin-bottom: 8px;">Documentos Caso</label>
                        <select id="docu-casos" name="docu-casos" class="form-control custom-select" style="border-radius: 8px; border: 2px solid #e9ecef; background: #fff;">
                          <option value="0" selected disabled>Seleccione documento...</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <!--/Detalles del caso-->
        </div>

        </div>


        <?php endif; ?>
      </div>
    </div>

    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>


  <div class="modal fade" id="add-seguimiento">
  <div class="modal-dialog modal-dialog-centered  modal-md">
  <div class="modal-content">
  <form id="new-seguimiento" method="POST">
        <div class="modal-header">
          <h4 class="modal-title">Añadir Seguimiento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="hidden" id="idsegcas" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="estatus-llamadas">Estatus de llamadas</label>
            <select class="form-control" id="estatus-llamadas" name="estatus-llamadas">
              <?php echo $estatus; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="seguimiento-comentario">Añadir seguimiento</label>
            <textarea id="seguimiento-comentario" name="seguimiento-comentario"    class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="agregar_seguimiento" class="btn btn-primary">Guardar </button>
          <button type="submit" id="actualizar_seguimiento" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>





<!-- /.MODAL DE PARTICIPANTES -->
<div class="modal fade" id="add-participantes">
 
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <input type="hidden"id="id_participante" >
      <input type="hidden"id="id_taller" >
        <div class="modal-header">
          <h4 class="modal-title">Participantes</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        

        <div class="modal-body">

        <div class="row">
        <div class="col-lg-8 col-sm-8 col-md-8 buscar_participante">
          <div class="d-flex align-items-center">
            <label for="cedula-existente" class="mb-0 mr-2">Buscar Cédula</label>
            <input type="text" class="form-control mr-2" style="max-width: 220px;" onkeypress="return valideKey(event);" name="cedula-existente" min="7" id="cedula-existente" autocomplete="off">
            <button type="button" style="font-size: 11px;" id="btn_buscar" class="btn btn-xs btn-primary btn_buscar">Buscar</button>
          </div>
        </div>
        </div>

    <div class="row">
        <div class="form-group col-md-4"> <!-- Primera columna -->
            <label for="nombre">Nombre</label>
            <input type="text" onkeyup="mayus(this);" class="form-control" onkeypress="noNumeros(event)" id="nombre" name="nombre" required>
        </div>
        <div class="form-group col-md-4"> <!-- Segunda columna -->
            <label for="apellido">Apellido</label>
            <input type="text" onkeyup="mayus(this);" class="form-control" onkeypress="noNumeros(event)" id="apellido" name="apellido" required>
        </div>
        <div class="form-group col-md-4"> <!-- Tercera columna -->
            <label for="cedula">Cédula</label>
            <input type="text" onkeypress="return valideKey(event);" class="form-control" id="cedula" name="cedula" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4"> <!-- Primera columna -->
              <label for="tipo-persona">Tipo de Persona</label>
              <select class="form-control" id="tipo-persona" name="tipo-persona">
              <option value="V">V - Venezolano</option>
              <option value="E">E - Extranjero</option>
              <option value="J">J - Jurídico</option>
              <option value="G">G - Gubernamental</option>
              </select>
        </div>




        <div class="form-group col-md-4"> <!-- Segunda columna -->

        <label for="t-beneficiario">Tipo de Beneficiario</label>
              <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                <option value="0" disabled>Seleccione</option>
              </select>  
        </div>
        <div class="form-group col-md-4"> <!-- Tercera columna -->
            <label for="edad">Edad</label>
            <input type="text" inputmode="numeric" onkeypress="return valideKey(event);" class="form-control" id="edad" name="edad" required>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <label for="pais-caso">País</label>
            <select id="pais-caso" disabled="disabled" name="pais-caso" class="form-control">
                <option value="1" selected disabled>Venezuela</option>
            </select>
        </div>
        <div class="col-4">
            <label for="estado-caso">Estado</label>
            <select id="estado-caso" name="estado-caso" class="form-control">
                <option value="0" disabled>Seleccione Estado</option>
            </select>
        </div>
        <div class="col-4">
            <label for="municipio-caso">Municipio</label>
            <select id="municipio-caso" name="municipio-caso" class="form-control">
                <option value="0">Seleccione Municipio</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <label for="parroquia-caso">Parroquia</label>
            <select id="parroquia-caso" name="parroquia-caso" class="form-control">
                <option value="0">Seleccione Parroquia</option>
            </select>
        </div>
        <div class="col-4">
        <label for="telefono">Teléfono</label>
        <input type="tel" inputmode="numeric" onkeypress="return valideKey(event);" class="form-control" id="telefono" name="telefono" required>
        </div>

        <div class="col-4">
        <label for="sexo">Sexo</label>
            <select class="form-control" id="sexo" name="sexo" required>
                <option value="0" selected disabled>Seleccione</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>   
        </div>
      </div>
     
      <div class="col-lg-4 col-sm-4 col-md-4 org_pp ">
        <label for="organismo-caso">Organismo del Poder Poular</label>
        <select id="organismo-caso" name="organismo-caso" class="form-control">
        <option value="0">Seleccione Organismo</option>
        </select>
      </div>




      <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
        <label for="telefono" class="invisible">Teléfono</label>
            <button class="btn btn-primary" id="ingresar_participante" style="border-radius: 3px; background-color:#3c5b72; color: white; border: none;">
                Ingresar Participante
            </button>
        </div>
        </div>

    
  
    <br>

          <!-- Tabla de agregar participante  -->
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="ant-table-wrapper css-2i2tap">
                  <div class="ant-spin-nested-loading css-2i2tap">
                    <div class="ant-spin-container">
                      <div class="ant-table ant-table-empty">
                        <div class="ant-table-container">
                          <div class="ant-table-content">
                            <table class="table table-striped table-bordered" id="table_audiencia">
                              <thead>
                                <tr>
                                  <th class="ant-table-cell" scope="col">Nombre</th>
                                  <th class="ant-table-cell" scope="col">Apellido</th>
                                  <th class="ant-table-cell" scope="col">Cedula</th>
                                  <th class="ant-table-cell" scope="col">Telefono</th>
                                  <th class="ant-table-cell" scope="col">Sexo</th>
                                </tr>
                              </thead>
                              <tbody class="tbody_0">
                                <tr>
                                  <td class="image_email" colspan="5" style="text-align: center;">
                                    <div class="css-2i2tap ant-empty ant-empty-normal">
                                      <div style="display: block; margin: 0 auto;">
                                        <svg width="64" height="41" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
                                          <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                            <ellipse fill="#f5f5f5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                            <g fill-rule="nonzero" stroke="#d9d9d9">

                                            <path d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>
                                              <path d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z" fill="#fafafa"></path>
                                            </g>
                                          </g>
                                        </svg>
                                      </div>
                                      <div class="ant-empty-description">No data</div>
                                    </div>
                                  </td>
                                </tr>
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
        </div>

        <div class="modal-footer justify-content-between">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="agregar_participantes" class="btn btn-primary">Guardar</button>
          <button type="submit" id="actualizar_participantes" class="btn btn-primary" style="display: none;">Actualizar</button>
        </div>
   
    </div>
  </div>









</div>

           

            





<!-- /.modal -->
<!--/.Añadir estatus-->
<?php if (in_array($session->get('userrol'), [1,2, 3, 5, 10])) { ?>
  <div class="modal fade" id="cambiar-estatus">
    <div class="modal-dialog  modal-dialog-centered modal-md">
      <div class="modal-content">
        <form id="caso-estatus" method="POST">
          <div class="modal-header">
            <input type="hidden" id="env_correo" value="<?php echo $env_correo; ?>">
            <h4 class="modal-title">Cambiar estatus de caso</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="estatus-caso">Estatus caso</label>
              <select id="estatus-caso" name="estatus-caso" class="form-control">
                <?php echo $estatus_llamadas; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <label id="mensaje" style="display: none;">Espere un momento, esta ventana se cerrará automáticamente</label>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<?php } ?>

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

<!-- Ajuste de layout dinámico para evitar espacio vacío y normalizar visibilidad -->
<script>
(function(){
  function updateLayoutForSections(showSeguimientos){
    var rows = document.querySelectorAll('.card-body.seguimientos .row');
    rows.forEach(function(row){
      var leftCol = row.querySelector('#tl');
      var spacer = row.querySelector('.col-lg-1.col-md-1');
      var infoCol = row.querySelector('.info-general-left');
      if (!leftCol || !infoCol) return;
      if (showSeguimientos){
        leftCol.classList.remove('d-none');
        if (spacer) spacer.classList.remove('d-none');
        infoCol.classList.remove('col-12','col-md-12','col-lg-12');
        if (!infoCol.classList.contains('col-lg-3')){
          infoCol.classList.add('col-lg-3','col-md-3','col-12');
        }
      } else {
        leftCol.classList.add('d-none');
        if (spacer) spacer.classList.add('d-none');
        infoCol.classList.remove('col-lg-3','col-md-3');
        if (!infoCol.classList.contains('col-lg-12')){
          infoCol.classList.add('col-12','col-md-12','col-lg-12');
        }
      }
    });
  }

  function setSections(showSeguimientos){
    var seg = document.querySelector('.card-body.seguimientos');
    var part = document.querySelector('.card-body.participantes');
    if (seg) seg.classList.toggle('d-none', !showSeguimientos);
    if (part) part.classList.toggle('d-none', showSeguimientos);
    updateLayoutForSections(showSeguimientos);
    if (showSeguimientos && window.$ && $.fn && $.fn.dataTable){
      setTimeout(function(){ try { $('#table_seguimientos').DataTable().columns.adjust(); } catch(e) {} }, 150);
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    var selectInfo = document.getElementById('informacion');
    if (selectInfo){
      if (selectInfo.value === '1'){
        setSections(true);
      } else if (selectInfo.value === '2'){
        setSections(false);
      } else {
        var seg = document.querySelector('.card-body.seguimientos');
        var showSeguimientos = seg ? !seg.classList.contains('d-none') : true;
        updateLayoutForSections(showSeguimientos);
      }
      selectInfo.addEventListener('change', function(){
        setSections(this.value === '1');
      });
    } else {
      var seg = document.querySelector('.card-body.seguimientos');
      var showSeguimientos = seg ? !seg.classList.contains('d-none') : true;
      updateLayoutForSections(showSeguimientos);
    }
  });

  window.previewInfoOnly = function(){ setSections(false); };
  window.restoreLayout = function(){ setSections(true); };
})();
</script>