

<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/chart.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/chartjs-plugin-datalabels.js"></script>
<style>
table.dataTable thead,
table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
}

/* Estilos para gráficos en grupos de dos */
.charts-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}



.chart-container {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
}



/* Estilos para los controles */
.date-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.date-label {
    min-width: 70px;
}

.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}


    .chart-container {
        width: 48%; /* Ajustado para dos gráficos por fila */
        height: 380px;
        display: inline-block; /* Permite que los contenedores estén en la misma línea */
        margin: 5px; /* Espacio entre los gráficos */
    }
    .chart-row {
        width: 100%;
        overflow: hidden; /* Limpia el float */
    }

    .chart-container h2 {
    font-size: 16px;
}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

</div>

    <div class="content">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Gráficas</h3>
                        </div>
                    </div>
                    
                    <div class="card-body">

                        <style>
                            #search-button {
                                position: absolute; /* Para posicionarlo en la esquina */
                                top: 10px; /* Ajusta según sea necesario */
                                right: 10px; /* Ajusta según sea necesario */
                                z-index: 1000;
                                background-color: #007bff; /* Color de fondo */
                                color: white; /* Color del icono */
                                border: none; /* Sin borde */
                                border-radius: 50%; /* Botón redondeado */
                                width: 50px; /* Ancho del botón */
                                height: 50px; /* Alto del botón */
                                font-size: 20px; /* Tamaño del icono */
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
                                transition: background-color 0.3s, transform 0.3s;
                                display: flex; /* Para centrar el icono */
                                align-items: center; /* Centrar verticalmente */
                                justify-content: center; /* Centrar horizontalmente */
                                text-decoration: none; /* Sin subrayado */
                            }

                            #search-button:hover {
                                background-color: #0056b3; /* Color de fondo al pasar el ratón */
                                transform: scale(1.1); /* Aumentar tamaño al pasar el ratón */
                            }

                            #search-button:focus {
                                outline: none; /* Sin contorno al hacer clic */
                            }
                        </style>
                        <div class="d-flex justify-content-end">
                            <a id="search-button" href="<?php echo base_url(); ?>/vista_Encuesta" class="btn btn-light" title="Detalles">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>

                        
                        <div class="date-input-group mb-3">
                            <label for="fecha_inicio" class="date-label">Desde:</label>
                            <input type="date" 
                                class="form-control" 
                                value="<?php echo $fecha_inicio ?>"
                                name="desde" 
                                id="fecha_inicio">
                            
                            <label for="fecha_fin" class="date-label">Hasta:</label>
                            <input type="date" 
                                class="form-control" 
                                value="<?php echo $fecha_fin ?>"
                                name="hasta" 
                                id="fecha_fin">
                        </div>

                        <div class="btn-group">
                            <button type="button" 
                                    class="btn btn-sm btn-primary consultar">
                                Consultar
                            </button>
                            <button type="button" 
                                    class="btn btn-sm btn-secondary limpiar">
                                Limpiar
                            </button>
                        </div>

                        <div class="chart-row">
                            <?php foreach ($graficos as $key => $grafico): ?>
                                <div class="chart-container">
                                    <h2><?= $grafico['pregunta'] ?></h2>
                                    <canvas id="grafico<?= $key ?>" ></canvas>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="miModal" class="modal fade" 
     tabindex="-1" role="dialog" 
     aria-labelledby="miModalLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-xl" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="miModalLabel">Detalles de la Respuesta</h4>
                <span class="cerrar" data-dismiss="modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="table-responsive"> 
                    <table class="display table table-striped table-hover" id="tablaDatos" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20%;">Nombres</th>
                                <th class="text-center" style="width: 5%;">Trámite</th>
                                <th class="text-center" style="width: 46%;"> Observación</th>
                                <th class="text-center" style="width: 5%;">Respuesta</th>
                                <th class="text-center" style="width: 5%;">Teléfono</th>
                                <th>Propiedad Intelectual</th>
                               
                                <th class="text-center" style="width: 5%;">Ver</th> 
                                <th style="width: 0%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div> 
    </div>
</div>
<style>
/* CLAVE: Habilitar el Scroll de la Pantalla Principal (Mantenido) */
body.modal-open {
    overflow: auto !important; 
    padding-right: 0 !important; 
}

/* ------------------------------------------------------------------- */
/* 1. AJUSTE DE MARGEN Y ALTURA DEL MODAL (AÚN MÁS BAJO) */
/* ------------------------------------------------------------------- */

#miModal .modal-dialog {
    /* CLAVE: Aumentar el margen vertical a 5rem para bajarlo más */
    margin: 7rem auto; 
    
    /* Ajustamos la altura mínima para que quepa con el nuevo margen (5rem + 5rem = 10rem) */
    min-height: calc(100vh - 10rem); 
}

#miModal .modal-content {
    height: 100%; 
}

#miModal .modal-body {
    /* Define la altura máxima del cuerpo y activa el scroll vertical */
    /* El valor 200px debe ser ajustado si tu header/footer es más grande */
    max-height: calc(100vh - 200px); 
    overflow-y: auto; 
    padding: 0;
}

/* ------------------------------------------------------------------- */
/* 2. ESTÉTICA Y FUNCIONALIDAD (Mantenido) */
/* ------------------------------------------------------------------- */

#miModal .modal-header {

    color: white;
    border-bottom: none;
    position: relative; 
}

#miModal .modal-header .cerrar {
    color: white; 
    font-size: 30px; 
    line-height: 1;
    cursor: pointer;
    position: absolute; 
    top: 10px;
    right: 15px;
    opacity: 0.7;
    transition: opacity 0.2s;
}

#miModal .modal-header .cerrar:hover {
    opacity: 1;
}

/* Estilos de DataTables y responsividad */
#miModal #tablaDatos {
    width: 100% !important; 
}

#miModal .table-responsive {
    padding: 15px; 
}
</style>



<script>
    const chartConfigs = [];
    <?php foreach ($graficos as $key => $grafico): ?>
        chartConfigs.push({
            id: 'grafico<?= $key ?>',
            type: 'pie',
            // --- AÑADIR ESTA LÍNEA ---
            questionText: '<?= addslashes($grafico['pregunta']) ?>', 
            // --------------------------
            labels: [
                <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                    '<?= addslashes($respuesta['tipo']) ?>',
                <?php endforeach; ?>
            ],
            data: [
                <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                    <?= $respuesta['total_respuestas'] ?>,
                <?php endforeach; ?>
            ],
            total_respuestas: [
                <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                    <?= $respuesta['total_respuestas'] ?>,
                <?php endforeach; ?>
            ],
            porcentajes: <?= json_encode(array_column($grafico['respuestas'], 'porcentaje')) ?>,
            responseData: <?= json_encode($grafico['respuestas']) ?>,
            questionId: '<?= $key ?>'
        });
    <?php endforeach; ?>
</script>
