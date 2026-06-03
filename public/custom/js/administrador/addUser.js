$(function() {
    listar_usuarios();
    llenar_combo_roles(Event, undefined);
    llenar_combo_direcciones(Event, undefined);
});

// FUNCION PARA LLENAR EL COMBO DE LOS ROLES
function llenar_combo_roles(e, id) {
    e.preventDefault;
    url = '/listar_Combo_Roles';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length >= 1) {
                $('#edit-user-rol').empty();
                $('#edit-user-rol').append('<option value=0 selected disabled>Seleccione</option>');
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        $('#edit-user-rol').append('<option value=' + item.idrol + '>' + item.rolnom + '</option>');
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.idrol === id) {
                            $('#edit-user-rol').append('<option value=' + item.idrol + ' selected>' + item.rolnom + '</option>');
                        } else {
                            $('#edit-user-rol').append('<option value=' + item.idrol + '>' + item.rolnom + '</option>');
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error('Error al cargar roles:', errorThrown);
        }
    });
}

// FUNCION PARA LLENAR EL COMBO DE DIRECCIONES
function llenar_combo_direcciones(e, id) {
    const url = '/listar_direcciones_administrativas/';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length >= 1) {
                $('#id_direccion_administrativa').empty();
                $('#id_direccion_administrativa').append('<option value="0" selected disabled>Seleccione</option>');

                $('#edit_direccion_administrativa').empty();
                $('#edit_direccion_administrativa').append('<option value="0" selected disabled>Seleccione</option>');

                $.each(data, function(i, item) {
                    if (item.correo !== null) {
                        if (id !== undefined && item.id === id) {
                            $('#id_direccion_administrativa').append('<option value="' + item.id + '" selected>' + item.descripcion + '</option>');
                            $('#edit_direccion_administrativa').append('<option value="' + item.id + '" selected>' + item.descripcion + '</option>');
                        } else {
                            $('#id_direccion_administrativa').append('<option value="' + item.id + '">' + item.descripcion + '</option>');
                            $('#edit_direccion_administrativa').append('<option value="' + item.id + '">' + item.descripcion + '</option>');
                        }
                    }
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            console.error('Error al cargar direcciones:', status, errorThrown);
        }
    });
}

// FUNCION PARA DEFINIR DATATABLE DE USUARIOS
function listar_usuarios() {
    $('#table_usuarios').DataTable({
        responsive: true,
        "order": [[0, "asc"]],
        "paging": true,
        "info": true,
        "filter": true,
        "autoWidth": true,
        "ajax": {
            "url": "/Get_All_Usuarios",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            { data: 'idusuopr' },
            { data: 'usuopnom' },
            { data: 'usuopape' },
            { data: 'rolnom' },
            { data: 'usuopemail' },
            { data: 'usercargo' },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    if (row.usuopborrado == 'f') {
                        return '<span class="btnactivo">Activo</span>';
                    } else {
                        return '<span class="btninnactivo">Inactivo</span>';
                    }
                }
            },
            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style="font-size:1px" data-toggle="tooltip" title="Editar" id_direccion_administrativa=' + row.id_direccion_administrativa + ' usuoppass=' + row.usuoppass + ' usuopemail="' + row.usuopemail + '" idusuopr=' + row.idusuopr + ' usuopnom="' + row.usuopnom + '" usuopape=' + row.usuopape + ' idrol=' + row.idrol + ' borrado=' + row.usuopborrado + ' usercargo="' + row.usercargo + '"> <i class="material-icons">create</i></a>' +
                        ' <a href="javascript:;" class="btn btn-xs btn-light Bloquear" style="font-size:1px" data-toggle="tooltip" title="Bloquear" idusuopr=' + row.idusuopr + '> <i class="material-icons">delete</i></a>';
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
            }]
        }
    });
}

// Verificación de contraseñas iguales al agregar
$(document).on('keyup', "#user-confirm-pass", function(e) {
    e.preventDefault();
    let pass = $("#user-confirm-pass").val();
    if ($("#user-pass").val() != pass) {
        $("#user-pass").addClass('is-invalid');
        $("#user-confirm-pass").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#user-pass").removeClass('is-invalid');
        $("#user-confirm-pass").removeClass('is-invalid');
        $("#user-pass").addClass('is-valid');
        $("#user-confirm-pass").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});

// EVENTO PARA AGREGAR UN USUARIO
$(document).on('submit', "#new-user", function(e) {
    e.preventDefault();
    let id_direccion_administrativa = $("#id_direccion_administrativa").val();
    let clave_actual = $("#user-pass").val();

    if (clave_actual.length < 8) {
        alert('LA CONTRASEÑA DEBE TENER MÍNIMO 8 CARACTERES');
        return;
    }

    if (id_direccion_administrativa == '' || id_direccion_administrativa == null) {
        alert('DEBE SELECCIONAR LA DIRECCIÓN ADMINISTRATIVA');
        return;
    }

    let datos = {
        "username": $("#user-name").val(),
        "userlastname": $("#user-lastname").val(),
        "useremail": $("#user-email").val(),
        "userrol": $("#user-rol").val(),
        "userpass": $("#user-pass").val(),
        "usercargo": $("#usercargo").val(),
        "acceso_audi": false,
        "id_direccion_administrativa": id_direccion_administrativa
    };

    $.ajax({
        url: "/addNewUser",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(unescape(encodeURIComponent(JSON.stringify(datos))))
        },
        success: function(mensaje) {
            if (mensaje === 0) {
                Swal.fire({
                    icon: "error",
                    html: '<strong>Error!! El Usuario ya Existe</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false
                });
                setTimeout(function() { window.location = "/adminUsers"; }, 1500);
            } else if (mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    html: '<strong>Usuario Registrado Exitosamente</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false
                });
                setTimeout(function() { window.location = "/adminUsers"; }, 1500);
            } else {
                Swal.fire({
                    icon: "error",
                    html: '<strong>Ocurrió un error al registrar el Usuario</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false
                });
                setTimeout(function() { window.location = "/adminUsers"; }, 1500);
            }
        }
    });
});

// METODO PARA ABRIR EL MODAL DE EDICIÓN
$('#listar_usuarios').on('click', '.Editar', function(e) {
    var idusuopr = $(this).attr('idusuopr');
    var usuopnom = $(this).attr('usuopnom');
    var usuopape = $(this).attr('usuopape');
    var usuopemail = $(this).attr('usuopemail');
    var usuoppass = $(this).attr('usuoppass');
    var usuopborrado = $(this).attr('borrado');
    var usercargo = $(this).attr('usercargo');
    var id_direccion_administrativa = $(this).attr('id_direccion_administrativa');
    var id = $(this).attr('idrol');

    if (usercargo == 'null') {
        usercargo = '';
    }

    var rol_usuario_sesion = $('#nivel_usuario').val();

    if (id == 5 && rol_usuario_sesion != 5) {
        alert('No posee los permisos necesarios para realizar esta acción');
        return;
    }

    llenar_combo_roles(e, parseInt(id));
    llenar_combo_direcciones(e, parseInt(id_direccion_administrativa));

    $("#editUser").modal("show");
    $('#editUser').find('#edit-user-name').val(usuopnom);
    $('#editUser').find('#edit-user-lastname').val(usuopape);
    $('#editUser').find('#edit-user-email').val(usuopemail);
    $('#editUser').find('#userid').val(idusuopr);
    $('#editUser').find('#edit-user-pass').val(usuoppass);
    $('#editUser').find('#edit-user-confirm-pass').val(usuoppass);
    $('#editUser').find('#clave-anterior').val(usuoppass);
    $('#editUser').find('#cargo').val(usercargo);

    estatus_borrado = false;
    if (usuopborrado == 'f') {
        $('#usuopborrado').attr('checked', 'checked');
        $('#usuopborrado').val(false);
    }
    if (usuopborrado == 't') {
        $('#usuopborrado').removeAttr('checked');
        $('#usuopborrado').val(true);
    }
});

// METODO QUE TOMA EL ESTATUS ACTUAL DEL CHECKBOX
$('#usuopborrado').click(function() {
    if ($('#usuopborrado').is(':checked')) {
        estatus_borrado = false;
    } else {
        estatus_borrado = true;
    }
});

let cambiar_clave = 'false';
$('#cambiar-clave').click(function() {
    if ($('#cambiar-clave').is(':checked')) {
        $('#modulo-claves').show();
        cambiar_clave = 'true';
    } else {
        cambiar_clave = 'false';
        $('#modulo-claves').hide();
    }
});

// Validación genérica de email (sin restricción de dominio)
$(document).on('change', '#edit-user-email', function(e) {
    let texto = $("#edit-user-email").val();
    if (texto.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/) == null) {
        $("#edit-user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.length < 5) {
        $("#edit-user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#edit-user-email").removeClass('is-invalid');
        $("#edit-user-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});

$(document).on('change', '#user-email', function(e) {
    let texto = $("#user-email").val();
    if (texto.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/) == null) {
        $("#user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.length < 5) {
        $("#user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#user-email").removeClass('is-invalid');
        $("#user-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});

// EVENTO PARA GUARDAR EL USUARIO EDITADO
$(document).on('submit', "#edit-user", function(e) {
    e.preventDefault();
    let clave_actual = $("#edit-user-pass").val().trim();
    let clave_anterior = $("#clave-anterior").val();
    let usercargo = $("#cargo").val();

    if (clave_actual.length < 8) {
        alert('LA CONTRASEÑA DEBE TENER MÍNIMO 8 CARACTERES');
        return;
    }

    if (cambiar_clave == 'true') {
        clave_actual = clave_actual.trim();
        if (clave_anterior == clave_actual) {
            $("#edit-user-pass").addClass('is-invalid');
            alert('ERROR! LA CONTRASEÑA DEBE SER DIFERENTE A LA ANTERIOR');
            return;
        }
        $("#edit-user-pass").removeClass('is-invalid');
        $("#edit-user-confirm-pass").removeClass('is-invalid');
    }

    let datos = {
        "username": $("#edit-user-name").val(),
        "userlastname": $("#edit-user-lastname").val(),
        "useremail": $("#edit-user-email").val(),
        "userrol": $("#edit-user-rol").val(),
        "userid": $("#userid").val(),
        "id_direccion_administrativa": $("#edit_direccion_administrativa").val(),
        "usercargo": usercargo,
        "usuoppass": clave_actual,
        "usuopborrado": estatus_borrado,
        "modulo_clave": cambiar_clave,
        "acceso_audi": false
    };

    $.ajax({
        url: "/editUser",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(unescape(encodeURIComponent(JSON.stringify(datos))))
        },
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', "true");
        }
    }).then((response) => {
        Swal.fire('Éxito!', "Usuario editado exitosamente", "success");
        $("#editUser").modal('hide');
        $("button[type=submit]").removeAttr('disabled');
        setTimeout(function() {
            window.location = '/adminUsers/';
        }, 1500);
    }).catch((request) => {
        Swal.fire("Error!", "Ha ocurrido un error", "error");
        $("button[type=submit]").removeAttr('disabled');
        setTimeout(function() {
            window.location = '/adminUsers/';
        }, 1600);
    });
});

// METODO PARA BLOQUEAR UN USUARIO
$('#listar_usuarios').on('click', '.Bloquear', function(e) {
    var idusuopr = $(this).attr('idusuopr');
    let usuopborrado = 'true';
    let datos = {
        idusuopr: idusuopr,
        usuopborrado: usuopborrado
    };
    Swal.fire({
        title: '¿Deseas Bloquear el Registro?',
        text: 'El registro será bloqueado del Sistema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/Bloquear_User",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(unescape(encodeURIComponent(JSON.stringify(datos))))
                }
            }).then((response) => {
                Swal.fire('Éxito!', "Usuario Bloqueado exitosamente", "success");
                setTimeout(function() {
                    window.location = '/adminUsers/';
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
                setTimeout(function() {
                    window.location = '/adminUsers/';
                }, 1600);
            });
        }
    });
});
