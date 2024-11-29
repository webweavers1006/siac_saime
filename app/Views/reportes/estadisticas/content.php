<!-- Content Wrapper. Contains page content -->

<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">

<style>
  table {
  border-collapse: collapse;
  width: 100%; /* Ajusta el ancho según sea necesario */
}
th, td {
  border: 1px solid #ddd;
  padding: 6px;
  text-align: left;
}
th {
  background-color: #f2f2f2;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Estadísticas Globales</h1>
        </div>
        <div class="col-sm-6">
          &nbsp;&nbsp; <label for="min">Desde</label>&nbsp;
          <input type="date" class="bodersueve"    style="width:150px;"  value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">&nbsp;&nbsp;
          <label for="hasta">Hasta</label>&nbsp;&nbsp;
          <input type="date" class="bodersueve" style="width:150px;" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">&nbsp;
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>
          &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
        </div>
      </div>
    </div><!-- /.container-fluid -->
    <div class="fechas"style="display: block;" >
 <label for="hasta">Desde: </label>&nbsp;&nbsp;
    <!-- <input type="text" class="fecha" name="" disabled="disabled" style="width:100px;" id="fecha_desde" value="<php echo $fecha_desde; ?>">
    <label for="hasta">Hasta: </label>&nbsp;&nbsp;
    <input type="text" class="fecha" name="" disabled="disabled" style="width:100px;" id="fecha_hasta" value="<php echo $fecha_hasta; ?>"> -->

    </div>
   
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
        <!-- /.card -->

        <div id="reportPage">
          <div class="row">

            <div class="col-md-5">
              <div class="card">

                <div class="card-header">
                  <h3 class="card-title">Via de Atención</h3>

                  <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="grafica"></canvas>
                </div>
              </div>

            </div>

            <div class="col-md-2">
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Tipo de Solicitud</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="grafica_tipo_solicitud"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>

  </section>


  <div class="card">
    <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
      <!-- /.card -->
      <div class="row">
        <div class="col-md-3   card">
          <div class="card">
            <div class="card-header">
              <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Tipo de Beneficiario
            </div>
            <div class="card-body">
              <div class="text-muted">
              <table class="diseño">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_casos = 0;
                    foreach ($beneficiarios as $beneficiario) :
                        $total_casos += $beneficiario->count;
                    ?>
                        <tr>
                            <td><?php echo $beneficiario->tipo_beneficiario_nombre; ?></td>
                            <td><?php echo $beneficiario->count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                  
                        <td><strong><b>Total</b></strong></td>
                        <td><strong > <?php echo $total_casos; ?></strong></td>
                    </tr>
                </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3   card">
          <div class="card">
            <div class="card-header">
              <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Via de Atencion
            </div>
            <div class="card-body">
              <div class="text-muted">
              <table class="diseño">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_casos_atencion = 0;
                    foreach ($via_atencion as $via_atencion) :
                        $total_casos_atencion += $via_atencion->count;
                    ?>
                        <tr>
                            <td><?php echo $via_atencion->red_s_nom; ?></td>
                            <td><?php echo $via_atencion->count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong><b>Total</b></strong></td>
                        <td><strong><?php echo $total_casos_atencion; ?></strong></td>
                    </tr>
                </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3   card">
          <div class="card">
            <div class="card-header">
              <h5 class="text-primary"><i class="fas fa-angle-double-right"></i>Tipo Atencion
            </div>
            <div class="card-body">
              <div class="text-muted">
              <table class="diseño">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_casos_tipo_solicitud = 0;
                    foreach ($tipo_solicitud as $tipo_solicitud) :
                        $total_casos_tipo_solicitud += $tipo_solicitud->count;
                    ?>
                        <tr>
                            <td><?php echo $tipo_solicitud->tipo_aten_nombre; ?></td>
                            <td><?php echo $tipo_solicitud->count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong><b>Total</b></strong></td>
                        <td><strong><?php echo $total_casos_tipo_solicitud; ?></strong></td>
                    </tr>
                </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3   card">
          <div class="card">
            <div class="card-header">
              <h5 class="text-primary"><i class="fas fa-angle-double-right"></i>Estatus Casos
            </div>
            <div class="card-body">
              <div class="text-muted">
              <table class="diseño">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_casos_estatus_casos = 0;
                    foreach ($estatus_casos as $estatus_casos) :
                        $total_casos_estatus_casos += $estatus_casos->count;
                    ?>
                        <tr>
                            <td><?php echo $estatus_casos->estnom; ?></td>
                            <td><?php echo $estatus_casos->count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong><b>Total</b></strong></td>
                        <td><strong><?php echo $total_casos_estatus_casos; ?></strong></td>
                    </tr>
                </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </form>
  </div>
 

 
       
  </section>
  <!-- ARRAY PARA LOS ENCABEZADOS DE LA GRAFICA TIPO ATENCION -->
  <?php 
   $array_nombre_atencion = [];
   foreach ($nombre_atencion as $nombre) 
   {
       $array_nombre_atencion[] = "'" . $nombre . "'";
   }
   $array_nombre_atencion = implode(',', $array_nombre_atencion);
  ?>
 <!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO ATENCION -->
<?php 
   $array_count_atencion = [];
   foreach ($count_atencion as $nombre) 
   {
       $array_count_atencion[] = "'" . $nombre . "'";
   }
   $array_count_atencion = implode(',', $array_count_atencion);
  ?>

 <!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO ATENCION MASCULINO -->
 <?php 
   $array_count_atencion_maculino = [];
   foreach ($count_atencion_masculino as $nombre) 
   {
       $array_count_atencion_maculino[] = "'" . $nombre . "'";
   }
   $array_count_atencion_maculino = implode(',', $array_count_atencion_maculino);
  ?>
 <!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO ATENCION FEMENINO -->
 <?php 
   $array_count_atencion_femenino = [];
   foreach ($count_atencion_Femenino as $nombre) 
   {
       $array_count_atencion_femenino[] = "'" . $nombre . "'";
   }
   $array_count_atencion_femenino = implode(',', $array_count_atencion_femenino);
  ?>
   <script>
    // Obtener una referencia al elemento canvas del DOM
    const $grafica_via_atencion = document.querySelector("#grafica");
    // Las etiquetas son las que van en el eje X. 
    const etiquetas = [<?php echo $array_nombre_atencion;?>]
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datosVentas2020 = {
      label: "CASOS ATENDIDOS",
      data: [<?php echo $array_count_atencion;?>],
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
      borderWidth: 1, // Ancho del borde
      
    };

    new Chart($grafica_via_atencion, {
      type: 'bar', // Tipo de gráfica
      data: {
        labels: etiquetas,
        datasets: [
          datosVentas2020,
          
          {
            label: 'MASCULINO',
            data: [<?php echo $array_count_atencion_maculino; ?>],
            backgroundColor: 'rgba(50, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
          },
          {
            label: 'FEMENINO',
            data: [<?php echo $array_count_atencion_femenino; ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
            // Color de fondo de las barras para el segundo conjunto de datos
          }
        ]
      },
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
    });
  </script> 
<!-- ARRAY PARA LOS ENCABEZADOS DE LA GRAFICA TIPO DE SOLICITUD -->
<?php 
$solicitudNombres = [];
foreach ($nombre_solicitud as $nombre) {
    $solicitudNombres[] = $nombre;
}
$solicitudNombresJson = json_encode($solicitudNombres);
?>

<!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO SOLICITUD -->
<?php 
$solicitudCount = [];
foreach ($count_solicitud as $count) {
    $solicitudCount[] = $count;
}
$solicitudCountJson = json_encode($solicitudCount);
?>

<!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO SOLICITUD MASCULINO -->
<?php 
$solicitudCountMasculino = [];
foreach ($count_solicitud_Masculino as $nombre) {
    $solicitudCountMasculino[] = $nombre;
}
$solicitudCountMasculinoJson = json_encode($solicitudCountMasculino);
?>


<!-- ARRAY PARA LOS COUNT DE LA GRAFICA TIPO SOLICITUD FEMENINO -->
<?php 
$solicitudCountFemenino = [];
foreach ($count_solicitud_Femenino as $nombre) {
    $solicitudCountFemenino[] = $nombre;
}
$solicitudCountFemeninoJson = json_encode($solicitudCountFemenino);
?>



<script>
    // Obtener una referencia al elemento canvas del DOM
    const $grafica_via_solicitud = document.querySelector("#grafica_tipo_solicitud");
    // Las etiquetas son las que van en el eje X. 
    const etiquetas_solicitud = <?=$solicitudNombresJson?>;
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datos = {
        label: "CASOS ATENDIDOS",
        data: <?=$solicitudCountJson?>,
        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
        borderWidth: 1, // Ancho del borde
    };

    new Chart($grafica_via_solicitud, {
        type: 'bar', // Tipo de gráfica
        data: {
            labels: etiquetas_solicitud,
            datasets: [
                datos,
                {
                    label: 'MASCULINO',
                    data: <?=$solicitudCountMasculinoJson?>,
                    backgroundColor: 'rgba(50, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
                },
                {
                    label: 'FEMENINO',
                    data: <?=$solicitudCountFemeninoJson?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                    // Color de fondo de las barras para el segundo conjunto de datos
                }
            ]
        },
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
    });
</script>