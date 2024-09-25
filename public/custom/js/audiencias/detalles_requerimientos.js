
// Seleccionar todos los checkbox
document.getElementById('selectAll').addEventListener('click', function() {
    var checkboxes = document.getElementsByName('select[]');
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = this.checked;
    }
  });





// LINK DE LOS NUMEROS DE SOLICITUDES
$('#table_audiencia tbody a').on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    window.location = '/detalles_solicitudes/' + id;
    
    });
// Obtener el select, el botón y los checkboxes
const selectElement = document.querySelector('select[name="id_trabajador"]');
const remitirButton = document.getElementById('remitir');
const checkboxes = document.getElementsByName('select[]');
const selectAllCheckbox = document.getElementById('selectAll');
// Agregar un evento al checkbox "select all"
selectAllCheckbox.addEventListener('click', function() {
  // Alternar el estado de los checkboxes
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = this.checked;
  }
  // Verificar si al menos un checkbox está seleccionado
  const alMenosUnoSeleccionado = Array.prototype.some.call(checkboxes, (checkbox) => checkbox.checked);
  // Habilitar o deshabilitar el select y el botón
  selectElement.disabled = !alMenosUnoSeleccionado;
 remitirButton.disabled = !alMenosUnoSeleccionado;
});

// Agregar un evento a cada checkbox
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('click', function() {
    const alMenosUnoSeleccionado = Array.prototype.some.call(checkboxes, (checkbox) => checkbox.checked);
    selectElement.disabled = !alMenosUnoSeleccionado;
    remitirButton.disabled = !alMenosUnoSeleccionado;
  });
});

