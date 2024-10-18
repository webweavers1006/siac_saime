$(function() {
    listar_roles_audiencias();
});





/*
 * Función para definir datatable:
 */
function listar_roles_audiencias() {
    $('#table_roles').DataTable({
        responsive: true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "info": true,
        "filter": true,
        "autoWidth": true,
        //"stateSave": true,
        "ajax": {
            "url": "http://172.16.0.46:70/roles", // URL correcta
            "type": "GET",
            dataSrc: 'roless' // Cambiado para que apunte a la clave correcta en la respuesta JSON
        },
        "columns": [
            { data: 'id' },
            { data: 'rol' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar"  id=' + row.id + ' descripcion="' + row.rol + '"> <i class="material-icons">create</i></a>';
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
            "sSearch": "Buscar:",
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
$(document).on('submit', "#new-rol", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let datos_audiencia = {
        "rol": $('#name-rol').val().trim(),
    };

    $.ajax({
        type: "POST",
        url: "http://172.16.0.46:70/roles",
        data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(response) {
            Swal.fire('Exito!', "Registro exitoso", "success");

            setTimeout(function() {
                window.location = '/vista_Roles_audiencias';
            }, 1500);
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', "Error al Insertar el registro", "error");
            console.error(xhr.responseText);
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_roles').on('click', '.Editar', function(e) {
    var id = $(this).attr('id');
    var descripcion = $(this).attr('descripcion');
    $("#editar").modal("show");
    $('#editar').find('#editar-rol').val(descripcion);
    $('#editar').find('#id-rol').val(id);

   
});


// Evento para guardar la direccion editada
$(document).on('submit', "#edit-rol", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id = $("#id-rol").val();
    let datos_audiencia = {
        "rol": $('#editar-rol').val(),
    };

    $.ajax({
        type: "PUT",
        url: "http://172.16.0.46:70/roles/" + id,
        data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(response) {
            Swal.fire('Exito!', "REGISTRO ACTUALIZADO", "success");

            setTimeout(function() {
                window.location = '/vista_Roles_audiencias';
            }, 1500);
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', "Error al actualizar el registro", "error");
            console.error(xhr.responseText);
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

