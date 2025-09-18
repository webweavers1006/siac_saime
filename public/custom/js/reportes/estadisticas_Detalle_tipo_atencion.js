
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
        window.location = "/estadisticas_Detalle_tipo_atencion/" + desde + '/' + hasta;
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

    window.location = "/estadisticas_Detalle_tipo_atencion/null/null";

})