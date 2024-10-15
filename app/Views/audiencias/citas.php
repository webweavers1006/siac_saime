<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/citas.css">


<?php
$session = session();
$userdata = $session->get();


?>   
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
    
        <?php
    if (isset($userdata['permisos']['permisos']) && in_array('citas.read', $userdata['permisos']['permisos'])) {
        $style = 'style="display: block;"';
    } else {
        $style = 'style="display: none;"';
        echo '<p style="padding-left: 500px; font-weight: bold;">No tiene permisos para visualizar las citas.</p>';
    }
    ?>
    <section class="section" <?php echo $style; ?>>
    <div class="row">
     
      <div class="col-md-12">
        <div class="form-steps">
          
        <!-- ******PASO1******* -->
        <div class="form-step form-step-active paso1" >
              <div class="columns is-multiline">
                  <?php foreach ($datos['citas'] as $cita) { ?>
                    
                      <div class="column is-3">
                             <?php
                              if (isset($userdata['permisos']['permisos']) && in_array('citas.update', $userdata['permisos']['permisos'])) {
                              ?>
                                <a href="/actualizar_citas/<?php echo $cita['id']; ?>" class="card-link" style="cursor: pointer;">
                              <?php
                              } else {
                              ?>
                                <a href="#" class="card-link" style="cursor: not-allowed; color: #ccc;">
                              <?php
                              }
                              ?>
                              <div class="card">
                                  <header class="card-header">
                                    
                                      <p class="card-header-title" style="font-weight: bold;">N°<?php echo $cita['id']; ?>
                                          <span style="float: right;">
                                              <i class="nav-icon fas fa-calendar" style="color: #003985; font-size: 20px;"></i>
                                          </span>
                                      </p>
                                  </header>
                                  <div class="card-content">
                                  <?php
                                    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                                    $dia = date('j', strtotime($cita['fecha_cita']));
                                    $mes = $meses[date('n', strtotime($cita['fecha_cita'])) - 1];
                                    $año = date('Y', strtotime($cita['fecha_cita']));
                                    echo '<p class="title is-4" style="font-weight: bold;">' . $dia . ' - ' . $mes . ' - ' . $año . '</p>';
                                    ?>
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

        <!-- ******PASO2******* -->

          <div class="form-step paso2" >
            <!-- Contenido del paso 2 -->
            
            <div class="card calendario">
         
                <div id="calendar"></div>
                <script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/calendario/index.global.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/calendario/index.global.min.js"></script>
                <style>
                #calendar .fc-event {
                  border-color: #ccc;
                  color: white;
                  
                }
                </style>
                <style>
                  #calendar .fc-event {
                      border-color: #ccc; /* Borde básico para todos los eventos */
                  }
                    /* Definir colores para diferentes estados */
                    .estado-5 {
                      background-color: red; /*  rojo Citas canceladas */
                  }

                  .estado-4 {
                      background-color: rgb(2, 67, 121);/*  azul Citas pautadas */
                  }

                  .estado-3 {
                      background-color: rgb(241, 233, 114); /* amarilla  Citas resueltas */
                  }

                  .estado-default {
                      
                      background-color: rgb(23, 84, 87); /* verde */
                  }
                </style>
                <?php
                $events = array();
                $max_date = null;
                $citasById = array(); // Crear un array asociativo para búsqueda eficiente
                foreach ($datos['citas'] as $cita) {
                    // Definir la clase CSS basada en el id_estado
                    $className = '';
                    switch ($cita['id_estado']) {
                        case 5:
                            $className = 'estado-5'; // Cita cancelada
                            break;
                        case 4:
                            $className = 'estado-4'; // Cita pautada
                            break;
                        case 3:
                            $className = 'estado-3'; // Cita resuelta
                            break;
                        default:
                            $className = 'estado-default'; // Clase por defecto si no coincide
                            break;
                    }

                    $event = array(
                        'title' => $cita['nombre'],
                        'id_estado' => $cita['id_estado'],
                        'start' => date('Y-m-d H:i:s', strtotime($cita['fecha_cita'])),
                        'end' => date('Y-m-d H:i:s', strtotime($cita['fecha_cita'])),
                        'className' => $className, // Añadir la clase CSS
                        'citaId' => $cita['id'], // Añadir un atributo separado para citaId
                    );
                    $events[] = $event;
                    $citasById[$cita['id']] = $cita; // Almacenar los detalles del evento en el array asociativo
                    if ($max_date === null || strtotime($cita['fecha_cita']) > strtotime($max_date)) {
                        $max_date = $cita['fecha_cita'];
                    }
                }
                $json_events = json_encode($events);
                ?>
                
          </div>
          </div>

          <!-- END FROND STEEP -->
        </div>
        </div>
      </div>
    </div>
    </section>
    
  </div>

  

</main>


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
          multiMonthMaxColumns: 2, // garantizar una sola columna
           //showNonCurrentDates: true,
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
  formSteps.forEach((formStep) => {
    formStep.style.opacity = 0; // Agrega esta línea para ocultar el paso del formulario
    formStep.style.pointerEvents = 'none'; // Agrega esta línea para deshabilitar los eventos de puntero
  });
  formSteps[idx].style.opacity = 1; // Agrega esta línea para mostrar el paso del formulario actual
  formSteps[idx].style.pointerEvents = 'auto'; // Agrega esta línea para habilitar los eventos de puntero
  if (idx === 1) { // Si estamos en el paso 2
    document.querySelector('.paso2 .card.calendario').style.display = 'block'; // Muestra el contenido del paso 2
  }
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

