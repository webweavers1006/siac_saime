<!-- Content Wrapper. Contains page content -->
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/dashboard.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    ;
  }
</style>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid container-fluid-smaller">
      <!-- /.row -->

      <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Estadisticas Audiencias</h1>
        </div>
      </div>
    </div>
   

        <section class="content">
        <div class="card">
          <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
            <div id="reportPage">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <h3 class="card-title">Audiencias</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                    <canvas id="myChart" width="1430" height="600"></canvas>
                      
                  </div>
                </div>
              </div>
            </div>
          </form>
        
        </section>
        </div>
      
      
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>

<?php
    $allStates = [
        'NUEVO' => 0,
        'EN PROCESO' => 0,
        'RESUELTA' => 0
    ];

    // Actualizar los valores según los datos originales
    foreach ($estatus['requerimientosbyEstados'] as $estado) {
        if (array_key_exists($estado['estado'], $allStates)) {
            $allStates[$estado['estado']] = $estado['total'];
        }
    }
?>

<script>
const labels = <?php echo json_encode(array_keys($allStates)); ?>;
const data = {
  labels: labels,
  datasets: [
    {
      label: 'Audiencias',
      data: <?php echo json_encode(array_values($allStates)); ?>,
      backgroundColor: [
        'rgba(255, 206, 86, 0.70)', // Amarillo para NUEVO
        'rgba(54, 162, 235, 0.2)', // Azul para EN PROCESO
        'rgba(255, 99, 132, 0.70)'  // Rojo para RESUELTA
      ],
      borderColor: [
        'rgba(54, 162, 235, 1)', // Amarillo para NUEVO
        'rgba(54, 162, 235, 1)', // Azul para EN PROCESO
        'rgba(54, 162, 235, 1)',  // Rojo para RESUELTA
      ],
      borderWidth: 1, // Ancho del borde
    }
  ]
};

const config = {
  type: 'bar',
  data: data,
  options: {
    responsive: true,
    title: {
      display: true,
      text: 'Estado de Requerimientos' // Título del gráfico
    },
    tooltips: {
      mode: "index",
      intersect: false
    },
    scales: {
      xAxes: [{
        ticks: {
          beginAtZero: true,
          stepSize: 1 // Cambié a 1 para que se ajuste a los datos
        },
        grid: {
          display: true,
          color: 'rgba(0, 0, 255, 1)',
          z: 1,
          drawOnChartArea: true,
          borderDash: [5, 5] // Línea discontinua
        }
      }]
    }
  }
};

new Chart(
  document.getElementById('myChart'),
  config
);
</script>