//Evento que busca las parroquias por municipio
$(document).on("click", "#subir_archivos", (e) => {
    e.preventDefault();


    var archivo = document.getElementById("archivo").files[0]; // Obtiene el archivo seleccionado
    var id_caso = document.getElementById("id_caso_pdf").value;

    var formData = new FormData(); // Crea un objeto FormData
    formData.append("archivo", archivo);
    formData.append("id_caso_pdf", id_caso); // Agrega el archivo al objeto FormData
    $.ajax({
        url: "/upload",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {

            if (data == 0) {
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>ERROR EL ARCHIVO YA EXISTE.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // setTimeout(function() {
                //     window.location = "/casos";
                // }, 1600);
            } else if (data == 1) {
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>ERROR EL ARCHIVO ES DEMASIADO GRANDE.</strong>',

                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                setTimeout(function() {

                }, 1600);
            }

            if (data == 2) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>ARCHIVO CARGADO EXITOSAMENTE.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                setTimeout(function() {
                    let idcaso = $('#id_caso').val();
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
                }, 1600);
            } else if (data == 3) {
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>HUBO UN ERROR AL CAGAR EL ARCHIVO.</strong>',

                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // setTimeout(function() {
                //     window.location = "/casos";
                // }, 1600);
            } else if (data == 4) {
                Swal.fire({
                    icon: "success",
                    type: 'error',
                    html: '<strong>DEBE SELECCIONAR UN ARCHIVO.</strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // setTimeout(function() {
                //     window.location = "/casos";
                // }, 1600);

            }

        },
        error: function(xhr, status, error) {
            // Aquí puedes manejar los errores
        }
    });
});