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


          <h1>Estadísticas, Tipos de Atención</h1>
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


        <!-- total casos de asesoria por estados  -->
      <?php 
      
        $array_totalcasos_asesoria = null;
        for ($e=0; $e <count($estadisticas_asesoria) ; $e++) { 
        $count=$estadisticas_asesoria[$e]->asesoria;
        if ($array_totalcasos_asesoria === null) {
        $array_totalcasos_asesoria = "'".$count."'";
        }else {
        $array_totalcasos_asesoria = $array_totalcasos_asesoria.",'".$count."'";
        }
        }  
      ?> 
      <!-- total casos de sugerencia por estados  -->
      <?php 
        
        $array_totalcasos_sugerencia = null;
        for ($e=0; $e <count($estadisticas_sugerencia) ; $e++) { 
        $count=$estadisticas_sugerencia[$e]->sugerencia;
        if ($array_totalcasos_sugerencia === null) {
        $array_totalcasos_sugerencia = "'".$count."'";
        }else {
        $array_totalcasos_sugerencia = $array_totalcasos_sugerencia.",'".$count."'";
        }
        }  
      ?> 
        <!-- total casos de queja por estados  -->
       <?php  
        $array_totalcasos_queja = null;
        for ($e=0; $e <count($estadisticas_queja) ; $e++) { 
        $count=$estadisticas_queja[$e]->queja;
        if ($array_totalcasos_queja === null) {
        $array_totalcasos_queja = "'".$count."'";
        }else {
        $array_totalcasos_queja = $array_totalcasos_queja.",'".$count."'";
        }
        }  
      ?> 
         <!-- total casos de reclamo por estados  -->
         <?php  
        $array_totalcasos_reclamo = null;
        for ($e=0; $e <count($estadisticas_reclamo) ; $e++) { 
        $count=$estadisticas_reclamo[$e]->reclamo;
        if ($array_totalcasos_reclamo === null) {
        $array_totalcasos_reclamo = "'".$count."'";
        }else {
        $array_totalcasos_reclamo = $array_totalcasos_reclamo.",'".$count."'";
        }
        }  
      ?> 

      <!-- total casos de reclamo por denuncia  -->
      <?php  
        $array_totalcasos_denuncia = null;
        for ($e=0; $e <count($estadisticas_denuncia) ; $e++) { 
        $count=$estadisticas_denuncia[$e]->denuncia;
        if ($array_totalcasos_denuncia === null) {
        $array_totalcasos_denuncia = "'".$count."'";
        }else {
        $array_totalcasos_denuncia = $array_totalcasos_denuncia.",'".$count."'";
        }
        }  
      ?> 
 <!-- total casos peticion  -->
 <?php  
 
        $array_totalcasos_peticion = null;
        for ($e=0; $e <count($estadisticas_peticion) ; $e++) { 
        $count=$estadisticas_peticion[$e]->peticion;
        if ($array_totalcasos_peticion === null) {
        $array_totalcasos_peticion = "'".$count."'";
        }else {
        $array_totalcasos_peticion = $array_totalcasos_peticion.",'".$count."'";
        }
        }  
      ?> 


 <!-- total casos talleres  -->
 <?php  
 
        $array_totalcasos_talleres = null;
        for ($e=0; $e <count($estadisticas_talleres) ; $e++) { 
        $count=$estadisticas_talleres[$e]->talleres;
        if ($array_totalcasos_talleres === null) {
        $array_totalcasos_talleres = "'".$count."'";
        }else {
        $array_totalcasos_talleres = $array_totalcasos_talleres.",'".$count."'";
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
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
        <!-- /.card -->
        <a href="#" id="downloadPdf">Descargar PDF</a>
        <div id="reportPage">
          <div class="row">
                </div>
                <div class="card-body">
                <h3 class="card-title">   &nbsp;&nbsp; Estados</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                  <!-- <canvas id="grafica" height="100"></canvas> -->
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
            <div class="col-md-2">
            </div>   
          </div>
        </div>
  </section>

  </section>




  <script>
const labels = [<?php echo $array;?>];
const data = {
  labels: labels,
  datasets: [
        //  datosVentas2020,
          {
            // CASOS ATENDIDOS
            label: 'Casos Atendidos',
            data: [<?php echo $array_totalcasos;?>],
            backgroundColor: 'rgba(128, 128, 128, 20)' // Color de fondo de las barras para el segundo conjunto de datos
          },
         
             // CASOS ASESORIA
             {
            label: 'Asesoría',
            data: [<?php echo $array_totalcasos_asesoria; ?>],
            backgroundColor: 'rgba(0, 180, 175, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },

             // CASOS SUGERENCIA
             {
            label: 'Sugerencia',
            data: [<?php echo $array_totalcasos_sugerencia; ?>],
            backgroundColor: 'rgba(81, 152, 255, 30)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
          
             // CASOS QUEJA
             {
            label: 'Queja',
            data: [<?php echo $array_totalcasos_queja; ?>],
            backgroundColor: 'rgba(45, 0, 1, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
            // CASOS RECLAMO
            {
            label: 'Reclamo',
            data: [<?php echo $array_totalcasos_reclamo; ?>],
            backgroundColor: 'rgba(196,64,54, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
             // CASOS DENUCIA
             {
            label: 'Denuncia',
            data: [<?php echo $array_totalcasos_denuncia; ?>],
            backgroundColor: 'rgba(255, 99, 132, 20)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
          
          // CASOS DENUCIA
          {
            label: 'Petición',
            data: [<?php echo $array_totalcasos_peticion; ?>],
            backgroundColor: 'rgba( 99, 82, 186,30)'
            // Color de fondo de las barras para el segundo conjunto de datos
          },
           // CASOS DENUCIA
           {
            label: 'Talleres',
            data: [<?php echo $array_totalcasos_talleres; ?>],
            backgroundColor: 'rgba(255, 215, 0, 0.3)'
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

