
 // Evento change para el select de tipo de atención
 $("#tipo-atencion-usu").on('change', function(e) {
     $("#ayudas").modal("show");
    document.getElementById("detalles_atencion").disabled = false;
    $("#hijos_tipoatencion").val('NO');
    let idTipoAtencion = $(this).val(); 
    let selectedOption = $(this).find('option:selected');

    let actProInt = selectedOption.data('act-pro-int');
    let organismoPp = selectedOption.data('organismo_pp');
    // Muestra u oculta elementos según el tipo de atención
    if (idTipoAtencion == 5 || idTipoAtencion == 1) {
        $("#denuncias").toggle(idTipoAtencion == 5);
        $(".tipoproint").toggle(actProInt === 't');
        document.getElementById("tipo-pi").disabled = (actProInt !== 't');
        $(".org_pp").toggle(organismoPp === 't');
        document.getElementById("organismo-caso").disabled = (organismoPp !== 't');
    } else {
        $("#cgr").hide();
        $("#denuncias").hide();
        $(".tipoproint").toggle(actProInt === 't');
        document.getElementById("tipo-pi").disabled = (actProInt !== 't');
        $(".org_pp").toggle(organismoPp === 't');
        document.getElementById("organismo-caso").disabled = (organismoPp !== 't');
    }

   $.ajax({
    url: `/Listar_Tipo_Atencion_act_coordenadas/${idTipoAtencion}`,
    method: 'GET',
    dataType: 'json',
   
    })
    .done((response) => {
        // La petición se completó con éxito
       const tipoAtencion = response[0]; 

    if (tipoAtencion && tipoAtencion.act_coordenadas === 't') {
    $(".mapa_ayuda").show();
    $("#actcoordenadas").val('t');
    
      map.invalidateSize();
    } else {
    $(".mapa_ayuda").hide();
     $("#actcoordenadas").val('f');
    }
    })
    .fail((xhr, status, error) => {
        // La petición falló o devolvió un error
        let errorMessage = 'Error al cargar datos.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        Swal.fire('Error', errorMessage, 'error');
    });

    // Llama a la función para llenar detalles de atención
    llenar_detalle_atencion(e, idTipoAtencion);





});