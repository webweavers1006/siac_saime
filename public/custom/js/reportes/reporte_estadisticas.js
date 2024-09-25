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
                        //console.log(data)
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
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();
    let id_estado = $('#estado-caso').val();

  
    if (id_estado==='null'||id_estado===null)
    {
        if (desde == '') {
            desde = 'null'
        }
        if (hasta == '') {
            hasta = 'null'
        }
        if (desde == 'null' && hasta == 'null') {
            alert('DEBE INGRESAR EL RANGO DE FECHA ')
        } else if (desde == 'null' && hasta != 'null') {} else if (hasta == 'null' && desde != 'null') {
            alert('DEDE INDICAR EL CAMPO HASTA');
        } else if (hasta < desde) {
            alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA')
        } else {
          ;
     
            window.location = "/estadisticas_con_filtro/" + desde + '/' + hasta+'/'+ id_estado;
        }
        
    }else
    {
        if (desde == '') {
            desde = 'null'
        }
        if (hasta == '') {
            hasta = 'null'
        }
        window.location = "/estadisticas_con_filtro/" + desde + '/' + hasta+'/'+ id_estado;
    }

  
    
})

$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();

    window.location = "/estadisticas";

})


