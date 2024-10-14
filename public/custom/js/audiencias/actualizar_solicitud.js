





$('#actualizar_solicitud').on('click', function() {
  const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
  
        let id_solicitud= $('#id_solicitud').val();

        let descripcion= $('#descripcion').val();
          // DATOS PARA LA SOLICITUD
          let datos_audiencia =
          {
            "id_estado": $('#id_estado').val(),
            "descripcion": $('#descripcion').val(),
            "id_trabajador": $('#id_trabajador').val(),
         
          
          };
       ;

          if (descripcion.length < 5) {
            alert('La descripción debe contener al menos 5 caracteres');
          }else
          {
             // ENVIO LOS DATOS DE LA SOLICITUD
             $.ajax({
              type: "PUT",
              url: "http://172.16.0.46:70/solicitudes/"+id_solicitud,
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
                window.location = '/actualizar_solicitud/'+id_solicitud;
                }, 1500);
        
               

              }
            });

          }
     

          

           
  
});

