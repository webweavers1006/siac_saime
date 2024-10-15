<!-- Content Wrapper. Contains page content -->

<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script> -->
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
  <!-- Content Header (Page header) -->
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

      <div class="row mb-2">
        <div class="col-sm-6">
        
        </div>
        &nbsp;&nbsp; &nbsp;&nbsp;<label for="estado-caso">Estado</label>
        <div class="col-lg-3 col-sm-3 col-md-3">
          <select id="estado-caso" name="estado-caso" class="form-control">
              <option value="0" disabled>Seleccione Estado</option>
          </select>
        </div>
      </div>


   <!-- /.container-fluid -->
    <div class="fechas"style="display: block;" >
 <label for="hasta">Desde: </label>&nbsp;&nbsp;
    <input type="text" class="fecha" name="" disabled="disabled" style="width:100px;" id="fecha_desde" value="<?php echo $fecha_desde; ?>">
    <label for="hasta">Hasta: </label>&nbsp;&nbsp;
    <input type="text" class="fecha" name="" disabled="disabled" style="width:100px;" id="fecha_hasta" value="<?php echo $fecha_hasta; ?>">

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
                  <h3 class="card-title">Casos por Propiedad Intelectual</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="grafica_prointel"></canvas>
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
          <div class="col-md-3 card">
            <div class="card">
              <div class="card-header">
                <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Tipo de Beneficiario</h4>
              </div>
              <div class="card-body">
              <div class="text-muted">
              <table class="diseño">
                  <thead><tr><th>Tipo</th><th>Cantidad</th></tr></thead>
                  <tbody>
                    <tr><td>Usuarios</td><td><?php echo $usuario; ?></td></tr>
                    <tr><td>Emprendedores</td><td><?php echo $emprendedor; ?></td></tr>
                    <tr><td>Total Casos</td><td><?php echo $usuario + $emprendedor; ?></td></tr>
                  </tbody>
                </table>
                <h6 class="text-primary"><i class="fas fa-angle-double-right"></i> Estatus Casos</h6>
                <table class="diseño">
                  <thead><tr><th>Estatus</th><th>Cantidad</th></tr></thead>
                  <tbody>
                    <tr><td>Abiertos</td><td><?php echo $Abiertos; ?></td></tr>
                    <tr><td>Cerrados</td><td><?php echo $Cerrados; ?></td></tr>
                    <tr><td>Total Casos</td><td><?php echo $Abiertos + $Cerrados; ?></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>

          <div class="col-md-3 card">
            <div class="card">
              <div class="card-header">
                <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Vía de Atención</h4>
              </div>
              <div class="card-body">
              <div class="text-muted">
                <table class="diseño">
                  <thead><tr><th>Vía de Atención</th><th>Cantidad</th></tr></thead>
                  <tbody>
                    <tr><td>Whatsapp</td><td><?php echo $Whatsapp; ?></td></tr>
                    <tr><td>Personal</td><td><?php echo $Personal; ?></td></tr>
                    <tr><td>Llamada</td><td><?php echo $Llamadatelefonica; ?></td></tr>
                    <tr><td>Correo</td><td><?php echo $CorreoElectronico; ?></td></tr>
                    <tr><td>Portal Web</td><td><?php echo $No_Aplica_red_social; ?></td></tr>
                    <tr><td>Total Casos</td><td><?php echo $Whatsapp + $Personal + $Llamadatelefonica + $CorreoElectronico + $No_Aplica_red_social; ?></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>

          <div class="col-md-3 card">
            <div class="card">
              <div class="card-header">
                <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Propiedad Intelectual</h4>
              </div>
              <div class="card-body">
              <div class="text-muted">
                <table class="diseño">
                  <thead><tr><th>Tipo de Propiedad Intelectual</th><th>Cantidad</th></tr></thead>
                  <tbody>
                    <tr><td>Marcas</td><td><?php echo $Marcas;?></td></tr>
                    <tr><td>Patentes</td><td><?php echo $Patentes;?></td></tr>
                    <tr><td>Derecho de Autor</td><td><?php echo $DerechoAutor;?></td></tr>
                    <tr><td>Indicaciones Geográficas</td><td><?php echo $Indicaciones_Geograficas;?></td></tr>
                    <tr><td>No Aplica</td><td><?php echo $No_Aplica;?></td></tr>
                    <tr><td>Total Casos</td><td><?php echo $Marcas + $Patentes + $DerechoAutor + $Indicaciones_Geograficas + $No_Aplica;?></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
          <div class="col-md-3 card">
            <div class="card">
              <div class="card-header">
                <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Atención Ciudadano</h4>
              </div>
              <div class="card-body">
              <div class="text-muted">
                <table class="diseño">
                  <thead><tr><th>Tipo de Atención</th><th>Cantidad</th></tr></thead>
                  <tbody>
                    <tr><td>Asesoría</td><td><?php echo $Asesoría;?></td></tr>
                    <tr><td>Queja</td><td><?php echo $Queja;?></td></tr>
                    <tr><td>Reclamo</td><td><?php echo $Reclamo;?></td></tr>
                    <tr><td>Sugerencia</td><td><?php echo $Sugerencia;?></td></tr>
                    <tr><td>Denuncia</td><td><?php echo $Denuncia;?></td></tr>
                    <tr><td>Petición</td><td><?php echo $Petición;?></td></tr>
                    <tr><td>Talleres</td><td><?php echo $Talleres;?></td></tr>
                    <tr><td>Total Casos</td><td><?php echo $Asesoría + $Queja + $Reclamo + $Sugerencia + $Denuncia + $Talleres + $Petición;?></td></tr>
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


  <!-- /.content -->


  <script>
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    // Las etiquetas son las que van en el eje X. 
    const etiquetas = ["Whatsapp", "Personal", "Llamada", "Correo","Portal"]
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datosVentas2020 = {
      label: "CASOS ATENDIDOS",
      data: [<?php echo $Whatsapp; ?>, <?php echo $Personal; ?>, <?php echo $Llamadatelefonica; ?>, <?php echo $CorreoElectronico; ?>,<?php echo $No_Aplica_red_social; ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
      borderWidth: 1, // Ancho del borde
    };

    new Chart($grafica, {
      type: 'bar', // Tipo de gráfica
      data: {
        labels: etiquetas,
        datasets: [
          datosVentas2020,
          {
            label: 'MASCULINO',
            data: [<?php echo $Sexo_Whatsapp_M; ?>, <?php echo $Sexo_Personal_M; ?>, <?php echo $Sexo_Llamadatelefonica_M; ?>, <?php echo $Sexo_CorreoElectronico_M; ?>,<?php echo $sexo_no_Aplica_red_social_M; ?>],
            backgroundColor: 'rgba(50, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
          },
          {
            label: 'FEMENINO',
            data: [<?php echo $Sexo_Whatsapp_F; ?>, <?php echo $Sexo_Personal_F; ?>, <?php echo $Sexo_Llamadatelefonica_F; ?>, <?php echo $Sexo_CorreoElectronico_F; ?>,<?php echo $sexo_no_Aplica_red_social_F; ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
            // Color de fondo de las barras para el segundo conjunto de datos
          }
          // Aquí más datos...
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



  <script>
    // Obtener una referencia al elemento canvas del DOM
    const $grafica_prointel = document.querySelector("#grafica_prointel");
    // Las etiquetas son las que van en el eje X. 
    const etiquetas_prointel = ["Marcas", "Patentes", "Derecho de auntor", "Indicaciondes"]
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const dato_pronintel = {
      label: "CASOS ATENDIDOS",
      data: [<?php echo $Marcas; ?>, <?php echo $Patentes; ?>, <?php echo $DerechoAutor; ?>, <?php echo $Indicaciones_Geograficas; ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
      borderWidth: 1, // Ancho del borde
    };


    new Chart($grafica_prointel, {
      type: 'bar', // Tipo de gráfica
      data: {
        labels: etiquetas_prointel,
        datasets: [
          dato_pronintel,
          {
            label: 'MASCULINO',
            data: [<?php echo $sexo_Marcas_M; ?>, <?php echo $sexo_Patentes_M; ?>, <?php echo $sexo_DerechoAutor_M; ?>, <?php echo $sexo_Indicaciones_Geograficas_M; ?>],
            backgroundColor: 'rgba(50, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
          },
          {
            label: 'FEMENINO',
            data: [<?php echo $sexo_Marcas_F; ?>, <?php echo $sexo_Patentes_F; ?>, <?php echo $sexo_DerechoAutor_F; ?>, <?php echo $sexo_Indicaciones_Geograficas_F; ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
            // Color de fondo de las barras para el segundo conjunto de datos
          }
          // Aquí más datos...
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