
// Seleccionar todos los checkbox
// document.getElementById('selectAll').addEventListener('click', function() {
//     var checkboxes = document.getElementsByName('select[]');
//     for (var i = 0; i < checkboxes.length; i++) {
//       checkboxes[i].checked = this.checked;
//     }
//   });





// LINK DE LOS NUMEROS DE SOLICITUDES
$('#table_audiencia tbody a').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
   
    window.location = '/detalles_solicitudes/' + id;
    
    });


// Obtener el select, el botón y los checkboxes
const selectElement = document.querySelector('select[name="id_trabajador"]');
const remitirButton = document.getElementById('remitir');
const checkboxes = document.getElementsByName('select[]');
const selectAllCheckbox = document.getElementById('selectAll');
// Agregar un evento al checkbox "select all"
selectAllCheckbox.addEventListener('click', function() {
  // Alternar el estado de los checkboxes
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = this.checked;
  }
  // Verificar si al menos un checkbox está seleccionado
  const alMenosUnoSeleccionado = Array.prototype.some.call(checkboxes, (checkbox) => checkbox.checked);
  // Habilitar o deshabilitar el select y el botón
  selectElement.disabled = !alMenosUnoSeleccionado;
 remitirButton.disabled = !alMenosUnoSeleccionado;
});

// Agregar un evento a cada checkbox
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('click', function() {
    const alMenosUnoSeleccionado = Array.prototype.some.call(checkboxes, (checkbox) => checkbox.checked);
    selectElement.disabled = !alMenosUnoSeleccionado;
    remitirButton.disabled = !alMenosUnoSeleccionado;
  });
});


// Configuración del calendario
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
  time_24hr: true, // Deshabilitar selección de AM/PM
  minTime: "00:00", // Establecer la hora mínima en 00:00
  defaultHour: 0, // Establecer la hora predeterminada en 0
  defaultMinute: 0, // Establecer el minuto predeterminado en 0
  onChange: function(selectedDates, dateStr, instance) {
    // Actualizar valor del input con la fecha y hora seleccionadas
    const fechaHora = instance.formatDate(selectedDates[0], "d-m-Y H:i"); // Utilizar H:i para formato de 24 horas
    document.getElementById("fecha_cita").value = fechaHora;
  },
  onClose: function(selectedDates, dateStr, instance) {
    // Actualizar valor del input con la fecha seleccionada al cerrar el calendario
    const fechaHora = instance.formatDate(selectedDates[0], "d-m-Y H:i"); // Utilizar H:i para formato de 24 horas
    document.getElementById("fecha_cita").value = fechaHora;
  }
});

// Evento click en el botón "Agendar"
$('.agendar').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  // Obtener la fecha y hora seleccionadas
  var fecha_cita = document.getElementById("fecha_cita").value;
  var fecha_cita_array = fecha_cita.split(" ");
  var fecha_array = fecha_cita_array[0].split("-");
  var hora_array = fecha_cita_array[1].split(":");
  var fecha = new Date(fecha_array[2], fecha_array[1] - 1, fecha_array[0], hora_array[0], hora_array[1], 0);
  fecha_cita=(fecha.getFullYear() + '-' + (fecha.getMonth() + 1).toString().padStart(2, '0') + '-' + fecha.getDate().toString().padStart(2, '0') + ' ' + fecha.getHours().toString().padStart(2, '0') + ':' + fecha.getMinutes().toString().padStart(2, '0') + ':' + fecha.getSeconds().toString().padStart(2, '0'));
  document.getElementById("fecha_cita").value = fecha.getFullYear() + '-' + (fecha.getMonth() + 1).toString().padStart(2, '0') + '-' + fecha.getDate().toString().padStart(2, '0') + ' ' + fecha.getHours().toString().padStart(2, '0') + ':' + fecha.getMinutes().toString().padStart(2, '0') + ':' + fecha.getSeconds().toString().padStart(2, '0');


   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = {
    id_requerimiento: $("#id_requerimiento").val(),
    id_estado: 4,
    id_formato_cita: $("#id_formato_cita").val(),
    fecha_cita: fecha_cita,
 
};


// AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "POST",
  url: `https://siac.sapi.gob.ve/api/audiencia/citas`,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
      headers: {

        'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

      },  
  success: function(response) 
  
  {
    
      Swal.fire('Exito!', "REGISTRO EXITOSO", "success");
      $("#editUser").modal('hide');
      $("button[type=submit]").removeAttr('disabled');
      setTimeout(function() {
      window.location = '/citas/';
      }, 1500);
      
      
    }
      });   


});

$('#remitir').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  let id_trabajador=$("#id_trabajador").val();
  let id_requerimiento=$("#id_requerimiento").val();
  const selectedIds = [];
  $('input.checkbox-status:checked').each(function() {
    var id = $(this).closest('tr').find('td:eq(4)').text(); // Get the ID from the hidden TD
    selectedIds.push(id);
  });

  // DATOS PARA EL USUARIO EN AUDIENCIAS
  const audienceData = {
    id_trabajador: id_trabajador,
  };

  // Iterate through each selected ID and make an AJAX request
  selectedIds.forEach((id) => {
    $.ajax({
      type: "PUT",
      url: `https://siac.sapi.gob.ve/api/audiencia/solicitudes/${id}`,
      data: JSON.stringify(audienceData),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
      },
      success: function(response) {
        Swal.fire('Exito!', "REGISTRO EXITOSO", "success");
        setTimeout(function() {
          window.location = '/detalles_requerimientos/'+id_requerimiento;
        }, 1500);
      }
    });
  });
});