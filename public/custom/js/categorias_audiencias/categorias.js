$(function() {
    listar_categorias_audiencias();
});



const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
/*
 * Función para definir datatable:
 */
function listar_categorias_audiencias() {
    $('#table_categorias').DataTable({
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
            "url": "https://siac.sapi.gob.ve/api/audiencia/categorias", // URL correcta
            "type": "GET",
            headers: {
                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
            },
            dataSrc: 'categorias' // Cambiado para que apunte a la clave correcta en la respuesta JSON
        },
        "columns": [
            { data: 'id' },
            { data: 'categoria' },
            { data: 'departamento' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar"  id_cierre=' + row.cierre + ' id_condicion=' + row.id_condicion + ' id=' + row.id + ' categoria="' + row.categoria + '"  departamento="' + row.id_departamento + '"> <i class="material-icons">create</i></a>'
                   
                    
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
$(document).on('submit', "#new-categoria", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id_departamento=$('#id_departamento').val();
    let id_cierre=$('#id_cierre').val();


    if (id_departamento==0||id_departamento=='0') 
    {
        alert('Debe seleccionar el departamento ');
        
    }
    else if (id_cierre==0||id_cierre=='0') 
        {
            alert('El campo Categoria de cierre , es requerido');
            
        }
    
    else
    {
        let datos_audiencia = {
            "categoria": $('#name-categoria').val().trim(),
            "id_departamento":id_departamento,
            "cierre":id_cierre
        };
       
         $.ajax({
        type: "POST",
        url: "https://siac.sapi.gob.ve/api/audiencia/categorias",
        data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(response) {
            Swal.fire('Exito!', "Registro exitoso", "success");

            setTimeout(function() {
                window.location = '/vista_Categorias_audiencias';
            }, 1500);
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', "Error al Insertar el registro", "error");
            console.error(xhr.responseText);
        }
    });

    }
    
    
  

   
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_categorias').on('click', '.Editar', function(e) {
    var id = $(this).attr('id');
    var categoria = $(this).attr('categoria');
    var departamento = $(this).attr('departamento');
    var id_condicion = $(this).attr('id_condicion');
    var id_cierre = $(this).attr('id_cierre');

    if (id_condicion == 1) {
        $('#id_condicion').attr('checked', 'checked');
        $('#id_condicion').val(false);
    }
    else if (id_condicion == 2) {
        $('#id_condicion').removeAttr('checked')
        $('#id_condicion').val(true)
    }


    $("#editar").modal("show");
    $('#editar').find('#editar-categoria').val(categoria);
    $('#editar').find('#id-categoria').val(id);
    $('#editar').find('#edit_id_departamento').val(departamento);
    $('#editar').find('#edit_id_cierre').val(id_cierre);

   
});


// Evento para guardar la direccion editada
$(document).on('submit', "#edit-categoria", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id = $("#id-categoria").val();

    
    
    let id_condicion = $("#id_condicion").is(':checked');
    if (id_condicion) {
        // El checkbox está marcado
        id_condicion = 1;
    } else {
        // El checkbox no está marcado
        id_condicion = 2;
    }
    


 
    let datos_audiencia = {
        "categoria": $('#editar-categoria').val(),
        "id_departamento": $('#edit_id_departamento').val(),
        "id_condicion": id_condicion,
        "cierre": $('#edit_id_cierre').val(),
    };

    $.ajax({
        type: "PUT",
        url: "https://siac.sapi.gob.ve/api/audiencia/categorias/" + id,
        data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
        },
        success: function(response) {
            Swal.fire('Exito!', "REGISTRO ACTUALIZADO", "success");

            setTimeout(function() {
                window.location = '/vista_Categorias_audiencias';
            }, 1500);
        },
        error: function(xhr, status, error) {
            Swal.fire('Error!', "Error al actualizar el registro", "error");
            console.error(xhr.responseText);
        }
     });
});





  

