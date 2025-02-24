$(function() {
    listar_Direcciones_Administra();
});

/*
 * Función para definir datatable:
 */
function listar_Direcciones_Administra() {
    $('#table_beneficiarios').DataTable({
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
            "url": "/Listar_Tipo_Beneficiarios/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'tipo_beneficiario_id' },
            { data: 'tipo_beneficiario_nombre' },
            { data: 'borrado' },


            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"     tipo_beneficiario_id=' + row.tipo_beneficiario_id + '    tipo_beneficiario_nombre="' + row.tipo_beneficiario_nombre + '"     borrado=' + row.borrado + ' > <i class="material-icons " >create</i></a>'

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
$(document).on('submit', "#new-beneficiarios", function(e) {
    e.preventDefault();
    let descripcion = $("#name-beneficiarios").val();
    descripcion = descripcion.trim();
    let datos = {
        "descripcion": descripcion,
    }
    $.ajax({
        url: "/add_Tipo_Beneficiarios",
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
                    window.location = "/vista_tipo_Beneficiarios";
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
                    window.location = "/vista_tipo_Beneficiarios";
                }, 1500);
            }
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_tipo_Beneficiarios').on('click', '.Editar', function(e) {
    var id_beneficiario = $(this).attr('tipo_beneficiario_id');
    var descripcion = $(this).attr('tipo_beneficiario_nombre');
    var borrado = $(this).attr('borrado');
    $("#editar").modal("show");
    $('#editar').find('#editar-beneficiario').val(descripcion);
    $('#editar').find('#id-beneficiario').val(id_beneficiario);
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
$(document).on('submit', "#edit-beneficiairos", function(e) {
    e.preventDefault();
    let descripcion = $("#editar-beneficiario").val();
    let borrado = $("#borrado").val();
    let id_beneficiario = $("#id-beneficiario").val();
    if ($('#borrado').is(':checked')) {
        borrado = 'false';

    } else {
        borrado = 'true';

    }
    let datos = {
        "descripcion": descripcion,
        "borrado": borrado,
        "id_beneficiario": id_beneficiario,
    }
    $.ajax({
        url: "/editTipoBeneficiario",
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
                    window.location = "/vista_tipo_Beneficiarios";
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
                    window.location = "/vista_tipo_Beneficiarios";
                }, 1500);
            }
        }
    });

});