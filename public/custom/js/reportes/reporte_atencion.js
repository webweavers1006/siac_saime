/*
 *Este es el document ready
 */
$(function() {
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();
    let tipo_pi = $('#tipo-pi').val();
    let tipo_atencion_usu = $('#tipo-atencion-usu').val();
    let via_atencion = $('#via-atencion').val();
    let direcciones_caso = $('#direcciones_caso').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let atencion_cuidadano = $('#office').val();
    let sexo = $('#sexo').val();
    if (desde == '' && hasta == '') {

        desde = 'null'
        hasta = 'null'
    }
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo);
    llenar_Propiedad_Intelectual(Event);
    llenar_Tipo_Atencion(Event);
    llenar_via_atencion(Event);
});

function listar_reportes(desde = null, hasta = null, tipo_pi = null, tipo_atencion_usu = null, sexo = null, via_atencion = null, direcciones_caso = null, tipo_beneficiario = 0,atencion_cuidadano = 0,estatus=0,nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, nombre_direccion_remi,nombre_aten_cuidadano,nombre_estatus) {

    // Convertir la fecha
    var fechaOriginal = desde;
    var dataFormatada_desde = moment(fechaOriginal).format("DD-MM-YYYY");
    var fechaOriginal2 = hasta;
    var dataFormatada_hasta = moment(fechaOriginal2).format("DD-MM-YYYY");
    var encabezado = '';
    if (dataFormatada_desde != 'Invalid date' && dataFormatada_hasta != 'Invalid date') {
        encabezado = encabezado + 'Desde:' + ' ' + dataFormatada_desde + ' ' + ' ' + 'hasta' + ' ' + ' ' + dataFormatada_hasta + ' ' + ' ';
    }
    if (tipo_pi != null) {
        encabezado = encabezado + 'Tipo de Propiedad:' + ' ' + nombre_propiedad + ' ';
    }

    if (tipo_atencion_usu != null) {
        encabezado = encabezado + 'Tipo de Atencion:' + ' ' + nombre_atencion + ' ';
    }

    if (sexo != null) {
        encabezado = encabezado + 'Sexo:' + ' ' + nombresexo + ' ';
    }

    if (via_atencion != null) {
        encabezado = encabezado + 'Via de atencion:' + ' ' + nombre_via_atencion + ' ';
    }

    if (direcciones_caso != null) {
        encabezado = encabezado + 'Remitido a:' + ' ' + nombre_direccion_remi + ' ';
    }

    if (tipo_beneficiario != null && tipo_beneficiario != 0) {
        encabezado = encabezado + 'Tipo beneficiario :' + ' ' + nombre_tipo_beneficiario + ' ';
    }
    if (atencion_cuidadano != null && atencion_cuidadano != 0) {
        encabezado = encabezado + 'Atencion Cuidadano :' + ' ' + nombre_aten_cuidadano+ ' ';
    }

    if (estatus != null && estatus != 0) {
        encabezado = encabezado + 'Estatus :' + ' ' + nombre_estatus+ ' ';
    }

    let ruta_imagen = rootpath;
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
                            color: '#19375a',
                            fontSize: '18',
                            alignment: 'center'
                        }
                        doc.styles['td:nth-child(2)'] = {
                                width: '130px',
                                'max-width': '130px'
                            },
                            doc.styles.tableHeader = {
                                fillColor: '#19375a',
                                color: 'white',
                                alignment: 'center'
                            },
                            // Create a header
                            doc.pageMargins = [10, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
                            doc.styles.title = {
                                color: '#19375a',
                                fontSize: '18',
                                alignment: 'center',
                            }
                            return {
                                columns: [{
                                        margin: [10, 3, 40, 40],
                                        image: ruta_imagen,
                                        width: 780,
                                        height: 46,

                                    },
                                    {
                                        margin: [-800, 50, -25, 0],
                                        color: '#19375a',
                                        fontSize: '18',
                                        alignment: 'center',
                                        text: 'Consolidado de Atencion',
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
                    title: 'Consolidado de Atencion',

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
            "url": "/Listar_Atencion/" + desde + '/' + hasta + '/' + tipo_pi + '/' + tipo_atencion_usu + '/' + sexo + '/' + via_atencion + '/' + direcciones_caso + '/' + tipo_beneficiario+ '/' +atencion_cuidadano+'/'+estatus,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            {data:'idcaso'},
            { data: 'cedula' },
            { data: 'tipo_beneficiario' },
            { data: 'nombre' },
            { data: 'casotel' },
            { data: 'casodesc' },
            { data: 'segcoment' },
            { data: 'fecha_seguimiento' },
            { data: 'estnom' },
            { data: 'nombre_usuario' },

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

//FUNCION PARA LLENAR EL COMBO DE LAS REDES SOCIALES
function llenar_via_atencion(e, id) {
    e.preventDefault;
    url = "/listar_Red_Social";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#via-atencion").empty();
                $("#via-atencion").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#via-atencion").append(
                            "<option value=" +
                            item.red_s_id +
                            ">" +
                            item.red_s_nom +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#via-atencion").append(
                                "<option value=" +
                                item.red_s_id +
                                " selected>" +
                                item.red_s_nom +
                                "</option>"
                            );
                        } else {
                            $("#via-atencion").append(
                                "<option value=" +
                                item.red_s_id +
                                ">" +
                                item.red_s_nom +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            //alert(xhr.status);
           //alert(errorThrown);
        },
    });
}
//FUNCION PARA LLENAR EL COMBO TIPO DE PROPIEDAD INTELECTUAL
function llenar_Propiedad_Intelectual(e, id) {
    e.preventDefault;
    url = "/Listar_Propiedad_Intelectual";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#tipo-pi").empty();
                $("#tipo-pi").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#tipo-pi").append(
                            "<option value=" +
                            item.tipo_prop_id +
                            ">" +
                            item.tipo_prop_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#tipo-pi").append(
                                "<option value=" +
                                item.tipo_prop_id +
                                " selected>" +
                                item.tipo_prop_nombre +
                                "</option>"
                            );
                        } else {
                            $("#tipo-pi").append(
                                "<option value=" +
                                item.tipo_prop_id +
                                ">" +
                                item.tipo_prop_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            //alert(xhr.status);
           //alert(errorThrown);
        },
    });
}
//FUNCION PARA LLENAR EL COMBO TIPO DE ATENCION USUARIO
function llenar_Tipo_Atencion(e, id) {
    e.preventDefault;
    url = "/Listar_Tipo_Atencion_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#tipo-atencion-usu").empty();
                $("#tipo-atencion-usu").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#tipo-atencion-usu").append(
                            "<option value=" +
                            item.tipo_aten_id +
                            ">" +
                            item.tipo_aten_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#tipo-atencion-usu").append(
                                "<option value=" +
                                item.tipo_aten_id +
                                " selected>" +
                                item.tipo_aten_nombre +
                                "</option>"
                            );
                        } else {
                            $("#tipo-atencion-usu").append(
                                "<option value=" +
                                item.tipo_aten_id +
                                ">" +
                                item.tipo_aten_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            //alert(xhr.status);
           //alert(errorThrown);;
        },
    });
}
$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();
    let via_atencion = $('#via-atencion').val();
    let direcciones_caso = $('#direcciones_caso').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let atencion_cuidadano = $('#office').val();
    let estatus = $('#estatus').val();
    let tipo_pi = $('#tipo-pi').val();
    let tipo_atencion_usu = $('#tipo-atencion-usu').val();
    let sexo = $('#sexo').val();
    let nombre_propiedad = $('#tipo-pi option:selected').text();
    let nombre_atencion = $('#tipo-atencion-usu option:selected').text();
    let nombresexo = $('#sexo option:selected').text();
    let nombre_via_atencion = $('#via-atencion option:selected').text();
    let nombre_tipo_beneficiario = $('#t-beneficiario option:selected').text();
    let nombre_direccion_remi = $('#direcciones_caso option:selected').text();
    let nombre_aten_cuidadano = $('#office option:selected').text();
    let nombre_estatus = $('#estatus option:selected').text();

    if (desde == '') {
        desde = 'null'
    }
    if (hasta == '') {
        hasta = 'null'
    }
    if (desde == 'null' && hasta != 'null') {
        alert('DEDE INDICAR EL CAMPO DESDE');

    } else if (hasta == 'null' && desde != 'null') {
        alert('DEDE INDICAR EL CAMPO HASTA');
    } else if (hasta < desde) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA')
    }
    $("#table_casos").dataTable().fnDestroy();
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo, via_atencion, direcciones_caso, tipo_beneficiario,atencion_cuidadano,estatus, nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, nombre_direccion_remi,nombre_aten_cuidadano,nombre_estatus);


})
$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();
    location.reload();

})