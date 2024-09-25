<!-- Content Wrapper. Contains page content -->

<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">
<div class="content-wrapper">

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

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">


          <h1>Estadísticas, Tipo de Beneficiario</h1>
        </div>
      <!-- listado de estados -->
        <?php
      $array = null;
      for ($i=0; $i <count($estadisticas) ; $i++) { 
        $estado=$estadisticas[$i]->estadonom;
        if ($array === null) {
          $array = "'".$estado."'";
        }else {
          $array = $array.",'".$estado."'";
        }
      }  
        ?>
     <!-- total casos por estados -->
      <?php
      $array_totalcasos = null;
      for ($a=0; $a <count($estadisticas) ; $a++) { 
        $count=$estadisticas[$a]->total_casos;
        if ($array_totalcasos === null) {
          $array_totalcasos = "'".$count."'";
        }else {
          $array_totalcasos = $array_totalcasos.",'".$count."'";
        }
      }  

        ?>

         <!-- total casos usuarios por estados  -->
         <?php 
      $array_totalcasosUsuario_por_estado = null;
      for ($u=0; $u <count($estadisticas_usuario) ; $u++) { 
        $count=$estadisticas_usuario[$u]->usuario;
        if ($array_totalcasosUsuario_por_estado === null) {
          $array_totalcasosUsuario_por_estado = "'".$count."'";
        }else {
          $array_totalcasosUsuario_por_estado = $array_totalcasosUsuario_por_estado.",'".$count."'";
        }
      }  
       ?>
   <!-- total casos emprendedor por estados  -->
   <?php 

      $array_totalcasosEmprendedor_por_estado = null;
      for ($e=0; $e <count($estadisticas_emprendedor) ; $e++) { 
        $count=$estadisticas_emprendedor[$e]->emprendedor;
        if ($array_totalcasosEmprendedor_por_estado === null) {
          $array_totalcasosEmprendedor_por_estado = "'".$count."'";
        }else {
          $array_totalcasosEmprendedor_por_estado = $array_totalcasosEmprendedor_por_estado.",'".$count."'";
        }
      }  
 
       ?>

      
           
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
            <canvas id="myChart" width="1430" height="600"></canvas>
               
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</section>

</div>



<script>
const labels = [<?php echo $array;?>];
const data = {
  labels: labels,
  datasets: [
          //datosVentas2020,
          {
            // CASOS ATENDIDOS
            label: 'Casos Atendidos',
            data: [<?php echo $array_totalcasos;?>],
            backgroundColor: 'rgba(128, 128, 128, 20)' // Color de fondo de las barras para el segundo conjunto de datos
          },
         
             // CASOS USUARIOS
             {
            label: 'Usuarios',
            data: [<?php echo $array_totalcasosUsuario_por_estado; ?>],
            backgroundColor: 'rgba(99, 211, 255, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
          // CASOS EMPRENDEDOR
          {
            label: 'Emprendedor',
            data: [<?php echo $array_totalcasosEmprendedor_por_estado; ?>],

            
            backgroundColor: 'rgba(40, 123, 255, 50)'
            // Color de fondo de las barras para el segundo conjunto de datos
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

  