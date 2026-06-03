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
   
    $.ajax({
        url: "/signin",
        method: "POST",
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
            } else if (data == 1) {
                Toast.fire({
                    type: 'success',
                    title: "Iniciando Sesión"
                });
                setTimeout(function() {
                    window.location.href = '/inicio';
                }, 1400);
            } else if (data == 2) {
                Toast.fire({
                    type: 'error',
                    title: "Contraseña Incorrecta"
                });
            } else if (data == 3) {
                Toast.fire({
                    type: 'error',
                    title: "Usuario incorrecto"
                });
            }
        }
    })
});

/*Verificacion de datos en el form*/
$(document).on('change', '#usuario-email', function(e) {
    let texto = $("#usuario-email").val();
    if (texto.length < 5) {
        $("#usuario-email").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#usuario-email").removeClass('is-invalid');
        $("#usuario-email").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});