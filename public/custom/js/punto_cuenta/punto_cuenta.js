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
        $("#btn-asociar-caso").hide();
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
            var selectElement = document.getElementById('docu-punto');
            selectElement.addEventListener('change', function() {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var url = selectedOption.text;
                var ruta = '../documentos_punto_cuenta/' + url; // Reemplaza "
                window.open(ruta, "_blank");
            });
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
    


    $('#archivo').val(''); 




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
    if (response.message === "success") {
        // 1. Llenar el select como ya lo haces
        if (response.data) {
            $("#docu-punto-deta").html(response.data);
        }

       
        var selectElement = document.getElementById('docu-punto-deta');
        selectElement.addEventListener('change', function() {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var url = selectedOption.text;
        var ruta = '../documentos_punto_cuenta/' + url; // Reemplaza "
        window.open(ruta, "_blank");
        });



    } else {
        $("#docu-punto-deta").html('<option value="0" selected disabled>No se encontraron documentos</option>');
    }
})
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
    // 1. CAPTURA DE INFORMACIÓN PARA EL ENCABEZADO DE EXPORTACIÓN
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
    
    const nombresColumnas = ['Detalles', 'Número de Caso', 'Nombre', 'Tipo de Atención', 'Detalle de Atención'];
    let ruta_imagen = rootpath; 
    const $contenedorTabla = $("#lista-casos-asociados");

    // Limpieza y estado de carga
    $contenedorTabla.html('<p class="text-muted m-0 p-4 border rounded"><i class="fas fa-sync fa-spin mr-2 text-primary"></i> Cargando casos asociados...</p>');
    
    if ($.fn.DataTable.isDataTable('#tabla-casos-data')) {
        $('#tabla-casos-data').DataTable().destroy();
    }
    
    // 2. PETICIÓN AL SERVIDOR (CODEIGNITER 4)
    $.ajax({
        url: "/cargarCasosAsociados/" + id_punto_cuenta,
        method: "GET",
        dataType: "JSON",
    })
    .then((response) => {
        if (response && response.length > 0) {
            
            // 3. MAPEADO DE DATOS (Se asegura la relación llave:valor para DataTable)
            const dataTableData = response.map(caso => {
                return {
                    'acciones': `<button type="button" class="btn btn-xs btn-primary btn-abrir-doc" 
                                    data-id="${caso.id_caso}" 
                                    data-toggle="tooltip" title="Detalles"
                                    style="padding: 2px 5px;">
                                    <i class="material-icons" style="font-size:18px;">visibility</i>
                                 </button>`,
                    'id_caso': caso.id_caso,
                    'nombre': caso.nombre,
                    'tipo_aten_nombre': caso.tipo_aten_nombre || 'N/A',  
                    'tipo_atend_nombre': caso.tipo_atend_nombre || 'N/A'
                };
            });
            
            // 4. CREACIÓN DE LA ESTRUCTURA HTML
            let htmlTabla = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tabla-casos-data">
                        <thead>
                            <tr class="bg-light">
                                <th>Detalles</th>
                                <th>Número de Caso</th>
                                <th>Nombre</th>
                                <th>Tipo de Atención</th>
                                <th>Detalle de Atención</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>`;
            $contenedorTabla.html(htmlTabla);
            
            // 5. INICIALIZACIÓN DE DATATABLES
            const tabla = $('#tabla-casos-data').DataTable({
                data: dataTableData,
                columns: [
                    { data: 'acciones', orderable: false, width: "50px" },
                    { data: 'id_caso' },
                    { data: 'nombre' }, 
                    { data: 'tipo_aten_nombre' },
                    { data: 'tipo_atend_nombre' }
                ],
                dom: "<'row mb-3'<'col-sm-12'B>>" + 
                      "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", 
                responsive: true,
                order: [[1, 'asc']], 
                buttons: [
                    // --- CONFIGURACIÓN PDF ---
                    {
                        extend: "pdf",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn-xs btn-dark mr-2', 
                        orientation: 'landscape',
                        pageSize: 'LETTER',
                        exportOptions: { columns: [1, 2, 3, 4] }, // No exporta la columna de botones
                        customize: function(doc) {
                            // Tu lógica de encabezado PDF (DetailBody, etc.)
                            doc.styles.tableHeader = { fillColor: '#4c8aa0', color: 'white', alignment: 'center' };
                            // (Mantenemos tu lógica original de splice y header aquí...)
                        }
                    },
                    // --- CONFIGURACIÓN EXCEL ---
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel', 
                        className: 'btn-xs btn-dark',
                        filename: 'Casos_Asociados',
                        exportOptions: { columns: [1, 2, 3, 4] },
                        customizeData: function(data) {
                            var numColumns = data.header.length; 
                            const rowsToPrepend = [];
                            rowsToPrepend.push(['Casos Asociados'].concat(Array(numColumns - 1).fill(null)));
                            detalleExportacion.forEach(item => {
                                rowsToPrepend.push([item.label, item.value].concat(Array(numColumns - 2).fill(null)));
                            });
                            rowsToPrepend.push(Array(numColumns).fill(null)); 
                            data.body.splice(0, 0, ...rowsToPrepend);
                            data.header = [];
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            // 6. EVENTO PARA ABRIR EL DOCUMENTO (Delegado)
            $('#tabla-casos-data').on('click', '.btn-abrir-doc', function() {
                const idCaso = $(this).data('id');
                // Sustituye esta URL por la ruta real de tu controlador en CodeIgniter
                const url = `/verCaso/${idCaso}`; 
                window.open(url, '_blank');
            });

         } else {
            $contenedorTabla.html(`
                <div class="alert alert-success p-4 m-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2 fa-lg"></i> 
                    No se encontraron casos asociados.
                </div>
            `);
        }
    })
    .catch((jqXHR) => {
        console.error("Error:", jqXHR);
        $contenedorTabla.html('<div class="alert alert-danger">Error al cargar la información.</div>');
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
            // Rehabilitar botón antes de cualquier acción
            $submitBtn.prop('disabled', false).text('Asignar');
            
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

        // 9. Manejo de errores HTTP (incluye 500)
        error: function(xhr, status, error) {
            // Rehabilitar botón
            $submitBtn.prop('disabled', false).text('Asignar');
            
            console.error("Error AJAX:", status, error);
            
            let mensaje_error = "Error de conexión con el servidor.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje_error = xhr.responseJSON.message;
            } else if (xhr.status === 500) {
                mensaje_error = "Error interno del servidor (500). Verifique que el caso no esté ya asociado.";
            }
            
            alert("❌ Error: " + mensaje_error);
        }

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
                     $("#btn-asociar-caso").hide()
                    $("#mensaje-punto-cuenta").show();
                    $mensajePuntoCuenta.html('<span class="text-danger font-weight-bold"><i class="fas fa-ban"></i> Este tipo de atención no tiene acceso al punto de cuenta.</span>');
                } else {
                   $("#btn-asociar-caso").show()
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