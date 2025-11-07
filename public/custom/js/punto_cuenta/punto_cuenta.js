$(function() {
    listar_Punto_Cuenta();
});


    
    // --- 1. FUNCIÓN DE LIMPIEZA CENTRALIZADA ---
    // Creamos una función que oculta la tarjeta y limpia los campos.
    function resetearFormularioAsociacion() {
        $("#card-detalle-caso").hide(); 
        $("#campo-nombre").val('');
        $("#campo-cedula").val('');
        $("#campo-telefono").val('');
        $("#campo-tipo-atencion").val('');
        $("#btn-asociar-caso").prop('disabled', true);
         $("#mensaje-punto-cuenta").html(""); // Limpiar el mensaje
        $("#mensaje-punto-cuenta").hide();
    }

    // --- 2. MANEJAR EVENTO DE CIERRE DEL MODAL ---
    // Escucha el evento que se dispara JUSTO ANTES de que el modal se oculte.
    $('#modal-casos').on('hide.bs.modal', function (e) {
        resetearFormularioAsociacion();
    });

   


/*
 * Función para definir datatable:
 */
function listar_Punto_Cuenta() {
    $('#table_punto_cuenta').DataTable({
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
            "url": "/Listar_Punto_Cuenta/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'id' },
            { data: 'numero_punto_cuenta' },
            { data: 'fecha_punto_cuenta' },
            { data: 'nombre' },
            { data: 'monto_aprobado' },
            { data: 'causa_beneficio' },

          {
                orderable: false,
                data: null,
                render: function(data, type, row) {
                return '<a href="javascript:void(0);" class="btn btn-xs btn-primary Editar" style="font-size:12px; padding: 2px 5px;" data-toggle="tooltip" title="Editar" data-id="' + row.id + '" data-numero-cuenta="' + row.numero_punto_cuenta + '" data-fecha-cuenta="' + row.fecha_punto_cuenta + '" data-nombre-completo="' + row.nombre + '" data-monto="' + row.monto_aprobado + '" data-causa="' + row.causa_beneficio + '" data-estado="' + row.estado + '"><i class="material-icons">create</i></a>' + ' '+
                      '<a href="javascript:void(0);" class="btn btn-xs btn-primary Casos" style="font-size:12px; padding: 2px 5px;" data-toggle="tooltip" title="Asociar" data-id="' + row.id + '" data-numero-cuenta="' + row.numero_punto_cuenta + '" data-fecha-cuenta="' + row.fecha_punto_cuenta + '" data-nombre-completo="' + row.nombre + '" data-monto="' + row.monto_aprobado + '" data-causa="' + row.causa_beneficio + '" data-estado="' + row.estado + '"><i class="material-icons">search</i></a>' ;
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
            }],
        }
    });
}
// //EVENTO PARA AGREGAR UN NUEVO PUNTO DE CUENTA
$(document).on('submit', "#form-add-punto-cuenta", function(e) {
    e.preventDefault();

    // 1. Obtener los valores de los campos del formulario "Punto de Cuenta"
    let numero_punto_cuenta = $("#numero_punto_cuenta").val();
    let fecha_punto_cuenta = $("#fecha_punto_cuenta").val();
    let nombre_beneficiario = $("#nombre_beneficiario").val().trim();
    let apellido_beneficiario = $("#apellido_beneficiario").val().trim();
    let monto_aprobado = $("#monto_aprobado").val();
    let causa_beneficiario = $("#causa_beneficiario").val().trim();

    // 2. Crear el objeto de datos
    let datos = {
        "numero_punto_cuenta": numero_punto_cuenta,
        "fecha_punto_cuenta": fecha_punto_cuenta,
        "nombre": nombre_beneficiario, // Usamos 'nombre' como en la BD
        "apellido": apellido_beneficiario, // Usamos 'apellido' como en la BD
        "monto_aprobado": monto_aprobado,
        "causa_beneficio": causa_beneficiario, // Usamos 'causa_beneficio' como en la BD
    };


    $.ajax({
        // **URL AJUSTADA:** Cambié el endpoint al lógico para Puntos de Cuenta
        url: "/add_Punto_Cuenta", 
        method: "POST",
        dataType: "JSON",
        data: {
            // Se mantiene la codificación con btoa y JSON.stringify
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            // Descomenta esta línea si quieres deshabilitar el botón al enviar
            //$("button[type=submit]").attr('disabled', 'true');
        },
        success: function(mensaje) {
            // Asumo que tu backend retorna 1 para éxito y 2 para error.
            if (mensaje == 1) {
                Swal.fire({
                    icon: "success",
                    type:"success",
                    html: '<strong>Registro Exitoso</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    // **REDIRECCIÓN AJUSTADA:** Cambié la redirección a la vista lógica
                    window.location = "/punto_cuenta"; 
                }, 1500);
            } else if (mensaje == 2) {
                Swal.fire({
                    icon: "error",
                    type:"error",
                    html: '<strong>Hubo un error al insertar el registro </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    window.location = "/punto_cuenta"; 
                }, 1500);
            }
        }
    });
});


// //MÉTODO PARA ABRIR EL MODAL PARA LA EDICIÓN DE PUNTO DE CUENTA
$('#listar_punto_cuenta').on('click', '.Editar', function(e) {
    e.preventDefault();
    
    const id = $(this).data('id');
    const numero_cuenta = $(this).data('numero-cuenta');
    const fecha_cuenta = $(this).data('fecha-cuenta');
    const monto = $(this).data('monto');
    const causa = $(this).data('causa');
    const nombre_completo = $(this).data('nombre-completo');
    const estado = $(this).data('estado'); // 'Activo' o 'Inactivo'
    const partes_nombre = nombre_completo.split(' ');
    const nombre = partes_nombre.shift() || ''; 
    const apellido = partes_nombre.join(' ') || ''; 



    let datos = {
        id: id,
    };

    $.ajax({
        url: "/buscar_documentos_punto",
        method: "POST",
        dataType: "JSON",
        // Codifica los datos para enviarlos de forma segura
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .done(function(response) {
        // Asume que el servidor devuelve { message: "success", data: "<option>...</option>" }
        // Se usa .html() para reemplazar el contenido del select
        if (response.message === "success" && response.data) {
            $("#docu-punto").html(response.data);
        } else {
            // Manejo de caso en el que no hay documentos
            $("#docu-punto").html('<option value="0" selected disabled>No se encontraron documentos</option>');
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        // jqXHR contiene la respuesta del servidor (status, responseText, etc.)
        console.error("Error al buscar documentos:", textStatus, errorThrown, jqXHR.responseJSON);
        // Muestra un mensaje de error al usuario
        let errorMessage = "Error desconocido";
        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
             errorMessage = jqXHR.responseJSON.message;
        } else if (errorThrown) {
             errorMessage = errorThrown;
        }

        $("#docu-punto").html('<option value="0" selected disabled>No hay documentos asociados</option>');
       
    });

    $('#archivo').val(''); 

    $("#editar").modal("show"); 
    $('#edit_numero_punto_cuenta').val(numero_cuenta);
    $('#edit_fecha_punto_cuenta').val(fecha_cuenta);
    $('#edit_nombre_beneficiario').val(nombre);
    $('#edit_apellido_beneficiario').val(apellido);
    $('#edit_monto_aprobado').val(monto);
    $('#edit_causa_beneficiario').val(causa);
    $('#id_punto_cuenta_editar').val(id);
    const checkboxBorrado = $('#borrado');
    
    if (estado === 'Activo') {
        checkboxBorrado.prop('checked', true);
        checkboxBorrado.val('false'); 
        checkboxBorrado.siblings('label').text('Activo');

    } else if (estado === 'Inactivo') {
        checkboxBorrado.prop('checked', false);
        checkboxBorrado.val('true');
        checkboxBorrado.siblings('label').text('Inactivo');
    }
    checkboxBorrado.off('change').on('change', function() {
        if ($(this).is(':checked')) {
            $(this).val('false');
            $(this).siblings('label').text('Activo');
        } else {
            $(this).val('true');
            $(this).siblings('label').text('Inactivo');
        }
    });

});

// //EVENTO PARA GUARDAR LA EDICIÓN DE PUNTO DE CUENTA
$(document).on('submit', "#form-edit-punto-cuenta", function(e) {
    e.preventDefault();
    let id_punto_cuenta = $("#id_punto_cuenta_editar").val(); // Campo oculto que creamos
    let numero_punto_cuenta = $("#edit_numero_punto_cuenta").val();
    let fecha_punto_cuenta = $("#edit_fecha_punto_cuenta").val();
    let nombre_beneficiario = $("#edit_nombre_beneficiario").val().trim();
    let apellido_beneficiario = $("#edit_apellido_beneficiario").val().trim();
    let monto_aprobado = $("#edit_monto_aprobado").val();
    let causa_beneficio = $("#edit_causa_beneficiario").val().trim();

  
    let borrado;
   
    if ($('#borrado').is(':checked')) {
        borrado = 'false'; 
    } else {
      
        borrado = 'true';
    }


    let datos = {
        "id": id_punto_cuenta, 
        "numero_punto_cuenta": numero_punto_cuenta,
        "fecha_punto_cuenta": fecha_punto_cuenta,
        "nombre": nombre_beneficiario, 
        "apellido": apellido_beneficiario, 
        "monto_aprobado": monto_aprobado,
        "causa_beneficio": causa_beneficio,
        "borrado": borrado, 
    };

    $.ajax({
       
        url: "/edit_Punto_Cuenta", 
        method: "POST",
        dataType: "JSON",
        data: {
           
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            
        },
        success: function(mensaje) {
            if (mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type:"success",
                    html: '<strong>Registro Actualizado </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                setTimeout(function() {
                
                    window.location = "/punto_cuenta";
                }, 1500);
            } else if (mensaje === 2) {
                Swal.fire({
                    icon: "error",
                    type:"error",
                    html: '<strong>Hubo un error en la actualización del registro</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    window.location = "/punto_cuenta";
                }, 1500);
            }
        }
    });
});




// Lógica para abrir el modal, mostrar detalles y cargar casos asociados.
$('#listar_punto_cuenta').on('click', '.Casos', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const numero_cuenta = $(this).data('numero-cuenta');
    const fecha_cuenta_original = $(this).data('fecha-cuenta'); // Se renombra la variable original
    const monto = $(this).data('monto');
    const causa = $(this).data('causa');
    const nombre_completo = $(this).data('nombre-completo');
    
    // ----------------------------------------------------
    // ✨ LÓGICA DE REFORMATEO DE FECHA (dd/mm/yy)
    // ----------------------------------------------------
    let fecha_formateada = fecha_cuenta_original;

    // Intenta reformatear si la fecha tiene el formato YYYY-MM-DD (o similar)
    if (fecha_cuenta_original && fecha_cuenta_original.includes('-')) {
        try {
            const dateParts = fecha_cuenta_original.split('-'); // Asume YYYY-MM-DD
            
          
            if (dateParts.length === 3) {
                
                const dia = dateParts[2];
                const mes = dateParts[1];
                const año_corto = dateParts[0].substring(2); 

                fecha_formateada = `${dia}/${mes}/${año_corto}`;
            }
        } catch (error) {
            console.error("Error al formatear la fecha:", error);
            // En caso de error, se mantiene el valor original
        }
    }
    // ----------------------------------------------------
    
    $("#modal-casos").modal("show");
    $('#detalle-numero-cuenta').text(numero_cuenta);
    $('#detalle-nombre-completo').text(nombre_completo);
    $('#detalle-fecha').text(fecha_formateada); 
    $('#detalle-monto').text(monto);
    $('#detalle-causa').text(causa);
    $('#caso-id-punto-cuenta').val(id);
    $('#form-asociar-caso').trigger('reset');
    cargarCasosAsociados(id); 
});
/**
 * Carga y muestra los casos asociados a un punto de cuenta en una tabla DataTables, 
 * incluyendo la configuración de botones de exportación con diseño personalizado y estético en PDF/Excel.
 * @param {string} id_punto_cuenta ID del punto de cuenta.
 */
// **Función toUnicodeBold ELIMINADA **

function cargarCasosAsociados(id_punto_cuenta) {
    
    // 1. CAPTURA DE INFORMACIÓN DE DETALLE
    const numero_cuenta = $('#detalle-numero-cuenta').text();
    const nombre_completo = $('#detalle-nombre-completo').text();
    const fecha = $('#detalle-fecha').text();
    const monto = $('#detalle-monto').text();
    const causa = $('#detalle-causa').text();
    const detalleExportacion = [
        { label: 'Nombre Aprobador:', value: nombre_completo }, 
        { label: 'Causa:', value: causa },
        { label: 'Fecha:', value: fecha },
        { label: 'Monto Aprobado:', value: monto }
    ];
    
    // Lista de los nombres de columna como STRINGS SIMPLES.
    const nombresColumnas = [
        'Número de Caso', 
        'Nombre', 
        'Tipo de Atención', 
        'Detalle de Atención'
    ];

    
    let ruta_imagen = rootpath; 
    const $contenedorTabla = $("#lista-casos-asociados");
    $contenedorTabla.html('<p class="text-muted m-0 p-4 border rounded"><i class="fas fa-sync fa-spin mr-2 text-primary"></i> Cargando casos asociados...</p>');
    if ($.fn.DataTable.isDataTable('#tabla-casos-data')) {
        $('#tabla-casos-data').DataTable().destroy();
    }
    
    $.ajax({
        url: "/cargarCasosAsociados/" + id_punto_cuenta,
        method: "GET",
        dataType: "JSON",
    })
    .then((response) => {
        if (response && response.length > 0) {
            
            const dataTableData = response.map(caso => {
                return {
                    'id_caso': caso.id_caso,
                    'nombre': caso.nombre,
                    'tipo_aten_nombre': caso.tipo_aten_nombre || 'N/A',  
                    'tipo_atend_nombre': caso.tipo_atend_nombre || 'N/A', 
                };
            });
            
            let htmlTabla = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tabla-casos-data">
                        <thead>
                            <tr class="bg-light">
                                <th>Número de Caso</th>
                                <th>Nombre</th>
                                <th>Tipo de Atención</th>
                                <th>Detalle de Atención</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            `;
            $contenedorTabla.html(htmlTabla);
            
            $('#tabla-casos-data').DataTable({
                data: dataTableData, 
                dom: "<'row mb-3'<'col-sm-12'B>>" + 
                      "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", 
                responsive: true,
                order: [[0, 'asc']], 
                buttons: [
                    // --- Configuración del Botón PDF (Omitida por brevedad) ---
                    // ... (El bloque PDF permanece igual) ...
                    {
                        extend: "pdf",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn-xs btn-dark mr-2', 
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                        header: true,
                        footer: true,
                        download: 'open',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        alignment: 'center',
                        customize: function(doc) {
                            
                            let detailBody = [];
                            const ROW_HEIGHT_PDF = 25; 
                            const CELL_MARGIN = [10, 5, 0, 5]; 
                            const LIGHT_FILL = '#F5F5F5';
                            const FONT_SIZE = 9;

                            detailBody.push([
                                { text: detalleExportacion[0].label, bold: false, fontSize: FONT_SIZE, color: '#555555', margin: CELL_MARGIN, fillColor: LIGHT_FILL }, 
                                { text: detalleExportacion[0].value, fontSize: FONT_SIZE, bold: true, margin: CELL_MARGIN },
                                { text: detalleExportacion[1].label, bold: false, fontSize: FONT_SIZE, color: '#555555', margin: CELL_MARGIN, fillColor: LIGHT_FILL }, 
                                { text: detalleExportacion[1].value, fontSize: FONT_SIZE, bold: true, margin: CELL_MARGIN } 
                            ]);
                            
                            detailBody.push([
                                { text: detalleExportacion[2].label, bold: false, fontSize: FONT_SIZE, color: '#555555', margin: CELL_MARGIN, fillColor: LIGHT_FILL }, 
                                { text: detalleExportacion[2].value, fontSize: FONT_SIZE, bold: true, margin: CELL_MARGIN },
                                { text: detalleExportacion[3].label, bold: false, fontSize: FONT_SIZE, color: '#555555', margin: CELL_MARGIN, fillColor: LIGHT_FILL }, 
                                { text: detalleExportacion[3].value, fontSize: FONT_SIZE, bold: true, margin: CELL_MARGIN }
                            ]);
                            
                            const LOGO_MARGIN_TOP = 40; 
                            const FORM_TITLE_Y = LOGO_MARGIN_TOP + 60; 
                            const FORM_BODY_Y = FORM_TITLE_Y + 25; 
                            
                            const SEPARATOR_Y = FORM_BODY_Y + (2 * ROW_HEIGHT_PDF) + 10; 
                            const TABLE_TITLE_Y = SEPARATOR_Y + 15; 
                            
                            
                            const detailTableStructure = {
                                layout: {
                                    defaultBorder: false, 
                                    paddingLeft: function(i, node) { return 0; },
                                    paddingRight: function(i, node) { return 0; },
                                    paddingTop: function(i, node) { return 0; },
                                    paddingBottom: function(i, node) { return 0; },
                                },
                                table: {
                                    widths: [100, 220, 120, '*'], 
                                    body: detailBody
                                },
                                absolutePosition: { x: 40, y: FORM_BODY_Y } 
                            };
                            
                            const detailTitleStructure = {
                                columns: [
                                    {
                                        text: [{ text: '  Punto de Cuenta', color: '#1a75ff', fontSize: 10, bold: true, background: 'white' }],
                                        width: 'auto'
                                    },
                                    {
                                        text: numero_cuenta,
                                        alignment: 'right',
                                        color: 'white',
                                        background: '#17a2b8', 
                                        fontSize: 9,
                                        bold: true,
                                        margin: [0, 0, 5, 0], 
                                        width: 100
                                    }
                                ],
                                columnGap: 10,
                                absolutePosition: { x: 40, y: FORM_TITLE_Y } 
                            };
                            
                            const mainTitleStructure = {
                                text: 'Casos Asociados ',
                                color: '#4c8aa0',
                                fontSize: 14,
                                bold: true,
                                alignment: 'center', 
                                absolutePosition: { x: 0, y: TABLE_TITLE_Y } 
                            };

                            const finalSeparatorStructure = {
                                canvas: [{
                                    type: 'line',
                                    x1: 40, y1: 0,
                                    x2: 790, y2: 0, 
                                    lineWidth: 0.5,
                                    lineColor: '#CCCCCC'
                                }],
                                absolutePosition: { x: 0, y: SEPARATOR_Y }
                            };

                            doc.content.splice(0, 1);
                            doc.styles.title = { color: '#4c8aa0', fontSize: '18', alignment: 'center' };
                            doc.styles.tableHeader = { fillColor: '#4c8aa0', color: 'white', alignment: 'center' };
                            
                            doc.pageMargins = [40, TABLE_TITLE_Y + 20, 0, 70]; 
                            
                            doc['header'] = (function(page, pages) {
                                return {
                                    stack: [ 
                                        { columns: [{ margin: [10, LOGO_MARGIN_TOP, 40, 40], image: ruta_imagen, width: 780, height: 50 }] },
                                        
                                        detailTitleStructure, 
                                        detailTableStructure, 
                                        finalSeparatorStructure,
                                        mainTitleStructure
                                    ], 
                                }
                            });
                            
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                        alignment: 'center',
                                        text: ['pagina ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                                    }],
                                }
                            });
                        }
                    },
                    // --------------------------------------------------------------------------------------
                    // ** CONFIGURACIÓN DEL BOTÓN EXCEL (CON ORDEN Y COLORES ESTABLES) **
                    // --------------------------------------------------------------------------------------
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel', 
                        className: 'btn-xs btn-dark',
                        title: null, 
                        download: 'open',
                        exportOptions: { columns: [0, 1, 2, 3] },
                        // Nombre de Archivo FIJO
                        filename: 'Casos asociados', 
           customizeData: function(data) {
    var numColumns = data.header.length; 
    const rowsToPrepend = []; // Array que almacena las filas a insertar
    
    // A. Insertamos el TÍTULO (Fila 1)
    const titleRow = ['Casos Asociados'].concat(Array(numColumns - 1).fill(null));
    rowsToPrepend.push(titleRow);
    
    // B. Insertamos los DETALLES (Filas 2-5)
    detalleExportacion.forEach(item => {
        // Texto simple
        const styledLabel = item.label; 
        const detailRow = [styledLabel, item.value].concat(Array(numColumns - 2).fill(null));
        rowsToPrepend.push(detailRow); 
    });
    
    // C. Insertamos UNA FILA VACÍA para separación (Fila 6).
    const emptyRow = Array(numColumns).fill(null);
    rowsToPrepend.push(emptyRow); 
    
    // D. Insertamos los NOMBRES DE COLUMNA (Fila 7)
    const styledNombresColumnas = nombresColumnas; // Texto simple
    rowsToPrepend.push(styledNombresColumnas); 

    // E. Insertamos UNA FILA VACÍA de separación final (Fila 8)
    rowsToPrepend.push(emptyRow); 
    
    // 2. Insertamos el bloque completo al inicio del data.body.
    data.body.splice(0, 0, ...rowsToPrepend);
    
    // 3. Eliminamos el encabezado original.
    data.header = [];
},

                        
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var r = $('sheetData', sheet);
                            
                            // 1. Configuración de Autoajuste de Ancho de Columna
                            var cols = $('cols', sheet);
                            if (!cols.length) {
                                cols = sheet.createElement('cols');
                                $(cols).insertBefore(r[0]);
                            }
                            for (var i = 0; i < nombresColumnas.length; i++) {
                                $(cols).append('<col min="' + (i + 1) + '" max="' + (i + 1) + '" width="20" customWidth="1" autoWidth="1"/>');
                            }
                        },

                        // ** ESTILOS: Aplicación de color y negrita con RGB directo **
                        excelStyles: [
                            // Estilo BASE: Fuente general (más pequeño)
                            {
                                "cells": "A1:D1000",
                                "style": { "font": { "sz": 10 } }
                            },
                            // Estilo para el TÍTULO (Fila 1) - Azul atractivo
                            {
                                "cells": "A1:D1",
                                "style": {
                                    "fill": { "patternType": "solid", "fgColor": { "rgb": "1E90FF" } }, // Azul
                                    "font": { "color": { "rgb": "FFFFFF" }, "bold": true, "sz": 14 }, // Blanco, negrita, grande
                                    "alignment": { "horizontal": "center" },
                                    "border": { "top": { "style": "medium" }, "bottom": { "style": "medium" }, "left": { "style": "medium" }, "right": { "style": "medium" } }
                                }
                            },
                            // Estilo para el área de DETALLES (Filas 2-5)
                            {
                                "cells": "A2:D5",
                                "style": {
                                    // FONDO GRIS CLARO - Usamos RGB directo para más estabilidad
                                    "fill": { "patternType": "solid", "fgColor": { "rgb": "E0E0E0" } },
                                    "font": { "bold": true }, // Negrita para las etiquetas
                                    "border": { "top": { "style": "thin" }, "bottom": { "style": "thin" }, "left": { "style": "thin" }, "right": { "style": "thin" } }
                                }
                            },
                            // Estilo para los VALORES DE DETALLE (Columna B, Filas 2-5) - Quitamos la negrita en los valores
                            {
                                "cells": "B2:B5",
                                "style": {
                                    "font": { "bold": false }
                                }
                            },
                            // Estilo para la fila de ENCABEZADOS DE COLUMNA (Fila 7)
                            {
                                "cells": "A7:D7",
                                "style": {
                                    // FONDO GRIS MÁS OSCURO - Usamos RGB directo para más estabilidad
                                    "fill": { "patternType": "solid", "fgColor": { "rgb": "C8C8C8" } },
                                    "font": { "bold": true },
                                    "alignment": { "horizontal": "center" },
                                    "border": { "top": { "style": "medium" }, "bottom": { "style": "medium" } }
                                }
                            }
                        ]
                    }
                ],
                // --- Definición de Columnas y Opciones ---
                columns: [
                    { data: 'id_caso', title: 'Número de Caso' },
                    { data: 'nombre', title: 'Nombre' }, 
                    { data: 'tipo_aten_nombre', title: 'Tipo de Atención' },
                    { data: 'tipo_atend_nombre', title: 'Detalle de Atención' },
                ],
                paging: true,
                pageLength: 10,
                searching: true,
                info: true,
                order: [[0, 'asc']], 

                language: {
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
           
                },
                columnDefs: [
                    { "targets": [0], "visible": true, "searchable": true }
                ],
            });
         }
        else {
            $contenedorTabla.html(`
                <div class="alert alert-success p-4 m-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2 fa-lg"></i> 
                    No se encontraron casos asociados a este punto de cuenta.
                </div>
            `);
        }
    })
    .catch((jqXHR, textStatus, errorThrown) => {
        console.error("Error al cargar casos asociados:", textStatus, errorThrown, jqXHR);
        $contenedorTabla.html(`
            <div class="alert alert-danger p-4 m-0 shadow-sm" role="alert">
                <i class="fas fa-times-circle mr-2 fa-lg"></i> 
                Ocurrió un error al intentar cargar los casos. Intente de nuevo.
            </div>
        `);
    });
}
$(document).on('submit', "#form-asociar-caso", function(e) {
    // 1. Prevenir el envío estándar del formulario
    e.preventDefault();

    // 2. Cachear elementos para eficiencia
    const $form = $(this);
    const $submitBtn = $form.find(':submit'); // Encontrar el botón de submit dentro del formulario

    // 3. Obtener valores y limpiar los espacios en blanco
    const id_punto_cuenta = $.trim($('#caso-id-punto-cuenta').val());
    const id_caso = $.trim($('#inputnuevocaso').val());

    // 4. Validación robusta de campos
    if (!id_punto_cuenta) {
        alert("⚠️ Falta el ID del Punto de Cuenta.");
        $('#caso-id-punto-cuenta').focus(); // Mejor UX: enfocar el campo
        return;
    }

    if (!id_caso) {
        alert("⚠️ Falta el ID del Caso a asociar.");
        $('#inputnuevocaso').focus(); // Mejor UX: enfocar el campo
        return;
    }

    // 5. Preparar los datos (estructura clara y sin cambios)
    const datos_asociacion = {
        "id_punto_cuenta": id_punto_cuenta,
        "id_caso": id_caso,
    };

    // 6. Llamada AJAX
    $.ajax({
        url: 'asociar_casos',
        type: 'POST',
        data: datos_asociacion,
        dataType: 'json',

        // 7. Antes de enviar: Deshabilita el botón y da feedback
        beforeSend: function() {
            // Se usa .html() para permitir añadir un spinner si se desea, pero por ahora solo cambia el texto.
            $submitBtn.prop('disabled', true).text('Asociando...');
        },

        // 8. Éxito
        success: function(response) {
            if (response.success) {
                alert("✅ Caso asociado exitosamente.");
                 window.location = "/punto_cuenta";
            } else {
                // Captura el mensaje del servidor o usa un fallback
                const mensaje_error = response.message || "Error desconocido al asociar el caso.";
                alert(" Error al asociar el caso: " + mensaje_error);
                window.location = "/punto_cuenta";
            }
        },

       
    });
});
 // ... (Código anterior)

// EVENTO PARA VERIFICAR UN CASO (Lógica adaptada)
$(document).on('click', "#btnverificarcaso", function(e) {
    e.preventDefault();
    let inputnuevocaso = $("#inputnuevocaso").val();
    inputnuevocaso = inputnuevocaso.trim();
    const $cardDetalle = $("#card-detalle-caso");
    const $btnAsociar = $("#btn-asociar-caso");
    const $btnVerificar = $(this); 
    const $mensajePuntoCuenta = $("#mensaje-punto-cuenta");

   

    // Si el campo está vacío
    if (inputnuevocaso === "") {
        // Usamos el reset centralizado para limpiar todo
        resetearFormularioAsociacion(); 
        alert("Por favor, ingrese un número de caso para verificar.");
        return; 
    }
   
    // Limpiamos los detalles antes de iniciar la nueva búsqueda (por si se cambió el número)
    resetearFormularioAsociacion(); 

    // 1. Mostrar estado de carga
    $btnVerificar.html('<i class="fas fa-spinner fa-spin"></i>');
    $btnVerificar.prop('disabled', true);

    $.ajax({
        url: 'verificar_caso/'+inputnuevocaso,
        type: 'get',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response && response.length > 0) {
                const caso = response[0];

                // POBLAR LOS CAMPOS (usando .val() correctamente)
                $("#campo-nombre").val(caso.nombre); 
                $("#campo-telefono").val(caso.casotel); 
                $("#campo-cedula").val(caso.cedula);
                $("#campo-tipo-atencion").val(caso.tipo_aten_nombre);
                
                // MOSTRAR la tarjeta de detalles
                $cardDetalle.slideDown(); 
                
                // ----------------------------------------------------
                // ✨ LÓGICA DE PUNTO DE CUENTA AÑADIDA ✨
                // ----------------------------------------------------
                if (caso.act_punto_cuenta === "f") {
                    // Deshabilitar botón y mostrar mensaje
                    $btnAsociar.prop('disabled', true);
                    $("#mensaje-punto-cuenta").show();
                    $mensajePuntoCuenta.html('<span class="text-danger font-weight-bold"><i class="fas fa-ban"></i> Este tipo de atención no tiene acceso al punto de cuenta.</span>');
                } else {
                    // Habilitar el botón y limpiar mensaje (si existe)
                    $btnAsociar.prop('disabled', false);
                    $mensajePuntoCuenta.html(''); // Limpiar el mensaje si estaba antes
                }
                // ----------------------------------------------------
                
                $btnVerificar.html('<i class="fas fa-search"></i>').prop('disabled', false); // Restaurar botón
                
            } else {
                // Caso no encontrado: Llama al reset centralizado
                resetearFormularioAsociacion(); 
                alert("Error al verificar el caso: La id_caso no se encontró o es inválida.");
                $btnVerificar.html('<i class="fas fa-search"></i>').prop('disabled', false); // Restaurar botón
            }
        },
        error: function(xhr, status, error) {
            // Error: Llama al reset centralizado
            resetearFormularioAsociacion(); 
            alert("Ocurrió un error de conexión con el servidor. Por favor, intente de nuevo. Código: " + xhr.status);
            $btnVerificar.html('<i class="fas fa-exclamation-triangle"></i>').prop('disabled', false); // Restaurar botón con error
        }
    });
});
  

//Evento para subir archivos
$(document).on("click", "#subir_archivos", (e) => {
    e.preventDefault();
    var archivo = document.getElementById("archivo").files[0]; // Obtiene el archivo seleccionado
    var id_punto_cuenta = document.getElementById("id_punto_cuenta_editar").value;
    var formData = new FormData(); // Crea un objeto FormData
    formData.append("archivo", archivo);
    formData.append("id_punto_cuenta", id_punto_cuenta); // Agrega el archivo al objeto FormData
    $.ajax({
        url: "/upload_docu_punto_cuenta",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>ERROR EL ARCHIVO YA EXISTE.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // setTimeout(function() {
                //     window.location = "/casos";
                // }, 1600);
            } else if (data == 1) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>ERROR EL ARCHIVO ES DEMASIADO GRANDE.</strong>',

                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                setTimeout(function() {

                }, 1600);
            }

            if (data == 2) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>ARCHIVO CARGADO EXITOSAMENTE.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                setTimeout(function() {
                    let datos = {
        id: id_punto_cuenta,
    };

    $.ajax({
        url: "/buscar_documentos_punto",
        method: "POST",
        dataType: "JSON",
        // Codifica los datos para enviarlos de forma segura
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .done(function(response) {
        // Asume que el servidor devuelve { message: "success", data: "<option>...</option>" }
        // Se usa .html() para reemplazar el contenido del select
        if (response.message === "success" && response.data) {
            $("#docu-punto").html(response.data);
        } else {
            // Manejo de caso en el que no hay documentos
            $("#docu-punto").html('<option value="0" selected disabled>No se encontraron documentos</option>');
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        // jqXHR contiene la respuesta del servidor (status, responseText, etc.)
        console.error("Error al buscar documentos:", textStatus, errorThrown, jqXHR.responseJSON);
        // Muestra un mensaje de error al usuario
        let errorMessage = "Error desconocido";
        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
             errorMessage = jqXHR.responseJSON.message;
        } else if (errorThrown) {
             errorMessage = errorThrown;
        }

        $("#docu-punto").html('<option value="0" selected disabled>No hay documentos asociados</option>');
       
    });
                   
                }, 1600);
            } else if (data == 3) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>HUBO UN ERROR AL CAGAR EL ARCHIVO.</strong>',

                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else if (data == 4) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR UN ARCHIVO.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }else if (data == 5) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Tipo de archivo no permitido.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
            else if (data == 6) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Tipo de archivo no coincide con el contenido.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
            else if (data == 7) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Error al agregar a la base de datos.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
            else if (data == 8) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Nombre de archivo inválido. Las extensiones dobles no están permitidas.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
            else if (data == 9) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>El archivo no es una imagen válida.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }


        },
        error: function(xhr, status, error) {
            // Aquí puedes manejar los errores
        }
    });
});