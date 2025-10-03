/*
 *Este es el document ready
 */
 llenar_Estados(Event);


//FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, id) {
    e.preventDefault;
    url = "/llenar_Estados";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#estado-caso").empty();
                $("#estado-caso").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#estado-caso").append(
                            "<option value=" +
                            item.estadoid +
                            ">" +
                            item.estadonom +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#estado-caso").append(
                                "<option value=" +
                                item.estadoid +
                                " selected>" +
                                item.estadonom +
                                "</option>"
                            );
                        } else {
                            $("#estado-caso").append(
                                "<option value=" +
                                item.estadoid +
                                ">" +
                                item.estadonom +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
         
        },
    });
}



$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let desde = $('#desde').val() || 'null';
    let hasta = $('#hasta').val() || 'null';
    let id_estado = $('#estado-caso').val();
    id_estado = (id_estado === '0' || id_estado === null || id_estado === undefined) ? 'null' : id_estado;

    if (id_estado === 'null') {
        if (desde === 'null' && hasta === 'null') {
            alert('DEBE INGRESAR AL MENOS EL RANGO DE FECHA.');
            return; // Detiene la ejecución si hay error.
        }
        
        // 3. Validar si solo se ingresó una fecha
        if (desde === 'null' && hasta !== 'null') {
            alert('DEBE INDICAR LA FECHA DE INICIO (DESDE).');
            return;
        }
        if (hasta === 'null' && desde !== 'null') {
            alert('DEBE INDICAR LA FECHA DE FIN (HASTA).');
            return;
        }

        // 4. Validar que la fecha 'DESDE' no sea mayor a la fecha 'HASTA'
        if (desde !== 'null' && hasta !== 'null' && hasta < desde) {
            alert('LA FECHA DE INICIO (DESDE) ES MAYOR A LA FECHA DE FIN (HASTA).');
            return;
        }
    }
    
    // --- Ejecución de la Consulta ---
    
    // Si la validación pasa, se redirige. Todos los parámetros tendrán un valor (fecha o 'null')
    window.location = "/estadisticas_con_filtro/" + desde + '/' + hasta + '/' + id_estado;

});

$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();

    window.location = "/estadisticas";

})


