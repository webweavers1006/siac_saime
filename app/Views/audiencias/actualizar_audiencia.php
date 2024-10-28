
          
 <!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/actualizar_audiencias.css">

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
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Actualizar Audiencia</p>
                <span style="font-size: 14px;">Nº <?php echo $datos2['id']; ?></span>
                <input type="hidden" id="id_requerimiento" value="<?php echo $datos2['id']; ?>">

                <input type="hidden" id="id_condicion" value="<?php echo $datos2['id_condicion']; ?>">

                <br><br>
              </div>
             
            </div>
          </div>
        </div>
      </div>

      <input type="hidden"  id="id_area"value="<?php echo $datos2['id_area']; ?>">
<!-- Sección de información -->
<section class="section" style="margin-left: 63px;">
  <div class="card card_table " style="max-width: 1350px; margin: 20px auto;">
    <div class="column is-7">
      <div class="box">
        <div class="columns is-centered is-multiline">
          <div class="column is-12">
            <div class="ant-descriptions css-2i2tap">
              <div class="ant-descriptions-header">
                <div class="ant-descriptions-title">Información de Audiencia</div>
              </div>
              <div class="ant-descriptions-view">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                  <div>
                    <label>Formato de la cita:</label>
                    <input type="text" value="<?php echo $datos2['formato_cita']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>País:</label>
                    <input type="text" value="<?php echo $datos2['pais']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Estado:</label>
                    <input type="text" value="<?php echo $datos2['estado_pais']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Estatus:</label>
                    <input type="text" value="<?php echo $datos2['estado']; ?>"  class="no-border" disabled>
                  </div>
                  <div>
                    <label>Responsable:</label>
                    <input type="text" value="<?php echo $datos2['trabajador']; ?>" style="width: 400px;" class="no-border" disabled>
                  </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                  <div class="column is-12">
                  <div class="columns">
                    <div class="column is-12">
                      <div class="dividir"><span>Formato Cita</span></div>
                    </div>
                  </div>
                    <div class="control">
                      <div class="select">
                      <select name="id_formato_cita" id="id_formato_cita">
                          <option value="0" <?php echo ($datos2['id_formato_cita'] == 0) ? 'selected' : ''; ?>>---Seleccione un Formato---</option>
                          <option value="1" <?php echo ($datos2['id_formato_cita'] == 1) ? 'selected' : ''; ?>>Presencial</option>
                          <option value="2" <?php echo ($datos2['id_formato_cita'] == 2) ? 'selected' : ''; ?>>Virtual</option>
                      </select>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                  <div>
                    <label>Pais</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_pais" class="w-100" id="pais-select">
                            <option value="0">---Seleccione un pais---</option>
                            <?php
                            foreach ($pais['paisess'] as $estado) {
                                $selected = ($estado['id'] == $datos2['id_pais']) ? 'selected' : '';
                                echo "<option value='{$estado['id']}' $selected>{$estado['pais']}</option>";
                            }
                            ?>
                      </select>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label>Estado</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_estado" class="w-100" id="estado-select">
                          <option value="0">---Seleccione un estado---</option>
                      </select>

                      <script>
                          // Agregamos un bloque de código que se ejecute al cargar la página
                          window.onload = function() {
                              var paisSelect = document.getElementById('pais-select');
                              var paisName = paisSelect.options[paisSelect.selectedIndex].text;
                              if (paisName.toLowerCase() === 'venezuela') {
                                  <?php
                                  foreach ($estados['estados_paisess'] as $estado) {
                                      $selected = ($estado['id'] == $datos2['id_estado_pais']) ? 'selected' : '';
                                      echo "document.getElementById('estado-select').innerHTML += '<option value=\"{$estado['id']}\" $selected>{$estado['estado_pais']}</option>';";
                                  }
                                  ?>
                              }
                          };

                          // Mantenemos el evento onchange para actualizar el select cuando se cambie el país
                          document.getElementById('pais-select').onchange = function() {
                              var paisId = this.value;
                              var paisName = this.options[this.selectedIndex].text;
                              if (paisName.toLowerCase() === 'venezuela') {
                                  <?php
                                  foreach ($estados['estados_paisess'] as $estado) {
                                      $selected = ($estado['id'] == $datos2['id_estado_pais']) ? 'selected' : '';
                                      echo "document.getElementById('estado-select').innerHTML += '<option value=\"{$estado['id']}\" $selected>{$estado['estado_pais']}</option>';";
                                  }
                                  ?>
                              } else {
                                  document.getElementById('estado-select').innerHTML = '<option value="0">---Seleccione un estado---</option>';
                              }
                          };
                      </script>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label>Responsable</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_trabajador" id="id_trabajador">
                      <option value="0" selected>---Seleccione---</option>
                          <!-- <option value="0" <php echo ($datos2['id_trabajador'] == 0) ? 'selected' : ''; ?>>---Seleccione un responsable---</option>
                          <option value="38" <php echo ($datos2['id_trabajador'] == 38) ? 'selected' : ''; ?>>DIRECTOR PATENTES</option>
                          <option value="35" <php echo ($datos2['id_trabajador'] == 35) ? 'selected' : ''; ?>>DIRECTOR MARCAS</option> -->
                      </select>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label>Estatus</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_estado" id="id_estado">
                          <option value="0" <?php echo ($datos2['id_estado'] == 0) ? 'selected' : ''; ?>>---Seleccione un Estatus---</option>
                          <option value="1" <?php echo ($datos2['id_estado'] == 1) ? 'selected' : ''; ?>>NUEVO</option>
                          <option value="2" <?php echo ($datos2['id_estado'] == 2) ? 'selected' : ''; ?>>EN PROCESO</option>
                          <option value="3" <?php echo ($datos2['id_estado'] == 3) ? 'selected' : ''; ?>>RESUELTO</option>
                      </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-12">
            <br>
            <button class="button is-primary is-fullwidth" id="actualizar_audiencias">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>






<br>
</div>
</div>
