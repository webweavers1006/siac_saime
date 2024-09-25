let fecha_recivido=$("#fecha-recibido").val();


    if (fecha_recivido>getFormattedDate()) 
    {
     alert('La fecha de creación no debe ser mayor al dia de hoy ')
    }



console.log(getFormattedDate());