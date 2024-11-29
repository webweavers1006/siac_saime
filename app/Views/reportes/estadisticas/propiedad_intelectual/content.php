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


          <h1>Estadísticas - Propiedad Intelectual</h1>
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
            <canvas id="estatus" width="2000" height="600"></canvas>
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
    $estados[$key] = array(
        'estado' => $estado,
        'count_estado' => 0,
        'tipo_propiedad' => array()
    );
}


foreach ($data['nombre_estado_propiedad'] as $key => $nombre_estado_propiedad) {
    $estado_key = array_search(trim($nombre_estado_propiedad), array_map('trim', $data['nombres_estados']));
    $propiedad = $data['nombre_tipo_propiedad'][$key];
    $count_propiedad = $data['count_propiedad'][$key];
    
    if (isset($estados[$estado_key])) {
        $estados[$estado_key]['tipo_propiedad'][] = array(
            'nombre_tipo_propiedad' => $propiedad,
            'count_propiedad' => $count_propiedad
        );
        $estados[$estado_key]['count_estado'] += $count_propiedad;
    }
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
const informacion = <?php echo json_encode($estados);?>;

var ctx = document.getElementById('estatus').getContext('2d');

// Usar un objeto para agrupar los datos por estado
const estadoMap = {};

// Extraer tipos de propiedad únicos
const tipopropiedadUnicos = Array.from(new Set(
  informacion.flatMap(obj => obj.tipo_propiedad.map(propiedad => propiedad.nombre_tipo_propiedad))
));

// Agrupar propiedades por estado
informacion.forEach(obj => {
  const estado = obj.estado;
  const totalPropiedades = parseInt(obj.count_estado); // Asegurarse de que sea un número

  if (!estadoMap[estado]) {
    estadoMap[estado] = {
      total: totalPropiedades,
      conteos: new Array(tipopropiedadUnicos.length).fill(0) // Inicializa el conteo para cada tipo de propiedad
    };
  }

  obj.tipo_propiedad.forEach(propiedad => {
    const index = tipopropiedadUnicos.indexOf(propiedad.nombre_tipo_propiedad);
    if (index !== -1) {
      estadoMap[estado].conteos[index] += parseInt(propiedad.count_propiedad); // Asegurarse de que sea un número
    }
  });
});

// Convertir el mapa en un array y filtrar aquellos con total > 0
const sortedData = Object.entries(estadoMap)
  .map(([estado, data]) => ({ estado, total: data.total, conteos: data.conteos }))
  .filter(item => item.total > 0) // Filtrar estados con total > 0
  .sort((a, b) => b.total - a.total); // Ordenar por total

const sortedLabels = sortedData.map(item => item.estado);
const sortedCounts = sortedData.map(item => item.conteos);

const colors = [
  '#52baac', 
  '#5999c1', 
  '#09c8f2', 
  '#ef67f3', 
  '#42eea5', 
  '#cbcbcb' 
];

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
      ...tipopropiedadUnicos.map((tipo, index) => ({
        label: tipo,
        data: sortedCounts.map(counts => counts[index]),
        backgroundColor: colors[index % colors.length], // Colores de la paleta
        borderColor: colors[index % colors.length], // Asignar un color del arreglo
        borderWidth: 1
      }))
    ]
  },
  options: {
    tooltips: {
      backgroundColor: 'rgba(0, 0, 0, 0.8)', // Color por defecto para los tooltips
      callbacks: {
        label: function(tooltipItem, data) {
          const estado = sortedLabels[tooltipItem.index];
          const tiposInfo = tipopropiedadUnicos.map((tipo, index) => {
            const conteo = sortedCounts[tooltipItem.index][index];
            return `${tipo}: ${conteo > 0 ? conteo : 0}`;
          });
          const total = sortedCounts[tooltipItem.index].reduce((a, b) => a + parseInt(b), 0); // Asegurarse de que sea un número
          return [...tiposInfo, `Total: (${total > 0 ? total : 0})`];
        },
        title: function(tooltipItem, data) {
          const estado = sortedLabels[tooltipItem[0].index];
          const total = sortedCounts[tooltipItem[0].index].reduce((a, b) => a + parseInt(b), 0); // Asegurarse de que sea un número
          return total > 0 ? estado : `${estado} (No hay propiedades)`;
        }
      }
    }
  }
});
</script>