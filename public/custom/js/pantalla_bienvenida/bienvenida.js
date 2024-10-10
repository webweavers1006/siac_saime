// setTimeout(function() {
//     window.location = "/inicio";
// }, 2500);

window.addEventListener('load', function() {
    var imagen = document.querySelector('.form-login_imagen');
    imagen.style.opacity = 1;
});

// let rol = $("#rol").val();
// if (rol == 9 || rol == 5) {

//     setTimeout(function() {
//       const userData = localStorage.getItem('user_audiencia');
//       const userDataJson = JSON.parse(userData);
//       const token = userDataJson.token;
//       const url = `/inicio?token=${token}`;
//       location.href = url;
//     }, 700); // 700ms = 0.7 segundos
  
//   }

let rol = $("#rol").val();
if (rol == 9 || rol == 5) {
  setTimeout(function() {
    const userData = localStorage.getItem('user_audiencia');
    const userDataJson = JSON.parse(userData);
    const token = userDataJson.token;

    document.cookie = `token=${token}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;

    window.location.href = '/inicio';
  }, 700); // 700ms = 0.7 segundos
}

 