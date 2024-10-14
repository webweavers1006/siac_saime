







$('#actualizar_audiencias').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  
   let id_estado_pais= $('#estado-select').val();
   let id_requerimiento= $('#id_requerimiento').val();
   
   if (id_estado_pais===0||id_estado_pais==='0') 
  {
    id_estado_pais=26 
  }else
  {
    id_estado_pais= $('#estado-select').val();
  }

  // DATOS PARA REQUERIMIENTO
  let datos_audiencia =
   {
    "id_formato_cita": $('#id_formato_cita').val(),
    "id_estado_pais": id_estado_pais,
    "id_pais": $('#pais-select').val(),
    "id_trabajador": $("#id_trabajador").val(),
    "id_estado":  $("#id_estado").val(),
   // "id_condicion":  $("#id_condicion").val(),
  };

  
  //console.log(JSON.stringify(datos_audiencia));
    // // // ENVIO LOS DATOS DEL REQUERIMIENTO
     $.ajax({
       type: "PUT",
       url: "http://172.16.0.46:70/requerimientos/"+id_requerimiento,
       data: JSON.stringify(datos_audiencia), // Convertir objeto a cadena JSON
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       dataType: "json",
        headers: {

          'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

        },
       success: function(response)
       {       
            Swal.fire('Exito!', "REGISTRO ACTUALIZADO", "success");
            setTimeout(function() {
            window.location = '/vista_audiencias/';
            }, 1500);

       }
 
      });
  
});



  let id_area = $("#id_area").val();
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  const url = `http://172.16.0.46:70/usuarios_areas/director/${id_area}`;
    // Realiza la solicitud AJAX
    $.ajax({
      url: url,
      method: "get",
      dataType: "JSON", 
      dataType: "json",
      headers: {

        'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí

      },  
      beforeSend: function() {    
       
      },   
      success: function(response) {
        $('#id_trabajador').val(response.id_usuario);         
      },
      error: function(xhr, status, error) {   
        console.error(xhr.responseText);   
      }
    
 
  
});
