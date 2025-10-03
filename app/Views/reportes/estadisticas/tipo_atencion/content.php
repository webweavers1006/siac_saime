<!-- Content Wrapper. Contains page content -->


<script type="text/javascript" src="<?php echo base_url(); ?>/dist/chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">
<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1 class="mb-4">Estadísticas - Tipo de Atención</h1>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-md-3 mb-3">
        <div class="d-flex align-items-center">
          <label for="desde" class="form-label mb-0 me-2">Desde</label>
          <input type="date" class="form-control form-control-sm" value="<?= $desde ?>" name="desde" id="desde">
        </div>
      </div>
      
      <div class="col-md-3 mb-3">
        <div class="d-flex align-items-center">
          <label for="hasta" class="form-label mb-0 me-2">Hasta</label>&nbsp;&nbsp;&nbsp;
          <input type="date" class="form-control form-control-sm" value="<?= $hasta ?>" name="hasta" id="hasta">
        </div>
      </div>
      <input type="hidden" id="estado" value="<?= $estado ?>">

     
      <div class="col-md-3 mb-3">
        <div class="d-flex align-items-center">
          <label for="estado-caso" class="form-label mb-0 me-2">Estado</label>&nbsp;&nbsp;&nbsp;
          <select id="estado-caso" name="estado-caso" class="form-control form-control-sm">
            <option value="0" disabled selected>Seleccione Estado</option>
          </select>
        </div>
      </div>

      <div class="col-md-3 mb-3 d-flex justify-content-md-end align-items-center">
        <button type="button" class="btn btn-primary me-2 consultar">Consultar</button>
        <button type="button" class="btn btn-secondary limpiar">Limpiar</button>
      </div>
    </div>
  </div>
</section>




<!-- Main content -->
<section class="content">
<div class="card">
  <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
    <div id="reportPage">
      <div class="row">
        <div class="col-12">
          <div class="card-body">
            <h3 class="card-title">Estados</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
            <div class="chart-container">
    <canvas id="estatus"></canvas>
</div>
        </div>
      </div>
    </div>
  </form>
</div>
</section>

<style>
  .chart-container {
    position: relative;
    height: 60vh; /* Ejemplo: 60% de la altura de la ventana del navegador */
    width: 80vw;  /* Ejemplo: 80% del ancho de la ventana */
    /* O puedes usar un tamaño fijo */
    /* height: 400px; */
    /* width: 800px; */
}
</style>
<?php
// Mantener la estructura original exactamente igual
$data = json_decode($json_data, true);
$nombres_municipios = $data['nombres_municipios'];
$tipos_atencion_unicos = $data['tipos_atencion_unicos'];
$series_data = $data['series_data'];

// Calcular totales acumulados para cada municipio
$totales_acumulados = array_fill(0, count($nombres_municipios), 0);
foreach ($tipos_atencion_unicos as $index => $tipo_atencion) {
    foreach ($series_data[$index] as $municipio_index => $valor) {
        // CORRECCIÓN: Conversión explícita a entero para asegurar la suma correcta.
        $totales_acumulados[$municipio_index] += (int)$valor; 
    }
}

// Mantener la estructura original de datasets
$datasets = [];
// ... resto del código de datasets, que ya estaba bien ...
foreach ($tipos_atencion_unicos as $index => $tipo_atencion) {
    $backgroundColor = sprintf('rgba(%d, %d, %d, 0.6)', rand(0, 255), rand(0, 255), rand(0, 255));
    $borderColor = str_replace('0.6', '1', $backgroundColor);
    
    $datasets[] = [
        'label' => $tipo_atencion,
        'data' => $series_data[$index],
        'backgroundColor' => $backgroundColor,
        'borderColor' => $borderColor,
        'borderWidth' => 1,
    ];
}

// Agregar el dataset de totales
$datasets[] = [
    'label' => 'Total',
    'data' => $totales_acumulados,
    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
    'borderColor' => 'rgba(75, 192, 192, 1)',
    'borderWidth' => 2,
    'borderDash' => [5, 5]  // Línea punteada para el total
];

// Mantener la estructura original del chart_data
$chart_data = [
    'labels' => $nombres_municipios,
    'datasets' => $datasets,
];

// Convertir a JSON
$json_chart_data = json_encode($chart_data);
?>


<style>
        .tooltip-multiline {
            display: flex;
            flex-direction: column;
        }
        .tooltip-multiline > span:first-child {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
<script>
// Los datos para el gráfico se inyectan desde PHP
const chartData = <?php echo $json_chart_data; ?>;
// Obtiene el contexto del canvas
var ctx = document.getElementById('estatus').getContext('2d');
// Crea el nuevo gráfico de barras
const myChart = new Chart(ctx, {
type: 'bar',
data: chartData,
options: {
responsive: true,
maintainAspectRatio: false,
scales: {
x: {
stacked: false,
},
y: {
stacked: false
}
},
plugins: {
title: {
display: true,
text: 'Casos por Municipio y Tipo de Atención'
},
tooltip: {
mode: 'index',
intersect: false
}
}
}
});
</script>


