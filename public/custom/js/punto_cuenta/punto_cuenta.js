$(function() {
    listar_Punto_Cuenta();
});


    
    // --- 1. FUNCIÓN DE LIMPIEZA CENTRALIZADA ---
    // Creamos una función que oculta la tarjeta y limpia los campos.
    function resetearFormularioAsociacion() {
        // Oculta la tarjeta de detalles
        $("#card-detalle-caso").hide(); 
        
        // Limpia los campos de entrada
        
        $("#campo-nombre").val('');
        $("#campo-cedula").val('');
        $("#campo-telefono").val('');
        $("#campo-tipo-atencion").val('');
        
        // Deshabilita el botón de asociación
        $("#btn-asociar-caso").prop('disabled', true);
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
 
 * @param {string} id_punto_cuenta ID del punto de cuenta.

 */
function cargarCasosAsociados(id_punto_cuenta) {
    const $contenedorTabla = $("#lista-casos-asociados");

    // 1. Contenedor y estado de carga inicial
    $contenedorTabla.html('<p class="text-muted m-0 p-4 border rounded"><i class="fas fa-sync fa-spin mr-2 text-primary"></i> Cargando casos asociados...</p>');

    // 2. Destruir DataTables preexistente (¡Importante!)
    if ($.fn.DataTable.isDataTable('#tabla-casos-data')) {
        $('#tabla-casos-data').DataTable().destroy();
    }

    $.ajax({
        url: "/cargarCasosAsociados/" + id_punto_cuenta,
        method: "GET",
        dataType: "JSON",
    })
    .then((response) => {
        
        // Lógica de éxito: Renderizar la tabla.
        if (response && response.length > 0) {
            console.log(response);
            
            // ✅ 1. Incluir las nuevas propiedades en el mapeo de datos
            const dataTableData = response.map(caso => {
                return {
                    'id_caso': caso.id_caso,
                    'nombre': caso.nombre,
                    'tipo_aten_nombre': caso.tipo_aten_nombre,  // Agregado
                    'tipo_atend_nombre': caso.tipo_atend_nombre, // Agregado
                };
            });
            
            // --- 3A. Generar la estructura de la tabla HTML (Cabecera con 4 columnas) ---
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
            
            // Reemplazamos el contenido de carga con la tabla
            $contenedorTabla.html(htmlTabla);


            // --- 6. Inicialización de DataTables (Configuración con 4 columnas) ---
            $('#tabla-casos-data').DataTable({
                data: dataTableData, 
                // ✅ 2. Añadir las nuevas columnas a la configuración de DataTables
                columns: [
                    { data: 'id_caso', title: 'Número de Caso' },
                    { data: 'nombre', title: 'Nombre' }, 
                    { data: 'tipo_aten_nombre', title: 'Tipo de Atención' },   // Agregado
                    { data: 'tipo_atend_nombre', title: 'Detalle de Atención' }, // Agregado
                ],
                // Opciones de configuración de DataTables
                paging: true,              // 👈 ACTIVADO PARA MOSTRAR LA PAGINACIÓN
                pageLength: 5,             // Mostrar solo 5 filas por página por defecto (más compacto)
                searching: true,
                info: true,
                responsive: true,
                order: [[0, 'asc']], // Ordenar por la columna 0 (ID de Caso)
                dom: 'lfrtip',            // DOM clásico para incluir: length (l), filter (f), table (t), info (i), processing (p)
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                }
            });


         }
        else {
            // Lógica para cuando no hay casos.

            $contenedorTabla.html(`
                <div class="alert alert-success p-4 m-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2 fa-lg"></i> 
                    No se encontraron casos asociados a este punto de cuenta.
                </div>
            `);
        }
    })
    .catch((xhr, status, errorThrown) => {
        // Lógica de error...
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
/ // //EVENTO PARA VERIFICAR UN CASO (Lógica adaptada)
    $(document).on('click', "#btnverificarcaso", function(e) {
        e.preventDefault();
        let inputnuevocaso = $("#inputnuevocaso").val();
        inputnuevocaso = inputnuevocaso.trim();
        
        // Referencias a elementos clave
        const $cardDetalle = $("#card-detalle-caso");
        const $btnAsociar = $("#btn-asociar-caso");
        const $btnVerificar = $(this); 
    
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
                
                if (response && response.length > 0) {
                    const caso = response[0];
    
                    // POBLAR LOS CAMPOS (usando .val() correctamente)
                    $("#campo-nombre").val(caso.nombre); 
                    $("#campo-telefono").val(caso.casotel); 
                    $("#campo-cedula").val(caso.cedula);
                    $("#campo-tipo-atencion").val(caso.tipo_aten_nombre);
                    
                    // MOSTRAR la tarjeta de detalles
                    $cardDetalle.slideDown(); 
    
                    // HABILITAR el botón de asociar caso
                    $btnAsociar.prop('disabled', false);
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
                    icon: "success",
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
                    icon: "success",
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
                    icon: "success",
                    type: 'error',
                    html: '<strong>HUBO UN ERROR AL CAGAR EL ARCHIVO.</strong>',

                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else if (data == 4) {
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR UN ARCHIVO.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }else if (data == 5) {
                Swal.fire({
                    icon: "success",
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
                    icon: "success",
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
                    icon: "success",
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
                    icon: "success",
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
                    icon: "success",
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