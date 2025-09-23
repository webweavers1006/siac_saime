$('#btn_agregar').on('click', function(e) {
    window.location = '/vista_agregar_caso'
});
$(function() {
    Listar_Casos();
    llenar_Tipo_Beneficiarios(Event);
    
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
        responsive: true,
      
        dom: "Bfrtip",
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
        dom: 'Blfrtip',
        "searching": true,
        "lengthMenu": [[10, 25, 50, -1], ['10', '25', '50', 'Todos']],
        "ordering": true,
        "info": true,
        "autoWidth": true,
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
}

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
 



    if (id_tipo_atencion == 1)
    {
       
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
    llenar_detalle_atencion(Event,id_tipo_atencion,tipo_atend_id,hijos_detalle_atencion);
   document.getElementById("edit_detelle_atencion").disabled = false;
})





$("#tipo-atencion-usu").on('change', function(e) {
    document.getElementById("edit_detelle_atencion").disabled = false;
    let id_tipo_atencion = $('#tipo-atencion-usu option:selected').val();
    let tipo_atend_id = $('#id_hijos_detalle_atencion').val();
    var selectedOption = $(this).find('option:selected');
    var act_pro_int = selectedOption.data('act-pro-int');

    let hijos_detalle_atencion;
    if (id_tipo_atencion == 5) 
        {
            if (act_pro_int=='t') 
                {
                   
                    $(".prop_int").show();
                    document.getElementById("tipo-pi").disabled = false;
                    
                }else
                {
                    $(".prop_int").hide();
                }
            $("#cgr").hide();
            $("#denuncias").show();
            llenar_detalle_atencion(Event,id_tipo_atencion,tipo_atend_id,hijos_detalle_atencion);
        }
    else  if (id_tipo_atencion == 1) 
        {            
           
                     $("#denuncias").hide();
                    // $(".detalle_atencion").hide();
                     if (act_pro_int=='t') 
                        {
                           
                            $(".prop_int").show();
                            document.getElementById("tipo-pi").disabled = false;
                            
                        }else
                        {
                            $(".prop_int").hide();
                        }
                         
                        llenar_detalle_atencion(Event,id_tipo_atencion,tipo_atend_id,hijos_detalle_atencion);
        }         
    else
        {
            if (act_pro_int=='t') 
                {
                   
                    $(".prop_int").show();
                    document.getElementById("tipo-pi").disabled = false;
                    
                }else
                {
                    $(".prop_int").hide();
                }
            $("#cgr").hide();
            $("#denuncias").hide();
           // $(".detalle_atencion").show();
        }

    // Llama a la función para llenar detalles de atención
    llenar_detalle_atencion(Event,id_tipo_atencion,tipo_atend_id,hijos_detalle_atencion);
   
});


//METODO PARA ABRIR EL MODAL PARA LA   EDICION DEL CASO
$('#listar_casos').on('click', '.Imprimir', function(e) {
    e.preventDefault();
    let idcaso = $(this).attr('idcaso');

    window.open('generar_pdf/' + idcaso, '_blank');
    // window.location = '/generar_pdf/' + idcaso, '_blank'
});


var selectElement = document.getElementById('docu-casos');
selectElement.addEventListener('change', function() {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var url = selectedOption.text;
    var ruta = 'documentos_casos/' + url; // Reemplaza "
    window.open(ruta, "_blank");
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
   

    // let idcaso = $("#idcaso").val();
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
        if (tipo_atencion == 1) {

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
        } else if (tipo_atencion == 5) {

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
            //ES UN CASO NORMAL 
        } else {
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
//Evento de envio del formulario
$(document).on("submit", "#caso-remitido", function(e) {
    e.preventDefault();
    let datos = {
        "id_caso": $("#idcaso").val(),
        "direccion": $("#direcciones_caso").val(),
        "nombre_direccion": $('#direcciones_caso option:selected').text()
    }
    $.ajax({
        url: "/remitirCaso",
        method: "POST",
        dataType: "JSON",
        data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(datos))))},
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', 'true');
            $("#mensaje").show();
            
        },
        success: function(respuesta) {
            
            if (respuesta.mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>EL CASO Nª' + ' ' + ' ' + respuesta.idcaso + ' ' + 'HA SIDO REMITIDO </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    //timer: 3500,
                });
                setTimeout(function() {
                    window.location = "/casos";
                }, 1600);
            } else if (respuesta.mensaje === 2) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Hubo un error al intentar remitir el caso .</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 4000,
                });

                setTimeout(function() {
                    window.location = "/casos";
                }, 3000);
            }else if (respuesta.mensaje === 3){
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>LA DIRECCION ADMINISTRATIVA NO TIENE CORREO ASOCIADO .</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3800,
                });

                setTimeout(function() {
                    window.location = "/casos";
                }, 1600);
            }


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




////FUNCION PARA LLENAR EL COMBO DE DETALLE DE ATENCION
function  llenar_detalle_atencion(e,id_tipo_atencion,tipo_atend_id,hijos_detalle_atencion)
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
                $('#edit_detelle_atencion').empty();
                $('#edit_detelle_atencion').append('<option value=0  selected disabled>Seleccione</option>');   
                
                
                if(hijos_detalle_atencion==='NO' || hijos_detalle_atencion==='null')
                {
                    $(".detalle_atencion").hide();
                }else
                {
                
                    if(tipo_atend_id===undefined)
                        {      
                            $.each(data, function(i, item)
                            {
                                //
                                $('#edit_detelle_atencion').append('<option value='+item.tipo_atend_id+'>'+item.tipo_atend_nombre+'</option>');
                    
                            });
                        }
                        else
                        {
                            $(".detalle_atencion").show();
                    
                                // Filtrar datos
                            const datosFiltrados = data.filter(dato => dato.tipo_aten_id === id_tipo_atencion);
                    
                            // Agregar opciones al select
                            datosFiltrados.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.tipo_atend_id;
                                option.textContent = item.tipo_atend_nombre;
                                if (item.tipo_atend_id === tipo_atend_id) {
                                    option.selected = true; // <-- Aquí se agrega la propiedad 'selected'
                                }
                                $('#edit_detelle_atencion').append(option);
                            });
                                
                }   
                
                }
}      
},
error:function(xhr, status, errorThrown)
{
   // alert(xhr.status);
   // alert(errorThrown);
}
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