<!-- Content Wrapper. Contains page content -->

<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">


          <h1>Estadísticas - Organismo del poder popular</h1>
        </div>
     
      
        <div class="col-sm-6">
          &nbsp;&nbsp; <label for="min">Desde</label>&nbsp;
          <input type="date" class="bodersueve" style="width:140px;" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">&nbsp;&nbsp;
          <label for="hasta">Hasta</label>&nbsp;&nbsp;
          <input type="date" class="bodersueve" style="width:140px;" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">&nbsp;
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
        </div>
      </div>
    </div><!-- /.container-fluid -->
   
  </section>


  <style>

.card {

max-width: auto;

margin: auto;

}

canvas {

max-width: auto;

height: auto;

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
            <div id="estatus-totales"></div>
    
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
$estados = array();

// Crear la estructura inicial de estados
foreach ($data['nombres_estados'] as $key => $estado) {
    $estados[$estado] = array(
        'estado' => $estado,
        'count_estado' => $data['count_estados'][$key],
        'tipo_organismo' => array()
    );
}
// Agregar organismos a cada estado
foreach ($data['nombre_estado_organismo'] as $key => $nombre_estado_organismo) {
  $organismos = $data['nombre_tipo_organismo'][$key];
  $count_organismos = $data['count_organismo'][$key];

  // Verificar si el estado existe en el arreglo de estados
  if (isset($estados[$nombre_estado_organismo]) && !empty($organismos)) {
      // Solo agregar si el nombre del organismo no es null o vacío
      if ($organismos !== null && $organismos !== '') {
          $estados[$nombre_estado_organismo]['tipo_organismo'][] = array(
              'nombre_organismo' => $organismos,
              'count_organismo' => $count_organismos // Cambiado a $count_organismos
          );
      }
  }
}


// Actualiza el valor de count_estado
foreach ($estados as &$estado) {
    $count_estado = 0;
    foreach ($estado['tipo_organismo'] as $organismo) {
        $count_estado += $organismo['count_organismo']; // Cambiado a 'count_organismo'
    }
    $estado['count_estado'] = $count_estado;
}

// Ordenar el arreglo por count_estado en orden descendente
usort($estados, function($a, $b) {
    return $b['count_estado'] - $a['count_estado'];
});



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
// Obtén la información desde PHP
const informacion = <?php echo json_encode($estados); ?>;

// Selecciona el contexto del canvas
var ctx = document.getElementById('estatus').getContext('2d');

// Extrae los nombres de estados
const estados = informacion.map(estado => estado.estado);

// Extrae los counts de estados
const countsEstados = informacion.map(estado => estado.count_estado);

// Extrae los tipos de organismos sin repetirlos
const tiposorganismosNombres = Array.from(new Set(informacion.flatMap(estado => 
    estado.tipo_organismo.map(organismo => organismo.nombre_organismo) // Cambiado a nombre_organismo
)));


// Extrae los counts de organismos para cada estado
const countsorganismos = informacion.map(estado => {
    const organismos = estado.tipo_organismo;
    return tiposorganismosNombres.map(tipo => {
        const organismo = organismos.find(organismo => organismo.nombre_organismo === tipo); // Cambiado a nombre_organismo
        return organismo ? parseInt(organismo.count_organismo) : 0; // Cambiado a count_organismo
    });
});

// Ordena los datos por el total de organismos en orden descendente
const sortedData = informacion.map((estado, index) => {
    const total = countsorganismos[index].reduce((a, b) => a + b, 0);
    return { estado: estado.estado, total, index };
}).sort((a, b) => b.total - a.total);

// Reordena los datos originales según el orden establecido
const sortedLabels = sortedData.map(item => item.estado);
const sortedCountsorganismos = sortedData.map(item => countsorganismos[item.index]);

const colors = [
    '#52baac', 
    '#F7DC6F', 
    '#09c8f2', 
    '#ef67f3', 
    '#42eea5', 
    '#cbcbcb' 
];

// Crea la gráfica
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: sortedLabels,
        datasets: [
            {
                label: 'Total',
                data: sortedData.map(item => item.total),
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1
            },
            ...tiposorganismosNombres.map((tipo, index) => ({
                label: tipo,
                data: sortedCountsorganismos.map(counts => counts[index]),
                backgroundColor: colors[index % colors.length], // Colores de la paleta
                borderWidth: 1
            }))
        ]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    const estado = sortedLabels[tooltipItem.index];
                    const tiposInfo = tiposorganismosNombres.map((tipo, index) => `${tipo}: ${sortedCountsorganismos[tooltipItem.index][index]}`);
                    const total = sortedCountsorganismos[tooltipItem.index].reduce((a, b) => a + b, 0);
                    return [...tiposInfo, `Total: (${total})`];
                },
                title: function(tooltipItem, data) {
                    return sortedLabels[tooltipItem[0].index];
                }
            }
        }
    }
});
</script>







