<?php
$session = session();
?>
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/ver_caso.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <input type="hidden" name="" id="rol_usuario" value="<?php echo($session->get('userrol'));?>">
  <input type="hidden" name="" id="id_usuario" value="<?php echo($session->get('iduser'));?>">


  <!-- Main content -->
  <section class="container-fluid ">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Seguimientos del Caso Nº <?php echo '<span style="color: black;">' . $idcaso . '</span>'; ?> &nbsp;&nbsp;
            <a data-toggle="modal" data-target="#add-seguimiento" class="btn btn-sm btn-primary">Añadir Seguimiento</a>
            <?php if ($session->get('userrol') == 1 || $session->get('userrol') == 3 ||  $session->get('userrol') == 5 || $session->get('userrol') == 10) { ?>&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a data-toggle="modal" data-target="#cambiar-estatus" class="btn btn-sm btn-dark">Cambiar estatus</a>
          <?php } ?>
          </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-8 col-md-8 col-lg-8 order-2 order-md-1" id="tl">
            <div class="card-body">
              <table class="display table-responsive" id="table_seguimientos" style="width:100%" style="margin-top: 20px">
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
          <div class="col-8 col-md-8 col-lg-4 order-1 order-md-2 detalle_caso ">
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
              <select class="form-control" style="width: 350px;" id="docu-casos" name="docu-casos">
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
      <!-- /.card-body -->
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
<!-- /.modal -->
<!--/.Añadir estatus-->
<?php if ($session->get('userrol') == 1  or $session->get('userrol') == 3 or $session->get('userrol') == 5 or $session->get('userrol') == 10) { ?>
  <div class="modal fade" id="cambiar-estatus">
    <div class="modal-dialog  modal-dialog-centered modal-md">
      <div class="modal-content">
        <form id="caso-estatus" method="POST">
          <div class="modal-header">
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

