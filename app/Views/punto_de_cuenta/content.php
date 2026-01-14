<?php
$session = session();
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
      /* Paleta y superficies tipo Tailwind */
    :root {
        --slate-50: #f8fafc;
        --slate-100: #eef2f7; /* más contraste */
        --slate-200: #d9e0ea;
        --slate-300: #b8c2cf;
        --slate-500: #4b5563;
        --slate-700: #1f2937;
        --primary-500: #083B7A; /* Azul primario */
        --primary-600: #062F60;
        --primary-700: #05264D;
        --success-500: #10b981;
        --danger-500: #ef4444;
        --warning-500: #f59e0b;
        --info-500: #06b6d4;
        --accent-500: #1363DF; /* azul acento */
        --radius-md: 14px;
        --radius-sm: 10px;
        --shadow-sm: 0 2px 4px rgba(2,6,23,0.08), 0 1px 3px rgba(2,6,23,0.06);
        --shadow-md: 0 20px 25px -5px rgba(2,6,23,0.1), 0 10px 10px -5px rgba(2,6,23,0.04);
    }

    .detalle_caso {
        border-left: 1px solid #dee2e6; /* separador visual */
        padding: 15px; /* espacio interno */
        background-color: #fcfcfc; /* fondo claro como el ejemplo */
        color: #1f2937; /* buen contraste en texto */
    }

    .btn-xs-xs {
        position: relative;
        padding: 0.25rem 0.5rem;
        left: 0%;
        background-color: var(--slate-500);
        border-radius: 6px;
        align-items: center;
        color: white;
    }

    .length-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Estilos mejorados para Información General */
    .card-info {
        border: 1px solid var(--slate-200);
        border-top: 3px solid var(--info-500);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .info-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
    }

    /* Layout de 2 columnas cuando Información General ocupa todo el ancho */
    .info-general-left.col-lg-12 .info-section {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    /* Tarjetas de información */
    .info-item-custom {
        position: relative;
        display: block;
        padding: 14px 14px;
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-sm);
        background: #ffffff;
        box-shadow: var(--shadow-sm);
        transition: transform 0.12s ease, box-shadow 0.12s ease, border-color 0.12s ease, background-color 0.12s ease;
    }

    .info-item-custom:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-500);
    }

    /* Iconografía */
    .icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-grid;
        place-items: center;
        margin-right: 12px;
        box-shadow: 0 6px 12px rgba(2,6,23,0.08);
    }

    .bg-info-light { background: linear-gradient(135deg, rgba(6,182,212,0.16), rgba(19,99,223,0.12)); }
    .bg-success-light { background: linear-gradient(135deg, rgba(16,185,129,0.16), rgba(5,150,105,0.12)); }
    .bg-warning-light { background: linear-gradient(135deg, rgba(245,158,11,0.18), rgba(245,158,11,0.12)); }

    /* Encabezado del bloque Información General */
    .card.card-info .card-header {
        background: linear-gradient(135deg, rgba(8,59,122,0.95), rgba(19,99,223,0.88));
        color: #fff;
    }

    .card.card-info .card-title {
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .info-item {
        padding: 10px 12px;
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-sm);
        background: white;
        box-shadow: var(--shadow-sm);
    }

    .info-item.bg-light {
        background-color: var(--slate-100) !important;
        padding: 12px;
        border: 1px solid var(--slate-200);
    }

    .info-item.bg-info-light {
        background: linear-gradient(135deg, rgba(19,99,223,0.08), rgba(8,59,122,0.08)) !important;
        padding: 14px;
        border: 1px solid rgba(19,99,223,0.2);
    }

    .info-label {
        display: block;
        font-size: 11px !important;
        text-transform: uppercase;
        color: var(--slate-500);
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: 0.04em;
    }

    .info-value {
        font-size: 14px !important;
        color: var(--slate-700);
        word-break: break-word;
    }

    /* Unificar tipografía para Información General */
    .info-item-custom .text-uppercase,
    .info-item-custom .info-label {
        font-size: 11px !important;
    }

    .info-item-custom .font-weight-semibold,
    .info-item-custom .font-weight-medium,
    .info-item-custom .text-dark,
    .info-item-custom > div > div:last-child {
        font-size: 14px !important;
    }

    .info-item-custom .text-white {
        font-size: 14px !important;
    }

    .info-value.font-weight-bold {
        font-weight: 700;
        color: #0f172a;
    }

    .info-value.font-italic {
        font-style: italic;
        color: #334155;
        line-height: 1.6;
    }

    .additional-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Badge styles */
    .badge-success {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 800;
        border-radius: 9999px;
        letter-spacing: 0.04em;
        box-shadow: 0 8px 16px rgba(16,185,129,0.25);
    }

    /* Tabla - volver a bordes originales, sin radios ni sombra del contenedor */
    .table {
        border-collapse: collapse;
        width: 100%;
        background: transparent;
        border-radius: 0;
        overflow: visible;
        box-shadow: none;
    }

    .table thead th {
        background: linear-gradient(90deg, rgba(99,102,241,0.15), rgba(168,85,247,0.15));
        color: #0b1220;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        padding: 12px 8px; /* original */
        border-bottom: 2px solid #6c757d; /* original */
        vertical-align: middle;
        letter-spacing: 0.06em;
    }

    .table tbody td {
        padding: 10px 8px; /* original */
        vertical-align: middle;
        border-bottom: 1px solid #e6dede; /* original */
        color: #495057; /* original */
        background: transparent;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa; /* original */
    }

    .table .text-center {
        text-align: center;
    }

    /* Card improvements */
    .card {
        box-shadow: var(--shadow-md);
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-md);
        background: white;
    }

  
    .card-header::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(99,102,241,0.15), rgba(168,85,247,0.05) 60%, transparent 70%);
        filter: blur(2px);
        pointer-events: none;
    }

    .card-body {
        padding: 22px;
        background: #ffffff;
    }

    
    /* Botones mejorados */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        border-color: transparent;
        font-weight: 700;
        padding: 10px 16px;
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }

    .btn-primary:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
       
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: transparent;
        font-weight: 700;
        padding: 10px 16px;
        font-size: 13px;
        border-radius: 9999px;
        box-shadow: 0 10px 15px -3px rgba(16,185,129,0.25), 0 4px 6px -2px rgba(5,150,105,0.25);
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }

    .btn-success:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
        box-shadow: 0 20px 25px -5px rgba(16,185,129,0.35), 0 10px 10px -5px rgba(5,150,105,0.35);
    }

    .btn-dark {
        background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        border-color: transparent;
        font-weight: 100;
       padding: 4px 12px; 
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }

    .btn-dark:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
        
    }

    /* Modal improvements */
    .modal-header {
        background: linear-gradient(180deg, var(--slate-50), var(--slate-100));
        border-bottom: 1px solid var(--slate-200);
        padding: 16px 22px;
    }

    .modal-footer {
        border-top: 1px solid var(--slate-200);
        padding: 16px 22px;
        background: var(--slate-50);
    }

    .modal-title {
        font-weight: 700;
        color: #0f172a;
    }

    /* Form controls */
    .form-control {
        border: 1px solid var(--slate-300);
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
        background: white;
        transition: box-shadow 0.1s ease, border-color 0.1s ease;
    }

    .form-control:focus {
        border-color: var(--primary-500);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .form-control-sm {
        padding: 8px 10px;
        font-size: 13px;
        border-radius: 8px;
    }

    /* Page header improvements */
    .content-header {
        padding: 18px 0;
    }

    .content-wrapper {
        background-color: var(--slate-100);
    }

    /* Table responsive */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        background: transparent; /* original */
        border-radius: 0; /* original */
        box-shadow: none; /* original */
        border: 0; /* original */
    }

    /* Utilities */
    .mb-2 { margin-bottom: 0.5rem !important; }
    .mt-1 { margin-top: 0.25rem !important; }
    .mt-3 { margin-top: 1rem !important; }
    .my-3 { margin-top: 1rem !important; margin-bottom: 1rem !important; }
    .mr-2 { margin-right: 0.5rem !important; }

    /* Text utilities */
    .text-muted { color: var(--slate-500) !important; }
    .text-info { color: var(--info-500) !important; }
    .text-warning { color: var(--warning-500) !important; }
    .text-secondary { color: var(--slate-500) !important; }
    .text-primary { color: var(--primary-600) !important; }
    .text-dark { color: #0f172a !important; }
    .small { font-size: 85% !important; }
    .font-italic { font-style: italic !important; }
    .font-weight-bold { font-weight: 700 !important; }
    .text-uppercase { text-transform: uppercase !important; }

    .d-flex { display: flex !important; }
    .align-items-start { align-items: flex-start !important; }

    /* Rounded utilities */
    .rounded { border-radius: 0.5rem !important; }
    .rounded-lg { border-radius: 0.75rem !important; }

    /* Shadow utilities */
    .shadow-sm { box-shadow: var(--shadow-sm) !important; }

    /* Height utilities */
    .h-100 { height: 100% !important; }

    /* Order utilities - mantener bloque info a la derecha en desktop */
    .order-1 { order: 1 !important; }
    .order-2 { order: 2 !important; }

    @media (min-width: 768px) {
        .order-md-1 { order: 1 !important; }
        .order-md-2 { order: 2 !important; }
    }

    /* Cabeceras DataTables (compatibles) */
    table.dataTable thead,
    table.dataTable tfoot {
        color: white;
        background: linear-gradient(to right, #083B7A, #083B7A, #083B7A);
    }

    /* Ocultar bloque duplicado de Información General en vista con participantes */
    .card-body.seguimientos .row > .col-lg-4.col-md-4.col-12.order-1.order-md-2 + .col-lg-4.col-md-4.col-12.order-1.order-md-2 {
        display: none !important;
    }

    /* Iconografía visible y estilizada para Información General */
    .card.card-info .card-header i,
    .card.card-info .info-section i { opacity: 1; }
    .card.card-info .icon-wrapper { display: inline-grid !important; }

    /* Corregir padding solo en contenedores de tablas, sin afectar Información General */
    .card-body.seguimientos .row #tl > .card-body,
    .card-body.participantes .row .col-12 > .card-body { padding: 0 !important; }
    .info-general-left .card-body { padding: 18px !important; }

    /* Mover Información General hacia la izquierda */
    .info-general-left {
        margin-left: 0;
    }

    /* Ampliar ancho de Información General en escritorio */
    @media (min-width: 792px) {
        .card-body.seguimientos .row .info-general-left {
            flex: 0 0 36%;
            max-width: 36%;
            padding-left: 40px; /* separación de la tabla */
        }
        .card-body.seguimientos .row #tl {
            flex: 0 0 62%;
            max-width: 62%;
            padding-right: 30px; /* separación del bloque de info */
        }
        /* Anular espaciador para liberar ancho */
        .card-body.seguimientos .row .col-lg-1.col-md-1 {
            flex: 0 0 0 !important;
            max-width: 0 !important;
            padding: 0 !important;
        }
    }

</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><div class="col-sm-6">
        </div></div></div></div>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Punto de Cuenta 
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-punto-cuenta">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_punto_cuenta" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 10%;">Numero</td>
                              <td class="text-center" style="width: 2%;">Fecha P Cuenta</td>
                              <td class="text-center" style="width: 15%;">Nombre</td>
                              <td class="text-center" style="width: 6%;">Monto Aprobado</td>
                              <td class="text-center" style="width: 2%;">Causa</td>
                              <td class="text-center" style="width: 3%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_punto_cuenta">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="add-punto-cuenta" tabindex="-1" role="dialog" aria-labelledby="addPuntoCuentaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content shadow-lg rounded-3">
      
      <div class="modal-header bg-light border-bottom p-3">
        <h5 class="modal-title fw-bold" id="addPuntoCuentaTitle">Agregar Punto de Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="form-add-punto-cuenta" method="POST" role="form"> 
        
        <div class="modal-body p-4">
          
          <h6 class="text-secondary fw-bold text-uppercase mb-3">Datos del Punto de Cuenta</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="numero_punto_cuenta" class="form-label fw-semibold">Número de Punto de Cuenta</label>
                <input type="text" onkeyup="mayus(this);" name="numero_punto_cuenta" id="numero_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="fecha_punto_cuenta" class="form-label fw-semibold">Fecha de Punto de Cuenta</label>
                <input type="date" name="fecha_punto_cuenta" id="fecha_punto_cuenta" class="form-control form-control-sm" autocomplete="off" required> 
              </div>
            </div>
          </div>
          
          <div class="d-flex align-items-center mb-3">
              <div class="flex-grow-1"><hr class="m-0"></div>
              <h6 class="text-secondary fw-bold text-uppercase text-center mx-3 mb-0">Aprobador</h6>
              <div class="flex-grow-1"><hr class="m-0"></div>
          </div>
          
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="nombre_beneficiario" class="form-label">Nombre</label>
                <input type="text" onkeyup="mayus(this);" name="nombre_beneficiario" id="nombre_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-0">
                <label for="apellido_beneficiario" class="form-label">Apellido</label>
                <input type="text" onkeyup="mayus(this);" name="apellido_beneficiario" id="apellido_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="mb-0">
                <label for="monto_aprobado" class="form-label">Monto Aprobado</label>
                <input type="text" onkeypress="return valideKey(event);" name="monto_aprobado" id="monto_aprobado" class="form-control form-control-sm" step="0.01" min="0" autocomplete="off" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-0">
                <label for="causa_beneficiario" class="form-label">Causa del Beneficiario</label>
                <input type="text" onkeyup="mayus(this);" name="causa_beneficiario" id="causa_beneficiario" class="form-control form-control-sm" autocomplete="off" required>
              </div>
            </div>
          </div>
          
      
          </div>
        
        <div class="modal-footer d-flex justify-content-end border-top bg-light p-3">
          <button class="btn btn-sm btn-secondary me-2" type="reset">Limpiar</button>
          
          <button type="button" class="btn btn-sm btn-danger me-2" data-dismiss="modal">Cerrar</button>

          <button class="btn btn-sm btn-success" type="submit">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

      <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="editarPuntoCuentaTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarPuntoCuentaTitulo">
                    <i class="fas fa-edit me-2"></i> Editar Punto de Cuenta
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-edit-punto-cuenta" method="POST" role="form">
                <input type="hidden" name="id_punto_cuenta_editar" id="id_punto_cuenta_editar" class="form-control">

                <div class="modal-body">

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-file-invoice me-2"></i> Información Principal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_numero_punto_cuenta" class="form-label">Número de Punto de Cuenta</label>
                                        <input type="text" onkeyup="mayus(this);" name="numero_punto_cuenta" id="edit_numero_punto_cuenta" class="form-control" autocomplete="off" required placeholder="Escribe el número aquí">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_fecha_punto_cuenta" class="form-label">Fecha de Punto de Cuenta</label>
                                        <input type="date" name="fecha_punto_cuenta" id="edit_fecha_punto_cuenta" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-user-tie me-2"></i> Datos del Aprobador y Monto
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_nombre_beneficiario" class="form-label">Nombre del Aprobador</label>
                                        <input type="text" onkeyup="mayus(this);" name="nombre_beneficiario" id="edit_nombre_beneficiario" class="form-control" autocomplete="off" required placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_apellido_beneficiario" class="form-label">Apellido del Aprobador</label>
                                        <input type="text"  onkeyup="mayus(this);" name="apellido_beneficiario" id="edit_apellido_beneficiario" class="form-control" autocomplete="off" required placeholder="Apellido">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_monto_aprobado" class="form-label">Monto Aprobado</label>
                                        <div class="input-group">
                                            
                                            <input type="text" onkeypress="return valideKey(event);" name="monto_aprobado" id="edit_monto_aprobado" class="form-control" step="0.01" min="0" autocomplete="off" required placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_causa_beneficiario" class="form-label">Causa/Motivo</label>
                                        <input type="text" onkeyup="mayus(this);" name="causa_beneficiario" id="edit_causa_beneficiario" class="form-control" autocomplete="off" required placeholder="Breve descripción de la causa">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-paperclip me-2"></i> Gestión de Documentos
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Subir Nuevo Documento</h6>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="archivo" name="archivo" aria-describedby="btn_subir_archivos">
                                <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">
                                <button type="button" id="subir_archivos" class="btn btn-info">
                                    <i class="fas fa-cloud-upload-alt me-1"></i> Subir Archivo
                                </button>
                            </div>
                            
                            <h6 class="card-subtitle mb-2 text-muted">Documentos Existentes del Caso</h6>
                            <div class="row g-3 align-items-center">
                                <div class="col-12">
                                    <select class="form-control" id="docu-punto" name="docu-punto">
                                        <option value="0" selected disabled>Seleccione un documento adjunto...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="borrado" name="borrado" value='false'>
                        <label class="form-check-label fw-bold" for="borrado">Punto de Cuenta Activo</label>
                        <small class="text-muted d-block">Desactivar para marcar como inactivo o borrado.</small>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" type="reset">
                        <i class="fas fa-eraser me-1"></i> Limpiar Campos
                    </button>
                    <div>
                        <button type="button" class="btn btn-danger me-2" data-dismiss="modal">
                            <i class="fas fa-times-circle me-1"></i> Cerrar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-save me-1"></i> Actualizar Punto
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>


     <div class="modal fade" id="modal-casos" tabindex="-1" role="dialog" aria-labelledby="modalCasosTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header bg-primary text-white p-3 border-bottom-0 rounded-top-lg">
                <h5 class="modal-title font-weight-bold" id="modalCasosTitle">
                    <i class="fas fa-link mr-2"></i> Gestión de Casos Asociados
                </h5>
                <button type="button" class="close text-white opacity-100" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true" class="h3 font-weight-light">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 modal-body-lg-text"> 
                
                <div class="card shadow-sm mb-4 border-left-primary">
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <h6 class="card-title text-primary m-0 font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i> Detalles del Punto de Cuenta
                        </h6>
                         <span id="detalle-numero-cuenta" class="badge badge-info ml-2 font-weight-bold p-2"></span>
                    </div>
                    <div class="card-body p-3 informacion">
                        <dl class="row mb-0"> 
                            <dt class="col-sm-3 text-secondary">Nombre Aprobador:</dt>
                            <dd class="col-sm-9 font-weight-bold text-dark"><span id="detalle-nombre-completo"></span></dd>
                            
                            <dt class="col-sm-3 text-secondary">Causa:</dt>
                            <dd class="col-sm-9 text-muted text-wrap"><span id="detalle-causa"></span></dd>
                            
                            <dt class="col-sm-3 text-secondary">Fecha:</dt>
                            <dd class="col-sm-3"><span id="detalle-fecha" class="badge badge-light border text-secondary p-1 font-weight-normal"></span></dd>

                            <dt class="col-sm-3 text-secondary">Monto Aprobado:</dt>
                            <dd class="col-sm-3 text-success font-weight-bolder">
                                <i class="fas fa-money-bill-wave mr-1"></i> <span id="detalle-monto"></span>
                            </dd>
                             <div class="mt-4">
    <label class="small text-uppercase text-muted font-weight-bold mb-2">
        <i class="fas fa-paperclip mr-1"></i> Documentos Adjuntos del Caso
    </label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white text-primary">
                <i class="fas fa-file-pdf"></i>
            </span>
        </div>
        <select class="custom-select form-control-lg shadow-none" id="docu-punto-deta" name="docu-punto" style="font-size: 0.9rem;">
            <option value="0" selected disabled>Seleccione un documento para visualizar...</option>
            </select>
        
    </div>
    <small class="form-text text-muted mt-2">
        <i class="fas fa-info-circle mr-1"></i> Se muestran todos los archivos digitales vinculados a este punto de cuenta.
    </small>
</div>
                        </dl>
                        <input type="hidden" id="caso-id-punto-cuenta">
                    </div>
                </div>

                <h6 class="mt-4 mb-3 text-primary border-bottom pb-2 font-weight-bold">
                    <i class="fas fa-list-alt mr-2"></i> Casos Actualmente Asociados
                </h6>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="lista-casos-asociados">
                            <p class="text-muted m-0 p-4 border rounded"><i class="fas fa-sync fa-spin mr-2 text-primary"></i> Cargando casos...</p> 
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="resumen-financiero" class="mt-3">
                            </div>
                    </div>
                </div>
                
                <hr class="my-4"> 

                <h6 class="mb-3 text-success font-weight-bold">
                    <i class="fas fa-link mr-2"></i> Asociar Nuevo Caso
                </h6>
                <form id="form-asociar-caso">
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-5">
                            <label for="input-nuevo-caso">Número/Referencia del Caso</label>
                            <div class="input-group shadow-sm">
                                <input type="text" id="inputnuevocaso" onkeypress="return valideKey(event);" name="referencia_caso" class="form-control" placeholder="Ej: 2023-012345" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="btnverificarcaso">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-lg border-0 border-top-success mt-3" id="card-detalle-caso" style="display: none;">
    
    <div class="card-header bg-white p-2">
        <h3 class="text-success m-0 font-weight-bold small">
            <i class="fas fa-check-circle mr-2"></i> Informacion del Caso
        </h3>
    </div>
    
    <div class="card-body p-3 pt-2">
        <dl class="row mb-0 small">
            
            <dt class="col-sm-3 text-muted text-truncate">Nombre:</dt>
            <dd class="col-sm-9 font-weight-bolder text-dark mb-1">
                <input type="text" id="campo-nombre" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
            </dd>
            
            <dt class="col-sm-3 text-muted">Cédula:</dt>
            <dd class="col-sm-3 font-weight-normal text-muted mb-1">
                <input type="text" id="campo-cedula" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
            </dd>
            
            <dt class="col-sm-3 text-muted">Teléfono:</dt>
            <dd class="col-sm-3 font-weight-normal text-muted mb-1">
                <input type="text" id="campo-telefono" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
            </dd>

            <dt class="col-sm-3 text-muted">Tipo de Atención:</dt>
            <dd class="col-sm-9 font-weight-semibold text-primary mb-1">
                <input type="text" id="campo-tipo-atencion" class="form-control form-control-sm border-0 bg-transparent p-0" readonly>
            </dd>
            
        </dl>
    </div>
</div>

                  <div id="mensaje-punto-cuenta" class="mt-2" style="display: none;"></div> 
                    <button type="submit" id="btn-asociar-caso" class="btn btn-success btn-block mt-3 py-2 shadow-sm" disabled>
                        <i class="fas fa-plus-circle mr-2"></i> Asociar Caso
                    </button>
                </form>
            </div>
            
            <div class="modal-footer d-flex justify-content-end p-3 bg-light border-top-0 rounded-bottom-lg"> 
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

      <script type="text/javascript">
        function valideKey(evt) {
          var code = (evt.which) ? evt.which : evt.keyCode;
          if (code == 8) { // backspace.
            return true;
          } else if (code >= 48 && code <= 57) { // is a number.
            return true;
          } else { // other keys.
            return false;
          }
        }
      </script>
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>