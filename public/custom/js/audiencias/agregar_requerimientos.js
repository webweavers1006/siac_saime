
let solicitudes = [];


$('#agregar_caso').prop('disabled', true).addClass('deshabilitado');
$('#ingresar_audiencia').prop('disabled', true).addClass('deshabilitado');



$(document).on('submit', "#buscar", function(e) {
  e.preventDefault();

  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  let ano = $("#ano").val().trim();
  let sol = $("#sol").val().trim();
  let id_area = $("#id_area").val();
  let tipo_audiencia = id_area === '1' ? 'M' : 'P';
  if (!ano) {
    alert("Por favor ingrese el año");
  }
  else  if (id_area==0||id_area==null) {
    alert("Por favor seleccione el Tipo de Audiencia");
  }
  
  else {
    $('#agregar_caso').prop('disabled', false).removeClass('deshabilitado');

    sol = sol.padStart(6, '0');
    const valorConcatenado = `${ano}${sol}`;

    if (tipo_audiencia == 'M') {
      let url = `http://172.16.0.30/graficos/marcas/ef${ano}/${ano}${sol}.jpg`;
      mostrarImagen(url);
    } else if (tipo_audiencia == 'P') {
      let url = `http://172.16.0.30/graficos/patentes/di${ano}/${ano}${sol}.jpg`;
      mostrarImagen(url);
    }
    
    function mostrarImagen(url) {
      const img = document.getElementById('image');
      img.src = url;
      img.addEventListener('load', function() {
        img.style.display = 'block';
      });
      img.addEventListener('error', function() {
        img.style.display = 'none';
      });
    }

    


    const url = `http://172.16.0.46:70/solicitudes/consulta/${valorConcatenado}/${tipo_audiencia}`;
    // Realiza la solicitud AJAX
     
    $.ajax({
      url: url,
      method: "get",
      dataType: "JSON", 
      dataType: "json",
              headers: {

                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

              },  
      beforeSend: function() {    
       
      },   
      success: function(response) {
        $('#nombre_marca').val(response.nombre);        
        $('#nombre_titular').val(response.titulares[7]);        
        $('#numero_poder').val(response.poder);    
        
        let categoria = $('#id_categoria option:selected').text();
        
        let datos = {
          nombre: response.nombre,
          solicitud: response.solicitud,
          categoria: response.categoria,
        };
        solicitudes.push(datos); // Agregamos datos al arreglo    
      },
      error: function(xhr, status, error) {   
        alert("Error: El numero de solicitud utilizado");
      }
    
    });
  }
});





$('#agregar_caso').on('click', function() {
  let descripcion = $('#descripcion').val().trim();
  let id_categoria = $('#id_categoria').val().trim();
  let id_formato_cita = $('#id_formato_cita').val().trim();
  let id_pais = $('#pais-select').val().trim();
  let id_area = $('#id_area').val().trim();
  let nombre_marca= $('#nombre_marca').val().trim();
  let nombre_titular = $('#nombre_titular').val().trim();
  let categoria_seleccionada = $('#id_categoria option:selected').text();
  if (id_area === '0' || id_area === 0) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor seleccione el tipo de Audiencia');
  }else if (id_formato_cita === '0' || id_formato_cita === 0) {
  // Mostrar mensaje de error
  mostrarMensajeError('Por favor  seleccione el formato de la Cita ');
  }else if (id_pais === '0' || id_pais === 0) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor  seleccione el Pais ');
  }else if (nombre_marca === '' && nombre_titular === null) {
  // Mostrar mensaje de error
  mostrarMensajeError('Por favor Ingrese el Numero de Solicitud o Registro y presione Buscar ');
} 
  else if (id_categoria === '0' || id_categoria === 0) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor seleccione la Categoria');
  } else if (descripcion === '' || descripcion === null) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor ingrese la descripción del Caso');
  
  } else if (descripcion.length < 5) {
    alert('La descripción debe tener al menos 5 caracteres.');
  }
  else {
    // Agregamos el valor de categoria_seleccionada al arreglo solicitudes
    if (solicitudes.length > 0) {
      solicitudes[solicitudes.length - 1].categoria_seleccionada = categoria_seleccionada;
      solicitudes[solicitudes.length - 1].descripcion = descripcion;
      solicitudes[solicitudes.length - 1].id_categoria = id_categoria;
    }
  
    $('#ingresar_audiencia').prop('disabled', false).removeClass('deshabilitado');
  
    $('.image_email').hide();
    updateTable(); // Actualizamos la tabla cuando se hace clic en el botón
    // Limpiamos los campos de solicitudes
    $('#id_area').prop('disabled', true);
    $('#descripcion').val('');
    $('#ano').val('');
    $('#sol').val('');
    $('#id_categoria').val('0');
  }
});

function updateTable() {
  $('#agregar_solicitudes').prop('disabled', false)
  .removeClass('deshabilitado');
  let tbody = $('.tbody_0');
  let ultimaSolicitud = solicitudes[solicitudes.length - 1];

  // Creamos una nueva fila de tabla
  let row = $('<tr>').data('index', solicitudes.length - 1);
  row.append($('<td>').text(ultimaSolicitud.nombre));
  row.append($('<td>').text(ultimaSolicitud.registro));
  row.append($('<td>').text(ultimaSolicitud.solicitud));
  row.append($('<td>').text(ultimaSolicitud.categoria));
  row.append($('<td>').text(ultimaSolicitud.categoria_seleccionada));

  // Agregamos un botón de eliminar a la fila
  let deleteButton = $('<td>').append($('<button>').text('Eliminar')
    .addClass('button is-primary is-light delete-button')
    .css({
      'background-color': '#ebf4ff',
      'color': '#07f'
    }));
  row.append(deleteButton);

  tbody.append(row); // Agregamos la fila al cuerpo de la tabla
}

// Función para mostrar mensaje de error
function mostrarMensajeError(mensaje) {
  // Implementar la lógica para mostrar el mensaje de error
  alert(mensaje)
}

$(document).on('click', '.delete-button', function() {
  $(this).closest('tr').remove();
});


$('#ingresar_audiencia').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  
   let id_estado_pais= $('#estado-select').val();
   let id_municipio= $('#municipio-select').val();
   let id_parroquia= $('#parroquia-select').val();


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
    "id_area": $('#id_area').val(),
    "id_usuario": user_audiencia['id'],
    "id_trabajador": $("#id_trabajador").val(),
    "id_estado": 1,
  };

    // // ENVIO LOS DATOS DEL REQUERIMIENTO
     $.ajax({
       type: "POST",
       url: "http://172.16.0.46:70/requerimientos",
       data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       dataType: "json",
        headers: {

          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

        },
       success: function(response)
       {       
          // LE QUITO EL - A LOS NUMEROS DE SOLICITUD
          const solicitudesObject = solicitudes.slice();
          const solicitudValues = solicitudesObject.map(obj => obj.solicitud);
          const num_solicitudes = solicitudValues.map(str => str.replace("-", ""));
          const num_solicitud = [...num_solicitudes]; // or num_solicitudes.join(", ");
          const id_requerimiento = response.requerimientos_id;
          const id_trabajador = $("#id_trabajador").val();
          // TRANSFORMO EL OBJETO EN UN ARREGLO DE OBJETOS
          const solicitud = num_solicitud.map((num, index) => {
            return {
              num_solicitud: num,
              id_categoria: solicitudesObject[index].id_categoria,
              descripcion: solicitudesObject[index].descripcion,
              id_trabajador: id_trabajador,
              id_requerimiento: id_requerimiento,
            };
          });

         

            //ENVIO LOS DATOS DE LA SOLICITUD
            $.ajax({
              type: "POST",
              url: "http://172.16.0.46:70/solicitudes",
              data: JSON.stringify(solicitud), // Convertir objeto a cadena JSON
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              dataType: "json",
              headers: {

                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

              },
              success: function(response)
              {
               

              }
            });

            Swal.fire('Exito!', "REGISTRO EXITOSO", "success");
          
            setTimeout(function() {
            window.location = '/vista_audiencias/';
            }, 1500);

       }
 
      });
  
});


/*Verficacion de datos en el form*/
$(document).on('change', '#id_area', function(e) {
  let id_area = $("#id_area").val();

if (id_area==1) 
{
  const areaInput1 = document.getElementById('informacion');
  areaInput1.textContent = 'Información de la marca';
  const areaInput2 = document.getElementById('nombre_area');
  areaInput2.textContent = 'Nombre de la Marca:';
 
 

}else
if (id_area==2) 
  {
    const areaInput1 = document.getElementById('informacion');
    areaInput1.textContent = 'Información de la Patente';
    const areaInput2 = document.getElementById('nombre_area');
    areaInput2.textContent = 'Titulo de la Patente ';
   
    
  }


  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = `http://172.16.0.46:70/usuarios_areas/director/${id_area}`;
    // Realiza la solicitud AJAX
    $.ajax({
      url: url,
      method: "get",
      dataType: "JSON", 
      dataType: "json",
      headers: {

        'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

      },  
      beforeSend: function() {    
       
      },   
      success: function(response) {
        $('#id_trabajador').val(response.id_usuario);         
      },
      error: function(xhr, status, error) {   
        console.error(xhr.responseText);   
      }
    
    });
  
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



