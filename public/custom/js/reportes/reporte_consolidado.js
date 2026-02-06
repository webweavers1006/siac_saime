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
    let detalle_atencion = $('#edit_detelle_atencion').val();
    let org_id = $('#organismo-caso').val();
    let edad_min = $('#edad_min').val();
    let edad_max = $('#edad_max').val();
    let sexo = $('#sexo').val();
 if (desde === '' && hasta === '') {
    desde = null; // ¡Sin comillas!
    hasta = null; // ¡Sin comillas!
}
let idcaso = $('#id-caso').val();


// Las edades (edad_min, edad_max) pueden seguir siendo 'null' como cadena,
// si no las pasas a moment() u otra función de fecha.
if (edad_min === '' && edad_max === '') {
    edad_min = 'null';
    edad_max = 'null';
}
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo,edad_min,edad_max,detalle_atencion,org_id);
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
               
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
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


function listar_reportes(desde = null, hasta = null, tipo_pi = null, tipo_atencion_usu = null, sexo = null, via_atencion = null, direcciones_caso = null, tipo_beneficiario = 0, atencion_cuidadano = 0, estatus = 0, id_pais = 0, id_estado = 0, id_municipio = 0, id_parroquia = 0, edad_min = null, edad_max = null, detalle_atencion = 0, org_id = 0, nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, nombre_direccion_remi, nombre_aten_cuidadano, nombre_estatus = null, nombre_estado = null, nombre_org_id) {

    // *******************************************************************
    // 🚩 CORRECCIÓN CLAVE PARA MOMENT.JS: Especificar el formato de entrada.
    // Usamos 'MM/DD/YY' según lo confirmado.
    // *******************************************************************
    const FORMATO_ENTRADA = "MM/DD/YY";
    
    // 1. Crear los objetos Moment con el formato de entrada
    const m_desde = moment(desde, FORMATO_ENTRADA);
    const m_hasta = moment(hasta, FORMATO_ENTRADA);

    // 2. Formatear solo si son fechas válidas
    let dataFormatada_desde = 'Invalid date';
    let dataFormatada_hasta = 'Invalid date';

    if (m_desde.isValid()) {
        dataFormatada_desde = m_desde.format("DD-MM-YYYY");
    }
    if (m_hasta.isValid()) {
        dataFormatada_hasta = m_hasta.format("DD-MM-YYYY");
    }

    var encabezado = '';

    // 3. Validar si AMBAS fechas son válidas para incluir en el encabezado
    if (m_desde.isValid() && m_hasta.isValid()) {
        encabezado += `Desde: ${dataFormatada_desde} hasta ${dataFormatada_hasta} `;
    }

    // -------------------------------------------------------------
    // El resto de tu lógica de encabezado (sin cambios mayores)
    // -------------------------------------------------------------
    if (tipo_pi != null) {
        encabezado += 'Tipo de Propiedad: ' + nombre_propiedad + ' ';
    }

    if (tipo_atencion_usu != null) {
        encabezado += 'Tipo de Atencion: ' + nombre_atencion + ' ';
    }

    if (sexo != null) {
        encabezado += 'Sexo: ' + nombresexo + ' ';
    }

    if (nombre_estado != null && nombre_estado != '' && nombre_estado != 'Seleccione') {
        encabezado += 'Estado: ' + nombre_estado + ' ';
    }

    if (edad_min != 'null' && edad_max != 'null' && edad_min != null && edad_max != null) {
        encabezado += 'Edad: Entre ' + edad_min + ' y ' + edad_max + ' ';
    }
    if (via_atencion != null && via_atencion != 'null' && via_atencion != undefined) {
        encabezado += 'Via de atencion: ' + nombre_via_atencion + ' ';
    }

    if (direcciones_caso != null && direcciones_caso != 'null' && direcciones_caso != undefined) {
        encabezado += 'Remitido a: ' + nombre_direccion_remi + ' ';
    }

    if (tipo_beneficiario != null && tipo_beneficiario != 0) {
        encabezado += 'Tipo beneficiario : ' + nombre_tipo_beneficiario + ' ';
    }
    if (atencion_cuidadano != null && atencion_cuidadano != 0) {
        encabezado += 'Atencion Cuidadano : ' + nombre_aten_cuidadano + ' ';
    }

    if (org_id != null && org_id != 0) {
        encabezado += 'Organismo del poder popular : ' + nombre_org_id + ' ';
    } else {
        org_id = 0;
    }


    if (estatus != null && estatus != 0) {
        encabezado += 'Estatus : ' + nombre_estatus + ' ';
    }

    let ruta_imagen = rootpath;
    // Si la tabla ya está inicializada, la destruimos para evitar errores de re-inicialización
    if ($.fn.DataTable.isDataTable('#table_casos')) {
        $('#table_casos').DataTable().destroy();
    }
    
    var table = $('#table_casos').DataTable({
        responsive: true,
        
        // Uso de 'dom' mejorado y consistente
        dom: 'l<"row"<"col-md-6"B><"col-md-6 text-right"f>>tip', 
        
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                        doc.pageMargins = [10, 115, 0, 70];
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
                                    height: 46,

                                },
                                {
                                    margin: [-800, 50, -25, 0],
                                    color: '#4c8aa0',
                                    fontSize: '18',
                                    alignment: 'center',
                                    text: 'Consolidado de Casos',
                                    fontSize: 18,
                                },
                                {
                                    margin: [-700, 80, -25, 0],
                                    // Se corrigió la asignación dentro del texto, usando el valor de 'encabezado'
                                    text: insertarSaltoDeLinea(encabezado, 100), 
                                },
                            ],
                        }
                    });
                    // Create a footer
                    doc['footer'] = (function(page, pages) {
                        return {
                            columns: [{
                                alignment: 'center',
                                text: ['pagina ', {
                                    text: page.toString()
                                }, ' of ', {
                                    text: pages.toString()
                                }]
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
                title: 'Consolidado de Casos',

                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
        // Se consolidaron las opciones de 'dom' aquí, eliminando la duplicidad
        // y usando la opción simplificada arriba 'dom: "l<"row"<"col-md-6"B><"col-md-6 text-right"f>>tip"'
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
    "autoWidth": true,
    //"dom": 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
    "serverSide": true,
    "ajax": {
        "url": "/reporte_consolidado",
        "type": "GET",
        "data": {
            desde: desde,
            hasta: hasta,
            tipo_pi: tipo_pi,
            tipo_atencion_usu: tipo_atencion_usu,
            sexo: sexo,
            via_atencion: via_atencion,
            direcciones_caso: direcciones_caso,
            tipo_beneficiario: tipo_beneficiario,
            atencion_cuidadano: atencion_cuidadano,
            estatus: estatus,
            id_pais: id_pais,
            id_estado: id_estado,
            id_municipio: id_municipio,
            id_parroquia: id_parroquia,
            edad_min: edad_min,
            edad_max: edad_max,
            detalle_atencion: detalle_atencion,
            org_id: org_id
        }
    },
    // **COLUMNAS**
    "columns": [
    { data: 'idcaso' },
    { data: 'cedula' },
    { data: 'tipo_beneficiario' },
    { data: 'nombre' },
    { data: 'casotel' },
    { data: 'tipo_prop_nombre' },
    { data: 'sexo' },
    { data: 'via_atencion_nombre' },
    { data: 'tipo_aten_nombre' },
    { data: 'descripcion' },
    { data: 'pais_nombre' },
    { data: 'estado_nombre' },
    { data: 'municipio_nombre' },
    { data: 'parroquia_nombre' },
    { data: 'organismo_pp_nombre' },
    { data: 'casofec' },
    { data: 'estnom' },
    { data: 'user_name' },
    { 
        // Columna para el botón de acción
        data: null,
        render: function(data, type, row) {
            // Se usa 'return' y solo se añade el idcaso como atributo
            return '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" ' +
                   'style="font-size:1px" data-toggle="tooltip" title="Seguimientos" ' +
                   'idcaso="' + row.idcaso + '">' + 
                   '  <i class="material-icons">search</i> ' +
                   '</a>';
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
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)", // Se agregó el placeholder de filtrado
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
        },
        "columnDefs": [{
            "targets": [0], "visible": false, "searchable": false
        }, ]
    },
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

// MÉTODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
// === OBJETO DE CONFIGURACIÓN DE IDIOMA DE DATATABLES ===
const datatablesLanguageConfig = {
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
};


// === FUNCIÓN PARA INICIALIZAR/RE-INICIALIZAR DATATABLES ===
function initializeSeguimientosDataTable() {
    // Si la tabla ya está inicializada, la destruimos
    if ($.fn.DataTable.isDataTable('#table_seguimientos')) {
        $('#table_seguimientos').DataTable().destroy();
    }
    
    // Inicializamos DataTables con las características necesarias
    $('#table_seguimientos').DataTable({
        "searching": true, 
        "paging": true,    
        "responsive": true, 
        "info": true,
        "ordering": true,
        "language": datatablesLanguageConfig 
    });
}
// ====================================================================
// === FUNCIÓN DE INICIALIZACIÓN DE DATATABLES (MODIFICADA) ===
// ====================================================================
function initializeSeguimientosDataTable() {
    // 1. Verificar si ya existe una instancia de DataTables
    if ($.fn.DataTable.isDataTable('#table_seguimientos')) {
        // Si existe, la destruimos para garantizar una re-inicialización limpia.
        // Esto sirve como un seguro, aunque el evento 'hidden.bs.modal' ya lo hace.
        $('#table_seguimientos').DataTable().destroy();
    }
    
    // 2. Inicializar la tabla de DataTables
    $('#table_seguimientos').DataTable({
        "responsive": true,
        "paging": true,
        "searching": true,
        "info": true,
        "ordering": true,
        // Configuración de idioma, CRUCIAL para DataTables
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
        // Nota: NO uses 'retrieve: true'
    });
}


// ====================================================================
// === EVENTOS CLAVE DE BOOTSTRAP MODAL ===
// ====================================================================

// 1. EVENTO: Inicializa DataTables cuando el modal se muestra (SHOWN)
//    Aquí es donde la tabla existe y tiene contenido del AJAX.
$('#modal-detalle-seguimientos').on('shown.bs.modal', function () {
    // Asegúrate de que el contenedor de la tabla esté visible
    $('#tl').show();
    
    // Inicializa/re-dibuja la tabla con los nuevos datos.
    initializeSeguimientosDataTable();
    
    // Llama a la API de DataTables para re-calcular el ancho.
    $('#table_seguimientos').DataTable().columns.adjust().responsive.recalc();
});

// 2. EVENTO CLAVE: Destruye DataTables y limpia al ocultarse el modal (HIDDEN)
//    Esto resuelve el problema de ver datos anteriores.
$('#modal-detalle-seguimientos').on('hidden.bs.modal', function () {
    // Verificar si existe una instancia antes de intentar destruirla
    if ($.fn.DataTable.isDataTable('#table_seguimientos')) {
        $('#table_seguimientos').DataTable().destroy();
    }
    
    // Opcional: Limpiar el cuerpo de la tabla para evitar flashes
    $('#listar_seguimientos').empty(); 
    
    // Ocultar el contenedor si tu lógica lo requiere
    $('#tl').hide(); 
});


// ====================================================================
// === MÉTODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS (AJAX) ===
// ====================================================================
$('#listar_casos').on('click', '.Seguimientos', function(e) {
    e.preventDefault();
    
    let $this = $(this);
    let idcaso = $this.attr('idcaso');
    const $modal = $('#modal-detalle-seguimientos');
    
    // Mostrar el modal inmediatamente
    $modal.modal('show'); 
    
    // Mostrar estado de carga
    $('#caso-id-titulo').text('...');
    $('#detalle-nombre').text('Cargando...'); 
    // Usar el elemento <tbody> (listar_seguimientos) para mostrar el spinner
    $('#listar_seguimientos').html('<tr><td colspan="5" class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Cargando datos del caso...</p></td></tr>');
    
    // Asumo que esta función existe y es síncrona/asíncrona
     buscar_documentos_casos(idcaso); 

    // Ejecutar la llamada AJAX
    $.ajax({
        url: '/DetalleCasoConsolidado/' + idcaso, 
        type: 'GET',
        dataType: 'json', 
        
        success: function(response) {
            if (response.success) {
                const data = response.caso_data;

                // 1. PINTAR LA INFORMACIÓN GENERAL DEL CASO
                $('#caso-id-titulo').text(data.idcaso);
                $('#id-caso').val(data.idcaso);
                $('#detalle-fecha-caso').text(data.fecha_caso);
                $('#detalle-nombre').text(data.nombre);
                $('#detalle-correo').text(data.correo);
                $('#detalle-estado').text(data.estado);
                $('#detalle-municipio').text(data.municipio);
                $('#detalle-parroquia').text(data.parroquia);
                $('#detalle-descripcion').text(data.casodesc);
                $('#detalle-unidad-adm').text(data.unidad_administrativa);
                $('#detalle-usuario-operador').text(data.usuario_operador);


                // 2. GENERAR Y PINTAR LA TABLA DE SEGUIMIENTOS
                let seguimientosHtml = '';
                response.seguimientos.forEach((seg, index) => {
                    seguimientosHtml += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${seg.fecha_segui}</td> 
                            <td class="text-center">${seg.desc_est_llamada}</td> 
                            <td class="text-center">${seg.user_name}</td> 
                            <td class="text-center">${seg.segcoment}</td> 
                        </tr>
                    `;
                });
                $('#listar_seguimientos').html(seguimientosHtml);

                // IMPORTANTE: No se llama a initializeSeguimientosDataTable() aquí.
                // Se llama en el evento 'shown.bs.modal'
            } else {
                 // Si hay error en la respuesta pero la llamada fue exitosa
                 $('#listar_seguimientos').html('<tr><td colspan="5" class="text-center py-4"><p class="alert alert-warning">Error: ' + response.message + '</p></td></tr>');
            }
        },
        
        error: function(xhr, status, error) {
            console.error("Error al cargar el detalle del caso: ", error);
            $('#listar_seguimientos').html('<tr><td colspan="5" class="text-center py-4"><p class="alert alert-danger">Hubo un error de conexión al cargar la información.</p></td></tr>');
        }
    });
});


//FUNCION PARA LLENAR EL COMBO DE LOS MUNICIPIOS EN FUNSION DEL ID DEL ESTADO
function buscar_documentos_casos(idcaso) {



let datos = {
    idcaso: idcaso,
};
$.ajax({
        url: "/buscar_documentos_casos",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .then((response) => {
        $("#docu-casos").html(response.data);

    })
    .catch((request) => {
        $("#docu-casos").val(0);
        Swal.fire("Error", response.JSONmessage, "Error");
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
    let detalle_atencion = $('#edit_detelle_atencion').val();
    let via_atencion = $('#via-atencion').val();
    let direcciones_caso = $('#direcciones_caso').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let atencion_cuidadano = $('#office').val();
    let estatus = $('#estatus').val();
    let tipo_pi = $('#tipo-pi').val();
    let tipo_atencion_usu = $('#tipo-atencion-usu').val();
    let sexo = $('#sexo').val();
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
    let nombre_aten_cuidadano = $('#office option:selected').text();
    let nombre_estatus = $('#estatus option:selected').text();
    let nombre_estado = $('#estado-caso option:selected').text();
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
    listar_reportes(desde, hasta, tipo_pi, tipo_atencion_usu, sexo, via_atencion, direcciones_caso, tipo_beneficiario,atencion_cuidadano,estatus,id_pais,id_estado,id_municipio,id_parroquia,edad_min,edad_max,detalle_atencion,org_id, nombre_propiedad, nombre_atencion, nombresexo, nombre_via_atencion, nombre_tipo_beneficiario, nombre_direccion_remi,nombre_aten_cuidadano,nombre_estatus,nombre_estado,nombre_org_id);
    }

})
$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();
    location.reload();

})


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
               
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
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
        llenar_Estados(Event, '26'); 
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
        llenar_Estados(Event); 

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