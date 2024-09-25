<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/dashboard.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    ;
  }
</style>
<?php
$session = session();
?>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">

    <div class="container-fluid container-fluid-smaller">
      <!-- /.row -->
        
<!-- Verificar si el rol del usuario actual es igual a 9 -->
<?php if ($session->get('userrol') == 9) { ?>
  <!-- Iniciar la fila de tarjetas -->
  <div class="row">
    <!-- Recorrer el arreglo de estatus de requerimientos -->
    <?php foreach ($estatus['requerimientosbyEstados'] as $estado) { ?>
      <!-- Crear una tarjeta para cada estatus -->
      <div class="col-lg-4 col-md-6 col-sm-12 p-2">
        <div class="box height">
          <div class="mt-2">
            <!-- Mostrar el título de la tarjeta según el estatus -->
            <h2 class="has-text-weight-bold is-relative">
              <?php 
              switch ($estado['estado']) {
                case 'NUEVO':
                  echo 'Casos Recibidos';
                  break;
                case 'EN PROCESO':
                  echo 'Casos Atendidos';
                  break;
                case 'RESUELTA':
                  echo 'Casos Resueltos';
                  break;
              }
              ?>
              <!-- Agregar un icono según el estatus -->
              <span class="icon mr-2 icon-dash 
              <?php 
              switch ($estado['estado']) {
                case 'NUEVO':
                  echo 'yellow';
                  break;
                case 'EN PROCESO':
                  echo 'blue';
                  break;
                case 'RESUELTA':
                  echo 'red';
                  break;
              }
              ?>">
                <i class="fas fa-clipboard-list" aria-hidden="true"></i>
              </span>
            </h2>
          </div>
          <!-- Mostrar el total de requerimientos para cada estatus -->
          <p class="mt-3 has-text-weight-semibold is-size-full has-text-centered"><?= $estado['total'] ?></p>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>






      <br>
        <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">
            <div class="card-body imagen">
              <section class="form-login_imagen2">
                <div class="imagencentral2">
                  <img class="img-fluid mx-auto d-block" src="<?= base_url() ?>/img/LogoSIAC_sapi.png" id="imagencentral">
                </div>
               
              </div>
             
            </section>
           
          </div>
        </div>
      </div>
      
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
