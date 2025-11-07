/*
 *Este es el document ready
 */
$(function() {
    
    
    listar_Participantes_Mediacion();
   
});



function listar_Participantes_Mediacion() {


 
    var encabezado = '';
   
    let ruta_imagen = rootpath;
    var table = $('#table_participantes_mediacion').DataTable({
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
                    pageSize: 'A4',
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
                                        margin: [-800, 75, -40, 0],
                                        color: '#4c8aa0',
                                        fontSize: '18',
                                        alignment: 'center',
                                        text: 'Participantes Mediacion',
                                        fontSize: 18,
                                    },
                                    {
                                        margin: [-700, 80, -25, 0],
                                        text: encabezado = insertarSaltoDeLinea(encabezado, 100),
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
                    title: 'Participantes Mediacion',

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
            "url": "/listar_participantes_Mediacion/",
            "type": "GET",
            dataSrc: ''
        },
       "columns": [
    { "data": "ter_id" },
    { "data": "ter_nombre" },
    { "data": "ter_tipo_per" },
    { "data": "ter_identificacion" },
    { "data": "ter_correo" },
    { "data": "ter_telefono" },
    { "data": "ter_direccion" },
    {
        "orderable": true,
        "data": null,
        "render": function(data, type, row) {
            
            // Renderiza el botón solo con los atributos data-* solicitados
            return `
                <a href="javascript:;" 
                   class="btn btn-xs btn-primary Editar" 
                   style="font-size:1px" 
                   data-toggle="tooltip" 
                   title="Editar"
                   
                   data-ter_id="${row.ter_id}"
                   data-ter_nombre="${row.ter_nombre}"
                   data-ter_tipo_per="${row.ter_tipo_per}"
                   data-ter_identificacion="${row.ter_identificacion}"
                   data-ter_correo="${row.ter_correo}"
                   data-ter_pais="${row.ter_pais}"
                   data-ter_estado="${row.ter_estado}"
                   data-ter_municipio="${row.ter_municipio}"
                   data-ter_parroquia="${row.ter_parroquia}"
                   data-ter_telefono="${row.ter_telefono}"
                   data-ter_direccion="${row.ter_direccion}">
                       <i class="material-icons">create</i>
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



/**
 * METODO PARA ABRIR EL MODAL PARA LA EDICIÓN DE PARTICIPANTES.
 * Escucha el evento 'click' en cualquier botón con la clase 'Editar' dentro de la tabla.
 */
$('#listar_participantes_mediacion').on('click', '.Editar', function(e) {
    e.preventDefault();

    // 1. Obtener los datos del botón
    var ter_id = $(this).attr('data-ter_id');
    var ter_nombre = $(this).attr('data-ter_nombre');
    var ter_tipo_per = $(this).attr('data-ter_tipo_per');
    var ter_identificacion = $(this).attr('data-ter_identificacion');
    var ter_correo = $(this).attr('data-ter_correo');
    var ter_pais = $(this).attr('data-ter_pais');
    var ter_telefono = $(this).attr('data-ter_telefono');
    var ter_direccion = $(this).attr('data-ter_direccion');
    var ter_estado = $(this).attr('data-ter_estado');
    var ter_municipio = $(this).attr('data-ter_municipio');
    var ter_parroquia = $(this).attr('data-ter_parroquia');
     $("#editar").modal("show");
    // 2. Cargar los datos básicos en el modal
    $('#editar').find('#data-ter_id').val(ter_id);
    $('#editar').find('#data-ter_nombre').val(ter_nombre);
    $('#editar').find('#data-ter_tipo_per').val(ter_tipo_per);
    $('#editar').find('#data-ter_identificacion').val(ter_identificacion);
    $('#editar').find('#data-ter_correo').val(ter_correo);
    $('#editar').find('#data-ter_telefono').val(ter_telefono);
    $('#editar').find('#data-ter_direccion').val(ter_direccion);


    if (ter_pais !=1) 
    {
        $("#estado-caso").prop('disabled', true);
        $("#municipio-caso").prop('disabled', true);
        $("#parroquia-caso").prop('disabled', true);
        
    }else
    {
        $("#estado-caso").prop('disabled', false);
        $("#municipio-caso").prop('disabled', false);
        $("#parroquia-caso").prop('disabled', false);
        

    }

   
    llenar_pais(Event,ter_pais);
    llenar_Estados(Event,ter_estado)
    llenar_municipios(Event,ter_estado, ter_municipio);
    llenar_parroquias(Event,ter_municipio, ter_parroquia);
    
   
});



//FUNCION PARA LLENAR EL COMBO DE LOS ESTADOS
function llenar_Estados(e, estadoid) {
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
                if (estadoid === undefined) {
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
                        if (item.estadoid === estadoid) {
                            $("#estado-caso").append(
                                "<option value=" +
                                item.estadoid +
                                " selected>" +
                                item.estadonom +
                                "</option>"
                            );
                            $('#estado_anterior').val(item.estadonom);
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
            alert(xhr.status);
            alert(errorThrown);
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
                        if (item.paisid === id) {
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
        llenar_Estados(Event, '1'); 
        $("#municipio-caso").val('1');
        $("#parroquia-caso").val('1');
        $("#estado-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#municipio-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#parroquia-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar

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
});
//FUNCION PARA LLENAR EL COMBO DE LOS MUNICIPIOS EN FUNSION DEL ID DEL ESTADO
function llenar_municipios(e, estadoid, municipioid) {
    let datos = {
        id_estado: estadoid
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
            $("#municipio-caso").html(response.data);
            $("#municipio-caso").val(municipioid).prop("selected", true);
            let municipionom = $('#municipio-caso option:selected').text();
            $("#municipio_anterior").val(municipionom);
            if (mun != 0) {
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
                        $("#parroquia-caso").html(response.data);
                    })
                    .catch((request) => {
                        Swal.fire("Error", response.JSONmessage, "Error");
                    });
            }
        })
        .catch((request) => {
            Swal.fire("Error", response.JSONmessage, "Error");
        });

}
//FUNCION PARA LLENAR EL COMBO DE LAS PARROQUIAS  EN FUNSION DEL LOS MUNISIPIOS
function llenar_parroquias(e, municipioid, parroquiaid) {
    let datos = {
        id_municipio: municipioid,
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
            $("#parroquia-caso").html(response.data);
            $("#parroquia-caso").val(parroquiaid).prop("selected", true);
            let parroquianom = $('#parroquia-caso option:selected').text();
            $("#parroquia_anterior").val(parroquianom);

        })
        .catch((request) => {
            Swal.fire("Error", response.JSONmessage, "Error");
        });

}



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
        $("#municipio-caso").html('<option value="0" selected disabled>Seleccione Municipio</option>' + response.data);
        
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


/**
 * METODO PARA MANEJAR EL GUARDADO DE LA EDICIÓN. 
 * Escucha el evento 'submit' del formulario y construye un objeto de datos explícito.
 */
$('#form-editar-participante').on('submit', function(e) {

    e.preventDefault();

   
    const $ident = $('#data-ter_identificacion'); 

    const datos = {
        ter_id: $('#data-ter_id').val(),
        ter_nombre: $('#data-ter_nombre').val(),
        ter_tipo_per: $('#data-ter_tipo_per').val(),
        ter_identificacion: $ident.val(), // Usamos la variable $ident para consistencia
        ter_correo: $('#data-ter_correo').val(),
        ter_telefono: $('#data-ter_telefono').val(),
        ter_direccion: $('#data-ter_direccion').val(),
        // Datos de ubicación
        ter_pais: $('#pais-caso').val(),
        ter_estado: $('#estado-caso').val(),
        ter_municipio: $('#municipio-caso').val(),
        ter_parroquia: $('#parroquia-caso').val()
    };

    let contraparte_ident = $ident.val();
    let hasErrorTipo23 = false;
    // Regex para 5 o más dígitos, opcionalmente seguidos de - y 1 dígito
    const REGEX_IDENTIFICACION_ESTRICTA = /^\d{5,}(?:-\d{1})?$/;
    const ident_valor_trimmed = contraparte_ident.trim();

    // --- Lógica de Validación de Identificación ---
    if (ident_valor_trimmed !== '') {
        // Elimina puntos y espacios, convierte a mayúsculas
        let valor_a_validar = ident_valor_trimmed.replace(/[. ]/g, '').toUpperCase();

        if (!REGEX_IDENTIFICACION_ESTRICTA.test(valor_a_validar)) {
            $ident.removeClass('border-gray-300').addClass('border-red-500').focus().get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
            Swal.fire({
                icon: "error",
                type: 'error',
                html: '<strong>Identificación inválida. Formato: Mínimo 5 dígitos (ej: 12345) o 12345678-2.</strong>',
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 4000,
                focusConfirm: false,
                allowOutsideClick: true
            });



            
            hasErrorTipo23 = true;
        } else {
            $ident.removeClass('border-red-500').addClass('border-gray-300');
        }
    } else {
        // En caso de estar vacío, asegurar que no tenga el borde de error
        $ident.removeClass('border-red-500').addClass('border-gray-300');
    }
    // --- Fin Lógica de Validación ---

    // 🚩 CORRECCIÓN CRÍTICA: Detener el envío si hay errores de validación
    if (hasErrorTipo23) {
        // Puedes añadir aquí el re-habilitar del botón si lo habías deshabilitado en beforeSend
        return; 
    }

    // Si no hay errores, se procede con la petición AJAX
    $.ajax({
        url: "/edit_participante",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            // Se recomienda deshabilitar el botón de envío para evitar envíos dobles
            // $("button[type=submit]").attr('disabled', 'true'); 
        },
        success: function(mensaje) {
            // Se recomienda volver a habilitar el botón si la petición es exitosa o falla, 
            // a menos que la página vaya a ser redireccionada.
            // $("button[type=submit]").removeAttr('disabled'); 

            if (mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>Registro Actualizado</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                // Redirección solo después de mostrar el mensaje de éxito
                setTimeout(function() {
                    window.location = "/Vista_Participantes_Mediacion";
                }, 1500);
            } else if (mensaje === 2) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Hubo un error en la actualización del registro</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                });
                // Se podría considerar no redireccionar en caso de error para que el usuario pueda corregir
            }
        },
        error: function(xhr, status, error) {
            // Manejo de errores de la petición AJAX (ej: error 404, error de servidor 500)
            // $("button[type=submit]").removeAttr('disabled'); // Re-habilitar botón
            Swal.fire({
                icon: "error",
                type: 'error',
                html: '<strong>Error de conexión o de servidor. Por favor, inténtalo de nuevo.</strong>',
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 4000
            });
        }
    });
});
/**
 * METODO PARA CERRAR EL MODAL USANDO EL BOTÓN CANCELAR O ESCAPE (Si se implementa).
 * Añade la clase 'hidden' para ocultar el modal de Tailwind.
 */
$('#btn-cerrar-edicion').on('click', function() {
    $('#editar').addClass('hidden');
});

