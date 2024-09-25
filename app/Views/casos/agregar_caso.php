
<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/agregar_caso.css">



<style>


:root {
    --primary-color: rgb(11, 78, 179);
  }
  
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }
  
  /* Progressbar */
  .progressbar {
    position: relative;
    display: flex;
    justify-content: space-between;
    counter-reset: step;
    margin: 2rem 0 4rem;
  }
  
  .progressbar::before,
  .progress {
    content: "";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 4px;
    width: 100%;
    background-color: #dcdcdc;
    z-index: -1;
  }
  
  .progress {
    background-color: var(--primary-color);
    width: 0%;
    transition: 0.3s;
  }
  
  .progress-step {
    width: 2.1875rem;
    height: 2.1875rem;
    background-color: #dcdcdc;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .progress-step::before {
    counter-increment: step;
    content: counter(step);
  }
  
  .progress-step::after {
    content: attr(data-title);
    position: absolute;
    top: calc(100% + 0.5rem);
    font-size: 0.85rem;
    color: #666;
  }
  
  .progress-step-active {
    background-color: var(--primary-color);
    color: #f3f3f3;
  }
  
  .form {

    /* other styles */
  
    margin: 2rem auto;
  
    border: 1px solid #ccc;
  
    border-radius: 0.35rem;
  
    padding: 1.5rem;
  
  }


  
  .form-step {
    display: none;
    transform-origin: left;
    animation: animate 0.5s;
  }
  
  .form-step-active {
    display: block;
  }
  
  .input-group {
    margin: 2rem 0;
  }
  
  @keyframes animate {

from {

  transform: translateX(100%);

}

to {

  transform: translateX(0);

}

}
  
  /* Button */
  .btns-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
  
  .btn {
    padding: 0.75rem;
    display: block;
    text-decoration: none;
    background-color: var(--primary-color);
    color: #f3f3f3;
    text-align: center;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: 0.3s;
  }
  .btn:hover {
    box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-color);
  }



.bodersueve_fieldset {
    margin: left 1px;
    margin-right: 1px;
    height: auto;
    border-radius: 5px 5px 5px 5px;
    border: 1px solid rgb(209, 205, 207);
    font-size: 16px;
    outline: none;
}

.card-body {
    opacity: 0;
    animation: fade-in 1s forwards;
}




.fondo {
    border-top: 5px solid #496a77;
    border-radius: 10px 10px 10px 10px;
}
/* Añade algo de margen en la parte superior de la página */
.content-header {
    margin-top: 2rem;
  }
  
  
  
  
  /* Estiliza el botón de envío */
  .card-footer button {
    background-color: #496a77;
    color: #e2f3fa;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 2rem;
    font-size: 1rem;
    cursor: pointer;
  }
  
  /* Estiliza el botón de envío al pasar el cursor por encima */
  .card-footer button:hover {
    background-color: #323346;
  }
  
  /* Estiliza el botón de envío al hacer clic */
  .card-footer button:active {
    background-color: #e6e6e6;
  }
  
  .content-header
  {
    margin: 0;
    margin-left: 22%;
    position: relative;
    width: 70%;
  }
 
  
  /* Estiliza la etiqueta del área de texto */
  .form-group label[for="requerimiento-usuario"] {
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  
  /* Estiliza el área de texto */
  #requerimiento-usuario {
    height: 5rem;
  }
  
  /* Estiliza los elementos de selección */
  .form-group select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 14 8'><polygon points='0,0 14,0 7,7'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px
  }

  #requerimiento-usuario{
    width: 80%;
  }

  .textarea{
    width: 80%;
  }
</style>
<div class="content-header">
  <div class="container">



  <form action="#" class="form">
        <h1 class="text-center">Agregar caso</h1>
        <!-- Progress bar -->
        <div class="progressbar">
          <div class="progress" id="progress"></div>
          <div
          class="progress-step progress-step-active" data-title=" Beneficiario"></div>
          <div class="progress-step" data-title="Direccion"></div>
          <div class="progress-step" data-title="Atencion"></div>
        </div>
        <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6">
          <div style="display: flex;">  <label for="cedula-persona">Buscar Cédula o Rif  &nbsp;&nbsp;&nbsp; </label>
            <input type="text" class="form-control" style="width: 200px;"  name="cedula-existente" min="7" id="cedula-existente" autocomplete="off">
            &nbsp;&nbsp;&nbsp; <button type="button" style="font-size: 11px;" id="btn_buscar" class="btn btn-xs btn-primary btn_buscar">Buscar</button>
          </div>
        </div>
        </div>

     
        <!-- Steps -->
        <div class="form-step form-step-active">
        <div class="col-lg-3 col-sm-3 col-md-3">   
          </div>
        <div class="row">
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="nombre-persona">Nombre</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-persona" id="nombre-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="apellido-persona">Apellido</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="apellido-persona" id="apellido-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="tipo-persona">Tipo de Persona</label>
              <select class="form-control" id="tipo-persona" name="tipo-persona">
              <option value="V">V - Venezolano</option>
              <option value="E">E - Extranjero</option>
              <option value="J">J - Jurídico</option>
              <option value="G">G - Gubernamental</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="cedula-persona">Nº Cédula o Rif</label>
              <input type="text" class="form-control" onkeypress="return valideKey(event);"name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
          </div>
          <div class="col-lg-1 col-sm-1 col-md-1">
              <label for="edad">Edad</label>
              <input type="text" class="form-control" onkeypress="return valideKey(event);" name="edad" id="edad"  autocomplete="off" required>
          </div>
          
          <div class="col-lg-2 col-sm-2 col-md-2">
              <label for="fecha-nacimiento">Fecha de Nac.</label>
              <input class="form-control" type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="apellido-persona">Profesión</label>
              <input type="text" class="form-control" onkeyup="mayus(this);" name="profesion" id="profesion" onkeypress="noNumeros(event)" autocomplete="off" required>
          </div>

          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="t-beneficiario">Tipo de Beneficiario</label>
              <select class="form-control" id="t-beneficiario" name="t-beneficiario">
              <option value="1" selected>Usuario</option>
              <option value="2">Emprendedor</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="tipo-persona">Género</label>
              <select class="form-control" id="sexo" name="tipo-persona">
              <option value="1">Masculino</option>
              <option value="2">Femenino</option>
              </select>
          </div>
          <div class="col-lg-3 col-sm-3 col-md-3">
              <label for="telefono-persona">Teléfono</label>
              <input type="text" class="form-control" onkeypress="return valideKey(event);" name="telefono" id="telefono" autocomplete="off">
          </div>
          <div class="col-lg-2 col-sm-2 col-md-2">
              <label for="fecha-recibido">Fecha de Recibido</label>
              <input class="form-control" type="date" name="fecha-recibido" id="fecha-recibido" required>
          </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
          <label for="red-social">Via de Atención</label>
          <select class="form-control" name="red-social" id="red-social">
          <option value="0" disabled>Seleccione</option>
          </select>
      </div>



      <?php if ($session->get('userrol') == 4 ) { ?> 
      <div class="col-lg-4 col-sm-4 col-md-4">
      <label for="">Dirección</label>
          <select class="form-control" name="office" id="office">
          <option value="1" selected>Dirección de Atención Estadal</option>
          </select>
      </div>
      <?php } ?>




      <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 2 or $session->get('userrol') == 3 or $session->get('userrol') == 5 ) { ?> 
      <div class="col-lg-4 col-sm-4 col-md-4">
      <label for="">Dirección</label>
          <select class="form-control" name="office" id="office">
          <option value="1" selected>Dirección de Atención al Ciudadano</option>
          <option value="2">Dirección de Atención Estadal</option>
          </select>
      </div>
      <?php } ?>
      <div class="col-lg-5 col-sm-5 col-md-5">
          <label for="correo">Correo Electrónico</label>
          <input type="email" class="form-control" name="correo" id="correo" autocomplete="off" required>
      </div>
          </div>
          <br>
          <div class="">
            <a href="#" class="btn btn-next width-50 ml-auto">SIGUIENTE</a>
          </div>
        </div>

        <div class="form-step">
          <div class="row">

          <div class="col-4">
              <label for="pais-caso">País</label>
              <select id="pais-caso"  disabled="disabled"name=" pais-caso" class="form-control">
              <option value="1" selected disabled>Venezuela</option>
              </select>
          </div>
          <div class="col-4">
              <label for="estado-caso">Estado</label>
              <select id="estado-caso" name="estado-caso" class="form-control">
              <option value="0" disabled>Seleccione Estado</option>

              </select>
          </div>
          <div class="col-4">
              <label for="municipio-caso">Municipio</label>
              <select id="municipio-caso" name="municipio-caso" class="form-control">
              <option value="0">Seleccione Municipio</option>
              </select>
          </div>

          <div class="col-4">
              <label for="parroquia-caso">Parroquia</label>
              <select id="parroquia-caso" name="parroquia-caso" class="form-control">
              <option value="0">Seleccione Parroquia</option>
              </select>
          </div>

          <div class="col-lg-4 col-sm-4 col-md-4">
              <label for="tipo-pi">Tipo de Atención</label>
              <select class="form-control" id="tipo-atencion-usu" name="tipo-atencioni-usu">
              <option value="0" disabled>Seleccione</option>
              </select>
          </div>


          <div class="col-lg-4 col-sm-4 col-md-4">
              <label for="tipo-pi">Tipo de Propiedad Intelectual </label>
              <select disabled class="form-control" id="tipo-pi" name="tipo-pi">
              <option value="0" disabled>Seleccione</option>
              </select>
          </div>
          </div>
          <!-- FORMULARIO PARA EL CASO DE ASESORIA -->
          <div class="row" id="cgr" style="display: none;">

  <div class="col-lg-4 col-sm-4 col-md-4">
    <label for="competancia-cgr">Ente asdcrito</label>
    <select class="form-control" id="ente-adscrito" name="competencia-cgr" value="0">
      <option value=" 0" selected disabled>Seleccione</option>
    </select>
  </div>
  <div class="col-lg-3 col-sm-3 col-md-3">
    <label for="competancia-cgr">Competencia de CGR</label>
    <select class="form-control" id="competencia-cgr" name="competencia-cgr" value="0">
      <option value=" 0" selected disabled>Seleccione</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select>
  </div>
  <div class="col-lg-3 col-sm-3 col-md-3">
    <label for="asume-cgr">Asume CGR</label>
    <select class="form-control" id="asume-cgr" name="asume-cgr" value="0">
      <option value="0" selected disabled>Seleccione</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select>
  </div>
  </div>
  <br>

  <!-- FORMULARIO PARA EL CASO DE DENUNCIAS -->
  <div class="row" id="denuncias" style="display: none;">

  <div class="col-lg-8">
  <label for="asume-cgr">A quien afecta el hecho:</label>&nbsp;&nbsp;
  <input type="radio" id="option-personal" name="option" value="personal">&nbsp;&nbsp;
  <span>Personal</span>&nbsp;&nbsp;
  <input type="radio" id="option-comunidad" name="option" value="comunidad">&nbsp;&nbsp;
  <span>Comunidad</span>&nbsp;&nbsp;
  <input type="radio" id="option-terceros" name="option" value="terceros">&nbsp;&nbsp;
  <span>Terceros</span>&nbsp;&nbsp;
  </div>
  <label for="fecha-hechos">Fecha de los hechos</label>
  <div class="col-lg-2">
    <input class="form-control" type="date" name="fecha-hechos" id="fecha-hechos" value=" ">
  </div>

  <div class="col-10">
    &nbsp;&nbsp;<label for="denu-involucrados">Indique Personas , Organismos o Instituciones Involucradas en los hechos :</label>
    
    <textarea type="text" class="form-control" name="denu-involucrados" id="denu-involucrados">
  </textarea>
  </div>
  <div class="col-11">
    <br>
    <label>EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE :</label>
    <div class=" row">
      <div class="col-lg-5 col-sm-5 col-md-5">
        <label for="nombre-instancia">Nombre de la instancia del Poder Popular</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-instancia" id="nombre-instancia" autocomplete="off">
      </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
        <label for="rif-instancia">Rif:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="rif-instancia" id="rif-instancia" autocomplete="off">
      </div>
      <div class="col-lg-4 col-sm-4 col-md-4">
        <label for="ente-financiador">Ente Financiador:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="ente-financiador" id="ente-financiador" autocomplete="off">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 col-sm-5 col-md-5">
        <label for="nombre-proyecto">Nombre del Proyecto:</label>
        <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-proyecto" id="nombre-proyecto" autocomplete="off">
      </div>
      <div class="col-lg-3 col-sm-3 col-md-3">
        <label for="monto-aprovado">Monto Aprobado:</label>
        <input type="text" class="form-control" onkeypress="return valideKey(event);" name="monto-aprovado" id="monto-aprovado" onkeypress="noNumeros(event)" autocomplete="off">
      </div>
    </div>

      </div>
    </div>
                          <br>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">ANTERIOR</a>
          <a href="#" class="btn btn-next">SIGUIENTE</a>
        </div>
      </div>
      
    


      <div class="form-step">
         <div class="row">
       
        <div>
            <label for="planteamiento-caso">Descripción del Caso</label>
            <textarea type="text" class="form-control"     style="width: 1000px;"      name="requerimiento-usuario" id="requerimiento-usuario" required>
            </textarea>
        </div>
            
        </div>
       
         <br>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">Previous</a>
          <button type="button" class="btn  btn-sm  btn-primary" id="guardar">Guardar</button>
        </div>
      </div>

      
    </form>
  
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
 

  <script>


function getFormattedDate() {
  const date = new Date();
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}
</script>


  <script>

const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {

    let nombre_persona = $("#nombre-persona").val();
    let apellido_persona = $("#apellido-persona").val();
    let cedula_persona = $("#cedula-persona").val();
    let red_social = $("#red-social").val();
    let edad = $("#edad").val();
    let fecha_nacimiento = $("#fecha-nacimiento").val();
    let profesion = $("#profesion").val();
    let correo = $("#correo").val();
    let estado = $("#estado-caso").val();
    let tipo_atencion = $("#tipo-atencion-usu").val();
    let tipo_prop_intelec = $("#tipo-pi").val();
    let fecha_recivido=$("#fecha-recibido").val();

    if (fecha_recivido>getFormattedDate()) 
    {
     alert('La fecha de creación no debe ser mayor al dia de hoy ')
    }else if (nombre_persona == '') {
        $("#nombre-persona").addClass('is-invalid');

        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL NOMBRE.</strong>',

            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    } else if (apellido_persona == '') {
        $("#nombre-persona").removeClass('is-invalid');
        $("#apellido-persona").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL APELLIDO.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    } else if (cedula_persona == '') {
        $("#apellido-persona").removeClass('is-invalid');
        $("#cedula-persona").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL NÚMERO DE CEDULA.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
      
      else if (edad == '') {
        $("#apellido-persona").removeClass('is-invalid');
        $("#edad").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR LA EDAD </strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
      else if (fecha_nacimiento == '' ||fecha_nacimiento == 'NULL'  ) {
        $("#edad").removeClass('is-invalid');
        $("#fecha-nacimiento").addClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR LA DE FECHA DE NACIMIENTO </strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    
      } 
      
      
      
      
      
      else if (red_social == null) {
        $("#red-social").addClass('is-invalid');
        $("#cedula-persona").removeClass('is-invalid');
        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE SELECCIONAR LA VIA DE ATENCION.</strong>',

            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    }else if (correo == '') {
      $("#red-social").removeClass('is-invalid');
        $("#correo").addClass('is-invalid');

        Swal.fire({
            icon: "success",
            type: 'error',
            html: '<strong>DEBE INGRESAR EL CORREO ELECTRONICO.</strong>',
            toast: true,
            position: "center",
            showConfirmButton: false,
            timer: 3500,
        });
    }
    
 
    

    else
    {
      if (formStepsNum>0) {
        if (estado == null) 
        {
          $("#correo").removeClass('is-invalid');
          $("#estado-caso").addClass('is-invalid');
          Swal.fire({
              icon: "success",
              type: 'error',
              html: '<strong>EL CAMPO ESTADO ES OBLIGATORIO.</strong>',
              toast: true,
              position: "center",
              showConfirmButton: false,
              timer: 3500,
          });
        }else if (tipo_atencion == null) 
        {
          $("#estado-caso").removeClass('is-invalid');
          $("#tipo-atencion-usu").addClass('is-invalid');
          Swal.fire({
              icon: "success",
              type: 'error',
              html: '<strong>EL USUARIO DEBE TENER ALGUN TIPO DE ATENCION</strong>',
              toast: true,
              position: "center",
              showConfirmButton: false,
              timer: 3500,
          })
        }else if (tipo_atencion == 1&& tipo_prop_intelec==null) 
        {
            $("#tipo-atencion-usu").removeClass('is-invalid');
              $("#tipo-pi").addClass('is-invalid');
              Swal.fire({
                  icon: "success",
                  type: 'error',
                  html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>',
                  toast: true,
                  position: "center",
                  showConfirmButton: false,
                  timer: 3500,
              });

        }else  if (tipo_atencion === '5') 
          {
            let denu_involucrados = $('#denu-involucrados').val();
            let fecha_hechos = $('#fecha-hechos').val();
            denu_involucrados = denu_involucrados.trim();
            if (document.getElementById('option-personal').checked) {
                option_personal = true
            } else {
                option_personal = false
            }
            if (document.getElementById('option-comunidad').checked) {
                option_comunidad = true
            } else {
                option_comunidad = false
            }
            if (document.getElementById('option-terceros').checked) {
                option_terceros = true
            } else {
                option_terceros = false
            }

            if (option_personal == false && option_comunidad == false && option_terceros == false) {
                alert('Debe indicar a quien afecta el hecho');
            }else {
               

                if (fecha_hechos == '') {
                    alert('Debe selecciar la fecha en que ocurrieron los hechos');

                } else if (denu_involucrados === '') {
                    $("#denu-involucrados").addClass('is-invalid');
                    alert('Este campo es requerido , por favor introduzca la informacion solicitada');
                }else
                {
                  formStepsNum++;
                  updateFormSteps();
                  updateProgressbar();
                }
              }
          } else
                {
                  formStepsNum++;
                  updateFormSteps();
                  updateProgressbar();
                }
         



      }else
      {
        formStepsNum++;
       updateFormSteps();
      updateProgressbar();
      }
   


    }

  });
});
    
prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum--;
  
    updateFormSteps();
    updateProgressbar();
    
  });
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressbar() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formStepsNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

  </script>
</html>

     
      <!-- ***** FUNCION PARA SOLO LETRAS***-** -->
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>


      
<!-- ***** FUNCION PARA SOLO NUMEROS***-** -->
<script type="text/javascript">
  function valideKey(evt) {
    var code = (evt.which) ? evt.which : evt.keyCode;
    if (code == 8) { // backspace.
      return true;
    } else if (code >= 48 && code <= 57) { // is a number.
      return true;
    } else { // other keys.
      return false;
    }
  }
</script>

     

      <script>
      document.addEventListener('DOMContentLoaded', function() {
      const textarea = document.getElementById('denu-involucrados');
      textarea.addEventListener('click', function() {
      if (textarea.value.trim() === '') {
      textarea.setSelectionRange(0, 0);
      } else {
      textarea.setSelectionRange(textarea.value.length, textarea.value.length);
      }
      });
      });
      </script>

      