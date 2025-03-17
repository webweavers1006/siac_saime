

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

    <!-- Main content -->
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

                    
                                                <!-- Filtros de fecha -->
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

                            <!-- Botones de acción -->
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
</div>
<script>
    <?php foreach ($graficos as $key => $grafico): ?>
        var ctx<?= $key ?> = document.getElementById('grafico<?= $key ?>').getContext('2d');
        var grafico<?= $key ?> = new Chart(ctx<?= $key ?>, {
            type: 'pie',
            data: {
                labels: [
                    <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                        '<?= addslashes($respuesta['tipo']) ?>',
                    <?php endforeach; ?>
                ],
                datasets: [{
                    data: [
                        <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                            <?= $respuesta['total_respuestas'] ?>,
                        <?php endforeach; ?>
                    ],
                    backgroundColor: [
                        '#ec8800',
                        '#ff9800',
                        '#77dd77',
                        '#9ca3af',
                        '#a9e9a4',
                    ],
                    total_respuestas: [
                        <?php foreach ($grafico['respuestas'] as $respuesta): ?>
                            <?= $respuesta['total_respuestas'] ?>,
                        <?php endforeach; ?>
                    ]
                }],
            },
            options: {
                maintainAspectRatio: false,
                animation: false,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 40
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var index = tooltipItem.dataIndex;
                                var total = <?= json_encode(array_column($grafico['respuestas'], 'total_respuestas')) ?>[index];
                                var percentage = <?= json_encode(array_column($grafico['respuestas'], 'porcentaje')) ?>[index];

                                return [
                                    'Porcentaje: ' + percentage + '%',
                                    'Respuestas: ' + total
                                ];
                            },
                            footer: function() {
                                return ''; 
                            }
                        }
                    },
                    datalabels: {
                        color: 'black',
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, context) => {
                            const index = context.dataIndex; 
                            const total = context.chart.data.datasets[0].total_respuestas[index]; 
                            const percentage = ((total / context.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0)) * 100).toFixed(2); // Calcular el porcentaje
                            return total > 0 ? [' ' + percentage + '%', ' ' + ' '+' '+ ' '+' '+total] : ''; 
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    <?php endforeach; ?>
</script>