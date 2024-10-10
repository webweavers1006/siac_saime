
          
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
              <img src="<?php echo base_url(); ?>/img/favicon.jpg" style="width: 30px; height: 30px;">
              <div class="ml-2">
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Audiencia</p>
                <span style="font-size: 14px;">Nº <?php echo $datos2['id']; ?></span>
               
              </div>
            </div>
          
              <div class="col-sm-4">
                <label class="has-text-weight-semibold">Pais de solicitud</label>
            
                - <?php echo $datos2['pais']; ?>
              </div>
              <div class="col-sm-4">
                <label class="has-text-weight-semibold">Formato de cita</label>
                <!-- Información del formato de cita -->
                - <?php echo $datos2['formato_cita']; ?>
              </div>
              <div class="col-sm-4">
                <label class="has-text-weight-semibold">Fecha creacion</label>
                <!-- Información de la fecha de creación -->
                -  <?php echo date("d-m-Y H:i:s", strtotime($datos2['created'])); ?>
              </div>
            
          </div>
        </div>
      </div>


  <!-- Sección de información -->
  <section class="section" style="margin-left: 63px;">
        <!-- Información Empresa o Bufete -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card card_table">
              <div class="card-body p-3">
                <h5 class="ant-descriptions-title" style="font-weight: bold;">Informacion Empresa o Bufete</h5>
                <h5 class="ant-descriptions-title" style="font-weight: bold;">Informacion Empresa o Bufete</h5>
                <h5 class="ant-descriptions-title" style="font-weight: bold;">Informacion Empresa o Bufete</h5>
              </div>
            </div>
          </div>
        </div>

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
                                <div class="select"  style="display: inline-block; margin-left: 6px;">
                                    <select name="id_trabajador" disabled>
                                        <option value="0">---Seleccione un responsable---</option>

                                        <?php foreach ($responsable['usuariosareas'] as $usuarioarea) { ?>
                                            <?php if ($usuarioarea['id_area'] == $otrosdatos['informacion']['id_area']) { ?>
                                                <option value="<?php echo $usuarioarea['id']; ?>" <?php echo ($usuarioarea['id'] == $otrosdatos['informacion']['id_trabajador']) ? 'selected' : ''; ?>>
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
          <div class="col-lg-8">
            <div class="card card_table">
              <div class="card-body">
                <table class="table table-striped table-bordered" id="table_audiencia" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 2%;"><input type="checkbox" id="selectAll" name="select[]" value=""></th>
                      <th class="text-center" style="width: 15%;">Número Solicitud</th>
                      <th class="text-center" style="width: 5%;">Estatus del caso</th>
                      <th class="text-center" style="width: 10%;">Categoría</th>
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
                                    <input type="checkbox" class="checkbox-status" name="select[]" value="<?php echo $solicitud['num_solicitud']; ?>">
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


<section class="section_card">
  <!-- Tarjeta Lateral -->
  <div class="col-lg-3  card_lateral">
    <input type="hidden" id="id_requerimiento" value="<?php echo $datos2['id']; ?>">
    <div class="row">
    <div class="col-12">
    <?php
      if (empty($cita['fecha_cita']) || is_null($cita['fecha_cita'])) {
      ?>
      <div class="card citas">
          <div class="card-body" style="padding-left: 10px;">
              <label class="form-check-label text-left" for="pdf"><b>Agendar cita </b></label>
              <input id="fecha_cita"  class="form-control w-100"   type="text" placeholder="Seleccione una fecha y hora">
              <div class="select w-100">
                  <label for="">Formato de cita</label>
                  <select name="id_formato_cita" id="id_formato_cita" class="w-100">
                      <option value="0">---Seleccione un Formato---</option>
                      <option value="1">Presencial</option>
                      <option value="2">Virtual</option>
                  </select>
              </div>
              <br><br><button class="btn btn-primary btn-block w-100 agendar">Agendar</button> 
          </div>
      </div>
    <?php
    } else {
    ?>
    <div class="actualizar_citas" >
    <div class="card citas">
    <div class="card-body" style="padding-left: 10px;">
    <label class="form-check-label text-left" for="pdf"><b><?php echo $cita['estado']; ?> </b></label>
        <br><label for="id_formato_cita">Fecha :</label> <?php echo date_format(date_create($cita['fecha_cita']), 'd-m-Y'); ?>
        <br><label for="id_formato_cita">Formato :</label> <?php echo $cita['formato_cita']; ?>
        <br><label for="id_formato_cita">Hora :</label> <?php echo date_format(date_create($cita['fecha_cita']), 'g:i a'); ?>
        <br>
        <a href="/actualizar_citas/<?php echo $cita['id']; ?>">
          <div class="box is-pointer has-background-blue helper-button ">
          <button class="btn btn-primary btn-block w-100 actualizar">Editar</button> 
          </div>
        </a>
        
        
       
    </div>
</div>
     </div>
    <?php
    }
    ?>

    </div>

    
    <div class="col-12">
      <div class="card responsable">
        <div class="card-body">
          <div class="box is-primary">
            <p style="text-align: left;" class="has-text-bold" style="color: inherit;">Responsable</p>
            <p style="text-align: center;" class="has-text-bold" style="color: inherit;">
            <?php if (!empty($solicitud)) { ?>

             
            <h3 style="text-align: center;"><?php echo $solicitud['trabajador']; ?></h3>
            <?php } ?>
            </p>
            <p style="text-align: center;" class="has-text-bold" style="color: inherit;">Area</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  </div>

</section>
<br>
  <!-- Estatus de la Audiencia -->
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


  <div class="is-fixed bottom-5 ">
  <a href="/agregar_solicitudes/<?php echo $datos2['id'];?>">
      <div class="box is-pointer has-background-blue helper-button ">
        <span class="icon is-small is-right has-text-white circle-icon">
          <i class="fa fa-plus-square" aria-hidden="true" style='font-size:27px'></i>
        </span>
      </div>
    </a>
  </div>

  <div class="is-fixed bottom-1 ">
    <a href="/actualizar_audiencia/<?php echo $datos2['id'];?>">
      <div class="box is-pointer has-background-blue helper-button ">
        <span class="icon is-small is-right has-text-white circle-icon">
          <i class="material-icons" style='font-size:27px'>create</i>
        </span>
      </div>
    </a>
  </div>
</div>
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
