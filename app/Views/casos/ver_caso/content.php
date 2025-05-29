<?php
$session = session();
?>
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
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
        <h3 class="text-secondary">
          <i class="fas fa-angle-double-right"></i> Seguimientos del Caso Nº 
          <span style="color: black;"><?= $idcaso; ?></span>&nbsp;&nbsp;
          <a data-toggle="modal" data-target="#add-seguimiento" class="btn btn-sm btn-primary">Añadir Seguimiento</a>
          
          <?php if ($acc_participantes == 't') : ?>
            <a data-toggle="modal" data-target="#add-participantes" class="btn btn-sm btn-success" id="btn-add-participantes">Añadir Participantes</a>
           
          <?php endif; ?>
         
          <?php if (in_array($session->get('userrol'), [1, 3, 5, 10])) : ?>
            <a data-toggle="modal" data-target="#cambiar-estatus" class="btn btn-sm btn-dark">Cambiar estatus</a>
          <?php endif; ?>
        </h3>
        
        <?php if ($acc_participantes == 't') : ?>
          <br>
          <div class="row">
          <div class="col-lg-7 col-md-7 col-sm-7">
              <h3 class="text-secondary">
                  Nombre de la Actividad:
              </h3>
              <h4 style="color: black;"><?= htmlspecialchars($casodesc); ?></h4>
              <input type="hidden" id="descripcion_actividad" value="<?php echo htmlspecialchars($casodesc); ?>">
          </div>
              <div class="col-lg-1 col-md-1 col-sm-1">
                 
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 d-flex align-items-center">
                  <label for="informacion" class="mr-2"><h3>Información</h3></label>&nbsp;&nbsp;
                  <select class="form-control" id="informacion" name="tipo-atencioni-usu">
                      <option value="0" selected disabled>Seleccione</option>
                      <option value="1">Seguimientos</option>
                      <option value="2">Participantes</option>
                  </select>
              </div>
          </div>
          

         
          

          <div class="card-body seguimientos" style="visibility: hidden;">
            <div class="row">
              <div class="col-9 col-md-9 col-lg-9 order-2 order-md-1" id="tl">
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
              <!--Detalles del caso-->
              <div class="col-6 col-md-6 col-lg-3 order-1 order-md-2 detalle_caso ">
                <h3 class="text-primary"><i class="fas fa-angle-double-right"></i> Informacion General

                </h3>

                <input type="hidden" id="id-caso" name="id-caso" value="<?php echo $idcaso ?>">

                <div class="text-muted">

                  <b class="d-block">Fecha del caso:</b>
                  <i class="far fa-calendar fa-calendar"></i>
                  <?php echo '<span style="color: black;">' . $fecha_caso . '</span>'; ?>
                  <b class="d-block">Nombre y Apellido:</b>
                  <?php echo '<span style="color: black;">' . $nombre . '</span>'; ?>
                  <b class="d-block">Correo Beneficiario:</b>
                  <?php echo '<span style="color: black;">' . $correo . '</span>'; ?>
                  <!-- <b class="d-block">Direccion:</b>
                  <php echo '<span style="color: black;">' . $direccion . '</span>'; ?> -->
                  <b class="d-block">Estado:</b>
                  <?php echo '<span style="color: black;">' . $estado . '</span>'; ?>
                  <b class="d-block">Municipio: </b> <?php echo '<span style="color: black;">' . $municipio . '</span>'; ?>
                  <b class="d-block">Parroquia:</b>
                  <?php echo '<span style="color: black;">' . $parroquia . '</span>'; ?>
                  <p class="text-md">
                    <b class="d-block"> Descricion del caso:</b>
                    <?php echo '<span style="color: black;">' . $casodesc . '</span>'; ?>
                    </b>
                    <b class="d-block"> Caso Remitido a:</b>
                    <?php echo '<span style="color: black;">' . $unidad_administrativa . '</span>'; ?>
                    </b>
                  </p>
              
                          
                  <b class="d-block">DOCUMENTOS CASO:</b>
                  <select class="form-control" style="width: 300px;" id="docu-casos" name="docu-casos">
                  <option value="0" selected disabled>Seleccione</option>
                  </select>

                  <b class="d-block">Detalles adicionales:</b>
                  <i class="far fa-user fa-user"></i>
                  <?php echo '<span style="color: black;">' . $usuario_operador . '</span>'; ?>
                  
                </div>
              </div>
            </div>
          </div>

         
        <div class="card-body participantes" style="visibility: hidden;">
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
          <div class="col-9 col-md-9 col-lg-9 order-2 order-md-1" id="tl">
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
          <!--Detalles del caso-->
          <div class="col-6 col-md-6 col-lg-3 order-1 order-md-2 detalle_caso ">
            <h3 class="text-primary"><i class="fas fa-angle-double-right"></i> Informacion General

            </h3>

            <input type="hidden" id="id-caso" name="id-caso" value="<?php echo $idcaso ?>">

            <div class="text-muted">

              <b class="d-block">Fecha del caso:</b>
              <i class="far fa-calendar fa-calendar"></i>
              <?php echo '<span style="color: black;">' . $fecha_caso . '</span>'; ?>
            
              <b class="d-block">Nombre y Apellido:</b>
              <?php echo '<span style="color: black;">' . $nombre . '</span>'; ?>
              <b class="d-block">Correo Beneficiario:</b>
              <?php echo '<span style="color: black;">' . $correo . '</span>'; ?>
              <!-- <b class="d-block">Direccion:</b>
              <php echo '<span style="color: black;">' . $direccion . '</span>'; ?> -->
              <b class="d-block">Estado:</b>
              <?php echo '<span style="color: black;">' . $estado . '</span>'; ?>
             
              <b class="d-block">Municipio: </b> <?php echo '<span style="color: black;">' . $municipio . '</span>'; ?>
             
              <b class="d-block">Parroquia:</b>
              <?php echo '<span style="color: black;">' . $parroquia . '</span>'; ?>
             
              <p class="text-md">
                <b class="d-block"> Descricion del caso:</b>
                <?php echo '<span style="color: black;">' . $casodesc . '</span>'; ?>
                </b>
                <b class="d-block"> Caso Remitido a:</b>
                <?php echo '<span style="color: black;">' . $unidad_administrativa . '</span>'; ?>
                </b>
              </p>
           
                      
              <b class="d-block">DOCUMENTOS CASO:</b>
              <select class="form-control" style="width: 300px;" id="docu-casos" name="docu-casos">
              <option value="0" selected disabled>Seleccione</option>
              </select>

              <b class="d-block">Detalles adicionales:</b>
              <i class="far fa-user fa-user"></i>
              <?php echo '<span style="color: black;">' . $usuario_operador . '</span>'; ?>
              
            </div>
            <br>


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
<!-- /.content-wrapper -->
<!--Añadir seguimiento-->





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
        <input type="hidden" name="" id="idsegcas" value="">
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
 
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Cambiado a modal-lg -->
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
          <div style="display: flex;">  <label for="cedula-persona">Buscar Cédula   &nbsp;&nbsp;&nbsp; </label>
            <input type="text" class="form-control" style="width: 200px;"  onkeypress="return valideKey(event);" name="cedula-existente" min="7" id="cedula-existente" autocomplete="off">
            &nbsp;&nbsp;&nbsp; <button type="button" style="font-size: 11px;" id="btn_buscar" class="btn btn-xs btn-primary btn_buscar">Buscar</button>
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
            <input type="text" onkeypress="return valideKey(event);" class="form-control" id="edad" name="edad" required>
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
        <input type="tel" onkeypress="return valideKey(event);" class="form-control" id="telefono" name="telefono" required>
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
        <label for="telefono" style="color: white; pointer-events: none; user-select: none;">Teléfono</label>
            <button  class="btn btn-primary" id="ingresar_participante" style="border-radius: 3px; background-color:#3c5b72; color: white; border: none;">
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
                            <table class="table table-striped table-bordered" id="table_audiencia" style="table-layout: auto;">
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
<?php if ($session->get('userrol') == 1  or $session->get('userrol') == 3 or $session->get('userrol') == 5 or $session->get('userrol') == 10) { ?>
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