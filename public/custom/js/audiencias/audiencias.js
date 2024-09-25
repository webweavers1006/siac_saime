


$(function() {
    listado_Audiencias();
});

/*
 * Función para definir datatable:
 */
function listado_Audiencias() {
    let ruta_imagen = rootpath;
    var encabezado = '';
    $.ajax({
      url: "http://172.16.0.46:70/requerimientos/1/100/",
      method: "GET",
      dataType: "json"
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
        "ordering": true,
        "info": true,
        "autoWidth": true,
        ajax: {
          url: "/listar_Casos_Usuarios",
          type: "GET",
          dataSrc: ''
        },
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
          {
            orderable: true,
            data: null,
            render: function(data, type, row) {
              return '<a href="javascript:;" class="btn btn-xs  Detalles" style=" font-size:1px" data-toggle="tooltip" title="Detalles"  id=' + row.id + ' > <i class="material-icons " >search</i></a>'
            }
          },
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
        .catch((error) => {
          Swal.fire("Error", "No se pudo cargar la lista de audiencias", "Error");
        });
    });
}

        


// METODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
$('#listar_audencias').on('click', '.Detalles', function(e) {
    e.preventDefault();
    const idCaso = $(this).attr('id');
    const url = `/detalles_requerimientos/${idCaso}`;
    window.location.href = url;
});



// //EVENTO PARA AGREGAR UNA DIRECCION
$(document).on('click', "#btn_agregar", function(e) {
    e.preventDefault();
   
    window.location = '/vista_agregar_requerimientos/';

})
