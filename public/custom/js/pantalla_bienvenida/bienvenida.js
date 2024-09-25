// setTimeout(function() {
//     window.location = "/inicio";
// }, 2500);

window.addEventListener('load', function() {
    var imagen = document.querySelector('.form-login_imagen');
    imagen.style.opacity = 1;
});

let rol = $("#rol").val();
if (rol == 9 || rol == 5) {
  setTimeout(function() {
    window.location = '/inicio';
  }, 700); // 5000ms = 5 seconds
}

