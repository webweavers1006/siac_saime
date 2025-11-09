
/**
 * Habilita o deshabilita todos los campos dentro de una sección de rol.
 * @param {string} prefix - Prefijo del rol ('apoderado-solicitante', etc.).
 * @param {boolean} habilitar - Si es true, habilita; si es false, deshabilita (bloquea).
 */
function toggleCamposEdicion(prefix, habilitar) {
    // Selector para el contenido del bloque, incluyendo el contenedor principal.
    const selectorContenido = `#${prefix}-content, #${prefix.replace('-apoderado', '')}-content, #mediacion`;
    const $elementos = $(selectorContenido).find('input, select, textarea, button');

    $elementos.each(function() {
        const $el = $(this);
        const id = $el.attr('id');
        
        // 🚨 CAMBIO CLAVE: Excluir el campo de búsqueda, el botón de búsqueda Y el checkbox "aplica".
        if (
            (id && id.includes('cedula-existente')) || // Campo de búsqueda
            (id && id.includes('btn_buscar')) ||       // Botón de búsqueda
            (id && id.includes('-aplica'))             // Checkbox "Aplica"
        ) {
            // El checkbox "Aplica" siempre debe estar habilitado, independientemente del parámetro 'habilitar'.
            $el.prop('disabled', false); 
            $el.removeClass('campo-solo-lectura');
            return; // Continúa al siguiente elemento
        }
        
        // Bloquear/Desbloquear el elemento
        $el.prop('disabled', !habilitar);

        // Aplicar/Remover la clase visual
        if (habilitar) {
            $el.removeClass('campo-solo-lectura');
        } else {
            $el.addClass('campo-solo-lectura');
        }
    });
}


// =================================================================
// Retención de Cédula. Asigna el valor buscado (cedula) al campo principal de C.I. o RIF 
// del bloque de formulario correspondiente,
//  asegurando que este dato no se pierda si el tercero no es encontrado.
// =================================================================

function mapearCedulaFormulario(prefix, cedula) {
    let ciFieldId;
    if (prefix === 'contraparte') { ciFieldId = '#contraparte-ident-valor'; } 
    else if (prefix === 'apoderado-solicitante') { ciFieldId = '#apoderado-solicitante-ci'; } 
    else { ciFieldId = '#contraparte-apoderado-ci'; }
    $(ciFieldId).val(cedula);
}

// =================================================================
// 🧹 Restablece Campos de Datos y Ubicación.
//  Elimina el contenido de todos los campos de texto del rol (Nombre, Teléfono, Dirección, IMPRE).
//  //  Reinicia los selectores de ubicación (País, Estado, Municipio, Parroquia) al estado "Seleccione",
//  listos para una nueva carga. Se invoca tras un fallo en la búsqueda de la cédula.
//  @param {string} prefix - Prefijo del rol (ej: 'apoderado-solicitante').
// =================================================================
function limpiarCamposTercero(prefix) {
    let ciFieldId, tipoFieldId, nombreFieldId, impreFieldId;

    if (prefix === 'contraparte') {
        ciFieldId = '#contraparte-ident-valor'; tipoFieldId = '#contraparte-ident-tipo'; nombreFieldId = '#contraparte-nombre-razon';
    } else if (prefix === 'apoderado-solicitante') {
        ciFieldId = '#apoderado-solicitante-ci'; tipoFieldId = '#apo_solicitente-ident-tipo'; nombreFieldId = '#apoderado-solicitante-nombres'; impreFieldId = '#apoderado-solicitante-impre';
    } else {
        ciFieldId = '#contraparte-apoderado-ci'; tipoFieldId = '#apo_contraparte-ident-tipo'; nombreFieldId = '#apoderado-contraparte-nombres'; impreFieldId = '#contraparte-apoderado-impre';
    }

    $(ciFieldId).val(''); 
    $(tipoFieldId).val('V'); 
    $(nombreFieldId).val('');
    $(`#${prefix}-telefono`).val('');
    $(`#${prefix}-correo`).val('');
    $(`#${prefix}-direccion`).val('');
    if (impreFieldId) $(impreFieldId).val('');
    
    
}

// =================================================================
// 🗺️ Mapeo Integral de Datos de Tercero.
// Asigna la información detallada del tercero (Nombre, Identificación, Teléfono, Correo, Dirección, IMPRE)
// a los campos correspondientes dentro de la sección del formulario.
// Inicia la **cascada asíncrona de ubicación** (País, Estado, Municipio, Parroquia) para precargar y
// seleccionar automáticamente los valores geográficos guardados.
//@param {string} prefix - Prefijo del rol (ej: 'apoderado-solicitante').
// @param {Object} data - Objeto JSON con los datos del tercero devueltos por el servidor.
// =================================================================

function mapearDatosTercero(prefix, data) {
    // Definiciones de IDs para mapeo...
    let ciFieldId, tipoFieldId, nombreFieldId, impreFieldId;

    if (prefix === 'contraparte') {
        ciFieldId = '#contraparte-ident-valor'; tipoFieldId = '#contraparte-ident-tipo'; nombreFieldId = '#contraparte-nombre-razon';
    } else if (prefix === 'apoderado-solicitante') {
        ciFieldId = '#apoderado-solicitante-ci'; tipoFieldId = '#apo_solicitente-ident-tipo'; nombreFieldId = '#apoderado-solicitante-nombres'; impreFieldId = '#apoderado-solicitante-impre';
    } else { 
        ciFieldId = '#contraparte-apoderado-ci'; tipoFieldId = '#apo_contraparte-ident-tipo'; nombreFieldId = '#apoderado-contraparte-nombres'; impreFieldId = '#contraparte-apoderado-impre';
    }

    // 1. Mapeo de campos de texto
    $(ciFieldId).val(data.ter_identificacion || '');
    $(tipoFieldId).val(data.ter_tipo_per || 'V');
    $(nombreFieldId).val(data.ter_nombre ? data.ter_nombre.trim() : '');
    if (impreFieldId) $(impreFieldId).val(data.ter_impre_abogado || '');
    $(`#${prefix}-telefono`).val(data.ter_telefono || '');
    $(`#${prefix}-correo`).val(data.ter_correo || '');
    $(`#${prefix}-direccion`).val(data.ter_direccion ? data.ter_direccion.trim() : '');

    // 2. Mapeo de Ubicación (Usando tu lógica de inicialización y disparadores)
    const pais = data.ter_pais;
    const estado = data.ter_estado;
    const municipio = data.ter_municipio;
    const parroquia = data.ter_parroquia;
    
    if (pais) {
        const paisId = `${prefix}-pais-select`;
        const estadoId = `${prefix}-estado-select`;
        const municipioId = `${prefix}-municipio-select`;
        const parroquiaId = `${prefix}-parroquia-select`;

        // A. Cargar y seleccionar el País
        // Nota: llenando Paises Multiple con el ID lo selecciona (esto debe existir)
        llenar_Paises_Multiple(paisId, pais); 

        // B. Si es Venezuela (País 1), necesitamos activar la cascada y seleccionar Estado/Municipio/Parroquia.
        if (pais == 1) {
            // Llenar el Estado con el valor (usando tu función)
            llenar_Estados_Multiple(estadoId, estado); 

            // Para que la cascada funcione, necesitamos cargar Municipio y Parroquia manualmente,
            // ya que el evento 'change' en el estado no se ha disparado.
            
            // 🚨 SOLUCIÓN ADAPTADA: Cargar Municipio después de un pequeño retraso (para esperar que Estado se seleccione)
            setTimeout(() => {
                if (estado) {
                    const datos_m = { id_estado: estado };
                    $.ajax({
                        url: "/municipios",
                        method: "POST",
                        dataType: "JSON",
                        data: { data: btoa(JSON.stringify(datos_m)) },
                    })
                    .then((response) => {
                        $(`#${municipioId}`).html(response.data);
                        if (municipio) {
                             $(`#${municipioId}`).val(municipio); // Seleccionar municipio

                             // Cargar Parroquias
                             const datos_p = { id_municipio: municipio };
                             return $.ajax({
                                 url: "/parroquias",
                                 method: "POST",
                                 dataType: "JSON",
                                 data: { data: btoa(JSON.stringify(datos_p)) },
                             });
                        }
                    })
                    .then((response) => {
                        if (response) {
                             $(`#${parroquiaId}`).html(response.data);
                             if (parroquia) {
                                $(`#${parroquiaId}`).val(parroquia); // Seleccionar parroquia
                             }
                        }
                    })
                    .catch((request) => {
                        console.error("Error cargando ubicación en mapeo:", request);
                    });
                }
            }, 100); // Pequeño retraso para evitar race conditions
        } else {
             // Si el país no es 1 (Extranjero), replicamos la lógica de fijar valores
             llenar_Estados_Multiple(estadoId, 26); 
             // Y el resto de los selectores deben ser cargados/fijados según tu lógica de País Extranjero.
             // (Se asume que la carga de Municipios/Parroquias para Extranjero se maneja internamente en tu código)
             $(`#${municipioId}`).val('336'); 
             $(`#${parroquiaId}`).val('1135');
        }
    }
}


// Expresión Regular para un formato de correo estándar
const REGEX_EMAIL = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    
// Lista de todos los IDs a validar
const CAMPO_IDS = [
    '#correo', 
    '#apoderado-solicitante-correo', 
    '#contraparte-correo', 
    '#apoderado-contraparte-correo'
];
const SELECTOR_TODOS_CORREOS = CAMPO_IDS.join(', ');

// Selector para el botón de navegación
const BTN_NEXT = '.btn-next';

// ----------------------------------------------------
// Función auxiliar NECESARIA para controlar el botón "SIGUIENTE"
// ----------------------------------------------------
function verificarEstadoGeneral() {
    // Si CUALQUIERA de los campos tiene la clase 'is-invalid', deshabilitamos el botón.
    if ($(SELECTOR_TODOS_CORREOS).is('.is-invalid')) {
        $(BTN_NEXT).attr('disabled', 'true').addClass('disabled');
    } else {
        // Si ninguno tiene 'is-invalid', habilitamos el botón.
        $(BTN_NEXT).removeAttr('disabled').removeClass('disabled');
    }
}

// ----------------------------------------------------
// Función de validación centralizada con manejo de iconos
// ----------------------------------------------------
function manejarValidacionCorreo($input) {
    const texto = $input.val().trim(); 
    

    const $feedbackIcon = $input.next('.feedback-icon');

    // 1. Limpiar clases
    $input.removeClass('is-invalid is-valid');
    $feedbackIcon.html('').removeClass('text-success text-danger');

    // 2. Si el campo está vacío, salir (es opcional/no obligatorio).
    if (texto.length === 0) {
        verificarEstadoGeneral(); 
        return;
    }

    // 3. Validar formato y longitud mínima
    if (!REGEX_EMAIL.test(texto) || texto.length < 5) {
        $input.addClass('is-invalid');
        
        // Agregar símbolo de incorrecto (❌ rojo)
        $feedbackIcon.html('❌').addClass('text-danger');
        
        // Si hay un error, el botón se deshabilita (verificado en el paso 4).
    } else {
        $input.addClass('is-valid');
        
        // Agregar símbolo de bien (✅ verde)
        $feedbackIcon.html('✅').addClass('text-success');
    }

    // 4. Controlar el botón "SIGUIENTE"
    verificarEstadoGeneral();
}

// ----------------------------------------------------
// Bloque ÚNICO: Aplicar la validación a TODOS los campos
// ----------------------------------------------------
$(document).on('keyup change', SELECTOR_TODOS_CORREOS, function() {
    manejarValidacionCorreo($(this));
});

// Llamar a la verificación al cargar la página para establecer el estado inicial
$(document).ready(function() {
    verificarEstadoGeneral();
});


$(function() {

    // let tipo_atencion_usu = $("#tipo-atencion-usu").val();
 
   
     llenar_Propiedad_Intelectual(Event);
     llenar_Estados(Event);
     llenar_pais(Event);
     llenar_Red_social(Event);
     llenar_Entes_asdcritos(Event);
     llenar_Tipo_Beneficiarios(Event);
     llenar_Organismos_PP(Event);

   // 1. INICIALIZACIÓN DE SELECTORES PARA APODERADO SOLICITANTE
    llenar_Selectores_Iniciales("apoderado-solicitante");

    // 2. INICIALIZACIÓN DE SELECTORES PARA CONTRAPARTE
    llenar_Selectores_Iniciales("contraparte");

    // 3. INICIALIZACIÓN DE SELECTORES PARA APODERADO CONTRAPARTE
    llenar_Selectores_Iniciales("apoderado-contraparte");

toggleCamposEdicion('apoderado-solicitante', false); 
    toggleCamposEdicion('contraparte', false); 
    toggleCamposEdicion('apoderado-contraparte', false);

   // Adjuntar eventos de búsqueda (Click)
    $('#btn_buscar_apo_sol').on('click', function(e) {
        e.preventDefault(); 
        buscar_Tercero_Mediacion('apoderado-solicitante'); 
    });

    $('#btn_buscar_contra').on('click', function(e) {
        e.preventDefault(); 
        buscar_Tercero_Mediacion('contraparte');
    });

    $('#btn_buscar_apo_contra').on('click', function(e) {
        e.preventDefault(); 
        buscar_Tercero_Mediacion('apoderado-contraparte');
    });
 });
 // =================================================================
// I. FUNCIONES DE LLENADO DE COMBOBOX (SELECTS)
// =================================================================

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
            //;
          
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

// FUNCION PARA LLENAR EL COMBO PAIS
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

// =================================================================
// II. MANEJADORES DE EVENTOS DE VALIDACIÓN
// =================================================================

$("#red-social").on('change', function() {
    $("#red-social").removeClass('is-invalid');
    id_red_social=$('#red-social').val();  
    
   llenar_Tipo_Atencion(Event,id_red_social);   
 
});
 
$("#estado-caso").on('change', function() {
    $("#estado-caso").removeClass('is-invalid');
});

$("#tipo-pi").on('change', function() {
    $("#tipo-pi").removeClass('is-invalid');
 
});


// =================================================================
// III. MANEJADORES DE EVENTOS DE UBICACIÓN GEOGRÁFICA (Cascada)
// =================================================================

// Evento al cambiar el PAÍS
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
        // Si el país es 1, restablecer y deshabilitar selectores

        $("#estado-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#municipio-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#parroquia-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        llenar_Estados(Event, '1'); 
        $("#municipio-caso").val('1');
        $("#parroquia-caso").val('1');

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


// Evento que busca los municipios por estados (Disparado al hacer click en el selector)
$(document).on("click", "#estado-caso", (e) => {
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
             $("#municipio-caso").html(response.data);
 
             let mun = $("#municipio-caso").val();
 
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
                         // El mensaje de error original usa 'response.JSONmessage' que no está definido en el catch
                         Swal.fire("Error", "Error al cargar parroquias.", "error"); 
                     });
             }
         })
         .catch((request) => {
             // El mensaje de error original usa 'response.JSONmessage' que no está definido en el catch
             Swal.fire("Error", "Error al cargar municipios.", "error");
         });
 });

// Evento que busca las parroquias por municipio (Disparado al hacer click en el selector)
 $(document).on("click", "#municipio-caso", (e) => {
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
             $("#parroquia-caso").html(response.data);
         })
         .catch((request) => {
             // El mensaje de error original usa 'response.JSONmessage' que no está definido en el catch
             Swal.fire("Error", "Error al cargar parroquias.", "error");
         });
 });

// =================================================================
// DEFINICIONES DE FUNCIONES AUXILIARES (CORRECCIÓN)
// =================================================================

function llenar_Paises_Multiple(selectId, idSeleccionado) {
    const url = "/llenar_pais";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            const $select = $(`#${selectId}`);
            if (data.length >= 1) {
                $select.empty();
                $.each(data, function(i, item) {
                    let selectedAttr = (idSeleccionado !== undefined && item.paisid == idSeleccionado) ? " selected" : "";
                    $select.append(
                        `<option value="${item.paisid}"${selectedAttr}>${item.paisnom}</option>`
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar Países:", status, errorThrown);
        },
    });
}

function llenar_Estados_Multiple(selectId, idSeleccionado) {
    const url = "/llenar_Estados"; 

    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            const $select = $(`#${selectId}`);
            if (data.length >= 1) {
                $select.empty();
                $select.append(
                    "<option value='0' selected disabled>Seleccione</option>"
                );
                
                $.each(data, function(i, item) {
                    let selectedAttr = (idSeleccionado !== undefined && item.estadoid == idSeleccionado) ? " selected" : "";
                    $select.append(
                        `<option value="${item.estadoid}"${selectedAttr}>${item.estadonom}</option>`
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar Estados:", status, errorThrown);
        },
    });
}


// =================================================================
// FUNCIÓN PRINCIPAL DE INICIALIZACIÓN (CÓDIGO ORIGINAL)
// =================================================================

/**
 * Inicializa los selectores de ubicación y sus eventos de cascada para una sección específica.
 * @param {string} prefijo - El prefijo del ID (ej: 'apoderado-solicitante').
 */
function llenar_Selectores_Iniciales(prefijo) {
    const paisId = `${prefijo}-pais-select`;
    const estadoId = `${prefijo}-estado-select`;
    const municipioId = `${prefijo}-municipio-select`;
    const parroquiaId = `${prefijo}-parroquia-select`;
    
    // 1. Llenar País y Estado al inicio
    llenar_Paises_Multiple(paisId);
    llenar_Estados_Multiple(estadoId);

    // 2. Evento al cambiar el PAÍS (LÓGICA DE CASCADA Y EXTRANJERO)
    $(`#${paisId}`).on('change', function() {

        $(`#${paisId}`).removeClass('is-invalid');
        var pais = $(this).val();  
        
        if (pais != 1) 
        {
            // Lógica País Extranjero: Fija la ubicación 
            llenar_Estados_Multiple(estadoId, 26); 
            $(`#${municipioId}`).val('336'); 
            $(`#${parroquiaId}`).val('1135');
        
            $(`#${estadoId}`).prop('disabled', true);
            $(`#${municipioId}`).prop('disabled', true);
            $(`#${parroquiaId}`).prop('disabled', true);

            let datos_m = { id_estado: 26 };

            $.ajax({
                url: "/municipios",
                method: "POST",
                dataType: "JSON",
                data: { data: btoa(JSON.stringify(datos_m)) },
            })
            .then((response) => {
                $(`#${municipioId}`).html(response.data);

                let mun = $(`#${municipioId}`).val();
                if (mun != 0) {
                    let datos_p = { id_municipio: mun };
                    return $.ajax({
                        url: "/parroquias",
                        method: "POST",
                        dataType: "JSON",
                        data: { data: btoa(JSON.stringify(datos_p)) },
                    });
                }
            })
            .then((response) => {
                $(`#${parroquiaId}`).html(response.data);
            })
            .catch((request) => {
                Swal.fire("Error", request.responseJSON.message || "Error al cargar datos", "error");
            });
            
        } 
        else
        {
            // Lógica País Nacional (1): Restablecer y habilitar
            $(`#${estadoId}`).val('0').prop('disabled', false);
            $(`#${municipioId}`).val('0').prop('disabled', false); 
            $(`#${parroquiaId}`).val('0').prop('disabled', false);
            
            llenar_Estados_Multiple(estadoId); // Vuelve a llenar con todos los estados
        }
    });

    // 3. Evento que busca los municipios por estados
    // Se usa 'change' en lugar de 'click' para ser más estándar en selectores
    $(`#${estadoId}`).on("change", (e) => {
        e.preventDefault();
        
        if ($(`#${estadoId}`).prop('disabled')) return;

        let datos = { id_estado: $(`#${estadoId}`).val() };

        $.ajax({
                url: "/municipios",
                method: "POST",
                dataType: "JSON",
                data: { data: btoa(JSON.stringify(datos)) },
            })
            .then((response) => {
                $(`#${municipioId}`).html(response.data);
    
                let mun = $(`#${municipioId}`).val();
    
                if (mun != 0) {
                    let datos_p = { id_municipio: mun };
                    return $.ajax({
                            url: "/parroquias",
                            method: "POST",
                            dataType: "JSON",
                            data: { data: btoa(JSON.stringify(datos_p)) },
                        });
                } else {
                     $(`#${parroquiaId}`).empty().append("<option value='0' disabled selected>Seleccione Parroquia</option>");
                }
            })
            .then((response) => {
                $(`#${parroquiaId}`).html(response.data);
            })
            .catch((request) => {
                Swal.fire("Error", "Error al cargar municipios.", "error");
            });
    });

    // 4. Evento que busca las parroquias por municipio
    // Se usa 'change' en lugar de 'click' para ser más estándar en selectores
    $(`#${municipioId}`).on("change", (e) => {
        e.preventDefault();
        
        if ($(`#${municipioId}`).prop('disabled')) return;

        let datos = { id_municipio: $(`#${municipioId}`).val() };
        $.ajax({
                url: "/parroquias",
                method: "POST",
                dataType: "JSON",
                data: { data: btoa(JSON.stringify(datos)) },
            })
            .then((response) => {
                $(`#${parroquiaId}`).html(response.data);
            })
            .catch((request) => {
                Swal.fire("Error", "Error al cargar parroquias.", "error");
            });
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
 
 //FUNCION PARA LLENAR EL COMBO ENTES ADSCRITOS
 function llenar_Entes_asdcritos(e, ente_adscrito_id) {
     e.preventDefault;
     url = "/Listar_Entes_asdcritos";
     $.ajax({
         url: url,
         method: "GET",
         dataType: "JSON",
         beforeSend: function(data) {},
         success: function(data) {
             if (data.length >= 1) {
              $("#ente-adscrito").empty();
                 $("#ente-adscrito").append(
                     "<option value=0  selected disabled>Seleccione</option>"
                 );
                 if (ente_adscrito_id === undefined) {
                     $.each(data, function(i, item) {
                         //
                         $("#ente-adscrito").append(
                             "<option value=" +
                             item.ente_id +
                             ">" +
                             item.ente_nombre +
                             "</option>"
                         );
                     });
                 } else {
                     $.each(data, function(i, item) {
                         if (item.ente_id === ente_adscrito_id) {
                             $("#ente-adscrito").append(
                                 "<option value=" +
                                 item.ente_id +
                                 " selected>" +
                                 item.ente_nombre +
                                 "</option>"
                             );
                         } else {
                             $("#ente-adscrito").append(
                                 "<option value=" +
                                 item.ente_id +
                                 ">" +
                                 item.ente_nombre +
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
 
 //FUNCION PARA LLENAR EL COMBO DE LAS REDES SOCIALES
 function llenar_Red_social(e, id) {
     e.preventDefault;
     url = "/listar_Red_Social_filtro";
     $.ajax({
         url: url,
         method: "GET",
         dataType: "JSON",
         beforeSend: function(data) {},
         success: function(data) {
             if (data.length >= 1) {
                 $("#red-social").empty();
                 $("#red-social").append(
                     "<option value=0  selected disabled>Seleccione</option>"
                 );
                 if (id === undefined) {
                     $.each(data, function(i, item) {
                         //
                         $("#red-social").append(
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
                             $("#red-social").append(
                                 "<option value=" +
                                 item.red_s_id +
                                 " selected>" +
                                 item.red_s_nom +
                                 "</option>"
                             );
                         } else {
                             $("#red-social").append(
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
             alert(xhr.status);
             alert(errorThrown);
         },
     });
 }
 
 


 
 //FUNCION PARA LLENAR EL COMBO TIPO DE PROPIEDAD INTELECTUAL
 function llenar_Propiedad_Intelectual(e, id) {
     e.preventDefault;
     url = "/Listar_Propiedad_Intelectual_MOD";
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
             alert(xhr.status);
             alert(errorThrown);
         },
     });
 }
 
// Función para llenar el combo tipo de atención usuario con formación









 function llenar_Tipo_Atencion(e, idRedSocial) {
    let url = "/buscar_via_tipo_atencion/" + idRedSocial;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function() {
            // Puedes agregar un loader o alguna acción antes de la solicitud
        },
        success: function(data) {
            let $select = $("#tipo-atencion-usu");
            $select.empty();
            $select.append("<option value='0' selected disabled>Seleccione</option>");
            $.each(data, function(index, item) {
                $select.append($('<option></option>')
                    .val(item.tipo_atencion_id)
                    .text(item.tipo_aten_nombre)
                    .attr('data-act-pro-int', item.act_pro_int)
                    .attr('data-organismo_pp', item.organismo_pp)
                );
            });
        },
        error: function(xhr) {
            alert("Error: " + xhr.status + " - " + xhr.statusText);
        },
    });
}




 // Evento change para el select de tipo de atención
$("#tipo-atencion-usu").on('change', function(e) {
    $("#ayudas").modal("show");
    document.getElementById("detalles_atencion").disabled = false;
    $("#hijos_tipoatencion").val('NO');
    let idTipoAtencion = $(this).val(); 
    let selectedOption = $(this).find('option:selected');

    let actProInt = selectedOption.data('act-pro-int');
    let organismoPp = selectedOption.data('organismo_pp');
    
    // 1. Ocultar todas las secciones condicionales al inicio (excepto las que usan toggle)
    $("#mediacion").hide(); // Ocultamos mediación por defecto
    $("#cgr").hide(); // Ocultamos CGR por defecto

    // 2. Lógica de visibilidad exclusiva basada en el ID
    if (idTipoAtencion == 5 || idTipoAtencion == 1) {
        // Lógica ORIGINAL para ID 5 y 1:
        // - Usa .toggle() para #denuncias (solo visible si es 5)
        $("#denuncias").toggle(idTipoAtencion == 5); 
        
    } else if (idTipoAtencion == 23) {
        // Caso específico ID 23: Mostrar Mediación
        $("#mediacion").show();
        
        // Asegurarse de que las otras secciones estén ocultas si no se manejan en el toggle
        $("#denuncias").hide(); 

    } else {
        // Caso 'sino': Ocultar secciones específicas
        $("#denuncias").hide();
    }
    
    // 3. Lógica Común basada en Data Attributes (AFECTA A TODOS LOS CASOS)
    // ESTA PARTE SE MANTIENE COMO LO REQUERISTE para que funcione en 5, 1, 23 o cualquier otro ID
    // si sus data attributes lo indican.
    $(".tipoproint").toggle(actProInt === 't');
    document.getElementById("tipo-pi").disabled = (actProInt !== 't');
    $(".org_pp").toggle(organismoPp === 't');
    document.getElementById("organismo-caso").disabled = (organismoPp !== 't');

    // 4. Petición AJAX (Se mantiene)
   $.ajax({
    url: `/Listar_Tipo_Atencion_act_coordenadas/${idTipoAtencion}`,
    method: 'GET',
    dataType: 'json',
   
    })
    .done((response) => {
       const tipoAtencion = response[0]; 

    if (tipoAtencion && tipoAtencion.act_coordenadas === 't') {
    $(".mapa_ayuda").show();
    $("#actcoordenadas").val('t');
    
      map.invalidateSize();
    } else {
    $(".mapa_ayuda").hide();
     $("#actcoordenadas").val('f');
    }
    })
    .fail((xhr, status, error) => {
        let errorMessage = 'Error al cargar datos.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        Swal.fire('Error', errorMessage, 'error');
    });

    // 5. Función Final (Se mantiene)
    llenar_detalle_atencion(e, idTipoAtencion);

});













function  llenar_detalle_atencion(e,idTipoAtencion)
{

    e.preventDefault;
    
      url='/Listar_Detalle_Atencion_filtro';
       $.ajax
      ({
           url:url,
           method:'GET',
          dataType:'JSON',
          beforeSend:function(data)
          {
          },
          success:function(data)
          {
          
if(data.length>=1)
{
     $('#detalles_atencion').empty();
     $('#detalles_atencion').append('<option value=0  selected disabled>Seleccione</option>');   
     if(idTipoAtencion===undefined)
    {
      
      
         $.each(data, function(i, item)
         {
           $(".detelle_atencion").hide();
              //
              $('#detalles_atencion').append('<option value='+item.tipo_atend_id+'>'+item.tipo_atend_nombre+'</option>');

         });
    }
    else
    {
       $(".detelle_atencion").hide();
       data=data.filter(dato=>dato.tipo_aten_id==idTipoAtencion);
       //console.log(buscar);
          $.each(data, function(i, item)
          {
          
   
           $(".detelle_atencion").show();
           $("#hijos_tipoatencion").val('SI');
           $('#detalles_atencion').append('<option value='+item.tipo_atend_id+'>'+item.tipo_atend_nombre+'</option>');    
         });
    }
}      
},
error:function(xhr, status, errorThrown)
{
    alert(xhr.status);
    alert(errorThrown);
}
});
}


 $("#requerimiento-usuario").on('change', function() {
     $("#requerimiento-usuario").removeClass('is-invalid');
 });




 //METODO PARA GUARDAR EL CASO 
 $(document).on("click", "#guardar", function(e) {
     e.preventDefault();
     let tipo_prop_intelec = $("#tipo-pi").val();
     let tipo_atencion = $("#tipo-atencion-usu").val();
     let tipo_atend_id = $("#detalles_atencion").val();
     let requerimiento_user = $("#requerimiento-usuario").val();
     let red_social = $("#red-social").val();
     let estado = $("#estado-caso").val();
     let org_id = $("#organismo-caso").val();
    

        if (org_id == null || org_id == '') {
            org_id = 1; 
        }

     let sexo = $("#sexo").val();
     requerimiento_user = requerimiento_user.trim();
     if (red_social == null) {
         $("#red-social").addClass('is-invalid');
 
         Swal.fire({
             icon: "error",
             type: 'error',
             html: '<strong>DEBE SELECCIONAR LA VIA DE ATENCION.</strong>',
 
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } else if (estado == null) {
         $("#red-social").removeClass('is-invalid');
         $("#estado-caso").addClass('is-invalid');
         Swal.fire({
             icon: "error",
             type: 'error',
             html: '<strong>EL CAMPO ESTADO ES OBLIGATORIO.</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } 
     else if (tipo_atencion == null) {
         $("#tipo-pi").removeClass('is-invalid');
         $("#tipo-atencion-usu").addClass('is-invalid');
         Swal.fire({
             icon: "error",
             type: 'error',
             html: '<strong>EL USUARIO DEBE TENER ALGUN TIPO DE ATENCION</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         })
     } else if (requerimiento_user == '') {
         $("#tipo-atencion-usu").removeClass('is-invalid');
         $("#requerimiento-usuario").addClass('is-invalid');
         $
         Swal.fire({
             icon: "error",
             type: 'error',
             html: '<strong>DEBE INDICAR LA DESCRIPCION DEL CASO .</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } else {
         $("button[type=button]").attr('disabled', 'false');
         $("#red-social").removeClass('is-invalid');
         $("#estado-caso").removeClass('is-invalid');
         $("#tipo-pi").removeClass('is-invalid');
         $("#tipo-atencion-usu").removeClass('is-invalid');
         $("#requerimiento-usuario").removeClass('is-invalid');

         //VERIFICO SI LA ATENCION ES ASESORIA PARA TOMAR EL VALOR DE LOS CAMPOS CORREPONDIENTES

         let tipo_atencion_usu = $("#tipo-atencion-usu").val();
         //VARIABLES PARA CGR
         let competencia_crg =2;
         let asume_crg= 2;
         let ente_adscrito
         let bandera_cgr = false;
         //VARIABLES PARA LA DEDUNCIA
         let option_personal
         let option_comunidad
         let option_terceros
         let bandera_denuncia = false;
         let fecha_hechos = $('#fecha-hechos').val();
         let denu_involucrados = $('#denu-involucrados').val();
         denu_involucrados = denu_involucrados.trim();
         let nombre_instancia = $('#nombre-instancia').val();
         let rif_instancia = $('#rif-instancia').val();
         let ente_financiador = $('#ente-financiador').val();
         let nombre_proyecto = $('#nombre-proyecto').val();
         let monto_aprovado = $('#monto-aprovado').val();
    
         if (tipo_atencion === '1') 
        {
             if (tipo_prop_intelec == null) {
                     $("#estado-caso").removeClass('is-invalid');
                     $("#tipo-pi").addClass('is-invalid');
                     Swal.fire({
                         icon: "error",
                         type: 'error',
                         html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>',
                         toast: true,
                         position: "center",
                         showConfirmButton: false,
                         timer: 3500,
                     });
                 }else
                 {

                   



                     // competencia_crg = $("#competencia-cgr").val()
                     // asume_crg = $("#asume-cgr").val()
                     // if (competencia_crg == null) {
                     //   alert('DEBE INDICAR SI APLICA O NO  LA COMPETENCIA DEL CGR')
                     //} //else if (asume_crg == null) {
                     // alert('DEBE INDICAR SI ASUME CGR')
                     // } else {
                 bandera_cgr = true;
                     // valor_competencia = $("#competencia-cgr").val();
                     // valor_asume = $("#asume-cgr").val();
                     let cedula= $("#cedula-persona").val()
                     if (cedula.charAt(0).match(/[a-zA-Z]/))
                     {
                         cedula = cedula.slice(1);
                     }
                  let datos = {
                      "social_network": $("#red-social").val(),
                      "date-entry": $("#fecha-recibido").val(),
                      "person-name": $("#nombre-persona").val(),
                      "person-lastname": $("#apellido-persona").val(),
                      "person-id": cedula,
                      "nacionalidad": $("#tipo-persona").val(),
                      "telephone": $("#telefono").val(),
                      "country": $("#pais-caso").val(),
                      "state": $("#estado-caso").val(),
                      "county": $("#municipio-caso").val(),
                      "town": $("#parroquia-caso").val(),
                      "bandera_denuncia": bandera_denuncia,
                      "record-work": $("#num-tramite").val(),
                      "pi-type": $("#tipo-pi").val(),
                      "user-requirement": $("#requerimiento-usuario").val(),
                      "office": $("#office").val(),
                      "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                      "sexo": $("#sexo").val(),
                      "bandera_cgr": bandera_cgr,
                      "tipo_atend_id": tipo_atend_id,
                      "edad": $("#edad").val(),
                      "fecha_nacimiento": $("#fecha-nacimiento").val(),
                      "profesion": $("#profesion").val(),
                      "competencia_crg": competencia_crg,
                      "asume_crg": asume_crg,
                      "tipo_beneficiario": $("#t-beneficiario").val(),
                      "direccion": $("#office").val(),
                      "correo": $("#correo").val(),
                      "profesion": $("#profesion").val(),
                      "ente_adscrito": 0,
                      "organismo-caso": org_id,
                       "act_coordenadas": $("#actcoordenadas").val(),
                      //"ente_adscrito": $("#ente-adscrito").val(0),
                  }
                  
                  $.ajax({
                      url: "/registrarCaso",
                      method: "POST",
                      dataType: "JSON",
                      data: {
                          "data": btoa(JSON.stringify(datos))
                      },
                      beforeSend: function() {
                          
                      },
                      success: function(respuesta) {
                         $("button[type=button]").attr('disabled', 'false');
                          if (respuesta.mensaje === 1) {
                              Swal.fire({
                                  icon: "success",
                                  type: 'success',
                                  html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + ' ' + respuesta.idcaso + '</strong>',
                                  toast: true,
                                  position: "center",
                                  showConfirmButton: false,
                                  //timer: 3500,
                              });
                              setTimeout(function() {
                                  window.location = "/casos";
                              }, 1500);
                          } else if (respuesta.mensaje === 2) {
                              Swal.fire({
                                  icon: "error",
                                  type: 'error',
                                  html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                  toast: true,
                                  position: "center",
                                  showConfirmButton: false,
                                  //timer: 3000,
                              });
                              setTimeout(function() {
                                  window.location = "/casos";
                              }, 1500);
                          }
                          else if (respuesta.mensaje === 7) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                //timer: 3000,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        }
                        //NO SE ENCONTRO EL ID DEL USUARIO
                        else if (respuesta.mensaje === 8) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el proceso del registro .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                //timer: 3000,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        }
                      }
                  });
 
                 }
 
            
             } 
            else if (tipo_atencion === '5') {
    // 1. Obtención de valores booleanos de los checkboxes de manera concisa
    const option_personal = $('#option-personal').prop('checked');
    const option_comunidad = $('#option-comunidad').prop('checked');
    const option_terceros = $('#option-terceros').prop('checked');
    
    // Asumiendo que 'fecha_hechos', 'denu_involucrados', 'nombre_instancia', etc.,
    // son variables definidas en el scope superior o son obtenidas de otros inputs.
    // **NOTA:** Aquí debes asegurarte de que estas variables existen y tienen valor.
    
    // 2. Validación de Afectados
    if (!option_personal && !option_comunidad && !option_terceros) {
        alert('Debe indicar a quien afecta el hecho');
        return; 
    } 

    // 3. Validación de Campos Requeridos y Recolección de Errores
    const mensajesError = [];

    if (fecha_hechos === '' || fecha_hechos === undefined) {
        mensajesError.push('Debe seleccionar la fecha en que ocurrieron los hechos.');
    }
    
    if (denu_involucrados === '' || denu_involucrados === undefined) {
        $("#denu-involucrados").addClass('is-invalid');
        mensajesError.push('Este campo es requerido, por favor introduzca la información solicitada.');
    } else {
        $("#denu-involucrados").removeClass('is-invalid');
    }

    if (mensajesError.length > 0) {
        alert(mensajesError.join('\n'));
        return; // Detener el proceso si hay errores
    }

    // 4. Preparación de Variables para el Envío
    const bandera_denuncia = true;
    const ente_adscrito = 0; // Se mantiene en 0 según tu lógica original
    
    // Lógica mejorada para 'prop_intelectual'
    let prop_intelectual = $("#tipo-pi").val();
    if (prop_intelectual == null || prop_intelectual === 'null') {
        prop_intelectual = 1; // Asignar valor por defecto
    }

    // Normalizar la cédula para el envío (eliminando el prefijo si existe)
    let cedula_a_enviar = $("#cedula-persona").val();
    if (cedula_a_enviar.charAt(0).match(/[a-zA-Z]/)) {
        cedula_a_enviar = cedula_a_enviar.slice(1);
    }

    // 5. Construcción del Objeto de Datos
    const datos = {
        social_network: $("#red-social").val(),
        'date-entry': $("#fecha-recibido").val(),
        'person-name': $("#nombre-persona").val(),
        'person-lastname': $("#apellido-persona").val(),
        'person-id': cedula_a_enviar,
        nacionalidad: $("#tipo-persona").val(),
        telephone: $("#telefono").val(),
        country: $("#pais-caso").val(),
        state: $("#estado-caso").val(),
        county: $("#municipio-caso").val(),
        town: $("#parroquia-caso").val(),
        'record-work': $("#num-tramite").val(),
        'pi-type': prop_intelectual, 
        'user-requirement': $("#requerimiento-usuario").val(),
        office: $("#office").val(),
        'tipo-atencion-usu': $("#tipo-atencion-usu").val(),
        sexo: $("#sexo").val(),
        tipo_atend_id: tipo_atend_id, // Variable que debe venir definida del scope superior
        bandera_denuncia: bandera_denuncia,
        option_personal: option_personal,
        option_comunidad: option_comunidad,
        option_terceros: option_terceros,
        fecha_hechos: fecha_hechos,
        denu_involucrados: denu_involucrados,
        nombre_instancia: nombre_instancia, // Asegurar que estas variables están definidas
        rif_instancia: rif_instancia,       // Asegurar que estas variables están definidas
        ente_financiador: ente_financiador, // Asegurar que estas variables están definidas
        nombre_proyecto: nombre_proyecto,    // Asegurar que estas variables están definidas
        monto_aprovado: monto_aprovado,      // Asegurar que estas variables están definidas
        bandera_cgr: bandera_cgr,            // Asegurar que estas variables están definidas
        tipo_beneficiario: $("#t-beneficiario").val(),
        direccion: $("#office").val(),
        correo: $("#correo").val(),
        ente_adscrito: ente_adscrito,
        edad: $("#edad").val(),
        fecha_nacimiento: $("#fecha-nacimiento").val(),
        profesion: $("#profesion").val(),
        'organismo-caso': org_id, // Asegurar que 'org_id' está definido
        'act_coordenadas': $("#actcoordenadas").val(),
    };
    
    // 6. Llamada AJAX para el registro del caso
    $.ajax({
        url: "/registrarCaso",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos)) // Mantener el formato de codificación
        },
        beforeSend: function() {
            // Deshabilitar el botón de envío y mostrar un mensaje de carga
            $("button[type=button]").prop('disabled', true);
        },
        success: function(respuesta) {
            $("button[type=button]").prop('disabled', false); // Habilitar al finalizar

            if (respuesta.mensaje === 1) {
                // Éxito en el registro
                Swal.fire({
                    icon: "success",
                    title: '¡Registro Exitoso! ✅',
                    html: `<strong>Caso registrado con el N° ${respuesta.idcaso}</strong>`,
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(() => {
                    // Redirigir después del SweetAlert
                    window.location = "/casos";
                });
            } else if (respuesta.mensaje === 2 || respuesta.mensaje === 7) {
                // Error de registro conocido
                Swal.fire({
                    icon: "error",
                    title: 'Error de Registro ❌',
                    html: '<strong>Hubo un error en el registro del requerimiento.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3000,
                }).then(() => {
                    window.location = "/casos";
                });
            } else {
                 // Respuesta exitosa pero con mensaje inesperado
                 Swal.fire("Error Desconocido", "El servidor respondió, pero el mensaje fue inesperado.", "warning");
            }
        },
        error: function(xhr, status, errorThrown) {
            // Manejo de errores de conexión/servidor
            $("button[type=button]").prop('disabled', false);
            console.error("Error en el registro:", status, errorThrown);
            Swal.fire("Error de Conexión 🛑", `No se pudo registrar el caso. Código: ${xhr.status}`, "error");
        }
    });
}
         // SI ES UN CASO DE MEDIACION ENTRA AQUI
         else if (tipo_atencion === '23') 

         {
         
           
        
            const datos_medicion = obtenerDatosMediacion();

                
                let bandera_cgr = false;
                let bandera_denuncia = false;
                let valor_competencia = ''; 
                let ente_adscrito = 0
                let valor_asume = ''; 

             
                
               
                let competencia_crg = valor_competencia; // Se iguala a las variables inicializadas
                let asume_crg = valor_asume;             // Se iguala a las variables inicializadas


                // --- Procesamiento de Propiedad Intelectual ---
                let prop_intelectual = 1; // Inicializamos con el valor por defecto
                const tipo_prop_intelec = $("#tipo-pi").val();

                // Verifica que el valor no sea nulo, 'null' (como string) o cadena vacía para asignarlo.
                if (tipo_prop_intelec !== null && tipo_prop_intelec !== 'null' && tipo_prop_intelec !== '') 
                {
                    prop_intelectual = tipo_prop_intelec;
                }

                // --- Procesamiento de Cédula ---
                let cedula = $("#cedula-persona").val();

                // Verifica si la cédula existe y si el primer carácter es una letra, luego la remueve.
                if (cedula && cedula.charAt(0).match(/[a-zA-Z]/))
                {
                    cedula = cedula.slice(1);
                }

                // **CORRECCIÓN 4: Se usa 'const' para el objeto de datos final.**
                const datos = { 
                    datos_medicion:datos_medicion,
                    "social_network": $("#red-social").val(),
                    "date-entry": $("#fecha-recibido").val(),
                    "person-name": $("#nombre-persona").val(),
                    "person-lastname": $("#apellido-persona").val(),
                    "person-id": cedula,
                    "tipo_atend_id": tipo_atend_id, 
                    "nacionalidad": $("#tipo-persona").val(),
                    "telephone": $("#telefono").val(),
                    "country": $("#pais-caso").val(),
                    "state": $("#estado-caso").val(),
                    "county": $("#municipio-caso").val(),
                    "town": $("#parroquia-caso").val(),
                    "record-work": $("#num-tramite").val(),
                    "pi-type": prop_intelectual,
                    "user-requirement": $("#requerimiento-usuario").val(),
                    "office": $("#office").val(),
                    "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                    "sexo": $("#sexo").val(),
                    "bandera_cgr": bandera_cgr,
                    "bandera_denuncia": bandera_denuncia,
                    "competencia_crg": competencia_crg, // Usamos la variable declarada/igualada
                    "ente_adscrito": ente_adscrito,
                    "asume_crg": asume_crg,           // Usamos la variable declarada/igualada
                    "tipo_beneficiario": $("#t-beneficiario").val(),
                    "direccion": $("#office").val(), 
                    "correo": $("#correo").val(),
                    "edad": $("#edad").val(),
                    "fecha_nacimiento": $("#fecha-nacimiento").val(),
                    "profesion": $("#profesion").val(),
                    "act_coordenadas": $("#actcoordenadas").val(),
                    "latitud": $("#latitude").val(),
                    "longitud": $("#longitude").val(),
                    "nombre": $("#locationName").val(),
                    "organismo-caso": org_id, // Usamos la variable declarada
                };

                // --- Llamada AJAX ---
                $.ajax({
                    url: "/registrarCaso",
                    method: "POST",
                    dataType: "JSON",
                    // **CORRECCIÓN 5: Se asegura de que el botón se habilite correctamente.**
                    data: {
                        "data": btoa(JSON.stringify(datos))
                    },
                    beforeSend: function() {
                        // Opcional: Deshabilitar el botón aquí para evitar envíos múltiples.
                    },
                    success: function(respuesta) {
                        // Se corrige el valor de 'disabled' a 'true' o 'false', pero es mejor usar .prop() o .removeAttr()
                        $("button[type=button]").removeAttr('disabled'); // **Habilitar el botón**
                        
                        if (respuesta.mensaje === 1) {
                            Swal.fire({
                                icon: "success",
                                html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + respuesta.idcaso + '</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        } else if (respuesta.mensaje === 2 || respuesta.mensaje === 7) { 
                            // **CORRECCIÓN 6: Se agrupan los mensajes de error para evitar duplicación de código.**
                            Swal.fire({
                                icon: "error",
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario.</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        }
                    }
                });

        
         

         }
         else 
         {
             bandera_cgr = false;
             bandera_denuncia = false;
             valor_competencia = '';
             ente_adscrito = 0
             valor_asume = '';

             let tipo_prop_intelec = $("#tipo-pi").val();

             
             if (tipo_prop_intelec !=null && tipo_prop_intelec !='null') 
            {
                prop_intelectual= $("#tipo-pi").val();
            }
            else
            {
                prop_intelectual = 1

            }


       
       
             let cedula= $("#cedula-persona").val()
             if (cedula.charAt(0).match(/[a-zA-Z]/))
             {
                 cedula = cedula.slice(1);
             }
             let datos = {
                 "social_network": $("#red-social").val(),
                 "date-entry": $("#fecha-recibido").val(),
                 "person-name": $("#nombre-persona").val(),
                 "person-lastname": $("#apellido-persona").val(),
                 "person-id": cedula,
                 "tipo_atend_id": tipo_atend_id,
                 "nacionalidad": $("#tipo-persona").val(),
                 "telephone": $("#telefono").val(),
                 "country": $("#pais-caso").val(),
                 "state": $("#estado-caso").val(),
                 "county": $("#municipio-caso").val(),
                 "town": $("#parroquia-caso").val(),
                 "record-work": $("#num-tramite").val(),
                 "pi-type":prop_intelectual,
                 "user-requirement": $("#requerimiento-usuario").val(),
                 "office": $("#office").val(),
                 "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                 "sexo": $("#sexo").val(),
                 "bandera_cgr": bandera_cgr,
                 "bandera_denuncia": bandera_denuncia,
                 "competencia_crg": competencia_crg,
                 "ente_adscrito": ente_adscrito,
                 "asume_crg": asume_crg,
                 "tipo_beneficiario": $("#t-beneficiario").val(),
                 "direccion": $("#office").val(),
                 "correo": $("#correo").val(),
                 "edad": $("#edad").val(),
                 "fecha_nacimiento": $("#fecha-nacimiento").val(),
                 "profesion": $("#profesion").val(),
                "act_coordenadas": $("#actcoordenadas").val(),
                "latitud": $("#latitude").val(),
                "longitud": $("#longitude").val(),
                "nombre": $("#locationName").val(),
                "organismo-caso": org_id,



             }
             $.ajax({
                 url: "/registrarCaso",
                 method: "POST",
                 dataType: "JSON",
                 data: {
                     "data": btoa(JSON.stringify(datos))
                 },
                 beforeSend: function() {
                     
                 },
                 success: function(respuesta) {
                     $("button[type=button]").attr('disabled', 'false');
                     if (respuesta.mensaje === 1) {
                         Swal.fire({
                             icon: "success",
                             type: 'success',
                             html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + ' ' + respuesta.idcaso + '</strong>',
                             toast: true,
                             position: "center",
                             showConfirmButton: false,
                             //timer: 3500,
 
                         });
                         setTimeout(function() {
                             window.location = "/casos";
                         }, 1500);
                     } else if (respuesta.mensaje === 2) {
                         Swal.fire({
                             icon: "error",
                             type: 'error',
                             html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                             toast: true,
                             position: "center",
                             showConfirmButton: false,
                             //timer: 1500,
                         });
                         setTimeout(function() {
                             window.location = "/casos";
                         }, 1500);
                     }
                     else if (respuesta.mensaje === 7) {
                        Swal.fire({
                            icon: "error",
                            type: 'error',
                            html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                            toast: true,
                            position: "center",
                            showConfirmButton: false,
                            //timer: 3000,
                        });
                        setTimeout(function() {
                            window.location = "/casos";
                        }, 1500);
                    }
                 }
             });
         }
 
     }
 
 
 });

 // Función auxiliar para calcular la edad (movida fuera del evento para mejor organización)
function calcularEdad(fechaNacimientoStr) {
    const hoy = new Date();
    // Asegurarse de que el formato de fecha sea YYYY-MM-DD para compatibilidad
    const fechaNacimiento = new Date(fechaNacimientoStr.replace(/-/g, '/')); 
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();

    // Ajustar la edad si aún no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }
    return edad;
}

// Función principal para cargar todos los datos del usuario y sus dependencias
function cargarDatosUsuario(caso, cedulaNormal) {
    const datos = {
        nombre: caso.casonom,
        apellido: caso.casoape,
        cedula: cedulaNormal,
        nacionalidad: caso.caso_nacionalidad || 'V', // Valor por defecto 'V' si es nulo
        beneficiario: caso.tipo_beneficiario,
        genero: caso.sexo,
        telefono: caso.casotel,
        correo: caso.correo,
        estado: caso.estadoid,
        municipio: caso.municipioid,
        parroquia: caso.parroquiaid,
        fecha_nacimiento: caso.fecha_nacimiento,
        profesion: caso.profesion,
    };

    // 1. Asignación de valores a Inputs
    $("#nombre-persona").val(datos.nombre);
    $("#apellido-persona").val(datos.apellido);
    $("#cedula-persona").val(datos.cedula);
    $("#telefono").val(datos.telefono);
    $("#correo").val(datos.correo);
    $("#fecha-nacimiento").val(datos.fecha_nacimiento);
    $("#profesion").val(datos.profesion);
    
    // Calcular y asignar edad
    if (datos.fecha_nacimiento) {
        $("#edad").val(calcularEdad(datos.fecha_nacimiento));
    }

    // 2. Selección de opciones en Selects (usando .val() de jQuery es más simple)
    $("#tipo-persona").val(datos.nacionalidad);
    $("#t-beneficiario").val(datos.beneficiario);
    $("#sexo").val(datos.genero);
    $("#estado-caso").val(datos.estado);
    
    // 3. Carga ENCADENADA de Municipios y Parroquias (Solución al problema)
    const datosMunicipio = { id_estado: datos.estado };
    
    // Petición para cargar los Municipios
    $.ajax({
        url: "/municipios",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(datosMunicipio)),
        },
    })
    .done((response) => {
        $("#municipio-caso").html(response.data);
        $("#municipio-caso").val(datos.municipio); // Selecciona el municipio guardado

        // Petición ENCADENADA para cargar las Parroquias (SÓLO si el Municipio se cargó)
        const datosParroquia = {
            id_municipio: datos.municipio, 
        };

        // Devolvemos la promesa de la segunda llamada AJAX
        return $.ajax({ 
            url: "/parroquias",
            method: "POST",
            dataType: "JSON",
            data: {
                data: btoa(JSON.stringify(datosParroquia)),
            },
        });
    })
    .done((response) => {
        // Se ejecuta cuando las Parroquias se han cargado exitosamente
        $("#parroquia-caso").html(response.data);
        $("#parroquia-caso").val(datos.parroquia); // Selecciona la parroquia guardada
    })
    .fail((request, textStatus, errorThrown) => {
        // Manejo de error si falla cualquiera de las dos llamadas
        console.error("Error en la carga de dependencias:", textStatus, errorThrown);
        alert("Error: No se pudieron cargar los municipios o parroquias.");
    });
}

// --------------------------------------------------------------------------

// Evento click del botón de búsqueda
$('#btn_buscar').on('click', function(e) {
    e.preventDefault(); 

    let cedula = $("#cedula-existente").val().trim();
    const cedula_normal = $("#cedula-existente").val().trim();
    
    // Normalizar la cédula: eliminar el primer carácter si es una letra
    if (cedula.charAt(0).match(/[a-zA-Z]/)) {
        cedula = cedula.slice(1);
    }
    
    if (cedula === '') { 
        alert('Debe ingresar la cédula para los datos del Usuario');
        return; 
    }
    
    const url = '/buscar_datos_usuarios';
    const data = {
        cedula_existente: cedula,
    };

    $.ajax({
        url: url,
        method: 'POST',
        // Se mantiene el formato de codificación si el backend lo requiere
        data: {data:btoa(unescape(encodeURIComponent(JSON.stringify(data))))}, 
        dataType: 'JSON',
        beforeSend: function(data) {
            // Aquí se puede mostrar un spinner
        },
        success: function(response) {
            if (response === 0) {
                alert('La cedula no se encuentra registrada');
                $("#cedula-persona").val(cedula);
                // También limpiar otros campos si es un error de búsqueda
                $("#nombre-persona, #apellido-persona, #telefono, #correo, #edad, #profesion").val('');
            } else {
                // Llama a la función que organiza la carga de datos y las dependencias
                cargarDatosUsuario(response[0], cedula_normal);
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error en la búsqueda:", status, errorThrown);
            alert(`Error ${xhr.status}: ${errorThrown}`);
        }
    });
});

$("#fecha-nacimiento").on('change', function() {
    // Obtener la fecha de nacimiento seleccionada
    var fechaNacimiento = new Date($(this).val());
    var hoy = new Date();
    
    // Calcular la edad
    var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    var mes = hoy.getMonth() - fechaNacimiento.getMonth();
    
    // Ajustar la edad si no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }
    // Asignar la edad al elemento con id='edad'
    $("#edad").val(edad);
});

function obtenerDatosMediacion() {
    
    // Función auxiliar para obtener el valor del campo de texto o select
    const getElementValue = (id) => $(`#${id}`).val();

    // -----------------------------------------------------------
    // A. Datos del Apoderado del Solicitante (Tipo = 1)
    // -----------------------------------------------------------
    const apoderadoSolicitante = {
        // Campo identificador para la BD
        tipo_apoderado: '1', 
        

        // Datos Personales
        ident_tipo: getElementValue('apo_solicitente-ident-tipo'),
        ci: getElementValue('apoderado-solicitante-ci'),
        impre: getElementValue('apoderado-solicitante-impre'),
        nombres: getElementValue('apoderado-solicitante-nombres'),
        telefono: getElementValue('apoderado-solicitante-telefono'),
        correo: getElementValue('apoderado-solicitante-correo'),
        
        // Ubicación
        pais: getElementValue('apoderado-solicitante-pais-select'),
        estado: getElementValue('apoderado-solicitante-estado-select'),
        municipio: getElementValue('apoderado-solicitante-municipio-select'),
        parroquia: getElementValue('apoderado-solicitante-parroquia-select'),
        direccion: getElementValue('apoderado-solicitante-direccion')
    };

    // -----------------------------------------------------------
    // B. Datos de la Contraparte
    // -----------------------------------------------------------
    const contraparte = {
        // Datos Personales y de Identificación
        
      
        nombre_razon: getElementValue('contraparte-nombre-razon'),
        ident_tipo: getElementValue('contraparte-ident-tipo'),
        ident_valor: getElementValue('contraparte-ident-valor'),
        correo: getElementValue('contraparte-correo'),
        telefono: getElementValue('contraparte-telefono'),
        // Ubicación
        pais: getElementValue('contraparte-pais-select'),
        estado: getElementValue('contraparte-estado-select'),
        municipio: getElementValue('contraparte-municipio-select'),
        parroquia: getElementValue('contraparte-parroquia-select'),
        direccion: getElementValue('contraparte-direccion')
    };

    // -----------------------------------------------------------
    // C. Datos del Apoderado de la Contraparte (Tipo = 2)
    // -----------------------------------------------------------
    const apoderadoContraparte = {
        // Campo identificador para la BD
        tipo_apoderado: '2', 
        // Datos Personales y de Identificación
        ident_tipo: getElementValue('apo_contraparte-ident-tipo'),
        ci: getElementValue('contraparte-apoderado-ci'),
        impre: getElementValue('contraparte-apoderado-impre'),
        // Datos Personales
        nombres: getElementValue('apoderado-contraparte-nombres'),
        telefono: getElementValue('apoderado-contraparte-telefono'),
        correo: getElementValue('apoderado-contraparte-correo'),
        
        // Ubicación
        pais: getElementValue('apoderado-contraparte-pais-select'),
        estado: getElementValue('apoderado-contraparte-estado-select'),
        municipio: getElementValue('apoderado-contraparte-municipio-select'),
        parroquia: getElementValue('apoderado-contraparte-parroquia-select'),
        direccion: getElementValue('apoderado-contraparte-direccion')
    };

    // -----------------------------------------------------------
    // D. Descripción de la Controversia (CORREGIDA para Radio Buttons)
    // -----------------------------------------------------------
    const controversia = {
        // 🚨 Radio Buttons: Obtiene el valor del radio button seleccionado
        // Asume que el atributo 'name' de todos los radios es 'tipo_controversia'
        tipo_controversia: $('#tipo-pi').val(),
        
        
    };


    // Objeto final que contiene toda la información organizada
    const datosMediacion = {
        apoderado_solicitante: apoderadoSolicitante,
        contraparte: contraparte,
        apoderado_contraparte: apoderadoContraparte,
        controversia: controversia
    };
    
    // Puedes usar esto para depurar y ver el objeto en la consola
    // console.log(datosMediacion);

    return datosMediacion;
}

//Metodo para buscar la informacion del solicitante en funcion de la cedula 

/**
 * Función genérica para buscar un tercero y mapear sus datos a una sección del formulario.
 * @param {string} prefix - Prefijo de la sección destino ('apoderado-solicitante', 'contraparte', 'apoderado-contraparte').
 */
// =================================================================
// 2. FUNCIÓN MAESTRA DE BÚSQUEDA (buscar_Tercero_Mediacion)
//Función Maestra de Búsqueda. Obtiene la cédula del campo de búsqueda (cedula-existente), 
// realiza la llamada AJAX (/buscar_datos_cedula_mediacion/), maneja los estados (cargando/error) y 
// dirige los datos a mapearDatosTercero si la búsqueda es exitosa. 
// Centraliza la lógica de los botones "Buscar".
// =================================================================


function buscar_Tercero_Mediacion(prefix) {
    
    let cedulaInputId;
    let botonId = `#btn_buscar_${prefix.replace('-', '_')}`; 

    if (prefix === 'contraparte') { cedulaInputId = `#cedula-existente-contra`; } 
    else if (prefix === 'apoderado-solicitante') { cedulaInputId = `#cedula-existente-apo-sol`; } 
    else { cedulaInputId = `#cedula-existente-apo-contra`; }

    const $input = $(cedulaInputId);
    const $boton = $(botonId);

    let cedula_existente = ($input.val() || '').trim();
    
    if (!cedula_existente) {
        Swal.fire("Advertencia", `Debe ingresar la cédula o RIF para buscar los datos de ${prefix.replace('-', ' ')}.`, "warning");
        return;
    }

    const url = '/buscar_datos_cedula_mediacion/' + cedula_existente;
    
    $.ajax({
        url: url,
        method: 'GET', 
        dataType: 'JSON',
        
        beforeSend: function() { $boton.prop('disabled', true).text('Buscando...'); },
        
        success: function(response) {    
            $boton.prop('disabled', false).text('Buscar'); 
            
            // 1. Lógica de NO ENCONTRADO (El tercero NO existe en la base de datos)
            if (response.error || !response.ter_identificacion) {
                Swal.fire("Información", response.error || 'No se encontraron datos para la identificación: ' + cedula_existente, "info");
                
                limpiarCamposTercero(prefix); 
                mapearCedulaFormulario(prefix, cedula_existente);

                // 🚨 CAMBIO CLAVE: LIBERAR campos para que el usuario pueda agregar la información
                toggleCamposEdicion(prefix, true); 
                return;
            }
            
            // 2. Lógica de ENCONTRADO (El tercero SÍ existe en la base de datos)
            
            mapearDatosTercero(prefix, response);
            
            // 🚨 CAMBIO CLAVE: MANTENER BLOQUEADOS los campos (modo solo lectura)
            toggleCamposEdicion(prefix, false); 
            
            if (prefix.includes('apoderado')) {
                $(`#${prefix}-aplica`).prop('checked', true);
                if (typeof toggleApoderado === 'function') {
                    toggleApoderado(prefix); 
                }
            }

            Swal.fire("Éxito", `Datos  cargados correctamente.`, "success");
        },
        
        error: function(xhr, status, errorThrown) {
            $boton.prop('disabled', false).text('Buscar'); 
            console.error("Error en la solicitud:", status, errorThrown, xhr);
            Swal.fire("Error", "Ocurrió un error al intentar buscar los datos.", "error");
        }
    });
}