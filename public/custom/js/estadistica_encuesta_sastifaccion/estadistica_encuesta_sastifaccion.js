$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let fecha_inicio = $('#fecha_inicio').val();
    let fecha_fin = $('#fecha_fin').val();
    $('#fecha_inicio').val(fecha_inicio);
    $('#fecha_fin').val(fecha_fin );

    if (fecha_inicio == '') {
        fecha_inicio = 'null'
    }
   

    if (fecha_fin == '') {
        fecha_fin = 'null'
    }
    if (fecha_inicio == 'null' && fecha_fin != 'null') {
        alert('DEDE INDICAR EL CAMPO DESDE');

    } else if (fecha_fin == 'null' && fecha_inicio != 'null') {
        alert('DEDE INDICAR EL CAMPO fecha_fin');
    } else if (fecha_fin < fecha_inicio) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO fecha_fin')
    }

   else
    {
   
        window.location='/vista_Grafica_Encuestas/'+fecha_inicio+'/'+fecha_fin;
    }
})
$(document).on('click', '.limpiar', function(e) {
  
    if (fecha_inicio == '') {
        fecha_inicio = 'null'
    }
   

    if (fecha_fin == '') {
        fecha_fin = 'null'
    }
    window.location='/vista_Grafica_Encuestas/'+null+'/'+null;

})