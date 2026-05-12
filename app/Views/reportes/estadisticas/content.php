<script src="<?php echo base_url(); ?>/custom/js/tailwindcss.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/estadisticas.css">

<style>
  /* Configuración básica para integrar con Tailwind */
  .content-wrapper {
    background-color: #f4f6f9;
  }
  .card {
    border-radius: 0.75rem;
    box-shadow: 0 5px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s;
  }
  .card:hover {
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
  }
  .table-custom th, .table-custom td {
    padding: 0.4rem 0.6rem;
    font-size: 0.875rem;
  }
  .table-custom thead {
    background-color: #f1f5f9;
    border-bottom: 2px solid #e2e8f0;
  }
  .table-custom tbody tr:hover {
    background-color: #f8fafc;
  }
</style>

<div class="content-wrapper p-4 sm:p-6 lg:p-8">
<section class="content-header p-0">
  <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4 gap-4">
    
    <div class="flex-shrink-0">
      <h1 class="text-2xl font-extrabold text-gray-900 border-blue-500 pl-3">Estadísticas Globales</h1>
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
          </div>
          <div class="card-body p-4"> <canvas id="grafica"></canvas>
          </div>
        </div>
      </div>
      
      <div class="col-md-6 mb-4">
        <div class="card h-full">
          <div class="card-header border-b-2 border-gray-200 p-3 flex justify-between items-center bg-white rounded-t-xl">
            <h3 class="card-title text-lg font-bold text-blue-600">Tipo de Solicitud</h3>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
          
          <div class="col-span-1">
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

          <div class="col-span-1">
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
                          foreach ($via_atencion as $v_aten) :
                              $total_casos_atencion += $v_aten->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $v_aten->red_s_nom; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $v_aten->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
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

          <div class="col-span-1">
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
                          foreach ($tipo_solicitud as $t_solic) :
                              $total_casos_tipo_solicitud += $t_solic->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $t_solic->tipo_aten_nombre; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $t_solic->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
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

          <div class="col-span-1">
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
                          foreach ($estatus_casos as $e_casos) :
                              $total_casos_estatus_casos += $e_casos->count;
                          ?>
                              <tr class="hover:bg-gray-50">
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $e_casos->estnom; ?></td>
                                  <td class="whitespace-nowrap text-gray-800"><?php echo $e_casos->count; ?></td>
                              </tr>
                          <?php endforeach;
                      } ?>
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

<script>
    // Gráfica 1: Vía de Atención
    new Chart(document.querySelector("#grafica"), {
      type: 'bar',
      data: {
        labels: <?= json_encode($nombre_atencion ?? []) ?>,
        datasets: [
          {
            label: "CASOS ATENDIDOS",
            data: <?= json_encode($count_atencion ?? []) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
          },
          {
            label: 'MASCULINO',
            data: <?= json_encode($count_atencion_masculino ?? []) ?>,
            backgroundColor: 'rgba(50, 123, 255, 0.5)'
          },
          {
            label: 'FEMENINO',
            data: <?= json_encode($count_atencion_Femenino ?? []) ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
          }
        ]
      },
      options: {
        responsive: true,
        tooltips: { mode: "index", intersect: false },
        scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
      }
    });

    // Gráfica 2: Tipo de Solicitud
    new Chart(document.querySelector("#grafica_tipo_solicitud"), {
        type: 'bar',
        data: {
            labels: <?= json_encode($nombre_solicitud ?? []) ?>,
            datasets: [
                {
                    label: "CASOS ATENDIDOS",
                    data: <?= json_encode($count_solicitud ?? []) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'MASCULINO',
                    data: <?= json_encode($count_solicitud_Masculino ?? []) ?>,
                    backgroundColor: 'rgba(50, 123, 255, 0.5)'
                },
                {
                    label: 'FEMENINO',
                    data: <?= json_encode($count_solicitud_Femenino ?? []) ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: { mode: "index", intersect: false },
            scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
        }
    });
</script>