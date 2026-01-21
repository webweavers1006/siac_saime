<div class="content-wrapper" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; position: relative;">
    <div class="hero-pattern"></div>
    <section class="content-header pt-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="hero-content">
                    <h1 class="display-4 font-weight-bold text-dark mb-2" style="letter-spacing: -2px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-chart-line mr-3 text-primary"></i>Detalles de Audiencias
                    </h1>
                    <p class="text-muted mb-0 lead" style="text-shadow: 0 1px 2px rgba(0,0,0,0.05);">Vista detallada de las audiencias por estado</p>
                </div>
                <a href="<?= base_url(); ?>/estadisticas_audiencias" class="btn btn-glass shadow-lg px-4 py-3 btn-rounded-custom">
                    <i class="fas fa-arrow-left mr-2"></i> <span class="font-weight-bold">Regresar a Estadísticas</span>
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            
            <?php 
                $audiencias = isset($informacion['requerimientos']) ? $informacion['requerimientos'] : 
                              (isset($informacion['informacion']) ? $informacion['informacion'] : 
                              (isset($informacion) ? $informacion : []));
                
                $total_segmento = count($audiencias);
                
                // Detectamos el tipo de dato para el título del KPI
                $primer_item = !empty($audiencias) ? reset($audiencias) : null;
                $estado_actual = isset($primer_item['estado']) ? $primer_item['estado'] : 'AUDIENCIAS';
                
                // Configuración visual según el estado
                $config = [
                    'NUEVO'      => ['color' => 'warning', 'icon' => 'fa-star', 'label' => 'Nuevas'],
                    'EN PROCESO' => ['color' => 'info',    'icon' => 'fa-sync-alt', 'label' => 'En Proceso'],
                    'RESUELTA'   => ['color' => 'success', 'icon' => 'fa-check-double', 'label' => 'Resueltas'],
                    'DEFAULT'    => ['color' => 'primary', 'icon' => 'fa-th-large', 'label' => 'Total']
                ];

                $ui = isset($config[$estado_actual]) ? $config[$estado_actual] : $config['DEFAULT'];
            ?>

            <div class="row mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="stats-card-modern shadow-xl border-0 bg-white p-4 d-flex align-items-center position-relative overflow-hidden">
                        <div class="stats-gradient-bg bg-gradient-<?= $ui['color'] ?>"></div>
                        <div class="stats-icon-modern bg-<?= $ui['color'] ?> text-white mr-4 position-relative z-index-1">
                            <i class="fas <?= $ui['icon'] ?> fa-2x"></i>
                        </div>
                        <div class="position-relative z-index-1">
                            <p class="text-muted mb-1 text-uppercase font-weight-bold" style="letter-spacing: 1.2px; font-size: 0.75rem;">Total de Registros</p>
                            <h2 class="mb-1 font-weight-bold text-dark" style="font-size: 2.8rem; line-height: 1; margin: 0;"><?= $total_segmento ?></h2>
                            <span class="badge-modern badge-<?= $ui['color'] ?> px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;"><?= $ui['label'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-modern border-0 shadow-lg" style="border-radius: 24px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%); backdrop-filter: blur(10px);">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-modern">
                        <table class="table table-modern" id="detallesTable">
                            <thead class="thead-modern">
                                <tr>
                                    <th class="th-modern pl-4">Contacto</th>
                                    <th class="th-modern">Ubicación</th>
                                    <th class="th-modern">Asunto / Área</th>
                                    <th class="th-modern">Fecha Registro</th>
                                    <th class="th-modern text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($audiencias as $item): ?>
                                <tr class="table-row-modern">
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-modern bg-light-<?= $ui['color'] ?> text-<?= $ui['color'] ?> mr-3">
                                                <?= strtoupper(substr($item['nombre_contacto'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-1" style="font-size: 0.95rem;"><?= $item['nombre_contacto'] . ' ' . $item['apellido_contacto'] ?></div>
                                                <div class="small text-muted" style="font-size: 0.8rem;"><?= $item['correo_contacto'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem; color: #2c3e50;"><?= $item['pais'] ?></div>
                                        <div class="small text-muted" style="font-size: 0.8rem; color: #6c757d;"><?= $item['estado_pais'] ?></div>
                                    </td>
                                    <td>
                                        <div class="badge badge-<?= $ui['color'] ?> mb-2 px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; border-radius: 20px;"><?= $item['area'] ?></div>
                                        <div class="text-muted text-truncate" style="max-width: 220px; font-size: 0.85rem; line-height: 1.4; color: #5a6c7d;"><?= $item['solicitudes'] ?></div>
                                    </td>
                                    <td class="text-muted">
                                        <i class="far fa-calendar-alt mr-2 text-primary"></i>
                                        <span style="font-weight: 600; color: #2c3e50; font-size: 0.9rem;"><?= date('d/m/Y', strtotime($item['created'])) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>/detalles_requerimientos/<?= $item['id'] ?>" class="btn-action-modern" title="Ver detalles">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Modern Design Styles */
.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.hero-content {
    animation: fadeInUp 0.8s ease-out;
}

.btn-outline-primary {
    transition: all 0.3s ease;
    border-width: 2px;
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.3);
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.btn-rounded-custom {
    border-radius: 50px;
}

/* Stats Card Modern */
.stats-card-modern {
    border-radius: 24px;
    transition: all 0.3s ease;
    animation: slideInLeft 0.6s ease-out;
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
    backdrop-filter: blur(10px);
}

.stats-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stats-gradient-bg {
    position: absolute;
    top: 0;
    right: 0;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    opacity: 0.1;
    transform: translate(30px, -30px);
}

.stats-icon-modern {
    width: 60px;
    height: 60px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.badge-modern {
    border-radius: 50px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Card Modern */
.card-modern {
    transition: all 0.3s ease;
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.card-header-modern {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Table Modern */
.table-responsive-modern {
    border-radius: 0 0 24px 24px;
    overflow: hidden;
}

.table-modern {
    margin-bottom: 0;
}

.thead-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.thead-modern .th-modern {
    padding: 12px 15px;
    border-bottom: 2px solid #dee2e6;
    font-size: 0.8rem;
    color: #495057;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 700;
    vertical-align: middle;
}

.table-row-modern {
    border-bottom: 1px solid rgba(0,0,0,0.03);
}

.table-row-modern td {
    padding: 12px 15px;
    vertical-align: middle;
    border: none;
}

.avatar-modern {
    width: 45px;
    height: 45px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-action-modern {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
}

.btn-action-modern:hover {
    transform: rotate(15deg) scale(1.1);
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
    color: white;
}

/* Gradient Backgrounds */
.bg-gradient-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); }

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }

    .stats-card-modern {
        margin-bottom: 20px;
    }

    .table-responsive-modern {
        border-radius: 0;
    }

    .thead-modern .th-modern {
        padding: 15px 10px;
        font-size: 0.7rem;
    }

    .table-row-modern td {
        padding: 15px 10px;
    }
}

/* Badge Colors */
.badge-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; }
.badge-success { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; }
.badge-info { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); color: white; }
.badge-warning { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; }
</style>
