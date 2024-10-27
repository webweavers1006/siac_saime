$(function() {
    Listar_bufetes();

});
$('.guardar').attr('disabled', true);


const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));

/*
 * Función para definir datatable:
 */
function Listar_bufetes() {
    $('#table_bufetes').DataTable({
        responsive: true,
        order: [[0, "desc"]],
        paging: true,
        info: true,
        filter: true,
        autoWidth: true,
        // stateSave: true,
        ajax: {
            url: "http://172.16.0.46:70/bufetes", // URL correcta
            type: "GET",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
            },
            dataSrc: 'bufetes' // Cambiado para que apunte a la clave correcta en la respuesta JSON
        },
        columns: [
            { data: 'id' },
            { data: 'nombre_bufete' },
            { data: 'rif' },
            { data: 'correo_bufete' },
            { data: 'telefono_bufete' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return `<a href="javascript:;" class="btn btn-xs btn-primary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar" id="${row.id}" nombre_bufete="${row.nombre_bufete}" rif="${row.rif}" id_condicion="${row.id_condicion}" correo_bufete="${row.correo_bufete}" telefono_bufete="${row.telefono_bufete}"><i class="material-icons">create</i></a>`;
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
            sSearch: "Buscar:",
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
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            }],
        }
    });
}
// //EVENTO PARA AGREGAR UN ROL 
$(document).on('submit', "#new-bufete", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));

    let nombre_bufete = $('#nombre_bufete').val();
    let correo = $('#correo').val();
    let rif = $('#rif').val();
    let telefono = $('#telefono').val();

        let datos_audiencia = {
            "nombre_bufete": nombre_bufete,
            "correo": correo,
            "rif": rif,
            "telefono": telefono
        };

        $.ajax({
            type: "POST",
            url: "http://172.16.0.46:70/bufetes",
            data: JSON.stringify(datos_audiencia),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}`
            },
            success: function(response) {
                Swal.fire('Exito!', "Registro exitoso", "success");
                setTimeout(function() {
                    window.location = '/vista_Bufetes_audiencias';
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', "Error al Insertar el registro", "error");
                console.error(xhr.responseText);
            }
        });
    
});





// Método para abrir el modal para la edición
$('#listar_bufetes').on('click', '.Editar', function(e) {
    e.preventDefault(); // Evitar el comportamiento por defecto del clic



    var id = $(this).attr('id');
    var nombre_bufete = $(this).attr('nombre_bufete');
    var rif = $(this).attr('rif');
    var correo_bufete = $(this).attr('correo_bufete');
    var telefono_bufete = $(this).attr('telefono_bufete');
    if (telefono_bufete=='null') 
    {
        telefono_bufete='';
    }
    var id_condicion = $(this).attr('id_condicion');

    if (id_condicion == 1) {
        $('#id_condicion').attr('checked', 'checked');
        $('#id_condicion').val(false);
    }
    else if (id_condicion == 2) {
        $('#id_condicion').removeAttr('checked')
        $('#id_condicion').val(true)
    }

    $("#editar").modal("show");
    $('#editar').find('#id_bufete').val(id);
    $('#editar').find('#edit_nombre_bufete').val(nombre_bufete);
    $('#editar').find('#edit_rif').val(rif); 
    $('#editar').find('#edit_correo').val(correo_bufete);
    $('#editar').find('#edit_telefono_bufete').val(telefono_bufete);
    
});

// Evento para guardar la  editada
$(document).on('submit', "#edit-bufete", function(e) {
    e.preventDefault();

    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id = $('#id_bufete').val();
    let nombre_bufete = $('#edit_nombre_bufete').val(); 
    let rif = $('#edit_rif').val(); 
    let correo_bufete = $('#edit_correo').val();
    let telefono = $('#edit_telefono_bufete').val();

    let id_condicion = $("#id_condicion").is(':checked');
    if (id_condicion) {
        // El checkbox está marcado
        id_condicion = 1;
    } else {
        // El checkbox no está marcado
        id_condicion = 2;
    }

    let datos_audiencia = {
        "nombre_bufete": nombre_bufete,
        "correo": correo_bufete,
        "rif": rif,
        "telefono": telefono,
        "id_condicion": id_condicion,
    };

        //console.log(JSON.stringify(datos_audiencia));
        $.ajax({
            type: "PUT",
            url: "http://172.16.0.46:70/bufetes/"+id,
            data: JSON.stringify(datos_audiencia),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}`
            },
            success: function(response) {
                Swal.fire('Exito!', "Registro Actualizado", "success");
                setTimeout(function() {
                    window.location = '/vista_Bufetes_audiencias';
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', "Error al Insertar el registro", "error");
                console.error(xhr.responseText);
            }
        });
    
});
    
   // }
//});



$(document).on('input', '#correo', function(e) {
    let texto = $("#correo").val();
    
    // Validación del formato de correo
    if (!texto.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/) || texto.length < 5) {
        $("#correo").addClass('is-invalid').removeClass('is-valid');
        $("button[type=submit]").attr('disabled', true);
    } else {
        $("#correo").removeClass('is-invalid').addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});

$(document).on('input', '#edit_correo', function(e) {
    let texto = $("#edit_correo").val();
    
    // Validación del formato de edit_correo
    if (!texto.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/) || texto.length < 5) {
        $("#edit_correo").addClass('is-invalid').removeClass('is-valid');
        $("button[type=submit]").attr('disabled', true);
    } else {
        $("#edit_correo").removeClass('is-invalid').addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});

