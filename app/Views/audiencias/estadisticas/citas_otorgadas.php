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
          <h1>Citas otrogadas por meses</h1>
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
                    <h3 class="card-title">Informacion</h3>
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

<script>
const labels = [];
const data = {
  labels: labels,
  datasets: [
    {
      label: 'Citas Otorgadas',
      data: [],
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
      borderWidth: 1, // Ancho del borde
    }
  ]
};

// Loop through the $casos array and extract the month names and citation counts
<?php foreach ($citas['citabyMonths'] as $month) { ?>
  labels.push('<?php echo $month[0]; ?>');
  data.datasets[0].data.push(<?php echo $month[1]; ?>);
<?php } ?>

const config = {
  type: 'bar',
  data: data,
  options: {
    responsive: true,
    title: {
      display: true
    },
    tooltips: {
      mode: "index",
      intersect: false
    },
    scales: {
      xAxes: [{
        ticks: {
          beginAtZero: true,
          stepSize: 2
        },
        grid: {
          display: true,
          color: 'rgba(0, 0, 255, 1)',
          z: 1,
          drawOnChartArea: true,
          borderDash: [5, 5] // add this property to create a dotted line
        }
      }]
    }
  }
};

new Chart(
  document.getElementById('myChart'),
  config
);

// Calculate the total
let total = 0;
data.datasets[0].data.forEach(count => {
  total += count;
});
console.log(`The total number of citations is: ${total}`);
</script>