<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>

<style>


/* 3. COMPACTAR EL LOGO/CINTILLO (AJUSTADO) */
.navbar img, 
.cintillo-compacto { 
    /* Altura final ya establecida en el HTML (height="75"), esto solo la refuerza */
    height: 60px; 
    /* Elimina cualquier margen residual para compactación vertical */
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    /* Asegura que el contenedor de la imagen no afecte el layout horizontal */
    display: block; 
}

/* Estilo para un campo que está deshabilitado y queremos resaltar visualmente */
.campo-deshabilitado {
    background-color: #f5f5f5 !important; /* Un gris muy claro */
    color: #888888 !important;         /* Texto en gris para indicar deshabilitado */
    cursor: not-allowed !important;    /* Cambia el cursor para indicar que no se puede interactuar */
    /* Opcional: Si usa Bootstrap u otro framework, puedes sobreescribir su estilo */
    border-color: #e9ecef !important;
}
/* Estilo para los campos deshabilitados/de solo lectura */
.campo-solo-lectura {
    background-color: #f5f5f5 !important; /* Gris claro para indicar inactividad */
    color: #555555 !important;         /* Texto gris */
    cursor: not-allowed !important;    /* Cursor de prohibido */
    border-color: #e0e0e0 !important;
}
</style>
<script src="<?php echo base_url(); ?>/custom/js/tailwindcss.js"></script>

    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], 
                    },
                    colors: {
                        'primary-blue': '#007bff', 
                        'primary-dark': '#0056b3',
                        'theme-gray': '#a9b6c2', 
                    }
                }
            }
        }
    </script>

    <style>
        /* ⭐ Estilos que hacen los campos más compactos y visibles (AJUSTADOS) ⭐ */
        .compact-form-control {
            height: calc(1.9rem + 2px) !important; /* Altura compacta */
            padding: .25rem .5rem !important;     
            font-size: .875rem !important;        
            width: 100% !important; 
        }
        /* Etiqueta con margen inferior más reducido */
        .card-body label {
            font-size: 0.9rem;
            margin-bottom: .1rem; /* Margen inferior muy reducido: de .15rem a .1rem */
            display: block; 
        }
        .compact-input-edad {
            width: 65px !important; 
            height: calc(1.9rem + 2px) !important;
            padding: .25rem .5rem !important;
            font-size: .875rem !important;
            display: inline-block;
        }
        /* Ajuste de padding de columna para layout compacto, reemplaza el padding de Bootstrap */
        .col-compact {
            padding-right: 5px; 
            padding-left: 5px;
        }
        
        /* Reduce el tamaño del campo de texto de BÚSQUEDA (Search) de DataTables */
        div.dataTables_wrapper div.dataTables_filter input {
            height: calc(1.9rem + 2px) !important; 
            padding: .25rem .5rem !important;
            font-size: .875rem !important;
            max-width: 200px; 
            display: inline-block; 
        }
        /* Alinea verticalmente la etiqueta "Search:" */
        div.dataTables_wrapper div.dataTables_filter label {
            font-size: 0.9rem;
        }


    </style>

<!-- <link rel="stylesheet" href="<php echo base_url(); ?>/datatable_responsive/css/responsive.bootstrap4.css"> -->
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
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
      /* Botones mejorados */
    .btn-xs {
     
        border-color: transparent;
        font-weight: 700;
         padding: 4px 6px; 
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }
    /* Botones mejorados */
   .btn_agregar{
     background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        border-color: transparent;
        font-weight: 700;
         padding: 8px 13px; 
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }

    

</style>
<style>
    /* Estructura del Header Premium */
    .premium-top-header {
        background: linear-gradient(135deg, #002244 0%, #003366 50%, #004488 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 15px 15px 0 0; /* Solo redondeado arriba para unirlo a la tabla */
        box-shadow: 0 10px 25px rgba(0, 34, 68, 0.2);
    }

    .header-grid {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        align-items: center;
    }

    /* Badge central con Glassmorphism */
    .direction-badge-large {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 8px 25px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }
    .direction-badge-large strong { 
        font-size: 1.4rem; 
        font-weight: 800; 
        color: #fff;
        display: block; 
    }

    /* Botón Agregar estilo Pill blanco */
    .siac-btn-primary {
        background: white !important;
        color: #003366 !important;
        font-weight: 800;
        font-size: 0.8rem;
        padding: 10px 20px;
        border-radius: 50px;
        border: none;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .siac-btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255,255,255,0.3);
    }

    /* Cursor del efecto de escritura */
    .typing-cursor {
        display: inline-block; width: 3px; height: 1.1em; background-color: #3498db;
        margin-left: 5px; animation: blink-cursor 0.8s infinite; vertical-align: middle;
    }
    @keyframes blink-cursor { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

    @media (max-width: 992px) {
        .header-grid { grid-template-columns: 1fr; gap: 15px; text-align: center; }
        .text-right { text-align: center; }
    }
</style>












<style>
 

    
   

    /* Animación de escritura */
    .typing-cursor {
        display: inline-block; width: 3px; height: 1.1em; background-color: var(--accent-blue);
        margin-left: 5px; animation: blink-cursor 0.8s infinite; vertical-align: middle;
    }
    @keyframes blink-cursor { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
</style>


<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/edicion_casos.css">
<!-- Estilos de mejoras visuales para la vista de casos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/mejoras_casos.css">
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                    
                    <div class="siac-main-card">
                        
                        <header class="premium-top-header">
                            <div class="header-grid">
                                
                                <div class="title-area">
                                    <h3 class="m-0 text-white">
                                        <i class="fas fa-folder-open mr-2 text-info"></i> 
                                        Pantalla de Casos
                                    </h3>
                                    <small class="text-white-50 text-uppercase tracking-widest" style="font-size: 0.65rem;">
                                        Gestión de Expedientes
                                    </small>
                                </div>

                                <div class="direction-center">
                                    </div>

                                <div class="text-right">
                                    <button type="submit" id="btn_agregar" class="siac-btn-primary shadow-sm">
                                        <i class="fas fa-plus-circle mr-1"></i> Agregar Caso
                                    </button>
                                    
                                    <input type="hidden" id="rol_usuario" value="<?php echo($session->get('userrol'));?>">
                                    <input type="hidden" id="mensaje_documento" value="<?php echo $mensaje ?>">
                                </div>

                            </div>
                        </header>
                        
                        </div> </div>
            </div>
        </div>

<div class="card-body p-0"> <div class="row px-4 py-3">
        <div class="col-lg-12 col-sm-12 col-md-12">
            
            <div class="bg-white rounded-lg shadow-sm border p-3">
                <div class="siac-table-container">
                    <table class="display table-professional datatable-full-width" id="table_casos" style="width:100%">
                        <thead class="siac-table">
                            <tr>
                                <th style="width: 50px; white-space: nowrap;">Nº</th>
                                
                                <th class="text-center" style="width: 90px; white-space: nowrap;">Cédula</th>
                                
                                <th class="text-center" style="min-width: 200px;">Beneficiario</th>
                                
                                <th class="text-center" style="width: 100px; white-space: nowrap;">Teléfono</th>
                                
                                <th class="text-center" style="width: 120px; white-space: nowrap;">Propiedad Intelectual</th>
                                
                                <th class="text-center" style="width: 120px; white-space: nowrap;">Tipo de Atención</th>
                                
                                <th class="text-center" style="width: 90px; white-space: nowrap;">Fecha</th>
                                
                                <th class="text-center" style="width: 100px; white-space: nowrap;">Estatus</th>
                                
                                <th class="text-center" style="width: 100px; white-space: nowrap;">Operador</th>
                                
                                <th class="text-center" style="width: 140px; white-space: nowrap; text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listar_casos" class="siac-table">
                            </tbody>
                    </table>
                </div>
            </div> </div>
    </div>
</div>
                  <!-- Custom CSS for full-width DataTables -->
                  <style>
                      /* Ensure DataTables uses full container width */
                      .datatable-full-width {
                          width: 100% !important;
                          table-layout: auto;
                          min-width: 100%;
                      }
                      
                      /* Fix for nested table container */
                      .siac-table-container {
                          width: 100% !important;
                          max-width: 100%;
                          overflow-x: auto;
                      }
                      
                      /* Ensure proper column distribution */
                      #table_casos {
                          width: 100% !important;
                          table-layout: auto;
                      }
                      
                      /* Responsive wrapper for DataTables */
                      .dataTables_wrapper {
                          width: 100% !important;
                          min-width: 100%;
                      }
                      
                      /* Ensure all wrapper elements use full width */
                      .dataTables_scroll,
                      .dataTables_scrollBody,
                      .dataTables_scrollHead,
                      .dataTables_scrollHeadInner {
                          width: 100% !important;
                          max-width: 100% !important;
                      }
                      
                      /* Fix for Bootstrap grid conflict */
                      .siac-main-card .row {
                          margin-right: 0;
                          margin-left: 0;
                      }
                      
                      /* Ensure columns use full width on all screen sizes */
                      @media (min-width: 768px) {
                          .siac-table-container {
                              width: 100% !important;
                              max-width: 100% !important;
                          }
                      }
                      
                      @media (min-width: 992px) {
                          .siac-table-container {
                              width: 100% !important;
                              max-width: 100% !important;
                          }
                      }
                      
                      @media (min-width: 1200px) {
                          .siac-table-container {
                              width: 100% !important;
                              max-width: 100% !important;
                          }
                      }
                  </style>
          </div>
            </div>
          
            
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <style>
      #editCase {
      overflow-y: auto;
      max-height: auto; /* adjust the max-height value as needed */
    }
    </style>
<div class="modal fade" id="editCase">
    <div class="modal-dialog modal-dialog-centered modal-xl"> 
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-secondary"><i class="fas fa-angle-double-right"></i> EDICION DE CASO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_caso">
                <div class="siac-section-card">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-user-tie"></i> Información del Beneficiario
                        </h5>
                    </div>
                    <input type="hidden" id="nombre_anterior" name="" value="">
                    <input type="hidden" id="tipo_atend_borrado" name="" value="">
                    <input type="hidden" id="apellido_anterior" name="" value="">
                    <input type="hidden" id="tipo_persona_anterior" name="" value="">
                    <input type="hidden" id="cedula_anterior" name="" value="">
                    <input type="hidden" id="t_beneficiario_anterior" name="" value="">
                    <input type="hidden" id="genero_anterior" name="" value="">
                    <input type="hidden" id="telefono_anterior" name="" value="">
                    <input type="hidden" id="fecha_anterior" name="" value="">
                    <input type="hidden" id="via_atencion_anterior" name="" value="">
                    <input type="hidden" id="ofiid_anterior" name="" value="">
                    <input type="hidden" id="correo_anterior" name="" value="">
                    <input type="hidden" id="direccion_anterior" name="" value="">
                    <input type="hidden" id="estado_anterior" name="" value="">
                    <input type="hidden" id="municipio_anterior" name="" value="">
                    <input type="hidden" id="parroquia_anterior" name="" value="">
                    <input type="hidden" id="descripcion_anterior" name="" value="">
                    <input type="hidden" id="Tipo_prop_anterior" name="" value="">
                    <input type="hidden" id="Tipo_antenc_anterior" name="" value="">
                    <input type="hidden" id="ente_anterior" name="" value="">
                    <input type="hidden" id="cgr_anterior" name="" value="">
                    <input type="hidden" id="azume_anterior" name="" value="">
                    <input type="hidden" id="afecta_hechos_anterior" name="" value="" autocomplete="off">
                    <input type="hidden" id="fecha_hechos_anterior" name="" value="">
                    <input type="hidden" id="involucrados_anterior" name="" value="">
                    <input type="hidden" id="nombre_instancia_anterior" name="" value="">
                    <input type="hidden" id="rif_instancia_anterior" name="" value="">
                    <input type="hidden" id="ente_financiador_anterior" name="" value="">
                    <input type="hidden" id="nombre_proyecto_anterior" name="" value="">
                    <input type="hidden" id="monto_aprobado_anterior" name="" value="">
                    <input type="hidden" id="actcoordenadas">
                    <input type="hidden" class="form-control" id="id_hijos_detalle_atencion">
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="nombre-persona">Nombre</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="nombre-persona" id="nombre-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="apellido-persona">Apellido</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="apellido-persona" id="apellido-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-6 mb-2">
                                <label class="siac-label" for="tipo-persona">Tipo Persona</label>
                                <select class="siac-select" id="tipo-persona" name="tipo-persona">
                                    <option value="V">V - Venezolano</option>
                                    <option value="E">E - Extranjero</option>
                                    <option value="J">J - Juridico</option>
                                    <option value="G">G - Gobierno</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-6 mb-2">
                                <label class="siac-label" for="cedula-persona">Nº cedula o Rif</label>
                                <input type="text" class="siac-input" name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-4 mb-2">
                                <label class="siac-label" for="edad">Edad</label>
                                <input type="text" disabled class="siac-input" onkeyup="mayus(this);" name="edad" id="edad" onkeypress="return valideKey(event);" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-8 mb-2">
                                <label class="siac-label" for="fecha-nacimiento">Fecha de Nac.</label>
                                <input class="siac-input" type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="profesion">Profesión</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="profesion" id="profesion" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="sexo">Genero</label>
                                <select class="siac-select" id="sexo" name="sexo">
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="siac-select" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="siac-section-card siac-mt-3">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-id-card"></i> Información de Contacto y Atención
                        </h5>
                    </div>
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="telefono-persona">Teléfono</label>
                                <input type="text" class="siac-input" onkeypress="return valideKey(event);" maxlength="12" pattern="\d{12}" title="Debe ingresar exactamente 12 dígitos" name="telefono" id="telefono" autocomplete="off">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="fecha-recibido">Fecha de Recibido</label>
                                <input class="siac-input" type="date" name="fecha-recibido" id="fecha-recibido" required>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <label class="siac-label" for="correo">Correo Electronico</label>
                                <input type="email" class="siac-input" name="correo" id="correo" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="red-social">Via de Atencion</label>
                                <select class="siac-select" name="red-social" id="red-social">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-lg-9 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="office">Atención al Ciudadano</label>
                                <select class="siac-select" name="office" id="office">
                                    <option value="1">Dirección de Atención al Ciudadano</option>
                                    <option value="2">Coordinador Estadal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="siac-section-card siac-mt-3">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-map-marked-alt"></i> Ubicación
                        </h5>
                    </div>
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <label for="direccion" style="display: none;">Dirección</label>
                                <input type="text" style="display: none;" class="siac-input" name="direccion" id="direccion" autocomplete="off">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <label class="siac-label" for="pais-caso">País</label>
                                <select  id="pais-caso" name="pais-caso" class="siac-select">
                                    <option value="1" selected>Venezuela</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <label class="siac-label" for="estado-caso">Estado</label>
                                <select id="estado-caso" name="estado-caso" class="siac-select">
                                    <option value="0" disabled>Seleccione Estado</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <label class="siac-label" for="municipio-caso">Municipio</label>
                                <select id="municipio-caso" name="municipio-caso" class="siac-select">
                                    <option value="0">Seleccione Municipio</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
                                <label class="siac-label" for="parroquia-caso">Parroquia</label>
                                <select id="parroquia-caso" name="parroquia-caso" class="siac-select">
                                    <option value="0">Seleccione Parroquia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="siac-section-card siac-mt-3">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-file-alt"></i> Detalles del Caso
                        </h5>
                    </div>
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="tipo-atencion-usu">Tipo de Atención</label>
                                <select class="siac-select" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12 mb-2 prop_int oculto">
                                <label class="siac-label" for="tipo-pi">Tipo de Propiedad Intelectual</label>
                                <select disabled class="siac-select" id="tipo-pi" name="tipo-pi">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2 org_pp">
                                <label class="siac-label" for="organismo-caso">Organismo del Poder Popular</label>
                                <select id="organismo-caso" name="organismo-caso" class="siac-select">
                                    <option value="0">Seleccione Organismo</option>
                                </select>
                            </div>
                             <!-- IMPUT QUE VALIDA SI SE SELECCIONO UN TIPO DE ATENCION CON HIJOS -->
          <input type="hidden" class="form-control" name="hijos_tipoatencion" id="hijos_tipoatencion" autocomplete="off" >


                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2 detalle_atencion oculto">
                                <label class="siac-label" for="edit_detelle_atencion">Detalle Atencion</label>
                                <select disabled class="siac-select" id="edit_detelle_atencion" name="detalles_atencion">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="siac-label" for="requerimiento-usuario">Descripción del Caso</label>
                                <textarea type="text" class="siac-input" name="requerimiento-usuario" id="requerimiento-usuario" required rows="3" style="min-height: 100px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="siac-section-card siac-mt-3" id="cgr" style="display: block;">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-question-circle"></i> Asesoría
                        </h5>
                    </div>
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="ente_adscrito_id">Ente adscrito</label>
                                <select class="siac-select" id="ente_adscrito_id" name="competencia-cgr" value="0">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="competencia-cgr">Competencia de CGR</label>
                                <select class="siac-select" id="competencia-cgr" name="competencia-cgr" value="0">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="asume-cgr">Asume CGR</label>
                                <select class="siac-select" id="asume-cgr" name="asume-cgr" value="0">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /*Contenido de Mediacion -->
        <div class="row" id="mediacion" style="display: none;">

<div class="space-y-6 p-6 border border-gray-300 rounded-xl shadow-lg bg-white w-full max-w-6xl mx-auto"> 

    <div class="border-b pb-6 space-y-4">
        
        <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg flex flex-wrap justify-between items-center">
            <span>Datos del Apoderado del Solicitante</span>
            
            <div class="flex items-center space-x-3 mt-2 sm:mt-0"> 
                <input type="checkbox" id="apoderado-solicitante-aplica" onchange="toggleApoderado('apoderado-solicitante')"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="apoderado-solicitante-aplica" class="text-lg font-semibold text-gray-800 flex items-center select-none"> Aplica</label> 
            </div>
        </h3>
        
        <div id="apoderado-solicitante-content" class="apoderado-content apoderado-hidden space-y-4">
            
            <div class="mb-4">
                    <div class="flex items-center space-x-3">
                        <label for="cedula-existente-apo-sol" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula </label>
                        <input type="text" onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente" min="7" id="cedula-existente-apo-sol" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_sol" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                    </div>
                </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="apo_solicitente-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo de Persona</label>
                        <select id="apo_solicitente-ident-tipo" name="apo_solicitente-ident-tipo" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                            <option value="V" selected>V - Venezolano</option>
                            <option value="E">E - Extranjero</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2"> 
                        <label for="apoderado-solicitante-ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                        <input type="text" onkeypress="return valideKey(event);" id="apoderado-solicitante-ci" placeholder="Ej: 12345678"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="apoderado-solicitante-impre" class="block text-sm font-medium text-gray-700">IMPRE Abogado</label>
                    <input type="text"  onkeyup="mayus(this);" id="apoderado-solicitante-impre" placeholder="Ej: 12345"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div>
                <label for="apoderado-solicitante-nombres" class="block text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                <input type="text"  onkeyup="mayus(this);" id="apoderado-solicitante-nombres" placeholder="Ej: Rosa María Gómez"
                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="apoderado-solicitante-telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" id="apoderado-solicitante-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="apoderado-solicitante-correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="flex items-center"> 
                        <input type="email"  onkeyup="mayus(this);" id="apoderado-solicitante-correo" placeholder="ejemplo@abogado.com"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <span class="feedback-icon ml-2"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                <div>
                    <label for="apoderado-solicitante-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                    <select id="apoderado-solicitante-pais-select" name="apoderado-solicitante-pais" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione País</option>
                    </select>
                </div>

                <div>
                    <label for="apoderado-solicitante-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="apoderado-solicitante-estado-select" name="apoderado-solicitante-estado" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Estado</option>
                    </select>
                </div>
                
                <div>
                    <label for="apoderado-solicitante-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                    <select id="apoderado-solicitante-municipio-select" name="apoderado-solicitante-municipio" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Municipio</option>
                    </select>
                </div>
                
                <div>
                    <label for="apoderado-solicitante-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                    <select id="apoderado-solicitante-parroquia-select" name="apoderado-solicitante-parroquia" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Parroquia</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="apoderado-solicitante-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
                <input type="text" id="apoderado-solicitante-direccion"  onkeyup="mayus(this);" placeholder="Calle, Edificio, Oficina"
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <div class="border-b pb-6 space-y-4">
        
        <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg">
            Datos de la Contraparte
        </h3>
        
         <div class="mb-4">
                <div class="flex items-center space-x-3">
                    <label for="cedula-existente-contra" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula o Rif</label>
                    <input type="text"  onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente-contra" min="7" id="cedula-existente-contra" autocomplete="off">
                    <button type="button" id="btn_buscar_contra" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                </div>
            </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            
            <div>
                <label for="contraparte-nombre-razon" class="block text-sm font-medium text-gray-700">
                    Nombres y Apellidos / Razón Social <span class="text-red-500">*</span>
                </label>
                <input type="text"  onkeyup="mayus(this);" id="contraparte-nombre-razon" placeholder="Ej: Juan Pérez o Empresa C.A." 
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

            <div class="flex space-x-3">
                <div class="w-1/3">
                    <label for="contraparte-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select id="contraparte-ident-tipo" name="contraparte-ident-tipo" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                        
                        <option value="V" selected>V - Venezolano</option>
                        <option value="E">E - Extranjero</option>
                        <option value="J">J - Jurídico</option>
                        <option value="G">G - Gubernamental</option>
                    </select>
                </div>
                
                <div class="w-2/3">
                    <label for="contraparte-ident-valor" class="block text-sm font-medium text-gray-700">Identificación (C.I. / RIF)</label>
                    <input type="text"   onkeyup="mayus(this);" id="contraparte-ident-valor" placeholder="Ej: 12345678"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            
            <div>
                <label for="contraparte-telefono" class="block text-sm font-medium text-gray-700">
                    Teléfono <span class="text-red-500">*</span>
                </label>
                <input type="text" id="contraparte-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567" 
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
            </div>

            <div>
                <label for="contraparte-correo" class="block text-sm font-medium text-gray-700">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                
                <div class="flex items-center">
                    
                    <input type="email"  onkeyup="mayus(this);" id="contraparte-correo" placeholder="ejemplo@dominio.com" 
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    
                    <span class="feedback-icon ml-2"></span>
                </div>
            </div>

        </div>
            
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">

            <div>
                <label for="contraparte-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                <select id="contraparte-pais-select" name="contraparte-pais" 
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="0" disabled selected>Seleccione País</option>
                    </select>
            </div>
            <div>
                <label for="contraparte-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="contraparte-estado-select" name="contraparte-estado" 
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                    <option value="0" disabled selected>Seleccione Estado</option>
                    </select>
            </div>
            <div>
                <label for="contraparte-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                <select id="contraparte-municipio-select" name="contraparte-municipio"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                    <option value="0" disabled selected>Seleccione Municipio</option>
                    </select>
            </div>
            <div>
                <label for="contraparte-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                <select id="contraparte-parroquia-select" name="contraparte-parroquia"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                    <option value="0" disabled selected>Seleccione Parroquia</option>
                    </select>
            </div>
        </div>

        <div>
            <label for="contraparte-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
            <input type="text" onkeyup="mayus(this);" id="contraparte-direccion" placeholder="Calle, Edificio, Apartamento/Local"
                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
        </div>
        
    </div>

    <div class="border-b pb-6 space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 bg-blue-50 border-t-2 border-blue-200 p-2 rounded-lg flex flex-wrap justify-between items-center">
            <span>Datos del Apoderado de la Contraparte</span>
            
            <div class="flex items-center space-x-3 mt-2 sm:mt-0"> 
                <input type="checkbox" id="apoderado-contraparte-aplica" onchange="toggleApoderado('apoderado-contraparte')"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="apoderado-contraparte-aplica" class="text-lg font-semibold text-gray-800 flex items-center select-none"> Aplica</label>
            </div>
        </h3>

      
        <div id="apoderado-contraparte-content" class="apoderado-content apoderado-hidden space-y-4">
          <div class="mb-4">
                    <div class="flex items-center space-x-3">
                        <label for="cedula-existente-apo-contra" class="text-sm font-medium text-gray-700 whitespace-nowrap">Buscar Cédula </label>
                        <input type="text"  onkeyup="mayus(this);" class="flex-grow border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 max-w-xs"  name="cedula-existente-apo-contra" min="7" id="cedula-existente-apo-contra" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_contra" class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">Buscar</button>
                    </div>
         </div>
           
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="apo_contraparte-ident-tipo" class="block text-sm font-medium text-gray-700">Tipo de Persona</label>
                        <select id="apo_contraparte-ident-tipo" name="apo_contraparte-ident-tipo" 
                                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out bg-white">
                            <option value="V" selected>V - Venezolano</option>
                            <option value="E">E - Extranjero</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2"> 
                        <label for="contraparte-apoderado-ci" class="block text-sm font-medium text-gray-700">C.I.</label>
                        <input type="text"  onkeypress="return valideKey(event);" id="contraparte-apoderado-ci" placeholder="Ej: 12345678"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="contraparte-apoderado-impre" class="block text-sm font-medium text-gray-700">IMPRE Abogado</label>
                    <input type="text"  onkeyup="mayus(this);" id="contraparte-apoderado-impre" placeholder="Ej: 12345"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="apoderado-contraparte-nombres" class="block text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                <input type="text"  onkeyup="mayus(this);" id="apoderado-contraparte-nombres" placeholder="Ej: Rosa María Gómez"
                class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="apoderado-contraparte-telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" id="apoderado-contraparte-telefono" onkeypress="return valideKey(event);" placeholder="Ej: +58 412 1234567"
                        class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="apoderado-contraparte-correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="flex items-center"> 
                        <input type="email"  onkeyup="mayus(this);" id="apoderado-contraparte-correo" placeholder="ejemplo-contraparte@abogado.com"
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <span class="feedback-icon ml-2"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                    
                <div>
                    <label for="apoderado-contraparte-pais-select" class="block text-sm font-medium text-gray-700">País</label>
                    <select id="apoderado-contraparte-pais-select" name="apoderado-contraparte-pais" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione País</option>
                        </select>
                </div>
                
                <div>
                    <label for="apoderado-contraparte-estado-select" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="apoderado-contraparte-estado-select" name="apoderado-contraparte-estado" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Estado</option>
                        </select>
                </div>

                <div>
                    <label for="apoderado-contraparte-municipio-select" class="block text-sm font-medium text-gray-700">Municipio</label>
                    <select id="apoderado-contraparte-municipio-select" name="apoderado-contraparte-municipio" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Municipio</option>
                        </select>
                </div>
                
                <div>
                    <label for="apoderado-contraparte-parroquia-select" class="block text-sm font-medium text-gray-700">Parroquia</label>
                    <select id="apoderado-contraparte-parroquia-select" name="apoderado-contraparte-parroquia" 
                            class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="0" disabled selected>Seleccione Parroquia</option>
                        </select>
                </div>
            </div>

            <div>
                <label for="apoderado-contraparte-direccion" class="block text-sm font-medium text-gray-700">Dirección Completa</label>
                <input type="text"  onkeyup="mayus(this);" id="apoderado-contraparte-direccion" placeholder="Calle, Edificio, Oficina"
                    class="mt-1 block w-full border border-gray-300 p-2 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>


</div>

</div>

                <div class="siac-section-card siac-mt-3" id="denuncias" style="display: none;">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-exclamation-triangle"></i> Denuncia
                        </h5>
                    </div>
                    <div class="siac-section-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label">A quien afecta el hecho:</label>
                                <div class="siac-radio-group">
                                    <label class="siac-radio-label"><input type="radio" id="option-personal" value="Personal" name="option" class="siac-radio"> Personal</label>
                                    <label class="siac-radio-label"><input type="radio" id="option-comunidad" value="Comunidad" name="option" class="siac-radio"> Comunidad</label>
                                    <label class="siac-radio-label"><input type="radio" id="option-terceros" value="Terceros" name="option" class="siac-radio"> Terceros</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="fecha-hechos">Fecha de los hechos</label>
                                <input class="siac-input" type="date" name="fecha-hechos" id="fecha-hechos" value=" ">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 mb-2">
                                <label class="siac-label" for="denu-involucrados">Indique personas, Organismos o Instituciones, Involucradas en los hechos:</label>
                                <textarea type="text" class="siac-input" onkeyup="mayus(this);" name="denu-involucrados" id="denu-involucrados" required rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="siac-text-muted">EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE:</h6>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="nombre-instancia">Nombre de la instancia del Poder Popular</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="nombre-instancia" id="nombre-instancia" autocomplete="off">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="rif-instancia">Rif:</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="rif-instancia" id="rif-instancia" autocomplete="off">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="ente-financiador">Ente Financiador:</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" value=" " name="ente-financiador" id="ente-financiador" autocomplete="off">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="nombre-proyecto">Nombre del Proyecto:</label>
                                <input type="text" class="siac-input" onkeyup="mayus(this);" name="nombre-proyecto" id="nombre-proyecto" autocomplete="off">
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <label class="siac-label" for="monto-aprovado">Monto Aprobado:</label>
                                <input type="text" class="siac-input" onkeypress="return valideKey(event);" name="monto-aprovado" id="monto-aprovado" onkeypress="noNumeros(event)" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="siac-docs-card">
            <div class="siac-docs-header">
                <h5>
                    <i class="fas fa-file-upload me-2"></i> Documentos Adjuntos
                </h5>
            </div>
            <div class="siac-docs-body">
                <form id="miFormulario" enctype="multipart/form-data" class="mb-4">
                    <label class="siac-label" for="archivo">Seleccionar y Subir Archivo</label>
                    <div class="input-group">
                        <input type="file" class="siac-file-input" id="archivo" name="archivo" aria-describedby="btn_subir_archivos">
                        <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">
                        <button type="button" id="subir_archivos" class="siac-btn-primary">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Subir
                        </button>
                    </div>
                </form>

                <hr>

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="siac-label" for="docu-casos">Documentos del Caso</label>
                    </div>
                    <div class="col-md-5 col-lg-4"> 
                            <select class="siac-select" style="width: 350px;" id="docu-casos" name="docu-casos">
                                <option value="0" selected disabled>Seleccione</option>
                                </select>
                    </div>
                </div>
            </div>
            </div>


    <div class="siac-punto-card siac-mt-3" style="display: none">
        <div class="siac-punto-header">
            <h5>
                <i class="fas fa-file-upload me-2"></i> Punto de Cuenta
            </h5>
        </div>
        <div class="siac-punto-body">
            
            <div class="row">
                
                <div class="col-md-5">
                    <div class="mb-3">
                        
                        <select class="siac-select" id="punto-cuenta-select" name="id_punto_cuenta">
                            <option value="" selected disabled>-- Elija una opción --</option>
                            </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        
                        <select class="siac-select" id="documentos-select" name="docu_ruta" disabled>
                            <option value="" selected disabled>-- Documento no disponible --</option>
                            </select>
                    </div>
                </div>
                
            </div>
            
            
        </div>
    </div>



            
 
                <div class="siac-section-card siac-mt-3 coordenadas" id="map-section">
                    <div class="siac-section-header">
                        <h5>
                            <i class="fas fa-map-pin"></i> Coordenadas de la ubicación
                        </h5>
                    </div>
                    <div class="siac-section-body">
                         <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 mapa_ayuda">
                                <form id="guardar_ayudas" method="POST" role="form">
                                    <div class="modal-body p-0"> 
<link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.css">
                                        <script src="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.js"></script>
                                        <div class="siac-map-wrapper mb-2"> 
                                            <div class="row align-items-end">
                                                <div class="col-lg-3 col-md-6 mb-2">
                                                    <label class="siac-label" for="latitude">Latitud:</label>
                                                    <input type="text" id="latitude" name="latitude" class="siac-input" placeholder="Ej: 10.4806">
                                                </div>
                                                <div class="col-lg-3 col-md-6 mb-2">
                                                    <label class="siac-label" for="longitude">Longitud:</label>
                                                    <input type="text" id="longitude" name="longitude" class="siac-input" placeholder="Ej: -66.9036">
                                                </div>
                                                <div class="col-lg-4 col-md-8 mb-2">
                                                    <label class="siac-label" for="locationName">Nombre del lugar:</label>
                                                    <input type="text" id="locationName" name="locationName" class="siac-input" placeholder="Ej: La Vega, Los Mangos">
                                                </div>
                                                <br>
                                                <div class="col-lg-2 col-md-4 mb-2 d-flex justify-content-end">
                                                     <button id="ubicar-btn" type="button" class="siac-btn-primary mr-1"><i class="fas fa-map-marker-alt"></i></button>
                                                    <button id="limpiar-btn" type="button" class="siac-btn-primary" style="background: #6c757d;"><i class="fas fa-eraser"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="siac-map-container">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="siac-notification siac-mt-3">
                    <h4><i class="fas fa-info-circle"></i> Extensiones Permitidas</h4>
                    <p class="extensions">.jpg, .jpeg, .png, .pdf, .doc, .docx, .ods, .xls, .xlsx, .mp4, .mp3, .m4a, .m4v, .mov, .wmv, .avi, .mkv, .swf, .odt</p>
                    <p class="extensions2">Tamaño Maximo 10MB</p>
                </div>

            </div>
            
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" id="editar_caso" type="button"><i class="fas fa-save"></i> Actualizar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. COMPRESIÓN DEL ESPACIO: Reducción de padding y margin */
    .modal-body {
        padding: 15px; /* Reducido de 20px a 15px */
    }

    .card-section {
        margin-bottom: 15px; /* Reducido de 20px a 15px */
    }

    .card-header {
        padding: 10px 15px; /* Reducido para una cabecera más delgada */
    }

    .card-body {
        padding: 15px; /* Reducido de 20px a 15px */
    }
     .card-casos {
        background-color: white;
        border-bottom: 1px solid #d1d8e1;
        border-radius: 10px 10px 0 0;
        padding: 12px 20px;
    }

    .modal-footer {
        padding: 10px 15px; /* Reducido de 15px 20px */
    }
    
    /* 2. COMPRESIÓN DEL FORMULARIO: Etiquetas y Controles */
    label {
        font-size: 0.85rem; /* Etiquetas un poco más pequeñas */
        font-weight: 600;
        margin-bottom: 0.15rem; /* Reducción de espacio entre etiqueta y control */
    }

    .form-control {
        height: calc(1.5em + .75rem + 2px); /* Altura estándar para controles de formulario */
        padding: .375rem .75rem;
        font-size: 0.9rem; /* Fuente del texto de entrada ligeramente más pequeña */
    }
    
    /* Ajuste específico para inputs de tipo date que suelen tener problemas de altura */
    input[type="date"].form-control {
        height: calc(1.5em + .75rem + 2px); 
        line-height: 1.5; 
    }

    /* 3. MEJORAS VISUALES MENORES */
    #map {
        height: 300px; /* Reducido de 400px a 300px para ahorrar espacio vertical */
        margin-bottom: 0px; 
    }

    .form-container {
        padding: 10px !important; /* Reducido el padding del contenedor del mapa */
        margin-bottom: 10px !important; 
    }

    /* Ajuste para los márgenes inferiores de las columnas de campos (mb-2 en el HTML) */
    .row > [class*="col-"] .mb-2 {
        margin-bottom: 0.5rem !important; /* Uso de la clase mb-2 en el HTML para 0.5rem */
    }

    /* Estilos originales se mantienen para el diseño general */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        background-color: #f7f9fc;
    }
    
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #ffffff;
        border-radius: 12px 12px 0 0;
    }

    .btn-sm {
        /* Para evitar conflictos con btn-xs del datatable, usamos btn-sm, que ya está en el código.
           Asegúrate de que los botones del datatable usen una clase diferente o btn-xs si es necesario, 
           pero no apliques estilos globales a btn-xs aquí. */
        padding: .25rem .5rem; 
        font-size: .875rem;
    }

</style>




        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
<?php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 5) { ?>
  <div class="modal fade" id="remitir_caso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
        
        <div class="modal-header border-0" style="background: linear-gradient(135deg, #002244 0%, #003366 100%); padding: 1.5rem;">
          <h4 class="modal-title font-weight-bold text-white" style="font-size: 1.2rem;">
            <i class="fas fa-paper-plane mr-2 text-info"></i> Remitir Caso
          </h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="caso-remitido" method="POST">
          <input type="hidden" id="idcaso" name="id_caso_remitir" value="">
          
          <div class="modal-body p-4" style="background-color: #f8fafc;">
            <div class="text-center mb-4">
              <div class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-circle mb-3" style="width: 60px; height: 60px; border: 2px dashed #3498db;">
                <i class="fas fa-university fa-lg text-primary"></i>
              </div>
              <p class="text-muted small">Seleccione la unidad administrativa que recibirá el expediente para su gestión.</p>
            </div>

            <div class="form-group mb-2">
              <label for="direcciones_caso" class="font-weight-bold text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                Dirección Administrativa Receptora
              </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-white border-right-0"><i class="fas fa-sitemap text-primary"></i></span>
                </div>
                <select id="direcciones_caso" name="direcciones_caso" class="form-control border-left-0 font-weight-bold" style="height: 45px; color: #003366; border-radius: 0 8px 8px 0;">
                  <?php echo $direcciones; ?>
                </select>
              </div>
            </div>

            <div id="mensaje" class="alert mt-3 border-0 shadow-sm" style="display: none; border-radius: 10px; font-size: 0.85rem;">
                </div>
          
          </div>

          <div class="modal-footer border-0 p-3 bg-white d-flex justify-content-between">
            <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal" style="border-radius: 50px; color: #64748b;">
              Cancelar
            </button>
            
            <button type="submit" class="btn px-4 font-weight-bold shadow-sm" style="background: #003366; color: white; border-radius: 50px; transition: all 0.3s;">
              <i class="fas fa-check-circle mr-1"></i> Confirmar Remisión
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
  </div>
  <!-- /.content -->
</div>


<!-- ***** FUNCION PARA SOLO NUMEROS***-** -->
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
<!-- ***** FUNCION PARA SOLO LETRAS***-** -->
<script>
  function noNumeros(event) {
    const tecla = event.keyCode || event.which;
    if (tecla >= 48 && tecla <= 57) {
      event.preventDefault();
    }
  }
</script>
<!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
<script>
  function mayus(e) {
    e.value = e.value.toUpperCase();
  }
</script>

<script>
        function valideKey(evt) {
    // Permitir solo números
    var code = (evt.which) ? evt.which : evt.keyCode;
    if (code < 48 || code > 57) {
        evt.preventDefault();
    }

    // Limitar a 12 dígitos
    var input = document.getElementById("telefono");
    if (input.value.length >= 12) {
        evt.preventDefault();
    }
}
      </script>



<style>
 /* ======================================================= */
/* CLASES CSS PARA EL EFECTO SLIDE             */
/* ======================================================= */

.apoderado-content {
    /* Define la duración y las propiedades a animar */
    transition: max-height 0.8s ease-out, opacity 0.4s ease-in-out, padding 0.8s ease-out;
    overflow: hidden; 
}

/* ESTADO INICIAL (OCULTO) */
.apoderado-hidden {
    max-height: 0;
    opacity: 0;
    /* !important para asegurar que el max-height: 0 sobrescriba el padding-y que pueda haber */
    padding-top: 0 !important; 
    padding-bottom: 0 !important;
}

/* ESTADO FINAL (VISIBLE) */
.apoderado-visible {
    /* Un valor grande para asegurar que el contenido se vea */
    max-height: 1000px; 
    opacity: 1;
    /* Restablece el padding que fue ocultado en apoderado-hidden */
    padding-top: 1.5rem; /* El valor 1.5rem corresponde a p-6 / 2 */
    padding-bottom: 1.5rem; /* El valor 1.5rem corresponde a p-6 / 2 */
}
</style>

<script>
    /**
     * Limpia todos los campos de entrada (input y select) dentro de un elemento.
     * @param {HTMLElement} container El elemento contenedor cuyos campos serán limpiados.
     */
    function clearFormFields(container) {
        // Limpiar inputs de texto/email
        const textInputs = container.querySelectorAll('input[type="text"], input[type="email"]');
        textInputs.forEach(input => {
            input.value = '';
        });

        // Limpiar selects 
        const selects = container.querySelectorAll('select');
        selects.forEach(select => {
            if (select.options.length > 0) {
                select.value = select.options[0].value; 
            }
        });
    }


    /**
     * Alterna la visibilidad de la sección del apoderado usando clases de Tailwind CSS
     * para transiciones de deslizar y aparecer (max-height).
     * @param {string} prefix El prefijo de los IDs (e.g., 'apoderado-solicitante', 'apoderado-contraparte').
     */
    function toggleApoderado(prefix) {
        if (!prefix) return; 

        const checkbox = document.getElementById(prefix + '-aplica');
        const contentDiv = document.getElementById(prefix + '-content');
        
        if (!checkbox || !contentDiv) return;

        // Asegura la clase base (aunque ya está en el HTML)
        contentDiv.classList.add('apoderado-content');


        if (checkbox.checked) {
            // MOSTRAR: Slide-Down & Fade-In
            
            // 1. Prepara el elemento removiendo la clase de ocultar (max-height: 0)
            contentDiv.classList.remove('apoderado-hidden');
            
            // 2. **Paso CLAVE:** Forzar un reflow. Esto obliga al navegador a recalcular el estilo.
            // Es crucial para que la transición de max-height se ejecute correctamente.
            contentDiv.offsetWidth; 
            
            // 3. Aplica la clase de visualización (activa la transición a max-height: 1000px)
            contentDiv.classList.add('apoderado-visible'); 
            
        } else {
            // OCULTAR: Slide-Up & Fade-Out
            
            // 1. Retira la clase de visualización
            contentDiv.classList.remove('apoderado-visible');
            
            // 2. Aplica la clase de ocultar (activa la transición a max-height: 0)
            contentDiv.classList.add('apoderado-hidden');
            
            // 3. Limpiar campos después de que la transición termine (800ms)
            setTimeout(() => {
                clearFormFields(contentDiv);
            }, 800); 
        }
    }
</script>