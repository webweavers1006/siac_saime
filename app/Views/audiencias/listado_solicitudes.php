
<?php
$session = session();
$userdata = $session->get();

?>   
          
 <!-- Content Wrapper. Contains page content -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/detalles_requerimientos.css">
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
    <div class="container-fluid">
      <br>
      <div class="row">
        <div class="col-lg-12 custom-col-width">
          <div class="card card_table audiencia" style="max-width: 1350px; margin: 20px auto;">
            <div class="d-flex align-items-center">
              <img src="<?php echo base_url(); ?>/img/favicon.jpg" style="width: 40px; height: 40px;">
              <div class="ml-4">
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Listado de Solicitudes</p>

              <br>
              <p class="mb-0" style="font-size: 14px; font-weight: bold;"><?php echo ($userdata['nombre'])?></p>
              </div>
            </div>
          
             
            
          </div>
        </div>
      </div>


  <!-- Sección de información -->
  <section class="section" style="margin-left: 63px;">
        <!-- Información Empresa o Bufete -->
       

        <!-- Control de Remisión -->
        <?php if (!empty($otrosdatos) && !$otrosdatos['error']) { ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="box">
                                <button type="button" class="ant-btn css-2i2tap ant-btn-primary" id="remitir" class="ant-btn css-2i2tap ant-btn-primary" disabled>
                                    <span>Remitir</span>
                                </button>
                                <div class="select" style="display: inline-block; margin-left: 6px;">
                                <select name="id_trabajador" disabled id="id_trabajador">
                                    <option value="0" selected>---Seleccione un responsable---</option>

                                    <?php foreach ($responsable['usuariosareas'] as $usuarioarea) { ?>
                                        <?php if ($usuarioarea['id_area'] == $otrosdatos['informacion']['id_area']) { ?>
                                            <option value="<?php echo $usuarioarea['id']; ?>" >
                                                <?php echo $usuarioarea['nombre']; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?php } ?>

              <!-- Tabla de Audiencias -->
        <div class="row">
          <div class="col-lg-11">
            <div class="card card_table">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="table_audiencia" style="width:100%">
                  <thead>
                    <tr>
                    <th class="text-center" style="width: 1%;"></th>
                      <th class="text-center" style="width: 10%;">Número Solicitud</th>
                      <th class="text-center" style="width: 5%;">Estatus del caso</th>
                      <th class="text-center" style="width: 10%;">Categoría</th>
                      <th class="text-center" style="width: 1%;"></th>
                    </tr>
                  </thead>
                  <tbody>

                 

                    <?php
                      // Verifica si el arreglo $datos['solicitudes'] no está vacío
                      if (!empty($datos['solicitudes'])) {
                        // Inicia el ciclo foreach para recorrer cada solicitud en el arreglo
                        foreach ($datos['solicitudes'] as $solicitud) {
                          // Genera una fila en la tabla para cada solicitud
                          ?>
                          <tr>
                            <td class="text-center">
                              <!-- Checkbox con el valor de la solicitud -->
                             
                              <!-- Icono de estado de la solicitud -->
                              <span class="circle" style="background-color: <?php echo getStateColor($solicitud['estado']); ?>;"></span>
                            </td>
                            <td class="text-center">
                              <!-- Enlace con el número de solicitud y el ID de la solicitud -->
                              <a href="#" data-id="<?php echo $solicitud['id']; ?>" class="link-solicitud">
                                Nº<?php echo $solicitud['num_solicitud']; ?>
                              </a>
                            </td>
                            <td class="text-center"><?php echo $solicitud['estado']; ?></td>
                            <td class="text-center"><?php echo $solicitud['categoria']; ?></td>
                            <td class="text-center">
                             <?php if (!empty($mensajes['solicitudes']) && $solicitud['num_solicitud'] == $mensajes['solicitudes'][0]['num_solicitud'] && $mensajes['solicitudes'][0]['mensajes'] == 'cita') { ?> 
                              <span class="circle" style="background-color: <?php echo getStateColor($mensajes['solicitudes'][0]['mensajes']); ?>;"></span>
                              <?php } ?> 
                            </td>
                            <td style="display: none;"><?php echo $solicitud['id']; ?></td> <!-- Add this line to hide the ID -->
                          </tr>

                          <?php
                
                
             

                      }
                    } else {
                      // Si el arreglo está vacío, muestra el mensaje de "No data"
                      ?>
                      <tbody class="tbody_0">
                          <!-- Contenido de la tabla -->
                          <td class="image_email" colspan="7" style="text-align: center;">
                              <div class="css-2i2tap ant-empty ant-empty-normal">
                                  <div style="display: block; margin: 0 auto;">
                                      <!-- Icono SVG de "No data" -->
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
                                  <!-- Mensaje de "No data" -->
                                  <div class="ant-empty-description">No data</div>
                              </div>
                          </td>
                      </tbody>
                      <?php
                    }
                    ?>
                </tbody>

                

                </table>
              </div>
            </div>
          </div>
        </div>

        <?php
        function getStateColor($estado) {
          switch (trim($estado)) {
            case 'POR RESOLVER':
              return 'rgb(34, 129, 155)';
            case 'RESUELTA':
              return 'rgb(49, 155, 67)';
            default:
              return '#1677ff';
          }
        }
        ?>
        <style>
        /* Estilos para el checkbox */

          .circle {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
          }
          
        </style>
</section>


<br>
  <!-- Estatus de la Audiencia -->
  <br><br>
<div class="row">
<div class="col-3">
  <div class="box_estatus">
    <div class="card estatus">
      <div class="card-body">
        <div><span class="estatus-items">
          <span class="ant-badge ant-badge-status ant-badge-not-a-wrapper css-2i2tap">
          <span class="estatus-item estatus1">Por resolver</span>
          <div><span class="estatus-items">
            <span class="estatus-item estatus2">Resuelta</span>
            <div><span class="estatus-items">
              <span class="estatus-item estatus3">Solicitud de cita</span>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
</div>
<div class="col-6">
</div>


  




</div>



<style>
 /* Estilos generales del calendario */


.flatpickr-calendar {
  background-color: transparent;
  background: linear-gradient(to right, #c7d8ee, #dce4f0, #edf0f3);
  border-radius: 25px;
  padding: 20px; /* Agregué un padding para dar espacio entre el contenido y el borde */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Agregué una sombra para dar profundidad */
}

/* Estilos de los días */
.flatpickr-day {
  cursor: pointer; /* Agregué un cursor para indicar que se puede hacer clic */
}

/* Estilos del selector de hora, mes y año */
.flatpickr-time{
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Agregué una sombra para dar profundidad */
}

.flatpickr-month {
  font-weight: bold; /* Negrita */
  color: #333; /* Gris oscuro */
  font-size: 12px;
}

/* Estilos de los nombres de los días de la semana */
.flatpickr-weekday {
  font-weight: bold; /* Negrita */
  color: #03A9F4;
  border-radius: 10px;
}

/* Estilos del día de hoy y del día seleccionado */
.flatpickr-day.today, .flatpickr-day.selected {
  background-color: #034eaf; /* Azul */
  border-radius: 50%;
  color: #fff; /* Blanco */
}
.flatpickr-time .arrow {
  border-width: 50px;
  border-color: #333;
  border-style: solid;
  cursor: pointer;
}

</style>
<script src="<?php echo base_url(); ?>/custom/js/calendario/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url(); ?>/custom/js/calendario/flatpickr.min.js"></script>







<br>
</div>
</div>
