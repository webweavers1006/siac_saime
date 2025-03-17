<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/tailwind.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/encuesta.css">
</head>
<body>
<style>
        /* Estilos para el contenedor de cada icono */
        .icono-contenedor {
            position: relative;
            display: inline-block;
            width: 100px; /* Tamaño del contenedor */
            height: 100px; /* Tamaño del contenedor */
            margin: 20px; /* Espacio entre iconos */
        }

        /* Estilos para la estrella */
        .estrella {
            position: absolute;
            top: -10px; /* Posición vertical de la estrella */
            left: 50%; /* Centra la estrella horizontalmente */
            transform: translateX(-50%); /* Ajusta el centrado */
            width: 30px; /* Tamaño de la estrella */
            height: 30px; /* Tamaño de la estrella */
            z-index: 1; /* Asegura que la estrella esté encima del icono */
        }

        /* Estilos para el icono */
        .icono {
            width: 100%; /* Tamaño del icono */
            height: 100%; /* Tamaño del icono */
        }
    </style>
    <div class="content-wrapper">
       
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                    <br>  <br>
                        <div class="card">
                            <div class="card-header border-0"></div>
                            
                            <div class="card-body">
                            <h2 class="text-center  font-semibold ">Detalle de la Encuesta de Sastifación</h2>
                            <br>  
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                            <div class="flex flex-wrap justify-center">
                                              <!-- Muy Satisfecho -->
                                              <div class="inline-flex items-center m-2">
                                                  <span class="inline-block w-4 h-4 rounded-md me-2" style="background-color: #77dd77;"></span>&nbsp;&nbsp;
                                                  <span class="text-gray-600 dark:text-neutral-400 text-center">Muy Satisfecho</span>
                                              </div>
                                              <!-- Satisfecho -->
                                              <div class="inline-flex items-center m-2">
                                                  <span class="inline-block w-4 h-4 rounded-md me-2" style="background-color: #a9e9a4;"></span>&nbsp;&nbsp;
                                                  <span class="text-gray-600 dark:text-neutral-400 text-center">Satisfecho</span>
                                              </div>
                                              <!-- Neutral -->
                                              <div class="inline-flex items-center m-2">
                                                  <span class="inline-block w-4 h-4 rounded-md me-2" style="background-color: #606061;"></span>&nbsp;&nbsp;
                                                  <span class="text-gray-600 dark:text-neutral-400 text-center">Neutral</span>
                                              </div>
                                              <!-- Insatisfecho -->
                                              <div class="inline-flex items-center m-2">
                                                  <span class="inline-block w-4 h-4 rounded-md me-2" style="background-color: #ec8800;"></span>&nbsp;&nbsp;
                                                  <span class="text-gray-600 dark:text-neutral-400 text-center">Insatisfecho</span>
                                              </div>
                                              <!-- Muy Insatisfecho -->
                                              <div class="inline-flex items-center m-2">
                                                  <span class="inline-block w-4 h-4 rounded-md me-2" style="background-color: #ff9800;"></span>&nbsp;&nbsp;
                                                  <span class="text-gray-600 dark:text-neutral-400 text-center">Muy Insatisfecho</span>
                                              </div>
                                          </div>                       
                                   <form id="surveyForm">
                                                    <div class="md:w-4/6 sm:w-4/5 a md:w-full  sm:w-5/6" id="questionsContainer">
                                                        <!-- Los bloques de preguntas se insertarán aquí -->
                                                    </div>
                                    </form>
                 
                                    <section>

                                    
                                        <div class="mx-auto w-full lg:py-2 mt-16 opinion  " style="display: none;"  >
                                            <div class="max-w-screen-xl sm:text-lg">
                                                <p class="font-medium text-center text-gray-700">
                                                    ¡Opinión del participante!
                                                </p>
                                            </div>
                                        </div>
                                      

                                        <?php
                                                $comentarios = $comentario['encuestass']; 
                                                $id_participante = (int)$id_participante; 
                                                $comentarioEncontrado = false; 

                                                foreach ($comentarios as $encuesta) {
                                                    if ($encuesta['id'] === $id_participante) {
                                                        $textoComentario = htmlspecialchars($encuesta['comentario']); // Escapamos el texto para evitar problemas de seguridad
                                                        echo '<div class="">
                                                                <textarea class="flex flex-col bg-gray-200 rounded-lg p-4 justify-center mt-8 gap-2 w-full no-focus comentario" style="display: none;" placeholder="" id="comentario" readonly>' . $textoComentario . '</textarea>
                                                                <label class="textarea-floating-label" for="comentario"></label>
                                                            </div>'; 
                                                        $comentarioEncontrado = true; 
                                                        break; 
                                                    }
                                                }

                                                // Si no se encontró el comentario, puedes mostrar un mensaje
                                                if (!$comentarioEncontrado) {
                                                    echo '<p>No se encontró el comentario para el participante.</p>';
                                                }
                                                ?>

                                                <style>
                                                /* CSS para eliminar el efecto de enfoque */
                                                .no-focus:focus {
                                                    outline: none; /* Elimina el contorno */
                                                    box-shadow: none; /* Elimina la sombra */
                                                }
                                                </style>
                                    </section>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                           
                      
               

    
    </div>
    </div>
    </div>
    </div>
     
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const detalleEncuesta = <?php echo json_encode($detalle_encuesta); ?>;
        const preguntas = detalleEncuesta.EncuestaFiltroPregFuncs;
        const container = document.getElementById('questionsContainer');

        preguntas.forEach(item => {
            const preguntaDiv = crearPreguntaDiv(item);
            container.appendChild(preguntaDiv);
        });

        function crearPreguntaDiv(item) {
    const leyenda = {
        1: "Muy satisfecho",
        2: "Satisfecho",
        3: "Neutral",
        4: "Insatisfecho",
        5: "Muy insatisfecho",
    };

    // Crear el contenedor principal de la pregunta
    const preguntaDiv = document.createElement('div');
    preguntaDiv.className = "flex flex-col bg-gray-200 rounded-lg p-4 justify-center mt-8 gap-2";

    // Crear un contenedor para la pregunta y los íconos
    const preguntaIconosDiv = document.createElement('div');
    preguntaIconosDiv.className = "flex flex-row justify-between items-center w-full";

    // Crear el texto de la pregunta
    const preguntaTexto = document.createElement('p');
    preguntaTexto.className = "text-gray-600";
    preguntaTexto.textContent = item.pregunta || "Pregunta sin título";

    // Crear un contenedor para los íconos y la leyenda
    const iconosLeyendaDiv = document.createElement('div');
    iconosLeyendaDiv.className = "flex flex-col items-end"; // Alinear íconos y leyenda a la derecha

    // Crear el contenedor de los ratings
    const ratingDiv = crearRatingDiv(item.id, item.respuesta);
    ratingDiv.className += " mb-2"; // Margen inferior para separar íconos de la leyenda

    // Crear un span para mostrar la leyenda si hay una respuesta
    const leyendaSpan = document.createElement('span');
    leyendaSpan.className = "py-2 px-4 w-full badge badge-primary bg-[#0e52cc] badge-lg text-white rounded-lg transition duration-300 ease-in-out";
    leyendaSpan.textContent = item.respuesta ? leyenda[item.respuesta] : '';

    // Añadir los íconos y la leyenda al contenedor iconosLeyendaDiv
    iconosLeyendaDiv.appendChild(ratingDiv);  // Íconos arriba
    iconosLeyendaDiv.appendChild(leyendaSpan); // Leyenda abajo

    // Añadir la pregunta y el contenedor de íconos/leyenda al contenedor de preguntaIconosDiv
    preguntaIconosDiv.appendChild(preguntaTexto);
    preguntaIconosDiv.appendChild(iconosLeyendaDiv);

    // Añadir los elementos al contenedor de la pregunta
    preguntaDiv.appendChild(preguntaIconosDiv); // Pregunta a la izquierda, íconos y leyenda a la derecha

    return preguntaDiv;
}
        function crearRatingDiv(idPregunta, respuesta) {
            const ratingDiv = document.createElement('div');
            ratingDiv.className = "w-full xl:w-auto flex justify-center";
            ratingDiv.innerHTML = `
                <div style="max-width:230px;width:100%">
                    <div class="rr--group" role="radiogroup" aria-required="false" aria-label="Rating Selection">
                        ${[1, 2, 3, 4, 5].map(rate => crearRatingBox(rate, idPregunta, respuesta)).join('')}
                        <div class="rr--reset" role="radio" aria-label="Reset rating" aria-checked="true" tabindex="0"></div>
                    </div>
                </div>

                
            `;
            return ratingDiv;
        }




        function crearRatingBox(rate, idPregunta, respuesta) {
    // Definir los colores según la respuesta
    const colores = {
        1: "#77dd77", // Verde claro
        2: "#a9e9a4", // Verde más claro
        3: "#606061", // Gris
        4: "#ec8800", // Naranja
        5: "#ff9800", // Naranja oscuro
    };
    
  
    // Determinar el color basado en la respuesta
    const colorIcono = colores[respuesta] || "#a7acb8";
    
    // Iconos SVG (puedes personalizarlos si es necesario)
    const iconos = [
        // Calificación 1
        
        `<svg aria-hidden="true" class="rr--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet">
            <g shape-rendering="geometricPrecision">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM96.8 314.1c-3.8-13.7 7.4-26.1 21.6-26.1l275.2 0c14.2 0 25.5 12.4 21.6 26.1C396.2 382 332.1 432 256 432s-140.2-50-159.2-117.9zM217.6 212.8s0 0 0 0c0 0 0 0 0 0l-.2-.2c-.2-.2-.4-.5-.7-.9c-.6-.8-1.6-2-2.8-3.4c-2.5-2.8-6-6.6-10.2-10.3c-8.8-7.8-18.8-14-27.7-14s-18.9 6.2-27.7 14c-4.2 3.7-7.7 7.5-10.2 10.3c-1.2 1.4-2.2 2.6-2.8 3.4c-.3 .4-.6 .7-.7 .9l-.2 .2c0 0 0 0 0 0c0 0 0 0 0 0s0 0 0 0c-2.1 2.8-5.7 3.9-8.9 2.8s-5.5-4.1-5.5-7.6c0-17.9 6.7-35.6 16.6-48.8c9.8-13 23.9-23.2 39.4-23.2s29.6 10.2 39.4 23.2c9.9 13.2 16.6 30.9 16.6 48.8c0 3.4-2.2 6.5-5.5 7.6s-6.9 0-8.9-2.8c0 0 0 0 0 0s0 0 0 0zm160 0c0 0 0 0 0 0l-.2-.2c-.2-.2-.4-.5-.7-.9c-.6-.8-1.6-2-2.8-3.4c-2.5-2.8-6-6.6-10.2-10.3c-8.8-7.8-18.8-14-27.7-14s-18.9 6.2-27.7 14c-4.2 3.7-7.7 7.5-10.2 10.3c-1.2 1.4-2.2 2.6-2.8 3.4c-.3 .4-.6 .7-.7 .9l-.2 .2c0 0 0 0 0 0c0 0 0 0 0 0s0 0 0 0c-2.1 2.8-5.7 3.9-8.9 2.8s-5.5-4.1-5.5-7.6c0-17.9 6.7-35.6 16.6-48.8c9.8-13 23.9-23.2 39.4-23.2s29.6 10.2 39.4 23.2c9.9 13.2 16.6 30.9 16.6 48.8c0 3.4-2.2 6.5-5.5 7.6s-6.9 0-8.9-2.8c0 0 0 0 0 0s0 0 0 0s0 0 0 0z"></path>
            </g>
        </svg>`,
        // Calificación 2
        `<svg aria-hidden="true" class="rr--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet">
            <g shape-rendering="geometricPrecision">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM96.8 314.1c-3.8-13.7 7.4-26.1 21.6-26.1l275.2 0c14.2 0 25.5 12.4 21.6 26.1C396.2 382 332.1 432 256 432s-140.2-50-159.2-117.9zM144.4 192a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
            </g>
        </svg>`,
        // Calificación 3
        `<svg aria-hidden="true" class="rr--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet">
            <g shape-rendering="geometricPrecision">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM176.4 176a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm128 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM160 336l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path>
            </g>
        </svg>`,
        // Calificación 4
        `<svg aria-hidden="true" class="rr--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet">
            <g shape-rendering="geometricPrecision">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM159.3 388.7c-2.6 8.4-11.6 13.2-20 10.5s-13.2-11.6-10.5-20C145.2 326.1 196.3 288 256 288s110.8 38.1 127.3 91.3c2.6 8.4-2.1 17.4-10.5 20s-17.4-2.1-20-10.5C340.5 349.4 302.1 320 256 320s-84.5 29.4-96.7 68.7zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
            </g>
        </svg>`,
        // Calificación 5
        `<svg aria-hidden="true" class="rr--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet">
            <g shape-rendering="geometricPrecision">
                <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM338.7 395.9c6.6-5.9 7.1-16 1.2-22.6C323.8 355.4 295.7 336 256 336s-67.8 19.4-83.9 37.3c-5.9 6.6-5.4 16.7 1.2 22.6s16.7 5.4 22.6-1.2c11.7-13 31.6-26.7 60.1-26.7s48.4 13.7 60.1 26.7c5.9 6.6 16 7.1 22.6 1.2zM176.4 272c17.7 0 32-14.3 32-32c0-1.5-.1-3-.3-4.4l10.9 3.6c8.4 2.8 17.4-1.7 20.2-10.1s-1.7-17.4-10.1-20.2l-96-32c-8.4-2.8-17.4 1.7-20.2 10.1s1.7 17.4 10.1 20.2l30.7 10.2c-5.8 5.8-9.3 13.8-9.3 22.6c0 17.7 14.3 32 32 32zm192-32c0-8.9-3.6-17-9.5-22.8l30.2-10.1c8.4-2.8 12.9-11.9 10.1-20.2s-11.9-12.9-20.2-10.1l-96 32c-8.4 2.8-12.9 11.9-10.1 20.2s11.9 12.9 20.2 10.1l11.7-3.9c-.2 1.5-.3 3.1-.3 4.7c0 17.7 14.3 32 32 32s32-14.3 32-32z"></path>
            </g>
        </svg>`
    ];
    return `

<div class="rr--box rr--off"
    role="radio"
    aria-checked="${respuesta == rate}"
    tabindex="0"
    style="color: ${respuesta == rate ? colores[respuesta] : '#a7acb8'}; text-align: center;">
    ${iconos[rate - 1]}
</div>

`;
}
});
</script>
</body>