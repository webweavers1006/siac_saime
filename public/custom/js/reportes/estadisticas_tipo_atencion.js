
$(function() {
llenar_Estados(Event);
});

// FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, id) {
    const url = "/llenar_Estados"; // Usar const para variables que no cambian
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {
            // Puedes agregar un loader o alguna indicación de que se está cargando
        },
        success: function(data) {
           
          
            if (data.length >= 1) {
                $("#estado-caso").empty(); // Limpiar el combo
                $("#estado-caso").append(
                    "<option value='0' selected disabled>Seleccione</option>"
                );
                $.each(data, function(i, item) {
                    // Agregar las opciones al combo
                    if (id === undefined) {
                        $("#estado-caso").append(
                            "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                        );
                    } else {
                       
                        if (item.estadoid === id) {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "' selected>" + item.estadonom + "</option>"
                            );
                        } else {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                            );
                        }
                    }
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            alert("Error: " + xhr.status + " - " + errorThrown);
        },
    });
}

$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();
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

        // $('#fecha_desde').val(desde);
        // $('#fecha_hasta').val(hasta);
        window.location = "/estadisticas_tipo_atencion/" + desde + '/' + hasta;
    }
})
	
//Generacion de archivo csv 
$(document).on('click', "#generaArchivoExcel", function(e) {
	e.preventDefault();
	let fechas = $("#rango-consulta").val().split(" - ");
    let datos = {
        "date_init"     : invertirFecha(fechas[0]),
		"date_end"      : invertirFecha(fechas[1]),
		"direccion": $("#direcciones").val(),
		"departamento": $("#departamentos").val()
    }
	window.location = '/generarExcelDepartamentos/'+btoa(JSON.stringify(datos));
})

$(document).on('click', '.limpiar', function(e) {
    e.preventDefault();

    window.location = "/estadisticas_tipo_atencion/null/null";

})