// // Para recuperar el objeto de almacenamiento local
//const user_audiencia = JSON.parse(localStorage.getItem('user_audiencia'));
 //console.log(user_audiencia); // salida el objeto almacenado// setTimeout(function() {
//     window.location = "/inicio";
// }, 2500);

// window.addEventListener('load', function() {
//     var imagen = document.querySelector('.form-login_imagen');
//     imagen.style.opacity = 1;
// });



let rol = $("#rol").val();
if (rol == 9 || rol == 5) {
  setTimeout(function() {
    const userData = localStorage.getItem('user_audiencia');
    const userDataJson = JSON.parse(userData);
    const token = userDataJson.token;
    const nivel_rol = userDataJson.id_rol;
 
    document.cookie = `nivel_rol=${nivel_rol}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
    document.cookie = `token=${token}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;

   window.location.href = '/inicio';
  }, 700); // 700ms = 0.7 segundos
}