
          
 <!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/actualizar_citas.css">

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
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Actualizar Cita</p>
                <span style="font-size: 14px;">Nº <?php echo $datos2['id']; ?></span>
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
                <div class="ant-descriptions-title">Información de la cita</div>
              </div>
              <div class="ant-descriptions-view">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                  <div>
                    <label>Formato de la cita:</label>
                    <input type="text" value="<?php echo $cita['formato_cita']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Fecha:</label>
                    <input type="text" value="<?php echo date_format(date_create($cita['fecha_cita']), 'd-m-Y'); ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>hora:</label>
                    <input type="text" value="<?php echo date_format(date_create($cita['fecha_cita']), 'g:i a'); ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Correo de Contacto:</label>
                    <input type="text" value="<?php echo $cita['correo']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Telefono de contacto:</label>
                    <input type="text" value="<?php echo $cita['telefono']; ?>" class="no-border" disabled>
                  </div>
                  <div>
                    <label>Estatus:</label>
                    <input type="text" value="<?php echo $cita['estado']; ?>" class="no-border" disabled>
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
                      <select name="id_formato_cita">
                          <option value="0" <?php echo ($cita['id_formato_cita'] == 0) ? 'selected' : ''; ?>>---Seleccione un Formato---</option>
                          <option value="1" <?php echo ($cita['id_formato_cita'] == 1) ? 'selected' : ''; ?>>Presencial</option>
                          <option value="2" <?php echo ($cita['id_formato_cita'] == 2) ? 'selected' : ''; ?>>Virtual</option>
                      </select>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label class="form-check-label text-left" for="pdf"><b>Agendar cita </b></label>
                        <input id="fecha_cita"  class="form-control w-100 fecha_cita"   type="text" placeholder="Seleccione una fecha y hora">
                    </div>

                  <div>
                    <label>Estatus</label>
                    <div class="control">
                      <div class="select">
                      <select name="id_estado">
                          <option value="0" <?php echo ($cita['id_estado'] == 0) ? 'selected' : ''; ?>>---Seleccione un Estatus---</option>
                          <option value="1" <?php echo ($cita['id_estado'] == 4) ? 'selected' : ''; ?>>CITA PAUTADA</option>
                          <option value="2" <?php echo ($cita['id_estado'] == 5) ? 'selected' : ''; ?>>CITA CANCELADA</option>
                          <option value="3" <?php echo ($cita['id_estado'] == 8) ? 'selected' : ''; ?>>CITA REPROGRAMADA</option>
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


<script>
  // Configuración del calendario
  flatpickr("#fecha_cita", {
    enableTime: true, // Habilitar selector de hora
    size: "compact", // Tamaño grande
    showMonths: 1, // Mostrar un mes
    showWeekNumbers: true, // Mostrar números de semana
    todayButton: "Hoy", // Texto del botón de hoy
    locale: {
      firstDayOfWeek: 1, // Lunes como primer día de la semana
      weekdays: {
        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
      },
      months: {
        shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
      }
    },
    onChange: function(selectedDates, dateStr, instance) {
      // Actualizar valor del input con la fecha y hora seleccionadas
      const fechaHora = instance.formatDate(selectedDates[0], "d-m-Y h:i K");
      document.getElementById("fecha_cita").value = fechaHora;
    },
    onClose: function(selectedDates, dateStr, instance) {
      // Actualizar valor del input con la fecha seleccionada al cerrar el calendario
      const fechaHora = instance.formatDate(selectedDates[0], "d-m-Y");
      document.getElementById("fecha_cita").value = fechaHora;
    }
  });

  // Evento click en el botón "Agendar"
  $('.agendar').on('click', function() {
    // Obtener la fecha y hora seleccionadas y mostrarlas en la consola
    const fechaHora = flatpickr("#fecha_cita").formatDate(flatpickr("#fecha_cita").selectedDates[0], "d-m-Y h:i K");
    console.log("Fecha y hora seleccionadas:", fechaHora);
    document.getElementById("fecha_cita").value = fechaHora;
  });
</script>

