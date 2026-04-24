
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
 
    
     llenar_Propiedad_Intelectual();
     llenar_Estados(); // Llamar sin parámetros o con undefined
     llenar_pais();
     llenar_Red_social();
     llenar_Entes_asdcritos();
     llenar_Tipo_Beneficiarios();
     llenar_Organismos_PP();

   // 1. INICIALIZACIÓN DE SELECTORES PARA APODERADO SOLICITANTE
    llenar_Selectores_Iniciales("apoderado-solicitante");

    // 2. INICIALIZACIÓN DE SELECTORES PARA CONTRAPARTE
    llenar_Selectores_Iniciales("contraparte");

    // 3. INICIALIZACIÓN DE SELECTORES PARA APODERADO CONTRAPARTE
    llenar_Selectores_Iniciales("apoderado-contraparte");

// toggleCamposEdicion('apoderado-solicitante', false); 
//     toggleCamposEdicion('contraparte', false); 
//     toggleCamposEdicion('apoderado-contraparte', false);

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

    // Enhanced delegated handler for Consignación table (ID 24) checkboxes + TOTAL
    $(document).on('change', '.check-pi', function() {
        const $row = $(this).closest('tr');
        const $qty = $row.find('.qty-pi');
        if (this.checked) {
            $qty.prop('disabled', false).val('1');
        } else {
            $qty.prop('disabled', true).val('0');
        }
        actualizarTotalCasosPI();
    });

    // Update total when quantity changes
    $(document).on('input', '.qty-pi', function() {
        actualizarTotalCasosPI();
    });

 // =================================================================
// I. FUNCIONES DE LLENADO DE COMBOBOX (SELECTS)
// =================================================================

// FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e) {
    if (e && e.preventDefault) e.preventDefault();
    const url = "/llenar_Estados";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {
            // Puedes agregar un loader o alguna indicación de que se está cargando
        },
        success: function(data) {
            if (data.length >= 1) {
                $("#estado-caso").empty();
                $("#estado-caso").append(
                    "<option value='0' selected disabled>Seleccione</option>"
                );
                $.each(data, function(i, item) {
                    $("#estado-caso").append(
                        "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar estados:", errorThrown);
        },
    });
}

// FUNCION PARA LLENAR EL COMBO PAIS
function llenar_pais(e) {
    if (e && e.preventDefault) e.preventDefault();
    url = "/llenar_pais";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#pais-caso").empty();
                $.each(data, function(i, item) {
                    $("#pais-caso").append(
                        "<option value=" + item.paisid + ">" + item.paisnom + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar países:", errorThrown);
        },
    });
}

// =================================================================
// II. MANEJADORES DE EVENTOS DE VALIDACIÓN
// =================================================================

$("#red-social").on('change', function() {
    $("#red-social").removeClass('is-invalid');
    let id_red_social = $('#red-social').val();
    llenar_Tipo_Atencion(id_red_social);   
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


// Evento que busca los municipios por estados (Disparado al cambiar la selección)
$(document).on("change", "#estado-caso", (e) => {
    e.preventDefault();
    
    // Validar que se haya seleccionado un estado válido (no "Seleccione" que tiene valor 0)
    const estadoId = $("#estado-caso").val();
    if (!estadoId || estadoId === '0' || estadoId === 0) {
        // Limpiar los selectores dependientes
        $("#municipio-caso").html("<option value='0' selected disabled>Seleccione</option>");
        $("#parroquia-caso").html("<option value='0' selected disabled>Seleccione</option>");
        return;
    }
    
    let datos = {
        id_estado: estadoId,
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
        
        // Obtener el primer municipio cargado y cargar sus parroquias
        let mun = $("#municipio-caso").val();
        if (mun && mun !== '0') {
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
            // Si no hay municipios, limpiar parroquias
            $("#parroquia-caso").html("<option value='0' selected disabled>Seleccione</option>");
        }
    })
    .then((response) => {
        if (response) {
            $("#parroquia-caso").html(response.data);
        }
    })
    .catch((request) => {
        console.error("Error al cargar municipios:", request);
        Swal.fire("Error", "Error al cargar municipios.", "error");
    });
});

// Evento que busca las parroquias por municipio (Disparado al cambiar la selección)
$(document).on("change", "#municipio-caso", (e) => {
    e.preventDefault();
    
    // Validar que se haya seleccionado un municipio válido
    const municipioId = $("#municipio-caso").val();
    if (!municipioId || municipioId === '0' || municipioId === 0) {
        // Limpiar el selector de parroquias
        $("#parroquia-caso").html("<option value='0' selected disabled>Seleccione</option>");
        return;
    }
    
    let datos = {
        id_municipio: municipioId,
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
        console.error("Error al cargar parroquias:", request);
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
function llenar_Organismos_PP(e) {
    if (e && e.preventDefault) e.preventDefault();
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
                $.each(data, function(i, item) {
                    $("#organismo-caso").append(
                        "<option value=" + item.org_id + ">" + item.org_nombre + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar organismos:", errorThrown);
        },
    });
}








 
//FUNCION PARA LLENAR EL COMBO TIPO DE BENEFICIARIOS
function llenar_Tipo_Beneficiarios(e) {
    if (e && e.preventDefault) e.preventDefault();
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
                $.each(data, function(i, item) {
                    $("#t-beneficiario").append(
                        "<option value=" + item.tipo_beneficiario_id + ">" + item.tipo_beneficiario_nombre + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar tipos de beneficiario:", errorThrown);
        },
    });
}
 
//FUNCION PARA LLENAR EL COMBO ENTES ADSCRITOS
function llenar_Entes_asdcritos(e) {
    if (e && e.preventDefault) e.preventDefault();
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
                $.each(data, function(i, item) {
                    $("#ente-adscrito").append(
                        "<option value=" + item.ente_id + ">" + item.ente_nombre + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar entes adscritos:", errorThrown);
        },
    });
}
 
//FUNCION PARA LLENAR EL COMBO DE LAS REDES SOCIALES
function llenar_Red_social(e) {
    if (e && e.preventDefault) e.preventDefault();
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
                $.each(data, function(i, item) {
                    $("#red-social").append(
                        "<option value=" + item.red_s_id + ">" + item.red_s_nom + "</option>"
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar redes sociales:", errorThrown);
        },
    });
}
 
 


 
// FUNCION PARA LLENAR EL COMBO TIPO DE PROPIEDAD INTELECTUAL
function llenar_Propiedad_Intelectual(e) {
    if (e && e.preventDefault) e.preventDefault();
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
                $.each(data, function(i, item) {
                    $("#tipo-pi").append(
                        "<option value=" +
                        item.tipo_prop_id +
                        ">" +
                        item.tipo_prop_nombre +
                        "</option>"
                    );
                });
            }
            window.propiedadIntelectualData = data; // Store for table generation
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar propiedad intelectual:", errorThrown);
        },
    });
}
function generarTablaPropiedadIntelectual() {
    if (!window.propiedadIntelectualData || window.propiedadIntelectualData.length === 0) {
        console.error('No PI data available');
        return;
    }

    // Agregamos w-100 a la card y a la tabla
    let tableHTML = `
        <div class="card border-0 shadow-sm overflow-hidden w-100" style="border-radius: 8px;">
            <div class="card-header border-0 py-2" style="background-color: #0d56b3; color: white;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-list-check me-2"></i>
                    <small class="fw-bold text-uppercase">Tipo de Propiedad Intelectual </small>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0 w-100">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center" style="width: 5%; color: #666; font-size: 0.8rem;">ACTIVO</th>
                            <th class="ps-3" style="color: #666; font-size: 0.8rem;">DESCRIPCIÓN</th>
                            <th class="text-center" style="width: 15%; color: #666; font-size: 0.8rem;">CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>`;

    $.each(window.propiedadIntelectualData, function(i, item) {
        tableHTML += `
                <tr data-pi-id="${item.tipo_prop_id}" class="pi-row-modern">
                    <td class="text-center">
                        <div class="form-check d-flex justify-content-center">
                            <input type="checkbox" class="form-check-input check-pi custom-checkbox" 
                                   data-pi-id="${item.tipo_prop_id}">
                        </div>
                    </td>
                    <td class="ps-3 fw-semibold text-dark" style="font-size: 0.85rem;">
                        ${item.tipo_prop_nombre}
                    </td>
                    <td class="pe-2">
                        <input type="number" class="form-control form-control-sm qty-pi text-center w-100" 
                               data-pi-id="${item.tipo_prop_id}" 
                               value="0" disabled min="1" max="999"
                               style="border-radius: 4px; border: 1px solid #ddd; max-width: 100px; margin: 0 auto;">
                    </td>
                </tr>`;
    });

    tableHTML += `
                    </tbody>
                    <tfoot style="background-color: #e9ecef; font-weight: bold;">
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td class="ps-3 text-end fw-bold text-uppercase" style="color: #0d56b3; font-size: 0.9rem;">
                                TOTAL DE CASOS A CREAR
                            </td>
                            <td class="text-center fw-bold fs-6" style="color: #0d56b3;" id="total-casos-pi">
                                0
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>`;

    $('#pi-table-container').html(tableHTML).fadeIn();
}
/**
 * Actualiza el total de casos PI en tiempo real
 */
function actualizarTotalCasosPI() {
    let total = 0;
    $('.check-pi:checked').each(function() {
        const $row = $(this).closest('tr');
        const qtyVal = parseInt($row.find('.qty-pi').val()) || 0;
        total += qtyVal;
    });
    $('#total-casos-pi').text(total);
    
    // Optional: Visual feedback
    if (total > 0) {
        $('#total-casos-pi').removeClass('text-muted').addClass('text-success fw-bolder');
    } else {
        $('#total-casos-pi').removeClass('text-success').addClass('text-muted');
    }
}

function validarTablaPI() {
    let hasValid = false;
    $('.check-pi').each(function() {
        let row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            let cantidad = parseInt(row.find('.qty-pi').val()) || 0;  // Fixed selector
            if (cantidad > 0) {
                hasValid = true;
                return false; // break
            }
        }
    });
    return hasValid;
}
 
// Función para llenar el combo tipo de atención usuario
function llenar_Tipo_Atencion(idRedSocial) {
    if (!idRedSocial) {
        let $select = $("#tipo-atencion-usu");
        $select.empty();
        $select.append("<option value='0' selected disabled>Seleccione</option>");
        return;
    }
    
    let url = "/buscar_via_tipo_atencion/" + idRedSocial;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function() {},
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
            console.error("Error al cargar tipos de atención:", xhr.status);
        },
    });
}


// Evento change para el select de tipo de atención
$("#tipo-atencion-usu").on('change', function(e) {
    const $this = $(this);
    const idTipoAtencion = $this.val();
    const selectedOption = $this.find('option:selected');
    
    // Mostramos modal y habilitamos el select de detalles
    $("#ayudas").modal("show");
    $(".detelle_atencion").show(); // Mostramos el contenedor div
    $("#detalles_atencion").prop("disabled", false);
    
    // Reset por defecto del validador de hijos
    $("#hijos_tipoatencion").val('NO');

    // Obtener data attributes
    const actProInt = selectedOption.data('act-pro-int');
    const organismoPp = selectedOption.data('organismo_pp');
    
    // 1. Limpieza inicial de secciones condicionales
    $("#mediacion, #cgr, #denuncias, .mapa_ayuda, #pi-table-container").hide();

    // 2. Lógica de visibilidad basada en ID
    if (idTipoAtencion == 5) {
        $("#denuncias").show();
    } else if (idTipoAtencion == 1) {
        // Lógica específica para ID 1 si la requiere, de lo contrario se queda oculto
    } else if (idTipoAtencion == 23) {
        $("#mediacion").show();
    }

    // 3. Lógica de Propiedad Intelectual (ID 24)
    if (idTipoAtencion == 24) {
        generarTablaPropiedadIntelectual();
        $('#tipo-pi, .label_propiedad').hide();
        $('#pi-table-container').show();
    } else {
        $('#tipo-pi, .label_propiedad').show();
        // Si existe la función, la llamamos, si no, asegúrate de tenerla definida
        if (typeof limpiarTablaPI === "function") limpiarTablaPI();
    }

    // 4. Lógica basada en Data Attributes (Toggle)
    // .tipoproint y .org_pp se muestran si el valor es 't'
    $(".tipoproint").toggle(actProInt === 't');
    $("#tipo-pi").prop("disabled", actProInt !== 't');

    $(".org_pp").toggle(organismoPp === 't');
    $("#organismo-caso").prop("disabled", organismoPp !== 't');

    // 5. Petición AJAX para Coordenadas
    $.ajax({
        url: `/Listar_Tipo_Atencion_act_coordenadas/${idTipoAtencion}`,
        method: 'GET',
        dataType: 'json'
    })
    .done((response) => {
        // Validamos que exista respuesta y el campo act_coordenadas
        const data = response[0]; 
        if (data && data.act_coordenadas === 't') {
            $(".mapa_ayuda").show();
            $("#actcoordenadas").val('t');
            
            // Si usas Leaflet o Google Maps, esto refresca el mapa
            if (typeof map !== 'undefined' && map.invalidateSize) {
                setTimeout(() => map.invalidateSize(), 200);
            }
        } else {
            $(".mapa_ayuda").hide();
            $("#actcoordenadas").val('f');
            // Limpiar inputs de coordenadas si es necesario
            $("#latitude, #longitude, #locationName").val('');
        }
    })
    .fail((xhr) => {
        const errorMessage = xhr.responseJSON?.message || 'Error al cargar datos.';
        Swal.fire('Error', errorMessage, 'error');
    });

    // 6. Ejecución de función externa
    llenar_detalle_atencion(e, idTipoAtencion);
});










function llenar_detalle_atencion(e, idTipoAtencion) {
    if (e && e.preventDefault) e.preventDefault();
    
    // 1. Limpieza previa de errores y estados
    $('#detalles_atencion').removeClass('is-invalid');
    const $contenedorDetalle = $(".detelle_atencion");
    const $selectDetalle = $('#detalles_atencion');
    const url = '/Listar_Detalle_Atencion_filtro';

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            // Compatibilidad PHP 8.4: Asegurar que data sea un objeto/array
let registros = safeParseJSON(data);

            // 2. Filtrar PRIMERO los datos antes de decidir si mostrar el select
            if (idTipoAtencion !== undefined && registros) {
                registros = registros.filter(dato => dato.tipo_aten_id == idTipoAtencion);
            }

            // 3. Lógica de visibilidad basada en el resultado del filtro
            if (registros && registros.length > 0) {
                $contenedorDetalle.show();
                $selectDetalle.empty().append('<option value="0" selected disabled>Seleccione</option>');
                
                $.each(registros, function(i, item) {
                    $selectDetalle.append('<option value="' + item.tipo_atend_id + '">' + item.tipo_atend_nombre + '</option>');
                });
                
                $("#hijos_tipoatencion").val('SI');
            } else {
                // 4. Si no hay datos que coincidan, ocultar y resetear TODO
                $contenedorDetalle.hide();
                $selectDetalle.empty().val('0');
                $("#hijos_tipoatencion").val('NO');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición:", error);
            $contenedorDetalle.hide();
            $("#hijos_tipoatencion").val('NO');
        }
    });
}


 $("#requerimiento-usuario").on('change', function() {
     $("#requerimiento-usuario").removeClass('is-invalid');
 });




// 🔧 FUNCIÓN safeParseJSON() - AL TOP DEL ARCHIVO (CRÍTICO)
function safeParseJSON(data) {
    try {
        if (typeof data === 'string') {
            const trimmed = data.trim();
            if (trimmed === '' || trimmed === 'null') return {error: true, mensaje: 8};
            return JSON.parse(trimmed);
        }
        if (data && typeof data === 'object') return data;
        console.error('Respuesta AJAX inválida:', data);
        return {error: true, mensaje: 2};
    } catch (e) {
        console.error('Error parsing JSON:', e, data);
        return {error: true, mensaje: 2};
    }
}

// METODO PARA GUARDAR EL CASO
$(document).on("click", "#guardar", function(e) {
    e.preventDefault();
    
    // 1. INHABILITAR INMEDIATAMENTE
    let $btn = $(this);
    $btn.prop('disabled', true);

    // 2. CAPTURA DE VARIABLES BÁSICAS
    let tipo_atencion = $("#tipo-atencion-usu").val();
    let tipo_atend_id = $("#detalles_atencion").val();
    let requerimiento_user = $("#requerimiento-usuario").val() ? $("#requerimiento-usuario").val().trim() : '';
    let red_social = $("#red-social").val();
    let estado = $("#estado-caso").val();
    let org_id = $("#organismo-caso").val() || 1;
    let cedula = $("#cedula-persona").val();

    // --- LÓGICA PARA CONSIGNACIÓN (TIPO 24) ---
    let lista_consignacion = null; 
    if (tipo_atencion === '24') {
        let items = [];
        $(".check-pi:checked").each(function() {
            let fila = $(this).closest('tr');
            let cantidad_input = fila.find('input[type="number"]');
            let cantidad_valor = parseInt(cantidad_input.val());

            items.push({
                id_pi: $(this).data('pi-id'),
                cantidad: isNaN(cantidad_valor) ? 1 : cantidad_valor 
            });
        });

        if (items.length === 0) {
            $btn.prop('disabled', false); // Rehabilitar si falla validación
            return Swal.fire({ 
                icon: "warning", 
                html: '<strong>Debe seleccionar al menos un ítem para la consignación.</strong>', 
                toast: true, 
                position: "center", 
                showConfirmButton: false, 
                timer: 3000 
            });
        }
        lista_consignacion = JSON.stringify(items);
    }

    // 3. VALIDACIONES DE CAMPOS OBLIGATORIOS
    $(".is-invalid").removeClass('is-invalid');

    if (!red_social || !estado || !tipo_atencion || requerimiento_user === '') {
        if (!red_social) $("#red-social").addClass('is-invalid');
        if (!estado) $("#estado-caso").addClass('is-invalid');
        if (!tipo_atencion) $("#tipo-atencion-usu").addClass('is-invalid');
        if (requerimiento_user === '') $("#requerimiento-usuario").addClass('is-invalid');

        $btn.prop('disabled', false); // Rehabilitar si faltan campos
        return Swal.fire({ 
            icon: "error", 
            html: '<strong>Complete los campos obligatorios resaltados.</strong>', 
            toast: true, 
            position: "center", 
            showConfirmButton: false, 
            timer: 3000 
        });
    }

    // 4. LIMPIEZA DE CÉDULA
    if (cedula && cedula.charAt(0).match(/[a-zA-Z]/)) { 
        cedula = cedula.slice(1); 
    }

    // 5. CONSTRUCCIÓN DEL OBJETO DE DATOS
    let datosBase = {
        "social_network": red_social,
        "date-entry": $("#fecha-recibido").val(),
        "person-name": $("#nombre-persona").val(),
        "person-lastname": $("#apellido-persona").val(),
        "person-id": cedula,
        "nacionalidad": $("#tipo-persona").val(),
        "telephone": $("#telefono").val(),
        "country": $("#pais-caso").val(),
        "state": estado,
        "county": $("#municipio-caso").val(),
        "town": $("#parroquia-caso").val(),
        "record-work": $("#num-tramite").val(),
        "pi-type": $("#tipo-pi").val() || 1,
        "user-requirement": requerimiento_user,
        "office": $("#office").val(),
        "tipo-atencion-usu": tipo_atencion,
        "sexo": $("#sexo").val(),
        "tipo_atend_id": tipo_atend_id,
        "tipo_beneficiario": $("#t-beneficiario").val(),
        "direccion": $("#office").val(),
        "correo": $("#correo").val(),
        "ente_adscrito": 0,
        "edad": $("#edad").val(),
        "fecha_nacimiento": $("#fecha-nacimiento").val(),
        "profesion": $("#profesion").val(),
        "organismo-caso": org_id,
        "act_coordenadas": $("#actcoordenadas").val(),
        "latitud": $("#latitude").val() || '',
        "longitud": $("#longitude").val() || '',
        "lista_consignacion": lista_consignacion,
        "bandera_cgr": false,
        "bandera_denuncia": false
    };

    // 6. LÓGICA SEGÚN TIPO DE ATENCIÓN
    if (tipo_atencion === '1') {
        datosBase.bandera_cgr = true;
        datosBase.competencia_crg = $("#competencia_crg").val() || 2;
        datosBase.asume_crg = $("#asume_crg").val() || 2;
    } 
    else if (tipo_atencion === '5') {
        datosBase.bandera_denuncia = true;
        datosBase.denu_afecta_persona = $('#option-personal').prop('checked');
        datosBase.denu_afecta_comunidad = $('#option-comunidad').prop('checked');
        datosBase.denu_afecta_terceros = $('#option-terceros').prop('checked');
        datosBase.denu_fecha_hechos = $('#fecha-hechos').val();
        datosBase.denu_involucrados = $('#denu-involucrados').val();
        datosBase.denu_instancia_popular = $('#nombre-instancia').val();
        datosBase.denu_rif_instancia = $('#rif-instancia').val();
        datosBase.denu_ente_financiador = $('#ente-financiador').val();
        datosBase.denu_nombre_proyecto = $('#nombre-proyecto').val();
        datosBase.denu_monto_aprovado = $('#monto-aprovado').val();
    }
    else if (tipo_atencion === '23') {
        datosBase.datos_medicion = (typeof obtenerDatosMediacion === 'function') ? obtenerDatosMediacion() : null;
    }

    // 7. ENVÍO AJAX
    $.ajax({
        url: "/registrarCaso",
        method: "POST",
        dataType: "JSON",
        timeout: 45000,
        data: { "data": btoa(unescape(encodeURIComponent(JSON.stringify(datosBase)))) },
        success: function(respuesta) {
            procesarRespuesta(respuesta);
            // Rehabilitar solo si el servidor devuelve error controlado
            if (respuesta.error || respuesta.status === 'error') {
                $btn.prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            $btn.prop('disabled', false); // Rehabilitar por fallo de red
            
            if (status === 'timeout') {
                Swal.fire({ 
                    icon: "warning", 
                    title: "⏱️ Timeout", 
                    html: "<strong>La operación tardó demasiado.</strong>" 
                });
            } else {
                Swal.fire({ icon: "error", title: "Error", text: "No se pudo procesar la solicitud." });
            }
        }
    });
});
function procesarRespuesta(respuesta) {
    $("button[type=button]").prop('disabled', false);
    
    // 1. Verificación de seguridad: ¿Viene el objeto esperado?
    if (respuesta.mensaje === 1 && respuesta.detalles && respuesta.detalles.length > 0) {
        let htmlMsg = "";

        if (respuesta.total_items > 1) {
            htmlMsg = "Los siguientes casos fueron creados exitosamente:<br><br>";
            htmlMsg += '<div style="text-align: left; background: #ffffff; padding: 10px; border: 1px solid #ddd; border-radius: 5px; max-height: 250px; overflow-y: auto; line-height: 1.5;">';
            
            respuesta.detalles.forEach(function(item) {
                htmlMsg += `<p style="margin: 5px 0; font-size: 0.9em;">🚀 <strong>Nº ${item.id}</strong> — ${item.nombre || 'Procesado'}</p>`;
            });
            
            htmlMsg += '</div>';
        } else {
            // Acceso seguro al primer elemento
            let itemUnico = respuesta.detalles[0];
            let nombre = itemUnico.nombre || "Atención";
            htmlMsg = `El caso <strong>Nº ${itemUnico.id}</strong> (${nombre}) ha sido registrado con éxito.`;
        }

        Swal.fire({ 
            icon: "success",
            title: '¡Registro Completado!',
            html: htmlMsg,
            confirmButtonText: 'Continuar',
            confirmButtonColor: '#28a745'
        }).then(() => {
            window.location = "/casos";
        });

    } else {
        // 2. Manejo de errores o respuestas incompletas
        let errorDetalle = respuesta.error || "No se pudieron generar los registros o la respuesta del servidor fue incompleta.";
        Swal.fire({ 
            icon: "error", 
            title: "Atención",
            html: `<strong>${errorDetalle}</strong>` 
        });
    }
}
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

/**
 * Función principal para cargar todos los datos del usuario y sus dependencias.
 * Nota: Asume que las funciones 'calcularEdad', 'obtenerMunicipios' y 'obtenerParroquias'
 * existen y manejan su propia lógica de AJAX/Fetch.
 */
async function cargarDatosUsuario(caso, cedulaNormal) {
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

    // 1. Asignación de valores a Inputs y Selects
    // (Esta parte es síncrona y no requiere cambios)
    $("#nombre-persona").val(datos.nombre);
    $("#apellido-persona").val(datos.apellido);
    $("#cedula-persona").val(datos.cedula);
    $("#telefono").val(datos.telefono);
    $("#correo").val(datos.correo);
    $("#fecha-nacimiento").val(datos.fecha_nacimiento);
    $("#profesion").val(datos.profesion);
    
    if (datos.fecha_nacimiento) {
        // Asegúrate de que 'calcularEdad' exista y funcione
        $("#edad").val(calcularEdad(datos.fecha_nacimiento));
    }

    $("#tipo-persona").val(datos.nacionalidad);
    $("#t-beneficiario").val(datos.beneficiario);
    $("#sexo").val(datos.genero);

    // 2. Selección del Estado y Carga ENCADENADA de Municipios y Parroquias
    
    // Selecciona el Estado primero (no depende de AJAX)
    $("#estado-caso").val(datos.estado); 

    if (!datos.estado) {
        // No hay estado, salimos de la carga dependiente
        return; 
    }

    try {
        // PASO A: Cargar Municipios. Esperamos a que termine.
        const datosMunicipio = { id_estado: datos.estado };
        const responseMunicipios = await obtenerMunicipios(datosMunicipio); // Función simulada/abstracta
        
        // Llenamos y seleccionamos el Municipio
        $("#municipio-caso").html(responseMunicipios.data);
        $("#municipio-caso").val(datos.municipio); 
        
        if (!datos.municipio) {
            // No hay municipio guardado, salimos antes de la siguiente llamada
            return;
        }

        // PASO B: Cargar Parroquias. Esperamos a que termine.
        const datosParroquia = { id_municipio: datos.municipio };
        const responseParroquias = await obtenerParroquias(datosParroquia); // Función simulada/abstracta
        
        // Llenamos y seleccionamos la Parroquia
        $("#parroquia-caso").html(responseParroquias.data);
        $("#parroquia-caso").val(datos.parroquia);

    } catch (error) {
        // Manejo de error único para cualquier paso
        console.error("Error en la carga de dependencias:", error);
        alert("Error: No se pudieron cargar los municipios o parroquias.");
    }
}

// ----------------------------------------------------
// Funciones de ayuda (se deben definir en el código real)
// ----------------------------------------------------

// Ejemplo de cómo podrían verse las funciones de ayuda usando jQuery AJAX:
function obtenerMunicipios(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: { data: btoa(JSON.stringify(data)) },
            success: resolve,
            error: reject,
        });
    });
}

function obtenerParroquias(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/parroquias",
            method: "POST",
            dataType: "JSON",
            data: { data: btoa(JSON.stringify(data)) },
            success: resolve,
            error: reject,
        });
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
    const getElementValue = (id) => $(`#${id}`).val();

    return {
        apoderado_solicitante: {
            aplica: $('#apoderado-solicitante-aplica').is(':checked'), // Agregamos el check
            tipo_apoderado: '1',
            ident_tipo: getElementValue('apo_solicitente-ident-tipo'),
            
            // CAMBIO CLAVE: de 'ci' a 'ident_valor'
            ident_valor: getElementValue('apoderado-solicitante-ci'), 
            
            // CAMBIO CLAVE: de 'nombres' a 'nombre_razon'
            nombre_razon: getElementValue('apoderado-solicitante-nombres'),
            
            impre: getElementValue('apoderado-solicitante-impre'),
            telefono: getElementValue('apoderado-solicitante-telefono'),
            correo: getElementValue('apoderado-solicitante-correo'),
            pais: getElementValue('apoderado-solicitante-pais-select'),
            direccion: getElementValue('apoderado-solicitante-direccion')
        },
        contraparte: {
            nombre_razon: getElementValue('contraparte-nombre-razon'),
            ident_tipo: getElementValue('contraparte-ident-tipo'),
            ident_valor: getElementValue('contraparte-ident-valor'),
            correo: getElementValue('contraparte-correo'),
            telefono: getElementValue('contraparte-telefono'),
            pais: getElementValue('contraparte-pais-select'),
            direccion: getElementValue('contraparte-direccion')
        },
        apoderado_contraparte: {
            aplica: $('#apoderado-contraparte-aplica').is(':checked'), // Agregamos el check
            tipo_apoderado: '2',
            ident_tipo: getElementValue('apo_contraparte-ident-tipo'),
            
            // CAMBIO CLAVE: de 'ci' a 'ident_valor'
            ident_valor: getElementValue('contraparte-apoderado-ci'),
            
            // CAMBIO CLAVE: de 'nombres' a 'nombre_razon'
            nombre_razon: getElementValue('apoderado-contraparte-nombres'),
            
            impre: getElementValue('contraparte-apoderado-impre'),
            telefono: getElementValue('apoderado-contraparte-telefono'),
            correo: getElementValue('apoderado-contraparte-correo'),
            pais: getElementValue('apoderado-contraparte-pais-select'),
            direccion: getElementValue('apoderado-contraparte-direccion')
        },
        controversia: {
            tipo_controversia: $('#tipo-pi').val()
        }
    };
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