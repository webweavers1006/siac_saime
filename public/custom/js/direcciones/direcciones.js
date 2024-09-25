$(function() {
    listar_Direcciones_Administra();
});



/*
 * Función para definir datatable:
 */
function listar_Direcciones_Administra() {
    $('#table_direcciones').DataTable({
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
            "url": "/listar_Ubicacion_Administrativa/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'id' },
            { data: 'descripcion' },
            { data: 'correo' },
            { data: 'borrado' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"     id=' + row.id + '    descripcion="' + row.descripcion + '"   correo="' + row.correo + '"    borrado=' + row.borrado + ' > <i class="material-icons " >create</i></a>'
    
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

// //EVENTO PARA AGREGAR UNA DIRECCION
$(document).on('submit', "#new-direccion", function(e) {
    e.preventDefault();
    let descripcion = $("#name-direccion").val();
    let correo = $("#name-correo").val();
    descripcion = descripcion.trim();
    let datos = {
        "descripcion": descripcion,
        "correo": correo,
    }
    $.ajax({
        url: "/add_Direccion",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            //$("button[type=submit]").attr('disabled', 'true');
        },
        success: function(respuesta) {

            if (respuesta.mensaje === 1) {
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
                    window.location = "/vista_direcciones_admin";
                }, 1500);
            } else if (respuesta.mensaje === 2) {
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
                    window.location = "/vista_direcciones_admin";
                }, 1500);
            }
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_direcciones').on('click', '.Editar', function(e) {
    var id_direccion = $(this).attr('id');
    var descripcion = $(this).attr('descripcion');
    var correo = $(this).attr('correo');
    var borrado = $(this).attr('borrado');
    $("#editar").modal("show");
    $('#editar').find('#editar-direccion').val(descripcion);
    $('#editar').find('#id-direccion').val(id_direccion);
    $('#editar').find('#editar-correo').val(correo);


    if (borrado == 'Activo') {
        $('#borrado').attr('checked', 'checked');
        $('#borrado').val('false');
    }
    if (borrado == 'Inactivo') {
        $('#borrado').removeAttr('checked')
        $('#borrado').val('true')
    }
});


// //Evento para guardar la direccion editada
$(document).on('submit', "#edit-direccion", function(e) {
    e.preventDefault();
    let descripcion = $("#editar-direccion").val();
    let borrado = $("#borrado").val();
    let id_direccion = $("#id-direccion").val();
    let correo = $("#editar-correo").val();
    if ($('#borrado').is(':checked')) {

        borrado = 'false';

    } else {
        borrado = 'true';

    }
    let datos = {
        "descripcion": descripcion,
        "borrado": borrado,
        "id_direccion": id_direccion,
        "correo": correo,
    }
    $.ajax({
        url: "/editDirecciones",
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
                    window.location = "/vista_direcciones_admin";
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
                    window.location = "/vista_direcciones_admin";
                }, 1500);
            }
        }
    });

});

$(document).on('change', '#name-correo', function(e) {
    let texto = $("#name-correo").val();
    if (texto.match(/\w*.\w*\@sapi.gob.ve/) == null) {
        $("#name-correo").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#name-correo").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#name-correo").removeClass('is-invalid');
        $("#name-correo").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
})

$(document).on('change', '#editar-correo', function(e) {
    let texto = $("#editar-correo").val();
    if (texto.match(/\w*.\w*\@sapi.gob.ve/) == null) {
        $("#editar-correo").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#editar-correo").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#editar-correo").removeClass('is-invalid');
        $("#editar-correo").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
})