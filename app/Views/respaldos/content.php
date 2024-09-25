<!-- Content Wrapper. Contains page content -->


<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Estadisticas Globales</h1>
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
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
        <!-- /.card -->
        <a href="#" id="downloadPdf">Download Report Page as PDF</a>
        <div id="reportPage">
          <div class="row">
            <div class="col-6">
              <div class="card">

                <div class="card-header">
                  <h3 class="card-title">Via de Atencion</h3>
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
            <div class="col-6">
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
        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Tipo de Beneficiario
            </div>
            <div class="card-body">
              <div class="text-muted">

                <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos por Usuarios
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<input type="text" name="" disabled="disabled" value="<?php echo $usuario; ?>" style="width: 50px;">
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos por Emprendedores &nbsp;&nbsp;
                    <input type="text" disabled="disabled" name="" value="<?php echo $emprendedor; ?>" style="width: 50px;">
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Via de Atencion
            </div>
            <div class="card-body">
              <div class="text-muted">

                <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por Whatsapp&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<input type="text" name="" disabled="disabled" value="<?php echo $Whatsapp; ?>" style="width: 50px;">
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos de forma personal&nbsp;&nbsp;
                    <input type="text" disabled="disabled" name="" value="<?php echo $Personal; ?>" style="width: 50px;">
                    <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por llamada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<input type="text" name="" disabled="disabled" value="<?php echo $Llamadatelefonica; ?>" style="width: 50px;">
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por correo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" disabled="disabled" name="" value="<?php echo $CorreoElectronico; ?>" style="width: 50px;">
              </div>
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h4 class="text-primary"><i class="fas fa-angle-double-right"></i> Propiedad Intelectual
            </div>
            <div class="card-body">
              <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por Marcas&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<input type="text" name="" disabled="disabled" value="<?php echo $Marcas; ?>" style="width: 50px;">
                <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por Patentes&nbsp;&nbsp;
                  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" disabled="disabled" name="" value="<?php echo $Patentes; ?>" style="width: 50px;">
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos Atendidos por Derecho de Autor&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;<input type="text" name="" disabled="disabled" value="<?php echo $DerechoAutor; ?>" style="width: 50px;">
                    <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Casos por Indicaciones Geograficas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="text" disabled="disabled" name="" value="<?php echo $Indicaciones_Geograficas; ?>" style="width: 50px;">
            </div>
          </div>
        </div>
      </div>
  </div>
  </section>


  <!-- /.content -->


  <script>
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    // Las etiquetas son las que van en el eje X. 
    const etiquetas = ["Whatsapp", "Personal", "Llamada", "Correo"]
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datosVentas2020 = {
      label: "CASOS ATENDIDOS",
      data: [<?php echo $Whatsapp; ?>, <?php echo $Personal; ?>, <?php echo $Llamadatelefonica; ?>, <?php echo $CorreoElectronico; ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
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
            data: [<?php echo $Sexo_Whatsapp_M; ?>, <?php echo $Sexo_Personal_M; ?>, <?php echo $Sexo_Llamadatelefonica_M; ?>, <?php echo $Sexo_CorreoElectronico_M; ?>],
            backgroundColor: 'rgba(40, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
          },
          {
            label: 'FEMENINO',
            data: [<?php echo $Sexo_Whatsapp_F; ?>, <?php echo $Sexo_Personal_F; ?>, <?php echo $Sexo_Llamadatelefonica_F; ?>, <?php echo $Sexo_CorreoElectronico_F; ?>],
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
        legend: {
          display: false
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
            backgroundColor: 'rgba(40, 123, 255, 0.5)' // Color de fondo de las barras para el segundo conjunto de datos
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
        legend: {
          display: false
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