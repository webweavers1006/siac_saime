$(function() {

    // Limpiar los campos del formulario
    $('#nombre').val('');
    $('#apellido').val('');
    $('#cedula').val('');
    $('#telefono').val('');
    $('#sexo').val('0'); 
    $('#tipo-persona').val('V');
    $('#t-beneficiario').val('0');
    $('#edad').val('');
    $('#pais-caso').val('1');
    $('#estado-caso').val('0');
    $('#municipio-caso').val('0');
    $('#parroquia-caso').val('0');
    let id_caso = $('#id-caso').val();
  
    
    $('#add-seguimiento').find('#actualizar_seguimiento').hide();
    let acceso_taller = $('#acceso_taller').val();
    if (acceso_taller !='f')
    {
        $('.seguimientos').hide();
        $('.participantes').css('visibility', 'visible');
        
    }else
    {
        $('.seguimientos').show();
    }
    buscar_documentos_casos();
    llenar_Estados(Event)
    llenar_Tipo_Beneficiarios(Event);
    listar_seguimientos(id_caso);
    listar_talleres_participantes(id_caso);
    llenar_Organismos_PP(Event);

});


//FUNCION PARA LLENAR EL COMBO ORGANISMOS DEL PODER POPULAR 
function llenar_Organismos_PP(e,org_id) {

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
                if (org_id === undefined) {
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
                        if (item.org_id=== org_id) {
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


 //Evento que busca los municipios por estados
 $(document).on("change", "#estado-caso", (e) => {
   

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




$('#add-seguimiento').on('show.bs.modal', function (event) {
    // Limpiar los campos del formulario
    $('#estatus-llamadas').val(1);
    $('#seguimiento-comentario').val('');
    
  });

/*
 * Función para definir datatable de usuarios:
 */
function listar_seguimientos(id_caso) {
    let rol_usuario=$('#rol_usuario').val();
    let id_usuario=$('#id_usuario').val();
    $('#table_seguimientos').DataTable({
        responsive: true,
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
            "url": "/listar_Seguimientos/" + id_caso,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            //{ data: 'idcaso' },
            { data: 'idsegcas' },
            { data: 'fecha_segui' },
            { data: 'desc_est_llamada' },
            { data: 'user_name' },
            { data: 'segcoment' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {


                if(rol_usuario==5 || rol_usuario==1){
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' + ' ' +
                    '<a href="javascript:;" class="btn btn-xs btn-light Bloquear" style=" font-size:1px" data-toggle="tooltip" title="Eliminar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '"> <i class="material-icons " >delete</i > < /a>'
                }else {

                   if(data.idusuopr==id_usuario)
                    {
                        return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' 
                    }else
                    {
                        return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar disabled " style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' 
                    }
                    
         
                }

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




function listar_talleres_participantes(id_caso) {
    let ruta_imagen = rootpath;
    let descripcion_actividad = $('#descripcion_actividad').val();
    let fecha = $('#fecha_taller').val();
    let estado = $('#estado_taller').val();
    let municipio = $('#municipio_taller').val();
    let parroquia = $('#parroquia_taller').val();
    var encabezado = 'Fecha :'+' '+' '+' '+ fecha+' '+' '+' '+ 'Estado :'+' '+' '+' '+estado+' '+' '+' '+'Municipio :'+ ' '+municipio+' '+' '+' '+'Parroquia :'+ ' '+parroquia;
    var table = $('#table_participantes').DataTable({
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
                    pageSize: 'LETTER',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9],
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
                            doc.pageMargins = [80, 125, 0, 70];
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
                                        height: 50,

                                    },
                                    {
                                        margin: [-1234, 70, -25, 0],
                                        color: '#4c8aa0', 
                                        fontSize: 18,
                                        alignment: 'center',
                                        text: 'Nombre de la Actividad : ',
                                    },
                                    {
                                        margin: [-640, 70, -25, 0], 
                                        color: '#000000', 
                                        fontSize: 18,
                                        alignment: 'center',
                                        text: descripcion_actividad, 
                                    },
                                    {
                                        margin: [-1373, 109, -25, 0], 
                                        color: '#000000', 
                                        alignment: 'center',
                                        text: 'Participantes :',
                                        //bold: true  
                                    },
                                    
                                    {
                                        margin: [-708, 93, -25, 0],
                                        text: encabezado,
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
                    title: descripcion_actividad,

                    download: 'open',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9],
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


        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],

        dom: 'Blfrtip',
        dom: 'f<"length-container"lB>tip',
        
        //"dom": 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
        "ajax": {
            "url": "/listar_participantes/" + id_caso,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'id' },
            { data: 'nombre_completo' },
            { data: 'cedula' },
            { data: 'nacionalidad' },
            { data: 'tipo_beneficiario_nombre' },
            { data: 'paisnom' },
            { data: 'estadonom' },
            { data: 'municipionom' },
            { data: 'parroquianom' },
            { data: 'telefono' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"    id_taller=' + row.id_taller + '  org_id=' + row.org_id + ' sexo=' + row.sexo + ' telefono=' + row.telefono + ' estado=' + row.estado + '  municipio=' + row.municipio + ' parroquia=' + row.parroquia + '  id=' + row.id + '  nombre=' + row.nombre + '   apellido=' + row.apellido + '    cedula="' + row.cedula + '" nacionalidad=' + row.nacionalidad + ' tipo_beneficiario=' + row.tipo_beneficiario + '  edad=' + row.edad + ' > <i class="material-icons " >create</i></a>'

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






$(document).on('submit', "#new-seguimiento", function(e) {
        e.preventDefault();
        let datos = {
            "callid": $("#estatus-llamadas").val(),
            "segcomment": $("#seguimiento-comentario").val(),
            "caseid": $("#id-caso").val()
        }
        if (datos.segcomment.lenght < 1) {
            Swal.fire("Atencion", "Debe añadir obligatoriamente un comentario", "error");
        } else {
            $.ajax({
                 url: "/addSeguimiento",
                method:'POST',
                data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(datos))))},
                dataType:'JSON',
                beforeSend: function() {
                    $("button[type=submit]").attr('disabled', 'true');
                }
            }).then((response) => {
                Swal.fire('Exito', response.message, "success");
                $("#new-seguimiento")[0].reset();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error", request.responseJSON.message, "error");
            });
            $("button[type=submit]").removeAttr('disabled');
            setTimeout(function() {
                location.reload();
            }, 1500);

            $("#add-seguimiento").modal('hide');
        }
    })
    //METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_seguimientos').on('click', '.Editar', function(e) {
    e.preventDefault();
    let idsegcas = $(this).attr('idsegcas');
    let idestllam = $(this).attr('idestllam');
    let segcoment = $(this).attr('segcoment');
    $("#add-seguimiento").modal("show");
    $('#add-seguimiento').find('#estatus-llamadas').val(idestllam);
    $('#add-seguimiento').find('#seguimiento-comentario').val(segcoment);
    $('#add-seguimiento').find('#actualizar_seguimiento').show();
    $('#add-seguimiento').find('#agregar_seguimiento').hide();
    $('#add-seguimiento').find('#idsegcas').val(idsegcas);
})


//Evento para actualizar un seguimiento
$(document).on("click", "#actualizar_seguimiento", (e) => {
    e.preventDefault()
    let datos = {
        "callid": $("#estatus-llamadas").val(),
        "segcomment": $("#seguimiento-comentario").val(),
        "caseid": $("#id-caso").val(),
        "idsegcas": $("#idsegcas").val()
    }
    if (datos.segcomment.lenght < 1) {
        Swal.fire("Atencion", "Debe añadir obligatoriamente un comentario", "error");
    } else {
        $.ajax({
            url: "/actualizar_Seguimiento",
            method: "POST",
            dataType: "JSON",
            data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(datos))))},
            beforeSend: function() {
                $("button[type=submit]").attr('disabled', 'true');
            }
        }).then((response) => {
            Swal.fire('Exito', response.message, "success");
            $("#new-seguimiento")[0].reset();
            setTimeout(function() {
                location.reload();
            }, 1500);
        }).catch((request) => {
            Swal.fire("Error", request.responseJSON.message, "error");
        });
        $("button[type=submit]").removeAttr('disabled');
        setTimeout(function() {
            location.reload();
        }, 1500);

        $("#add-seguimiento").modal('hide');
    }
});















//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_seguimientos').on('click', '.Bloquear', function(e) {
    let idsegcas = $(this).attr('idsegcas');
    let borrado = 'true'
    let datos = {
        idsegcas: idsegcas,
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
                url: "/eliminar_seguimiento",
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




//FUNCION PARA LLENAR EL COMBO DE LOS MUNICIPIOS EN FUNSION DEL ID DEL ESTADO
function buscar_documentos_casos(e) {

let idcaso = $('#id-caso').val();

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

var selectElement = document.getElementById('docu-casos');
selectElement.addEventListener('change', function() {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var url = selectedOption.text;
    var ruta = '../documentos_casos/' + url; // Reemplaza "
    window.open(ruta, "_blank");
});







// Inicializar el arreglo de solicitudes
let solicitudes = [];

// Manejar el evento de clic en el botón "ingresar_participante"
$('#ingresar_participante').on('click', function() {
    let tbody = $('.tbody_0');
    tbody.empty();
    let nombre = $('#nombre').val().trim();
    let apellido = $('#apellido').val().trim();
    let cedula = $('#cedula').val().trim();
    let telefono = $('#telefono').val().trim();
    let sexo = $('#sexo').val();
    let nacionalidad = $('#tipo-persona').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let edad = $('#edad').val();
    let organismo_pp = $('#organismo-caso').val();

    if (organismo_pp==''||organismo_pp==null) 
        {
            organismo_pp = 1;
            
        }

    if (edad==''||edad==null) 
    {
        edad = 0;
        
    }
    let pais = 1;
    let estado = $('#estado-caso').val();
    let municipio = $('#municipio-caso').val();
    let parroquia = $('#parroquia-caso').val();
    if (!nombre )
    {
        //$("#nombre-persona").removeClass('is-invalid');
        $("#nombre").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL NOMBRE.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    }else if (!apellido)
    {
        $("#nombre").removeClass('is-invalid');
        $("#apellido").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL APELLIDO.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });

    }
    else if (!cedula)
        {
            $("#apellido").removeClass('is-invalid');
            $("#cedula").addClass('is-invalid');
            Swal.fire({
                icon: "success",
                type: 'error',
                html: '<strong>DEBE INGRESAR EL LA CEDULA.</strong>',
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 3500,
            });
    
        }
       
    else if (tipo_beneficiario==0 ||tipo_beneficiario==null)
        {
            $("#cedula").removeClass('is-invalid');
            $("#t-beneficiario").addClass('is-invalid');
            Swal.fire({
                icon: "success",
                type: 'error',
                html: '<strong>DEBE SELECCIONAR  EL TIPO DE BENEFICIARIO.</strong>',
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 3500,
            });
        }
        else if (estado==0 ||estado==null)
            {
                $("#t-beneficiario").removeClass('is-invalid');
                $("#estado-caso").addClass('is-invalid');
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR  EL ESTADO.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3500,
                });
            }
        else if (municipio==0 ||municipio==null)
            {
                $("#estado-caso").removeClass('is-invalid');
                $("#municipio-caso").addClass('is-invalid');
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR  EL MUNICIPIO.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3500,
                });
            }
        else if (parroquia==0 ||parroquia==null)
            {
                $("#municipio-caso").removeClass('is-invalid');
                $("#parroquia-caso ").addClass('is-invalid');
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR LA PARROQUIA.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3500,
                });
            }   

            else if (sexo==0 ||sexo==null)
                {
                    $("#parroquia-caso").removeClass('is-invalid');
                    $("#estado-caso").removeClass('is-invalid');
                    $("#sexo ").addClass('is-invalid');
                    Swal.fire({
                        icon: "success",
                        type: 'error',
                        html: '<strong>DEBE SELECCIONAR EL SEXO.</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 3500,
                    });
                }   
        
            else

       {

                // Crear un nuevo objeto de participante
            let nuevoParticipante = {
                nombre: nombre,
                apellido: apellido,
                cedula: cedula,
                telefono: telefono,
                sexo: sexo,
                nacionalidad:nacionalidad,
                tipo_beneficiario:tipo_beneficiario,
                edad:edad,
                pais:pais,
                estado:estado,
                municipio:municipio,
                parroquia:parroquia,
                organismo_pp:organismo_pp
            };
            // Agregar el nuevo participante al arreglo de solicitudes
            solicitudes.push(nuevoParticipante);
            
            // Actualizar la tabla
            updateTable(); 

            // Limpiar los campos del formulario
            $('#nombre').val('');
            $('#apellido').val('');
            $('#cedula').val('');
            $('#telefono').val('');
            $('#sexo').val('0'); 
            $('#tipo-persona').val('V');
            $('#t-beneficiario').val('0');
            $('#edad').val('');
            $('#pais-caso').val('1');
            $('#estado-caso').val('0');
            $('#municipio-caso').val('0');
            $('#parroquia-caso').val('0');
            $('#organismo-caso').val('0');

       }    

      
});

// Función para actualizar la tabla
function updateTable() {
    let tbody = $('.tbody_0');
    tbody.empty(); // Limpiar la tabla antes de volver a llenarla

    // Agregar cada solicitud a la tabla
    solicitudes.forEach((solicitud, index) => {
        let row = $('<tr>').data('index', index);
        row.append($('<td>').text(solicitud.nombre));
        row.append($('<td>').text(solicitud.apellido));
        row.append($('<td>').text(solicitud.cedula));
        row.append($('<td>').text(solicitud.telefono));
        row.append($('<td>').text(solicitud.sexo));

        // Agregar un botón de eliminar a la fila
        let deleteButton = $('<td>').append($('<button>').text('Eliminar')
            .addClass('button is-primary is-light delete-button')
            .css({
                'background-color': '#ebf4ff',
                'color': '#07f'
            }));
        row.append(deleteButton);

        tbody.append(row); // Agregar la fila al cuerpo de la tabla
    });
}

// Función para mostrar mensaje de error
function mostrarMensajeError(mensaje) {
    alert(mensaje); // Implementar la lógica para mostrar el mensaje de error
}

// Manejar el evento de clic en el botón de eliminar
$(document).on('click', '.delete-button', function() {
    // Obtener el índice de la fila a eliminar
    let index = $(this).closest('tr').data('index');
    // Eliminar la solicitud del arreglo
    solicitudes.splice(index, 1);
    // Actualizar la tabla
    updateTable();
});
  


$('#agregar_participantes').on('click', function() {
    let id_caso = $('#id_caso').val(); 

    // Verifica si solicitudes está vacío o es null
    if (!solicitudes || solicitudes.length === 0) {
        Swal.fire("Advertencia", "Debe agregar participantes para poder guardar", "warning");
        return; // Salir de la función si no hay solicitudes
    }

    let datos = {
        id_caso: id_caso,
        solicitudes: solicitudes
    };

    $.ajax({
        url: "/agregar_participantes",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            // Puedes agregar un loader o alguna otra acción aquí si lo deseas
        }
    }).then((response) => {
        Swal.fire('Éxito', response.message, "success");
        setTimeout(function() {
            location.reload();
        }, 1500);
    }).catch((request) => {
        Swal.fire("Error", request.responseJSON.message, "error");
    });
});






$(document).on("change", "#informacion", (e) => {
    let informacion = $('#informacion').val();
    let id_caso = $('#id-caso').val();

    if (informacion === '1') {
        $('.seguimientos').show();
        $('#table_seguimientos').DataTable().destroy();
        listar_seguimientos(id_caso);
        
        $('.seguimientos').css('visibility', 'visible');
        $('.participantes').css('visibility', 'hidden');
    } else {
        $('#table_participantes').DataTable().destroy();
        listar_talleres_participantes(id_caso); // Fetch data first
        $('.seguimientos').hide();
        $('.participantes').css('visibility', 'visible');
    }
});

 // Mostrar y ocultar elementos al abrir el modal
$('#btn-add-participantes').on('click', function() {
    $('#ingresar_participante').show();
    $('.buscar_participante').show();
    $('#table_audiencia').show();
    $('#agregar_participantes').show();
    $('#actualizar_participantes').hide();

});

//METODO PARA ABRIR EL MODAL PARA LA   EDICION DE LOS PARTICIPANTES
$('#listar_participantes').on('click', '.Editar', function(e) {
    e.preventDefault();
    $('#ingresar_participante').hide();
    $('.buscar_participante').hide();
    $('#table_audiencia').hide();
    $('#agregar_participantes').hide();
    $('#actualizar_participantes').show();
    let id = $(this).attr('id');
    let id_taller = $(this).attr('id_taller');
    let nombre = $(this).attr('nombre');
    let apellido = $(this).attr('apellido');
    let cedula = $(this).attr('cedula');
    let nacionalidad = $(this).attr('nacionalidad');
    let tipo_beneficiario = $(this).attr('tipo_beneficiario');
    let edad = $(this).attr('edad');
    let estadoid = $(this).attr('estado');
    let municipioid = $(this).attr('municipio');
    let parroquiaid = $(this).attr('parroquia');
    let telefono = $(this).attr('telefono');
    let sexo = $(this).attr('sexo');
    let org_id = $(this).attr('org_id');
    

    $("#add-participantes").modal("show");
    $('#add-participantes').find('#nombre').val(nombre);
    $('#add-participantes').find('#id_participante').val(id);
    $('#add-participantes').find('#id_taller').val(id_taller);
    $('#add-participantes').find('#apellido').val(apellido);
    $('#add-participantes').find('#cedula').val(cedula);
    $('#add-participantes').find('#tipo-persona').val(nacionalidad);
    $('#add-participantes').find('#t-beneficiario').val(tipo_beneficiario);
    $('#add-participantes').find('#edad').val(edad);
    $('#add-participantes').find('#telefono').val(telefono);
    $('#add-participantes').find('#sexo').val(sexo);
    llenar_Estados(Event, estadoid);
    llenar_municipios(Event, estadoid, municipioid);
    llenar_parroquias(Event, municipioid, parroquiaid);
    llenar_Organismos_PP(Event,org_id);
})




/* METODO PARA ACTUALIZAR PARTICIPANTES */
$('#actualizar_participantes').on('click', function() {
    let id_participante= $('#id_participante').val(); 
    let id_taller= $('#id_taller').val(); 
    let nombre = $('#nombre').val().trim();
    let apellido = $('#apellido').val().trim();
    let cedula = $('#cedula').val().trim();
    let telefono = $('#telefono').val().trim();
    let sexo = $('#sexo').val();
    let nacionalidad = $('#tipo-persona').val();
    let tipo_beneficiario = $('#t-beneficiario').val();
    let edad = $('#edad').val();
    let pais = '1';
    let estado = $('#estado-caso').val();
    let municipio = $('#municipio-caso').val();
    let parroquia = $('#parroquia-caso').val();
    let org_id = $('#organismo-caso').val();
    let datos = 
    {
        id_taller:id_taller,
        org_id:org_id,
        nombre:nombre,
        apellido:apellido,
        cedula:cedula,
        telefono:telefono,
        sexo:sexo,
        nacionalidad:nacionalidad,
        tipo_beneficiario:tipo_beneficiario,
        edad:edad,
        pais:pais,
        estado:estado,
        municipio:municipio,
        parroquia:parroquia,
    }
   
 $.ajax({
            url: "/actualizar_participantes/"+id_participante,
            method: "POST",
            dataType: "JSON",
            data: {
                "data": btoa(JSON.stringify(datos))
            },
            beforeSend: function() 
            {
             
            }
        }).then((response) => {
            Swal.fire('Exito', response.message, "success");
            setTimeout(function() {
                location.reload();
            }, 1500);
        }).catch((request) => {
          Swal.fire("Error", request.responseJSON.message, "error");
        });
       
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

/* METODO PARA BUSCAR PARTICIPANTES */
$('#btn_buscar').on('click', function() {
    let cedula = $('#cedula-existente').val().trim(); 

   
    $.ajax({
        url: "/buscar_participante/" + cedula,
        method: "get",
        dataType: "JSON",
        beforeSend: function() {
    
        }
    }).then((response) => {
        // Verifica si la respuesta tiene datos
        if (response.length > 0) { 
            const participante = response[0]; 

            $('#add-participantes').find('#nombre').val(participante.nombre);
            $('#add-participantes').find('#apellido').val(participante.apellido);
            $('#add-participantes').find('#cedula').val(participante.cedula);
            $('#add-participantes').find('#tipo-persona').val(participante.nacionalidad);
            $('#add-participantes').find('#t-beneficiario').val(participante.tipo_beneficiario);
            $('#add-participantes').find('#edad').val(participante.edad);
            $('#add-participantes').find('#telefono').val(participante.telefono);
            $('#add-participantes').find('#sexo').val(participante.sexo);
            llenar_Estados(Event, participante.estado); 
            llenar_municipios(Event, participante.estado, participante.municipio); 
            llenar_parroquias(Event, participante.municipio, participante.parroquia);
        } else {
            // Limpiar los campos si no se encuentra el participante
            $('#add-participantes').find('#nombre').val('');
            $('#add-participantes').find('#apellido').val('');
            $('#add-participantes').find('#cedula').val('');
            $('#add-participantes').find('#tipo-persona').val('V');
            $('#add-participantes').find('#t-beneficiario').val('0');
            $('#add-participantes').find('#edad').val('');
            $('#add-participantes').find('#telefono').val('');
            $('#add-participantes').find('#sexo').val('0');
            Swal.fire("No encontrado", "No se encontró un participante con esa cédula.", "info");
            $('#add-participantes').find('#cedula').val(cedula);
        }
    }).catch((request) => {
        Swal.fire("Error", request.responseJSON.message || "Ocurrió un error inesperado.", "error");
    });
});