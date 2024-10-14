let solicitudes = [];

$('#agregar_solicitudes').prop('disabled', true).addClass('deshabilitado');




// EVENTO PARA AGREGAR UN NUEVO TIPO DE ATENCION
$(document).on('submit', "#buscar", function(e) {
  e.preventDefault();

  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  let ano = $("#ano").val().trim();
  let sol = $("#sol").val().trim();
  let id_area = $("#id_area").val();
  let tipo_audiencia = id_area === '1' ? 'M' : 'P';
  if (!ano) {
    alert("Por favor ingrese el año");
  } else {
    sol = sol.padStart(6, '0');
    const valorConcatenado = `${ano}${sol}`;
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
 
  let nombre_marca= $('#nombre_marca').val().trim();
  let nombre_titular = $('#nombre_titular').val().trim();
  let categoria_seleccionada = $('#id_categoria option:selected').text();
  
  
  if (nombre_marca === '' && nombre_titular === null) {
  // Mostrar mensaje de error
  mostrarMensajeError('Por favor Ingrese el Numero de Solicitud o Registro y presione Buscar ');
} 
  else if (id_categoria === '0' || id_categoria === 0) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor seleccione la Categoria');
  } else if (descripcion === '' || descripcion === null) {
    // Mostrar mensaje de error
    mostrarMensajeError('Por favor ingrese la descripción del Caso');
  
  }else if (descripcion.length < 5) {
    alert('La descripción debe tener al menos 5 caracteres.');
  }
  

  else {
    // Agregamos el valor de categoria_seleccionada al arreglo solicitudes
    if (solicitudes.length > 0) {
      solicitudes[solicitudes.length - 1].categoria_seleccionada = categoria_seleccionada;
      solicitudes[solicitudes.length - 1].descripcion = descripcion;
      solicitudes[solicitudes.length - 1].id_categoria = id_categoria;
    }
  
    
  
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


$(document).on('click', '.delete-button', function() {
  $(this).closest('tr').remove();
});

// Función para mostrar mensaje de error
function mostrarMensajeError(mensaje) {
  // Implementar la lógica para mostrar el mensaje de error
  alert(mensaje)
}






$('#agregar_solicitudes').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  
   

    // LE QUITO EL - A LOS NUMEROS DE SOLICITUD
    const solicitudesObject = solicitudes.slice();
    const solicitudValues = solicitudesObject.map(obj => obj.solicitud);
    const num_solicitudes = solicitudValues.map(str => str.replace("-", ""));
    const num_solicitud = [...num_solicitudes]; // or num_solicitudes.join(", ");
    const id_requerimiento = $("#id_requerimiento").val();
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
          Swal.fire('Exito!', "REGISTRO EXITOSO", "success");
    
          setTimeout(function() {
          window.location = '/detalles_requerimientos/'+id_requerimiento;
          }, 1500);
  
          

        }
      });

           
  
});



  let id_area = $("#id_area").val();
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
