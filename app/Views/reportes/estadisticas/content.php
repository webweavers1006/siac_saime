<script src="<?php echo base_url(); ?>/custom/js/tailwindcss.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">

<style>
  /* Configuración básica para integrar con Tailwind */
  .content-wrapper {
    background-color: #f4f6f9; /* Color de fondo típico de AdminLTE */
  }
  .card {
    border-radius: 0.75rem; /* Bordes redondeados ligeramente aumentados */
    box-shadow: 0 5px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.05); /* Sombra más pronunciada pero suave */
    transition: transform 0.2s;
  }
  .card:hover {
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
  }
  /* Estilo personalizado para las tablas: más compacto y limpio */
  .table-custom th, .table-custom td {
    padding: 0.4rem 0.6rem; /* Espaciado interno más reducido */
    font-size: 0.875rem; /* Texto un poco más pequeño */
  }
  .table-custom thead {
    background-color: #f1f5f9; /* Un gris más claro para el encabezado */
    border-bottom: 2px solid #e2e8f0; /* Borde más visible */
  }
  .table-custom tbody tr:hover {
    background-color: #f8fafc; /* Color de hover más sutil */
  }
</style>



<div class="content-wrapper p-4 sm:p-6 lg:p-8">
<section class="content-header p-0">
  <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4 gap-4">
    
    <div class="flex-shrink-0">
      <h1 class="text-2xl font-extrabold text-gray-900  border-blue-500 pl-3">Estadísticas Globales</h1>
    </div>
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 text-sm flex-wrap flex-grow">
      
      <div class="flex items-center gap-3 flex-wrap">
          
          <div class="flex items-center space-x-3 flex-shrink-0">
              <label for="desde" class="font-medium text-gray-700">Desde</label>
              <input type="date" class="border border-gray-300 rounded-lg p-1.5 focus:ring-blue-500 focus:border-blue-500 w-32 shadow-sm"
                value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
          </div>

          <div class="flex items-center space-x-3 flex-shrink-0">
              <label for="hasta" class="font-medium text-gray-700">Hasta</label>
              <input type="date" class="border border-gray-300 rounded-lg p-1.5 focus:ring-blue-500 focus:border-blue-500 w-32 shadow-sm"
                value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
          </div>
          
          <div class="flex items-center space-x-3 flex-shrink-0">
              <label for="estado-caso" class="font-medium text-gray-700">Estado</label>
              <select id="estado-caso" name="estado-caso" class="border border-gray-300 rounded-lg p-1.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                  <option value="0" disabled>Seleccione Estado</option>
                  </select>
          </div>

      </div>
      
      <div class="flex items-center space-x-3 flex-shrink-0">
          <button type="button" class="consultar bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md hover:shadow-lg transform hover:scale-105">Consultar</button>
          
          <button type="button" class="limpiar bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md hover:shadow-lg">Limpiar</button>
      </div>
    </div>
  </div>
</section>
  <section class="content mt-3">
    <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
      
     <div id="reportPage" class="mb-6">
    <div class="row">

      <div class="col-md-6 mb-4">
        <div class="card h-full">
          <div class="card-header border-b-2 border-gray-200 p-3 flex justify-between items-center bg-white rounded-t-xl">
            <h3 class="card-title text-lg font-bold text-blue-600">Vía de Atención</h3>
            <div class="card-tools space-x-1">
              <button type="button" class="btn btn-tool text-gray-500 hover:text-blue-600" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool text-gray-500 hover:text-red-500" data-card-widget="remove" data-toggle="tooltip" title="Remover"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body p-4"> <canvas id="grafica"></canvas>
          </div>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="card h-full">
          <div class="card-header border-b-2 border-gray-200 p-3 flex justify-between items-center bg-white rounded-t-xl">
            <h3 class="card-title text-lg font-bold text-blue-600">Tipo de Solicitud</h3>
            <div class="card-tools space-x-1">
              <button type="button" class="btn btn-tool text-gray-500 hover:text-blue-600" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool text-gray-500 hover:text-red-500" data-card-widget="remove" data-toggle="tooltip" title="Remover"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body p-4"> <canvas id="grafica_tipo_solicitud"></canvas>
          </div>
        </div>
      </div>
    </div>
</div>
      
    </form>
    
    <div class="card">
    <form id="anual-report-tables" name="anual-report-tables" method="POST" class="form-horizontal">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4"> <!-- USO DE GRID PARA 4 COLUMNAS RESPONSIVE (CORRECTO) -->
          
          <div class="col-span-1"> <!-- USO DE COL-SPAN-1 (CORRECTO) -->
            <div class="card h-full">
              <div class="card-header py-2 bg-blue-50 border-b border-blue-200 rounded-t-lg"> <h5 class="text-blue-600 text-base font-semibold flex items-center">
                  <i class="fas fa-angle-double-right mr-1"></i> Tipo de Beneficiario
                </h5>
              </div>
              <div class="card-body p-2"> <div class="text-muted overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-custom">
                  <thead>
                      <tr>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Nombre</th>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Cantidad</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                      <?php
                      $total_casos = 0;
                      if (!empty($beneficiarios)) {
                          foreach ($beneficiarios as $beneficiario) :
                              $total_casos += $beneficiario->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $beneficiario->tipo_beneficiario_nombre; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $beneficiario->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
                      <!-- TOTAL ROW - TEXTO CORREGIDO A text-blue-800 -->
                      <tr class="bg-blue-50 font-bold border-t-2 border-blue-200">
                          <td class="whitespace-nowrap text-blue-800">Total</td>
                          <td class="whitespace-nowrap text-blue-800"><?php echo $total_casos; ?></td>
                      </tr>
                  </tbody>
              </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-span-1"> <!-- USO DE COL-SPAN-1 (CORRECTO) -->
            <div class="card h-full">
              <div class="card-header py-2 bg-blue-50 border-b border-blue-200 rounded-t-lg"> <h5 class="text-blue-600 text-base font-semibold flex items-center">
                  <i class="fas fa-angle-double-right mr-1"></i> Vía de Atención
                </h5>
              </div>
              <div class="card-body p-2"> <div class="text-muted overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-custom">
                  <thead>
                      <tr>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Nombre</th>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Cantidad</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                      <?php
                      $total_casos_atencion = 0;
                      if (!empty($via_atencion)) {
                          foreach ($via_atencion as $via_atencion) :
                              $total_casos_atencion += $via_atencion->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $via_atencion->red_s_nom; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $via_atencion->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
                      <!-- TOTAL ROW - TEXTO CORREGIDO A text-blue-800 -->
                      <tr class="bg-blue-50 font-bold border-t-2 border-blue-200">
                          <td class="whitespace-nowrap text-blue-800">Total</td>
                          <td class="whitespace-nowrap text-blue-800"><?php echo $total_casos_atencion; ?></td>
                      </tr>
                  </tbody>
              </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-span-1"> <!-- USO DE COL-SPAN-1 (CORRECTO) -->
            <div class="card h-full">
              <div class="card-header py-2 bg-blue-50 border-b border-blue-200 rounded-t-lg"> <h5 class="text-blue-600 text-base font-semibold flex items-center">
                  <i class="fas fa-angle-double-right mr-1"></i> Tipo Atención
                </h5>
              </div>
              <div class="card-body p-2"> <div class="text-muted overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-custom">
                  <thead>
                      <tr>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Nombre</th>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Cantidad</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                      <?php
                      $total_casos_tipo_solicitud = 0;
                      if (!empty($tipo_solicitud)) {
                          foreach ($tipo_solicitud as $tipo_solicitud) :
                              $total_casos_tipo_solicitud += $tipo_solicitud->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $tipo_solicitud->tipo_aten_nombre; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $tipo_solicitud->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
                      <!-- TOTAL ROW - TEXTO CORREGIDO A text-blue-800 -->
                      <tr class="bg-blue-50 font-bold border-t-2 border-blue-200">
                          <td class="whitespace-nowrap text-blue-800">Total</td>
                          <td class="whitespace-nowrap text-blue-800"><?php echo $total_casos_tipo_solicitud; ?></td>
                      </tr>
                  </tbody>
              </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-span-1"> <!-- USO DE COL-SPAN-1 (CORRECTO) -->
            <div class="card h-full">
              <div class="card-header py-2 bg-blue-50 border-b border-blue-200 rounded-t-lg"> <h5 class="text-blue-600 text-base font-semibold flex items-center">
                  <i class="fas fa-angle-double-right mr-1"></i> Estatus Casos
                </h5>
              </div>
              <div class="card-body p-2"> <div class="text-muted overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-custom">
                  <thead>
                      <tr>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Nombre</th>
                          <th class="text-left font-medium text-gray-600 uppercase tracking-wider">Cantidad</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                      <?php
                      $total_casos_estatus_casos = 0;
                      if (!empty($estatus_casos)) {
                          foreach ($estatus_casos as $estatus_casos) :
                              $total_casos_estatus_casos += $estatus_casos->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $estatus_casos->estnom; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $estatus_casos->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
                      <!-- TOTAL ROW - TEXTO CORREGIDO A text-blue-800 -->
                      <tr class="bg-blue-50 font-bold border-t-2 border-blue-200">
                          <td class="whitespace-nowrap text-blue-800">Total</td>
                          <td class="whitespace-nowrap text-blue-800"><?php echo $total_casos_estatus_casos; ?></td>
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
</div>

<?php 
   // Usando json_encode para pasar los arrays de forma limpia y segura a JavaScript
   $array_nombre_atencion = json_encode(array_values($nombre_atencion ?? []));
   $array_count_atencion = json_encode(array_values($count_atencion ?? []));
   $array_count_atencion_maculino = json_encode(array_values($count_atencion_masculino ?? []));
   $array_count_atencion_femenino = json_encode(array_values($count_atencion_Femenino ?? []));
?>
<script>
    const $grafica_via_atencion = document.querySelector("#grafica");
    // Se parsean los datos JSON directamente en JS
    const etiquetas = JSON.parse('<?php echo $array_nombre_atencion;?>');

    const datosVentas2020 = {
      label: "CASOS ATENDIDOS",
      data: JSON.parse('<?php echo $array_count_atencion;?>'),
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1,
    };

    new Chart($grafica_via_atencion, {
      type: 'bar',
      data: {
        labels: etiquetas,
        datasets: [
          datosVentas2020,
          {
            label: 'MASCULINO',
            data: JSON.parse('<?php echo $array_count_atencion_maculino; ?>'),
            backgroundColor: 'rgba(50, 123, 255, 0.5)'
          },
          {
            label: 'FEMENINO',
            data: JSON.parse('<?php echo $array_count_atencion_femenino; ?>'),
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
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

<?php 
// Usando json_encode para pasar los arrays de forma limpia y segura a JavaScript
$solicitudNombresJson = json_encode(array_values($nombre_solicitud ?? []));
$solicitudCountJson = json_encode(array_values($count_solicitud ?? []));
$solicitudCountMasculinoJson = json_encode(array_values($count_solicitud_Masculino ?? []));
$solicitudCountFemeninoJson = json_encode(array_values($count_solicitud_Femenino ?? []));
?>

<script>
    const $grafica_via_solicitud = document.querySelector("#grafica_tipo_solicitud");
    const etiquetas_solicitud = JSON.parse('<?=$solicitudNombresJson?>');
    
    const datos = {
        label: "CASOS ATENDIDOS",
        data: JSON.parse('<?=$solicitudCountJson?>'),
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
    };

    new Chart($grafica_via_solicitud, {
        type: 'bar',
        data: {
            labels: etiquetas_solicitud,
            datasets: [
                datos,
                {
                    label: 'MASCULINO',
                    data: JSON.parse('<?=$solicitudCountMasculinoJson?>'),
                    backgroundColor: 'rgba(50, 123, 255, 0.5)'
                },
                {
                    label: 'FEMENINO',
                    data: JSON.parse('<?=$solicitudCountFemeninoJson?>'),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
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