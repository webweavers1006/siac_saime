<script type="text/javascript" src="<?= base_url(); ?>/js_paginas/Chart.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/js_paginas/jspdf.debug.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>/css_paginas/estadisticas.css">
<link rel="stylesheet" href="<?= base_url(); ?>/css_paginas/dashboard.css">
<style>
  table.dataTable thead, table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
  /* Estilo opcional para asegurar que el canvas no se desborde */
  #reportPage { overflow-x: auto; }
</style>

<div class="content-wrapper">
  <div class="content">
    <div class="container-fluid container-fluid-smaller">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Estadísticas Audiencias</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="card">
          <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
            <div id="reportPage">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <h3 class="card-title">Audiencias</h3>
                    <div class="card-tools text-right">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                    <canvas id="myChart" style="min-height: 400px; max-height: 600px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Obtenemos la data del controlador (aseguramos que sea un array)
    const rawData = <?= json_encode($estatus['requerimientosbyEstados'] ?? []); ?>;
    
    // 2. Arrays para la gráfica
    const labels = [];
    const dataValues = [];
    const backgroundColors = [];

    // Mapas de colores predefinidos (opcional)
    const colorMap = {
        'NUEVO': 'rgba(255, 206, 86, 0.7)',      // Amarillo
        'EN PROCESO': 'rgba(54, 162, 235, 0.7)', // Azul
        'RESUELTA': 'rgba(255, 99, 132, 0.7)'    // Rojo
    };

    // 3. Recorremos la data dinámicamente
    rawData.forEach(item => {
        labels.push(item.estado);
        dataValues.push(item.total);
        
        // Si el estado está en nuestro mapa usamos ese color, si no, uno gris aleatorio
        backgroundColors.push(colorMap[item.estado] || 'rgba(200, 200, 200, 0.7)');
    });

    // 4. Configuración de Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Audiencias',
                data: dataValues,
                backgroundColor: backgroundColors,
                borderColor: backgroundColors.map(c => c.replace('0.7', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            title: {
                display: true,
                text: 'Estado de Requerimientos (Actualizado)'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        precision: 0 // Solo números enteros
                    }
                }],
                xAxes: [{
                    gridLines: { display: false }
                }]
            }
        }
    });
});
</script>