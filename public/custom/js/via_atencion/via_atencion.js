$(function() {
    listar_via_de_atencion();
   listar_checkbox_tipo_atencion();
});

/*
 * Función para definir datatable:
 */
function listar_via_de_atencion() {
    $('#table_via_atencion').DataTable({
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
            "url": "/Listar_Via_Atencion/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'red_s_id' },
            { data: 'red_s_nom' },
            { data: 'borrado' },


            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"     red_s_id=' + row.red_s_id + '    red_s_nom="' + row.red_s_nom + '"     borrado=' + row.borrado + ' > <i class="material-icons " >create</i></a>'

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
$(document).on('submit', "#new-via-atencion", function(e) {
    e.preventDefault();
    let red_s_nom = $("#name-via-atencion").val();
    red_s_nom = red_s_nom.trim();
    let datos = {
        "red_s_nom": red_s_nom,
    }


    $.ajax({
        url: "/add_Via_Atencion",
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
                    window.location = "/vista_via_atencion";
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
                    window.location = "/vista_via_atencion";
                }, 1500);
            }
        }
    });
})


//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_via_atencion').on('click', '.Editar', function(e) {
    var red_s_id = $(this).attr('red_s_id');
    var red_s_nom = $(this).attr('red_s_nom');
    var borrado = $(this).attr('borrado');
    $("#editar").modal("show");
    // Limpia todos los checkboxes dentro del modal

    $('#editar').find('#editar-viaatencion').val(red_s_nom);
    $('#editar').find('#id-viaatencion').val(red_s_id);

    if (borrado == 'Activo') {
        $('#borrado').attr('checked', 'checked');
        $('#borrado').val('false');
    }
    if (borrado == 'Inactivo') {
        $('#borrado').removeAttr('checked')
        $('#borrado').val('true')
    }
    marcar_checkbox(red_s_id);

});
// // //Evento para guardar la edicion
const botonRiegos = document.querySelectorAll(".btnActualizar");
for (const boton of botonRiegos) {
    boton.addEventListener("click", function() {

    let red_s_nom = $("#editar-viaatencion").val();
    let borrado = $("#borrado").val();
    let red_s_id = $("#id-viaatencion").val();
    if ($('#borrado').is(':checked')) {
        borrado = 'false';

    } else {
        borrado = 'true';

    }
    let id_Via_Atencion = $('#id-viaatencion').val();
    const checkboxes = document.getElementsByName("tipoatencion"); // Cambiado a tipoatencion
     // Recorremos los checkbox y verificamos cuáles están seleccionados
    const selectedValues = [];
    for (const checkbox of checkboxes) {
        if (checkbox.checked) {
            selectedValues.push(checkbox.value);
        }
    }
    url='/buscar_hijos_via_atencion/'+id_Via_Atencion,
    $.ajax
    ({
        url:url,
        method:'GET',
        dataType:'JSON',
        beforeSend:function(data)
        {
        },
        success:function(data)
        {  

           
           let initialCheckboxValues = []; 
           for (let j = 0; j < data.length; j++)
              {
                initialCheckboxValues.push(data[j].tipo_atencion_id);  
              }
              valor=initialCheckboxValues;
             
              //OBTENEMOS LOS VALORES ELIMINADOS , SI LOS HAY 
              const deletedElements = valor.reduce((acc, element) => {
                if (!selectedValues.includes(element)) {
                  acc.push(element);
                }
                return acc;
              }, []);     

            let datos = 
            {
                "red_s_nom": red_s_nom,
                "borrado": borrado,
                "red_s_id": red_s_id,
                "selectedValues": selectedValues,
                "deletedElements": deletedElements,

            }
 
             $.ajax({
                    url: "/editViaAtencion",
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
                                window.location = "/vista_via_atencion";
                            }, 1500);
                        } else if (mensaje === 2) {
                            alert('REGISTRO ACTUALIZADO');
                            location.reload();
                        }
                    }
                });

        }
        });

     });

}



function marcar_checkbox(red_s_id) {  
    data = '';    
    url = '/buscar_hijos_via_atencion/' + red_s_id;

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {
            // Puedes agregar aquí un loading spinner o alguna otra acción antes de la petición
        },
        success: function(data) {   
            const checkboxes = document.getElementsByName('tipoatencion');
            
            // Primero, desmarcar todos los checkboxes
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }

            // Iterar sobre cada casilla de verificación
            for (let i = 0; i < checkboxes.length; i++) {
                const checkbox = checkboxes[i];
                
                // Iterar sobre cada objeto de datos
                for (const dataItem of data) {
                    const id = dataItem.tipo_atencion_id; // Ajusta el nombre de la propiedad si es necesario
                    
                    // Si el ID coincide con el valor de la casilla de verificación, marcarla como seleccionada
                    if (checkbox.value === id) {
                        checkbox.checked = true;
                        break; // Salir del bucle si se encuentra una coincidencia
                    }
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}


function listar_checkbox_tipo_atencion(data) {
    const url = '/Listar_Tipo_Atencion_filtro';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {
            // Puedes agregar un loader o algo similar aquí
        },
        success: function(data) {
            const TipoAtencionContainer = document.getElementById('check_tipo_atencion');
            TipoAtencionContainer.innerHTML = ''; // Limpiar el contenedor

            // Almacenar valores iniciales (opcional)
            let initialCheckboxValues = [];

            data.forEach(tipoatencion => {
                const checkboxId = `tipoatencion-${tipoatencion.tipo_aten_id}`;
                const checkboxHtml = `
                    <input type="checkbox" id="${checkboxId}" name="tipoatencion" value="${tipoatencion.tipo_aten_id}">
                    <label for="${checkboxId}">${tipoatencion.tipo_aten_nombre}</label><br>
                `;
                TipoAtencionContainer.innerHTML += checkboxHtml; // Agregar checkbox al contenedor
            });

            
        },
        error: function(xhr, status, errorThrown) {
            console.error("Error al cargar los tipos de atención:", errorThrown);
            alert("Ocurrió un error al cargar los tipos de atención. Inténtalo de nuevo más tarde.");
        }
    });
}

