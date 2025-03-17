$(function() {

    let fecha_inicio =null;
    let fecha_fin =null;
    let tramite =null;
    listar_participantes_encuestas(fecha_inicio, fecha_fin,tramite);

 

    setTimeout(function() {

        $('.opinion').slice(0, 2).show(); 
        $('.comentario').slice(0, 2).show(); 
    }, 1000);
});

/*
 * Función para definir datatable:
 */
function listar_participantes_encuestas(fecha_inicio, fecha_fin, tramite) {
    
    let url = `${url_encuestas}/api/encuesta`;
    let params = [];
    if (fecha_inicio && fecha_inicio !== 'null') {
        params.push(`fecha_inicio=${encodeURIComponent(fecha_inicio)}`);
    }
    if (fecha_fin && fecha_fin !== 'null') {
        params.push(`fecha_fin=${encodeURIComponent(fecha_fin)}`);
    }
    if (tramite && tramite !== 'null') {
        params.push(`tramite=${encodeURIComponent(tramite)}`);
    }
    if (params.length > 0) {
        url += `?${params.join('&')}`;
    }

    let table = $('#table_participantes_encuestas').DataTable({
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "info": true,
        "filter": true,
        "responsive": true,
        "autoWidth": true,
        
        "ajax": {
            "url": url,
            "type": "GET",
            "dataSrc": 'encuestass'
        },
        "columns": [
            { data: 'id' },
            { data: 'tramite' },
            { data: 'apellidos_nombres' },
            { 

                data: 'fecha',
                render: function(data, type, row) {
                    // Verificar si la fecha está disponible
                    if (data) {
                        // Crear un objeto Date a partir de la fecha
                        var date = new Date(data);
                        // Formatear la fecha a DD/MM/YYYY
                        var day = ('0' + date.getDate()).slice(-2);
                        var month = ('0' + (date.getMonth() + 1)).slice(-2); // Los meses son 0-indexados
                        var year = date.getFullYear();
                        return day + '-' + month + '-' + year; // Retornar la fecha formateada
                    }
        
                    return ''; // Retornar vacío si no hay fecha
        
                }
        
            },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return `
                        <a href="javascript:;" class="btn btn-xs btn-primary Detalles" 
                           style="font-size:1px" 
                           data-toggle="tooltip" 
                           title="Detalles" 
                           id="${row.id}" 
                           data-tramite="${row.tramite}" 
                           data-apellidos_nombres="${row.apellidos_nombres}">
                            <i class="material-icons">search</i>
                        </a>`;
                }
            }
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "columnDefs": [{
            "targets": [0],
            "visible": false,
            "searchable": false
        }],
        initComplete: function(settings, json) {
            // Recuperar el estado de la paginación
            let savedPage = localStorage.getItem('datatable_page');
            if (savedPage !== null) {
                table.page(parseInt(savedPage)).draw(false);
                localStorage.removeItem('datatable_page');
            }
        }
    });

    // Guardar el estado de la paginación antes de recargar la página
    table.on('page.dt', function() {
        let info = table.page.info();
        localStorage.setItem('datatable_page', info.page);
    });
}

// MÉTODO PARA BUSCAR LA INFORMACIÓN DE LA ENCUESTA DEL PARTICIPANTE
$('#listar_participante_encuesta').on('click', '.Detalles', function(e) {
    e.preventDefault(); 
    var id_participante = $(this).attr('id'); 
    window.location="/Vista_Detalle_Encuesta/"+id_participante
    
});


$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let fecha_inicio = $('#fecha_inicio').val();
    let fecha_fin = $('#fecha_fin').val();
    let tramite = $('#tramite').val().trim();
    
    if (fecha_inicio == '') {
        fecha_inicio = 'null'
    }
    if (tramite == '' || tramite==null) {
        tramite = 'null'
    }

    if (fecha_fin == '') {
        fecha_fin = 'null'
    }
    if (fecha_inicio == 'null' && fecha_fin != 'null') {
        alert('DEDE INDICAR EL CAMPO DESDE');

    } else if (fecha_fin == 'null' && fecha_inicio != 'null') {
        alert('DEDE INDICAR EL CAMPO fecha_fin');
    } else if (fecha_fin < fecha_inicio) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO fecha_fin')
    }

   else
    {
    $("#table_participantes_encuestas").dataTable().fnDestroy();
    listar_participantes_encuestas(fecha_inicio, fecha_fin,tramite);

    }
})
$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();
    location.reload();

})