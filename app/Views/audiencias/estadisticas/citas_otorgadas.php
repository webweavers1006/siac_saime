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

<style>




label {
margin-right: 10px;
font-weight: bold;
}
select {
padding: 5px;
border-radius: 4px;
border: 1px solid #ccc;
margin-right: 10px;
}
button {
padding: 5px 15px;
border: none;
border-radius: 4px;
background-color: #007BFF;
color: white;
cursor: pointer;
transition: background-color 0.3s;
}

button:hover {
background-color: #0056b3;
}
</style>


    <label for="year">Año:</label>
<select name="year" id="year">
    <?php
    for ($i = 2024; $i <= 2040; $i++) {
        echo "<option value='$i'>$i</option>";
    }
    ?>
</select>
<button id="redirect">Ir</button>
       <br><br>
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
      label: 'Presencial',
      data: [],
      backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de fondo para presenciales
      borderColor: 'rgba(75, 192, 192, 1)', // Color del borde para presenciales
      borderWidth: 1,
    },
    {
      label: 'Virtual',
      data: [],
      backgroundColor: 'rgba(153, 102, 255, 0.2)', // Color de fondo para virtuales
      borderColor: 'rgba(153, 102, 255, 1)', // Color del borde para virtuales
      borderWidth: 1,
    },
    {
      label: 'Total',
      data: [],
      backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color de fondo para el total
      borderColor: 'rgba(255, 99, 132, 1)', // Color del borde para el total
      borderWidth: 1,
    }
  ]
};

// Loop through the $citas array and extract the month names and citation counts
<?php foreach ($citas['citabyMonths'] as $month) { ?>
  labels.push('<?php echo $month['mes']; ?>'); // Mes
  data.datasets[0].data.push(<?php echo $month['presencial']; ?>); // Citas presenciales
  data.datasets[1].data.push(<?php echo $month['virtual']; ?>); // Citas virtuales
  // Calcular el total de citas por mes y agregarlo al conjunto de datos del total
  data.datasets[2].data.push(<?php echo $month['presencial'] + $month['virtual']; ?>); // Total de citas
<?php } ?>

const config = {
  type: 'bar',
  data: data,
  options: {
    responsive: true,
    title: {
      display: true,
      text: 'Estadísticas de Citas Otorgadas' // Título del gráfico
    },
    tooltips: {
      mode: "index",
      intersect: false
    },
    scales: {
      x: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        },
        grid: {
          display: true,
          color: 'rgba(0, 0, 255, 1)',
          z: 1,
          drawOnChartArea: true,
          borderDash: [5, 5] // Línea discontinua
        }
      },
      y: {
        beginAtZero: true
      }
    }
  }
};

new Chart(
  document.getElementById('myChart'),
  config
);

// Calcular el total de citas
let totalPresencial = 0;
let totalVirtual = 0;
let totalGeneral = 0;

data.datasets[0].data.forEach(count => {
  totalPresencial += count;
});
data.datasets[1].data.forEach(count => {
  totalVirtual += count;
});
data.datasets[2].data.forEach(count => {
  totalGeneral += count;
});

</script>