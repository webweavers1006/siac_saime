
let id_estado=$('#edit_id_estado').val();
let id_municipio = parseFloat($('#id_municipio').val());
let id_parroquia = parseFloat($('#id_parroquia').val());




llenar_Municipios(Event,id_estado,id_municipio);
llenar_Parroquias(Event,id_municipio,id_parroquia);


// FUNCION PARA LLENAR EL COMBO DE MUNICIPIOS
function llenar_Municipios(e, id_estado, id_municipio) {
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    const url = `http://172.16.0.46:70/municipios/byEstado/${id_estado}`;


    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}`
        },
        success: function(response) {
            const municipios = response.municipioss; // Asegúrate de que la propiedad sea correcta
            const selectMunicipio = $("#municipio-select");
            selectMunicipio.empty();

            // Verificar si hay municipios antes de iterar
            if (municipios && municipios.length > 0) {
                municipios.forEach(municipio => {
                    const option = new Option(municipio.municipio, municipio.id);
                    if (municipio.id === id_municipio) {
                        option.selected = true;
                    }
                    selectMunicipio.append(option);
                });
            } else {
                // Si no hay municipios, puedes mostrar un mensaje o una opción por defecto
                selectMunicipio.append('<option value="">No hay municipios disponibles</option>');
            }
  
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los municipios:', error);
        }
    });
}


function llenar_Parroquias(e, id_municipio, id_parroquia) {

    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    const url = `http://172.16.0.46:70/parroquias/byMunicipio/${id_municipio}`;

    $.ajax({
        url: url,
        method: "get",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}`
        },
        success: function(response) {
            const parroquias = response.parroquiass;
            const selectParroquia = $("#parroquia-select");

            selectParroquia.empty();

            // Verificar si hay parroquias antes de iterar
            if (parroquias.length > 0) {
                parroquias.forEach(parroquia => {
                    const option = new Option(parroquia.parroquia, parroquia.id);
                    if (parroquia.id === id_parroquia) {
                        option.selected = true;
                    }
                    selectParroquia.append(option);
                });
            } else {
                // Si no hay parroquias, puedes mostrar un mensaje o una opción por defecto
                selectParroquia.append('<option value="">No hay parroquias disponibles</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}



$('#actualizar_audiencias').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  

   let id_estado_pais= $('#estado-select').val();
   let id_municipio= $('#municipio-select').val();
   let id_parroquia= $('#parroquia-select').val();


   let id_requerimiento= $('#id_requerimiento').val();
   
   if (id_estado_pais===0||id_estado_pais==='0') 
    {
      id_estado_pais=26 
    }else
    {
      id_estado_pais= $('#estado-select').val();
    }
    if (id_municipio===0||id_municipio==='0')
    {
      id_municipio=463
    }else
    {
      id_municipio= $('#municipio-select').val();
    }
    if (id_parroquia===0||id_parroquia==='0')
    {
      id_parroquia=1139
    }else
    {
      id_parroquia= $('#parroquia-select').val();
    }

    
  // DATOS PARA REQUERIMIENTO
  let datos_audiencia =
   {
    "id_formato_cita": $('#id_formato_cita').val(),
    "id_estado_pais": id_estado_pais,
    "id_municipio": id_municipio,
    "id_parroquia": id_parroquia,
    "id_pais": $('#pais-select').val(),
    "id_trabajador": $("#id_trabajador").val(),
    "id_estado":  $("#id_estado").val(),
   // "id_condicion":  $("#id_condicion").val(),
  };

  

    // // // ENVIO LOS DATOS DEL REQUERIMIENTO
     $.ajax({
       type: "PUT",
       url: "http://172.16.0.46:70/requerimientos/"+id_requerimiento,
       data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       dataType: "json",
        headers: {

          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

        },
       success: function(response)
       {       
            Swal.fire('Exito!', "REGISTRO ACTUALIZADO", "success");
            setTimeout(function() {
            window.location = '/vista_audiencias/';
            }, 1500);

       }
 
      });
  
});


let id_area = $("#id_area").val().trim();
const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
const url = `http://172.16.0.46:70/usuarios_areas`;

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
      
        // Asumimos que la respuesta es un objeto con una propiedad 'usuariosareas'
        const usuarios = response.usuariosareas;

        // Filtrar usuarios que son directores y que coinciden con el id_area
        const directores = usuarios.filter(usuario => usuario.director && usuario.id_area === id_area);
        
        // Obtener el elemento select donde se agregarán los usuarios
        const select = $('#id_trabajador');
        // Limpiar el select antes de agregar nuevas opciones
        select.empty();
        
        // Agregar opciones al select
        directores.forEach(director => {
            select.append($('<option>', {
                value: director.id_usuario, // o director.id si prefieres
                text: director.nombre
            }));
        });
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
    }
});








// Evento para el cambio de estado
$(document).on('change', '#estado-select', function(e) {
  let id_estado = $("#estado-select").val();
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = `http://172.16.0.46:70/municipios/byEstado/${id_estado}`;
  
  // Realiza la solicitud AJAX para obtener los municipios
  $.ajax({
      url: url,
      method: "get",
      dataType: "json", 
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
      },
      beforeSend: function() {    
          // Puedes mostrar un loader aquí si lo deseas
      },   
      success: function(response) {
          // Limpiar el select de municipios antes de agregar nuevos
          $('#municipio-select').empty();
          $('#parroquia-select').empty(); // Limpiar parroquias al cambiar de estado

          // Iterar sobre los municipios y agregarlos al select
          response.municipioss.forEach(function(municipio) {
              $('#municipio-select').append(
                  $('<option>', { 
                      value: municipio.id,
                      text: municipio.municipio 
                  })
              );
          });

          // Seleccionar el primer municipio automáticamente
          if (response.municipioss.length > 0) {
              $('#municipio-select').val(response.municipioss[0].id).change(); // Cambia el valor y dispara el evento change
          }
      },
      error: function(xhr, status, error) {   
          console.error(xhr.responseText);   
      }
  });
});

// Evento para el cambio de municipio
$(document).on('change', '#municipio-select', function(e) {
  let municipio_id = $("#municipio-select").val();

  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = `http://172.16.0.46:70/parroquias/byMunicipio/${municipio_id}`;
  
  // Realiza la solicitud AJAX para obtener las parroquias
  $.ajax({
      url: url,
      method: "get",
      dataType: "json", 
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
      },
      beforeSend: function() {    
          // Puedes mostrar un loader aquí si lo deseas
      },   
      success: function(response) {
          // Limpiar el select de parroquias antes de agregar nuevos
          $('#parroquia-select').empty();

          // Iterar sobre las parroquias y agregarlas al select
          response.parroquiass.forEach(function(parroquia) {
              $('#parroquia-select').append(
                  $('<option>', { 
                      value: parroquia.id,
                      text: parroquia.parroquia // Cambia "nombre" por "parroquia" según tu estructura
                  })
              );
          });
      },
      error: function(xhr, status, error) {   
          console.error(xhr.responseText);   
      }
  });
});
