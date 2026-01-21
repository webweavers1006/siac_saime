<div class="content-wrapper" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; position: relative;">
    <div class="hero-pattern"></div>
    <section class="content-header pt-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="hero-content">
                    <h1 class="display-4 font-weight-bold text-dark mb-2" style="letter-spacing: -2px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-chart-bar mr-3 text-primary"></i>Estadísticas de Audiencias
                    </h1>
                    <p class="text-muted mb-0 lead" style="text-shadow: 0 1px 2px rgba(0,0,0,0.05);">Vista general del estado de los requerimientos</p>
                </div>
            </div>
        </div>
    </section>

      <section class="content">
        <!-- Tarjetas KPI Principales -->
        <div class="row mb-5">
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="stats-card-modern shadow-lg border-0 bg-white p-4 d-flex align-items-center position-relative overflow-hidden">
              <div class="stats-gradient-bg bg-gradient-primary"></div>
              <div class="stats-icon-modern bg-primary text-white mr-4 position-relative z-index-1">
                <i class="fas fa-users fa-lg"></i>
              </div>
              <div class="position-relative z-index-1">
                <p class="text-muted mb-1 text-uppercase font-weight-bold" style="letter-spacing: 1.2px; font-size: 0.75rem;">Total General</p>
                <h2 class="mb-1 font-weight-bold text-dark" style="font-size: 2.5rem; line-height: 1; margin: 0;"><?= array_sum(array_column($estatus['requerimientosbyEstados'] ?? [], 'total')) ?></h2>
                <p class="mb-0 text-muted small"><i class="fas fa-chart-line mr-1"></i>Histórico</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="stats-card-modern shadow-lg border-0 bg-white p-4 d-flex align-items-center position-relative overflow-hidden">
              <div class="stats-gradient-bg bg-gradient-warning"></div>
              <div class="stats-icon-modern bg-warning text-white mr-4 position-relative z-index-1">
                <i class="fas fa-star fa-lg"></i>
              </div>
              <div class="position-relative z-index-1">
                <p class="text-muted mb-1 text-uppercase font-weight-bold" style="letter-spacing: 1.2px; font-size: 0.75rem;">Nuevos</p>
                <h2 class="mb-1 font-weight-bold text-dark" style="font-size: 2.5rem; line-height: 1; margin: 0;">
                  <?php
                    $nuevos = array_filter($estatus['requerimientosbyEstados'] ?? [], function($e) { return $e['estado'] === 'NUEVO'; });
                    echo !empty($nuevos) ? array_values($nuevos)[0]['total'] : 0;
                  ?>
                </h2>
                <span class="badge badge-warning px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; border-radius: 20px;">Pendientes</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="stats-card-modern shadow-lg border-0 bg-white p-4 d-flex align-items-center position-relative overflow-hidden">
              <div class="stats-gradient-bg bg-gradient-info"></div>
              <div class="stats-icon-modern bg-info text-white mr-4 position-relative z-index-1">
                <i class="fas fa-cog fa-lg fa-spin"></i>
              </div>
              <div class="position-relative z-index-1">
                <p class="text-muted mb-1 text-uppercase font-weight-bold" style="letter-spacing: 1.2px; font-size: 0.75rem;">En Proceso</p>
                <h2 class="mb-1 font-weight-bold text-dark" style="font-size: 2.5rem; line-height: 1; margin: 0;">
                  <?php
                    $proceso = array_filter($estatus['requerimientosbyEstados'] ?? [], function($e) { return $e['estado'] === 'EN PROCESO'; });
                    echo !empty($proceso) ? array_values($proceso)[0]['total'] : 0;
                  ?>
                </h2>
                <span class="badge badge-info px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; border-radius: 20px;">Activos</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="stats-card-modern shadow-lg border-0 bg-white p-4 d-flex align-items-center position-relative overflow-hidden">
              <div class="stats-gradient-bg bg-gradient-success"></div>
              <div class="stats-icon-modern bg-success text-white mr-4 position-relative z-index-1">
                <i class="fas fa-check-circle fa-lg"></i>
              </div>
              <div class="position-relative z-index-1">
                <p class="text-muted mb-1 text-uppercase font-weight-bold" style="letter-spacing: 1.2px; font-size: 0.75rem;">Resueltas</p>
                <h2 class="mb-1 font-weight-bold text-dark" style="font-size: 2.5rem; line-height: 1; margin: 0;">
                  <?php
                    $resueltas = array_filter($estatus['requerimientosbyEstados'] ?? [], function($e) { return $e['estado'] === 'RESUELTA'; });
                    echo !empty($resueltas) ? array_values($resueltas)[0]['total'] : 0;
                  ?>
                </h2>
                <span class="badge badge-success px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; border-radius: 20px;">Completados</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Tarjeta del Gráfico -->
        <div class="card card-modern border-0 shadow-lg" style="border-radius: 24px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%); backdrop-filter: blur(10px);">
          <div class="card-header border-0 bg-transparent pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title mb-0 font-weight-bold text-dark" style="font-size: 1.5rem;">
                <i class="fas fa-chart-bar mr-3 text-primary"></i>Estado de Requerimientos
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-outline-primary btn-sm" data-card-widget="collapse" title="Contraer/Expandir" style="border-radius: 50px; padding: 0.375rem 0.75rem;">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body pt-0">
            <div class="chart-container position-relative" style="height: 450px; max-height: 600px; border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, rgba(248,249,250,0.5) 0%, rgba(233,236,239,0.5) 100%);">
              <canvas id="myChart" style="max-width: 100%; max-height: 100%; cursor: pointer;" title="Haz clic en las barras para ver detalles"></canvas>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>/js_paginas/Chart.min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>/css_paginas/estadisticas.css">
<link rel="stylesheet" href="<?= base_url(); ?>/css_paginas/dashboard.css">

<script>
document.addEventListener("DOMContentLoaded", function() {
    const rawData = <?= json_encode($estatus['requerimientosbyEstados'] ?? []); ?>;
    
    const labels = [];
    const dataValues = [];
    const backgroundColors = [];
    const ids = [];
    const hoverColors = [];

    const colorMap = {
        'NUEVO': { bg: 'rgba(255, 206, 86, 0.8)', hover: 'rgba(255, 206, 86, 1)' },
        'EN PROCESO': { bg: 'rgba(54, 162, 235, 0.8)', hover: 'rgba(54, 162, 235, 1)' },
        'RESUELTA': { bg: 'rgba(11, 92, 88, 0.8)', hover: 'rgba(9, 49, 47, 0.8)' }
    };

    rawData.forEach(item => {
        labels.push(item.estado);
        dataValues.push(item.total);
        ids.push(item.id_estado);
        
        const colorInfo = colorMap[item.estado] || { bg: 'rgba(200, 200, 200, 0.8)', hover: 'rgba(200, 200, 200, 1)' };
        backgroundColors.push(colorInfo.bg);
        hoverColors.push(colorInfo.hover);
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Audiencias',
                data: dataValues,
                backgroundColor: backgroundColors,
                hoverBackgroundColor: hoverColors,
                borderColor: backgroundColors.map(c => c.replace('0.8', '1')),
                borderWidth: 2,
                borderRadius: 8,
                estadoIds: ids
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false 
                },
                title: {
                    display: true,
                    text: 'Distribución de Estados de Requerimientos',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    padding: {
                        bottom: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(1);
                            return `Total: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            },
            onClick: (evt, elements) => {
                if (elements && elements.length > 0) {
                    let index = elements[0].index;
                    if (index === undefined) {
                        index = elements[0]._index;
                    }
                    
                    const id_estado = chart.data.datasets[0].estadoIds[index];
                   
                    if (id_estado !== undefined) {
                        const url = '<?= base_url(); ?>/detalles_estadisticas_audiencias?id_estado=' + id_estado;
                        window.location.href = url;
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 13,
                            weight: '500'
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
    
    window.filterChart = function(filterType) {
        document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.closest('.btn').classList.add('active');
        console.log('Filtrar por:', filterType);
    };
});
</script>

