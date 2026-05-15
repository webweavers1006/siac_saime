$(function() {
    // Al cargar la página, leemos el valor inicial del select (por si tiene uno por defecto)
    let estatus_inicial = $('#estatus').val();
    Listar_Casos(estatus_inicial);

    // Escuchar el cambio en el select de filtrado
    $('#estatus').on('change', function() {
        let estatus_seleccionado = $(this).val();
        
        // Volvemos a llamar a la función pasando el nuevo estatus
        Listar_Casos(estatus_seleccionado);
    });
});

$('#btn_agregar').on('click', function(e) {
    window.location = '/vista_agregar_caso';
});

/*
 * Función para definir datatable de casos:
 */
/*
 * Función para definir datatable de casos:
 */
function Listar_Casos(estatus = null) {
    let ruta_imagen = rootpath;
    var encabezado = '';
    
    var table = $('#table_casos').DataTable({
        destroy: true, // Permite reinicializar la tabla al cambiar el filtro sin errores
        responsive: true,
        // Orden descendente por la columna 0 (casos_id) para mostrar los últimos primero
        "order": [[0, "desc"]],
        dom: 'Blfrtip',
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
                    // Configuración de PDF
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
                        doc.content.splice(0, 1);
                        doc.styles.title = {
                            color: '#4c8aa0',
                            fontSize: '18',
                            alignment: 'center'
                        };
                        doc.styles['td:nth-child(2)'] = {
                            width: '130px',
                            'max-width': '130px'
                        };
                        doc.styles.tableHeader = {
                            fillColor: '#4c8aa0',
                            color: 'white',
                            alignment: 'center'
                        };
                        doc.pageMargins = [40, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
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
                                        text: 'Control de Casos',
                                        fontSize: 18,
                                        alignment: 'center',
                                    },
                                    {
                                        margin: [-600, 80, -25, 0],
                                        text: encabezado,
                                    },
                                ],
                            };
                        });
                        doc['footer'] = (function(page, pages) {
                            return {
                                columns: [{
                                    alignment: 'center',
                                    text: ['página ', { text: page.toString() }, ' de ', { text: pages.toString() }]
                                }],
                            };
                        });
                    },
                },
                {
                    // Configuración de Excel
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: 'Control de Casos',
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    excelStyles: {
                        "template": ["blue_medium", "header_blue", "title_medium"]
                    },
                }
            ]
        },
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],
        "ordering": true,
        "info": true,
        autoWidth: false,
        ajax: {
            url: "/listar_Casos_Remitidos",
            type: "GET",
            data: function (d) {
                d.estatus = estatus; // Enviamos el estatus como parámetro al controlador
            },
            dataSrc: ''
        },
        columns: [
            { data: 'casos_id', width: "1%" },
            { data: 'cedula', width: "10%" },
            { data: 'nombre', width: "20%" },
            { data: 'casotel', width: "10%" },
            { data: 'tipo_prop_nombre', width: "15%" },
            { data: 'tipo_aten_nombre', width: "12%" },
            { data: 'casofec', width: "5%" },
            { data: 'estnom', width: "3%" },
            { data: 'user_name', width: "10%" },
            {
                data: null,
                width: "15%",
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style="font-size:1px" 
                            data-toggle="tooltip" title="Seguimientos" 
                            data-idcaso="${row.casos_id}">
                            <i class="material-icons">search</i>
                        </a>
                        <a href="javascript:;" class="btn btn-xs btn-success Remitir" style="font-size:1px" 
                            data-toggle="tooltip" title="Remitir" 
                            data-idcaso="${row.casos_id}" 
                            data-tipo_atend_id="${row.tipo_atend_id}">
                            <i class="material-icons">redo</i>
                        </a>
                        <a href="javascript:;" class="btn btn-xs btn-dark Imprimir" style="font-size:1px" 
                            data-toggle="tooltip" title="Imprimir" 
                            data-idcaso="${row.casos_id}">
                            <i class="material-icons">print</i>
                        </a> `;
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
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        columnDefs: [{
            "targets": [0],
            "visible": true, // COLUMNA ID VISIBLE
            "searchable": true
        }],
        initComplete: function(settings, json) {
            let savedPage = localStorage.getItem('datatable_page');
            if (savedPage !== null) {
                table.page(parseInt(savedPage)).draw(false);
                localStorage.removeItem('datatable_page');
            }
        }
    });

    // Guardar estado de paginación
    table.on('page.dt', function () {
        let info = table.page.info();
        localStorage.setItem('datatable_page', info.page);
    });
}
// --- MANEJADORES DE EVENTOS ---

$('#listar_casos').on('click', '.Imprimir', function(e) {
    e.preventDefault();
    let idcaso = $(this).data('idcaso');
    window.open('generar_pdf/' + idcaso, '_blank');
});

$('#listar_casos').on('click', '.Seguimientos', function(e) {
    e.preventDefault();
    let idcaso = $(this).data('idcaso');
    window.location = '/verCaso/' + idcaso;
});

$('#listar_casos').on('click', '.Remitir', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('data-idcaso');
    $("#remitir_caso").modal("show");
    $("#remitir_caso").find('#idcaso').val(idcaso);
});

$("#estatus").on('change', function(e) {
    let estatus = $('#estatus').val();
    $("#table_casos").dataTable().fnDestroy();
    Listar_Casos(estatus);
});

// Manejo del formulario de remisión AJAX
$(document).on("submit", "#caso-remitido", function(e) {
    e.preventDefault();
    const $btnSubmit = $(this).find("button[type='submit']");
    const $contenedorMensaje = $("#mensaje");

    let datos = {
        "id_caso": $("#idcaso").val(),
        "direccion": $("#direcciones_caso").val(),
        "nombre_direccion": $('#direcciones_caso option:selected').text()
    };

    $.ajax({
        url: "/remitirCaso",
        method: "POST",
        dataType: "JSON",
        data: { data: btoa(unescape(encodeURIComponent(JSON.stringify(datos)))) },
        beforeSend: function() {
            $btnSubmit.attr('disabled', 'true').html('<i class="fas fa-spinner fa-spin mr-1"></i> Remitiendo...');
            $contenedorMensaje.hide().removeClass('alert-success alert-danger').addClass('alert-info')
                .html('<i class="fas fa-sync fa-spin mr-2"></i> Procesando remisión...').fadeIn();
        },
        success: function(respuesta) {
            if (respuesta.mensaje === 1) {
                $contenedorMensaje.removeClass('alert-info alert-danger').addClass('alert-success')
                    .html('<strong>¡ÉXITO!</strong> El caso Nº ' + respuesta.idcaso + ' ha sido remitido con éxito.');
                setTimeout(function() {
                    window.location = "/vista_casos_remitidos";
                }, 1600);
            } else {
                let textoError = (respuesta.mensaje === 3) ? 'La dirección no tiene correo asociado.' : 'No se pudo completar la remisión.';
                $contenedorMensaje.removeClass('alert-info alert-success').addClass('alert-danger').html('<strong>ERROR:</strong> ' + textoError);
                $btnSubmit.removeAttr('disabled').html('<i class="fas fa-check-circle mr-2"></i> Confirmar Remisión');
            }
        },
        error: function() {
            $contenedorMensaje.removeClass('alert-info').addClass('alert-danger').html('<strong>Error Crítico:</strong> El servidor no responde.');
            $btnSubmit.removeAttr('disabled').html('<i class="fas fa-check-circle mr-2"></i> Confirmar Remisión');
        }
    });
});