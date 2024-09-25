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
          <h1>Estadísticas, Propiedad Intelectual</h1>
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
      <!-- total casos de No aplica propiedad intelectual por estados  -->
    <?php 
      $array_totalcasosNo_aplica_por_estado = null;
      for ($e=0; $e <count($estadisticas_no_aplica) ; $e++) { 
      $count=$estadisticas_no_aplica[$e]->no_aplica;
      if ($array_totalcasosNo_aplica_por_estado === null) {
      $array_totalcasosNo_aplica_por_estado = "'".$count."'";
      }else {
      $array_totalcasosNo_aplica_por_estado = $array_totalcasosNo_aplica_por_estado.",'".$count."'";
      }
      }  
    ?> 
    <!-- total casos de derecho de auotor propiedad intelectual por derecho de autor  -->
    <?php 
    $array_totalcasos_derecho_autor = null;
    for ($e=0; $e <count($estadisticas_derecho_autor) ; $e++) { 
    $count=$estadisticas_derecho_autor[$e]->derecho_autor;
    if ($array_totalcasos_derecho_autor === null) {
    $array_totalcasos_derecho_autor = "'".$count."'";
    }else {
    $array_totalcasos_derecho_autor = $array_totalcasos_derecho_autor.",'".$count."'";
    }
    }  
  ?> 

        
   <!-- total casos de patentes por estados  -->
   <?php 
      $array_totalcasosPatentes_por_estado = null;
      for ($e=0; $e <count($estadisticas_patentes) ; $e++) { 
      $count=$estadisticas_patentes[$e]->patentes;
      if ($array_totalcasosPatentes_por_estado === null) {
      $array_totalcasosPatentes_por_estado = "'".$count."'";
      }else {
      $array_totalcasosPatentes_por_estado = $array_totalcasosPatentes_por_estado.",'".$count."'";
      }
      }  
    ?> 

   <!-- total casos de indicaciones geograficas por estados  -->
   <?php 
   
      $array_totalcasosIndicaciones_geograficas_por_estado = null;
      for ($e=0; $e <count($estadisticas_indicaciones_geograficas) ; $e++) { 
      $count=$estadisticas_indicaciones_geograficas[$e]->indicacione_geograficas;
      if ($array_totalcasosIndicaciones_geograficas_por_estado === null) {
      $array_totalcasosIndicaciones_geograficas_por_estado = "'".$count."'";
      }else {
      $array_totalcasosIndicaciones_geograficas_por_estado = $array_totalcasosIndicaciones_geograficas_por_estado.",'".$count."'";
      }
      }  
    ?> 
    <!-- total casos de marcas por estados  -->
    <?php 
      $array_totalcasosMarcas_por_estado = null;
      for ($e=0; $e <count($estadisticas_marcas) ; $e++) { 
      $count=$estadisticas_marcas[$e]->marcas;
      if ($array_totalcasosMarcas_por_estado === null) {
      $array_totalcasosMarcas_por_estado = "'".$count."'";
      }else {
      $array_totalcasosMarcas_por_estado = $array_totalcasosMarcas_por_estado.",'".$count."'";
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
               <!-- <script>
                function ajustarTamanhoCanvas() {
                  const canvas = document.getElementById('myChart');
                  const anchoMinimo = 400;
                  const altoMinimo = 800;
                  const anchoPantalla = window.innerWidth;
                  const altoPantalla = window.innerHeight;

                  if (anchoPantalla <= 480) {
                    // Teléfono
                    canvas.width = anchoMinimo;
                    canvas.height = altoMinimo;
                  } else {
                    // Monitor
                    canvas.width = 1430;
                    canvas.height = 100;  
                  }
                }
                   window.onresize = ajustarTamanhoCanvas;
                  </script> -->
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</section>



<script>
const labels = [<?php echo $array;?>];
const data = {
  labels: labels,
  datasets: [
         // datosVentas2020,
          {
            // CASOS ATENDIDOS
            label: 'Casos Atendidos',
            data: [<?php echo $array_totalcasos;?>],
            //40, 123, 255, 50
            backgroundColor: 'rgba(128, 128, 128, 20)' // Color de fondo de las barras para el segundo conjunto de datos
          },
         
             // CASOS PATENTES
             {
            label: 'Patentes',
            data: [<?php echo $array_totalcasosPatentes_por_estado; ?>],
            
            backgroundColor: 'rgba(45, 0, 1, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },


           // CASOS DERECHO DE AUTOR
         {
            label: 'Derecho de Autor',
            data: [<?php echo $array_totalcasos_derecho_autor; ?>],
            backgroundColor: 'rgba(0, 180, 175, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
             // CASOS INDICACIONES GEOGRAFICAS
         {
            label: 'Indicacioes Geográficas',
            data: [<?php echo $array_totalcasosIndicaciones_geograficas_por_estado; ?>],
            backgroundColor: 'rgba(128, 99, 105, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
           // CASOS MARCAS
          {
            label: 'Marcas',
            data: [<?php echo $array_totalcasosMarcas_por_estado; ?>],
           
            backgroundColor: 'rgba(196,64,54, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },

            // CASOS NO APLICA
          {
            label: 'No aplica',
            data: [<?php echo $array_totalcasosNo_aplica_por_estado; ?>],
            backgroundColor: 'rgba(255, 99, 132, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },

          
         
          
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
















