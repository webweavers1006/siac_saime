
let solicitudes = [];

// EVENTO PARA AGREGAR UN NUEVO TIPO DE ATENCION
$(document).on('submit', "#buscar", function(e) {
  e.preventDefault();
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
        console.error(xhr.responseText);   
      }
    
    });
  }
});

$('#agregar_caso').on('click', function() {
  let descripcion =  $('#descripcion').val().trim();
  let id_categoria =  $('#id_categoria').val().trim();
  let categoria_seleccionada = $('#id_categoria option:selected').text();

  if (id_categoria=='0'||id_categoria==0) 
  {
    alert("Por favor seleccione la Categoria"); 
  
  }else if (descripcion==''||descripcion==null) 
  {
    alert("Por favor ingrese la descripción del caso"); 
  }

  else
  {
    // Agregamos el valor de categoria_seleccionada al arreglo solicitudes
    if (solicitudes.length > 0) {
      solicitudes[solicitudes.length - 1].categoria_seleccionada = categoria_seleccionada;
    }

    $('.image_email').hide();
    updateTable(); // Actualizamos la tabla cuando se hace clic en el botón
    // Limpiamos los campos de solicitudes
    $('#descripcion').val('');
    $('#ano').val('');
    $('#sol').val(''); 
    $('#id_categoria').val('0');
  }
});
  

function updateTable() {



  let tbody = $('.tbody_0');
  let row = $('<tr>'); // Creamos una nueva fila de tabla

  row.append($('<td>').text(solicitudes[solicitudes.length - 1].nombre));
  row.append($('<td>').text(solicitudes[solicitudes.length - 1].registro));
  row.append($('<td>').text(solicitudes[solicitudes.length - 1].solicitud));
  row.append($('<td>').text(solicitudes[solicitudes.length - 1].categoria));
  row.append($('<td>').text(solicitudes[solicitudes.length - 1].categoria_seleccionada));

  tbody.append(row); // Agregamos la fila al cuerpo de la tabla
}