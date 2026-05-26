$(document).ready(function () {
    if (typeof listar_linea_estrategica === 'function') {
        listar_linea_estrategica();
    }
});

let table;

function listar_linea_estrategica() {
    if ($.fn.DataTable.isDataTable('#table_linea_estrategica')) {
        $('#table_linea_estrategica').DataTable().clear().destroy();
    }

    table = $('#table_linea_estrategica').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        paging: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '/listar_linea_estrategica',
            type: 'GET',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'descripcion' },
            { data: 'borrado_label' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary btn-edit" 
                                data-id="${row.id}" 
                                data-desc="${row.descripcion}" 
                                data-borrado="${row.borrado_label === 'Activo' ? false : true}"
                                data-toggle="tooltip" 
                                title="Editar">
                            <i class="material-icons">create</i> 
                        </button>
                    `;
                }
            }
        ],
        language: {
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
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
            }
        }
    });
}

$(document).ready(function () {
    // Agregar
    $('#new-linea-estrategica').on('submit', function (e) {
        e.preventDefault();

        let descripcion = $('#linea-estrategica-descripcion').val().trim();
        
        let datos = {
            descripcion: descripcion
        };

        $.ajax({
            url: '/add_linea_estrategica',
            method: 'POST',
            dataType: 'json',
            data: {
                data: btoa(JSON.stringify(datos))
            },
            success: function (resp) {
                const codigo = (typeof resp === 'object') ? parseInt(resp?.mensaje) : parseInt(resp);

                if (codigo === 1) {
                    $('#add-linea-estrategica').modal('hide');
                    $('#new-linea-estrategica')[0].reset();
                    if (typeof listar_linea_estrategica === 'function') listar_linea_estrategica();

                    Swal.fire({
                        icon: "success",
                        type: 'success',
                        html: '<strong>Registro Exitoso</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        window.location.href = "/linea_estrategica";
                    }, 1500);

                } else if (codigo === 2) {
                    Swal.fire({
                        icon: "error",
                        type: 'error',
                        html: '<strong>Hubo un error al insertar el registro</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        window.location.href = "/linea_estrategica";
                    }, 1500);
                }
            }
        });
    });

    // Editar: llenamos modal
    $('#table_linea_estrategica').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        const desc = $(this).data('desc');
        const borrado = $(this).data('borrado');

        $('#id-linea-estrategica').val(id);
        $('#linea-estrategica-descripcion-edit').val(desc);

        const isActivo = !borrado;
        $('#borrado-edit').prop('checked', isActivo);
        $('#borrado-edit').val(String(isActivo));

        $('#edit-linea-estrategica').modal('show');
    });

    // Guardar edición
    $('#edit-linea-estrategica-form').on('submit', function (e) {
        e.preventDefault();

        let id = parseInt($('#id-linea-estrategica').val());
        let descripcion = $('#linea-estrategica-descripcion-edit').val().trim();
        
        // EVALUACIÓN INVERTIDA: 
        // Si está marcado (:checked es true) enviamos false (Activo)
        // Si está desmarcado (:checked es false) enviamos true (Inactivo / Borrado)
        let borrado = !$('#borrado-edit').is(':checked');

        let datos = {
            id: id,
            descripcion: descripcion,
            borrado: borrado
        };

        $.ajax({
            url: '/edit_linea_estrategica',
            method: 'POST',
            dataType: 'json',
            data: {
                data: btoa(JSON.stringify(datos))
            },
            success: function (resp) {
                const codigo = (typeof resp === 'object') ? parseInt(resp?.mensaje) : parseInt(resp);

                if (codigo === 1) {
                    $('#edit-linea-estrategica').modal('hide');
                    if (typeof listar_linea_estrategica === 'function') listar_linea_estrategica();

                    Swal.fire({
                        icon: "success",
                        type: 'success',
                        html: '<strong>Registro Actualizado Exitosamente</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        window.location.href = "/linea_estrategica";
                    }, 1500);

                } else if (codigo === 2) {
                    Swal.fire({
                        icon: "error",
                        type: 'error',
                        html: '<strong>Hubo un error al actualizar el registro</strong>',
                        toast: true,
                        position: "center",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(function() {
                        window.location.href = "/linea_estrategica";
                    }, 1500);
                }
            }
        });
    });

    // Eliminar lógica
    $('#table_linea_estrategica').on('click', '.btn-del', function () {
        const id = $(this).data('id');

        if (!confirm('¿Deseas eliminar lógicamente este registro?')) return;

        let datos = {
            id: id
        };

        $.ajax({
            url: '/delete_linea_estrategica',
            method: 'POST',
            dataType: 'json',
            data: {
                data: btoa(JSON.stringify(datos))
            },
            success: function (resp) {
                if (resp === 1 || resp?.mensaje === 1) {
                    listar_linea_estrategica();
                }
            }
        });
    });
});