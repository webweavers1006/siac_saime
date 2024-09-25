$(function() {

   
    let id_caso = $('#id-caso').val();
    $('#add-seguimiento').find('#actualizar_seguimiento').hide();
    listar_seguimientos(id_caso);
    buscar_documentos_casos();

});



$('#add-seguimiento').on('show.bs.modal', function (event) {
    // Limpiar los campos del formulario
    $('#estatus-llamadas').val(1);
    $('#seguimiento-comentario').val('');
    
  });

/*
 * Función para definir datatable de usuarios:
 */
function listar_seguimientos(id_caso) {
    let rol_usuario=$('#rol_usuario').val();
    let id_usuario=$('#id_usuario').val();
    $('#table_seguimientos').DataTable({
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
            "url": "/listar_Seguimientos/" + id_caso,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            //{ data: 'idcaso' },
            { data: 'idsegcas' },
            { data: 'fecha_segui' },
            { data: 'desc_est_llamada' },
            { data: 'user_name' },
            { data: 'segcoment' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {


                if(rol_usuario==5 || rol_usuario==1){
                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' + ' ' +
                    '<a href="javascript:;" class="btn btn-xs btn-light Bloquear" style=" font-size:1px" data-toggle="tooltip" title="Eliminar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '"> <i class="material-icons " >delete</i > < /a>'
                }else {

                   if(data.idusuopr==id_usuario)
                    {
                        return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' 
                    }else
                    {
                        return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar disabled " style=" font-size:1px" data-toggle="tooltip" title="Editar" idsegcas="' + row.idsegcas + '"  idestllam="' + row.idestllam + '"   segcoment="' + row.segcoment + '" > <i class="material-icons " >create</i></a>' 
                    }
                    
         
                }

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

$(document).on('submit', "#new-seguimiento", function(e) {
        e.preventDefault();
        let datos = {
            "callid": $("#estatus-llamadas").val(),
            "segcomment": $("#seguimiento-comentario").val(),
            "caseid": $("#id-caso").val()
        }
        if (datos.segcomment.lenght < 1) {
            Swal.fire("Atencion", "Debe añadir obligatoriamente un comentario", "error");
        } else {
            $.ajax({
                 url: "/addSeguimiento",
                method:'POST',
                data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(datos))))},
                dataType:'JSON',
                beforeSend: function() {
                    $("button[type=submit]").attr('disabled', 'true');
                }
            }).then((response) => {
                Swal.fire('Exito', response.message, "success");
                $("#new-seguimiento")[0].reset();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error", request.responseJSON.message, "error");
            });
            $("button[type=submit]").removeAttr('disabled');
            setTimeout(function() {
                location.reload();
            }, 1500);

            $("#add-seguimiento").modal('hide');
        }
    })
    //METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_seguimientos').on('click', '.Editar', function(e) {
    e.preventDefault();
    let idsegcas = $(this).attr('idsegcas');
    let idestllam = $(this).attr('idestllam');
    let segcoment = $(this).attr('segcoment');
    $("#add-seguimiento").modal("show");
    $('#add-seguimiento').find('#estatus-llamadas').val(idestllam);
    $('#add-seguimiento').find('#seguimiento-comentario').val(segcoment);
    $('#add-seguimiento').find('#actualizar_seguimiento').show();
    $('#add-seguimiento').find('#agregar_seguimiento').hide();
    $('#add-seguimiento').find('#idsegcas').val(idsegcas);
})


//Evento para actualizar un seguimiento
$(document).on("click", "#actualizar_seguimiento", (e) => {
    e.preventDefault()
    let datos = {
        "callid": $("#estatus-llamadas").val(),
        "segcomment": $("#seguimiento-comentario").val(),
        "caseid": $("#id-caso").val(),
        "idsegcas": $("#idsegcas").val()
    }
    if (datos.segcomment.lenght < 1) {
        Swal.fire("Atencion", "Debe añadir obligatoriamente un comentario", "error");
    } else {
        $.ajax({
            url: "/actualizar_Seguimiento",
            method: "POST",
            dataType: "JSON",
            data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(datos))))},
            beforeSend: function() {
                $("button[type=submit]").attr('disabled', 'true');
            }
        }).then((response) => {
            Swal.fire('Exito', response.message, "success");
            $("#new-seguimiento")[0].reset();
            setTimeout(function() {
                location.reload();
            }, 1500);
        }).catch((request) => {
            Swal.fire("Error", request.responseJSON.message, "error");
        });
        $("button[type=submit]").removeAttr('disabled');
        setTimeout(function() {
            location.reload();
        }, 1500);

        $("#add-seguimiento").modal('hide');
    }
});















//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_seguimientos').on('click', '.Bloquear', function(e) {
    let idsegcas = $(this).attr('idsegcas');
    let borrado = 'true'
    let datos = {
        idsegcas: idsegcas,
        borrado: borrado
    }
    Swal.fire({
        title: '¿Deseas Eliminar el Registro?',
        text: 'El registro será eliminado del Sitema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            // Aquí puedes agregar la lógica para salir de la página
            $.ajax({
                url: "/eliminar_seguimiento",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(JSON.stringify(datos))
                },
                beforeSend: function() {

                }
            }).then((response) => {
                Swal.fire('Exito!', "Caso eliminado exitosamente", "success");
                $("#editUser").modal('hide');

                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            });

        }
    });
});




//FUNCION PARA LLENAR EL COMBO DE LOS MUNICIPIOS EN FUNSION DEL ID DEL ESTADO
function buscar_documentos_casos(e) {

let idcaso = $('#id-caso').val();

let datos = {
    idcaso: idcaso,
};
$.ajax({
        url: "/buscar_documentos_casos",
        method: "POST",
        dataType: "JSON",
        data: {
            data: btoa(JSON.stringify(datos)),
        },
    })
    .then((response) => {
        $("#docu-casos").html(response.data);

    })
    .catch((request) => {
        $("#docu-casos").val(0);
        Swal.fire("Error", response.JSONmessage, "Error");
    });

}

var selectElement = document.getElementById('docu-casos');
selectElement.addEventListener('change', function() {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var url = selectedOption.text;
    var ruta = '../documentos_casos/' + url; // Reemplaza "
    window.open(ruta, "_blank");
});







