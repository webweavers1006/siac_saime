

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
$('.actualizar').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  // Obtener la fecha y hora seleccionadas
  var fecha_cita = document.getElementById("fecha_cita").value;
  if (fecha_cita==''||fecha_cita==null) 
    {
      alert('DEBE SELECIONAR LA FECHA Y HORA DE LA CITA ') ;
    
    }else
    {
      var fecha_cita_array = fecha_cita.split(" ");
      var fecha_array = fecha_cita_array[0].split("-");
      var hora_array = fecha_cita_array[1].split(":");
      var fecha = new Date(fecha_array[2], fecha_array[1] - 1, fecha_array[0], hora_array[0], hora_array[1], 0);
      fecha_cita=(fecha.getFullYear() + '-' + (fecha.getMonth() + 1).toString().padStart(2, '0') + '-' + fecha.getDate().toString().padStart(2, '0') + ' ' + fecha.getHours().toString().padStart(2, '0') + ':' + fecha.getMinutes().toString().padStart(2, '0') + ':' + fecha.getSeconds().toString().padStart(2, '0'));
      document.getElementById("fecha_cita").value = fecha.getFullYear() + '-' + (fecha.getMonth() + 1).toString().padStart(2, '0') + '-' + fecha.getDate().toString().padStart(2, '0') + ' ' + fecha.getHours().toString().padStart(2, '0') + ':' + fecha.getMinutes().toString().padStart(2, '0') + ':' + fecha.getSeconds().toString().padStart(2, '0');

      let numero_cita=$("#numero_cita").val();
      // DATOS PARA EL USUARIO EN AUDIENCIAS
      const audienceData = {
      
        id_estado: $("#id_estado").val(),
        id_formato_cita: $("#id_formato_cita").val(),
        fecha_cita: fecha_cita,
    
        };

       // console.log(audienceData);
          // // ACTUALIZO LOS DATOS EN AUDIENCIA
        $.ajax({
          type: "PUT",
          url: `https://siac.sapi.gob.ve/api/audiencia/citas/`+numero_cita,
          data: JSON.stringify(audienceData),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          headers: {

            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
    
          },  
          success: function(response) 
          
          
          {
            
            Swal.fire('Exito!', "REGISTRO ACTUALIZADO", "success");
            $("#editUser").modal('hide');
            $("button[type=submit]").removeAttr('disabled');
            setTimeout(function() {
            window.location = '/citas/';
            }, 1500);
            
            
          }
            });   



          }


});