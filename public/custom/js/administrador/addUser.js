$(function() {
    listar_usuarios();
    let id =''
    let act_aud ='false'
   
    llenar_combo_roles(Event, id);
    llenar_combo_Direcciones_normal(Event, id);
   
   
    

});
//FUNCION PARA LLENAR EL COMBO DE LOS ROLES 
function llenar_combo_roles(e, id) {
    e.preventDefault
    url = '/listar_Combo_Roles';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#edit-user-rol').empty();
                $('#edit-user-rol').append('<option value=0  selected disabled>Seleccione</option>');
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //console.log(data)
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
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}



//FUNCION PARA LLENAR EL COMBO DE DIRECCIONES
function llenar_combo_Direcciones_normal(e,id) {
    e.preventDefault
    url = '/listar_direcciones_administrativas/';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#id_direccion_administrativa').empty();
                $('#id_direccion_administrativa').append('<option value=0  selected disabled>Seleccione</option>');
                $('#edit_direccion_administrativa').empty();
                $('#edit_direccion_administrativa').append('<option value=0  selected disabled>Seleccione</option>');
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        if (item.correo !== null) {
                            $('#id_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                            $('#edit_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                        }
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.descripcion !== null) {
                            if (item.id === id) {
                                $('#id_direccion_administrativa').append('<option value=' + item.id + ' selected>' + item.descripcion + '</option>');
                                $('#edit_direccion_administrativa').append('<option value=' + item.id + ' selected>' + item.descripcion + '</option>');
                                
                            } else {
                                $('#id_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                                $('#edit_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                                
                            }
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}



//FUNCION PARA LLENAR EL COMBO DE DIRECCIONES
function llenar_combo_Direcciones(e,id,act_aud) {
    e.preventDefault
    url = '/listar_direcciones_user_create/'+act_aud;
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $('#id_direccion_administrativa').empty();
                $('#id_direccion_administrativa').append('<option value=0  selected disabled>Seleccione</option>');

                $('#edit_direccion_administrativa').empty();
                $('#edit_direccion_administrativa').append('<option value=0  selected disabled>Seleccione</option>');
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        if (item.correo !== null) {
                            $('#id_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                            $('#edit_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                        }
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.descripcion !== null) {
                            if (item.id === id) {
                                $('#id_direccion_administrativa').append('<option value=' + item.id + ' selected>' + item.descripcion + '</option>');
                                $('#edit_direccion_administrativa').append('<option value=' + item.id + ' selected>' + item.descripcion + '</option>');
                            } else {
                                $('#id_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                                $('#edit_direccion_administrativa').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                            }
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}






/*
 * Función para definir datatable de usuarios:
 */
function listar_usuarios() {
    $('#table_usuarios').DataTable({
        responsive: true,
        "order": [
            [0, "asc"]
        ],
        "paging": true,
        "info": true,
        "filter": true,
        "responsive": true,
        "autoWidth": true,
        //"stateSave":true,
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
                        return '<span id="btnalerta"class="  btnactivo "disabled="disabled">' + 'Activo' + '</span>'
                    } else {
                        return '<span id="btnsolvente"class="btninnactivo "disabled="disabled">' + 'Innactivo' + '</span>'

                    }

                }
            },

            {
                orderable: true,
                data: null,
                render: function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-xs btn-secondary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar"  acceso_audi=' + row.acceso_audi + '  id_direccion_administrativa=' + row.id_direccion_administrativa + '  usuoppass=' + row.usuoppass + '   usuopemail="' + row.usuopemail + '" idusuopr=' + row.idusuopr + ' usuopnom="' + row.usuopnom + '" usuopape=' + row.usuopape + ' idrol=' + row.idrol + '  borrado=' + row.usuopborrado + ' usercargo="' + row.usercargo + '" > <i class="material-icons " >create</i></a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-xs btn-light Bloquear" style=" font-size:1px" data-toggle="tooltip" title="Bloquear" usuoppass=' + row.usuoppass + '   usuopemail="' + row.usuopemail + '" idusuopr=' + row.idusuopr + ' usuopnom="' + row.usuopnom + '" usuopape=' + row.usuopape + ' idrol=' + row.idrol + '> <i class="material-icons " >delete</i > < /a>'
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


//Verificacion si las dos contraseñas son iguales al agregar
$(document).on('keyup', "#user-confirm-pass", (e) => {
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

// //EVENTO PARA AGREGAR UN USUARIO
$(document).on('submit', "#new-user", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id_direccion_administrativa = $("#id_direccion_administrativa").val();
    
    //VERIFICAR SI EL ROL ES DE AUDIENCIAS
    let user_rol = $("#user-rol").val();

    let acceso_audi = $("#acceso_audi").is(':checked');

    if (acceso_audi) {
        // El checkbox está marcado
        acceso_audi==true
    } else {
        // El checkbox no está marcado
        acceso_audi==false
    }


    let clave_actual = $("#user-pass").val();

    if (clave_actual.length < 8) 
        {
                alert('LA CONTRASEÑA DEBE TENER MINIMO 8 CARACTERES');
        }
    else 
    {

                if (user_rol ==='9' || acceso_audi==true)
                {

                    
                    let id_rol = $("#id_rol").val();
                    let identificacion = $("#cedula").val();
                    if (id_rol==0 ||id_rol==null) 
                    {
                        alert('Debe seleccionar el nivel del rol');    
                    }else if (identificacion==''||identificacion==null) 
                    {
                        alert('Debe Ingresar el numero de Identificacion');    
                    }
                    else if (id_direccion_administrativa==''||id_direccion_administrativa==null)
                    {
                        alert('DEBE SELECCIONAR LA DIRECCIÓN ADMINISTRATIVA')
                    }
                    else
                    {   
                        // DATOS PARA EL USUARIO DEL SIAC 
                        let datos = 
                        {
                            "username": $("#user-name").val(),
                            "userlastname": $("#user-lastname").val(),
                            "useremail": $("#user-email").val(),
                            "userrol": $("#user-rol").val(),
                            "userpass": $("#user-pass").val(),
                            "usercargo": $("#usercargo").val(),
                            "acceso_audi": true,
                            "id_direccion_administrativa": $("#id_direccion_administrativa").val()
                        }
                        // AJAX QUE CREA EL USUARIO EN EL SIAC 
                        $.ajax({
                            url: "/addNewUser",
                            method: "POST",
                            dataType: "JSON",
                            data: {
                                "data": btoa(JSON.stringify(datos))
                            },
                            beforeSend: function() {
                                // $("button[type=submit]").attr('disabled', "true");
                            },
                            success: function(response)
                            {
                            
                                // DATOS PARA EL USUARIO EN AUDIENCIAS
                                let datos_audience = {
                                    "nombre": $("#user-name").val(),
                                    "apellido": $("#user-lastname").val(),
                                    "correo": $("#user-email").val(),
                                    "id_rol": $("#id_rol").val(),
                                    "identificacion": $("#cedula").val(),
                                    "clave": $("#user-pass").val(),
                                    "id": parseInt(response), 
                                };
                        
                           


                            //Si todos los campos son válidos, enviar la solicitud
                        // AJAX QUE CREA EL USUARIO EN EL SISTEMA DE AUDIENCIA     
                            $.ajax({
                                type: "POST",
                                url: "https://siac.sapi.gob.ve/api/audiencia/auth/user/create",
                                data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",
                                headers: {

                                    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
                    
                                  },  
                                success: function(response)
                                {
                                    
                                    

                                // Manejar la respuesta del servidor
                                Swal.fire({
                                    icon: "success",
                                    type: 'success',
                                    html: '<strong>Usuario Registrado Exitosamente</strong>',
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                //timer: 3500,

                                });
                                setTimeout(function() {
                                    window.location = "/adminUsers";
                                }, 1900);
                
                                },
                                error: function(xhr, status, error) 
                                {
                                    //console.log(xhr.responseJSON);
                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                        const errorCode = xhr.responseJSON.error.code;
                                        const errorMessage = xhr.responseJSON.error.message;
                                        switch (errorCode) {
                                        case "23000":
                                            if (errorMessage.includes("for key 'correo'")) {
                                            // Mostrar mensaje de error personalizado al usuario: correo electrónico duplicado
                                            Swal.fire({
                                                title: "error",
                                                type: 'error',
                                                text: "El correo electrónico ya existe en el sistema",
                                                icon: "error",
                                                toast: true,
                                                position: "center",
                                                showConfirmButton: false,
                                                timer: 1900,
                                            });
                                            

                                            } else if (errorMessage.includes("for key 'identificacion'")) {
                                            // Mostrar mensaje de error personalizado al usuario: cédula duplicada
                                            Swal.fire({
                                                title: "error",
                                                type: 'error',
                                                text: "La cédula  ya existe en el sistema",
                                                icon: "error",
                                                toast: true,
                                                position: "center",
                                                showConfirmButton: false,
                                                timer: 1900,
                                            });
                                            } 
                                            
                                            else {
                                            console.log("Error desconocido:", errorMessage);
                                            }
                                            break;
                                        default:
                                            console.log("Error desconocido:", errorMessage);
                                        }
                                    } else {
                                        console.log("Error desconocido:", xhr.responseJSON);
                                    }
                                }
                           });
                    
                        //   BIEN , CUANDO AGREGO ME MANDA UN TOKEN

                            }

                
                        });

                

                    }

                }else
                {
                   
                    let datos = 
                    {
                        "username": $("#user-name").val(),
                        "userlastname": $("#user-lastname").val(),
                        "useremail": $("#user-email").val(),
                        "userrol": $("#user-rol").val(),
                        "userpass": $("#user-pass").val(),
                        "usercargo": $("#usercargo").val(),
                        "acceso_audi": false,
                        "id_direccion_administrativa": $("#id_direccion_administrativa").val()
                    }
                    if (id_direccion_administrativa==''||id_direccion_administrativa==null)
                        {
                        alert('DEBE SELECCIONAR LA DIRECCIÓN ADMINISTRATIVA')
                    }else
                    {

                    
                        $.ajax({
                            url: "/addNewUser",
                            method: "POST",
                            dataType: "JSON",
                            data: {
                                "data": btoa(JSON.stringify(datos))
                            },
                            beforeSend: function() {
                                // $("button[type=submit]").attr('disabled', "true");
                            },
                    
                            success: function(mensaje) {
                    
                                if (mensaje === 0) {
                                    Swal.fire({
                                        icon: "error",
                                        type: 'error',
                                        html: '<strong>Error!! El Usuario ya Existe</strong>',
                                        toast: true,
                                        position: "center",
                                        showConfirmButton: false,
                                        //timer: 3500,
                    
                                    });
                                    setTimeout(function() {
                                        window.location = "/adminUsers";
                                    }, 1500);
                                } else if (mensaje === 1) {
                                    Swal.fire({
                                        icon: "success",
                                        type: 'success',
                                        html: '<strong>Usuario Registrado Exitosamente</strong>',
                                        toast: true,
                                        position: "center",
                                        showConfirmButton: false,
                                        //timer: 1500,
                                    });
                                    setTimeout(function() {
                                        window.location = "/adminUsers";
                                    }, 1500);
                                } else if (mensaje === 2) {
                                    Swal.fire({
                                        icon: "error",
                                        type: 'error',
                                        html: '<strong>Ocurrio un error al registrar el Usuario/strong>',
                                        toast: true,
                                        position: "center",
                                        showConfirmButton: false,
                                        //timer: 1500,
                                    });
                                    setTimeout(function() {
                                        window.location = "/adminUsers";
                                    }, 1500);
                                }
                            }
                        });
                    }

                 }
    
            }



    
});



//METODO PARA ABRIR EL MODAL PARA LA   EDICION
$('#listar_usuarios').on('click', '.Editar', function(e) {

    
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    var idusuopr = $(this).attr('idusuopr');
    var usuopnom = $(this).attr('usuopnom');
    var usuopape = $(this).attr('usuopape');
    var usuopemail = $(this).attr('usuopemail');
    var usuoppass = $(this).attr('usuoppass');
    var usuopborrado = $(this).attr('borrado');
    var usercargo = $(this).attr('usercargo');
    var acceso_audi = $(this).attr('acceso_audi');
    var id_direccion_administrativa = $(this).attr('id_direccion_administrativa');
    
    
    if (acceso_audi=='t') {
        let act_aud='true';

        llenar_combo_Direcciones(Event,id,act_aud);
        
    }else{
        let act_aud='false';
        llenar_combo_Direcciones_normal(Event,id_direccion_administrativa);
        
    }
    if (usercargo == 'null') 
    {
        usercargo = ''
    }
    var id = $(this).attr('idrol');
    if (id==9 ||id==5 ||acceso_audi=='t')     
    {
       
        act_aud='true';
        $.ajax({
            type: "GET",
            url: "https://siac.sapi.gob.ve/api/audiencia/usuarios/"+idusuopr,
            //data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            dataType: "json",
              headers: {

                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

              },  
            success: function(response)
            {     
               
               
                $(".edit_id_rol_nivel").css('display', 'block');
                $(".edit_user_cedula").css('display', 'block');
                $("#edit_id_rol option[value='" + response.id_rol + "']").prop("selected", true);
                $("#edit_cedula").val(response.identificacion); 
                },
            error: function(xhr, status, error) 
            {
                //console.log(xhr.responseJSON);
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    const errorCode = xhr.responseJSON.error.code;
                    const errorMessage = xhr.responseJSON.error.message;
                    switch (errorCode) {
                        case 0:
                            if (errorMessage.includes("Usuario not found")) {
                                // Mostrar mensaje de error personalizado al usuario: usuario no encontrado
                                Swal.fire({
                                   
                                    type: 'error',
                                    text: "El usuario no existe en el sistema de Audiencias",
                                    icon: "error",
                                    toast: true,
                                    position: "center",
                                    showConfirmButton: false,
                                   
                                });
                                setTimeout(function() {
                                    window.location = "/adminUsers";
                                }, 3200);
                
                            } else {
                                console.log("Error desconocido:", errorMessage);
                            }
                            break;
                        default:
                            console.log("Error desconocido:", errorMessage);
                    }
                } else {
                    console.log("Error desconocido:", xhr.responseJSON);
                }
            }
        });




  
        
    }else
    {
        act_aud='false';
    }

    var id_direccion_administrativa = $(this).attr('id_direccion_administrativa');
    var rol_usuario_sesion = $('#nivel_usuario').val();

   if(id==5 && rol_usuario_sesion!=5)
   {
    alert('No posee los permisos necesarios para realizar esta acción');
   }else
   {
    llenar_combo_roles(e, id);
    llenar_combo_Direcciones(Event,id_direccion_administrativa,act_aud);
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
        $('#usuopborrado').removeAttr('checked')
        $('#usuopborrado').val(true)
    }
    if (acceso_audi == 't') {
        $('#edit_acceso_audi').attr('checked', 'checked');
        $('#edit_acceso_audi').val(false);
    }
    if (acceso_audi == 'f') {
        $('#edit_acceso_audi').removeAttr('checked')
        $('#edit_acceso_audi').val(true)
    }

  }

   
});

//******METODO QUE TOMA EL ESTATUS ACTUAL DEL CHECKBO*****
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

$(document).on('change', '#edit-user-email', function(e) {
    let texto = $("#edit-user-email").val();
    if (texto.match(/^[a-zA-Z0-9._%+-]+@sapi\.gob\.ve$/) == null) {
        $("#edit-user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#edit-user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#edit-user-email").removeClass('is-invalid');
        $("#edit-user-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});




function validarFormatoEmail(email) {
    var regex = /^[a-zA-Z0-9._%+-]+@sapi\.gob\.ve$/;
    return regex.test(email);
  }



// //Evento para guardar el usuario editado
$(document).on('submit', "#edit-user", function(e) {
    e.preventDefault();
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let id_user=$("#userid").val();
    let clave_actual = $("#edit-user-pass").val().trim();
    let clave_anterior = $("#edit-user-confirm-pass").val();
    let usercargo = $("#cargo").val();
    let id_rol =$('#edit-user-rol').val();
    let acceso_audi = $('#edit_acceso_audi').is(':checked'); 

    if (acceso_audi) {
        // El checkbox está marcado
        acceso_audi = 't'; 
    } else {
        // El checkbox no está marcado
        acceso_audi = 'f'; 
    }
    
  
    if (clave_actual.length < 8) 
    {
            alert('LA CONTRASEÑA DEBE TENER MINIMO 8 CARACTERES');
    }
    else 
    {
        if (id_rol==9 || acceso_audi=='t'||id_rol==5 ) 
            {
               

                if (cambiar_clave == 'true')
                    {
                        clave_actual = clave_actual.trim();
        
                         if (clave_anterior == clave_actual) 
                        {
                            $("#edit-user-pass").addClass('is-invalid');
                            alert('ERROR! LA CONTRASEÑA DEBE SER DIFERENTE A LA ANTERIOR')
                        } else 
                        {
                            $("#edit-user-pass").removeClass('is-invalid');
                            $("#edit-user-confirm-pass").removeClass('is-invalid');
                            
                           // DATOS PARA EL USUARIO EN AUDIENCIAS
                          
                           let datos_audience =
                            {
                            "nombre": $("#edit-user-name").val(),
                            "apellido": $("#edit-user-lastname").val(),
                            "correo": $("#edit-user-email").val(),
                            "id_rol": $("#edit_id_rol").val(),
                            "identificacion": $("#edit_cedula").val(),
                            "clave": $("#edit-user-pass").val().trim(),
                           // "id": $("#userid").val(), 
                             };
        
                           
                            
                             
                           // DATOS PARA ACUTALIZAR DATOS EN EL SISTEMA DE AUDIENCIAS                                     
                            $.ajax({
                                type: "put",
                                url: "https://siac.sapi.gob.ve/api/audiencia/usuarios/"+id_user,
                                data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",
                                dataType: "json",
                                headers: {
                  
                                  'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
                  
                                },  
                                success: function(response)
                                {
                                    // DATOS PARA EL SIAC 
                                    let datos = 
                                    {
                                        "username": $("#edit-user-name").val(),
                                        "userlastname": $("#edit-user-lastname").val(),
                                        "useremail": $("#edit-user-email").val(),
                                        "userrol": $("#edit-user-rol").val(),
                                        "userid": $("#userid").val(),
                                        "id_direccion_administrativa": $("#edit_direccion_administrativa").val(),
                                        "usercargo": usercargo,
                                        "usuoppass": clave_actual,
                                        "usuopborrado": estatus_borrado,
                                        "modulo_clave": 'true',
                                        "acceso_audi": acceso_audi,
                                        
                                    }

                                     // DATOS PARA ACUTALIZAR INFORMACION EN SIAC
                                    $.ajax({
                                    url: "/editUser",
                                    method: "POST",
                                    dataType: "JSON",
                                    data: {
                                        "data": btoa(JSON.stringify(datos))
                                    },
                                    beforeSend: function() {
                                        $("button[type=submit]").attr('disabled', "true");
                                    }
                                   
                                     }).then((response) => {
                                        Swal.fire('Exito!', "Usuario editado exitosamente", "success");
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
                                      
                                        
                                }
                            });
           
                        }
                
                    } 
                    else 
                    {
                        // DATOS PARA EL USUARIO EN SIAC
                        const userData = {
                            username: $("#edit-user-name").val(),
                            userlastname: $("#edit-user-lastname").val(),
                            useremail: $("#edit-user-email").val(),
                            userrol: $("#edit-user-rol").val(),
                            userid: $("#userid").val(),
                            usuopborrado: estatus_borrado,
                            usercargo: usercargo,
                            modulo_clave: 'false',
                            acceso_audi:acceso_audi,
                            id_direccion_administrativa: $("#edit_direccion_administrativa").val(),
                            acceso_audi: acceso_audi,
                        };
                        
                        // DATOS PARA EL USUARIO EN AUDIENCIAS
                        const audienceData = {
                            nombre: $("#edit-user-name").val(),
                            apellido :$("#edit-user-lastname").val(),
                            correo: $("#edit-user-email").val(),
                            id_rol: $("#edit_id_rol").val(),
                            identificacion: $("#edit_cedula").val(),
                            apellido: $("#edit-user-lastname").val(),
                            


                        };
                        
                        
                        // ACTUALIZO LOS DATOS EN AUDIENCIA
                        $.ajax({
                            type: "PUT",
                            url: `https://siac.sapi.gob.ve/api/audiencia/usuarios/${id_user}`,
                            data: JSON.stringify(audienceData),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            dataType: "json",
                            headers: {
              
                              'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
              
                            },  
                            success: function(response) 
                            
                            {
                                // ACTUALIZO LOS DATOS EN SIAC           
                                $.ajax({
                                    url: "/editUser",
                                    method: "POST",
                                    dataType: "JSON",
                                    data: {
                                    data: btoa(JSON.stringify(userData)),
                                    },
                                    beforeSend: function() {
                                    $("button[type=submit]").attr('disabled', "true");
                                    }
                                })
                                .then((response) => {
                
        
                                Swal.fire('Exito!', "Usuario editado exitosamente", "success");
                                $("#editUser").modal('hide');
                                $("button[type=submit]").removeAttr('disabled');
                                setTimeout(function() {
                                window.location = '/adminUsers/';
                                }, 1500);
                                })
                                .catch((request) => {
                                    Swal.fire("Error!", "Ha ocurrido un error", "error");
                                    $("button[type=submit]").removeAttr('disabled');
                                    setTimeout(function() {
                                    window.location = '/adminUsers/';
                                    }, 1600);
                                });
                                
                                }
                                });   
                         }
                            
                            
          
        }else
        {
        
            if (cambiar_clave == 'true')
                {
                    clave_actual = clave_actual.trim();
    
                     if (clave_anterior == clave_actual) 
                    {
                        $("#edit-user-pass").addClass('is-invalid');
                        alert('ERROR! LA CONTRASEÑA DEBE SER DIFERENTE A LA ANTERIOR')
                    } else 
                    {
                        $("#edit-user-pass").removeClass('is-invalid');
                        $("#edit-user-confirm-pass").removeClass('is-invalid');
           
      
                          // DATOS PARA EL SIAC 
                          let datos = 
                          {
                              "username": $("#edit-user-name").val(),
                              "userlastname": $("#edit-user-lastname").val(),
                              "useremail": $("#edit-user-email").val(),
                              "userrol": $("#edit-user-rol").val(),
                              "userid": $("#userid").val(),
                              "id_direccion_administrativa": $("#edit_direccion_administrativa").val(),
                              "usercargo": usercargo,
                              "usuoppass": clave_actual,
                              "usuopborrado": estatus_borrado,
                              "modulo_clave": 'true',
                              "acceso_audi": acceso_audi,

                              
                          }
                            // ACTUALIZO LOS DATOS EN SIAC           
                            $.ajax({
                                url: "/editUser",
                                method: "POST",
                                dataType: "JSON",
                                data: {
                                data: btoa(JSON.stringify(datos)),
                                },
                                beforeSend: function() {
                                $("button[type=submit]").attr('disabled', "true");
                                }
                            })
                            .then((response) => {
                        
                        
                            Swal.fire('Exito!', "Usuario editado exitosamente", "success");
                            $("#editUser").modal('hide');
                            $("button[type=submit]").removeAttr('disabled');
                            setTimeout(function() {
                            window.location = '/adminUsers/';
                            }, 1500);
                            })
                            .catch((request) => {
                                Swal.fire("Error!", "Ha ocurrido un error", "error");
                                $("button[type=submit]").removeAttr('disabled');
                                setTimeout(function() {
                                window.location = '/adminUsers/';
                                }, 1600);
                             });
                            
                    }

                }else
                {

                     // DATOS PARA EL USUARIO EN SIAC
                     const userData = {
                        username: $("#edit-user-name").val(),
                        userlastname: $("#edit-user-lastname").val(),
                        useremail: $("#edit-user-email").val(),
                        userrol: $("#edit-user-rol").val(),
                        userid: $("#userid").val(),
                        usuopborrado: estatus_borrado,
                        usercargo: usercargo,
                        modulo_clave: 'false',
                        id_direccion_administrativa: $("#edit_direccion_administrativa").val(),
                        acceso_audi: acceso_audi,
                    };
                    
                    // ACTUALIZO LOS DATOS EN SIAC           
                    $.ajax({
                        url: "/editUser",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                        data: btoa(JSON.stringify(userData)),
                        },
                        beforeSend: function() {
                        $("button[type=submit]").attr('disabled', "true");
                        }
                    })
                    .then((response) => {


                    Swal.fire('Exito!', "Usuario editado exitosamente", "success");
                    $("#editUser").modal('hide');
                    $("button[type=submit]").removeAttr('disabled');
                    setTimeout(function() {
                    window.location = '/adminUsers/';
                    }, 1500);
                    })
                    .catch((request) => {
                        Swal.fire("Error!", "Ha ocurrido un error", "error");
                        $("button[type=submit]").removeAttr('disabled');
                        setTimeout(function() {
                        window.location = '/adminUsers/';
                        }, 1600);
                    });

                    }
        
        }
    }
    
    
 
   
})

//METODO PARA BLOQUEAR UN USUARIO
$('#listar_usuarios').on('click', '.Bloquear', function(e) {
    var idusuopr = $(this).attr('idusuopr');
    let usuopborrado = 'true'
    let datos = {
        idusuopr: idusuopr,
        usuopborrado: usuopborrado

    }
    Swal.fire({
        title: '¿Deseas Bloquear el Registro?',
        text: 'El registro será bloqueado del Sitema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            // Aquí puedes agregar la lógica para salir de la página
            $.ajax({
                url: "/Bloquear_User",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(JSON.stringify(datos))
                },
                beforeSend: function() {

                }
            }).then((response) => {
                Swal.fire('Exito!', "Usuario Bloqueado exitosamente", "success");
                $("#editUser").modal('hide');

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

$(document).on('change', '#user-email', function(e) {
    let texto = $("#user-email").val();
    if (texto.match(/\w*.\w*\@sapi.gob.ve/) == null) {
        $("#user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#user-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#user-email").removeClass('is-invalid');
        $("#user-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});


$("#user-rol").on('change', function() {

    let user_rol = $(this).val(); // Using $(this) to get the current select element
   let id=''
    if (user_rol === '9') { 
       
        $(".id_rol_nivel").show().css('display', 'block');
        $(".user_cedula").show().css('display', 'block');
        let act_aud='true';
         llenar_combo_Direcciones(Event,id,act_aud);
    } else {
        $(".id_rol_nivel").hide().css('display', 'none');
        $(".user_cedula").hide().css('display', 'none');
        let act_aud='false';
        
    }
});


$("#edit-user-rol").on('change', function() {


    let edit_user_rol = $(this).val(); // Using $(this) to get the current select element
   
    if (edit_user_rol === '9') { // Note: I changed the comparison to a string, as the value is likely a string
        $(".edit_id_rol_nivel").show().css('display', 'block');
        $(".edit_user_cedula").show().css('display', 'block');
    } else {
        
        $(".edit_id_rol_nivel").hide().css('display', 'none');
        $(".edit_user_cedula").hide().css('display', 'none');
    }
});



$("#acceso_audi").on('click', function() {
    if ($(this).is(':checked')) {
        $(".id_rol_nivel").show();
        $(".user_cedula").show();
    } else {
        $(".id_rol_nivel").hide();
        $(".user_cedula").hide();
    }
});

$("#edit_acceso_audi").on('click', function() {
   let idusuopr=$('#userid').val();
   const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));

   if ($(this).is(':checked')) 
    {

        $.ajax({
            type: "GET",
            url: "https://siac.sapi.gob.ve/api/audiencia/usuarios/"+idusuopr,
            //data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            dataType: "json",
            headers: {

                'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

            },  
                    success: function(response)
                    {     
                    
                    
                        $(".edit_id_rol_nivel").css('display', 'block');
                        $(".edit_user_cedula").css('display', 'block');
                        $("#edit_id_rol option[value='" + response.id_rol + "']").prop("selected", true);
                        $("#edit_cedula").val(response.identificacion); 
                    },
                            error: function(xhr, status, error) 
                            {
                                //console.log(xhr.responseJSON);
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    const errorCode = xhr.responseJSON.error.code;
                                    const errorMessage = xhr.responseJSON.error.message;
                                    switch (errorCode) {
                                        case 0:
                                            if (errorMessage.includes("Usuario not found")) {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: "El usuario no existe en el sistema de Audiencias. ¿Desea registrarlo?",
                                                    icon: 'error', // Asegúrate de que 'error' sea un valor válido
                                                    showCancelButton: true, // Muestra el botón "No"
                                                    confirmButtonText: 'Sí', // Botón "Sí"
                                                    cancelButtonText: 'No' // Botón "No"
                                                }).then((result) => {
                                                    if (result.value==true) {
                                                        $("#ingreso_por_update").css('display', 'block');
                                                        $("#guardar").css('display', 'none');
                                                        $(".edit_id_rol_nivel").css('display', 'block');
                                                        $(".edit_user_cedula").css('display', 'block');
                                                    // SI PRESIONA QUE NO , SE CIERRA EL SWAL FIRE***
                                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                        // Si el usuario hace clic en "No"
                                                        Swal.fire({
                                                            title: 'Cerrando...',
                                                            text: 'No se realizará ninguna acción.',
                                                            icon: 'info', // Asegúrate de que 'info' sea un valor válido
                                                            timer: 1500,
                                                            showConfirmButton: false
                                                        });
                                                    }
                                                });
                                
                                            } else {
                                                console.log("Error desconocido:", errorMessage);
                                            }
                                            break;
                                        default:
                                            console.log("Error desconocido:", errorMessage);
                                    }
                                } else {
                                    console.log("Error desconocido:", xhr.responseJSON);
                                }
                            }
                });
    } else 
    {
        $(".edit_id_rol_nivel").hide();
        $(".edit_user_cedula").hide();
        $("#ingreso_por_update").css('display', 'none');
        $("#guardar").css('display', 'block');
    }
     
   
});

$("#ingreso_por_update").on('click', function() {
    const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
    let idusuopr=$('#userid').val();
    let identificacion =$("#edit_cedula").val();

    let acceso_audi = $("#edit_acceso_audi").is(':checked');

    if (acceso_audi) {
        // El checkbox está marcado
        acceso_audi==true
    } else {
        // El checkbox no está marcado
        acceso_audi==false
    }

    if (identificacion==''||identificacion==null) 
    {
        alert('Por favor Introduzca la cedula del Usuario');    
    }
    else
    {

        let clave_actual = $("#edit-user-pass").val().trim();
        let clave_anterior = $("#edit-user-confirm-pass").val();
        let usercargo = $("#cargo").val();
        if (clave_actual.length < 8) 
        {
                alert('LA CONTRASEÑA DEBE TENER MINIMO 8 CARACTERES');
        }
        else 
        {

            if (cambiar_clave == 'true')
                {
                   
                    clave_actual = clave_actual.trim();
    
                     if (clave_anterior == clave_actual) 
                    {
                        $("#edit-user-pass").addClass('is-invalid');
                        alert('ERROR! LA CONTRASEÑA DEBE SER DIFERENTE A LA ANTERIOR')
                    } else 
                    {
                        $("#edit-user-pass").removeClass('is-invalid');
                        $("#edit-user-confirm-pass").removeClass('is-invalid');
                        
                       // DATOS PARA EL USUARIO EN AUDIENCIAS
                      
                       let datos_audience =
                        {
                        "nombre": $("#edit-user-name").val(),
                        "apellido": $("#edit-user-lastname").val(),
                        "correo": $("#edit-user-email").val(),
                        "id_rol": $("#edit_id_rol").val(),
                        "identificacion": $("#edit_cedula").val(),
                        "clave": $("#edit-user-pass").val().trim(),
                        "id": idusuopr, 
                         };

                        ////AJAX QUE CREA EL USUARIO EN EL SISTEMA DE AUDIENCIA     
                        $.ajax({
                        type: "POST",
                        url: "https://siac.sapi.gob.ve/api/audiencia/auth/user/create",
                        data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        headers: {

                            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

                        },  
                            success: function(response)
                            {
                                // DATOS PARA EL SIAC 
                                let datos = 
                                {
                                    "username": $("#edit-user-name").val(),
                                    "userlastname": $("#edit-user-lastname").val(),
                                    "useremail": $("#edit-user-email").val(),
                                    "userrol": $("#edit-user-rol").val(),
                                    "userid": $("#userid").val(),
                                    "id_direccion_administrativa": $("#edit_direccion_administrativa").val(),
                                    "usercargo": usercargo,
                                    "usuoppass": clave_actual,
                                    "usuopborrado": estatus_borrado,
                                    "modulo_clave": 'true',
                                    "acceso_audi": acceso_audi,
                                    
                                }

                               
                                 // DATOS PARA ACUTALIZAR INFORMACION EN SIAC
                                $.ajax({
                                url: "/editUser",
                                method: "POST",
                                dataType: "JSON",
                                data: {
                                    "data": btoa(JSON.stringify(datos))
                                },
                                beforeSend: function() {
                                    $("button[type=submit]").attr('disabled', "true");
                                }
                               
                                 }).then((response) => {
                                    Swal.fire('Exito!', "Usuario editado exitosamente", "success");
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
                                  
                                    
                            }
                        });
       
                    }
            
                } 
                else 
                {

                   
                    // DATOS PARA EL USUARIO EN SIAC
                    const userData = {
                        username: $("#edit-user-name").val(),
                        userlastname: $("#edit-user-lastname").val(),
                        useremail: $("#edit-user-email").val(),
                        userrol: $("#edit-user-rol").val(),
                        userid: $("#userid").val(),
                        usuopborrado: estatus_borrado,
                        usercargo: usercargo,
                        modulo_clave: 'false',
                        id_direccion_administrativa: $("#edit_direccion_administrativa").val(),
                        acceso_audi: acceso_audi,
                    };
                    
                    // DATOS PARA EL USUARIO EN AUDIENCIAS
                    let audienceData =
                    {
                    "nombre": $("#edit-user-name").val(),
                    "apellido": $("#edit-user-lastname").val(),
                    "correo": $("#edit-user-email").val(),
                    "id_rol": $("#edit_id_rol").val(),
                    "identificacion": $("#edit_cedula").val(),
                    "clave": '12345678',
                    "id": idusuopr, 
                     };


                   
                      ////AJAX QUE CREA EL USUARIO EN EL SISTEMA DE AUDIENCIA     
                      $.ajax({
                        type: "POST",
                        url: "https://siac.sapi.gob.ve/api/audiencia/auth/user/create",
                        data: JSON.stringify(audienceData), // Convertir objeto a cadena JSON
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        headers: {

                            'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

                        },  
                        success: function(response) 
                        
                        {
                            // ACTUALIZO LOS DATOS EN SIAC           
                            $.ajax({
                                url: "/editUser",
                                method: "POST",
                                dataType: "JSON",
                                data: {
                                data: btoa(JSON.stringify(userData)),
                                },
                                beforeSend: function() {
                                $("button[type=submit]").attr('disabled', "true");
                                }
                            })
                            .then((response) => {
            
    
                            Swal.fire('Exito!', "Usuario editado exitosamente", "success");
                            $("#editUser").modal('hide');
                            $("button[type=submit]").removeAttr('disabled');
                            setTimeout(function() {
                            window.location = '/adminUsers/';
                            }, 1500);
                            })
                            .catch((request) => {
                                Swal.fire("Error!", "Ha ocurrido un error", "error");
                                $("button[type=submit]").removeAttr('disabled');
                                setTimeout(function() {
                                window.location = '/adminUsers/';
                                }, 1600);
                            });
                            
                            }
                            });   
                     }
                        
                        
      
    }
                


    
    }


});
