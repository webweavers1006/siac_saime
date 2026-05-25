
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
  <style>
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
  </style>

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
  <!-- Main content -->
  <div class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card">
                    <div class="card-header border-0">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h3 class="text-secondary m-0">
                                    <i class="fas fa-angle-double-right"></i> Reporte de Talleres Participantes
                                </h3>
                            </div>
                            
                         <div class="col-md-3">
    <div class="d-flex align-items-center justify-content-end">
        <label for="operador" class="m-0 me-2 text-nowrap">Operador &nbsp;&nbsp; </label>
        <select class="form-control" id="operador" name="operador">
            <option value="0" disabled selected>Seleccione</option>
        </select>
    </div>
</div>
                        </div>
                    </div>

                    <!--Form-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="col-md-2">
                                <label for="hasta">Hasta:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="col-md-2">
                                <label for="sexo">Género:</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="M">MASCULINO</option>
                                    <option value="F">FEMENINO</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="via-atencion">Via de Atención:</label>
                                <select class="form-control" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>

                           
                            <div class="col-md-2">
                                <label for="tipo-atencion-usu">Tipo de Atención:</label>
                                <select class="form-control" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>

                            <div class="col-md-2 detalle_atencion" style="display: none;">
                                <label for="tipo-pi">Detalle Atencion</label>
                                <select class="form-control" id="edit_detelle_atencion" name="detalles_atencion">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>

                        </div>

                       
                       
                    
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="tipo-pi">Tipo de Propiedad Intelectual:</label>
                                <select class="form-control" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>
                          
                            <div class="col-md-2 "  >
                                <label for="estatus">Estatus:</label>
                                <select class="form-control" id="estatus" name="estatus">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">Abierto</option>
                                    <option value="2">Cerrado</option>
                                </select>
                            </div>


                           <div class="col-md-4">
                <label for="direcciones_admin">Dirección Administrativa:</label>
                <select class="form-control select2" id="direcciones_admin" name="direcciones_admin">
                    <option value="0" selected disabled>Seleccione...</option>
                    <?= $direcciones; ?>
                </select>
            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                            <label for="estado-caso">Estado</label>
                            <select id="estado-caso" name="estado-caso" class="form-control">
                                <option value="0" disabled>Seleccione Estado</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="municipio-caso">Municipio</label>
                            <select id="municipio-caso"  name="municipio-caso" class="form-control">
                            <option value="0" selected disabled >Seleccione Municipio</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="parroquia-caso">Parroquia</label>
                            <select id="parroquia-caso" name="parroquia-caso" class="form-control">
                            <option value="0" selected disabled >Seleccione  la Parroquia</option>
                            </select>
                        </div>
                            
                        <div class="col-lg-4 col-sm-4 col-md-4 org_pp ">
                            <label for="organismo-caso">Organismo del Poder Poular</label>
                            <select id="organismo-caso" name="organismo-caso" class="form-control">
                            <option value="0">Seleccione Organismo</option>
                            </select>
                        </div>
                       <div class="col-md-5">
                        <br>
                         <label for="estado-caso">Edad-> </label>
                           <label for="edad_min"  >Desde:</label>
                           <input type="number"  style="width: 50px;" id="edad_min" min="0" name="edad_min">&nbsp;&nbsp;
                           <label for="edad_max">Hasta:</label>                                
                           <input type="number"  style="width: 50px;"id="edad_max" min="0" name="edad_max">
                         </div>

                         <div class="col-md-3">
                            <br>
                             <button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>&nbsp;&nbsp;
                             <button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
                         </div>
                     

  
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
   
      <!--Form-->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">
            <div class="card-body">
              <table class="display table-responsive" id="table_participantes" style="width:100%" style="margin-top: 20px">
                <thead>
                  <tr>
                      <td class="text-center" style="width: 1%;">Nº</td>
                      <td class="text-center" style="width: 11%;">Nombres y Apellidos</td>
                      <td class="text-center" style="width: 11%;">Nombres de la Actividad</td>
                      <td class="text-center" style="width: 2%;">cedula</td>
                      <td class="text-center" style="width: 1%;">Nac</td>
                      <td class="text-center" style="width: 2%;">T_Beneficiario</td>
                      <td class="text-center" style="width: 1%;">Pais</td>
                      <td class="text-center" style="width: 1%;">Estado</td>
                      <td class="text-center" style="width: 1%;">Municipio</td>
                      <td class="text-center" style="width: 1%;">Parroquia</td>
                      <td class="text-center" style="width: 1%;">Telefono</td>
                      <!-- <td class="text-center" style="width: 1%;">operador</td> -->
                  </tr>
                </thead>
                <tbody id="listar_casos">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>