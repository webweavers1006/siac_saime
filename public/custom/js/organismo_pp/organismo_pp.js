$(function() {
    listar_via_de_atencion();

});

/*
 * Función para definir datatable:
 */
function listar_via_de_atencion() {
    $('#table_Organismos_pp').DataTable({
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
            "url": "/Listar_organismo_pp/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'org_id' },
            { data: 'org_nombre' },
            { data: 'borrado' },


            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"     org_id=' + row.org_id + '    org_nombre="' + row.org_nombre + '"     borrado=' + row.borrado + ' > <i class="material-icons " >create</i></a>'

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








// //EVENTO PARA AGREGAR UN NUEVO TIPO DE ORGANISMO
$(document).on('submit', "#new-organismo_pp", function(e) {
    e.preventDefault();
    let org_nombre = $("#name-organismo_pp").val();
    org_nombre = org_nombre.trim();
    let datos = {
        "org_nombre": org_nombre,
    }

    $.ajax({
        url: "/add_organismo_pp",
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
                    window.location = "/vista_organismo_pp";
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
                    window.location = "/vista_organismo_pp";
                }, 1500);
            }
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_organismo_pp').on('click', '.Editar', function(e) {
    var org_id = $(this).attr('org_id');
    var org_nombre = $(this).attr('org_nombre');
    var borrado = $(this).attr('borrado');
    $("#editar").modal("show");
    // Limpia todos los checkboxes dentro del modal

    $('#editar').find('#editar-org_nombre').val(org_nombre);
    $('#editar').find('#org_id').val(org_id);

    if (borrado == 'Activo') {
        $('#borrado').attr('checked', 'checked');
        $('#borrado').val('false');
    }
    if (borrado == 'Inactivo') {
        $('#borrado').removeAttr('checked')
        $('#borrado').val('true')
    }

});


// //Evento para guardar la edicion
$(document).on('click', "#btnActualizar", function(e) {
    e.preventDefault();
    let org_nombre = $("#editar-org_nombre").val();
    let borrado = $("#borrado").val();
    let org_id = $("#org_id").val();
    if ($('#borrado').is(':checked')) {
        borrado = 'false';

    } else {
        borrado = 'true';

    }
    let datos = {
        "org_nombre": org_nombre,
        "borrado": borrado,
        "org_id": org_id,
    }
    $.ajax({
        url: "/edit_organimo_pp",
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
                    window.location = "/vista_organismo_pp";
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
                    window.location = "/vista_organismo_pp";
                }, 1500);
            }
        }
    });

});


