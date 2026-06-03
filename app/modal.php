<?php if(file_exists(FCPATH . "css_paginas/casos.css")): ?>
    <link rel="stylesheet" href="<?= base_url("css_paginas/casos.css") ?>">
<?php endif; ?>
<?php 
$session = session(); 
// Colores del sistema desde sesión
$color_card_header = $session->get('color_card_header_sistema') ?: 'linear-gradient(135deg, #1e3a5f 0%, #0d2847 50%, #1363DF 100%)';
$color_letras_cards = $session->get('color_letras_cards_sistema') ?: '#ffffff';
?>

<link rel="stylesheet" href="<?= base_url('/css_paginas/estilo_unificado.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/css_paginas/edicion_casos.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/vistas_premium.css">

<style>
/* Estilos para el modal de edición de caso */
#editCase {
    overflow-y: auto;
    max-height: auto;
}

/* Estilos para los botones en el header del modal */
.modal-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
}

.modal-header-actions .btn {
    display: flex;
    align-items: center;
    padding: 6px 16px;
    font-size: 13px;
    border-radius: 5px;
}

.modal-header-actions .btn i {
    margin-right: 6px;
}

/* ==========================================================================
   ESTILOS: INFORMACIÓN DEL BENEFICIARIO (Estilo Información General - COMPACTO)
   ========================================================================== */
.beneficiario-info-card {
    border: 1px solid #e2e8f0 !important;
    border-top: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    margin-bottom: 15px !important;
}

/* Si el color azul sigue ahí, es porque el header tiene su propio fondo */
.beneficiario-info-card .card-header {
    background: linear-gradient(135deg, rgba(8,59,122,0.95), rgba(19,99,223,0.88));
    color: #fff;
    padding: 10px 16px;
    border-bottom: 1px solid #e2e8f0 !important;
    box-shadow: none !important;
}

.beneficiario-info-card .card-header h5 {
    font-weight: 700;
    font-size: 14px;
    margin: 0;
    letter-spacing: 0.02em;
}

.beneficiario-info-card .card-header h5 i {
    margin-right: 8px;
}

.beneficiario-info-card .card-body {
    padding: 12px;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

/* Grid compacto - 4 columnas */
.beneficiario-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}

@media (max-width: 1200px) {
    .beneficiario-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .beneficiario-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .beneficiario-grid {
        grid-template-columns: 1fr;
    }
}

/* Item individual - COMPACTO en una línea */
.beneficiario-item {
    display: flex;
    align-items: center;
    padding: 6px 10px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
    min-height: 38px;
    position: relative;
}

.beneficiario-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    border-color: #083B7A;
}

/* Icono */
.beneficiario-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 6px;
    flex-shrink: 0;
    font-size: 9px;
}

.beneficiario-icon.fa-user { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
.beneficiario-icon.fa-user-tag { background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; }
.beneficiario-icon.fa-id-card { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; }
.beneficiario-icon.fa-fingerprint { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
.beneficiario-icon.fa-birthday-cake { background: linear-gradient(135deg, #ec4899, #db2777); color: #fff; }
.beneficiario-icon.fa-calendar-alt { background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; }
.beneficiario-icon.fa-calendar { background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; }
.beneficiario-icon.fa-calendar-check { background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; }
.beneficiario-icon.fa-briefcase { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; }
.beneficiario-icon.fa-venus-mars { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; }
.beneficiario-icon.fa-users { background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; }
.beneficiario-icon.fa-address-card { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
.beneficiario-icon.fa-phone { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; }
.beneficiario-icon.fa-envelope { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
.beneficiario-icon.fa-route { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; }
.beneficiario-icon.fa-building { background: linear-gradient(135deg, #64748b, #475569); color: #fff; }
.beneficiario-icon.fa-map-marker-alt { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
.beneficiario-icon.fa-globe { background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; }
.beneficiario-icon.fa-map { background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; }
.beneficiario-icon.fa-landmark { background: linear-gradient(135deg, #a855f7, #9333ea); color: #fff; }
.beneficiario-icon.fa-street-view { background: linear-gradient(135deg, #eab308, #ca8a04); color: #fff; }
.beneficiario-icon.fa-handshake { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; }
.beneficiario-icon.fa-lightbulb { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
.beneficiario-icon.fa-university { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; }
.beneficiario-icon.fa-list-alt { background: linear-gradient(135deg, #06b6d4, #0891b2); color: #fff; }
.beneficiario-icon.fa-clipboard-list { background: linear-gradient(135deg, #64748b, #475569); color: #fff; }
.beneficiario-icon.fa-sitemap { background: linear-gradient(135deg, #14b8a6, #0d9488); color: #fff; }
.beneficiario-icon.fa-gavel { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; }
.beneficiario-icon.fa-check-circle { background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; }

/* Label */
.beneficiario-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 800;
    color: #000000;
    letter-spacing: 0.05em;
    margin-right: 8px;
    white-space: nowrap;
    flex-shrink: 0;
    min-width: 80px;
    max-width: 120px;
    overflow: visible;
}

/* Input - ocupa el resto del espacio */
.beneficiario-input {
    border: none !important;
    background: transparent !important;
    padding: 0 !important;
    font-size: 12px;
    font-weight: 400;
    color: #1f2937;
    box-shadow: none !important;
    outline: none !important;
    width: 100%;
    min-width: 0;
    flex-shrink: 1;
}

.beneficiario-input:focus {
    box-shadow: none !important;
}

.beneficiario-input:disabled {
    color: #1f2937;
    font-weight: 400;
    cursor: not-allowed;
}

/* Select - ocupa el resto del espacio */
.beneficiario-select {
    border: 1px solid #64748b !important;
    background: #f1f5f9 !important;
    padding: 4px 25px 4px 8px !important;
    font-size: 12px;
    font-weight: 400;
    color: #1f2937;
    box-shadow: none !important;
    outline: none !important;
    width: 100%;
    min-width: 0;
    cursor: pointer;
    border-radius: 4px;
    -webkit-appearance: menulist;
    -moz-appearance: menulist;
    appearance: menulist;
}

.beneficiario-select:focus {
    box-shadow: 0 0 0 2px rgba(8, 59, 122, 0.3) !important;
    border-color: #083B7A !important;
    background: #ffffff !important;
}

/* Normalizar opción seleccionada en select */
.beneficiario-select option:checked {
    font-weight: 400 !important;
}

/* Textarea - ocupa el resto del espacio */
.beneficiario-textarea {
    border: 1px solid #64748b !important;
    background: #f1f5f9 !important;
    padding: 8px 10px !important;
    font-size: 12px;
    font-weight: 400;
    color: #1f2937;
    box-shadow: none !important;
    outline: none !important;
    width: 100%;
    min-width: 0;
    border-radius: 4px;
    resize: none;
    flex-shrink: 1;
}

.beneficiario-textarea:focus {
    box-shadow: 0 0 0 2px rgba(8, 59, 122, 0.3) !important;
    border-color: #083B7A !important;
    background: #ffffff !important;
}

/* Campo de tipo de beneficiario ocupa 2 columnas */
.beneficiario-item-full {
    grid-column: span 2;
}

@media (max-width: 576px) {
    .beneficiario-item-full {
        grid-column: span 1;
    }
}

/* Input file dentro de beneficiario-item */
.beneficiario-item input[type="file"] {
    border: 1px solid #64748b !important;
    background: #f1f5f9 !important;
    padding: 4px 8px !important;
    font-size: 12px;
    font-weight: 400;
    color: #1f2937;
    border-radius: 4px;
    width: 100%;
    min-width: 0;
}

.beneficiario-item input[type="file"]:focus {
    box-shadow: 0 0 0 2px rgba(8, 59, 122, 0.3) !important;
    border-color: #083B7A !important;
    background: #fff !important;
    outline: none;
}

/* Input file con estilo personalizado */
.beneficiario-item input[type="file"]::-webkit-file-upload-button {
    background: linear-gradient(135deg, #1e3a5f 0%, #1363DF 100%);
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 600;
    margin-right: 10px;
}

.beneficiario-item input[type="file"]::-webkit-file-upload-button:hover {
    background: linear-gradient(135deg, #1363DF 0%, #1e3a5f 100%);
}

/* Fix para bordes duplicados en tarjetas anidadas - Eliminado - definido arriba */

/* Forzar un solo borde entre tarjetas */
.beneficiario-info-card + .beneficiario-info-card {
    margin-top: 12px;
}

/* Eliminar márgenes extra de tarjetas internas */
.beneficiario-info-card .card-body .card {
    margin: 0;
    border: none;
}

.beneficiario-info-card .card-body .card-header {
    display: none;
}

/* Asegurar que no haya doble borde en el contenido */
.beneficiario-info-card .card-body {
    padding: 12px;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
}
</style>

<script>
$(document).ready(function() {
    // Mover botones junto a "Mostrar registros"
    setTimeout(function() {
        var $lengthDiv = $('.dataTables_wrapper .row:first-child > div:first-child');
        var $buttons = $('.dataTables_wrapper .dt-buttons');
        if ($lengthDiv.length && $buttons.length) {
            $lengthDiv.append($buttons);
        }
    }, 100);
});
</script>


<div class="content-wrapper">
    <div class="table-container-slim">
        
        <div class="card  st-caso-1" >
            <div class="card-header st-caso-2"  style="background: <?= $color_card_header ?>">
                
                <div  class="st-caso-3"></div>
                <div  class="st-caso-4"></div>
                
                <div class="row align-items-center st-caso-5" > 
                    <div class="col-md-6 st-caso-6" >
                        <div  class="st-caso-7">
                            <i class="fas fa-folder-open st-caso-8"  style="color: <?= $color_letras_cards ?>"></i>
                        </div>
                        <div>
                            <h2 class="m-0 st-caso-9"  style="color: <?= $color_letras_cards ?>">
                                <i class="fas fa-angle-double-right mr-2"></i> Pantalla de Casos
                            </h2>
                            <small  class="st-caso-10" style="color: <?= $color_letras_cards ?>">
                                Gestión de Casos
                            </small>
                        </div>
                    </div>

                   <div class="col-md-6 text-right">
                        <button type="button" id="btn_agregar" class="btn btn-acciones">
                            <i class="fas fa-plus-circle mr-2"></i> Agregar Caso
                        </button>
                    </div> 
                </div>
            </div>
        </div>

        <input type="hidden" id="rol_usuario" value="<?= $session->get('id_rol'); ?>">
        <input type="hidden" id="mensaje_documento" value="<?= $mensaje; ?>">

        <div class="card-premium-table">
            <!-- Contenedor para botones de exportación -->
            <div class="dt-buttons mb-3"></div>
            <div class="table-responsive">
                <table class="table table-professional st-caso-11" id="table_casos" >
                <thead>
                    <tr>
                        <th class="text-center st-caso-12" ></th> <!-- Columna vacía para el expansor -->
                        <th class="text-center st-caso-13" >Nº</th>
                        <th class="text-center st-caso-14" >Cédula</th>
                        <th class="text-center st-caso-15" >Beneficiario</th>
                        <th class="text-center st-caso-16" >Teléfono</th>
                        <th class="text-center st-caso-17" >P.Intelectual</th>
                        <th class="text-center st-caso-18" >V.Atención</th>
                        <th class="text-center st-caso-19" >Tipo de Atención</th>
                        <th class="text-center st-caso-20" >Fecha</th>
                        <th class="text-center st-caso-21" >Estatus</th>
                        <th class="text-center st-caso-22" >Operador</th>
                        <th class="text-center st-caso-23" >Acciones</th>
                    </tr>
                </thead>
                <tbody id="listar_casos">
                    </tbody>
            </table>
        </div>
    </div>

    </div>
 </div> 



<div class="modal fade modal-premium" id="editCase">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header st-caso-24" style="border-bottom: none !important; box-shadow: none !important;" >
                <h4 class="modal-title font-weight-bold st-caso-25" >
                    <i class="fas fa-angle-double-right mr-2"></i> EDICION DE CASO
                </h4>
                <div class="modal-header-actions">
                    <button class="btn btn-acciones mr-2" id="editar_caso" type="button"><i class="fas fa-save mr-2"></i> Actualizar</button>
                    <button type="button" class="btn btn-modal-secondary" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i> Cerrar</button>
                </div>
            </div>
            <div class="modal-body">
<input type="hidden" id="id_caso">
                <div class="card beneficiario-info-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-tie"></i> Información del Beneficiario</h5>
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
<div class="card-body">
                        <div class="beneficiario-grid">
                            <!-- Nombre -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Nombre:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="nombre-persona" id="nombre-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <!-- Apellido -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Apellido:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="apellido-persona" id="apellido-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <!-- Tipo Persona -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Tipo:</span>
                                <select class="beneficiario-select" id="tipo-persona" name="tipo-persona">
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                    <option value="J">J</option>
                                    <option value="G">G</option>
                                </select>
                            </div>
                            <!-- Cédula/RIF -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Cédula:</span>
                                <input type="text" class="beneficiario-input" name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
                            </div>
                            <!-- Edad -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Edad:</span>
                                <input type="text" disabled class="beneficiario-input" name="edad" id="edad" onkeypress="return valideKey(event);" autocomplete="off" required>
                            </div>
                            <!-- Fecha de Nacimiento -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Fecha Nac:</span>
                                <input class="beneficiario-input" type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
                            </div>
                            <!-- Profesión -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Profesión:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="profesion" id="profesion" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <!-- Género -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Género:</span>
                                <select class="beneficiario-select" id="sexo" name="sexo">
                                    <option value="1">M</option>
                                    <option value="2">F</option>
                                </select>
                            </div>
                            <!-- Tipo de Beneficiario (ocupa 2 columnas) -->
                            <div class="beneficiario-item beneficiario-item-full">
                                <span class="beneficiario-label">Tipo Beneficiario:</span>
                                <select class="beneficiario-select" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

<div class="card beneficiario-info-card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-id-card"></i> Información de Contacto y Atención</h5>
                    </div>
                    <div class="card-body">
                        <div class="beneficiario-grid">
                            <!-- Teléfono -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Teléfono:</span>
                                <input type="text" class="beneficiario-input" onkeypress="return valideKey(event);" maxlength="12" pattern="\d{12}" title="Debe ingresar exactamente 12 dígitos" name="telefono" id="telefono" autocomplete="off">
                            </div>
                            <!-- Fecha de Recibido -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">F.Recibido:</span>
                                <input class="beneficiario-input" type="date" name="fecha-recibido" id="fecha-recibido" required>
                            </div>
                            <!-- Correo -->
                            <div class="beneficiario-item beneficiario-item-full">
                                <span class="beneficiario-label">Correo:</span>
                                <input type="email" class="beneficiario-input" name="correo" id="correo" autocomplete="off" required>
                            </div>
                            <!-- Vía de Atención -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Vía Atención:</span>
                                <select class="beneficiario-select" name="red-social" id="red-social">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <!-- Atención al Ciudadano -->
                            <div class="beneficiario-item beneficiario-item-full">
                                <span class="beneficiario-label">Atención:</span>
                                <select class="beneficiario-select" name="office" id="office">
                                    <option value="1">Dirección de Atención al Ciudadano</option>
                                    <option value="2">Coordinador Estadal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            
<div class="card beneficiario-info-card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-map-marked-alt"></i> Ubicación</h5>
                    </div>
                    <div class="card-body">
                        <div class="beneficiario-grid">
                            <!-- Dirección (ocupa todo el ancho) -->
                            <div class="beneficiario-item beneficiario-item-full" style="display: none;">
                                <span class="beneficiario-label">Dirección:</span>
                                <input type="text" class="beneficiario-input" name="direccion" id="direccion" autocomplete="off">
                            </div>
                            <!-- País -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">País:</span>
                                <select class="beneficiario-select" id="pais-caso" name="pais-caso">
                                    <option value="1" selected>Venezuela</option>
                                </select>
                            </div>
                            <!-- Estado -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Estado:</span>
                                <select class="beneficiario-select" id="estado-caso" name="estado-caso">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <!-- Municipio -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Municipio:</span>
                                <select class="beneficiario-select" id="municipio-caso" name="municipio-caso">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>
                            <!-- Parroquia -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Parroquia:</span>
                                <select class="beneficiario-select" id="parroquia-caso" name="parroquia-caso">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

<div class="card beneficiario-info-card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Detalles del Caso</h5>
                    </div>
                    <div class="card-body">
                        <div class="beneficiario-grid">
                            <!-- Tipo de Atención -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Tipo Atención:</span>
                                <select class="beneficiario-select" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <!-- Área -->
                            <div class="beneficiario-item prop_int oculto">
                                <span class="beneficiario-label">Área:</span>
                                <select disabled class="beneficiario-select" id="tipo-pi" name="tipo-pi">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <!-- Organismo del Poder Popular -->
                            <div class="beneficiario-item org_pp">
                                <span class="beneficiario-label">Organismo:</span>
                                <select class="beneficiario-select" id="organismo-caso" name="organismo-caso">
                                    <option value="0">Seleccione</option>
                                </select>
                            </div>
                            <!-- Detalle Atención -->
                            <div class="beneficiario-item detalle_atencion oculto">
                                <span class="beneficiario-label">Detalle:</span>
                                <select disabled class="beneficiario-select" id="edit_detelle_atencion" name="detalles_atencion">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <!-- Descripción del Caso -->
                        <div class="beneficiario-item beneficiario-item-full mt-2" style="min-height: 60px;">
                            <span class="beneficiario-label">Descripción:</span>
                            <textarea type="text" class="beneficiario-textarea" name="requerimiento-usuario" id="requerimiento-usuario" required rows="2"></textarea>
                        </div>
                        <input type="hidden" class="form-control" name="hijos_tipoatencion" id="hijos_tipoatencion" autocomplete="off">
                    </div>
                </div>

<div class="card beneficiario-info-card mt-3" id="cgr">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-question-circle"></i> Asesoría</h5>
                    </div>
                    <div class="card-body">
                        <div class="beneficiario-grid">
                            <!-- Ente adscrito -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Ente:</span>
                                <select class="beneficiario-select" id="ente_adscrito_id" name="competencia-cgr">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <!-- Competencia de CGR -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Competencia:</span>
                                <select class="beneficiario-select" id="competencia-cgr" name="competencia-cgr">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <!-- Asume CGR -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Asume:</span>
                                <select class="beneficiario-select" id="asume-cgr" name="asume-cgr">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /*Contenido de Mediacion -->
        <div class="row st-caso-30" id="mediacion" >

<div class="card beneficiario-info-card mt-2">
    <div class="card-header" style="padding: 8px 12px;">
        <h5 class="mb-0"><i class="fas fa-user-tie mr-2"></i> Datos del Apoderado del Solicitante</h5>
        <div class="toggle-container" style="position: absolute; right: 40px; top: 6px;">
            <div class="toggle-content">
<label class="toggle-label" for="apoderado-solicitante-aplica" style="color: <?= $color_letras_cards ?>;">Aplica</label>
                <label class="toggle-switch">
                    <input type="checkbox" id="apoderado-solicitante-aplica" onchange="toggleApoderado('apoderado-solicitante')">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding: 10px;">
        <div id="apoderado-solicitante-content" class="apoderado-content apodero-hidden">
            <!-- Fila 1: Identificación -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">BUSCAR C.I.:</span>
                    <div style="display: flex; gap: 4px; flex: 1;">
                        <input type="text" onkeyup="mayus(this);" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;" name="cedula-existente" id="cedula-existente-apo-sol" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_sol" class="btn btn-primary btn-sm" style="padding: 2px 8px; font-size: 10px;">Buscar</button>
                    </div>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 40px; font-size: 10px;">TIPO:</span>
                    <select id="apo_solicitente-ident-tipo" name="apo_solicitente-ident-tipo" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="V" selected>V</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 30px; font-size: 10px;">C.I.:</span>
                    <input type="text" onkeypress="return valideKey(event);" id="apoderado-solicitante-ci" placeholder="12345678" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 40px; font-size: 10px;">IMPRE:</span>
                    <input type="text" onkeyup="mayus(this);" id="apoderado-solicitante-impre" placeholder="N/A" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
            </div>
            <!-- Fila 2: Nombre, Teléfono, Ubicación -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item beneficiario-item-full" style="min-height: 34px; padding: 4px 8px; grid-column: span 2;">
                    <span class="beneficiario-label" style="min-width: 130px; font-size: 10px;">NOMBRES Y APELLIDOS:</span>
                    <input type="text" onkeyup="mayus(this);" id="apoderado-solicitante-nombres" placeholder="FREDDY TORRES" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 65px; font-size: 10px;">TELÉFONO:</span>
                    <input type="text" id="apoderado-solicitante-telefono" onkeypress="return valideKey(event);" placeholder="04143995654" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 35px; font-size: 10px;">PAÍS:</span>
                    <select id="apoderado-solicitante-pais-select" name="apoderado-solicitante-pais" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="Venezuela" selected>Venezuela</option>
                    </select>
                </div>
            </div>
            <!-- Fila 3: Estado, Municipio, Parrqoia -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 50px; font-size: 10px;">ESTADO:</span>
                    <select id="apoderado-solicitante-estado-select" name="apoderado-solicitante-estado" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="Anzoátegui" selected>Anzoátegui</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">MUNICIPIO:</span>
                    <select id="apoderado-solicitante-municipio-select" name="apoderado-solicitante-municipio" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="Anaco" selected>Anaco</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">PARROQUIA:</span>
                    <select id="apoderado-solicitante-parroquia-select" name="apoderado-solicitante-parroquia" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="Anaco" selected>Anaco</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 55px; font-size: 10px;">CORREO:</span>
                    <input type="email" onkeyup="mayus(this);" id="apoderado-solicitante-correo" placeholder="EMAIL" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
            </div>
            <!-- Fila 4: Dirección -->
            <div class="beneficiario-item beneficiario-item-full" style="min-height: 34px; padding: 4px 8px;">
                <span class="beneficiario-label" style="min-width: 75px; font-size: 10px;">DIRECCIÓN:</span>
                <input type="text" id="apoderado-solicitante-direccion" onkeyup="mayus(this);" placeholder="LOS MANGOS" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
            </div>
        </div>
    </div>
</div>

<div class="card beneficiario-info-card mt-2">
    <div class="card-header" style="padding: 8px 12px;">
        <h5 class="mb-0"><i class="fas fa-user-friends"></i> Datos de la Contraparte</h5>
    </div>
    <div class="card-body" style="padding: 10px;">
        <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 75px; font-size: 10px; margin-bottom: 0;">BUSCAR C.I.:</span>
                <div style="display: flex; gap: 4px; flex: 1;">
                    <input type="text" onkeyup="mayus(this);" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; width: 100%;" name="cedula-existente-contra" id="cedula-existente-contra" autocomplete="off">
                    <button type="button" id="btn_buscar_contra" class="btn btn-primary btn-sm" style="padding: 2px 8px; font-size: 10px;"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 35px; font-size: 10px; margin-bottom: 0;">TIPO:</span>
                <select id="contraparte-ident-tipo" name="contraparte-ident-tipo" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px; flex: 1;">
                    <option value="V" selected>V</option>
                    <option value="E">E</option>
                    <option value="J">J</option>
                    <option value="G">G</option>
                </select>
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; grid-column: span 2; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 90px; font-size: 10px; margin-bottom: 0;">IDENTIFICACIÓN:</span>
                <input type="text" onkeyup="mayus(this);" id="contraparte-ident-valor" placeholder="12345678" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; flex: 1;">
            </div>
        </div>

        <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; grid-column: span 2; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 135px; font-size: 10px; margin-bottom: 0;">NOMBRE / RAZÓN SOCIAL:</span>
                <input type="text" onkeyup="mayus(this);" id="contraparte-nombre-razon" placeholder="JUAN PÉREZ O EMPRESA C.A." class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; flex: 1;">
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 60px; font-size: 10px; margin-bottom: 0;">TELÉFONO:</span>
                <input type="text" id="contraparte-telefono" onkeypress="return valideKey(event);" placeholder="04121234567" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; flex: 1;">
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 35px; font-size: 10px; margin-bottom: 0;">PAÍS:</span>
                <select id="contraparte-pais-select" name="contraparte-pais" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px; flex: 1;">
                    <option value="0" disabled selected>PAÍS</option>
                </select>
            </div>
        </div>

        <div class="beneficiario-grid" style="grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 8px;">
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 50px; font-size: 10px; margin-bottom: 0;">ESTADO:</span>
                <select id="contraparte-estado-select" name="contraparte-estado" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px; flex: 1;">
                    <option value="0" disabled selected>Seleccione</option>
                </select>
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 65px; font-size: 10px; margin-bottom: 0;">MUNICIPIO:</span>
                <select id="contraparte-municipio-select" name="contraparte-municipio" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px; flex: 1;">
                    <option value="0" disabled selected>Seleccione</option>
                </select>
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 65px; font-size: 10px; margin-bottom: 0;">PARROQUIA:</span>
                <select id="contraparte-parroquia-select" name="contraparte-parroquia" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px; flex: 1;">
                    <option value="0" disabled selected>Seleccione</option>
                </select>
            </div>
        </div>

        <div class="beneficiario-grid" style="grid-template-columns: repeat(3, 1fr); gap: 8px;">
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; grid-column: span 2; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 75px; font-size: 10px; margin-bottom: 0;">DIRECCIÓN:</span>
                <input type="text" onkeyup="mayus(this);" id="contraparte-direccion" placeholder="CALLE, EDIFICIO, LOCAL" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; flex: 1;">
            </div>
            <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; display: flex; align-items: center; gap: 5px;">
                <span class="beneficiario-label" style="min-width: 50px; font-size: 10px; margin-bottom: 0;">CORREO:</span>
                <input type="email" onkeyup="mayus(this);" id="contraparte-correo" placeholder="EMAIL" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px; flex: 1;">
            </div>
        </div>
    </div>
</div>

<div class="card beneficiario-info-card mt-2">
    <div class="card-header" style="padding: 8px 12px;">
        <h5 class="mb-0"><i class="fas fa-briefcase mr-2"></i> Datos del Apoderado de la Contraparte</h5>
        <div class="toggle-container" style="position: absolute; right: 40px; top: 6px;">
            <div class="toggle-content">
<label class="toggle-label" for="apoderado-contraparte-aplica" style="color: <?= $color_letras_cards ?>;">Aplica</label>
                <label class="toggle-switch">
                    <input type="checkbox" id="apoderado-contraparte-aplica" onchange="toggleApoderado('apoderado-contraparte')">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding: 10px;">
        <div id="apoderado-contraparte-content" class="apoderado-content apodero-hidden">
            <!-- Fila 1: Identificación -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">BUSCAR C.I.:</span>
                    <div style="display: flex; gap: 4px; flex: 1;">
                        <input type="text" onkeyup="mayus(this);" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;" name="cedula-existente-apo-contra" id="cedula-existente-apo-contra" autocomplete="off">
                        <button type="button" id="btn_buscar_apo_contra" class="btn btn-primary btn-sm" style="padding: 2px 8px; font-size: 10px;"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 40px; font-size: 10px;">TIPO:</span>
                    <select id="apo_contraparte-ident-tipo" name="apo_contraparte-ident-tipo" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="V" selected>V</option>
                        <option value="E">E</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 30px; font-size: 10px;">C.I.:</span>
                    <input type="text" onkeypress="return valideKey(event);" id="contraparte-apoderado-ci" placeholder="12345678" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 40px; font-size: 10px;">IMPRE:</span>
                    <input type="text" onkeyup="mayus(this);" id="contraparte-apoderado-impre" placeholder="12345" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
            </div>
            <!-- Fila 2: Nombre y Teléfono -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px; grid-column: span 2;">
                    <span class="beneficiario-label" style="min-width: 130px; font-size: 10px;">NOMBRES Y APELLIDOS:</span>
                    <input type="text" onkeyup="mayus(this);" id="apoderado-contraparte-nombres" placeholder="ROSA MARÍA GÓMEZ" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 65px; font-size: 10px;">TELÉFONO:</span>
                    <input type="text" id="apoderado-contraparte-telefono" onkeypress="return valideKey(event);" placeholder="+58 412 1234567" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 35px; font-size: 10px;">PAÍS:</span>
                    <select id="apoderado-contraparte-pais-select" name="apoderado-contraparte-pais" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="0" disabled selected>Seleccione</option>
                    </select>
                </div>
            </div>
            <!-- Fila 3: Estado, Municipio, Parrqoia -->
            <div class="beneficiario-grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 50px; font-size: 10px;">ESTADO:</span>
                    <select id="apoderado-contraparte-estado-select" name="apoderado-contraparte-estado" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="0" disabled selected>Seleccione</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">MUNICIPIO:</span>
                    <select id="apoderado-contraparte-municipio-select" name="apoderado-contraparte-municipio" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="0" disabled selected>Seleccione</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 70px; font-size: 10px;">PARROQUIA:</span>
                    <select id="apoderado-contraparte-parroquia-select" name="apoderado-contraparte-parroquia" class="beneficiario-select" style="font-size: 11px; padding: 2px 6px;">
                        <option value="0" disabled selected>Seleccione</option>
                    </select>
                </div>
                <div class="beneficiario-item" style="min-height: 34px; padding: 4px 8px;">
                    <span class="beneficiario-label" style="min-width: 50px; font-size: 10px;">CORREO:</span>
                    <input type="email" onkeyup="mayus(this);" id="apoderado-contraparte-correo" placeholder="EMAIL" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
                </div>
            </div>
            <!-- Fila 4: Dirección -->
            <div class="beneficiario-item beneficiario-item-full" style="min-height: 34px; padding: 4px 8px;">
                <span class="beneficiario-label" style="min-width: 75px; font-size: 10px;">DIRECCIÓN:</span>
                <input type="text" onkeyup="mayus(this);" id="apoderado-contraparte-direccion" placeholder="CALLE, EDIFICIO, OFICINA" class="beneficiario-input" style="font-size: 11px; padding: 2px 6px;">
            </div>
        </div>
    </div>
</div>


</div>

</div>

                <div class="card beneficiario-info-card mt-3 st-caso-31" id="denuncias" >
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Denuncia</h5>
                    </div>
                    <div class="card-body">
                        <!-- Fila 1: Afecta a + Fecha -->
                        <div class="beneficiario-grid">
                            <!-- A quien afecta el hecho - ocupa 3 columnas -->
                            <div class="beneficiario-item" style="grid-column: span 3; min-height: 50px;">
                                <span class="beneficiario-label">Afecta a:</span>
                                <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                                    <label style="display: flex; align-items: center; gap: 5px; margin: 0; cursor: pointer;">
                                        <input type="radio" id="option-personal" value="Personal" name="option" style="margin: 0;">
                                        <span style="font-size: 12px; font-weight: 500;">Personal</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px; margin: 0; cursor: pointer;">
                                        <input type="radio" id="option-comunidad" value="Comunidad" name="option" style="margin: 0;">
                                        <span style="font-size: 12px; font-weight: 500;">Comunidad</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px; margin: 0; cursor: pointer;">
                                        <input type="radio" id="option-terceros" value="Terceros" name="option" style="margin: 0;">
                                        <span style="font-size: 12px; font-weight: 500;">Terceros</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Fecha de los hechos -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Fecha Hechos:</span>
                                <input class="beneficiario-input" type="date" name="fecha-hechos" id="fecha-hechos">
                            </div>
                        </div>

                        <!-- Título Involucrados -->
                        <div class="beneficiario-item beneficiario-item-full mt-2" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 45px; justify-content: center; border: 1px dashed #083B7A;">
                            <span class="beneficiario-label" style="color: #1e3a5f; font-size: 11px; max-width: none;">Indique personas, Organismos o Instituciones, Involucradas en los hechos:</span>
                        </div>

                        <!-- Campo de texto Involucrados -->
                        <div class="beneficiario-item beneficiario-item-full mt-2" style="min-height: 70px;">
                            <textarea type="text" class="beneficiario-textarea" onkeyup="mayus(this);" name="denu-involucrados" id="denu-involucrados" required rows="2"></textarea>
                        </div>

                        <!-- Título para instancia del poder popular -->
                        <div class="beneficiario-item beneficiario-item-full mt-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 45px; justify-content: center; border: 1px dashed #083B7A;">
                            <span class="beneficiario-label" style="color: #1e3a5f; font-size: 11px; max-width: none;">EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE:</span>
                        </div>

                        <!-- Fila 2: Instancia, RIF, Ente, Proyecto, Monto -->
                        <div class="beneficiario-grid mt-2">
                            <!-- Nombre de la instancia -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Instancia:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="nombre-instancia" id="nombre-instancia" autocomplete="off" placeholder="Nombre">
                            </div>

                            <!-- Rif -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">RIF:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="rif-instancia" id="rif-instancia" autocomplete="off" placeholder="J-00000000-0">
                            </div>

                            <!-- Ente Financiador -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Ente Financ.:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="ente-financiador" id="ente-financiador" autocomplete="off" placeholder="Ente">
                            </div>

                            <!-- Nombre del Proyecto -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Proyecto:</span>
                                <input type="text" class="beneficiario-input" onkeyup="mayus(this);" name="nombre-proyecto" id="nombre-proyecto" autocomplete="off" placeholder="Nombre">
                            </div>

                            <!-- Monto Aprobado -->
                            <div class="beneficiario-item">
                                <span class="beneficiario-label">Monto:</span>
                                <input type="text" class="beneficiario-input" onkeypress="return valideKey(event);" name="monto-aprovado" id="monto-aprovado" autocomplete="off" placeholder="0,00">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="card beneficiario-info-card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i> Documentos Adjuntos</h5>
            </div>
            <div class="card-body">
                <!-- Formulario de subida de archivo -->
                <div class="beneficiario-grid">
                    <div class="beneficiario-item" style="grid-column: span 3; min-height: 50px;">
                        <span class="beneficiario-label" style="max-width: 120px;">Subir Archivo:</span>
                        <form id="miFormulario" enctype="multipart/form-data" style="display: flex; align-items: center; width: 100%; gap: 10px;">
<input type="file" class="beneficiario-input" style="flex: 1; border: 1px solid #64748b; background: #f1f5f9; padding: 4px 8px; border-radius: 4px;" id="archivo" name="archivo" aria-describedby="btn_subir_archivos">
                            <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">
                            <button type="button" id="subir_archivos" class="btn btn-acciones">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Subir
                            </button>
                        </form>
                    </div>
                </div>

                <hr style="margin: 15px 0;">

                <!-- Selector de documentos del caso -->
                <div class="beneficiario-item" style="max-width: 100%;">
                    <span class="beneficiario-label" style="max-width: 150px;">Documentos del Caso:</span>
                    <select class="beneficiario-select" id="docu-casos" name="docu-casos" style="flex: 1; max-width: 400px;">
                        <option value="0" selected disabled>Seleccione</option>
                    </select>
                </div>
            </div>
            </div>


    <div class="card mt-3 shadow-xs punto   st-caso-33">
        <div class="card-header bg-primary text-white modal-header" style="border-bottom: none !important; box-shadow: none !important;">
            <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i> Punto de Cuenta</h5>
        </div>
        <div class="card-body">
            
            <div class="row">
                
                <div class="col-md-5">
                    <div class="mb-3">
                        
                        <select class="compact-form-control border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-300" id="punto-cuenta-select" name="id_punto_cuenta">
                            <option value="" selected disabled>-- Elija una opción --</option>
                            </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        
                        <select class="compact-form-control border border-gray-300 rounded-lg focus:ring-1 focus:ring-gray-300" id="documentos-select" name="docu_ruta" disabled>
                            <option value="" selected disabled>-- Documento no disponible --</option>
                            </select>
                    </div>
                </div>
                
            </div>
            
            
        </div>
    </div>



            
 
                <div class="card card-section mt-3 coordenadas" id="map-section">
                    <div class="card-header modal-header mb-0 text-primary" style="border-bottom: none !important; box-shadow: none !important;">
                        <h5 class="mb-0"><i class="fas fa-map-pin"></i> Coordenadas de la ubicación</h5>
                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 mapa_ayuda">
                                <form id="guardar_ayudas" method="POST" role="form">
                                    <div class="modal-body p-0"> 
<link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.css" />
                                        <script src="<?php echo base_url(); ?>/theme/plugins/leaflet/dist/leaflet.js"></script>
                                        <div class="form-container mb-2 p-2"> 
                                            <div class="row align-items-end">
                                                <div class="col-lg-3 col-md-6 mb-2">
                                                    <label for="latitude">Latitud:</label>
                                                    <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Ej: 10.4806">
                                                </div>
                                                <div class="col-lg-3 col-md-6 mb-2">
                                                    <label for="longitude">Longitud:</label>
                                                    <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Ej: -66.9036">
                                                </div>
                                                <div class="col-lg-4 col-md-8 mb-2">
                                                    <label for="locationName">Nombre del lugar:</label>
                                                    <input type="text" id="locationName" name="locationName" class="form-control" placeholder="Ej: La Vega, Los Mangos">
                                                </div>
                                                <br>
                                                <div class="col-lg-2 col-md-4 mb-2 d-flex justify-content-end">
                                                     <button id="ubicar-btn" type="button" class="btn btn-sm btn-primary mr-1"><i class="fas fa-map-marker-alt"></i></button>
                                                    <button id="limpiar-btn" type="button" class="btn btn-sm btn-secondary"><i class="fas fa-eraser"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='map'  class="st-caso-34"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="notification-card mt-3 modal-header" style="border-bottom: none !important; box-shadow: none !important;">
                    <h4 class="extensions">Extensiones Permitidas</h4>
                    <p class="extensions">.jpg, .jpeg, .png, .pdf, .doc, .docx, .ods, .xls, .xlsx, .mp4, .mp3, .m4a, .m4v, .mov, .wmv, .avi, .mkv, .swf, .odt</p>
                    <p class="extensions2">Tamaño Maximo 10MB</p>
                </div>

            </div>
            
        </div>
    </div>
</div>



    <!--/.Remitir caso-->
    <?php if ($session->get('id_rol') == 1 or $session->get('id_rol') == 3 or $session->get('id_rol') == 5) { ?>
      <div class="modal fade modal-premium" id="remitir_caso">
        <div class="modal-dialog  modal-dialog-centered modal-md">
          <div class="modal-content">
            <form id="caso-remitido" method="POST">
              <div class="modal-header st-caso-35" style="border-bottom: none !important; box-shadow: none !important;" >
                <h4 class="modal-title font-weight-bold st-caso-36" ><i class="fas fa-share mr-2"></i> Remitir Caso</h4>
                <input type="hidden" id="idcaso" name="" value="">
                <button type="button" class="close st-caso-37" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="direcciones_caso">Direcciones administrativas</label>
                  <select id="direcciones_caso" name="direcciones_caso" class="form-control shadow-sm">
                    <?php echo $direcciones; ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="reset" class="btn btn-modal-secondary" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i> Cerrar</button>
                <button type="submit"class="btn btn-acciones"><i class="fas fa-save mr-2"></i> Guardar</button>
                <label id="mensaje"  class="st-caso-38">Espere un momento, esta ventana se cerrará automáticamente</label>
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