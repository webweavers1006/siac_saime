$('#btn_agregar').on('click', function(e) {
    window.location = '/vista_agregar_caso'
});
$(function() {
    Listar_Casos();
    llenar_Tipo_Beneficiarios(Event);
    
});



// =================================================================
// 1. DEFINICIONES DE FUNCIONES AUXILIARES (DEBEN ESTAR AL INICIO)
// =================================================================

/**
 * Habilita o deshabilita todos los campos dentro de una sección de rol.
 * (La función toggleCamposEdicion es la única que debe quedar sin cambios aquí)
 */
function toggleCamposEdicion(prefix, habilitar) {
    const selectorContenido = `#${prefix}-content, #${prefix.replace('-apoderado', '')}-content, #mediacion`;
    const $elementos = $(selectorContenido).find('input, select, textarea, button');

    $elementos.each(function() {
        const $el = $(this);
        const id = $el.attr('id');
        
        // Excluir el campo de búsqueda, el botón de búsqueda Y el checkbox "aplica".
        if (
            (id && id.includes('cedula-existente')) || // Campo de búsqueda
            (id && id.includes('btn_buscar')) ||       // Botón de búsqueda
            (id && id.includes('-aplica'))             // Checkbox "Aplica"
        ) {
            $el.prop('disabled', false); 
            $el.removeClass('campo-solo-lectura');
            return; 
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


/**
 * 🎯 Mapea la Identificación Principal.
 * * Asigna la cédula o RIF buscado al campo de identificación del rol.
 */
function mapearCedulaFormulario(prefix, cedula) {
    let ciFieldId;
    if (prefix === 'contraparte') { ciFieldId = '#contraparte-ident-valor'; } 
    else if (prefix === 'apoderado-solicitante') { ciFieldId = '#apoderado-solicitante-ci'; } 
    else { ciFieldId = '#contraparte-apoderado-ci'; }
    $(ciFieldId).val(cedula);
}


/**
 * 🧹 Restablece Campos de Datos y Ubicación.
 * Elimina el contenido de todos los campos de texto del rol y reinicia los selectores.
 */
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

/**
 * 🗺️ Mapeo Integral de Datos de Tercero.
 * Asigna la información detallada del tercero a los campos e inicia la cascada de ubicación.
 */
function mapearDatosTercero(prefix, data) {
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

    // 2. Mapeo de Ubicación (¡BLOQUE CORREGIDO CON PROMESAS!)
    const pais = data.ter_pais;
    const estado = data.ter_estado;
    const municipio = data.ter_municipio;
    const parroquia = data.ter_parroquia;
    
  
    if (pais) {
        const paisId = `${prefix}-pais-select`;
        const estadoId = `${prefix}-estado-select`;
        const municipioId = `${prefix}-municipio-select`;
        const parroquiaId = `${prefix}-parroquia-select`;
        
        // 1. Cargar País
        llenar_Paises_Multiple(paisId, pais)
        
        // 2. Cargar Estados Y esperar
        .then(() => llenar_Estados_Multiple(estadoId, estado))
        
        // 3. Cargar Municipios (solo si el país es 1 y hay estado)
        .then(() => {
            if (pais == 1 && estado) {
                return llenar_municipios_generico(prefix, estado, municipio);
            } else if (pais != 1) {
                // Manejo de país extranjero: Asume que '336' y '1135' son correctos para no-Venezuela
                 $(`#${municipioId}`).val('336'); 
                 $(`#${parroquiaId}`).val('1135');
                 return Promise.resolve(); 
            }
            return Promise.resolve();
        })
        
        // 4. Cargar Parroquias (solo si hay municipio y país es 1)
        .then(() => {
            if (pais == 1 && municipio) {
                return llenar_parroquias_generico(prefix, municipio, parroquia);
            }
        })
        .catch((error) => {
            console.error(`Error en la cascada de ubicación de Búsqueda para ${prefix}:`, error);
        });
    }
}

// =================================================================
// 2. FUNCIÓN MAESTRA DE BÚSQUEDA (buscar_Tercero_Mediacion)
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

                // 🚨 LIBERAR campos para agregar la información
                toggleCamposEdicion(prefix, true); 
                return;
            }
            
            // 2. Lógica de ENCONTRADO (El tercero SÍ existe en la base de datos)
            
            mapearDatosTercero(prefix, response);
            
            // 🚨 MANTENER BLOQUEADOS los campos (modo solo lectura)
            toggleCamposEdicion(prefix, false); 
            
            if (prefix.includes('apoderado')) {
                $(`#${prefix}-aplica`).prop('checked', true);
                if (typeof toggleApoderado === 'function') {
                    toggleApoderado(prefix); 
                }
            }

            Swal.fire("Éxito", `Datos cargados correctamente.`, "success");
        },
        
        error: function(xhr, status, errorThrown) {
            $boton.prop('disabled', false).text('Buscar'); 
            console.error("Error en la solicitud:", status, errorThrown, xhr);
            Swal.fire("Error", "Ocurrió un error al intentar buscar los datos.", "error");
        }
    });
}


// =================================================================
// 3. INICIALIZACIÓN DEL DOM Y EVENTOS
// =================================================================

$(function() {
    
    // 1. INICIALIZACIÓN DE SELECTORES PARA APODERADO SOLICITANTE
    llenar_Selectores_Iniciales("apoderado-solicitante");

    // 2. INICIALIZACIÓN DE SELECTORES PARA CONTRAPARTE
    llenar_Selectores_Iniciales("contraparte");

    // 3. INICIALIZACIÓN DE SELECTORES PARA APODERADO CONTRAPARTE
    llenar_Selectores_Iniciales("apoderado-contraparte");

    // 🚨 BLOQUEO INICIAL (Modo Solo Lectura)
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


$(document).ready(function() {

    var $editCaseModal = $('#editCase');
    $editCaseModal.on('hidden.bs.modal', function () {
        


        
        // Resetear selectores a su primera opción o la que tenga el atributo 'selected'
        $editCaseModal.find('select').each(function() {
            var $this = $(this);
            // Busca la opción que tiene el atributo 'selected' o selecciona la primera
            var selectedOption = $this.find('option[selected]').val() || $this.find('option:first').val();
            $this.val(selectedOption).trigger('change');
        });

        // 4. Lógica Adicional (Opcional, pero útil para tu caso)
        // Si tienes divs que muestras/ocultas, como 'denuncias', puedes ocultarlos de nuevo:
        $('#denuncias').hide();
        $('#cgr').show(); // Si 'cgr' es la vista por defecto
        
        // También puedes limpiar el mapa si estás usando una librería como Leaflet
        // y necesitas reinicializarlo o limpiar marcadores.
        $('#latitude').val('');
        $('#longitude').val('');
        $('#locationName').val('');
        // *Aquí iría la lógica específica para limpiar el mapa si aplica*
    });
});

//FUNCION PARA LLENAR EL COMBO ORGANISMOS DEL PODER POPULAR 
function llenar_Organismos_PP(e, caso_org_id) {
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
                if (caso_org_id === undefined) {
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
                        if (item.org_id=== caso_org_id) {
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



//Evento para subir archivos
$(document).on("click", "#subir_archivos", (e) => {
    e.preventDefault();
    var archivo = document.getElementById("archivo").files[0]; // Obtiene el archivo seleccionado
    var id_caso = document.getElementById("id_caso_pdf").value;
    var formData = new FormData(); // Crea un objeto FormData
    formData.append("archivo", archivo);
    formData.append("id_caso_pdf", id_caso); // Agrega el archivo al objeto FormData
    $.ajax({
        url: "/upload",
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
                    let idcaso = $('#id_caso').val();
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
/*
 * Función para definir datatable de usuarios:
 */
function Listar_Casos() {
    let rol_usuario = $('#rol_usuario').val();
    let ruta_imagen = rootpath;
    var encabezado = '';
let table = $('#table_casos').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: -1 // La última columna será el expander
            }
        },
        width: '100%',
        autoWidth: false,
        scrollCollapse: true,
        fixedHeader: false,
      
      
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
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
                                fontSize: '18',
                                alignment: 'center',
                                text: 'Control de Casos',
                                fontSize: 18,
                            },
                            {
                                margin: [-600, 80, -25, 0],
                                text: encabezado,
                            }],
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
                },
            },
            {
                extend: "excel",
                text: 'Excel',
                className: 'btn-xs btn-dark',
                title: 'Control de Casos',
                download: 'open',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                },
                excelStyles: {
                    "template": [
                        "blue_medium",
                        "header_blue",
                        "title_medium"
                    ]
                },
            }]
        },
        "order": [[0, "desc"]],
        "paging": true,
        "lengthChange": true,
        dom: 'lfrBtip',
        "searching": true,
        "lengthMenu": [[10, 25, 50, -1], ['10', '25', '50', 'Todos']],
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "serverSide": true,
        "ajax": {
            "url": "/listar_Casos_Usuarios",
            "type": "GET",
           // dataSrc: ''
        },

       
        
        "columns": [
            { data: 'idcaso' },
            { data: 'cedula' },
            { data: 'nombre' },
            { data: 'casotel' },
            { data: 'tipo_prop_nombre' },
            { data: 'tipo_aten_nombre' },
            { data: 'casofec' },
            { data: 'estnom' },
            { data: 'user_name' },
            {
                data: null,
                render: function(data, type, row) {
                    if(rol_usuario==1){
                        return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"    organismo_pp="' + row.organismo_pp + '"  caso_org_id="' + row.caso_org_id + '"   pais="' + row.pais + '"   tipo_atend_borrado="' + row.tipo_atend_borrado + '"   act_pro_int="' + row.act_pro_int + '"   fecha_nacimiento_normal="' + row.fecha_nacimiento_normal + '"  tipo_atend_id="' + row.tipo_atend_id + '"  edad="' + row.edad + '"  fecha_nacimiento="' + row.fecha_nacimiento + '" profesion="' + row.profesion + '"    denu_involucrados="' + row.denu_involucrados + '" denu_monto_aprovado = "' + row.denu_monto_aprovado + '" denu_nombre_proyecto = "' + row.denu_nombre_proyecto + '" denu_ente_financiador ="' + row.denu_ente_financiador + '" denu_rif_instancia = "' + row.denu_rif_instancia + '" denu_instancia_popular = "' + row.denu_instancia_popular + '" denu_fecha_hechos=' + row.denu_fecha_hechos + '  denu_afecta_terceros="' + row.denu_afecta_terceros + '" denu_afecta_comunidad=' + row.denu_afecta_comunidad + ' denu_afecta_persona=' + row.denu_afecta_persona + ' asume_cgr=' + row.asume_cgr + '    competencia_cgr=' + row.competencia_cgr + '  ente_adscrito_id=' + row.ente_adscrito_id + ' correo="' + row.correo + '"  direccion="' + row.direccion + '"  tipo_beneficiario=' + row.tipo_beneficiario + '  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >create</i></a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style=" font-size:1px" data-toggle="tooltip" title="Seguimientos"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons ">search</i> </a>' + '  ' +
                        '<a href="javascript:;" class="btn btn-xs btn-success Remitir" style=" font-size:1px" data-toggle="tooltip" title="Remitir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >redo</i> </a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-dark Imprimir" style=" font-size:1px" data-toggle="tooltip" title="Imprimir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >print</i> </a>' 
                    }else if(rol_usuario==2){
                       return `<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar" organismo_pp="${row.organismo_pp}" tipo_atend_borrado="${row.tipo_atend_borrado}" act_pro_int="${row.act_pro_int}" fecha_nacimiento_normal="${row.fecha_nacimiento_normal}" tipo_atend_id="${row.tipo_atend_id}" edad="${row.edad}" fecha_nacimiento="${row.fecha_nacimiento}" profesion="${row.profesion}" denu_involucrados="${row.denu_involucrados}" denu_monto_aprovado="${row.denu_monto_aprovado}" denu_nombre_proyecto="${row.denu_nombre_proyecto}" denu_ente_financiador="${row.denu_ente_financiador}" denu_rif_instancia="${row.denu_rif_instancia}" denu_instancia_popular="${row.denu_instancia_popular}" denu_fecha_hechos="${row.denu_fecha_hechos}" denu_afecta_terceros="${row.denu_afecta_terceros}" denu_afecta_comunidad="${row.denu_afecta_comunidad}" denu_afecta_persona="${row.denu_afecta_persona}" asume_cgr="${row.asume_cgr}" competencia_cgr="${row.competencia_cgr}" ente_adscrito_id="${row.ente_adscrito_id}" correo="${row.correo}" direccion="${row.direccion}" tipo_beneficiario="${row.tipo_beneficiario}" casoape="${row.casoape}" casonom="${row.casonom}" cedula="${row.casoced}" caso_nacionalidad="${row.caso_nacionalidad}" sexo="${row.sexo}" casotel="${row.casotel}" casofec_normal="${row.casofec_normal}" idrrss="${row.idrrss}" ofiid="${row.ofiid}" estadoid="${row.estadoid}" tipo_prop_id="${row.tipo_prop_id}" id_tipo_atencion="${row.id_tipo_atencion}" casodesc="${row.casodesc}" municipioid="${row.municipioid}" parroquiaid="${row.parroquiaid}" idcaso="${row.idcaso}"><i class="material-icons">create</i></a> <a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style="font-size:1px" data-toggle="tooltip" title="Seguimientos" casoape="${row.casoape}" casonom="${row.casonom}" cedula="${row.casoced}" caso_nacionalidad="${row.caso_nacionalidad}" sexo="${row.sexo}" casotel="${row.casotel}" casofec_normal="${row.casofec_normal}" idrrss="${row.idrrss}" ofiid="${row.ofiid}" estadoid="${row.estadoid}" tipo_prop_id="${row.tipo_prop_id}" id_tipo_atencion="${row.id_tipo_atencion}" casodesc="${row.casodesc}" municipioid="${row.municipioid}" parroquiaid="${row.parroquiaid}" idcaso="${row.idcaso}"><i class="material-icons">search</i></a>`;
                        
                    } else if (rol_usuario == 3) {
                        return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"   caso_org_id="' + row.caso_org_id + '"  organismo_pp="' + row.organismo_pp + '" pais="' + row.pais + '" tipo_atend_borrado="' + row.tipo_atend_borrado + '" tipo_atend_borrado="' + row.tipo_atend_borrado + '" act_pro_int="' + row.act_pro_int + '"  fecha_nacimiento_normal="' + row.fecha_nacimiento_normal + '"  tipo_atend_id="' + row.tipo_atend_id + '"  edad="' + row.edad + '"  fecha_nacimiento="' + row.fecha_nacimiento + '" profesion="' + row.profesion + '"  denu_involucrados="' + row.denu_involucrados + '" denu_monto_aprovado = "' + row.denu_monto_aprovado + '" denu_nombre_proyecto = "' + row.denu_nombre_proyecto + '" denu_ente_financiador ="' + row.denu_ente_financiador + '" denu_rif_instancia = "' + row.denu_rif_instancia + '" denu_instancia_popular = "' + row.denu_instancia_popular + '" denu_fecha_hechos=' + row.denu_fecha_hechos + '  denu_afecta_terceros="' + row.denu_afecta_terceros + '" denu_afecta_comunidad=' + row.denu_afecta_comunidad + ' denu_afecta_persona=' + row.denu_afecta_persona + ' asume_cgr=' + row.asume_cgr + '    competencia_cgr=' + row.competencia_cgr + '  ente_adscrito_id=' + row.ente_adscrito_id + ' correo="' + row.correo + '"  direccion="' + row.direccion + '"  tipo_beneficiario=' + row.tipo_beneficiario + '  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >create</i></a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style=" font-size:1px" data-toggle="tooltip" title="Seguimientos"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >search</i> </a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-dark Imprimir" style=" font-size:1px" data-toggle="tooltip" title="Imprimir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"    tipo_atend_id="' + row.tipo_atend_id + '" cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >print</i> </a>' + ' ' + 
                        '<a href="javascript:;" class="btn btn-xs btn-success Remitir" style=" font-size:1px" data-toggle="tooltip" title="Remitir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >redo</i> </a>';
                    } else if (rol_usuario == 4) {
                        return '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style=" font-size:1px" data-toggle="tooltip" title="Seguimientos"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"  tipo_atend_id="' + row.tipo_atend_id + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >search</i> </a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-dark Imprimir" style=" font-size:1px" data-toggle="tooltip" title="Imprimir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"  tipo_atend_id="' + row.tipo_atend_id + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >print</i> </a>';
                    } else if (rol_usuario == 5) {
                        return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"   caso_org_id="' + row.caso_org_id + '" organismo_pp="' + row.organismo_pp + '" pais="' + row.pais + '" tipo_atend_borrado="' + row.tipo_atend_borrado + '" act_pro_int="' + row.act_pro_int + '"  fecha_nacimiento_normal="' + row.fecha_nacimiento_normal + '"  tipo_atend_id="' + row.tipo_atend_id + '"  edad="' + row.edad + '"  fecha_nacimiento="' + row.fecha_nacimiento + '" profesion="' + row.profesion + '" denu_involucrados="' + row.denu_involucrados + '" denu_monto_aprovado = "' + row.denu_monto_aprovado + '" denu_nombre_proyecto = "' + row.denu_nombre_proyecto + '" denu_ente_financiador ="' + row.denu_ente_financiador + '" denu_rif_instancia = "' + row.denu_rif_instancia + '" denu_instancia_popular = "' + row.denu_instancia_popular + '" denu_fecha_hechos=' + row.denu_fecha_hechos + '  denu_afecta_terceros="' + row.denu_afecta_terceros + '" denu_afecta_comunidad=' + row.denu_afecta_comunidad + ' denu_afecta_persona=' + row.denu_afecta_persona + ' asume_cgr=' + row.asume_cgr + '    competencia_cgr=' + row.competencia_cgr + '  ente_adscrito_id=' + row.ente_adscrito_id + ' correo="' + row.correo + '"  direccion="' + row.direccion + '"  tipo_beneficiario=' + row.tipo_beneficiario + '  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >create</i></a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style=" font-size:1px" data-toggle="tooltip" title="Seguimientos"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons ">search</i> </a>' + '  ' +
                        '<a href="javascript:;" class="btn btn-xs btn-success Remitir" style=" font-size:1px" data-toggle="tooltip" title="Remitir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >redo</i> </a>' +' '+
                        '<a href="javascript:;" class="btn btn-xs btn-dark Imprimir" style=" font-size:1px" data-toggle="tooltip" title="Imprimir"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >print</i> </a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-light Bloquear" style=" font-size:1px" data-toggle="tooltip" title="Bloquear"  casoape="' + row.casoape + '" casonom="' + row.casonom + '"   tipo_atend_id="' + row.tipo_atend_id + '"  cedula="' + row.casoced + '" caso_nacionalidad="' + row.caso_nacionalidad + '" sexo=' + row.sexo + ' casotel="' + row.casotel + '" casofec_normal=' + row.casofec_normal + ' idrrss=' + row.idrrss + ' ofiid=' + row.ofiid + ' estadoid=' + row.estadoid + ' tipo_prop_id=' + row.tipo_prop_id + '  id_tipo_atencion=' + row.id_tipo_atencion + ' casodesc="' + row.casodesc + '" municipioid=' + row.municipioid + ' parroquiaid=' + row.parroquiaid + ' idcaso=' + row.idcaso + '> <i class="material-icons " >delete</i> </a>';
                    }
                }
            }
        ],
        language: {
           // sProcessing: "Procesando...",
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
    table.on('page.dt', function () {
        let info = table.page.info();
        localStorage.setItem('datatable_page', info.page);
    });
    
// Adjust columns after initialization to ensure proper width distribution
    table.columns.adjust();
    
    // Re-adjust columns on window resize
    $(window).on('resize', function() {
        table.columns.adjust();
    });
}

/**
 * Manejador de evento para el expander de filas en móvil
 * Toggle para expandir/contraer la fila y mostrar acciones
 */
$(document).on('click', '.expand-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var btn = $(this);
    var tr = btn.closest('tr');
    var row = table.row(tr);
    var rowId = 'mobile-details-' + row.data().idcaso;
    
    // Toggle the row
    if (row.child.isShown()) {
        // Cerrar - remover la fila de detalles
        row.child.hide();
        tr.removeClass('shown');
        btn.html('<i class="fas fa-plus"></i>');
        btn.removeClass('expanded');
    } else {
        // Abrir - crear y mostrar la fila de detalles
        var acciones = tr.find('.btn-inline-actions').html();
        
        var detallesHtml = `
            <tr class="row-details" id="${rowId}">
                <td colspan="10">
                    <div class="mobile-details">
                        <div class="actions-container btn-inline-actions">
                            ${acciones}
                        </div>
                    </div>
                </td>
            </tr>
        `;
        
        $(detallesHtml).insertAfter(tr);
        tr.addClass('shown');
        btn.html('<i class="fas fa-minus"></i>');
        btn.addClass('expanded');
    }
});

let competencia_cgr = '';
let asume_cgr = '';
let denu_afecta_persona = '';
let denu_afecta_comunidad = '';
let denu_afecta_terceros = '';
let denu_involucrados = '';
let denu_fecha_hechos = '';
let denu_instancia_popular = '';
let denu_rif_instancia = '';
let denu_ente_financiador = '';
let denu_nombre_proyecto = '';
let denu_monto_aprovado = '';

// =========================================================================
// 🔑 CORRECCIÓN GLOBAL PARA EL ERROR COEP/CORS EN ICONOS (AQUÍ DEBE IR)
// =========================================================================
if (L.Icon.Default) {
    // Esto fuerza a Leaflet a pedir las imágenes de sus marcadores (icon.png)
    // usando CORS, resolviendo el bloqueo 'NotSameOriginAfterDefaultedToSameOriginByCoep'.
    L.Icon.Default.prototype.options.crossOrigin = 'anonymous';
}
// =========================================================================
// VARIABLES GLOBALES Y CONFIGURACIÓN INICIAL
// =========================================================================
let map = null;
let currentMarker = null;
const defaultVenezuelaCoords = [10.4806, -66.9036];

// =========================================================================
// FUNCIONES REUTILIZABLES
// =========================================================================

/**
 * Función que actualiza los campos de latitud y longitud.
 */
function updateFormCoords(lat, lon) {
    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lon.toFixed(6);
}

document.getElementById('locationName').addEventListener('input', function() {
    // Limpia los campos de latitud y longitud cuando se empieza a escribir en el campo de nombre.
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
});

/**
 * Función central para manejar la visualización del mapa.
 */
function handleMapDisplay(shouldShow, coords = null, name = 'Ubicación') {
    if (shouldShow) {
        // ⭐ PASO 1: Muestra el contenedor del mapa.
        $(".mapa_ayuda").show();

        if (map) {
            map.remove();
            map = null;
        }

        const mapCoords = coords || defaultVenezuelaCoords;
        const initialName = name || 'Ubicación';

        // ⭐ PASO 2: Inicializa el mapa.
        map = L.map('map').setView(mapCoords, 13);
        L.tileLayer('https://tile.openstreetmap.de/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
         crossOrigin: true 
        }).addTo(map);

        currentMarker = L.marker(mapCoords, { draggable: true }).addTo(map);
        currentMarker.bindPopup(`<b>${initialName}</b><br>Latitud: ${mapCoords[0].toFixed(6)}<br>Longitud: ${mapCoords[1].toFixed(6)}`);

        updateFormCoords(mapCoords[0], mapCoords[1]);
        if (name) {
            document.getElementById('locationName').value = initialName;
        }

        // ⭐ PASO 3: Llama a invalidateSize con un pequeño retraso
        // para asegurarte de que el mapa se redimensione correctamente
        // una vez que el div sea visible.
        setTimeout(() => {
            if (map) {
                map.invalidateSize();
            }
        }, 100);

        setupMapEvents();
    } else {
        $(".mapa_ayuda").hide();
        if (map) {
            map.remove();
            map = null;
        }
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('locationName').value = '';
    }
}

/**
 * Función que contiene todos los eventos del mapa, para evitar duplicación de código.
 */
function setupMapEvents() {
   currentMarker.on('dragend', function() {
        var newLatLng = currentMarker.getLatLng();
        updateFormCoords(newLatLng.lat, newLatLng.lng);

        var reverseGeocodeUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLatLng.lat}&lon=${newLatLng.lng}`;
        
        fetch(reverseGeocodeUrl)
            .then(response => response.json())
            .then(data => {
                var foundName = data.display_name || 'Ubicación seleccionada';
                document.getElementById('locationName').value = foundName;
                var newPopupContent = `<b>${foundName}</b><br>Latitud: ${newLatLng.lat.toFixed(6)}<br>Longitud: ${newLatLng.lng.toFixed(6)}`;
                currentMarker.setPopupContent(newPopupContent).openPopup();
            })
            .catch(error => {
                console.error('Error en la búsqueda inversa:', error);
                var newPopupContent = `<b>Ubicación seleccionada</b><br>Latitud: ${newLatLng.lat.toFixed(6)}<br>Longitud: ${newLatLng.lng.toFixed(6)}`;
                currentMarker.setPopupContent(newPopupContent).openPopup();
                document.getElementById('locationName').value = 'No se encontró nombre';
            });
    });

    document.getElementById('ubicar-btn').addEventListener('click', function() {
        var lat = parseFloat(document.getElementById('latitude').value);
        var lon = parseFloat(document.getElementById('longitude').value);
        var name = document.getElementById('locationName').value;

        if (name.trim() !== '' && (isNaN(lat) || isNaN(lon))) {
            var url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=ve&q=${encodeURIComponent(name)}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var foundLat = parseFloat(data[0].lat);
                        var foundLon = parseFloat(data[0].lon);
                        var foundName = data[0].display_name;
                        
                        updateMarker(foundLat, foundLon, foundName);
                    } else {
                        alert('No se encontraron resultados para "' + name + '".');
                    }
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    alert('Ocurrió un error al buscar el lugar.');
                });
        } else if (!isNaN(lat) && !isNaN(lon)) {
            var displayName = name && name.trim() !== '' ? name : 'Ubicación seleccionada';
            updateMarker(lat, lon, displayName);
        } else {
            alert('Por favor, ingresa al menos un nombre o coordenadas para ubicar.');
        }
    });

    document.getElementById('limpiar-btn').addEventListener('click', function() {
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        document.getElementById('locationName').value = '';
        if (currentMarker) {
            currentMarker.setLatLng(defaultVenezuelaCoords);
            map.setView(defaultVenezuelaCoords, 13);
        }
    });
}

/**
 * Función para centralizar la actualización del marcador, los campos y el mapa.
 */
function updateMarker(lat, lon, name) {
    if (currentMarker) {
        currentMarker.setLatLng([lat, lon]);
        currentMarker.setPopupContent(`<b>${name}</b><br>Latitud: ${lat.toFixed(6)}<br>Longitud: ${lon.toFixed(6)}`).openPopup();
    }
    updateFormCoords(lat, lon);
    document.getElementById('locationName').value = name;
    if (map) {
        map.setView([lat, lon], 12);
    }
}
//METODO PARA ABRIR EL MODAL PARA LA   EDICION DEL CASO
$('#listar_casos').on('click', '.Editar', function(e) {
    e.preventDefault();

  
    let idrol=$('#id_rol').val();
    // valore anteriores para luego comparar
    let nombre = $(this).attr('casonom');
    let paisid = $(this).attr('pais');
    let caso_org_id = $(this).attr('caso_org_id');
    let acc_org_pp = $(this).attr('organismo_pp');


    if (paisid !=1) 
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
    let act_pro_int = $(this).attr('act_pro_int');
    let nombre_anterior = nombre
    let apellido = $(this).attr('casoape');
    let apellido_anterior = apellido
    let cedula = $(this).attr('cedula');
    let tipo_atend_id = $(this).attr('tipo_atend_id');


   
    let tipo_atend_borrado = $(this).attr('tipo_atend_borrado');
    let cedula_anterior = cedula
    let edad = $(this).attr('edad');
    let fecha_nacimiento = $(this).attr('fecha_nacimiento');
    let fecha_nacimiento_normal = $(this).attr('fecha_nacimiento_normal');
    let profesion = $(this).attr('profesion');

    $('#editCase').find('#fecha-nacimiento').val(fecha_nacimiento_normal);
    $('#editCase').find('#edad').val(edad);
    $('#editCase').find('#profesion').val(profesion);
    $('#editCase').find('#id_hijos_detalle_atencion').val(tipo_atend_id);
    let hijos_detalle_atencion = $('#id_hijos_detalle_atencion').val().trim();
    let nacionalidad = $(this).attr('caso_nacionalidad');
    let nacionalidad_anterior = nacionalidad
    if (nacionalidad_anterior === 'E') {
        $('#editCase').find('#tipo_persona_anterior').val('E - Extranjero');
    } else if (nacionalidad_anterior === 'V') {
        $('#editCase').find('#tipo_persona_anterior').val('V - Venezolano');
    } else if (nacionalidad_anterior === 'J') {
        $('#editCase').find('#tipo_persona_anterior').val('J - Juridico');
    } else if (nacionalidad_anterior === 'G') {
        $('#editCase').find('#tipo_persona_anterior').val('G - Gobierno');
    }

    let sexo = $(this).attr('sexo');

    if (sexo == 'F') {
        $('#editCase').find('#genero_anterior').val('Femenino');
    } else {
        $('#editCase').find('#genero_anterior').val('Masculino');
    }
    let casotel = $(this).attr('casotel');
    let casotel_anterior = casotel
    let casofec_normal = $(this).attr('casofec_normal');
    let casofec_normal_anterior = casofec_normal
    let idrrss = $(this).attr('idrrss');
    let ofiid = $(this).attr('ofiid');
    if (ofiid == '1') {
        $('#editCase').find('#ofiid_anterior').val('Sala situacional');
    } else {
        $('#editCase').find('#ofiid_anterior').val('Coordinacion Regional');
    }
    let estadoid = $(this).attr('estadoid');
    let tipo_prop_id = $(this).attr('tipo_prop_id');
   
    let tipo_prop_id_anterior = tipo_prop_id
    let id_tipo_atencion = $(this).attr('id_tipo_atencion');
  
    let id_tipo_atencion_anterior = id_tipo_atencion
    let casodesc= $(this).attr('casodesc');
    // casodesc=(unescape(casodesc));

    //const casodesc = casodesc_normal.replace(/ÃÂ/g, "í").replace(/ÃÂ­/g, "í").replace(/ÃÂ³/g, "ó").replace(/ÃÂ¡/g, "á");
   // alert(casodesc);



    let casodesc_anterior = casodesc
    casodesc = casodesc.trim();
    casodesc_anterior = casodesc_anterior.trim();
    let municipioid = $(this).attr('municipioid');
    let municipioid_anterior = municipioid
    let parroquiaid = $(this).attr('parroquiaid');
    let parroquiaid_anterior = parroquiaid
    let idcaso = $(this).attr('idcaso');
    let tipo_beneficiario = $(this).attr('tipo_beneficiario');
   
    if (tipo_beneficiario == '1') {
        $('#editCase').find('#t_beneficiario_anterior').val('Usuario');
    } else {
        $('#editCase').find('#t_beneficiario_anterior').val('Emprendedor');
    }
    let tipo_beneficiario_anterior = tipo_beneficiario
    let direccion = $(this).attr('direccion');
    let direccion_anterior = direccion
    let correo = $(this).attr('correo');
    let correo_anterior = correo
    //let ente_adscrito_id = $(this).attr('ente_adscrito_id');
    let ente_adscrito_id_anterior = 0;
   // let competencia_cgr = $(this).attr('competencia_cgr');
    let competencia_cgr = 2;
    if (competencia_cgr == '1') {
        $('#editCase').find('#cgr_anterior').val('Si');
    } else {
        $('#editCase').find('#cgr_anterior').val('No');
    }
    //let asume_cgr = $(this).attr('asume_cgr');
    let asume_cgr = 2;
    if (asume_cgr == '1') {
        $('#editCase').find('#azume_anterior').val('Si');
    } else {
        $('#editCase').find('#azume_anterior').val('No');
    }
    let denu_afecta_terceros = $(this).attr('denu_afecta_terceros');
    let denu_afecta_comunidad = $(this).attr('denu_afecta_comunidad');
    let denu_afecta_persona = $(this).attr('denu_afecta_persona');
    if (denu_afecta_persona == 't') {
        $('#editCase').find('#afecta_hechos_anterior').val('option-personal');
    } else if (denu_afecta_comunidad == 't') {
        $('#editCase').find('#afecta_hechos_anterior').val('option-comunidad');
    } else if (denu_afecta_terceros == 't') {
        $('#editCase').find('#afecta_hechos_anterior').val('option-terceros');
    } else {
        $('#editCase').find('#afecta_hechos_anterior').val(' ');
    }
    let denu_involucrados = $(this).attr('denu_involucrados');
    if (denu_involucrados == 'null') {
        denu_involucrados = ' '
    }
    denu_involucrados_anterior = denu_involucrados.trim();
    $('#editCase').find('#involucrados_anterior').val(denu_involucrados_anterior);
    let denu_fecha_hechos = $(this).attr('denu_fecha_hechos');
    let denu_fecha_hechos_anterior = denu_fecha_hechos

    let denu_instancia_popular = $(this).attr('denu_instancia_popular');
    let denu_instancia_popular_anterior = denu_instancia_popular.trim();
    if (denu_instancia_popular_anterior == 'null') {
        denu_instancia_popular_anterior = ' '
    }
    $('#nombre_instancia_anterior').val(denu_instancia_popular_anterior);
    let denu_rif_instancia = $(this).attr('denu_rif_instancia');
    let denu_rif_instancia_anterior = denu_rif_instancia.trim();
    if (denu_rif_instancia_anterior == 'null') {
        denu_rif_instancia_anterior = ' '
    }

    $('#rif_instancia_anterior').val(denu_rif_instancia_anterior);

    let denu_ente_financiador = $(this).attr('denu_ente_financiador');
    let denu_ente_financiador_anterior = denu_ente_financiador.trim();
    if (denu_ente_financiador_anterior == 'null') {
        denu_ente_financiador_anterior = ' '
    }
    $('#ente_financiador_anterior').val(denu_ente_financiador_anterior);

    let denu_nombre_proyecto = $(this).attr('denu_nombre_proyecto');
    let denu_nombre_proyecto_anterior = denu_nombre_proyecto.trim();
    if (denu_nombre_proyecto_anterior == 'null') {
        denu_nombre_proyecto_anterior = ' '
    }
    $('#nombre_proyecto_anterior').val(denu_nombre_proyecto_anterior);

    let denu_monto_aprovado = $(this).attr('denu_monto_aprovado');
    let denu_monto_aprovado_anterior = denu_monto_aprovado.trim();
    if (denu_monto_aprovado_anterior == 'null') {
        denu_monto_aprovado_anterior = ' '
    }
    $('#monto_aprobado_anterior').val(denu_monto_aprovado_anterior);

    if (direccion == 'null') {
        direccion = ' '
    }
    if (correo == 'null') {
        correo = ' '
    }

    tipo_prop_id_anterior
    if (denu_fecha_hechos == 'null') {
        denu_fecha_hechos = ' '
    }


    ////////
    if (denu_nombre_proyecto == 'null') {
        denu_nombre_proyecto = ' '
    }
    if (denu_ente_financiador == 'null') {
        denu_ente_financiador = ' '
    }
    if (denu_instancia_popular == 'null') {
        denu_instancia_popular = ' '
    }
    if (denu_rif_instancia == 'null') {
        denu_rif_instancia = ' '
    }
    if (denu_monto_aprovado == 'null') {
        denu_monto_aprovado = ' '
    }
    if (direccion_anterior == 'null') {
        direccion_anterior = ''
    }
    if (correo_anterior == 'null') {
        correo_anterior = ''
    }
    if (denu_ente_financiador_anterior == 'null') {
        denu_ente_financiador_anterior = ''
    }
    if (denu_involucrados_anterior == 'null') {
        denu_involucrados_anterior = ''
    }
    if (denu_fecha_hechos_anterior == 'null') {
        denu_fecha_hechos_anterior = ''
    }

    if (denu_rif_instancia_anterior == 'null') {
        denu_rif_instancia_anterior = ''
    }

    if (denu_monto_aprovado_anterior == 'null') {
        denu_monto_aprovado_anterior = ''
    }
    ///LLENO LA PERSIANA DE LOS DOCUMENTOS ASOCIADOS A UN CASO 
    id = undefined;
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
    /////////////////////////////////////////////////////////
 // Variable global para almacenar los datos agrupados, accesible desde otros ámbitos
let datosAgrupadosPorPunto = {};
/**
 * Función que realiza la llamada AJAX para verificar el caso y obtener los puntos de cuenta asociados,
 * y luego llena el selector principal.
 * @param {string} idcaso - El ID del caso a verificar.
 */
cargarPuntosDeCuenta(idcaso);
   




    if (id_tipo_atencion == 1)
    {
        $("#denuncias").hide();
        $("#mediacion").hide();


        if (act_pro_int=='t') 
            {
                $(".prop_int").show();
                document.getElementById("tipo-pi").disabled = false;
                $("#cgr").hide();
                
            }else
            {
                $(".prop_int").hide();
                $("#cgr").hide();
            }
            if (hijos_detalle_atencion !== null && hijos_detalle_atencion !== 'null' && tipo_atend_borrado=='f')
                {
                    hijos_detalle_atencion=='SI';
                    $(".detalle_atencion").css("display", "show");
                } else 
                {
                    hijos_detalle_atencion=='NO';
                    $(".detalle_atencion").css("display", "none");
                }



                if (acc_org_pp=='t') 
                    {
                        $(".org_pp").show();
                        document.getElementById("organismo-caso").disabled = false;
                        $("#cgr").hide();
                        
                    }else
                    {
                        $(".org_pp").hide();
                        $("#cgr").hide();
                    }
                
       

    }


    
    else  if (id_tipo_atencion == 5)
    {
       

        if (act_pro_int=='t') 
            {
              
                $(".prop_int").show();
                document.getElementById("tipo-pi").disabled = false;
                
            }else
            {
                $("#mediacion").hide(); 
                $(".prop_int").hide();
                $("#denuncias").show();
                $("#cgr").hide();
            }

            if (acc_org_pp=='t') 
                {
                    $(".org_pp").show();
                    document.getElementById("organismo-caso").disabled = false;
                    $("#cgr").hide();
                    
                }else
                {
                    $(".org_pp").hide();
                    $("#cgr").hide();
                }
           
            if (hijos_detalle_atencion !== null && hijos_detalle_atencion !== 'null'&& tipo_atend_borrado=='f')
                {
                    hijos_detalle_atencion=='SI';
                    $(".detalle_atencion").css("display", "show");
                } else 
                {
                    hijos_detalle_atencion=='NO';
                    $(".detalle_atencion").css("display", "none");
                }


               
            
     
    } 
     
    else if (id_tipo_atencion == 23)
{
    // 1. Mostrar la sección de Mediación y ocultar otras
    $("#denuncias").hide();
    $("#cgr").hide();
    $("#mediacion").show(); 
    
    // METODO QUE BUSCA Y CARGA LA INFORMACIÓN DEL CASO DE MEDIACIÓN
    // Este método maneja el bloqueo inicial de campos de datos.
    loadDatosMediacion(idcaso);

    // 2. Lógica para Propiedad Intelectual (act_pro_int)
    if (act_pro_int == 't') 
    {
        $(".prop_int").show();
        // Nota: document.getElementById.disabled = false ya no es necesario
        // si la sección está bloqueada, pero se mantiene si es un control específico.
        document.getElementById("tipo-pi").disabled = false;
        $("#cgr").hide();
        
    } else {
        $(".prop_int").hide();
        $("#denuncias").hide();
        $("#cgr").hide();
    }
    
    // 3. Lógica para Detalle de Atención (hijos_detalle_atencion)
    // 🚨 CORRECCIÓN CLAVE: La doble asignación (hijos_detalle_atencion=='SI') estaba mal.
    if (hijos_detalle_atencion !== null && hijos_detalle_atencion !== 'null' && tipo_atend_borrado == 'f')
    {
        // Se asume que necesitas mostrar la sección si se cumplen las condiciones
        // La asignación debe ser con un solo = si quieres cambiar el valor de la variable.
        // hijos_detalle_atencion = 'SI'; // Descomentar si realmente necesitas cambiar la variable
        $(".detalle_atencion").show();
    } else {
        // hijos_detalle_atencion = 'NO'; // Descomentar si realmente necesitas cambiar la variable
        $(".detalle_atencion").hide();
    }


    // 4. Lógica para Organismos PP (acc_org_pp)
    if (acc_org_pp == 't') 
    {
        $(".org_pp").show();
        document.getElementById("organismo-caso").disabled = false;
        $("#cgr").hide();
        
    } else {
        $(".org_pp").hide();
        $("#cgr").hide();
    }
}

    else
    {
      

        if (act_pro_int=='t') 
            {
           
                $(".prop_int").show();
                document.getElementById("tipo-pi").disabled = false;    
            }
        else
            {
                $(".prop_int").hide();
                
            }

            if (acc_org_pp=='t') 
                {
                    $(".org_pp").show();
                    document.getElementById("organismo-caso").disabled = false;
                    $("#cgr").hide();
                    
                }else
                {
                    $(".org_pp").hide();
                    $("#cgr").hide();
                }


            $("#denuncias").hide();
            $("#cgr").hide();  

        
            if (hijos_detalle_atencion !== null && hijos_detalle_atencion !== 'null'&& tipo_atend_borrado=='f')
           {
               hijos_detalle_atencion=='SI';
               $(".detalle_atencion").css("display", "show");
           } else 
           {
               hijos_detalle_atencion=='NO';
               $(".detalle_atencion").css("display", "none");
           }
           
           
    }

   
    ///////
    loadCaseData(idcaso, id_tipo_atencion);
/**
 * Función para cargar los datos del caso al presionar el botón de edición.
 * @param {number} idcaso El ID del caso a editar.
 * @param {number} id_tipo_atencion El ID del tipo de atención del caso.
 */
function loadCaseData(idcaso, id_tipo_atencion) {
    $.ajax({
        url: "/buscar_caso_cordenada/" + idcaso,
        method: "get",
        dataType: "JSON",
    })
    .then((response) => {
        if (response && response.length > 0) {
            // Hay coordenadas guardadas - ahora verificar si el tipo de atención permite coordenadas
            verificarCoordenadasYObtenerMapa(idcaso, id_tipo_atencion, response[0]);
        } else {
            // No hay coordenadas guardadas - verificar si el tipo de atención permite coordenadas
            verificarCoordenadasYObtenerMapa(idcaso, id_tipo_atencion, null);
        }
    })
    .catch(() => {
        // En caso de error, intentar mostrar mapa según el tipo de atención
        verificarCoordenadasYObtenerMapa(idcaso, id_tipo_atencion, null);
    });
}

/**
 * Función auxiliar para verificar si el tipo de atención permite coordenadas
 * y mostrar el mapa con valores correspondientes.
 * @param {number} idcaso El ID del caso.
 * @param {number} id_tipo_atencion El ID del tipo de atención.
 * @param {object|null} coordenadasData Datos de coordenadas guardadas (si existen).
 */
function verificarCoordenadasYObtenerMapa(idcaso, id_tipo_atencion, coordenadasData) {
    $.ajax({
        url: `/Listar_Tipo_Atencion_act_coordenadas/${id_tipo_atencion}`,
        method: 'GET',
        dataType: 'json',
    })
    .done((resp) => {
        const tipoAtencion = resp[0];
        if (tipoAtencion && tipoAtencion.act_coordenadas === 't') {
            // El tipo de atención permite coordenadas - mostrar mapa
            $(".coordenadas").show();
            $("#actcoordenadas").val('t');
            
            if (coordenadasData) {
                // Hay coordenadas guardadas - mostrarlas en el mapa
                const initialCoords = [parseFloat(coordenadasData.latitud), parseFloat(coordenadasData.longitud)];
                const initialName = coordenadasData.nombre;
                console.log("Coordenadas encontradas. Mostrando ubicación guardada.");
                handleMapDisplay(true, initialCoords, initialName);
            } else {
                // No hay coordenadas guardadas - mostrar mapa con valores por defecto
                console.log("No se encontraron coordenadas guardadas. Tipo de atención permite coordenadas. Mostrando mapa para que el usuario pueda agregar las coordenadas.");
                handleMapDisplay(true, defaultVenezuelaCoords, 'Nueva ubicación');
            }
        } else {
            // El tipo de atención no permite coordenadas - ocultar mapa
            console.log("El tipo de atención no permite coordenadas. El mapa permanece oculto.");
            handleMapDisplay(false);
        }
    })
    .fail((xhr, status, error) => {
        console.error("Error al verificar si el tipo de atención permite coordenadas:", error);
        // En caso de error, ocultamos el mapa por precaución
        handleMapDisplay(false);
    });
}





    $("#editCase").modal("show");
    $('#editCase').find('#id_caso_pdf').val(idcaso);
    $('#editCase').find('#nombre-persona').val(nombre);
    $('#editCase').find('#apellido-persona').val(apellido);
    $('#editCase').find('#cedula-persona').val(cedula);
    $('#editCase').find('#tipo-persona').val(nacionalidad);
    $('#editCase').find('#requerimiento-usuario').val(casodesc);
    $('#editCase').find('#id_caso').val(idcaso);
    if (sexo == 'M') {
        $('#editCase').find('#sexo').val('1');
    } else {
        $('#editCase').find('#sexo').val('2');
    }
    $('#editCase').find('#telefono').val(casotel);
    $('#editCase').find('#fecha-recibido').val(casofec_normal);
    $('#editCase').find('#red-social').val(idrrss);
    $('#editCase').find('#t-beneficiario').val(tipo_beneficiario);
    $('#editCase').find('#direccion').val(direccion);
    $('#editCase').find('#correo').val(correo);
    $('#editCase').find('#tipo_atend_borrado').val(tipo_atend_borrado);
    $('#editCase').find('#ente_adscrito_id').val(ente_adscrito_id);
    $('#editCase').find('#denu-involucrados').val(denu_involucrados);
    $('#editCase').find('#fecha-hechos').val(denu_fecha_hechos);
    $('#editCase').find('#nombre-instancia').val(denu_instancia_popular);
    $('#editCase').find('#rif-instancia').val(denu_rif_instancia);
    $('#editCase').find('#ente-financiador').val(denu_ente_financiador);
    $('#editCase').find('#nombre-proyecto').val(denu_nombre_proyecto);
    $('#editCase').find('#monto-aprovado').val(denu_monto_aprovado);
    // capos para comparar
    $('#editCase').find('#nombre_anterior').val(nombre_anterior);
    $('#editCase').find('#apellido_anterior').val(apellido_anterior);
    $('#editCase').find('#direccion_anterior').val(direccion_anterior);
    $('#editCase').find('#correo_anterior').val(correo_anterior);
    $('#editCase').find('#fecha_anterior').val(casofec_normal_anterior);
    $('#editCase').find('#cedula_anterior').val(cedula_anterior);
    $('#editCase').find('#telefono_anterior').val(casotel_anterior);
    $('#editCase').find('#descripcion_anterior').val(casodesc_anterior);
    $('#editCase').find('#fecha_hechos_anterior').val(denu_fecha_hechos_anterior);
    if (competencia_cgr == 'null') {
        competencia_cgr = 0
    }
    if (asume_cgr == 'null') {
        asume_cgr = 0
    }
    if (denu_afecta_persona == 'null') {
        denu_afecta_persona = 'f'
    }
    if (denu_afecta_comunidad == 'null') {
        denu_afecta_comunidad = 'f'
    }
    if (denu_afecta_terceros == 'null') {
        denu_afecta_terceros = 'f'
    }
    if (denu_afecta_persona == 't') {
        $('#option-personal').attr('checked', 'checked');
        $('#option-personal').val('true');
    } else {
        $('#option-personal').removeAttr('checked')
        $('#option-personal').val('false')
    }
    if (denu_afecta_comunidad == 't') {
        $('#option-comunidad').attr('checked', 'checked');
        $('#option-comunidad').val('true');
    } else {
        $('#option-comunidad').removeAttr('checked')
        $('#option-comunidad').val('false')
    }
    if (denu_afecta_terceros == 't') {
        $('#option-terceros').attr('checked', 'checked');
        $('#option-terceros').val('true');
    } else {
        $('#option-terceros').removeAttr('checked')
        $('#option-terceros').val('false')
    }
    $('#editCase').find('#competencia-cgr').val(competencia_cgr);
    $('#editCase').find('#asume-cgr').val(asume_cgr);
    if (ofiid == '1') {
        $('#editCase').find('#office').val('1');
    } else {
        $('#editCase').find('#office').val('2');
    }

/**
 * Función para manejar valores nulos/vacíos en campos de texto, 
 * devolviendo 'N/A' o el valor predeterminado si el valor es falsy.
 * @param {string} value El valor a revisar (del JSON).
 * @returns {string} El valor saneado o 'N/A'.
 */
const safeValue = (value) => {
    // Convierte a String, elimina espacios y verifica si está vacío, nulo o cero
    if (value === null || value === undefined || String(value).trim() === "" || value === 0 || value === '0') {
        return 'N/A';
    }
    return String(value).trim();
};


/**
 * Función para cargar los datos del caso al presionar el botón de edición (Modo Visualización/Bloqueado).
 * * Configura todos los campos de datos en modo "solo lectura" pero deja libres los campos de búsqueda
 * y los checkboxes para permitir la edición o la búsqueda de nuevos terceros.
 * * @param {number} idcaso El ID del caso a editar.
 */
function loadDatosMediacion(idcaso) {
    $.ajax({
        url: "/buscar_Info_Mediacion/" + idcaso,
        method: "get",
        dataType: "JSON",
    })
    .then((response) => {
        if (!response || response.length === 0) {
            return Swal.fire("Advertencia", "No se encontraron datos de mediación para este caso.", "warning");
        }
        
        const data = response[0];
        
        // Estructura de mapeo centralizada de roles (UTILIZANDO LOS ID NUMÉRICOS DE SU JSON)
        const roles = [
            {
                prefix: 'apoderado-solicitante', 
                dataId: data.med_apo_sol_id, 
                nombre: data.nombre_apo_sol, 
                ci: data.id_apo_sol, 
                tipo_per: data.tipo_per_apo_sol,
                correo: data.correo_apo_sol, 
                telefono: data.telefono_apo_sol, 
                pais: data.pais_id_apo_sol, 
                estado: data.estado_id_apo_sol,
                municipio: data.municipio_id_apo_sol, 
                parroquia: data.parroquia_id_apo_sol, 
                direccion: data.direccion_apo_sol, 
                impre_abogado: data.impre_abogado_apo_sol,
                id_nombre: '#apoderado-solicitante-nombres', 
                id_ci: '#apoderado-solicitante-ci', 
                id_tipo_per: '#apo_solicitente-ident-tipo', 
                id_impre: '#apoderado-solicitante-impre',
            },
            {
                prefix: 'contraparte', 
                dataId: data.med_contra_id, 
                nombre: data.nombre_contra, 
                ci: data.id_contra, 
                tipo_per: data.tipo_per_contra,
                correo: data.correo_contra, 
                telefono: data.telefono_contra, 
                pais: data.pais_id_contra, 
                estado: data.estado_id_contra,
                municipio: data.municipio_id_contra, 
                parroquia: data.parroquia_id_contra, 
                direccion: data.direccion_contra, 
                impre_abogado: data.impre_abogado_contra,
                id_nombre: '#contraparte-nombre-razon', 
                id_ci: '#contraparte-ident-valor', 
                id_tipo_per: '#contraparte-ident-tipo', 
                id_impre: '',
            },
            {
                prefix: 'apoderado-contraparte', 
                dataId: data.med_apo_contra_id, 
                nombre: data.nombre_apo_contra, 
                ci: data.id_apo_contra, 
                tipo_per: data.tipo_per_apo_contra,
                correo: data.correo_apo_contra, 
                telefono: data.telefono_apo_contra, 
                pais: data.pais_id_apo_contra, 
                estado: data.estado_id_apo_contra,
                municipio: data.municipio_id_apo_contra, 
                parroquia: data.parroquia_id_apo_contra,
                direccion: data.direccion_apo_contra,
                impre_abogado: data.impre_abogado_apo_contra, 
                id_nombre: '#apoderado-contraparte-nombres', 
                id_ci: '#contraparte-apoderado-ci',
                id_tipo_per: '#apo_contraparte-ident-tipo', 
                id_impre: '#contraparte-apoderado-impre',
            }
        ];

        // Iterar sobre cada rol y mapear sus campos
        roles.forEach(rol => {
            const { 
                prefix, dataId, nombre, ci, tipo_per, correo, telefono, 
                pais, estado, municipio, parroquia, direccion, impre_abogado,
                id_nombre, id_ci, id_tipo_per, id_impre
            } = rol;
            
            const isApoderado = prefix.includes('apoderado');

            // 1. Manejo de Checkbox y Visibilidad
            if (isApoderado) {
                const aplica = dataId && dataId != 0;
                $(`#${prefix}-aplica`).prop('checked', aplica);
                if (typeof toggleApoderado === 'function') {
                    toggleApoderado(prefix); 
                }
            }

            // 2. Mapeo de campos de texto y selectores sencillos (APLICANDO safeValue)
            $(id_nombre).val(safeValue(nombre));
            $(id_ci).val(safeValue(ci));
            $(id_tipo_per).val(tipo_per || 'V');
            $(`#${prefix}-telefono`).val(safeValue(telefono));
            $(`#${prefix}-correo`).val(safeValue(correo));
            $(`#${prefix}-direccion`).val(safeValue(direccion));
            
            if (id_impre) {
                 $(id_impre).val(safeValue(impre_abogado));
            }

            // 3. Mapeo de Ubicación Asíncrona (CASCADA CORREGIDA Y MANEJO DE NULOS EN UBICACIÓN)
            
            // Convertimos los IDs a string y tratamos "null" o 0 como null para la lógica
            const paisId = (pais && pais != 0 && pais != '0') ? String(pais) : null;
            const estadoId = (estado && estado != 0 && estado != '0') ? String(estado) : null;
            const municipioId = (municipio && municipio != 0 && municipio != '0') ? String(municipio) : null;
            const parroquiaId = (parroquia && parroquia != 0 && parroquia != '0') ? String(parroquia) : null;

            if (paisId) {
                // Si existe ID de país, inicia la cascada
                llenar_Paises_Multiple(`${prefix}-pais-select`, paisId)
                
                // Cargar Estados Y esperar
                .then(() => llenar_Estados_Multiple(`${prefix}-estado-select`, estadoId))
                
                // Cargar Municipios (solo si hay estado)
                .then(() => {
                    if (estadoId) {
                        return llenar_municipios_generico(prefix, estadoId, municipioId);
                    }
                    return Promise.resolve();
                })
                
                // Cargar Parroquias (solo si hay municipio)
                .then(() => {
                    if (municipioId) {
                        return llenar_parroquias_generico(prefix, municipioId, parroquiaId);
                    }
                })
                .catch((error) => {
                    console.error(`Error en la cascada de ubicación para ${prefix}:`, error);
                });
            } else {
                // SI NO HAY PAÍS (null/0), establecer todos los selectores en "0" (Seleccione/N/A)
                // Se asume que la opción con value="0" es el placeholder "Seleccione"
                $(`#${prefix}-pais-select`).val('0');
                $(`#${prefix}-estado-select`).val('0');
                $(`#${prefix}-municipio-select`).val('0');
                $(`#${prefix}-parroquia-select`).val('0');
            }
        });
        
        // 🚨 CONFIGURACIÓN DE BLOQUEO (Modo Solo Lectura)
        
        // 1. Deshabilitar y aplicar estilo campo-solo-lectura a TODOS los campos de datos y botones que no son de búsqueda
        $("#mediacion").find('input, select, textarea').prop('disabled', true).addClass('campo-solo-lectura');
        $("#mediacion").find('button:not([id^="btn_buscar"])').prop('disabled', true).addClass('campo-solo-lectura');
        
        // 2. 🔓 LIBERACIÓN DE ELEMENTOS CLAVE DE INTERACCIÓN Y BÚSQUEDA
        
        // Liberar Checkboxes (Aplica)
        $("#mediacion").find('input[type="checkbox"]').prop('disabled', false).removeClass('campo-solo-lectura');
        
        // Liberar Campos de Cédula de Búsqueda
        $("#mediacion").find('input[id^="cedula-existente"]').each(function() {
            $(this).prop('disabled', false).removeClass('campo-solo-lectura');
        });

        // Liberar Botones de Búsqueda
        $("#mediacion").find('button[id^="btn_buscar"]').each(function() {
             $(this).prop('disabled', false).removeClass('campo-solo-lectura');
             $(this).text('Buscar');
        });

        // Mostrar el modal
        $('#editCase').modal('show'); 
    })
    .catch((error) => {
        console.error("Error en la solicitud AJAX general:", error);
        Swal.fire("Error", "Error al cargar los datos de la mediación. Revise la consola para más detalles.", "error");
    });
}
    llenar_pais(Event,paisid);
    llenar_Red_social(Event, idrrss);
    llenar_Estados(Event, estadoid)
    llenar_Organismos_PP(Event,caso_org_id);
    llenar_municipios(Event, estadoid, municipioid);
    llenar_parroquias(Event, municipioid, parroquiaid);
    llenar_Propiedad_Intelectual(Event, tipo_prop_id);
    //llenar_Tipo_Atencion(Event, id_tipo_atencion);
    llenar_Tipo_Atencion_filtros(Event,idrrss,id_tipo_atencion);   
    llenar_Entes_asdcritos(Event, ente_adscrito_id);
    llenar_detalle_atencion(Event,id_tipo_atencion,tipo_atend_id);
   document.getElementById("edit_detelle_atencion").disabled = false;
})

$("#tipo-atencion-usu").on('change', function(e) {
    document.getElementById("edit_detelle_atencion").disabled = false;
    let id_tipo_atencion = $('#tipo-atencion-usu option:selected').val();
    let act_pro_int = $(this).find('option:selected').data('act-pro-int');
    let tipo_atend_id = $('#id_hijos_detalle_atencion').val();
    let hijos_detalle_atencion;

    if (act_pro_int == 't') {
        $(".prop_int").show();
        document.getElementById("tipo-pi").disabled = false;
    } else {
        $(".prop_int").hide();
    }
   
   

    if (id_tipo_atencion == 5) {
        $("#cgr").hide();
        $("#mediacion").hide();
        $("#denuncias").show();
    } else if (id_tipo_atencion == 1) {
        $("#denuncias").hide();
        $("#mediacion").hide();
        $("#cgr").hide();
    } else if (id_tipo_atencion == 23) {
        $("#denuncias").hide();
        $("#mediacion").show();
        $("#cgr").hide();
    }
    
    else {
        $("#cgr").hide();
        $("#denuncias").hide();
         $("#mediacion").hide();
    }

    $.ajax({
        url: `/Listar_Tipo_Atencion_act_coordenadas/${id_tipo_atencion}`,
        method: 'GET',
        dataType: 'json',
    })
    .done((response) => {
        const tipoAtencion = response[0];
        if (tipoAtencion && tipoAtencion.act_coordenadas === 't') {
            handleMapDisplay(true);
            $("#actcoordenadas").val('t');
        } else {
            handleMapDisplay(false);
            $("#actcoordenadas").val('f');
        }
    })
    .fail((xhr, status, error) => {
        let errorMessage = 'Error al cargar datos.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        Swal.fire('Error', errorMessage, 'error');
        handleMapDisplay(false);
    });

    llenar_detalle_atencion(e, id_tipo_atencion,tipo_atend_id);
});


//METODO PARA ABRIR EL MODAL PARA LA   EDICION DEL CASO
$('#listar_casos').on('click', '.Imprimir', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('idcaso');

    window.open('generar_pdf/' + idcaso, '_blank');
    // window.location = '/generar_pdf/' + idcaso, '_blank'
});


// Evento para abrir documentos del caso (delegación de eventos para elementos dinámicos)
$(document).on('change', '#docu-casos', function() {
    var url = $(this).val();
    console.log('URL seleccionada:', url);
    // Verificar que el valor no sea vacío, null, 0 o "Seleccione"
    if (url && url !== '' && url !== '0' && url.toLowerCase() !== 'seleccione') {
        var ruta = 'documentos_casos/' + url;
        console.log('Abriendo documento:', ruta);
        window.open(ruta, "_blank");
    } else {
        console.log('Valor no válido para abrir documento');
    }
});

var selectElement = document.getElementById('documentos-select');
selectElement.addEventListener('change', function() {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var url = selectedOption.value;
    if (url && url !== '0') {
        var ruta = 'documentos_punto_cuenta/' + url;
        window.open(ruta, "_blank");
    }
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
//FUNCION PARA LLENAR EL COMBO DE LAS REDES SOCIALES
function llenar_Red_social(e, idrrss) {
    e.preventDefault;
    url = "/listar_Red_Social";
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
                if (idrrss === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#red-social").append("<option value=" + item.red_s_id + ">" + item.red_s_nom + "</option>");
                    });

                } else {
                    $.each(data, function(i, item) {
                        if (item.red_s_id === idrrss) {
                            $("#red-social").append("<option value=" + item.red_s_id + " selected>" + item.red_s_nom + "</option>");
                            $('#via_atencion_anterior').val(item.red_s_nom);
                        } else {
                            $("#red-social").append("<option value=" + item.red_s_id + ">" + item.red_s_nom + "</option>");
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
function llenar_Propiedad_Intelectual(e, tipo_prop_id) {
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
                if (tipo_prop_id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#tipo-pi").append(
                            "<option vallistar_Parroquiasue=" +
                            item.tipo_prop_id +
                            ">" +
                            item.tipo_prop_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.tipo_prop_id === tipo_prop_id) {
                            $("#tipo-pi").append(
                                "<option value=" +
                                item.tipo_prop_id +
                                " selected>" +
                                item.tipo_prop_nombre +
                                "</option>"
                            );
                            $('#Tipo_prop_anterior').val(item.tipo_prop_nombre);

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
                $("#ente_adscrito_id").empty();
                $("#ente_adscrito_id").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (ente_adscrito_id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#ente_adscrito_id").append(
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
                            $("#ente_adscrito_id").append(
                                "<option value=" +
                                item.ente_id +
                                " selected>" +
                                item.ente_nombre +
                                "</option>"
                            );
                            $('#ente_anterior').val(item.ente_nombre);
                        } else {
                            $("#ente_adscrito_id").append(
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
//Evento que busca los municipios por estados
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
                        Swal.fire("Error", response.JSONmessage, "Error");
                    });
            }
        })
        .catch((request) => {
            Swal.fire("Error", response.JSONmessage, "Error");
        });
});
//Evento que busca las parroquias por municipio
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
            Swal.fire("Error", response.JSONmessage, "Error");
        });
});
//Evento de envio del formulario
$(document).on("click", "#editar_caso", function(e) {
    e.preventDefault();
 
    let tipo_prop_intelec = $("#tipo-pi").val();
    let tipo_atencion = $("#tipo-atencion-usu").val();
    let requerimiento_user = $("#requerimiento-usuario").val();
    let red_social = $("#red-social").val();
    let estado = $("#estado-caso").val();
    let tipo_beneficiario = $("#t-beneficiario").val();
    let sexo = $("#sexo").val();
    let ente_adscrito_id = $("#ente_adscrito_id").val();
    let caso_org_id = $("#organismo-caso").val();
   

    let idcaso = $("#idcaso").val();
    requerimiento_user = requerimiento_user.trim();
    if (red_social == null) {
        $("#red-social").addClass('is-invalid');
        Swal.fire({
            icon: "success",
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
            icon: "success",
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
            icon: "success",
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
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INDICAR LA DESCRIPCION DEL CASO .</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    } else {
        $("#red-social").removeClass('is-invalid');
        $("#estado-caso").removeClass('is-invalid');
        $("#tipo-pi").removeClass('is-invalid');
        $("#tipo-atencion-usu").removeClass('is-invalid');
        $("#requerimiento-usuario").removeClass('is-invalid');
        if (document.getElementById('option-personal').checked) {
            denu_afecta_persona = true
        } else {
            denu_afecta_persona = false
        }
        if (document.getElementById('option-comunidad').checked) {
            denu_afecta_comunidad = true
        } else {
            denu_afecta_comunidad = false
        }
        if (document.getElementById('option-terceros').checked) {
            denu_afecta_terceros = true
        } else {
            denu_afecta_terceros = false
        }
        let fecha_hechos = $('#fecha-hechos').val();
        let competencia = $('#competencia-cgr').val(2);
        let asume = $('#asume-cgr').val(2);
        let tipo_atencion = $("#tipo-atencion-usu").val();
        let ente_adscrito = $("#ente_adscrito_id").val(0);
        let involucrados = $("#denu-involucrados").val();
        //PREGUNTO SI ES UN CASO DE ASESORIA 
        if (tipo_atencion == 1) 
        {

            if (tipo_prop_intelec == null) 
            {
                $("#estado-caso").removeClass('is-invalid');
                $("#tipo-pi").addClass('is-invalid');
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3500,
                });
            }    
            else{
            
                /// Coloco los datos del formulario en objeto_anterior para comparlo con los datos modificados en objeto_actual 
                /// OBJETO ANTERIOR
                var objeto_anterior = {
                    "Nombre": $('#nombre_anterior').val(),
                    "Apellido": $('#apellido_anterior').val(),
                    "Direccion": $('#direccion_anterior').val(),
                    "Correo": $('#correo_anterior').val(),
                    "Cedula": $('#cedula_anterior').val(),
                    "Telefono": $('#telefono_anterior').val(),
                    "CasoDescripcion": $('#descripcion_anterior').val(),
                    "FechaRecibo": $('#fecha_anterior').val(),
                    "Genero": $('#genero_anterior').val(),
                    "ViaAtencion": $('#via_atencion_anterior').val(),
                    "AtencionCuidadano": $('#ofiid_anterior').val(),
                    "TipoPersona": $('#tipo_persona_anterior ').val(),
                    "TipoBeneficiario": $('#t_beneficiario_anterior ').val(),
                    "Estado": $('#estado_anterior ').val(),
                    "Municipio": $('#municipio_anterior').val(),
                    "Parroquia": $('#parroquia_anterior ').val(),
                    "TipoPropiedad": $('#Tipo_prop_anterior ').val(),
                    "TipoAtencion": $('#Tipo_antenc_anterior ').val(),
                   // "EnteAsdcrito": $('#ente_anterior').val(),
                    "EnteAsdcrito":0,
                   // "CompetenciaCgr": $('#cgr_anterior').val(),
                   "CompetenciaCgr": 2,
                    //"AzumeCgr": $('#azume_anterior').val(),
                    "AzumeCgr": 2,

                }
                //OBJETO ACTUAL 
            var objeto_actual = {

                "Nombre": $('#nombre-persona').val(),
                "Apellido": $('#apellido-persona').val(),
                "Direccion": $("#direccion").val(),
                "Correo": $("#correo").val(),
                "Cedula": $("#cedula-persona").val(),
                "Telefono": $("#telefono").val(),
                "CasoDescripcion": $("#requerimiento-usuario").val(),
                "FechaRecibo": $('#fecha-recibido').val(),
                "Genero": $('#sexo option:selected').text(),
                "ViaAtencion": $('#red-social option:selected').text(),
                "AtencionCuidadano": $('#office option:selected').text(),
                "TipoPersona": $('#tipo-persona option:selected').text(),
                "TipoBeneficiario": $('#t-beneficiario option:selected').text(),
                "Estado": $('#estado-caso option:selected').text(),
                "Municipio": $('#municipio-caso option:selected').text(),
                "Parroquia": $('#parroquia-caso option:selected').text(),
                "TipoPropiedad": $('#tipo-pi option:selected').text(),
                "TipoAtencion": $('#tipo-atencion-usu option:selected').text(),
                // "EnteAsdcrito": $('#ente_adscrito_id option:selected').text(),
                // "CompetenciaCgr": $('#competencia-cgr option:selected').text(),
                // "AzumeCgr": $('#asume-cgr option:selected').text(),
                "EnteAsdcrito": 0,
                "CompetenciaCgr":2,
                "AzumeCgr": 2,

            }
            var camposModificados = [];
            for (var propiedad in objeto_anterior) {
                if (objeto_anterior.hasOwnProperty(propiedad)) {
                    if (objeto_anterior[propiedad] !== objeto_actual[propiedad]) {
                        camposModificados.push({
                            propiedad: propiedad,
                            valorAnterior: objeto_anterior[propiedad],
                            valorNuevo: objeto_actual[propiedad]
                        });
                    }
                }
            }
            if (camposModificados.length > 0) {
                var datos_modificados = camposModificados.map(function(campo) {
                    campo.valorAnterior = campo.valorAnterior.trim();
                    return campo.valorAnterior === '' ?
                        `Ingreso el Valor de ${campo.propiedad} = ${campo.valorNuevo}` :
                        `El campo: ${campo.propiedad} = ${campo.valorAnterior} fue modificado a: ${campo.valorNuevo}`;
                }).join(", ");

            }


            if (datos_modificados == undefined) {
                alert('NO HA REALIZADO NINGUNA MODIFICACION');

            } else {


                let datos = {
                    "social_network": $("#red-social").val(),
                    "date-entry": $("#fecha-recibido").val(),
                    "person-name": $("#nombre-persona").val(),
                    "person-lastname": $("#apellido-persona").val(),
                    "person-id": $("#cedula-persona").val(),
                    "nacionalidad": $("#tipo-persona").val(),
                    "telephone": $("#telefono").val(),
                    "country": $("#pais-caso").val(),
                    "state": $("#estado-caso").val(),
                    "county": $("#municipio-caso").val(),
                    "town": $("#parroquia-caso").val(),
                    "record-work": $("#num-tramite").val(),
                    "pi-type": $("#tipo-pi").val(),
                    "user-requirement": $("#requerimiento-usuario").val(),
                    "office": $("#office").val(),
                    "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                    "sexo": $("#sexo").val(),
                    "idcaso": $("#id_caso").val(),
                    "tipo_beneficiario": $("#t-beneficiario").val(),
                    "direccion": $("#direccion").val(),
                    "correo": $("#correo").val(),
                    "ente_adscrito_id": ente_adscrito_id,
                    "competencia_cgr": $("#competencia-cgr").val(),
                    "asume_cgr": $("#asume-cgr").val(),
                    "denu_afecta_persona": denu_afecta_persona,
                    "denu_afecta_comunidad": denu_afecta_comunidad,
                    "denu_afecta_terceros": denu_afecta_terceros,
                    "denu_involucrados": $('#denu-involucrados').val(),
                    "denu_fecha_hechos": $('#fecha-hechos').val(),
                    "denu_instancia_popular": $('#nombre-instancia').val(),
                    "tipo_atend_id": $("#edit_detelle_atencion").val(),
                    "denu_rif_instancia": $('#rif-instancia').val(),
                    "denu_ente_financiador": $('#ente-financiador').val(),
                    "denu_nombre_proyecto": $('#nombre-proyecto').val(),
                    "denu_monto_aprovado": $('#monto-aprovado').val(),
                    "nombre_instancia": $('#monto-aprovado').val(),
                    "ente_adscrito_id": ente_adscrito_id,
                    "campos_modificados": datos_modificados,
                    "caso_org_id": caso_org_id,
                    "edad": $("#edad").val(),
                    "fecha_nacimiento": $("#fecha-nacimiento").val(),
                    "profesion": $("#profesion").val(),
                  
                }
                $.ajax({
                    url: "/actualizarCaso",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        "data": btoa(JSON.stringify(datos))
                    },
                    beforeSend: function() {
                        //$("button[type=submit]").attr('disabled', 'true');
                    },
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire({
                                icon: "success",
                                type: 'success',
                                text: 'REGISTRO ACTUALIZADO',
                                icon: 'success',
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'my-toast-container',
                                    title: 'my-toast-title',
                                    content: 'my-toast-content',
                                    progress: 'my-toast-progress',
                                },
                                padding: '1rem',
                                iconHtml: '<i class="fas fa-check-circle"></i>'
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1400);

                        } else if (data == 2) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        }
                    }
                });

            }


            }


           
            
            //PREGUNTO SI ES UN CASO DE DENUNCIA
        } else if (tipo_atencion == 5)
         {

            if (denu_afecta_persona == false && denu_afecta_comunidad == false && denu_afecta_terceros == false) {
                alert('DEBE INDICAR A QUIEN AFECTA EL HECHO');
            } else if (fecha_hechos == '') {
                alert('Debe Indicar la Fecha en que ocurrieron los Hechos');
                $("#fecha-hechos").addClass('is-invalid');
                $("#competencia-cgr").removeClass('is-invalid');
            } else if (involucrados == ' ') {
                alert('Debe Indicar los Involucrados en los Hechos');
                $("#denu-involucrados").addClass('is-invalid');
                $("#fecha-hechos").removeClass('is-invalid');
            } else {
                $("#denu-involucrados").removeClass('is-invalid');
                let tipo_prop_intelec = $("#tipo-pi").val();

             
                if (tipo_prop_intelec !=null && tipo_prop_intelec !='null') 
                {
                    prop_intelectual= $("#tipo-pi").val();
                }
                else
                {
                    prop_intelectual = 1
    
                }

                /// Coloco los datos del formulario en objeto_anterior para comparlo con los datos modificados en objeto_actual 
                /// OBJETO ANTERIOR
                var objeto_anterior = {
                    "Nombre": $('#nombre_anterior').val(),
                    "Apellido": $('#apellido_anterior').val(),
                    "Direccion": $('#direccion_anterior').val(),
                    "Correo": $('#correo_anterior').val(),
                    "Cedula": $('#cedula_anterior').val(),
                    "Telefono": $('#telefono_anterior').val(),
                    "CasoDescripcion": $('#descripcion_anterior').val(),
                    "FechaRecibo": $('#fecha_anterior').val(),
                    "Genero": $('#genero_anterior').val(),
                    "ViaAtencion": $('#via_atencion_anterior').val(),
                    "Atencion": $('#ofiid_anterior').val(),
                    "TipoPersona": $('#tipo_persona_anterior ').val(),
                    "TipoBeneficiario": $('#t_beneficiario_anterior ').val(),
                    "Estado": $('#estado_anterior ').val(),
                    "Municipio": $('#municipio_anterior').val(),
                    "Parroquia": $('#parroquia_anterior ').val(),
                    "TipoPropiedad": $('#Tipo_prop_anterior ').val(),
                    "TipoAtencion": $('#Tipo_antenc_anterior ').val(),
                    "Afectados": $('#afecta_hechos_anterior').val(),
                    "FechaHechos": $('#fecha_hechos_anterior').val(),
                    "Involucrados": $('#involucrados_anterior').val(),
                    "NombreInstancia": $('#nombre_instancia_anterior').val(),
                    "RifInstancia": $('#rif_instancia_anterior').val(),
                    "EnteFinanciador": $('#ente_financiador_anterior').val(),
                    "NombreProyecto": $('#nombre_proyecto_anterior').val(),
                    "MontoAprobado": $('#monto_aprobado_anterior').val(),
                }

                /// OBJETO ACTUAL
                let Afecta_hechos_actual;
                obtenerSeleccion();

                function obtenerSeleccion() {
                    var opciones = document.getElementsByName("option");
                    for (var i = 0; i < opciones.length; i++) {
                        if (opciones[i].checked) {
                            var opcionSeleccionada = opciones[i].id;
                            Afecta_hechos_actual = (opcionSeleccionada);
                            break;
                        }
                    }
                }
                let denu_involucrados_actual = $('#denu-involucrados').val();
                denu_involucrados_actual = denu_involucrados_actual.trim();
                var objeto_actual = {
                    "Nombre": $('#nombre-persona').val(),
                    "Apellido": $('#apellido-persona').val(),
                    "Direccion": $("#direccion").val(),
                    "Correo": $("#correo").val(),
                    "Cedula": $("#cedula-persona").val(),
                    "Telefono": $("#telefono").val(),
                    "CasoDescripcion": $("#requerimiento-usuario").val(),
                    "FechaRecibo": $('#fecha-recibido').val(),
                    "Genero": $('#sexo option:selected').text(),
                    "ViaAtencion": $('#red-social option:selected').text(),
                    "Atencion": $('#office option:selected').text(),
                    "TipoPersona": $('#tipo-persona option:selected').text(),
                    "TipoBeneficiario": $('#t-beneficiario option:selected').text(),
                    "Estado": $('#estado-caso option:selected').text(),
                    "Municipio": $('#municipio-caso option:selected').text(),
                    "Parroquia": $('#parroquia-caso option:selected').text(),
                    "TipoPropiedad": $('#tipo-pi option:selected').text(),
                    "TipoAtencion": $('#tipo-atencion-usu option:selected').text(),
                    "Afectados": Afecta_hechos_actual,
                    "FechaHechos": $('#fecha-hechos').val(),
                    "Involucrados": denu_involucrados_actual,
                    "NombreInstancia": $('#nombre-instancia').val(),
                    "RifInstancia": $('#rif-instancia').val(),
                    "EnteFinanciador": $('#ente-financiador').val(),
                    "NombreProyecto": $('#nombre-proyecto').val(),
                    "MontoAprobado": $('#monto-aprovado').val(),

                }

                var camposModificados = [];
                for (var propiedad in objeto_anterior) {
                    if (objeto_anterior.hasOwnProperty(propiedad)) {
                        if (objeto_anterior[propiedad] !== objeto_actual[propiedad]) {
                            camposModificados.push({
                                propiedad: propiedad,
                                valorAnterior: objeto_anterior[propiedad],
                                valorNuevo: objeto_actual[propiedad]
                            });
                        }
                    }
                }
                if (camposModificados.length > 0) {
                    var datos_modificados = camposModificados.map(function(campo) {
                        let string_anterior = campo.valorAnterior;
                        let patron = /option-/;
                        if (patron.test(string_anterior)) {
                            campo.valorAnterior = string_anterior.replace(patron, "");
                        }
                        let string_Actual = campo.valorNuevo;
                        let patron_Actual = /option-/;
                        if (patron.test(string_Actual)) {
                            campo.valorNuevo = string_Actual.replace(patron, "");
                        }
                        campo.valorAnterior = campo.valorAnterior.trim();

                        return campo.valorAnterior === '' ?
                            `Ingreso el Valor de ${campo.propiedad} = ${campo.valorNuevo}` :
                            `El campo: ${campo.propiedad} = ${campo.valorAnterior} fue modificado a: ${campo.valorNuevo}`;
                    }).join(", ");

                }
                if (datos_modificados == undefined) {
                    alert('NO HA REALIZADO NINGUNA MODIFICACION');

                } else {


                    let datos = {
                        "social_network": $("#red-social").val(),
                        "date-entry": $("#fecha-recibido").val(),
                        "person-name": $("#nombre-persona").val(),
                        "person-lastname": $("#apellido-persona").val(),
                        "person-id": $("#cedula-persona").val(),
                        "nacionalidad": $("#tipo-persona").val(),
                        "telephone": $("#telefono").val(),
                        "country": $("#pais-caso").val(),
                        "state": $("#estado-caso").val(),
                        "county": $("#municipio-caso").val(),
                        "town": $("#parroquia-caso").val(),
                        "tipo_atend_id": $("#edit_detelle_atencion").val(),
                        "record-work": $("#num-tramite").val(),
                        "pi-type": prop_intelectual,
                        "user-requirement": $("#requerimiento-usuario").val(),
                        "office": $("#office").val(),
                        "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                        "sexo": $("#sexo").val(),
                        "idcaso": $("#id_caso").val(),
                        "tipo_beneficiario": $("#t-beneficiario").val(),
                        "direccion": $("#direccion").val(),
                        "correo": $("#correo").val(),
                        "ente_adscrito_id": ente_adscrito_id,
                        "competencia_cgr": $("#competencia-cgr").val(),
                        "asume_cgr": $("#asume-cgr").val(),
                        "denu_afecta_persona": denu_afecta_persona,
                        "denu_afecta_comunidad": denu_afecta_comunidad,
                        "denu_afecta_terceros": denu_afecta_terceros,
                        "denu_involucrados": $('#denu-involucrados').val(),
                        "denu_fecha_hechos": $('#fecha-hechos').val(),
                        "denu_instancia_popular": $('#nombre-instancia').val(),
                        "denu_rif_instancia": $('#rif-instancia').val(),
                        "denu_ente_financiador": $('#ente-financiador').val(),
                        "denu_nombre_proyecto": $('#nombre-proyecto').val(),
                        "denu_monto_aprovado": $('#monto-aprovado').val(),
                        "nombre_instancia": $('#monto-aprovado').val(),
                        "ente_adscrito_id": ente_adscrito_id,
                        "campos_modificados": datos_modificados,
                        "edad": $("#edad").val(),
                        "caso_org_id": caso_org_id,
                        "fecha_nacimiento": $("#fecha-nacimiento").val(),
                        "profesion": $("#profesion").val(),
                    }



                    $.ajax({
                        url: "/actualizarCaso",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            "data": btoa(JSON.stringify(datos))
                        },
                        beforeSend: function() {
                            //$("button[type=submit]").attr('disabled', 'true');
                        },
                        success: function(data) {

                            if (data == 1) {
                                Swal.fire({
                                    icon: "success",
                                    type: 'success',
                                    text: 'REGISTRO ACTUALIZADO',
                                    icon: 'success',
                                    toast: true,
                                    position: 'center',
                                    showConfirmButton: false,
                                    timer: 8000,
                                    timerProgressBar: true,
                                    customClass: {
                                        container: 'my-toast-container',
                                        title: 'my-toast-title',
                                        content: 'my-toast-content',
                                        progress: 'my-toast-progress',
                                    },
                                    padding: '1rem',
                                    iconHtml: '<i class="fas fa-check-circle"></i>'
                                });
                                setTimeout(function() {
                                    window.location = "/casos";
                                }, 1400);

                            } else if (data == 2) {
                                Swal.fire({
                                    icon: "error",
                                    type: 'error',
                                    html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                    timer: 3500,
                                });
                            }
                        }
                    });


                }
            }
            
        }   // SI ES UN CASO DE MEDIACION ENTRA AQUI
         else if (tipo_atencion === '23') 

         {
         
           
        
            const datos_medicion = obtenerDatosMediacion();

                
                let bandera_cgr = false;
                let bandera_denuncia = false;
                let valor_competencia = ''; 
                let ente_adscrito = 0
                let valor_asume = ''; 

             
                let tipo_atend_id = ''; 
               
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
                "person-id": $("#cedula-persona").val(),
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
                "tipo_atend_id": $("#edit_detelle_atencion").val(),
                "sexo": $("#sexo").val(),
                "idcaso": $("#id_caso").val(),
                "tipo_beneficiario": $("#t-beneficiario").val(),
                "direccion": $("#direccion").val(),
                "correo": $("#correo").val(),
                "ente_adscrito_id": ente_adscrito_id,
                "competencia_cgr": $("#competencia-cgr").val(),
                "asume_cgr": $("#asume-cgr").val(),
                "denu_afecta_persona": denu_afecta_persona,
                "denu_afecta_comunidad": denu_afecta_comunidad,
                "denu_afecta_terceros": denu_afecta_terceros,
                "denu_involucrados": $('#denu-involucrados').val(),
                "denu_fecha_hechos": $('#fecha-hechos').val(),
                "denu_instancia_popular": $('#nombre-instancia').val(),
                "denu_rif_instancia": $('#rif-instancia').val(),
                "denu_ente_financiador": $('#ente-financiador').val(),
                "denu_nombre_proyecto": $('#nombre-proyecto').val(),
                "denu_monto_aprovado": $('#monto-aprovado').val(),
                "nombre_instancia": $('#monto-aprovado').val(),
                "ente_adscrito_id": ente_adscrito_id,
                "campos_modificados": datos_modificados,
                "edad": $("#edad").val(),
                "caso_org_id": caso_org_id,
                "fecha_nacimiento": $("#fecha-nacimiento").val(),
                "profesion": $("#profesion").val(),
                "act_coordenadas": $("#actcoordenadas").val(),
                "latitud": $("#latitude").val(),
                "longitud": $("#longitude").val(),
                "nombre": $("#locationName").val(),
                };

                // --- Llamada AJAX ---
                $.ajax({
                    url: "/actualizarCaso",
                    method: "POST",
                    dataType: "JSON",
                    // **CORRECCIÓN 5: Se asegura de que el botón se habilite correctamente.**
                    data: {
                        "data": btoa(JSON.stringify(datos))
                    },
                    beforeSend: function() {
                        // Opcional: Deshabilitar el botón aquí para evitar envíos múltiples.
                    },
                    success: function(data) {

                        if (data == 1) {
                            Swal.fire({
                                icon: "success",
                                type: 'success',
                                text: 'REGISTRO ACTUALIZADO',
                                icon: 'success',
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'my-toast-container',
                                    title: 'my-toast-title',
                                    content: 'my-toast-content',
                                    progress: 'my-toast-progress',
                                },
                                padding: '1rem',
                                iconHtml: '<i class="fas fa-check-circle"></i>'
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1400);

                        } else if (data == 2) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        }
                    }
                });

        
         

         }




        //********************ES UN CASO NORMAL ***********
        else {
            //let datos_modificados = '';
            /// Coloco los datos del formulario en objeto_anterior para comparlo con los datos modificados en objeto_actual 
            /// OBJETO ANTERIOR
            let tipo_prop_intelec = $("#tipo-pi").val();

             
            if (tipo_prop_intelec !=null && tipo_prop_intelec !='null') 
            {
                prop_intelectual= $("#tipo-pi").val();
            }
            else
            {
                prop_intelectual = 1

            }

            var objeto_anterior = {
                    "Nombre": $('#nombre_anterior').val(),
                    "Apellido": $('#apellido_anterior').val(),
                    "Direccion": $('#direccion_anterior').val(),
                    "Correo": $('#correo_anterior').val(),
                    "Cedula": $('#cedula_anterior').val(),
                    "Telefono": $('#telefono_anterior').val(),
                    "CasoDescripcion": $('#descripcion_anterior').val(),
                    "FechaRecibo": $('#fecha_anterior').val(),
                    "Genero": $('#genero_anterior').val(),
                    "ViaAtencion": $('#via_atencion_anterior').val(),
                    "Atencion": $('#ofiid_anterior').val(),
                    "TipoPersona": $('#tipo_persona_anterior ').val(),
                    "TipoBeneficiario": $('#t_beneficiario_anterior ').val(),
                    "Estado": $('#estado_anterior ').val(),
                    "Municipio": $('#municipio_anterior').val(),
                    "Parroquia": $('#parroquia_anterior ').val(),
                    "TipoPropiedad": $('#Tipo_prop_anterior ').val(),
                    "TipoAtencion": $('#Tipo_antenc_anterior ').val(),
                }
                //OBJETO ACTUAL
            var objeto_actual = {

                "Nombre": $('#nombre-persona').val(),
                "Apellido": $('#apellido-persona').val(),
                "Direccion": $("#direccion").val(),
                "Correo": $("#correo").val(),
                "Cedula": $("#cedula-persona").val(),
                "Telefono": $("#telefono").val(),
                "CasoDescripcion": $("#requerimiento-usuario").val(),
                "FechaRecibo": $('#fecha-recibido').val(),
                "Genero": $('#sexo option:selected').text(),
                "ViaAtencion": $('#red-social option:selected').text(),
                "Atencion": $('#office option:selected').text(),
                "TipoPersona": $('#tipo-persona option:selected').text(),
                "TipoBeneficiario": $('#t-beneficiario option:selected').text(),
                "Estado": $('#estado-caso option:selected').text(),
                "Municipio": $('#municipio-caso option:selected').text(),
                "Parroquia": $('#parroquia-caso option:selected').text(),
                "TipoPropiedad": $('#tipo-pi option:selected').text(),
                "TipoAtencion": $('#tipo-atencion-usu option:selected').text(),
            }
            var camposModificados = [];
            for (var propiedad in objeto_anterior) {
                if (objeto_anterior.hasOwnProperty(propiedad)) {
                    if (objeto_anterior[propiedad] !== objeto_actual[propiedad]) {
                        camposModificados.push({
                            propiedad: propiedad,
                            valorAnterior: objeto_anterior[propiedad],
                            valorNuevo: objeto_actual[propiedad]
                        });
                    }
                }
            }
            if (camposModificados.length > 0) {
                var datos_modificados = camposModificados.map(function(campo) {
                    campo.valorAnterior = campo.valorAnterior.trim();
                    return campo.valorAnterior === '' ?
                        `Ingreso el Valor de ${campo.propiedad} = ${campo.valorNuevo}` :
                        `El campo: ${campo.propiedad} = ${campo.valorAnterior} fue modificado a: ${campo.valorNuevo}`;
                }).join(", ");

            }


            let datos = {
                "social_network": $("#red-social").val(),
                "date-entry": $("#fecha-recibido").val(),
                "person-name": $("#nombre-persona").val(),
                "person-lastname": $("#apellido-persona").val(),
                "person-id": $("#cedula-persona").val(),
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
                "tipo_atend_id": $("#edit_detelle_atencion").val(),
                "sexo": $("#sexo").val(),
                "idcaso": $("#id_caso").val(),
                "tipo_beneficiario": $("#t-beneficiario").val(),
                "direccion": $("#direccion").val(),
                "correo": $("#correo").val(),
                "ente_adscrito_id": ente_adscrito_id,
                "competencia_cgr": $("#competencia-cgr").val(),
                "asume_cgr": $("#asume-cgr").val(),
                "denu_afecta_persona": denu_afecta_persona,
                "denu_afecta_comunidad": denu_afecta_comunidad,
                "denu_afecta_terceros": denu_afecta_terceros,
                "denu_involucrados": $('#denu-involucrados').val(),
                "denu_fecha_hechos": $('#fecha-hechos').val(),
                "denu_instancia_popular": $('#nombre-instancia').val(),
                "denu_rif_instancia": $('#rif-instancia').val(),
                "denu_ente_financiador": $('#ente-financiador').val(),
                "denu_nombre_proyecto": $('#nombre-proyecto').val(),
                "denu_monto_aprovado": $('#monto-aprovado').val(),
                "nombre_instancia": $('#monto-aprovado').val(),
                "ente_adscrito_id": ente_adscrito_id,
                "campos_modificados": datos_modificados,
                "edad": $("#edad").val(),
                "caso_org_id": caso_org_id,
                "fecha_nacimiento": $("#fecha-nacimiento").val(),
                "profesion": $("#profesion").val(),
                "act_coordenadas": $("#actcoordenadas").val(),
                "latitud": $("#latitude").val(),
                "longitud": $("#longitude").val(),
                "nombre": $("#locationName").val(),
            }


            if (datos_modificados == undefined) {
                alert('NO HA REALIZADO NINGUNA MODIFICACION');

            } else {
                $.ajax({
                    url: "/actualizarCaso",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        "data": btoa(JSON.stringify(datos))
                    },
                    beforeSend: function() {
                        //$("button[type=submit]").attr('disabled', 'true');
                    },
                    success: function(data) {

                        if (data == 1) {
                            Swal.fire({
                                icon: "success",
                                type: 'success',
                                text: 'REGISTRO ACTUALIZADO',
                                icon: 'success',
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 8000,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'my-toast-container',
                                    title: 'my-toast-title',
                                    content: 'my-toast-content',
                                    progress: 'my-toast-progress',
                                },
                                padding: '1rem',
                                iconHtml: '<i class="fas fa-check-circle"></i>'
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1400);

                        } else if (data == 2) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        }
                    }
                });
            }


        }
    }

});

//METODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
$('#listar_casos').on('click', '.Seguimientos', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('idcaso');
    let rol_usuario=$('#rol_usuario').val();
   

    //********SEGUIMIENTOS******* */
    window.location = '/verCaso/' + idcaso;

   //********TALLERES******* */
   //window.location = '/verCaso/' + idcaso;

});

//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_casos').on('click', '.Bloquear', function(e) {
    let idcaso = $(this).attr('idcaso');
    let borrado = 'true'
    let datos = {
        idcaso: idcaso,
        borrado: borrado
    }
    Swal.fire({
        title: '¿Deseas Eliminar el Registro?',
        text: 'El registro será eliminado del Sitema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            // Aquí puedes agregar la lógica para salir de la página
            $.ajax({
                url: "/eliminar_Caso",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(JSON.stringify(datos))
                },
                beforeSend: function() {

                }
            }).then((response) => {
                Swal.fire('Exito!', "Caso eliminado exitosamente", "success");
                $("#editUser").modal('hide');

                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            });

        }
    });
});

//METODO PARA ABRIR EL MODAL PARA REMITIR EL CASO
$('#listar_casos').on('click', '.Remitir', function(e) {
    e.preventDefault();

    let idcaso = $(this).attr('idcaso');
    $("#remitir_caso").modal("show");
    $("#remitir_caso").find('#idcaso').val(idcaso);
});
$(document).on("submit", "#caso-remitido", function(e) {
    e.preventDefault();
    
    // Referencias a elementos del modal para no repetir código
    let $botonSubmit = $(this).find("button[type=submit]");
    let $mensajeContenedor = $("#mensaje");

    let datos = {
        "id_caso": $("#idcaso").val(),
        "direccion": $("#direcciones_caso").val(),
        "nombre_direccion": $('#direcciones_caso option:selected').text()
    }

    $.ajax({
        url: "/remitirCaso",
        method: "POST",
        dataType: "JSON",
        data: { data: btoa(unescape(encodeURIComponent(JSON.stringify(datos)))) },
        beforeSend: function() {
            // Deshabilitar botón y mostrar estado de carga dentro del modal
            $botonSubmit.attr('disabled', 'true').html('<i class="fas fa-spinner fa-spin"></i> Enviando...');
            $mensajeContenedor.removeClass('alert-success alert-danger').addClass('alert-info').html('<i class="fas fa-sync fa-spin mr-2"></i> Procesando remisión... por favor espere.').fadeIn();
        },
        success: function(respuesta) {
            
            if (respuesta.mensaje === 1) {
                // ÉXITO DENTRO DEL MODAL
                $mensajeContenedor.removeClass('alert-info alert-danger').addClass('alert-success')
                    .html('<strong><i class="fas fa-check-circle"></i> ¡ÉXITO!</strong> El caso Nº ' + respuesta.idcaso + ' ha sido remitido correctamente.');
                
                setTimeout(function() {
                    window.location = "/casos";
                }, 1600);

            } else if (respuesta.mensaje === 2) {
                // ERROR DE SISTEMA DENTRO DEL MODAL
                $mensajeContenedor.removeClass('alert-info alert-success').addClass('alert-danger')
                    .html('<strong><i class="fas fa-exclamation-triangle"></i> ERROR:</strong> Hubo un problema al intentar remitir el caso.');
                
                $botonSubmit.removeAttr('disabled').text('Confirmar Remisión');

            } else if (respuesta.mensaje === 3) {
                // ERROR DE CONFIGURACIÓN DENTRO DEL MODAL
                $mensajeContenedor.removeClass('alert-info alert-success').addClass('alert-danger')
                    .html('<strong><i class="fas fa-envelope-slash"></i> SIN CORREO:</strong> La dirección seleccionada no tiene un correo asociado.');
                
                $botonSubmit.removeAttr('disabled').text('Confirmar Remisión');
            }
        },
        error: function() {
            // Error de red o servidor (500)
            $mensajeContenedor.removeClass('alert-info').addClass('alert-danger')
                .html('<strong><i class="fas fa-bug"></i> Error crítico:</strong> No se pudo conectar con el servidor.');
            $botonSubmit.removeAttr('disabled').text('Confirmar Remisión');
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

$("#red-social").on('change', function() {
    $("#red-social").removeClass('is-invalid');
    id_red_social=$('#red-social').val();  
    let id_tipo_atencion=null;
   llenar_Tipo_Atencion_filtros(Event,id_red_social,id_tipo_atencion);   
 
});

function llenar_Tipo_Atencion_filtros(e, id_red_social, id_tipo_atencion) {
    // Validación: No hacer la llamada AJAX si id_red_social es nulo, indefinido, 0 o cadena vacía
    if (id_red_social === null || id_red_social === undefined || id_red_social === '' || id_red_social === '0') {
        // Limpiar el select y colocar la opción por defecto
        var $select = $("#tipo-atencion-usu");
        $select.empty();
        $select.append("<option value='0' selected disabled>Seleccione</option>");
        return; // No continuar con la llamada AJAX
    }
    
    let url = "/buscar_via_tipo_atencion/" + id_red_social;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function() {
            // Puedes agregar un loader o alguna acción antes de la solicitud
        },
        success: function(data) {
            // Seleccionamos el select donde vamos a agregar las opciones
            var $select = $("#tipo-atencion-usu");
            // Limpiamos el select antes de agregar nuevas opciones
            $select.empty();
            // Agregamos la opción "Seleccione" como primera opción
            $select.append("<option value='0' selected disabled>Seleccione</option>");
            // Recorremos el array de datos y agregamos cada opción al select
            $.each(data, function(index, item) {
                // Verificamos si id_tipo_atencion es nulo o indefinido
                let option = $('<option></option>')
                    .val(item.tipo_atencion_id)
                    .text(item.tipo_aten_nombre)
                    .attr('data-act-pro-int', item.act_pro_int); // Agregamos el atributo data-act-pro-int

                // Si coincide, agregamos la opción con selected
                if (id_tipo_atencion !== null && id_tipo_atencion !== undefined && id_tipo_atencion === item.tipo_atencion_id) {
                    option.prop('selected', true);
                }

                // Agregamos la opción al select
                $select.append(option);
            });
        },
        error: function(xhr, status, errorThrown) {
            alert("Error: " + xhr.status + " - " + errorThrown);
        },
    });
}



//FUNCION PARA LLENAR EL COMBO TIPO DE TIPO DE BENEFICIARIOS
function llenar_Tipo_Beneficiarios(e, tipo_beneficiario) {
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
                if (tipo_beneficiario === undefined) {
                    $.each(data, function(i, item) {
                        
                        $("#t-beneficiario").append(
                            "<option value=" +
                            item.tipo_beneficiario_id +
                            ">" +
                            item.tipo_beneficiario_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.tipo_beneficiario_id === tipo_beneficiario) {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id +
                                " selected>" +
                                item.tipo_beneficiario_nombre +
                                "</option>"
                            );
                            $('#Tipo_antenc_anterior').val(item.tipo_beneficiario_nombre);

                        } else {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id +
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

/**
 * Función para llenar el combo de detalle de atención, filtrando por 'tipo_aten_id' 
 * y seleccionando una opción inicial si 'tipo_atend_id' es nulo o vacío.
 *
 * @param {Event} e - Parámetro de evento (se ignora).
 * @param {string|number} idTipoAtencion - ID del Tipo de Atención para filtrar (coincide con 'tipo_aten_id').
 * @param {string|number} [tipo_atend_id] - ID del Detalle de Atención que debe quedar seleccionado.
 */
function llenar_detalle_atencion(e, idTipoAtencion, tipo_atend_id) {
    
    const url = '/Listar_Detalle_Atencion_filtro';
    const $selectDetalle = $('#edit_detelle_atencion'); 
    const $hijosTipoAtencion = $("#hijos_tipoatencion");
    const $contenedorDetalle = $(".detalle_atencion"); 
    
    // Convertimos a String y limpiamos espacios.
    let idFiltro = String(idTipoAtencion || '').trim();
    let idSeleccion = String(tipo_atend_id || '').trim(); 
    
    // 🚨 CORRECCIÓN CLAVE: Si llega la cadena "null" (que es el problema reportado), 
    // la convertimos a cadena vacía para que la validación 'if (idSeleccion)' funcione correctamente.
    if (idSeleccion === 'null' || idSeleccion === 'undefined') {
        idSeleccion = '';
    }

    // 1. Limpiamos y preparamos el select con un placeholder de carga.
    $selectDetalle.empty().append('<option value="" selected disabled>Cargando...</option>'); 

    // Validación de filtro (si idTipoAtencion es nulo/inválido)
    if (!idFiltro || idFiltro === 'undefined' || idFiltro === '0') {
         $contenedorDetalle.hide();
         $hijosTipoAtencion.val('NO');
         $selectDetalle.find('option').text('Seleccione un Tipo de Atención');
         return; 
    }
    
    // Si llegamos aquí, idFiltro es válido y procedemos con AJAX.

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
    })
    .done(function(data) {
        if (!data || data.length === 0) {
            $selectDetalle.empty().append('<option value="" disabled>No hay detalles disponibles</option>');
            $contenedorDetalle.hide();
            $hijosTipoAtencion.val('NO');
            return;
        }

        // 2. Aplicar el filtro por Tipo de Atención ('tipo_aten_id')
        let datosFiltrados = data.filter(item => item.tipo_aten_id === idFiltro);

        // Mostrar contenedor ya que el filtro es válido.
        $contenedorDetalle.show();
        $hijosTipoAtencion.val('SI');
        
        // 3. Llenar el Select
        if (datosFiltrados.length >= 1) {
             
             // Creamos la opción "Seleccione" (placeholder en el índice 0)
             $selectDetalle.empty().append('<option value="" disabled>Seleccione</option>'); 
             
             $.each(datosFiltrados, function(i, item) {
                $selectDetalle.append(
                    `<option value="${item.tipo_atend_id}">${item.tipo_atend_nombre}</option>`
                );
             });
             
             // 4. LÓGICA DE SELECCIÓN CONDICIONAL
             if (idSeleccion) {
                 // REGLA 1: Si hay un ID de detalle guardado, lo selecciona.
                 $selectDetalle.val(idSeleccion); 
             } else {
                 // REGLA 2: Si idTipoAtencion es válido pero tipo_atend_id es nulo/vacío, 
                 // forzamos la selección del placeholder.

                 // Intento 1: Seleccionar el valor vacío.
                 $selectDetalle.val(''); 
                 
                 // Intento 2: Si el val('') falla, forzamos la selección del índice 0.
                 if (!$selectDetalle.val()) {
                     $selectDetalle.prop('selectedIndex', 0);
                 }
             }
             
        } else {
            $contenedorDetalle.hide();
             // Si el filtro se aplicó, pero la lista quedó vacía
             $selectDetalle.empty().append('<option value="" selected disabled>No se encontraron detalles</option>');
        }
    })
    .fail(function(xhr, status, errorThrown) {
        console.error("Error al cargar el detalle de atención:", xhr.status, errorThrown);
        $selectDetalle.empty().append('<option value="" selected disabled>Error al cargar</option>');
    });
}
$('#editCase').on('hidden.bs.modal', function () {

    // Resetea el formulario cuando el modal se cierra

    $(this).find('input[type="text"], select').val('');

  });


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


function cargarPuntosDeCuenta(idcaso) {
    // 1. Resetear la variable global antes de cada nueva carga
    datosAgrupadosPorPunto = {};
    const selectElement = $("#punto-cuenta-select");
    const documentosSelect = $("#documentos-select");
    
    // Texto de la opción por defecto (placeholder)
    const defaultOptionText = "Seleccione un Punto de Cuenta";
    const defaultDocOptionText = "Seleccione un Documento";

    // 2. Limpiar selects y deshabilitar el selector de documentos
    // Usamos .html() para establecer la opción por defecto fácilmente
    selectElement.html(`<option value="">${defaultOptionText}</option>`);
    documentosSelect.html(`<option value="">${defaultDocOptionText}</option>`).prop('disabled', true);
    
    // Validar el ID del caso antes de la llamada
    if (!idcaso) {
        console.warn("ID del caso no proporcionado. No se realizará la llamada AJAX.");
        return;
    }

    // Datos a enviar (usando la convención de btoa/JSON)
    const dataToSend = { idcaso: idcaso };

    // 3. Llamada AJAX
    $.ajax({
        url: "/verificar_caso_punto_cuenta",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(dataToSend)),
        },
    })
    .then((response) => {
        const datos = response; 
        
        // Validación: asegurar que es un array con datos
        if (!Array.isArray(datos) || datos.length === 0) {
                    $(".punto").hide();
            console.warn("La respuesta es un array vacío o no hay puntos de cuenta asociados.");
            // No hacemos nada, los selects ya tienen el mensaje por defecto.
            return; 
        }
        $(".punto").show();
        const puntosCuentaUnicos = new Map();
        const opcionesHTML = [];
        
        datos.forEach(item => {
            const id = item.id_punto_cuenta;
            
            // A. Lógica para el select ÚNICO de Puntos de Cuenta
            if (!puntosCuentaUnicos.has(id)) {
                const text = `(${item.numero_punto_cuenta}) ${item.nombre}`;
                puntosCuentaUnicos.set(id, { value: id, text: text });
                opcionesHTML.push(`<option value="${id}">${text}</option>`);
            }
            
            // B. Lógica para la AGRUPACIÓN DE DOCUMENTOS
            if (!datosAgrupadosPorPunto[id]) {
                datosAgrupadosPorPunto[id] = [];
            }
            datosAgrupadosPorPunto[id].push({
                docu_ruta: item.docu_ruta,
                // Usar nombre_doc si existe, sino la ruta. Se mantiene tu lógica original.
                nombre_doc: item.nombre_doc || item.docu_ruta 
            });
        });
        
        // 4. Llenar el select principal de manera eficiente
        selectElement.append(opcionesHTML.join(''));
        
        console.log("Datos agrupados listos para usar:", datosAgrupadosPorPunto);
    })
    .catch((jqXHR, textStatus, errorThrown) => {
        console.error("Error al cargar puntos de cuenta:", textStatus, errorThrown, jqXHR);
        // Opcional: Notificar al usuario sobre el error.
    }); 
}
//---------------------------------------------------------------------
// --- MANEJO DEL EVENTO DE CAMBIO DEL PUNTO DE CUENTA ---
//---------------------------------------------------------------------

/**
 * Evento 'change' que se dispara cuando el usuario selecciona un Punto de Cuenta.
 */
$("#punto-cuenta-select").on('change', function() {
    const puntoCuentaSeleccionado = $(this).val();
    const documentosSelect = $("#documentos-select");
    const defaultDocOptionText = "Seleccione un Documento";

    // 1. Limpiar y establecer la opción por defecto
    documentosSelect.html(`<option value="">${defaultDocOptionText}</option>`);
    documentosSelect.prop('disabled', true);
    
    // 2. Verificar si hay un ID válido seleccionado
    if (puntoCuentaSeleccionado) {
        // Obtener la lista de documentos para el ID seleccionado
        const documentos = datosAgrupadosPorPunto[puntoCuentaSeleccionado];
        const opcionesDocHTML = [];

        if (documentos && documentos.length > 0) {
            documentos.forEach(doc => {
                // Usar docu_ruta como valor y nombre_doc/docu_ruta como texto visible
                opcionesDocHTML.push(`<option value="${doc.docu_ruta}">${doc.nombre_doc}</option>`);
            });
            
            // Llenar el select de Documentos
            documentosSelect.append(opcionesDocHTML.join(''));
            
            // Habilitar el selector de documentos
            documentosSelect.prop('disabled', false);
        } else {
            console.warn(`No se encontraron documentos para el punto de cuenta ID: ${puntoCuentaSeleccionado}`);
        }
    }
});

function llenar_pais_generico(prefix, paisid) {
    url = "/llenar_pais";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            const $select = $(`#${prefix}-pais-select`); // Selector dinámico
            $select.empty();

            if (data.length >= 1) {
                $.each(data, function(i, item) {
                    const isSelected = item.paisid == paisid ? 'selected' : '';
                    $select.append(
                        `<option value="${item.paisid}" ${isSelected}>${item.paisnom}</option>`
                    );
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error(`Error al cargar países para ${prefix}:`, errorThrown);
        },
    });
}

function llenar_estados_generico(prefix, estadoid) {
    url = "/llenar_Estados";
    return $.ajax({ // Retornamos la promesa para encadenar
        url: url,
        method: "GET",
        dataType: "JSON",
    })
    .then((data) => {
        const $select = $(`#${prefix}-estado-select`); // Selector dinámico
        $select.empty().append("<option value=0 selected disabled>Seleccione Estado</option>");

        if (data.length >= 1) {
            $.each(data, function(i, item) {
                const isSelected = item.estadoid == estadoid ? 'selected' : '';
                $select.append(
                    `<option value="${item.estadoid}" ${isSelected}>${item.estadonom}</option>`
                );
            });
        }
        return data; // Retornar data para el siguiente .then
    })
    .catch((xhr, status, errorThrown) => {
        console.error(`Error al cargar estados para ${prefix}:`, errorThrown);
    });
}

function llenar_municipios_generico(prefix, estadoid, municipioid) {
    let datos = { id_estado: estadoid };
    return $.ajax({
        url: "/municipios",
        method: "POST",
        dataType: "JSON",
        data: { data: btoa(JSON.stringify(datos)) },
    })
    .then((response) => {
        const $select = $(`#${prefix}-municipio-select`); // Selector dinámico
        $select.html(response.data);
        $select.val(municipioid).prop("selected", true);
        return response;
    })
    .catch((request) => {
        console.error(`Error al cargar municipios para ${prefix}:`, request.responseJSON.message || "Error");
    });
}

function llenar_parroquias_generico(prefix, municipioid, parroquiaid) {
    let datos = { id_municipio: municipioid };
    return $.ajax({
        url: "/parroquias",
        method: "POST",
        dataType: "JSON",
        data: { data: btoa(JSON.stringify(datos)) },
    })
    .then((response) => {
        const $select = $(`#${prefix}-parroquia-select`); // Selector dinámico
        $select.html(response.data);
        $select.val(parroquiaid).prop("selected", true);
        return response;
    })
    .catch((request) => {
        console.error(`Error al cargar parroquias para ${prefix}:`, request.responseJSON.message || "Error");
    });
}



// =================================================================
// DEFINICIONES DE FUNCIONES AUXILIARES (CORRECCIÓN)
// =================================================================
function llenar_Paises_Multiple(selectId, idSeleccionado) {
    const url = "/llenar_pais";
    
    // Retorna la promesa de la llamada AJAX
    return $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
    })
    .then((data) => {
        const $select = $(`#${selectId}`);
        $select.empty();
        
        // 1. Llenar opciones
        if (data.length >= 1) {
            $.each(data, function(i, item) {
                $select.append(
                    `<option value="${item.paisid}">${item.paisnom}</option>`
                );
            });
        }
        
        // 2. FORZAR LA SELECCIÓN y disparar el evento (CRUCIAL)
        if (idSeleccionado && idSeleccionado != 0) {
            // Convertimos a String para asegurar compatibilidad con los valores del DOM
            $select.val(String(idSeleccionado)).trigger('change'); 
        }
        
        return data; 
    })
    .catch((xhr, status, errorThrown) => {
        console.error("Error al cargar Países:", status, errorThrown);
        throw errorThrown;
    });
}

function llenar_Estados_Multiple(selectId, idSeleccionado) {
    const url = "/llenar_Estados"; 
    
    // Retorna la promesa de la llamada AJAX
    return $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
    })
    .then((data) => {
        const $select = $(`#${selectId}`);
        $select.empty();
        
        // 1. Llenar opciones
        $select.append("<option value='0' selected disabled>Seleccione</option>");
            
        if (data.length >= 1) {
            $.each(data, function(i, item) {
                $select.append(
                    `<option value="${item.estadoid}">${item.estadonom}</option>`
                );
            });
        }
        
        // 2. FORZAR LA SELECCIÓN y disparar el evento (CRUCIAL)
        if (idSeleccionado && idSeleccionado != 0) {
            $select.val(String(idSeleccionado)).trigger('change');
        } else {
            // Asegurar que el valor "Seleccione" (value='0') esté seleccionado por defecto
            $select.val('0'); 
        }
        
        return data;
    })
    .catch((xhr, status, errorThrown) => {
        console.error("Error al cargar Estados:", status, errorThrown);
        throw errorThrown;
    });
}
// =================================================================
// FUNCIÓN PRINCIPAL DE INICIALIZACIÓN (CÓDIGO CORREGIDO Y REFACTORIZADO)
// =================================================================

/**
 * Inicializa los selectores de ubicación y sus eventos de cascada para una sección específica.
 * @param {string} prefijo - El prefijo del ID (ej: 'apoderado-solicitante').
 */
function llenar_Selectores_Iniciales(prefijo) {
    // Definición de ID's de los selectores
    const paisId = `${prefijo}-pais-select`;
    const estadoId = `${prefijo}-estado-select`;
    const municipioId = `${prefijo}-municipio-select`;
    const parroquiaId = `${prefijo}-parroquia-select`;

    // --- Funciones Auxiliares para Limpieza y Carga AJAX ---
    
    /** Limpia y restablece un selector al valor "Seleccione" (value="0"). */
    const limpiarSelector = (id) => {
        const defaultOption = "<option value='0' disabled selected>Seleccione</option>";
        $(`#${id}`).empty().append(defaultOption).val('0');
    };

    /** Carga los municipios basados en un ID de estado. */
    const cargarMunicipios = (id_estado) => {
        // Limpia los selectores inferiores
        limpiarSelector(municipioId);
        limpiarSelector(parroquiaId);

        // Si el estado no es válido o es '0', no hacemos la llamada AJAX
        if (!id_estado || id_estado == '0') {
            return Promise.resolve(null);
        }

        const datos = { id_estado: id_estado };
        
        return $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: { data: btoa(JSON.stringify(datos)) },
        })
        .then((response) => {
            $(`#${municipioId}`).html(response.data);
            return $(`#${municipioId}`).val(); // Retorna el valor del primer municipio seleccionado
        });
    };
    
    /** Carga las parroquias basadas en un ID de municipio. */
    const cargarParroquias = (id_municipio) => {
        // Limpia el selector inferior
        limpiarSelector(parroquiaId);

        // Si el municipio no es válido o es '0', no hacemos la llamada AJAX
        if (!id_municipio || id_municipio == '0') {
            return Promise.resolve(null);
        }

        const datos = { id_municipio: id_municipio };
        
        return $.ajax({
            url: "/parroquias",
            method: "POST",
            dataType: "JSON",
            data: { data: btoa(JSON.stringify(datos)) },
        })
        .then((response) => {
            $(`#${parroquiaId}`).html(response.data);
            return true;
        });
    };

    // --- 1. Inicialización ---
    llenar_Paises_Multiple(paisId);
    llenar_Estados_Multiple(estadoId);
    // Asegurar que Municipio y Parroquia inicien limpios y en '0'
    limpiarSelector(municipioId); 
    limpiarSelector(parroquiaId);

    // --- 2. Evento al cambiar el PAÍS (LÓGICA DE CASCADA Y EXTRANJERO) ---
    $(`#${paisId}`).on('change', function() {
        $(`#${paisId}`).removeClass('is-invalid');
        const pais = $(this).val();  
        
        if (pais != 1) {
            // Lógica País Extranjero: Fija la ubicación 
            const ID_ESTADO_EXT = 26; // ID del estado para extranjeros
            const ID_MUN_EXT = '336';
            const ID_PARROQUIA_EXT = '1135';
            
            // 1. Establecer Estado y deshabilitar selectores
            llenar_Estados_Multiple(estadoId, ID_ESTADO_EXT); 
            $(`#${estadoId}`).val(ID_ESTADO_EXT).prop('disabled', true);
            $(`#${municipioId}`).prop('disabled', true);
            $(`#${parroquiaId}`).prop('disabled', true);

            // 2. Cargar municipios/parroquias para la ubicación fija
            cargarMunicipios(ID_ESTADO_EXT)
            .then(() => cargarParroquias(ID_MUN_EXT))
            .then(() => {
                // 3. Establecer los valores fijos después de la carga
                $(`#${municipioId}`).val(ID_MUN_EXT); 
                $(`#${parroquiaId}`).val(ID_PARROQUIA_EXT);
            })
            .catch((request) => {
                Swal.fire("Error", request.responseJSON.message || "Error al cargar ubicación extranjera.", "error");
            });
            
        } else {
            // Lógica País Nacional (1): Restablecer y habilitar
            $(`#${estadoId}`).val('0').prop('disabled', false);
            $(`#${municipioId}`).prop('disabled', false); 
            $(`#${parroquiaId}`).prop('disabled', false);
            
            llenar_Estados_Multiple(estadoId); // Vuelve a llenar con todos los estados
            limpiarSelector(municipioId);
            limpiarSelector(parroquiaId);
        }
    });

    // --- 3. Evento al cambiar el ESTADO (CASCADA: MUNICIPIOS y PARROQUIAS) ---
    $(`#${estadoId}`).on("change", (e) => {
        e.preventDefault();
        
        if ($(`#${estadoId}`).prop('disabled')) return;

        const id_estado_seleccionado = $(`#${estadoId}`).val();
        
        cargarMunicipios(id_estado_seleccionado)
        .then((primer_municipio_cargado) => {
            // Si la carga fue exitosa, intenta cargar las parroquias del primer municipio (si existe)
            if (primer_municipio_cargado) {
                 return cargarParroquias(primer_municipio_cargado);
            }
            return null; // Retorna null si no hay municipios o si el estado era '0'
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar municipios y parroquias.", "error");
        });
    });

    // --- 4. Evento al cambiar el MUNICIPIO (CASCADA: PARROQUIAS) ---
    $(`#${municipioId}`).on("change", (e) => {
        e.preventDefault();
        
        if ($(`#${municipioId}`).prop('disabled')) return;

        const id_municipio_seleccionado = $(`#${municipioId}`).val();
        
        cargarParroquias(id_municipio_seleccionado)
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar parroquias.", "error");
        });
    });
}

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



