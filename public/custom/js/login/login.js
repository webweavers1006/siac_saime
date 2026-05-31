const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).on('submit', "#login-user", function(e) {
    e.preventDefault();
    let datos = {
        "username": $("#usuario-email").val().trim(),
        "userpass": $("#usuario-clave").val()
    }
   
    let correo=$("#usuario-email").val().trim();
    $.ajax({
        url: "/signin",
        method: "GET",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            //$("button[type=submit]").attr('disabled', 'true');
        },
        success: function(data) {

            if (data == 0) {
                Toast.fire({
                    type: 'error',
                    title: "Usuario Bloqueado"
                });
            } else if (data == 1)
            { 
                    url = "/buscar_rol_correo/"+correo;
                    $.ajax({
                        url: url,
                        method: "GET",
                        dataType: "JSON",
                        beforeSend: function(data)
                        {

                        },
                        success: function(data)
                        {

                           
                          
                            Toast.fire({
                                type: 'success',
                                title: "Iniciando Sesion"

                                });
                                setTimeout(function() {
                                    window.location = "/pantalla_bienvenida";
                                }, 1400);
                        
                        },
                        error: function(xhr, status, errorThrown) {
                            alert(xhr.status);
                            alert(errorThrown);
                        },
                    });
            } else if (data == 2) {
                Toast.fire({
                    type: 'error',
                    title: "Contraseña Incorrecta"
                });

            } else if (data == 3) {
                Toast.fire({
                    type: 'error',
                    title: "Usuario  incorrecto"
                });

            }
        }

    })
});

/*Verficacion de datos en el form*/
$(document).on('change', '#usuario-email', function(e) {
    let texto = $("#usuario-email").val();
    if (texto.match(/\w*.\w*\@sapi.gob.ve/) == null) {
        $("#usuario-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else if (texto.lenght < 5) {
        $("#usuario-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#usuario-email").removeClass('is-invalid');
        $("#usuario-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});