<!-- Content Wrapper. Contains page content -->

<script type="text/javascript" src="<?php echo base_url(); ?>/dist/chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">


          <h1>Estadísticas-Estatus de Casos</h1>
        </div>
     
      
        <div class="col-sm-6">
          &nbsp;&nbsp; <label for="min">Desde</label>&nbsp;
          <input type="date" class="bodersueve" style="width:140px;"  name="desde" id="desde">&nbsp;&nbsp;
          <label for="hasta">Hasta</label>&nbsp;&nbsp;
          <input type="date" class="bodersueve" style="width:140px;"  name="hasta" id="hasta">&nbsp;
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
        </div>
      </div>
    </div><!-- /.container-fluid -->
   
  </section>


<style>
  .chart-container {
    position: relative;
    height: 60vh; 
    width: 80vw;  
   
}
</style>



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
            <canvas id="estatus" width="1430" height="600"></canvas>
            
    
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</section>
<?php

$data = json_decode($json_data, true);
$labels = array();
$datasets = array();

// Crear el dataset para el total de estados
$datasets[] = array(
    'label' => 'Total',
    'data' => array(),
    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
    'borderColor' => 'rgba(54, 162, 235, 1)',
    'borderWidth' => 1
);

// Se crea un array $estados vacío. Luego, se itera sobre el array $data['nombres_estados'] y 
//se crea un nuevo elemento en $estados para cada estado. Cada elemento tiene una 
//estructura con el nombre del estado, el conteo de casos en ese estado y un array vacío para los estatus.
$estados = array();
foreach ($data['nombres_estados'] as $key => $estado) {
    $estados[$key] = array(
        'estado' => $estado,
        'count_estado' => $data['count_estados'][$key],
        'estados_estatus' => array()
    );
}



//Se itera sobre el array $data['nombre_estado_estatus'] y se busca el índice del estado correspondiente en $estados. 
//Si se encuentra, se agrega un nuevo elemento al array estados_estatus con el nombre del estatus y el conteo de casos.
foreach ($data['nombre_estado_estatus'] as $key => $nombre_estado_estatus) {
  $estado_key = array_search(trim($nombre_estado_estatus), array_map('trim', $data['nombres_estados']));
    $estatus = $data['nombres_estatus'][$key];
    $count_estatus = $data['count_estatus'][$key];
    
    if (isset($estados[$estado_key])) {
        $estados[$estado_key]['estados_estatus'][] = array(
            'nombre_estatus' => $estatus,
            'count_estatus' => $count_estatus
        );
    }
}
// Ordenar el arreglo por count_estado en orden descendente
usort($estados, function($a, $b) {
  return $b['count_estado'] - $a['count_estado'];
});



//Se crean dos arrays vacíos: $etiquetas y $datosVentas2020. Luego, se itera sobre el array $estados y se calcula el total de casos para
//cada estado. Se agrega un nuevo elemento al array $datosVentas2020 con el nombre del estado y el total de casos.
$etiquetas = array();
$datosVentas2020 = array();

foreach ($estados as $estado) {
    $totalCasosEstado = $estado['count_estado'];
    $nombreEstado = $estado['estado'];
    
    if (!isset($datosVentas2020[$nombreEstado])) {
        $datosVentas2020[$nombreEstado] = 0;
    }
    
    foreach ($estado['estados_estatus'] as $estatus) {
        $datosVentas2020[$nombreEstado] += $estatus['count_estatus'];
    }
}

$totalesPorEstado = array();
$Datos_grafica = array();
foreach ($estados as $estado) {
    $nombreEstado = $estado['estado'];
    
    if (!isset($Datos_grafica[$nombreEstado])) {
        $Datos_grafica[$nombreEstado] = array();
        $Datos_grafica[$nombreEstado]['total'] = 0; // Inicializa el total para cada estado
    }
    
    if (!isset($totalesPorEstado[$nombreEstado])) {
        $totalesPorEstado[$nombreEstado] = 0; // Inicializa el total para cada estado de manera independiente
    } 
    foreach ($estado['estados_estatus'] as $estatus) {
        $nombreEstatus = $estatus['nombre_estatus'];
        $countEstatus = $estatus['count_estatus'];
        if (!isset($Datos_grafica[$nombreEstado][$nombreEstatus])) {
            $Datos_grafica[$nombreEstado][$nombreEstatus] = 0;
        }   
        $Datos_grafica[$nombreEstado][$nombreEstatus] += $countEstatus;
        $Datos_grafica[$nombreEstado]['total'] += $countEstatus; // Suma al total para cada estado
        $totalesPorEstado[$nombreEstado] += $countEstatus; // Suma al total para cada estado de manera independiente
    }
}

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
  const $grafica_via_atencion = document.querySelector("#estatus");
  const datosEstatus = <?php echo json_encode($Datos_grafica);?>;
  const totalesPorEstado = <?php echo json_encode($totalesPorEstado);?>;
  var ctx = document.getElementById('estatus').getContext('2d');

  // Extrae los nombres de estatus sin repetirlos
  const estatusNombres = Array.from(new Set(Object.keys(datosEstatus).map(estado => Object.keys(datosEstatus[estado]).filter(est => est !== 'total')).flat()));

  // Ordena los datos por total descendente
  const sortedData = Object.keys(datosEstatus).sort((a, b) => totalesPorEstado[b] - totalesPorEstado[a]);

  // Define colores específicos para ciertos estatus
  const estatusColors = {
    'Abierto': 'rgba(255, 99, 132, 0.5)',  // Rojo
    'Cerrado': 'rgba(75, 192, 192, 0.5)',   // Verde
    'No Aplica': 'rgba(201, 201, 201, 0.5)' // Gris
  };

  // Define un array de colores para los estatus restantes
  const additionalColors = [
    'rgba(54, 162, 235, 0.5)',
    'rgba(255, 206, 86, 0.5)',
    'rgba(153, 102, 255, 0.5)',
    'rgba(255, 159, 64, 0.5)',
    'rgba(0, 0, 0, 0.5)'
  ];

  // Crea la gráfica
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: sortedData,
      datasets: [
        ...estatusNombres.map((estatus, index) => ({
          label: estatus,
          data: sortedData.map(estado => datosEstatus[estado][estatus] || 0),
          backgroundColor: estatusColors[estatus] || additionalColors[index % additionalColors.length],
          borderColor: estatusColors[estatus] || additionalColors[index % additionalColors.length],
          borderWidth: 1
        }))
      ]
    },
    options: {
      plugins: {
        tooltip: {
          // This is the key. It groups all datasets at a specific index into a single tooltip.
          mode: 'index',
          intersect: false,
          callbacks: {
            title: function(tooltipItems) {
              return tooltipItems[0].label;
            },
            afterBody: function(tooltipItems) {
              let lines = [];
              const estado = tooltipItems[0].label;
              lines.push(`Total: ${totalesPorEstado[estado]}`);
              return lines;
            }
          }
        }
      }
    }
  });
</script>





