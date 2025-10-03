
$(function() {

 let estado=$('#estado').val();

 llenar_Estados(Event,estado);
});



// FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, estado) {
   
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
                    "<option value='0' selected disabled>Seleccione Estado</option>"
                );
                $.each(data, function(i, item) {
                    // Agregar las opciones al combo
                    if (estado === undefined) {
                        $("#estado-caso").append(
                            "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                        );
                    } else {
                       
                        if (item.estadoid === estado) {
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
    let estado=$('#estado-caso').val();
    llenar_Estados(Event,estado);
    if (desde == '') {
        desde = 'null'
    }
    if (hasta == '') {
        hasta = 'null'
    }

     
     
       if (desde == 'null' && hasta != 'null') {} else if (hasta == 'null' && desde != 'null') {
         alert('DEDE INDICAR EL CAMPO HASTA');
     } else if (hasta < desde) {
         alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA')
          }
      else {

      
        window.location = "/estadisticas_tipo_atencion/"+estado+'/' + desde + '/' + hasta;
    }
})
	

// Vincula la misma lógica al evento change del campo de estado
$(document).on('change', '#estado-caso', function(e) {
    e.preventDefault();
   let desde = $('#desde').val();
    let hasta = $('#hasta').val();
    let estado = $('#estado-caso').val();
    //llenar_Estados(Event,estado) ;
    if (desde === '') {
        desde = 'null';
    }
    if (hasta === '') {
        hasta = 'null';
    }
    
  

    if (desde === 'null' && hasta !== 'null') {
        // La condición original estaba vacía, se puede mejorar para evitar problemas
        alert('DEBE INDICAR EL CAMPO DESDE');
    } else if (hasta === 'null' && desde !== 'null') {
        alert('DEBE INDICAR EL CAMPO HASTA');
    } else if (hasta < desde) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA');
    } else {
        window.location = "/estadisticas_tipo_atencion/" + estado + '/' + desde + '/' + hasta;
    }

});


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

    window.location = "/estadisticas_tipo_atencion/null/null/null";

})

