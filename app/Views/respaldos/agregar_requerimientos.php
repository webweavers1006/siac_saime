<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/citas.css">
<main>
  <div class="container">
    <br>
    <form action="#" class="form">
      <h4 class="text-center">Control de Citas</h4>
      <div class="progressbar">
        <div class="progress" id="progress"></div>
        <div class="progress-step progress-step-active" data-title="Citas Listas"></div>
        <div class="progress-step" data-title="Calendario"></div>
      </div>
    </form>
    <br>
    <section class="section">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-11">
        <div class="form-steps">
          <div class="form-step form-step-active">
              <div class="columns is-multiline">
                  <?php foreach ($datos['citas'] as $cita) { ?>
                      <div class="column is-3">
                          <a href="/appointments/edit/<?php echo $cita['id']; ?>" class="card-link" style="cursor: pointer;">
                              <div class="card">
                                  <header class="card-header">
                                      <p class="card-header-title" style="font-weight: bold;">N°<?php echo $cita['id']; ?>
                                          <span style="float: right;">
                                              <i class="nav-icon fas fa-calendar" style="color: #003985; font-size: 20px;"></i>
                                          </span>
                                      </p>
                                  </header>
                                  <div class="card-content">
                                      <p class="title is-4" style="font-weight: bold;"><?php echo date('F jº Y', strtotime($cita['fecha_cita'])); ?></p>
                                      <p class="subtitle is-6"><?php echo date('h:i A', strtotime($cita['fecha_cita'])); ?></p>
                                      <div class="content_2">
                                          <p><?php echo $cita['nombre']; ?></p>
                                          <p><?php echo $cita['formato_cita']; ?></p>
                                      </div>
                                  </div>
                              </div>
                          </a>
                      </div>
                  <?php } ?>
              </div>
          </div>


          <div class="form-step">
            <!-- Contenido del paso 2 -->
            <div class="card calendario">
                <div id="calendar"></div>
                <script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/calendario/index.global.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/calendario/index.global.min.js"></script>
                <?php
                $events = array();
                $max_date = null;
                $citasById = array(); // Create an associative array for efficient lookup

                foreach ($datos['citas'] as $cita) {
                    $event = array(
                        'title' => $cita['nombre'],
                        'start' => date('Y-m-d H:i:s', strtotime($cita['fecha_cita'])),
                        'end' => date('Y-m-d H:i:s', strtotime($cita['fecha_cita'])),
                        //'url' => '/appointments/edit/' . $cita['id'],
                        'citaId' => $cita['id'], // Add a separate attribute for citaId
                    );
                    $events[] = $event;
                    $citasById[$cita['id']] = $cita; // Store the event details in the associative array
                    if ($max_date === null || strtotime($cita['fecha_cita']) > strtotime($max_date)) {
                        $max_date = $cita['fecha_cita'];
                    }
                }
                $json_events = json_encode($events);
                ?>
                  <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      var calendarEl = document.getElementById('calendar');

                      var calendar = new FullCalendar.Calendar(calendarEl, {
                        locale: 'es',
                        headerToolbar: {
                          left: 'prev,next today',
                          center: 'title',
                          right: 'multiMonthYear,dayGridMonth,timeGridWeek'
                        },
                        themeSystem: 'bootstrap',
                        initialView: 'multiMonthYear',
                        initialDate: '<?php echo date('Y-m-d H:i:s', strtotime($max_date)); ?>', // Formateado la fecha para que sea compatible con FullCalendar
                        editable: true,
                        selectable: true,
                        dayMaxEvents: true, // permitir enlace "más" cuando hay demasiados eventos
                        // multiMonthMaxColumns: 1, // garantizar una sola columna
                        // showNonCurrentDates: true,
                        fixedWeekCount: false,
                        businessHours: true,
                        weekends: false,
                        buttonText: {
                          today: 'Hoy',
                          month: 'Mes',
                          year: 'Año',
                          week: 'Semana',
                          day: 'Día',
                          list: 'Lista'
                        },

                          events: <?php echo $json_events; ?>,

                          eventClick: function(event) {
                      var citaId = event.event.extendedProps.citaId;
                      var citaInfo = <?php echo json_encode($citasById); ?>[citaId];
                      var startDate = moment(event.event.start).format('DD MMM YYYY'); // Format the start date

                      alert('Evento: ' + event.event.title + '\n' +
                            'Fecha de inicio: ' + startDate + '\n' + 
                            'Formato de cita: ' + citaInfo.formato_cita);
                  }
                      });

                      calendar.render();
                  });
                  </script>


          </div>
          </div>
        </div>
      </div>
    </div>
    </section>
    
  </div>

  

</main>

<script>
  const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");
let currentIdx = 0;

function init() {
  // Inicializar el estado del formulario y la barra de progreso
  updateFormSteps(0);
  updateProgressbar(0);
}

init();

progressSteps.forEach((progressStep) => {
  progressStep.addEventListener("click", (event) => {
    const idx = Array.prototype.indexOf.call(progressSteps, event.target);
    updateFormSteps(idx);
    updateProgressbar(idx);
  });
});

function updateFormSteps(idx) {
  formSteps.forEach((formStep) => formStep.classList.remove("form-step-active"));
  formSteps[idx].classList.add("form-step-active");
  currentIdx = idx;
}

function updateProgressbar(idx) {
  const progressStep = progressSteps[idx];
  const progressWidth = progressStep.offsetLeft + progressStep.offsetWidth;
  progress.style.width = progressWidth + "px";
}

function validateFormStep(idx) {
  // Validar el formulario en el paso actual
  // Si la validación falla, mostrar un mensaje de error y no permitir que el usuario avance
  // Si la validación es exitosa, permitir que el usuario avance al siguiente paso
}
</script>
<script src="<?php echo base_url(); ?>/theme/plugins/jquery/jquery.js"></script>
<script src="<?php echo base_url(); ?>/js_paginas/adminlte.js"></script>


<script src = "<?php echo base_url(); ?>/theme/plugins/bootstrap/js/bootstrap.bundle.min.js" ></script>
<script src="<?php echo base_url(); ?>/theme/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>/theme/plugins/moment/moment.min.js"></script>

