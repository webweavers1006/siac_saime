let id_caso='8157'

listar_talleres_participantes(id_caso);


function listar_talleres_participantes(id_caso) {
    
    

    $('#table_participantes').DataTable({
        responsive: true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "info": true,
        "filter": true,
        "responsive": true,
        "autoWidth": true,
        //"stateSave":true,
        "ajax": {
            "url": "/listar_participantes/" + id_caso,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'id' },
            { data: 'nombre_completo' },
            { data: 'cedula' },
            { data: 'nacionalidad' },
            { data: 'tipo_beneficiario_nombre' },
            { data: 'paisnom' },
            { data: 'estadonom' },
            { data: 'municipionom' },
            { data: 'parroquianom' },
            { data: 'telefono' },

  
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
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
            },
            "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            }],
        }
    });
}