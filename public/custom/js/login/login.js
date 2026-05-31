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

                           
                          
                            if (data[0].idrol === "9" ||data[0].idrol === "5" ||data[0].acceso_audi==="t")
                            {
                                let datos_audience = 
                                {
                                    "user": $("#usuario-email").val(),
                                    "pass": $("#usuario-clave").val(),                               
                                };  
                                $.ajax({
                                    type: "POST",
                                    url: "https://siac.sapi.gob.ve/api/audiencia/auth/user/authentication",
                                    data: JSON.stringify(datos_audience), // Convertir objeto a cadena JSON
                                    contentType: "application/json; charset=utf-8",
                                    dataType: "json",
                                    success: function(response)
                                    {
                                        
                                        
                                        localStorage.setItem('user_audiencia', JSON.stringify(response));
                                        Toast.fire({
                                        type: 'success',
                                        title: "Iniciando Sesion"

                                        });
                                       setTimeout(function() {

                                        const userData = localStorage.getItem('user_audiencia');
                                        const userDataJson = JSON.parse(userData);
                                        const token = userDataJson.token;
                                        const nivel_rol = userDataJson.id_rol;
                                     
                                        document.cookie = `nivel_rol=${nivel_rol}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                                        document.cookie = `token=${token}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
                                
                                       window.location.href = '/inicio';
                                         
                                       }, 1400);

                                    }

                                });
                            } else {
                                
                            }
                        
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