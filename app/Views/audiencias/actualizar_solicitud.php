
          
 <!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/actualizar_solicitud.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/flatpickr.min.css">

<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>

<!-- Contenedor principal -->
<div class="content-wrapper">
  <main class="content">
    <!-- Tarjeta principal -->
    <div class="container">
      <br>
      <div class="row">
        <div class="col-lg-12 custom-col-width">
          <div class="card card_table audiencia" style=" margin: 20px auto;">
            <div class="d-flex align-items-center">
              <img src="<?php echo base_url(); ?>/img/favicon.jpg" style="width: 30px; height: 30px;">
              <div class="ml-2">
              <p class="mb-0" style="font-size: 18px; font-weight: bold;"> Actualizar Solicitud</p>
                <span style="font-size: 14px;">Nº <?php echo $datos2['id']; ?> - Numero solcitud  <?php echo $datos['num_solicitud']; ?></span>
                <br><br>
              </div>
             
            </div>
          </div>
        </div>
      </div>


<!-- Sección de información -->
<section class="section" style="margin-left: 63px;">
  <div class="card card_table " style="max-width: 1350px; margin: 20px auto;">
    <div class="column is-7">
      <div class="box">
        <div class="columns is-centered is-multiline">
          <div class="column is-12">
            <div class="ant-descriptions css-2i2tap">
              <div class="ant-descriptions-header">
                <div class="ant-descriptions-title">Información de solicitud</div>
              </div>
              <div class="ant-descriptions-view">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                  <div>
                    <label>Estatus:</label>
                    <input type="text" value="<?php echo $datos['estado']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Descripción:</label>
                    <input type="text" value="<?php echo $datos['descripcion']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Responsable:</label>
                    <input type="text" value="<?php echo $datos['responsable']; ?>" class="no-border" disabled>
                  </div>
                  
                </div>
              
                <br>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                  
                <div>
                    <label>Estatus</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_estado">
                          <option value="0" <?php echo ($datos['id_estado'] == 0) ? 'selected' : ''; ?>>---Seleccione un Estatus---</option>
                          <option value="6" <?php echo ($datos['id_estado'] == 6) ? 'selected' : ''; ?>>Por resolver</option>
                          <option value="7" <?php echo ($datos['id_estado'] == 7) ? 'selected' : ''; ?>>Resuelta</option>
                       
                      </select>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label>Responsable</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_trabajador">
                    <option value="0">---Seleccione un responsable---</option>
                    <?php foreach ($responsable['usuariosareas'] as $usuarioarea) { ?>
                        <?php if ($usuarioarea['id_area'] == $datos['id_area']) { ?>
                            <option value="<?php echo $usuarioarea['id']; ?>" <?php echo ($usuarioarea['id_usuario'] == $datos['id_trabajador']) ? 'selected' : ''; ?>>
                                <?php echo $usuarioarea['nombre']; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                  </select>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
                <div class="control">
                    <p class=" has-text-weight-semibold mb-5">Descripción</p>
                    <textarea class="textarea" name="descripcion"><?php echo $datos['descripcion']; ?></textarea>
                  </div>
              </div>
            </div>
          </div>
          <div class="column is-12">
            <br>
            <button class="button is-primary is-fullwidth">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>






<br>
</div>
</div>
