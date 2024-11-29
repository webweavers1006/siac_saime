$(function() {
    listar_detalle_atencion();
    llenar_Tipo_Atencion(Event);
});

/*
 * Función para definir datatable:
 */
function listar_detalle_atencion() {
    $('#table_detalle_atencion').DataTable({
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
            "url": "/Listar_Detalle_Atencion/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'tipo_atend_id' },
            { data: 'tipo_atencion' },
            { data: 'tipo_atend_nombre' },
            { data: 'tipo_atend_borrado' },

            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"     tipo_atend_id=' + row.tipo_atend_id + '  tipo_aten_id=' + row.tipo_aten_id + '  tipo_atend_nombre="' + row.tipo_atend_nombre + '"     tipo_atend_borrado=' + row.tipo_atend_borrado + ' > <i class="material-icons " >create</i></a>'

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



//FUNCION PARA LLENAR EL COMBO TIPO DE SOLICITUD
function llenar_Tipo_Atencion(e, id) {
    e.preventDefault;
    url = "/Listar_Tipo_Atencion_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#tipo-atencion").empty();
                $("#tipo-atencion").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                      
                        $("#tipo-atencion").append(
                            "<option value=" +
                            item.tipo_aten_id+
                            ">" +
                            item.tipo_aten_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.tipo_aten_id=== id) {
                            $("#tipo-atencion").append(
                                "<option value=" +
                                item.tipo_aten_id+
                                " selected>" +
                                item.tipo_aten_nombre +
                                "</option>"
                            );
                          //  $('#Tipo_ayuda_anterior').val(item.descripcion);
                        } else {
                            $("#tipo-atencion").append(
                                "<option value=" +
                                item.tipo_aten_id+
                                ">" +
                                item.tipo_aten_nombre +
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

//FUNCION PARA LLENAR EL COMBO TIPO DE EDITAR TIPO ATENCION
function llenar_edit_tipo_atencion(e, id) {
    e.preventDefault;
    url = "/Listar_Tipo_Atencion_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#editar-tipo-atencion").empty();
                $("#editar-tipo-atencion").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                      
                        $("#editar-tipo-atencion").append(
                            "<option value=" +
                            item.tipo_aten_id+
                            ">" +
                            item.tipo_aten_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.tipo_aten_id=== id) {
                            $("#editar-tipo-atencion").append(
                                "<option value=" +
                                item.tipo_aten_id+
                                " selected>" +
                                item.tipo_aten_nombre +
                                "</option>"
                            );
                          //  $('#Tipo_ayuda_anterior').val(item.descripcion);
                        } else {
                            $("#editar-tipo-atencion").append(
                                "<option value=" +
                                item.tipo_aten_id+
                                ">" +
                                item.tipo_aten_nombre +
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


$("#tipo-atencion").on('change', function() {
    document.getElementById("tipo_atend_nombre").disabled = false;
 });

// //EVENTO PARA AGREGAR DETALLE DE ATENCION
$(document).on('submit', "#new-detalle", function(e) {
    e.preventDefault();

    let tipo_aten_id = $("#tipo-atencion").val();
    let tipo_atend_nombre = $("#tipo_atend_nombre").val();
    tipo_atend_nombre = tipo_atend_nombre.trim();

    if (tipo_atend_nombre==''||tipo_atend_nombre=='null') 
    {
        alert('Debe Ingresar Nombre del detalle de la Atencion')    
    }else
    {
        let datos = {
            "tipo_atend_nombre": tipo_atend_nombre,
            "tipo_aten_id": tipo_aten_id,
            
        }
        $.ajax({
            url: "/add_Detalle_Atencion",
            method: "POST",
            dataType: "JSON",
            data: {
                "data": btoa(JSON.stringify(datos))
            },
            beforeSend: function() {
                //$("button[type=submit]").attr('disabled', 'true');
            },
            success: function(mensaje) {
    
                if (mensaje == 1) {
                    Swal.fire({
                        icon: "success",
                        type: 'success',
                        html: '<strong>Registro Exitoso</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        //timer: 3500,
    
                    });
                    setTimeout(function() {
                        window.location = "/vista_detalle_atencion";
                    }, 1500);
                } else if (mensaje == 2) {
                    Swal.fire({
                        icon: "error",
                        type: 'error',
                        html: '<strong>Hubo un error al insertar el registro </strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        //timer: 1500,
                    });
                    setTimeout(function() {
                        window.location = "/vista_detalle_atencion";
                    }, 1500);
                }
            }
        });
    }
    
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_detalle_atencion').on('click', '.Editar', function(e) {
    var tipo_atend_id = $(this).attr('tipo_atend_id');
    var tipo_aten_id = $(this).attr('tipo_aten_id');
    var tipo_atend_nombre = $(this).attr('tipo_atend_nombre');
    var tipo_atend_borrado = $(this).attr('tipo_atend_borrado');
    $("#editar").modal("show");
    $('#editar').find('#edit_detalle_atencion').val(tipo_atend_nombre);
    $('#editar').find('#tipo_atend_id').val(tipo_atend_id);
    llenar_edit_tipo_atencion(Event,tipo_aten_id);
    if (tipo_atend_borrado == 'Activo') {
        $('#borrado').attr('checked', 'checked');
        $('#borrado').val('false');
    }
    if (tipo_atend_borrado == 'Inactivo') {
        $('#borrado').removeAttr('checked')
        $('#borrado').val('true')
    }
});


// //Evento para guardar la edicion
$(document).on('submit', "#edit-detalle-atencion", function(e) {
    e.preventDefault();
    let tipo_atend_nombre = $("#edit_detalle_atencion").val();
    let tipo_atend_borrado = $("#borrado").val();
    let tipo_atend_id = $("#tipo_atend_id").val();
    let tipo_aten_id = $("#editar-tipo-atencion").val();

    if ($('#borrado').is(':checked')) {
        borrado = 'false';

    } else {
        borrado = 'true';

    }
    let datos = {
        "tipo_atend_nombre": tipo_atend_nombre,
        "tipo_atend_borrado": borrado,
        "tipo_atend_id": tipo_atend_id,
        "tipo_aten_id": tipo_aten_id,
    }
    $.ajax({
        url: "/editDetalle_Atencion",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            //$("button[type=submit]").attr('disabled', 'true');
        },
        success: function(mensaje) {
            if (mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>Registro Actualizado </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    //timer: 3500,
                });
                setTimeout(function() {
                    window.location = "/vista_detalle_atencion";
                }, 1500);
            } else if (mensaje === 2) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Hubo un error en la actualizacion del registro</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    //timer: 1500,
                });
                setTimeout(function() {
                    window.location = "/vista_detalle_atencion";
                }, 1500);
            }
        }
    });

});