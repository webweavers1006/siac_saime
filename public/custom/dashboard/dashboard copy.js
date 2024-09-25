$('#btn_agregar').on('click', function(e) {
    window.location = '/agregar_caso'
});
$(function() {
    listar_usuarios();
});
/*
 * Función para definir datatable de usuarios:
 */
function listar_usuarios() {
    $('#table_casos').DataTable({
        "order": [
            [5, "desc"]
        ],
        "paging": true,
        "info": true,
        "filter": true,
        "responsive": true,
        "autoWidth": true,
        //"stateSave":true,
        "ajax": {
            "url": "/listar_Ultimos_Casos",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            //{ data: 'idcaso' },
            { data: 'nombre' },
            { data: 'casotel' },
            { data: 'tipo_prop_nombre' },
            { data: 'tipo_aten_nombre' },
            { data: 'casofec' },
            { data: 'estnom' },
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