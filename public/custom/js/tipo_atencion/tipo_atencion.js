$(function() {
    listar_Direcciones_Administra();
});

/*
 * Función para definir datatable:
 */
function listar_Direcciones_Administra() {
    $('#table_direcciones').DataTable({
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
            "url": "/Listar_Tipo_Atencion/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'tipo_aten_id' },
            { data: 'tipo_aten_nombre' },
            { data: 'borrado' },


            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" env_correo=' + row.env_correo + ' taller=' + row.acc_participantes + '  act_pro_int=' + row.act_pro_int + '   tipo_aten_id=' + row.tipo_aten_id + '    tipo_aten_nombre="' + row.tipo_aten_nombre + '"     borrado=' + row.borrado + ' > <i class="material-icons " >create</i></a>'

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

// //EVENTO PARA AGREGAR UN NUEVO TIPO DE ATENCION
$(document).on('submit', "#new-atencion", function(e) {
    e.preventDefault();
    let descripcion = $("#name-atencion").val();
    let act_pro_int = $("#acceso_pro_int").is(':checked') ? "true" : "false";
    let acc_participantes = $("#participantes").is(':checked') ? "true" : "false";
    let env_correo = $("#correo").is(':checked') ? "true" : "false";
    descripcion = descripcion.trim();
    let datos = {
        "descripcion": descripcion,
        "act_pro_int": act_pro_int,
        "acc_participantes": acc_participantes,
        "env_correo": env_correo,
    }


    $.ajax({
        url: "/add_Tipo_Atencion",
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
                    window.location = "/vista_tipo_atencion";
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
                    window.location = "/vista_tipo_atencion";
                }, 1500);
            }
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_tipo_atencion').on('click', '.Editar', function(e) {
    var id_atencion = $(this).attr('tipo_aten_id');
    var descripcion = $(this).attr('tipo_aten_nombre');
    var act_pro_int = $(this).attr('act_pro_int');
    var borrado = $(this).attr('borrado');
    var taller = $(this).attr('taller');
    var env_correo = $(this).attr('env_correo');
   
    $("#editar").modal("show");
    $('#editar').find('#editar-atencion').val(descripcion);
    $('#editar').find('#id-atencion').val(id_atencion);

     
    if (act_pro_int == 't') {
        $('#edit_acceso_pro_int').attr('checked', 'checked');
        $('#edit_acceso_pro_int').val('true');
    }
    if (act_pro_int == 'f') {
        $('#edit_acceso_pro_int').removeAttr('checked')
        $('#edit_acceso_pro_int').val('false')
    }

    if (borrado == 'Activo') {
        $('#borrado').attr('checked', 'checked');
        $('#borrado').val('false');
    }
    if (borrado == 'Inactivo') {
        $('#borrado').removeAttr('checked')
        $('#borrado').val('true')
    }
    if (taller == 't') {
        $('#edit_participantes').attr('checked', 'checked');
        $('#edit_participantes').val('false');
    }
    if (taller == 'f') {
        $('#edit_participantes').removeAttr('checked')
        $('#edit_participantes').val('f')
    }
    if (env_correo == 't') {
        $('#edit_correo').attr('checked', 'checked');
        $('#edit_correo').val('false');
    }
    if (env_correo == 'f') {
        $('#edit_correo').removeAttr('checked')
        $('#edit_correo').val('f')
    }


});


// //Evento para guardar la edicion
$(document).on('submit', "#edit-atencion", function(e) {
    e.preventDefault();
    let descripcion = $("#editar-atencion").val();
    let borrado = $("#borrado").val();
    let id_atencion = $("#id-atencion").val();
    let acc_participantes = $("#edit_participantes").val();
    let env_correo = $("#edit_correo").val();
    if ($('#borrado').is(':checked')) {
        borrado = 'false';

    } else {
        borrado = 'true';

    }

    if ($('#edit_correo').is(':checked')) {
        env_correo = 'true';

    } else {
        env_correo = 'false';

    }



    if ($('#edit_acceso_pro_int').is(':checked')) {
        act_pro_int = 'true';

    } else {
        act_pro_int = 'false';

    }

    if ($('#edit_participantes').is(':checked')) {

        acc_participantes = 'true';

    } else {
        acc_participantes = 'false';
    }

    let datos = {
        "descripcion": descripcion,
        "borrado": borrado,
        "id_atencion": id_atencion,
        "act_pro_int": act_pro_int,
        "acc_participantes": acc_participantes,
        "env_correo": env_correo,
    }
    $.ajax({
        url: "/editTipoAtencion",
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
                    window.location = "/vista_tipo_atencion";
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
                    window.location = "/vista_tipo_atencion";
                }, 1500);
            }
        }
    });

});