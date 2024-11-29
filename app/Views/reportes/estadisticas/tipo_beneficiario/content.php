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


          <h1>Estadísticas - Beneficiarios</h1>
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
foreach ($data['nombres_estados'] as $key => $estado) {
    $estados[$estado] = array(
        'estado' => $estado,
        'count_estado' => $data['count_estados'][$key],
        'tipo_beneficiario' => array()
    );
}

foreach ($data['nombre_estado_beneficiario'] as $key => $nombre_estado_beneficiario) {
  $beneficiarios = $data['nombre_tipo_beneficiario'][$key];
  $count_beneficiarios = $data['count_beneficiario'][$key];
  if (isset($estados[$nombre_estado_beneficiario])) {
      $estados[$nombre_estado_beneficiario]['tipo_beneficiario'][] = array(
          'nombre_beneficiarios' => $beneficiarios,
          'count_beneficiarios' => $count_beneficiarios
      );
  }
}

// Actualiza el valor de count_estado
foreach ($estados as &$estado) {
  $count_estado = 0;
  foreach ($estado['tipo_beneficiario'] as $beneficiario) {
    $count_estado += $beneficiario['count_beneficiarios'];
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
const informacion = <?php echo json_encode($estados);?>;
// Selecciona el contexto del canvas
var ctx = document.getElementById('estatus').getContext('2d');
// Extrae los nombres de estados
const estados = informacion.map(estado => estado.estado);
// Extrae los counts de estados
const countsEstados = informacion.map(estado => estado.count_estado);
// Extrae los tipos de beneficiarios sin repetirlos
const tiposBeneficiariosNombres = Array.from(new Set(informacion.flatMap(estado => estado.tipo_beneficiario.map(beneficiario => beneficiario.nombre_beneficiarios))));
// Extrae los counts de beneficiarios para cada estado
const countsBeneficiarios = informacion.map(estado => {
  const beneficiarios = estado.tipo_beneficiario;
  return tiposBeneficiariosNombres.map(tipo => {
    const beneficiario = beneficiarios.find(beneficiario => beneficiario.nombre_beneficiarios === tipo);
    return beneficiario ? parseInt(beneficiario.count_beneficiarios) : 0;
  });
});

// Ordena los datos por el total de beneficiarios en orden descendente
const sortedData = informacion.map((estado, index) => {
  const total = countsBeneficiarios[index].reduce((a, b) => a + b, 0);
  return { estado: estado.estado, total, index };
}).sort((a, b) => b.total - a.total);
// Reordena los datos originales según el orden establecido
const sortedLabels = sortedData.map(item => item.estado);
const sortedCountsBeneficiarios = sortedData.map(item => countsBeneficiarios[item.index]);
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
      ...tiposBeneficiariosNombres.map((tipo, index) => ({
        label: tipo,
        data: sortedCountsBeneficiarios.map(counts => counts[index]),
        backgroundColor: colors[index % colors.length], // Colores de la paleta
        //borderColor: `rgba(${index * 150}, 100, 100, 1)`,
        borderWidth: 1
      }))
    ]
  },
  options: {
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          const estado = sortedLabels[tooltipItem.index];
          const tiposInfo = tiposBeneficiariosNombres.map((tipo, index) => `${tipo}: ${sortedCountsBeneficiarios[tooltipItem.index][index]}`);
          const total = sortedCountsBeneficiarios[tooltipItem.index].reduce((a, b) => a + b, 0);
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






