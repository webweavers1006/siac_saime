$(document).on('submit', '#caso-estatus', function(e) {
    e.preventDefault();
    let datos = {
        "casestatus": $("#estatus-caso").val(),
        "caseid": $("#id-caso").val(),
    }
    $.ajax({
        url: "/cambiarEstatus",
        method: "POST",
        dataType: "JSON",
        data: {
            "data": btoa(JSON.stringify(datos))
        },
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', "true");
            $("#mensaje").show();
        },
        success: function(respuesta) {
            
            if (respuesta.mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>Estatus cambiado exitosamente</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 4000,
                });
                setTimeout(function() {
                    location.reload();
                }, 1600);
            } else if (respuesta.mensaje === 2) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Hubo un error al cambiar el estatus</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 4000,
                });

                setTimeout(function() {
                    location.reload();
                }, 3000);
            }else if (respuesta.mensaje === 3){
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>El usuario no tiene correo asociado.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 3800,
                });

                setTimeout(function() {
                    location.reload();
                }, 1600);
            }else if (respuesta.mensaje === 4) {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Hubo un error al enviar el Correo.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 4000,
                });

                setTimeout(function() {
                    location.reload();
                }, 3000);
            }


        }
     })
    
    
    //.then((response) => {
    //     Swal.fire("Exito", response.message, "success");
    //     $("#cambiar-estatus").modal('hide');
    //     $("#caso-estatus")[0].reset();
    // }).catch((request) => {
    //     Swal.fire("Error", request.responseJSON.message, "error");
    // });
    // setTimeout(function() {
    //     location.reload();
    // }, 1500);
    // $("button[type=submit]").removeAttr('disabled')
})