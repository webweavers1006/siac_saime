$(function() {
    listar_usuarios_areas();
let id_usuario=null;
    llenar_usuarios(Event,id_usuario);
});



const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));


/*
 * Función para definir datatable:
 */
function listar_usuarios_areas() {
    $('#table_usuarios_areas').DataTable({
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
            "url": "http://172.16.0.46:70/usuarios_areas", // URL correcta
            "type": "GET",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
            },
            dataSrc: 'usuariosareas' // Cambiado para que apunte a la clave correcta en la respuesta JSON
        },
        "columns": [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'area' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar" id_usuario=' + row.id_usuario + ' id=' + row.id + ' id_area=' + row.id_area + ' nombre="' + row.nombre + '" director="' + row.director + '" > <i class="material-icons">create</i></a>'
                   
                    
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
// //EVENTO PARA AGREGAR UN ROL 
$(document).on('submit', "#new-usuario-area", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));

    let id_usuario = $('#id_usuario').val();
    let id_area = $('#id_area').val();
    let id_director = $('#id_director').val();

    if (id_usuario == 0 || id_usuario == '0' || id_usuario == null) {
        alert('Debe seleccionar el Usuario');
    } else if (id_area == 0 || id_area == '0') {
        alert('Debe seleccionar el Area');
    } else if (id_director == 0 || id_director == '0') {
        alert('Debe seleccionar el Director');
    } else {
        let datos_audiencia = {
            "id_usuario": id_usuario,
            "id_area": id_area,
            "director": id_director
        };

        $.ajax({
            type: "POST",
            url: "http://172.16.0.46:70/usuarios_areas",
            data: JSON.stringify(datos_audiencia),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}`
            },
            success: function(response) {
                Swal.fire('Exito!', "Registro exitoso", "success");
                setTimeout(function() {
                    window.location = '/vista_Usuario_Areas_audiencias';
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', "Error al Insertar el registro", "error");
                console.error(xhr.responseText);
            }
        });
    }
});


// FUNCION PARA LLENAR EL COMBO DE LOS USUARIOS
function llenar_usuarios(e, id_usuario) {
    // Llamar a preventDefault como función (si es necesario, pero no se ve en el contexto)
    // e.preventDefault(); // Descomentar si 'e' es un evento y necesitas prevenir el comportamiento por defecto

    $.ajax({
        type: "GET",
        url: "http://172.16.0.46:70/usuarios/1/1000",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(data) {
            if (data.usuarios && data.usuarios.length > 0) { // Verificar que data.usuarios existe y tiene elementos
                $('#id_usuario').empty().append('<option value="0" selected disabled>Seleccione</option>');
                $('#edit_id_usuario').empty().append('<option value="0" selected disabled>Seleccione</option>');
                
                $.each(data.usuarios, function(i, item) {
                    // Comprobar si id_usuario es null
                    const selected = (id_usuario !== null && item.id.toString() === id_usuario.toString()) ? 'selected' : '';
                    const option = `<option value="${item.id}" ${selected}>${item.nombre} ${item.apellido}</option>`;
                    
                    $('#id_usuario').append(option);
                    $('#edit_id_usuario').append(option);
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            alert("Error: " + xhr.status + " - " + errorThrown); // Mejorar el mensaje de error
        }
    });
}




// Método para abrir el modal para la edición
$('#listar_usuario_areas').on('click', '.Editar', function(e) {
    e.preventDefault(); // Evitar el comportamiento por defecto del clic

    var id = $(this).attr('id');
    var id_area = $(this).attr('id_area');
    var valor_director = $(this).attr('director');
    var id_usuario = $(this).attr('id_usuario');

    let director;
    if (valor_director === 'true') {
        director = '1';
    } else if (valor_director === 'false') {
        director = '2';
    }

    $("#editar").modal("show");
    $('#editar').find('#edit_id_area').val(id_area);
    $('#editar').find('#edit_id_director').val(director); 
    $('#editar').find('#id_usuario_area').val(id);
    
    llenar_usuarios(Event, id_usuario);
});

// Evento para guardar la dirección editada
$(document).on('submit', "#edit-usuarios_areas", function(e) {
    e.preventDefault();

    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id_usuario = $('#edit_id_usuario').val(); // Cambié de id_usuario a id_usuario_area
    let id_area = $('#edit_id_area').val(); // Cambié de id_area a edit_id_area
    let id_director = $('#edit_id_director').val(); // Cambié de id_area a edit_id_director
    let id_usuario_area = $('#id_usuario_area').val();

    if (id_usuario == 0 || id_usuario == '0' || id_usuario == null) {
            alert('Debe seleccionar el Usuario');
        } else if (id_area == 0 || id_area == '0') {
            alert('Debe seleccionar el Area');
        } else if (id_director == 0 || id_director == '0') {
            alert('Debe seleccionar el Director');
        } else {
            let datos_audiencia = {
                "id_usuario": id_usuario,
                "id_area": id_area,
                "director": id_director
            };

        //console.log(JSON.stringify(datos_audiencia));
        $.ajax({
            type: "PUT",
            url: "http://172.16.0.46:70/usuarios_areas/"+id_usuario_area,
            data: JSON.stringify(datos_audiencia),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}`
            },
            success: function(response) {
                Swal.fire('Exito!', "Registro Actualizado", "success");
                setTimeout(function() {
                    window.location = '/vista_Usuario_Areas_audiencias';
                }, 1500);
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', "Error al Insertar el registro", "error");
                console.error(xhr.responseText);
            }
        });
    }
});
    
   // }
//});





