$('#btn_agregar').on('click', function(e) {
    window.location = '/vista_agregar_caso'
});
$(function() {
    Listar_Casos();
});



function Listar_Casos() {
    let rol_usuario=$('#rol_usuario').val();
    let ruta_imagen = rootpath;
    var encabezado = '';
    var table = $('#table_casos').DataTable({
        responsive: true,
      
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
                    //definimos estilos del boton de pd
                    extend: "pdf",
                    text: 'PDF',
                    className: 'btn-xs btn-dark',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    alignment: 'center',

                    customize: function(doc) {
                        //Remove the title created by datatTables
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
                            // Create a header
                            doc.pageMargins = [40, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '18',
                                alignment: 'center',
                            }
                            return {
                                columns: [{
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
                        // Create a footer
                        doc['footer'] = (function(page, pages) {
                            return {
                                columns: [{
                                    alignment: 'center',
                                    text: ['pagina ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                                }],
                            }
                        });

                    },
                },

                {
                    //definimos estilos del boton de excel
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: 'Control de Casos',

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    excelStyles: {
                        "template": [
                            "blue_medium",
                            "header_blue",
                            "title_medium"
                        ]
                    },

                }
            ]
        },
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
        //"dom": 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
        "ajax": {
            "url": "/listar_Casos_Remitidos",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'casos_id' },
            { data: 'cedula' },
            { data: 'nombre' },
            { data: 'casotel' },
            { data: 'tipo_prop_nombre' },
            { data: 'tipo_aten_nombre' },
            { data: 'casofec' },
            { data: 'estnom' },
            { data: 'user_name' },
            {
                
                data: null,
              
                render: function(data, type, row) {
                return  '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style=" font-size:1px" data-toggle="tooltip" title="Seguimientos"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.casos_id + '> <i class="material-icons ">search</i> </a>' 
                        
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
            }, ]

        },
    });
}

//METODO PARA ABRIR EL MODAL PARA LA   EDICION DEL CASO
$('#listar_casos').on('click', '.Imprimir', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('idcaso');
    window.open('generar_pdf/' + idcaso, '_blank');
    // window.location = '/generar_pdf/' + idcaso, '_blank'
});

//METODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
$('#listar_casos').on('click', '.Seguimientos', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('idcaso');
    window.location = '/verCaso/' + idcaso;

});

//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_casos').on('click', '.Bloquear', function(e) {
    let idcaso = $(this).attr('idcaso');
    let borrado = 'true'
    let datos = {
        idcaso: idcaso,
        borrado: borrado
    }
    Swal.fire({
        title: '¿Deseas Eliminar el Registro?',
        text: 'El registro será eliminado del Sitema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            // Aquí puedes agregar la lógica para salir de la página
            $.ajax({
                url: "/eliminar_Caso",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(JSON.stringify(datos))
                },
                beforeSend: function() {

                }
            }).then((response) => {
                Swal.fire('Exito!', "Caso eliminado exitosamente", "success");
                $("#editUser").modal('hide');

                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            });

        }
    });
});

