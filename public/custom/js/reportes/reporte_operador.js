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
    let edad_min = $('#edad_min').val();
    let edad_max = $('#edad_max').val();
    let org_id = $('#organismo-caso').val();
    let sexo = $('#sexo').val();
    if (desde == '' && hasta == '') {

        desde = 'null'
        hasta = 'null'
    }

    if (edad_min == '' && edad_max == '') {

        edad_min = 'null'
        edad_max = 'null'
    }
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo,edad_min,edad_max,org_id);
    llenar_Propiedad_Intelectual(Event);
    llenar_Tipo_Atencion(Event);
    llenar_via_atencion(Event);
    llenar_Estados(Event);
    llenar_Tipo_Beneficiarios(Event);
    llenar_pais(Event);
    llenar_Organismos_PP(Event);
});


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
    desde = null, hasta = null, tipo_pi = null, tipo_atencion_usu = null, sexo = null, via_atencion = null,
    direcciones_caso = null, tipo_beneficiario = 0, usuarios = null, estatus = 0, id_pais = 0,
    id_estado = 0, id_municipio = 0, id_parroquia = 0, edad_min = null, edad_max = null, org_id = 0,
    nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario,
    nombre_direccion_remi, nombre_usuario, nombre_estatus = null, nombre_estado = null, nombre_org_id = null
) {
    // Si la tabla ya está inicializada, la destruimos para evitar errores de re-inicialización
    if ($.fn.DataTable.isDataTable('#table_casos')) {
        $('#table_casos').DataTable().destroy();
    }

    // Convertir la fecha y construir el encabezado para el PDF
    var encabezado = '';
    // ... (Tu lógica de encabezado se mantiene sin cambios)
    if (desde && hasta && moment(desde).isValid() && moment(hasta).isValid()) {
        const dataFormatada_desde = moment(desde).format("DD-MM-YYYY");
        const dataFormatada_hasta = moment(hasta).format("DD-MM-YYYY");
        encabezado += `Desde: ${dataFormatada_desde} hasta ${dataFormatada_hasta} `;
    }
    if (usuarios) { encabezado += `Usuario: ${nombre_usuario} `; }
    if (tipo_pi) { encabezado += `Tipo de Propiedad: ${nombre_propiedad} `; }
    if (tipo_atencion_usu) { encabezado += `Tipo de Atencion: ${nombre_atencion} `; }
    if (sexo) { encabezado += `Sexo: ${nombresexo} `; }
    if (via_atencion && via_atencion !== 'null') { encabezado += `Vía de atencion: ${nombre_via_atencion} `; }
    if (direcciones_caso && direcciones_caso !== 'null') { encabezado += `Remitido a: ${nombre_direccion_remi} `; }
    if (tipo_beneficiario && tipo_beneficiario !== 0) { encabezado += `Tipo beneficiario: ${nombre_tipo_beneficiario} `; }
    if (estatus && estatus !== 0) { encabezado += `Estatus: ${nombre_estatus} `; }
    if (org_id && org_id !== 0) { encabezado += `Organismo del poder popular: ${nombre_org_id} `; }
    if (edad_min && edad_max) { encabezado += `Edad: Entre ${edad_min} y ${edad_max} `; }

    let ruta_imagen = rootpath;
    
    // Inicialización de DataTables
    var table = $('#table_casos').DataTable({
        responsive: true,
        
        // *******************************************************************
        // CORRECCIÓN CLAVE: CAMBIO EN LA OPCIÓN 'dom'
        // 'l' = lengthMenu (Mostrar X registros)
        // '<"row"<"col-md-6"B><"col-md-6"f>>' = Botones (B) y Filtro (f) en la misma fila.
        // *******************************************************************
        dom: 'l<"row"<"col-md-6"B><"col-md-6 text-right"f>>tip', 

        buttons: {
            dom: {
                // Se corrigió el uso de 'btn-xs-xs' para que se aplique correctamente a los botones generados
                button: { className: 'btn-xs-xs btn-dark' }, 
            },
            buttons: [
                // Botón PDF
                {
                    extend: "pdf",
                    text: 'PDF',
                    // className: 'btn-xs btn-dark', // Ya se aplica por defecto en dom.button
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    alignment: 'center',
                    customize: function(doc) {
                        doc.content.splice(0, 1);
                        doc.styles.title = { color: '#4c8aa0', fontSize: '18', alignment: 'center' };
                        doc.styles['td:nth-child(2)'] = { width: '130px', 'max-width': '130px' };
                        doc.styles.tableHeader = { fillColor: '#4c8aa0', color: 'white', alignment: 'center' };
                        doc.pageMargins = [10, 95, 0, 70];
                        doc['header'] = (function() {
                            return {
                                columns: [
                                    { margin: [10, 3, 40, 40], image: ruta_imagen, width: 780, height: 46 },
                                    { margin: [-800, 50, -25, 0], color: '#4c8aa0', fontSize: '18', alignment: 'center', text: 'Consolidado de Casos', fontSize: 18 },
                                    { margin: [-700, 80, -25, 0], text: insertarSaltoDeLinea(encabezado, 100) },
                                ],
                            };
                        });
                        doc['footer'] = (function(page, pages) {
                            return {
                                columns: [
                                    { alignment: 'center', text: ['Página ', { text: page.toString() }, ' de ', { text: pages.toString() }] }
                                ],
                            };
                        });
                    },
                },
                // Botón Excel
                {
                    extend: "excel",
                    text: 'Excel',
                    // className: 'btn-xs btn-dark', // Ya se aplica por defecto en dom.button
                    title: 'Consolidado de Casos',
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    excelStyles: {
                        "template": ["blue_medium", "header_blue", "title_medium"]
                    },
                }
                // Si quieres más botones (copiar, imprimir, etc.) añádelos aquí.
            ]
        },
        // ... (El resto de tu configuración se mantiene igual)
        "order": [[0, "desc"]],
        "paging": true,
        "lengthChange": true,
        "processing": true,
        "serverSide": true,
        "searching": true,
        "lengthMenu": [[10, 25, 50, -1], ['10', '25', '50', 'Todos']],
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "ajax": {
            "url": "reporte_operador", // La URL base
            "type": "GET",
            "data": function(d) {
                // Envía todos los filtros como parte de la data del request
                d.desde = desde; d.hasta = hasta; d.tipo_pi = tipo_pi; d.tipo_atencion_usu = tipo_atencion_usu;
                d.sexo = sexo; d.via_atencion = via_atencion; d.direcciones_caso = direcciones_caso;
                d.tipo_beneficiario = tipo_beneficiario; d.usuarios = usuarios; d.estatus = estatus;
                d.id_pais = id_pais; d.id_estado = id_estado; d.id_municipio = id_municipio;
                d.id_parroquia = id_parroquia; d.edad_min = edad_min; d.edad_max = edad_max;
                d.org_id = org_id;
            }
        },
        "columns": [
            { data: 'idcaso' }, { data: 'cedula' }, { data: 'tipo_beneficiario' }, { data: 'nombre' },
            { data: 'casotel' }, { data: 'tipo_prop_nombre' }, { data: 'tipo_aten_nombre' }, { data: 'casofec' },
            { data: 'estnom' }, { data: 'descripcion' }, { data: 'user_name' },
        ],
       "language": {
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
                "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "columnDefs": [{
                "targets": [0], "visible": false, "searchable": false
            }, ]
        },
    initComplete: function(settings, json) {
        let savedPage = localStorage.getItem('datatable_page');
        if (savedPage !== null) {
            table.page(parseInt(savedPage)).draw(false);
            localStorage.removeItem('datatable_page');
        }
    }
    });

    table.on('page.dt', function () {
        let info = table.page.info();
        localStorage.setItem('datatable_page', info.page);
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
           // alert(xhr.status);
          //  alert(errorThrown);
        },
    });
}




$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();
    let via_atencion = $('#via-atencion').val();
    let usuarios = $('#usuarios').val();
    let direcciones_caso = $('#direcciones_caso').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let tipo_pi = $('#tipo-pi').val();
    let tipo_atencion_usu = $('#tipo-atencion-usu').val();
    let sexo = $('#sexo').val();
    let estatus = $('#estatus').val();

    let id_pais = $('#pais-caso').val();
    let id_estado = $('#estado-caso').val();
    let id_municipio = $('#municipio-caso').val();
    let id_parroquia = $('#parroquia-caso').val();
    let org_id = $('#organismo-caso').val();
    let nombre_propiedad = $('#tipo-pi option:selected').text();
    let nombre_atencion = $('#tipo-atencion-usu option:selected').text();
    let nombresexo = $('#sexo option:selected').text();
    let nombre_via_atencion = $('#via-atencion option:selected').text();
    let nombre_tipo_beneficiario = $('#t-beneficiario option:selected').text();
    let nombre_direccion_remi = $('#direcciones_caso option:selected').text();
    let nombre_usuario = $('#usuarios option:selected').text();
    let nombre_estado = $('#estado-caso option:selected').text();
    let nombre_estatus = $('#estatus option:selected').text();
    let nombre_org_id = $('#organismo-caso option:selected').text();
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

    let edad_min = $('#edad_min').val();
    let edad_max = $('#edad_max').val();
    
    if (edad_min == '' && edad_max == '') {
        edad_min = 'null';
        edad_max = 'null';
    } 
    
    if (edad_min >= '0' && edad_max == '') {
        alert('Debe indicar el campo "Edad Hasta"');
    } else if (edad_min == '' && edad_max != '') {
        alert('Debe indicar el campo "Edad Desde"');
    } else if (parseInt(edad_max) < parseInt(edad_min)) {
        alert('El campo "Edad Desde" es mayor al campo "Edad Hasta"');
    }else
    {
    $("#table_casos").dataTable().fnDestroy();
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo, via_atencion, direcciones_caso, tipo_beneficiario, usuarios,estatus,id_pais,id_estado,id_municipio,id_parroquia,edad_min,edad_max,org_id, nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, nombre_direccion_remi, nombre_usuario,nombre_estatus,nombre_estado,nombre_org_id);

    }
})
$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();
    location.reload();

})


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


//FUNCION PARA LLENAR EL COMBO PAIS
function llenar_pais(e, id) {
    e.preventDefault;
    url = "/llenar_pais";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#pais-caso").empty();
                $("#pais-caso").append(
                    "<option value='0'>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                       
                        $("#pais-caso").append(
                            "<option value=" +
                            item.paisid +
                            ">" +
                            item.paisnom +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#pais-caso").append(
                                "<option value=" +
                                item.paisid +
                                " selected>" +
                                item.paisnom +
                                "</option>"
                            );
                        } else {
                            $("#pais-caso").append(
                                "<option value=" +
                                item.paisid +
                                ">" +
                                item.paisnom +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        },
    });
}


// FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, id) {
    const url = "/llenar_Estados"; // Usar const para variables que no cambian
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {
            // Puedes agregar un loader o alguna indicación de que se está cargando
        },
        success: function(data) {
            if (data.length >= 1) {
                $("#estado-caso").empty(); // Limpiar el combo
                $("#estado-caso").append(
                    "<option value='0' selected disabled>Seleccione</option>"
                );
                $.each(data, function(i, item) {
                    // Agregar las opciones al combo
                    if (id === undefined) {
                        $("#estado-caso").append(
                            "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                        );
                    } else {
                       
                        if (item.estadoid === id) {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "' selected>" + item.estadonom + "</option>"
                            );
                        } else {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                            );
                        }
                    }
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            alert("Error: " + xhr.status + " - " + errorThrown);
        },
    });
}

$("#pais-caso").on('change', function() {

    $("#pais-caso").removeClass('is-invalid');
    var pais = $('#pais-caso').val();  
    if (pais != 1) 
    {
        llenar_Estados(Event); 
        $("#municipio-caso").val('336');
        $("#parroquia-caso").val('1135');
       
        $("#estado-caso").prop('disabled', true);
        $("#municipio-caso").prop('disabled', true);
        $("#parroquia-caso").prop('disabled', true);

        let datos_m = {
            id_estado: 26,
        };

        $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: {
                data: btoa(JSON.stringify(datos_m)),
            },
        })
        .then((response) => {
            $("#municipio-caso").html(response.data);

            // Cargar parroquias solo si hay municipios
            let mun = $("#municipio-caso").val();
            if (mun != 0) {
                let datos_p = {
                    id_municipio: mun,
                };
                return $.ajax({
                    url: "/parroquias",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        data: btoa(JSON.stringify(datos_p)),
                    },
                });
            }
        })
        .then((response) => {
            $("#parroquia-caso").html(response.data);
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar datos", "error");
        });
        
    } 
    else
    {
        // Si el país es 1, restablecer y habilitar selectores
        $("#estado-caso").val('0').prop('disabled', false); // Restablecer y habilitar
        $("#municipio-caso").val('0').prop('disabled', false); // Restablecer y habilitar
        $("#parroquia-caso").val('0').prop('disabled', false); // Restablecer y habilitar
        llenar_Estados(Event, '1'); 

        let datos_m = {
            id_estado: 1,
        };

        $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: {
                data: btoa(JSON.stringify(datos_m)),
            },
        })
        .then((response) => {
            let opciones = '<option value="0" selected>Seleccione un municipio</option>';
            opciones += response.data; // Asegúrate de que response.data contenga las opciones en formato HTML
            $("#municipio-caso").html(opciones);

            // Cargar parroquias solo si hay municipios
            let mun = $("#municipio-caso").val();
            if (mun != 0) {
                let datos_p = {
                    id_municipio: mun,
                };
                return $.ajax({
                    url: "/parroquias",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        data: btoa(JSON.stringify(datos_p)),
                    },
                });
            } else {
                // Si no hay municipios, restablecer parroquias
                let opciones2 = '<option value="0" selected>Seleccione una Parroquia</option>';
                $("#parroquia-caso").html(opciones2);
                return Promise.reject(); // Para evitar que se ejecute el siguiente then
            }
        })
        .then((response) => {
            let opciones2 = '<option value="0" selected>Seleccione una Parroquia</option>';
            opciones2 += response.data; // Asegúrate de que response.data contenga las opciones en formato HTML
            $("#parroquia-caso").html(opciones2);
            $("#parroquia-caso").val('0'); // Asegúrate de que "Seleccione una Parroquia" esté seleccionado
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar datos", "error");
        });
    }
});






//Evento que busca los municipios por estados
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
            // Agregamos el valor "0" seleccionado por defecto
            let opciones = '<option value="0" selected>Seleccione un municipio</option>';
            opciones += response.data;
            $("#municipio-caso").html(opciones);

            let mun = $("#municipio-caso").val();
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Ocurrió un error", "error");
        });
});



//Evento que busca las parroquias por municipio
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
            let opciones2 = '<option value="0" selected>Seleccione una Parroquia</option>';
            opciones2 += response.data; // Asegúrate de que response.data contenga las opciones en formato HTML
            $("#parroquia-caso").html(opciones2);
            $("#parroquia-caso").val('0'); // Asegúrate de que "Seleccione una Parroquia" esté seleccionado
        })
        .catch((request) => {
            Swal.fire("Error", response.JSONmessage, "Error");
        });
});
