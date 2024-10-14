

// Para recuperar el objeto de almacenamiento local
const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));



$('#observaciones').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  // Obtener la fecha y hora seleccionadas
  let mensaje = document.getElementById("mensaje_observacion").value;
  let id_solicitud = document.getElementById("id_solicitud").value;
  let id_opcion = document.getElementById("id_opcion").value;
  let id_usuario = user_audiencia.id;
 
   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = 
   {
    mensaje: mensaje,
    id_solicitud: id_solicitud,
    id_usuario: id_usuario,
    id_opcion: id_opcion,
 
  };

//AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "POST",
  url: `http://172.16.0.46:70/mensajes`,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
  headers: {
    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
  },
    success: function(response) 
    
    {
      Swal.fire({
        icon: "success",
        type: 'success',
        html: '<strong>REGISTRO EXITOSO!!!'+ '</strong>',
        toast: true,
        position: "center",
        showConfirmButton: false,
        //timer: 3500,
    });
    setTimeout(function() {
      window.location = '/detalles_solicitudes/'+id_solicitud;
    }, 1500);
    
        
      }
    });   


});



$('#responsable').on('click', function() {
  // Obtener la fecha y hora seleccionadas
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
 
  let id_solicitud = document.getElementById("id_solicitud").value;
  
  let id_trabajador = document.getElementById("id_trabajador").value;
 
   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = 
   {
    id_trabajador: id_trabajador,
  };

//AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "PUT",
  url: `http://172.16.0.46:70/solicitudes/`+id_solicitud,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
  headers: {
    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
  },
  success: function(response) 
  
  {

    Swal.fire({
      icon: "success",
      type: 'success',
      html: '<strong>REGISTRO ACTUAIZADO!!!'+ '</strong>',
      toast: true,
      position: "center",
      showConfirmButton: false,
      //timer: 3500,
  });
  setTimeout(function() {
    window.location = '/detalles_solicitudes/'+id_solicitud;
  }, 1500);
  
     
    

      
    }
      });   


});



$('#cierre_solicitud').on('click', function() {
  // Obtener la fecha y hora seleccionadas
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  let respuesta = document.getElementById("respuesta").value;
  let id_solicitud = document.getElementById("id_solicitud").value;
  let id_estado =7
 
   // DATOS PARA EL USUARIO EN AUDIENCIAS
   const audienceData = 
   {
    respuesta: respuesta,
    id_estado:id_estado,
  };

//AGREGO LOS DATOS EN AUDIENCIA
$.ajax({
  type: "PUT",
  url: `http://172.16.0.46:70/solicitudes/`+id_solicitud,
  data: JSON.stringify(audienceData),
  contentType: "application/json; charset=utf-8",
  dataType: "json",
  dataType: "json",
  headers: {
    'Authorization': `Bearer ${user_audiencia.token}` // Agregar token aquí
  },
  success: function(response) 
  
  {
    
    Swal.fire({
      icon: "success",
      type: 'success',
      html: '<strong>REGISTRO EXITOSO!!!'+ '</strong>',
      toast: true,
      position: "center",
      showConfirmButton: false,
      //timer: 3500,
  });
  setTimeout(function() {
    window.location = '/detalles_solicitudes/'+id_solicitud;
  }, 1500);
  
      
    }


       
      
    
      });   


});