
listar_tipo_cierres();
// Para recuperar el objeto de almacenamiento local
const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));



$('#observaciones').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  // Obtener la fecha y hora seleccionadas
  let mensaje = document.getElementById("mensaje_observacion").value;
  let id_solicitud = document.getElementById("id_solicitud").value;
  let id_opcion = document.getElementById("id_opcion").value;
  let id_usuario = user_audiencia.id;
 
   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = 
   {
    mensaje: mensaje,
    id_solicitud: id_solicitud,
    id_usuario: id_usuario,
    id_opcion: id_opcion,
 
  };

//AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "POST",
  url: `https://siac.sapi.gob.ve/api/audiencia/mensajes`,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
  headers: {
    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
  },
    success: function(response) 
    
    {
      Swal.fire({
        icon: "success",
        type: 'success',
        html: '<strong>REGISTRO EXITOSO!!!'+ '</strong>',
        toast: true,
        position: "center",
        showConfirmButton: false,
        //timer: 3500,
    });
    setTimeout(function() {
      window.location = '/detalles_solicitudes/'+id_solicitud;
    }, 1500);
    
        
      }
    });   


});



$('#responsable').on('click', function() {
  // Obtener la fecha y hora seleccionadas
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
 
  let id_solicitud = document.getElementById("id_solicitud").value;
  
  let id_trabajador = document.getElementById("id_trabajador").value;
 
   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = 
   {
    id_trabajador: id_trabajador,
  };

//AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "PUT",
  url: `https://siac.sapi.gob.ve/api/audiencia/solicitudes/`+id_solicitud,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
  headers: {
    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
  },
  success: function(response) 
  
  {

    Swal.fire({
      icon: "success",
      type: 'success',
      html: '<strong>REGISTRO ACTUAIZADO!!!'+ '</strong>',
      toast: true,
      position: "center",
      showConfirmButton: false,
      //timer: 3500,
  });
  setTimeout(function() {
    window.location = '/detalles_solicitudes/'+id_solicitud;
  }, 1500);
  
     
    

      
    }
      });   


});


$('#cierre_solicitud').on('click', function() {
  // Obtener la fecha y hora seleccionadas
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
const respuesta = document.getElementById("respuesta").value;
const id_solicitud = document.getElementById("id_solicitud").value;
const id_estado = 7;

const cierre = document.getElementById("cierre").value;
const id_condicion = $("#id_condicion").is(':checked');
const id_categoria_original = $("#id_categoria_original").val();

let audienceData; // Cambié a let porque se asigna en dos lugares diferentes

if (id_condicion) {

 if (cierre==0 || cierre=='0') 
  {
    alert('Debe seleccionar el Tipo de cierre');
  }
  else
  {
    audienceData = 
    {
      respuesta: respuesta,
      id_estado: id_estado,
      // CATEGORIA NUEVA
      id_categoria_cierre: cierre,
    };

  }
    
} else {
    // DATOS PARA EL USUARIO EN AUDIENCIAS
    audienceData = {
        respuesta: respuesta,
        id_estado: id_estado,
        // CATEGORIA ORIGINAL
        id_categoria_cierre: id_categoria_original,
    };
}



  // Mostrar SweetAlert para confirmar la acción
  Swal.fire({
    title: '¿Está seguro?',
    text: "¿Desea cerrar la solicitud?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.value) {
  
      // Si el usuario confirma, se ejecuta el AJAX
      $.ajax({
        type: "PUT",
        url: `https://siac.sapi.gob.ve/api/audiencia/solicitudes/` + id_solicitud,
        data: JSON.stringify(audienceData),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(response) {
          Swal.fire({
            icon: "success",
            title: 'SOLICITUD CERRADA!!!',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 1500,
          });
          setTimeout(function() {
            window.location = '/detalles_solicitudes/' + id_solicitud;
          }, 1500);
        },
        error: function(xhr, status, error) {
          // Manejo de errores
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al cerrar la solicitud.',
          });
        }
      });
    } else {
     
    }
  });
});

function listar_tipo_cierres() {
  let id_area = parseInt($('#id_area').val(), 10); // Convertir a número
  //console.log("ID Área:", id_area);
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = `https://siac.sapi.gob.ve/api/audiencia/categorias`;

  // Realiza la solicitud AJAX
  $.ajax({
      url: url,
      method: "get",
      dataType: "json",
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
      },
      beforeSend: function() {
          // Puedes agregar un loader aquí si lo deseas
      },
      success: function(response) {
          const categorias = response.categorias; // Accede al array de categorías
          const $select = $('#cierre'); // Selecciona el elemento <select>

          // Limpia las opciones existentes en el <select>
          $select.empty();

          // Agrega una opción por defecto (opcional)
          $select.append('<option value="0" selected disabled>--------------------Tipo de Cierre--------------------</option>');

          // Filtrar las categorías por id_area (que ahora debe ser igual a id_departamento)
          const categoriasFiltradas = categorias.filter(categoria => {
              return id_area === categoria.id_departamento; // Comparación
          });

          //console.log("Categorías Filtradas:", categoriasFiltradas); // Verifica las categorías filtradas

          // Recorre el array de categorías filtradas y agrega las opciones al <select>
          categoriasFiltradas.forEach(categoria => {
              $select.append(`<option value="${categoria.id}">${categoria.categoria}</option>`);
          });
      },
      error: function(xhr, status, error) {
          console.error("Error:", error);
          console.error("Detalles:", xhr.responseText);
      }
  });
}

 
$("#id_condicion").on('click', function() {

  let id_condicion = $(this).is(':checked');

  if (id_condicion) {

      // El checkbox está marcado

      $(".cierre").show();

  } else {

      // El checkbox no está marcado

      $(".cierre").hide();

  }});