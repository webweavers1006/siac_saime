


$(function() {


   listado_Audiencias();
   
});

/*
 * Función para definir datatable:
 */
function listado_Audiencias() {
    let ruta_imagen = rootpath;
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    var encabezado = '';
    $.ajax({
      url: "https://siac.sapi.gob.ve/api/audiencia/requerimientos/1/100/",
      method: "GET",
      dataType: "json",
       dataType: "json",
        headers: {

          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

        },
    })
    .then((response) => {
      $('#table_audiencia').DataTable({
        responsive: true,
        dom: "Bfrtip",
        buttons: [
          {
            extend: "pdf",
            text: 'PDF',
            className: 'btn-xs btn-dark exportaciones',
            orientation: 'landscape',
            pageSize: 'LETTER',
            header: true,
            footer: true,
            download: 'open',
            exportOptions: {
              columns: [ 1, 2, 3, 4, 5],
            },
            customize: function(doc) {
              doc.content.splice(0, 1);
              doc.styles.title = {
                color: '#4c8aa0',
                fontSize: '18',
                alignment: 'center'
              }
              doc.styles['td:nth-child(2)'] = {
                width: '130px',
                'max-width': '130px'
              },
              doc.styles.tableHeader = {
                fillColor: '#4c8aa0',
                color: 'white',
                alignment: 'center'
              },
              doc.pageMargins = [40, 95, 0, 70];
              doc['header'] = (function(page, pages) {
                return {
                  columns: [
                    {
                      margin: [10, 3, 40, 40],
                      image: ruta_imagen,
                      width: 780,
                      height: 50,
                    },
                    {
                      margin: [-800, 50, -25, 0],
                      color: '#4c8aa0',
                      fontSize: '18',
                      alignment: 'center',
                      text: 'Control de Casos',
                      fontSize: 18,
                    },
                    {
                      margin: [-600, 80, -25, 0],
                      text: encabezado,
                    },
                  ],
                }
              });
              doc['footer'] = (function(page, pages) {
                return {
                  columns: [
                    {
                      alignment: 'center',
                      text: ['pagina ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                    },
                  ],
                }
              });
            },
          },
          {
            extend: "excel",
            text: 'Excel',
            className: 'btn-xs btn-dark exportaciones',
            title: 'Control de Casos',
            download: 'open',
            exportOptions: {
              columns: [1, 2, 3, 4, 5],
            },
            excelStyles: {
              "template": [
                "blue_medium",
                "header_blue",
                "title_medium"
              ]
            },
          }
        ],
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "lengthChange": true,

        dom: 'Blfrtip',
        "searching": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],
        
        columns: [
          {
            orderable: true,
            data: null,
            render: function(data, type, row) {
              if (data.estado.trim() == 'NUEVO') {
                return '<div style="text-align: center;"><span class="circle" style="background: rgb(0, 86, 184);"></span></div>';
              } else if (data.estado == 'EN PROCESO') {
                return '<div style="text-align: center;"><span class="circle" style="background: rgb(255, 208, 0);;"></span></div>';
              } else {
                return '<div style="text-align: center;"><span class="circle" style="background: rgb(215, 40, 48);;"></span></div>';
              }
            }
          },
          { data: 'id' },
          { data: 'pais' },
          { data: 'estado' },   
          { data: 'area' },
          { data: 'nombre' },
          { data: 'nombre_contacto'},
          { data: 'solicitudes', visible: false, searchable: true },
          {
            orderable: true,
            data: null,
            render: function(data, type, row) {
                return `
                    <div style="display: flex; align-items: center;">
                        <a href="javascript:;" class="btn btn-xs Detalles" style="font-size: 12px; margin-right: 5px;" data-toggle="tooltip" title="Detalles" id="${row.id}">
                            <i class="material-icons">search</i>
                        </a>
                        <a href="javascript:;" class="btn btn-xs Bufetes" style="font-size: 12px;" data-toggle="tooltip" title="Bufetes" id="${row.id}">
                            <i class="material-icons">business_center</i>
                        </a>
                    </div>
                `;
            }
        }
        ],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior"
          },
          oAria: {
            sSortAscending: ": Activar para ordenar la columna de manera ascendente",
            sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
        },
        data: response.requerimientos // acceder a la propiedad requerimientos y pasar el array de objetos
        })
       
    });
}

        


// METODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
$('#listar_audencias').on('click', '.Detalles', function(e) {
    e.preventDefault();
    const idCaso = $(this).attr('id');
    const url = `/detalles_requerimientos/${idCaso}`;
    window.location.href = url;
});



// MÉTODO PARA AGREGAR BUFETE A LA AUDIENCIA
$('#listar_audencias').on('click', '.Bufetes', function(e) {
  e.preventDefault();
  
  const id_audiencia = $(this).attr('id');
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = "https://siac.sapi.gob.ve/api/audiencia/usuarios_bufetes";

  $.ajax({
      url: url,
      method: "GET",
      dataType: "JSON",
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}` 
      },
      beforeSend: function() {
       
      },
      success: function(data) {
          const bufetes = data.usuariosbufetes || []; 
          let bufeteEncontrado = false;
          let id_bufete = ''; 
          let id_usuario_bufete = ''; 
          $("#asignar_bufete").modal("show");
          $('#asignar_bufete').find('#id_caso').val(id_audiencia); 
          // Verificar si alguno de los bufetes tiene el id_audiencia correspondiente
          bufetes.forEach(function(item) {
              if (item.id_audiencia === id_audiencia) {
                  bufeteEncontrado = true;
                  id_bufete = item.id_bufete;
                  id_usuario_bufete = item.id; // Guardar el id_bufete correspondiente
              }
          });

          $('#asignar_bufete').find('#id_usuario_bufete').val(id_usuario_bufete);

          // Mostrar/ocultar elementos según la coincidencia
          if (bufeteEncontrado) {
              Listar_bufetes(e, id_bufete); // Pasar solo el id_bufete encontrado
              $("#guardar").hide(); // Ocultar el botón de guardar
              $("#actualizar").show(); // Mostrar el botón de actualizar
          } else {
              Listar_bufetes(); // Llamar sin id_bufete si no se encontró
              $("#guardar").show(); // Mostrar el botón de guardar
              $("#actualizar").hide(); // Ocultar el botón de actualizar
          }
      },
      error: function(xhr, status, errorThrown) {
          alert(`Error ${xhr.status}: ${errorThrown}`);
      },
  });
});






// //EVENTO PARA AGREGAR UNA DIRECCION
$(document).on('click', "#btn_agregar", function(e) {
    e.preventDefault();
   
    window.location = '/vista_agregar_requerimientos/';

})
function Listar_bufetes(e, id_bufete) {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = "https://siac.sapi.gob.ve/api/audiencia/bufetes";

  $.ajax({
      url: url,
      method: "GET",
      dataType: "JSON",
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}`
      },
      beforeSend: function() {
          // Puedes agregar un loader o alguna acción antes de enviar la solicitud
      },
      success: function(data) {
          const bufetes = data.bufetes || []; // Asegúrate de que bufetes sea un arreglo

          $("#id_bufete").empty(); // Limpiar el combo antes de llenarlo
          $("#id_bufete").append(
              "<option value='0' selected disabled>Seleccione</option>"
          );

          if (bufetes.length > 0) {
              $.each(bufetes, function(i, item) {
                  // Asegúrate de que id_bufete y item.id sean del mismo tipo
                  const selected = (id_bufete && String(item.id) === String(id_bufete)) ? " selected" : "";
                  $("#id_bufete").append(
                      `<option value="${item.id}"${selected}>${item.nombre_bufete}</option>`
                  );
              });
          }
      },
      error: function(xhr, status, errorThrown) {
          alert(`Error ${xhr.status}: ${errorThrown}`);
      },
  });
}



$('#guardar').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  let id_audiencia = $('#id_caso').val();
  let id_bufete = $('#id_bufete').val(); 

  if (!id_bufete || id_bufete === 'null') 
  {
    alert('Debe seleccionar un Bufete');
  }
  else
  {
    let datos_audiencia = {
      "id_audiencia": id_audiencia,
      "id_bufete": id_bufete,
    };

    $.ajax({
      type: "POST",
      url: `https://siac.sapi.gob.ve/api/audiencia/usuarios_bufetes`,
      data: JSON.stringify(datos_audiencia),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}`
      },
      success: function(response) {
          Swal.fire('Éxito!', "Registro Actualizado", "success");
          setTimeout(function() {
              window.location = '/vista_audiencias';
          }, 1500);
      },
      error: function(xhr, status, error) {
          Swal.fire('Error!', "Error al Insertar el registro", "error");
          console.error(xhr.responseText);
      }
    });
  }
});

$('#actualizar').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const id_audiencia = $('#id_caso').val();
  const id_bufete = $('#id_bufete').val(); 
  const id_usuario_bufete = $('#id_usuario_bufete').val(); 


  if (!id_bufete || id_bufete === 'null') {
      alert('Debe seleccionar un Bufete');
      return;
  }

  // Preparar los datos para la actualización
  const datos_audiencia = {
      "id_audiencia": id_audiencia,
      "id_bufete": id_bufete,
  };

 // console.log(JSON.stringify(datos_audiencia));
  // Realizar la solicitud AJAX para actualizar el registro
  $.ajax({
      type: "PUT",
      url: `https://siac.sapi.gob.ve/api/audiencia/usuarios_bufetes/${id_usuario_bufete}`,
      data: JSON.stringify(datos_audiencia),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
          'Authorization': `Bearer ${user_audiencia.token}`
      },
      success: function(response) {
          Swal.fire('Éxito!', "Registro Actualizado", "success");
          setTimeout(function() {
              window.location = '/vista_audiencias';
          }, 1500);
      },
      error: function(xhr, status, error) {
          Swal.fire('Error!', "Error al actualizar el registro", "error");
          console.error(xhr.responseText);
      }
   });
});
     
  

  