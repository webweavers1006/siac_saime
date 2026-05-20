/*
 *Este es el document ready
 */
$(function() {
    // 1. Captura de filtros principales
    let desde = $('#desde').val() || 'null';
    let hasta = $('#hasta').val() || 'null';
    let tipo_pi = $('#tipo-pi').val() || 'null';
    let tipo_atencion_usu = $('#tipo-atencion-usu').val() || 'null';
    let sexo = $('#sexo').val() || 'null';
    let via_atencion = $('#via-atencion').val() || 'null';
    let direcciones_caso = $('#direcciones_caso').val() || 'null';
    
    // 2. Filtros numéricos / IDs (si vienen vacíos, se envían en 0 por defecto)
    let tipo_beneficiario = $('#t-beneficiario').val() || 0;
    let atencion_cuidadano = $('#office').val() || 0;
    let estatus = $('#estatus').val() || 0; // Agregado: ajusta el ID según tu HTML
    
    // 3. Ubicación geográfica
    let id_estado = $('#id_estado').val() || 0;       // Agregado: ajusta el ID según tu HTML
    let id_municipio = $('#id_municipio').val() || 0; // Agregado: ajusta el ID según tu HTML
    let id_parroquia = $('#id_parroquia').val() || 0; // Agregado: ajusta el ID según tu HTML
    
    // 4. Edades
    let edad_min = $('#edad_min').val() || 'null';
    let edad_max = $('#edad_max').val() || 'null';
    
    // 5. Detalles y entidades
    let detalle_atencion = $('#edit_detelle_atencion').val() || 0;
    let org_id = $('#organismo-caso').val() || 0;
    let operador = $('#operador').val() || 0; // Agregado: capturado del input/select correspondiente

    // Control de rangos vacíos (Mantiene tu lógica original de forma simplificada)
    if (desde === 'null' || hasta === 'null') {
        desde = 'null';
        hasta = 'null';
    }
    if (edad_min === 'null' || edad_max === 'null') {
        edad_min = 'null';
        edad_max = 'null';
    }

    // 6. LLAMADA CORREGIDA: Mismo orden exacto que espera la función listar_reportes
    listar_reportes(
        desde, 
        hasta, 
        tipo_pi, 
        tipo_atencion_usu, 
        sexo, 
        via_atencion, 
        direcciones_caso, 
        tipo_beneficiario,
        atencion_cuidadano,
        estatus,
        id_estado,
        id_municipio,
        id_parroquia,
        edad_min,
        edad_max,
        detalle_atencion,
        org_id,
        operador
    );

    // Carga de selectores e interfaz
    // Nota: Asegúrate de que 'Event' esté definido globalmente o cambia esto si generaba error.
    llenar_Propiedad_Intelectual(Event);
    llenar_Tipo_Atencion(Event);
    llenar_via_atencion(Event);
    llenar_Estados(Event);
    llenar_Tipo_Beneficiarios(Event);
    llenar_Organismos_PP(Event);
    llenar_Operadores_talleres(Event);
});


//FUNCION PARA LLENAR EL COMBO DE LOS OPERADORES DE LOS TALLERES
function llenar_Operadores_talleres(e, id) {
    e.preventDefault;
    url = "/Listar_Operadores_talleres";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#operador").empty();
                $("#operador").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#operador").append(
                            "<option value=" +
                            item.idusuopr+
                            ">" +
                            item.nombre_completo +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id=== idusuopr) {
                            $("#operador").append(
                                "<option value=" +
                                item.idusuopr+
                                " selected>" +
                                item.nombre_completo +
                                "</option>"
                            );
                        } else {
                            $("#operador").append(
                                "<option value=" +
                                item.idusuopr+
                                ">" +
                                item.nombre_completo +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            
        },
    });
}

//FUNCION PARA LLENAR EL COMBO ORGANISMOS DEL PODER POPULAR 
function llenar_Organismos_PP(e, id) {
    e.preventDefault;
    url = "/Listar_Organismo_PP_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#organismo-caso").empty();
                $("#organismo-caso").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#organismo-caso").append(
                            "<option value=" +
                            item.org_id+
                            ">" +
                            item.org_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id=== org_id) {
                            $("#organismo-caso").append(
                                "<option value=" +
                                item.org_id+
                                " selected>" +
                                item.org_nombre +
                                "</option>"
                            );
                        } else {
                            $("#organismo-caso").append(
                                "<option value=" +
                                item.org_id+
                                ">" +
                                item.org_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            
        },
    });
}

 //FUNCION PARA LLENAR EL COMBO TIPO DE BENEFICIARIOS
 function llenar_Tipo_Beneficiarios(e, id) {
    e.preventDefault;
    url = "/Listar_Tipo_Beneficiarios_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#t-beneficiario").empty();
                $("#t-beneficiario").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#t-beneficiario").append(
                            "<option value=" +
                            item.tipo_beneficiario_id+
                            ">" +
                            item.tipo_beneficiario_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id=== ente_adscrito_id) {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id+
                                " selected>" +
                                item.tipo_beneficiario_nombre +
                                "</option>"
                            );
                        } else {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id+
                                ">" +
                                item.tipo_beneficiario_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            
        },
    });
}



function listar_reportes(
    desde = null, 
    hasta = null, 
    tipo_pi = null, 
    tipo_atencion_usu = null, 
    sexo = null, 
    via_atencion = null, 
    direcciones_caso = null, 
    tipo_beneficiario = 0,
    atencion_cuidadano = 0,
    estatus = 0,
    id_estado = 0,
    id_municipio = 0,
    id_parroquia = 0,
    edad_min = null,
    edad_max = null,
    detalle_atencion = 0,
    org_id = 0,
    operador = 0,
    nombre_propiedad = null, 
    nombre_atencion = null, 
    nombresexo = null, 
    nombre_via_atencion = null, 
    nombre_tipo_beneficiario = null, 
    nombre_direccion_remi = null,
    nombre_aten_cuidadano = null,
    nombre_estatus = null,
    nombre_estado = null,
    nombre_org_id = null,
    nombre_operador = null
) {

    // Función auxiliar para validar que el dato realmente exista y tenga contenido útil
    function esValido(valor) {
        return valor !== null && 
               valor !== 'null' && 
               valor !== undefined && 
               valor !== 'undefined' && 
               valor !== '' && 
               valor !== 0 && 
               valor !== '0' && 
               valor !== 'Seleccione';
    }

    // FUNCIÓN PARA GENERAR EL ENCABEZADO EN TIEMPO REAL
    function obtenerEncabezadoDinamico() {
        var textoFiltros = '';
        var dataFormatada_desde = '';
        var dataFormatada_hasta = '';

        // Buscamos los valores actualizados directamente de la interfaz en el momento de generar el PDF
        let d = $('#desde').val() || desde;
        let h = $('#hasta').val() || hasta;

        if (d !== null && d !== 'null' && d !== '') {
            dataFormatada_desde = moment(d, "YYYY-MM-DD").format("DD-MM-YYYY");
        }
        if (h !== null && h !== 'null' && h !== '') {
            dataFormatada_hasta = moment(h, "YYYY-MM-DD").format("DD-MM-YYYY");
        }

        if (dataFormatada_desde !== '' && dataFormatada_hasta !== '' && dataFormatada_desde !== 'Invalid date' && dataFormatada_hasta !== 'Invalid date') {
            textoFiltros += 'Desde: ' + dataFormatada_desde + ' hasta ' + dataFormatada_hasta + ' | ';
        }

        // Textos de los selectores capturados en caliente
        let n_propiedad = $('#tipo-pi option:selected').text();
        let n_atencion = $('#tipo-atencion-usu option:selected').text();
        let n_sexo = $('#sexo option:selected').text();
        let n_estado = $('#estado-caso option:selected').text();
        let n_via = $('#via-atencion option:selected').text();
        let n_remi = $('#direcciones_caso option:selected').text();
        let n_beneficiario = $('#t-beneficiario option:selected').text();
        let n_ciudadano = $('#office option:selected').text();
        let n_estatus = $('#estatus option:selected').text();
        let n_operador = $('#operador option:selected').text();
        let e_min = $('#edad_min').val();
        let e_max = $('#edad_max').val();

        if (esValido($('#tipo-pi').val()) && esValido(n_propiedad)) textoFiltros += 'Tipo de Propiedad: ' + n_propiedad + ' | ';
        if (esValido($('#tipo-atencion-usu').val()) && esValido(n_atencion)) textoFiltros += 'Tipo de Atencion: ' + n_atencion + ' | ';
        if (esValido($('#sexo').val()) && esValido(n_sexo)) textoFiltros += 'Sexo: ' + n_sexo + ' | ';
        if (esValido($('#estado-caso').val()) && esValido(n_estado)) textoFiltros += 'Estado: ' + n_estado + ' | ';
        if (esValido(e_min) && esValido(e_max)) textoFiltros += 'Edad: Entre ' + e_min + ' y ' + e_max + ' | ';
        if (esValido($('#via-atencion').val()) && esValido(n_via)) textoFiltros += 'Vía de atención: ' + n_via + ' | ';
        if (esValido($('#direcciones_caso').val()) && esValido(n_remi)) textoFiltros += 'Remitido a: ' + n_remi + ' | ';
        if (esValido($('#t-beneficiario').val()) && esValido(n_beneficiario)) textoFiltros += 'Tipo beneficiario: ' + n_beneficiario + ' | ';
        if (esValido($('#office').val()) && esValido(n_ciudadano)) textoFiltros += 'Atención Ciudadano: ' + n_ciudadano + ' | ';
        if (esValido($('#estatus').val()) && esValido(n_estatus)) textoFiltros += 'Estatus: ' + n_estatus + ' | ';
        if (esValido($('#operador').val()) && esValido(n_operador)) textoFiltros += 'Operador: ' + n_operador + ' | ';

        if (textoFiltros.endsWith(' | ')) {
            textoFiltros = textoFiltros.slice(0, -3);
        }

        return textoFiltros || 'Sin filtros seleccionados';
    }

    let ruta_imagen = rootpath;

    // Inicializar DataTable
    var table = $('#table_participantes').DataTable({
        destroy: true, 
        responsive: true,
        dom: 'Blfrtip',
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                }
            },
            buttons: [
                {
                    extend: "pdf",
                    text: 'PDF',
                    className: 'btn-xs btn-dark',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    alignment: 'center',
                    customize: function(doc) {
                        doc.content.splice(0, 1);
                        doc.styles.tableHeader = {
                            fillColor: '#4c8aa0',
                            color: 'white',
                            alignment: 'center',
                            fontSize: 9,
                            bold: true
                        };
                        doc.pageMargins = [15, 130, 15, 50];

                        doc['header'] = (function(page, pages) {
                            return {
                                margin: [20, 10, 20, 0],
                                stack: [
                                    {
                                        image: ruta_imagen,
                                        width: 800, 
                                        height: 45,
                                        margin: [0, 0, 0, 10]
                                    },
                                    {
                                        text: 'Participantes Talleres',
                                        color: '#4c8aa0',
                                        fontSize: 16,
                                        bold: true,
                                        alignment: 'center',
                                        margin: [0, 0, 0, 5]
                                    },
                                    {
                                        // 👈 AQUÍ ESTÁ EL CAMBIO CLAVE: Llama a la función en caliente al presionar el botón
                                        text: obtenerEncabezadoDinamico(),
                                        fontSize: 9,
                                        color: '#555555',
                                        alignment: 'center',
                                        margin: [0, 0, 0, 0]
                                    }
                                ]
                            };
                        });

                        doc['footer'] = (function(page, pages) {
                            return {
                                margin: [0, 20, 0, 0],
                                columns: [{
                                    alignment: 'center',
                                    text: ['Página ', { text: page.toString() }, ' de ', { text: pages.toString() }],
                                    fontSize: 9
                                }]
                            };
                        });
                    }
                },
                {
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: 'Participantes Talleres',
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    excelStyles: {
                        "template": [
                            "blue_medium",
                            "header_blue",
                            "title_medium"
                        ]
                    }
                }
            ]
        },
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],
        "ordering": true,
        "info": true,
        "autoWidth": false, 
        "ajax": {
            "url": "/listar_talleres_participantes/" + desde + '/' + hasta + '/' + tipo_pi + '/' + tipo_atencion_usu + '/' + sexo + '/' + via_atencion + '/' + direcciones_caso + '/' + tipo_beneficiario+ '/' +atencion_cuidadano+'/'+estatus+'/'+id_estado+'/'+id_municipio+'/'+id_parroquia+'/'+edad_min+'/'+edad_max+'/'+detalle_atencion+'/'+org_id+'/'+operador,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'id', render: function(data) { return data ? data.toString().toUpperCase() : ''; } },
            { data: 'nombre_completo', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'casodesc', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'cedula', render: function(data) { return data ? data.toString().toUpperCase() : ''; } },
            { data: 'nacionalidad', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'tipo_beneficiario_nombre', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'paisnom', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'estadonom', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'municipionom', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'parroquianom', render: function(data) { return data ? data.toUpperCase() : ''; } },
            { data: 'telefono', render: function(data) { return data ? data.toString().toUpperCase() : ''; } }
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
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ],
        "initComplete": function(settings, json) {
            this.api().columns.adjust().responsive.recalc();
        }
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


//FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, id) {
    e.preventDefault;
    url = "/llenar_Estados";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#estado-caso").empty();
                $("#estado-caso").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#estado-caso").append(
                            "<option value=" +
                            item.estadoid +
                            ">" +
                            item.estadonom +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#estado-caso").append(
                                "<option value=" +
                                item.estadoid +
                                " selected>" +
                                item.estadonom +
                                "</option>"
                            );
                        } else {
                            $("#estado-caso").append(
                                "<option value=" +
                                item.estadoid +
                                ">" +
                                item.estadonom +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
         
        },
    });
}
// //Evento que busca los municipios por estados
// $(document).on("change", "#estado-caso", (e) => {
//     e.preventDefault();

//     let datos = {
//         id_estado: $("#estado-caso").val(),
//     };
//     $.ajax({
//             url: "/municipios",
//             method: "POST",
//             dataType: "JSON",
//             data: {
//                 data: btoa(JSON.stringify(datos)),
//             },
//         })
//         .then((response) => {
//             // Agregamos el valor "0" seleccionado por defecto
//             let opciones = '<option value="0" selected>Seleccione un municipio</option>';
//             opciones += response.data;
//             $("#municipio-caso").html(opciones);

//             let mun = $("#municipio-caso").val();
//         })
//         .catch((request) => {
//             Swal.fire("Error", request.responseJSON.message || "Ocurrió un error", "error");
//         });


        
// });


// Evento que busca los municipios por estados
$(document).on("change", "#estado-caso", (e) => {
    e.preventDefault();

    let datos = {
        id_estado: $("#estado-caso").val(),
    };

    $.ajax({
        url: "/municipios",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .then((response) => {
        // Actualizar el select de municipios
        $("#municipio-caso").html('<option value="0">Seleccione Municipio</option>' + response.data);
        
        // Limpiar el select de parroquias
        $("#parroquia-caso").html('<option value="0" selected disabled>Seleccione la Parroquia</option>');
    })
    .catch((request) => {
        Swal.fire("Error", "No se pudieron cargar los municipios. Intenta de nuevo.", "error");
    });
});

// Evento que busca las parroquias por municipios
$(document).on("change", "#municipio-caso", (e) => {
    e.preventDefault();

    let datos = {
        id_municipio: $("#municipio-caso").val(),
    };

    $.ajax({
        url: "/parroquias",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .then((response) => {
        // Actualizar el select de parroquias
        $("#parroquia-caso").html('<option value="0" selected disabled>Seleccione la Parroquia</option>' + response.data);
    })
    .catch((request) => {
        Swal.fire("Error", "No se pudieron cargar las parroquias. Intenta de nuevo.", "error");
    });
});

$(document).on('click', '.consultar', function(e) {
    e.preventDefault();

    // 1. Captura y normalización de valores (Inputs y Selects)
    let desde = $('#desde').val() || 'null';
    let hasta = $('#hasta').val() || 'null';
    let detalle_atencion = $('#edit_detelle_atencion').val() || 0;
    let via_atencion = $('#via-atencion').val() || 'null';
    let direcciones_caso = $('#direcciones_caso').val() || 'null';
    let tipo_beneficiario = $('#t-beneficiario').val() || 0;
    let atencion_cuidadano = $('#office').val() || 0;
    let estatus = $('#estatus').val() || 0;
    let tipo_pi = $('#tipo-pi').val() || 'null';
    let tipo_atencion_usu = $('#tipo-atencion-usu').val() || 'null';
    let sexo = $('#sexo').val() || 'null';
    let org_id = $('#organismo-caso').val() || 0;
    let id_estado = $('#estado-caso').val() || 0;
    let id_municipio = $('#municipio-caso').val() || 0;
    let id_parroquia = $('#parroquia-caso').val() || 0;
    let operador = $('#operador').val() || 0;

    // 2. Captura de nombres descriptivos (Textos seleccionados para los reportes)
    let nombre_propiedad = $('#tipo-pi option:selected').text() || null;
    let nombre_atencion = $('#tipo-atencion-usu option:selected').text() || null;
    let nombresexo = $('#sexo option:selected').text() || null;
    let nombre_via_atencion = $('#via-atencion option:selected').text() || null;
    let nombre_tipo_beneficiario = $('#t-beneficiario option:selected').text() || null;
    let nombre_direccion_remi = $('#direcciones_caso option:selected').text() || null;
    let nombre_aten_cuidadano = $('#office option:selected').text() || null;
    let nombre_estatus = $('#estatus option:selected').text() || null;
    let nombre_estado = $('#estado-caso option:selected').text() || null;
    let nombre_org_id = $('#organismo-caso option:selected').text() || null;
    let nombre_operador = $('#operador option:selected').text() || null;

    // Captura de rango de edades
    let edad_min = $('#edad_min').val();
    let edad_max = $('#edad_max').val();

    // 3. Validaciones estrictas de Rango de Fechas
    if (desde === 'null' && hasta !== 'null') {
        alert('DEBE INDICAR EL CAMPO DESDE');
        return;
    } 
    
    if (hasta === 'null' && desde !== 'null') {
        alert('DEBE INDICAR EL CAMPO HASTA');
        return;
    } 
    
    if (desde !== 'null' && hasta !== 'null' && hasta < desde) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA');
        return;
    }

    // 4. Validaciones estrictas de Rango de Edades
    if (edad_min === '' && edad_max === '') {
        edad_min = 'null';
        edad_max = 'null';
    } else {
        let intMin = parseInt(edad_min, 10);
        let intMax = parseInt(edad_max, 10);

        if (!isNaN(intMin) && (edad_max === '' || edad_max === null)) {
            alert('Debe indicar el campo "Edad Hasta"');
            return;
        } 
        
        if ((edad_min === '' || edad_min === null) && !isNaN(intMax)) {
            alert('Debe indicar el campo "Edad Desde"');
            return;
        } 
        
        if (intMax < intMin) {
            alert('El campo "Edad Desde" es mayor al campo "Edad Hasta"');
            return;
        }
    }

    // 5. Envío o recarga dinámica controlada de DataTables (Mantiene anchos de columnas estables)
    if ($.fn.DataTable.isDataTable('#table_participantes')) {
        var tablaInstanciada = $('#table_participantes').DataTable();
        var nuevaUrl = "/listar_talleres_participantes/" + desde + '/' + hasta + '/' + tipo_pi + '/' + tipo_atencion_usu + '/' + sexo + '/' + via_atencion + '/' + direcciones_caso + '/' + tipo_beneficiario + '/' + atencion_cuidadano + '/' + estatus + '/' + id_estado + '/' + id_municipio + '/' + id_parroquia + '/' + edad_min + '/' + edad_max + '/' + detalle_atencion + '/' + org_id + '/' + operador;
        
        // Cambiamos el origen de los datos en caliente y recalculamos la respuesta visual
        tablaInstanciada.ajax.url(nuevaUrl).load(function() {
            tablaInstanciada.columns.adjust().responsive.recalc();
        });
    } else {
        // Ejecución inicial por primera vez si no existía el componente inicializado
        listar_reportes(
            desde, hasta, tipo_pi, tipo_atencion_usu, sexo, via_atencion, direcciones_caso, tipo_beneficiario,
            atencion_cuidadano, estatus, id_estado, id_municipio, id_parroquia, edad_min, edad_max, detalle_atencion,
            org_id, operador, nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, 
            nombre_direccion_remi, nombre_aten_cuidadano, nombre_estatus, nombre_estado, nombre_org_id, nombre_operador
        );
    }
});

// Evento Limpiar separado correctamente
$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();
    location.reload();
});

$("#tipo-atencion-usu").on('change', function(e) {
    let id_tipo_atencion = $('#tipo-atencion-usu option:selected').val();
  

    let  hijos_detalle_atencion;
    $.ajax({
        url: "/buscar_hijos_detalle_atencion/"+id_tipo_atencion,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
           
            if (data.length > 0)
            { 
           
             $('.detalle_atencion').show();
             llenar_detalle_atencion(e,id_tipo_atencion)
               
            } else {
                $('.detalle_atencion').hide();
               
            }
        }
    });
});


/// FUNCION PARA LLENAR EL COMBO DE DETALLE DE ATENCION
function llenar_detalle_atencion(e, id_tipo_atencion) {
    const url = '/Listar_Detalle_Atencion_filtro';
    
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {
            // Puedes agregar un spinner o un mensaje de carga aquí si lo deseas
        },
        success: function(data) {
           ;
            if (data.length >= 1) {
                $('#edit_detelle_atencion').empty();
                $('#edit_detelle_atencion').append('<option value="0" selected disabled>Seleccione</option>');

                // Filtrar los datos según el id_tipo_atencion
                data.forEach(function(item) {
                   
                  
                    if (item.tipo_aten_id === id_tipo_atencion) {
                        $('#edit_detelle_atencion').append(
                            `<option value="${item.tipo_atend_id}">${item.tipo_atend_nombre}</option>`
                        );
                    }
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            // Manejo de errores
            console.error("Error en la solicitud AJAX:", errorThrown);
            // Puedes mostrar un mensaje de error al usuario si lo deseas
        }
    });
}

// Función para insertar un salto de línea en la cadena
function insertarSaltoDeLinea(texto, longitudMaxima) {
    let textoFormateado = '';
    let longitudActual = 0;
    // Dividir el texto en palabras
    const palabras = texto.split(' ');
    // Recorrer las palabras
    for (const palabra of palabras) {
        // Calcular la longitud actual más la nueva palabra
        const longitudNueva = longitudActual + palabra.length + 1; // +1 para el espacio
        // Si la longitud supera la longitud máxima, hacer un salto de línea
        if (longitudNueva > longitudMaxima) {
            // Solo agregar la palabra si no queda cortada
            if (longitudActual > 0) {
                textoFormateado = textoFormateado.trimEnd() + '\n'; // Agregar un salto de línea
            }
            longitudActual = 0; // Reiniciar la longitud actual
        }
        // Agregar la palabra al texto formateado
        textoFormateado += palabra + ' ';
        longitudActual += palabra.length + 1; // Actualizar la longitud actual
    }
    return textoFormateado.trim(); // Retornar el texto formateado sin espacios al final

}

