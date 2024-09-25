<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/detalles_solicitudes.css">
<!-- Contenedor principal -->
<div class="content-wrapper">
  <main class="content">
    <!-- Tarjeta principal -->
    <div class="container-fluid">
      <br>

<!-- **************************************CABESERA************************************ -->
      <div class="row justify-content-center">
        <div class="col-lg-12 custom-col-width">
          <div class="card card_table audiencia" style="max-width: 1350px; margin: 20px auto;">
            <div class="d-flex align-items-center">
              <img src="<?php echo base_url(); ?>/img/favicon.jpg" style="width: 30px; height: 30px;">
              <div class="ml-2">
                <span style="font-size: 18px; font-weight: bold;">Solicitud</span>
                <p class="mb-0"><?php echo $datos['num_solicitud']; ?></p>
              </div>
            </div>
            <div class="row mb-0">
              <div class="col-sm-8">
                <label  class="has-text-weight-semibold">Categoria-</label>
                <?php echo $datos['categoria']; ?>
              </div>
              <div class="col-sm-4">
                <label  class="has-text-weight-semibold">Descripción-</label>
                <?php echo $datos['descripcion']; ?>
              </div> 
            </div>
            <div class="row">
            <div class="col-10">
              </div>
              <div class="is-fixed bottom-1 ">
                <a href="/actualizar_solicitud/<?php echo $datos['id'];?>">
                  <div class="box is-pointer has-background-blue helper-button  edicion">
                    <span class="icon is-small is-right has-text-white circle-icon">
                      <i class="material-icons" style='font-size:27px'>create</i>
                    </span>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
 <!-- *********************************************************************************** -->

<!-- **************************************MENSAJES************************************ -->
<section class="mensajes" style="margin-left: 63px;">
  <div class="row justify-content-center">
    <div class="col-lg-12 custom-col-width">
      <div class="card card_table" style="max-width: 1350px; margin: 20px auto;">
        <div class="row">
          <div class="col-lg-6" style="display: inline-block; width: 49%;">
            <h2>SOLICITUD DE CITA</h2>
            <table class="table table-striped ant-alert-info">
              <thead>
                <tr>
                  <th>Texto</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($mensajes['mensajes'] as $mensaje) { ?>
                <?php if ($mensaje['opcion'] == 'SOLICITUD DE CITA') { ?>
                <tr>
                  <td><?= $mensaje['mensaje'] ?></td>
                  <td>
                    <button class="eliminar-btn" onclick="eliminarMensaje(<?= $mensaje['id']; ?>)">
                      <i class="fa fa-times"></i>
                    </button>
                  </td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="col-lg-6" style="display: inline-block; width: 49%;">
            <h2>OBSERVACION INTERNA</h2>
            <table class="table table-striped ant-alert-success">
              <thead>
                <tr>
                  <th>Texto</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($mensajes['mensajes'] as $mensaje) { ?>
                <?php if ($mensaje['opcion'] == 'OBSERVACION INTERNA') { ?>
                <tr>
                  <td><?= $mensaje['mensaje'] ?></td>
                  <td>
                    <button class="eliminar-btn" onclick="eliminarMensaje(<?= $mensaje['id']; ?>)">
                      <i class="fa fa-times"></i>
                    </button>
                  </td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <!-- *********************************************************************************** -->

 <!-- ********************************ESTATUS DE LA SOLICITU (CERRADO)************************************ -->
          <?php
              if ($datos['estado'] == 'RESUELTA') {
              ?>   
              <div class="row justify-content-center">
                <div class="col-lg-12 custom-col-width">
                  <div class="card card_table audiencia" style="max-width: 1350px; margin: 20px auto;">                         
                  <div class="box">
                  <br>
                    <div class="ant-result ant-result-success css-2i2tap">
                      <div class="ant-result-icon">
                        <span role="img" aria-label="check-circle" class="anticon anticon-check-circle">
                          <svg viewBox="64 64 896 896" focusable="false" data-icon="check-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm193.5 301.7l-210.6 292a31.8 31.8 0 01-51.7 0L318.5 484.9c-3.8-5.3 0-12.7 6.5-12.7h46.9c10.2 0 19.9 4.9 25.9 13.3l71.2 98.8 157.2-218c6-8.3 15.6-13.3 25.9-13.3H699c6.5 0 10.3 7.4 6.5 12.7z"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="ant-result-title">Esta solicitud se ha cerrado</div>
                      <div class="ant-result-content">
                        <div class="desc">
                          <div class="ant-typography css-2i2tap">
                            <span class="ant-typography css-2i2tap" style="font-size: 16px;">
                              <strong>Esta solicitud tiene un observacion de cierre</strong>
                            </span>
                          </div>
                          <div class="ant-typography css-2i2tap">
                            <span role="img" aria-label="close-circle" class="anticon anticon-close-circle site-result-demo-error-icon">
                              <svg fill-rule="evenodd" viewBox="64 64 896 896" focusable="false" data-icon="close-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <path d="M512 64c247.4 0 448 200.6 448 448S759.4 960 512 960 64 759.4 64 512 264.6 64 512 64zm0 76c-205.4 0-372 166.6-372 372s166.6 372 372 372 372-166.6 372-372-166.6-372-372-372zm128.01 198.83c.03 0 .05.01.09.06l45.02 45.01a.2.2 0 01.05.09.12.12 0 010 .07c0 .02-.01.04-.05.08L557.25 512l127.87 127.86a.27.27 0 01.05.06v.02a.12.12 0 010 .07c0 .03-.01.05-.05.09l-45.02 45.02a.2.2 0 01-.09.05.12.12 0 01-.07 0c-.02 0-.04-.01-.08-.05L512 557.25 384.14 685.12c-.04.04-.06.05-.08.05a.12.12 0 01-.07 0c-.03 0-.05-.01-.09-.05l-45.02-45.02a.2.2 0 01-.05-.09.12.12 0 010-.07c0-.02.01-.04.06-.08L466.75 512 338.88 384.14a.27.27 0 01-.05-.06l-.01-.02a.12.12 0 010-.07c0-.03.01-.05.05-.09l45.02-45.02a.2.2 0 01.09-.05.12.12 0 01.07 0c.02 0 .04.01.08.06L512 466.75l127.86-127.86c.04-.05.06-.06.08-.06a.12.12 0 01.07 0z"></path>
                              </svg>
                            </span> <?php echo $datos['respuesta']; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  <?php
                  }  // Cierra el if

                  ?>
 <!-- *********************************************************************************** --> 


<!-- ***********************INFORMACION EMPRESA O BUFETE **************************** -->
      <section class="section" style="margin-left: 63px;">
        <div class="row">
          <div class="col-lg-7">
            <div class="card card_table">
              <div class="card-body p-3">
                <div class="box">
                  <div class="ant-descriptions css-2i2tap">
                    <div class="ant-descriptions-header">
                      <div class="has-text-weight-semibold">Informacion</div>
                    </div>
                    <div class="ant-descriptions-view">
                      <table class="my-table w-100">
                        <tbody>
                          <tr>
                            <td style="font-size: 13px; font-weight: bold;"><strong>Nombre:</strong></td>
                            <td><?php echo $info_empresa_y_titulares['nombre']; ?></td>
                          </tr>
                          <tr>
                            <td style="font-size: 13px; font-weight: bold;"><strong>Estatus:</strong></td>
                            <td><?php echo $info_empresa_y_titulares['nombre_categoria']; ?></td>
                          </tr>
                          <tr>
                            <td style="font-size: 13px; font-weight: bold;"><strong>Nro Poder:</strong></td>
                            <td><?php echo $info_empresa_y_titulares['poder']; ?></td>
                          </tr>
                          <tr>
                            <td style="font-size: 13px; font-weight: bold;"><strong>Nro Registro:</strong></td>
                            <td><?php echo $info_empresa_y_titulares['registro']; ?></td>
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
 <!-- *********************************************************************************** --> 

 <!-- ***********************INFORMACION TITULARES **************************** -->

    <div class="row">
    <div class="col-lg-7">
        <div class="card card_table">
            <div class="card-body p-3">
                <div class="box">
                    <div class="ant-descriptions css-2i2tap">
                        <div class="ant-descriptions-header">
                            <div   class="has-text-weight-semibold">Información Titulares</div>
                        </div>
                        <div class="ant-descriptions-view">
                            <table class="my-table w-100">
                                <tbody>
                                    <tr>
                                        <td  style="font-size: 13px; font-weight: bold;"><strong>Nombre Titular:</strong></td>
                                        <td><?php echo $info_empresa_y_titulares['titulares'][7]; ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="font-size: 13px; font-weight: bold;"><strong>Identificación Titular:</strong></td>
                                        <td><?php echo $info_empresa_y_titulares['titulares']["identificacion"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="font-size: 13px; font-weight: bold;"><strong>Correo Titular:</strong></td>
                                        <td><?php echo $info_empresa_y_titulares['titulares']["email"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td  style="font-size: 13px; font-weight: bold;"><strong>Teléfono Titular:</strong></td>
                                        <td><?php echo $info_empresa_y_titulares['titulares']["telefono1"]; ?>&nbsp;<?php echo $info_empresa_y_titulares['titulares']["telefono2"]; ?></td>
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
 <!-- *********************************************************************************** --> 

<style>
.my-table {
  border-collapse: collapse;
  font-size: 12px; /* Reduce la fuente a 12px */
}

.my-table td {
  padding: 5px; /* Reduce el espaciado entre celdas a 5px */
}

.my-table td:first-child {
  font-weight: bold;
  width: 30%;
}
.my-table td {
  padding: 5px; /* Reduce el espaciado entre celdas a 5px */
  border: none; /* o border: transparent; */
}
</style>
         
 <!-- LINEA DEL TIEMPO     -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>   
 <?php
// Obtener los años de los datos
$años = array();
foreach ($cronologia["solicitudes"] as $dato) {
    $año = date("Y", strtotime($dato["fecha"]));
    if (!in_array($año, $años)) {
        $años[] = $año;
    }
}


?>

 <!-- ***********************LINEA DE TIEMPO **************************** -->
      <section>
        <div class="row">
            <div class="col-lg-7">
                <div class="card card_table">
                    <div class="card-body">
                        <h2>Línea del Tiempo</h2>
                        <div id="timeline">
                          <?php
                          // Recorrer los años
                          foreach ($años as $año) {
                              ?>
                              <div class="row timeline-movement timeline-movement-top">
                                  <div class="timeline-badge timeline-future-movement">
                                      <p><?php echo $año; ?></p>
                                  </div>
                              </div>

                              <?php
                              // Recorrer los eventos del año
                              $contador = 0;
                              foreach ($cronologia["solicitudes"] as $dato) {
                                  if (date("Y", strtotime($dato["fecha"])) == $año) {
                                      $contador++;
                                      $clase = ($contador % 2 == 0) ? 'center-right' : 'center-left';
                                      $offset = ($contador % 2 == 0) ? 'offset-sm-6' : '';
                                      $animacion = ($contador % 2 == 0) ? 'fadeInRight' : 'fadeInLeft';
                                      $panel_clase = ($contador % 2 == 0) ? 'debits' : 'credits';
                                      ?>

                                  <!-- Evento -->
                                  <div class="row timeline-movement">
                                      <div class="timeline-badge <?= $clase ?> evento-fondo"></div>
                                      <div class="<?= $offset ?> col-sm-6 timeline-item">
                                          <div class="row">
                                              <div class="col-sm-11">
                                                  <div class="timeline-panel <?= $panel_clase ?> anim animate <?= $animacion ?>">
                                                      <ul class="timeline-panel-ul">
                                                          <li>
                                                              <p class="fecha">
                                                                  <i class="glyphicon glyphicon-time" aria-label="Fecha"></i> 
                                                                  <b><?= date("d-m-Y", strtotime($dato["fecha"])) ?></b>
                                                              </p>
                                                          </li>

                                                          <li>
                                                              <span class="crono"><?= $dato["crono"] ?></span>
                                                          </li>
                                                          <li>
                                                              <span class="causale nombre"><?= $dato["nombre"] ?></span>
                                                          </li>
                                                          <li>
                                                              <span class="causale trabajador"><?= $dato["trabajador"] ?></span>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                      <?php
                                  }
                              }
                          }
                          ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
 <!-- *********************************************************************************** --> 

<!-- ***********************************SECCION CARD RESONSABLE ****************************************** --> 
      <section class="section_card">
        <!-- Tarjeta Lateral -->
        <div class="col-lg-3  card_lateral">
          <div class="row">
            <div class="col-12">
              <div class="card citas">
                <div class="card-body" style="padding-left: 10px;">
                  <div class="box">
                    <div class="field">
                      <label class="label">Responsable</label>
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
                    <div class="field" style="margin-top: 20px;">
                      <div class="control">
                        <button type="button" class="ant-btn css-2i2tap ant-btn-default button is-primary is-fullwidth">
                          <span>Asignar responsable</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card cierre_solicitud">
                <div class="card-body">
                  <div class="column is-12">
                    <p  class="has-text-weight-semibold mb-2">Cierre solicitud</p>
                    <textarea class="textarea" name="respuesta" style="margin-top: 0;"></textarea>
                    <div class="control" style="margin-top: 20px;">
                      <button type="button" class="ant-btn css-2i2tap ant-btn-default button is-primary is-fullwidth">
                        <span>Cerrar solicitud</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card cierre_solicitud">
                <div class="card-body">
                  <div class="column is-12">
                    <div class="box">
                      <div class="field">
                        <div class="control">
                          <p  class="has-text-weight-semibold">Observaciones</p>
                          <textarea class="textarea" name="mensaje"></textarea>
                        </div>
                      </div>
                      <div class="field" style="margin-top: 20px;">
                        <div class="control">
                          <div class="select">
                            <select name="id_opcion">
                              <option value="0">---Seleccione un tipo de mensaje---</option>
                              <option value="1">SOLICITUD DE CITA</option>
                              <option value="3">OBSERVACION INTERNA</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="field" style="margin-top: 20px;">
                        <div class="control">
                          <button class="button is-primary is-fullwidth">Enviar Mensaje</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
 <!-- *********************************************************************************** --> 
</mail>
</div>
</div>





<script>
  /**********************Scroll Animation "START"************************************/
$(document).ready(function(){
var $animation_elements = $('.anim');
var $window = $(window);

function check_if_in_view() {
var window_height = $window.height();
var window_top_position = $window.scrollTop();
var window_bottom_position = (window_top_position + window_height);

$.each($animation_elements, function() {
var $element = $(this);
var element_height = $element.outerHeight();
var element_top_position = $element.offset().top;
var element_bottom_position = (element_top_position + element_height);

//check to see if this current container is within viewport
if ((element_bottom_position >= window_top_position) &&
(element_top_position <= window_bottom_position)) {
$element.addClass('animated');
} else {
$element.removeClass('animated');
}
});
}

$window.on('scroll resize', check_if_in_view);
$window.trigger('scroll');
});
/**********************Scroll Animation "END"************************************/

/**********************Change color of center aligned animated content small Circle  "START"************************************/
$(document).ready(function(){
    $(" .debits").hover(function(){
        $(" .center-right").css("background-color", "#4997cd");
        }, function(){
        $(" .center-right").css("background-color", "#fff");
    }); 
});
$(document).ready(function(){
    $(".credits").hover(function(){
        $(".center-left").css("background-color", "#4997cd");
        }, function(){
        $(".center-left").css("background-color", "#fff");
    }); 
});
/**********************Change color of center aligned animated content small Circle  "END"************************************/
</script>


<script>
  function eliminarMensaje(id) {
    console.lo(id);
    // Aquí puedes agregar la lógica para eliminar el mensaje
    // Por ejemplo, puedes hacer una petición AJAX para eliminar el mensaje
    // $.ajax({
    //     type: 'POST',
    //     url: 'eliminar-mensaje.php',
    //     data: {id: id},
    //     success: function() {
    //         // Eliminar el elemento de la marquesina
    //         $('#marquesina-item-' + id).remove();
    //     }
    // });
}
</script>