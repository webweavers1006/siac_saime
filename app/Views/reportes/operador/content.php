<?php
$session = session();
?>

<div class="content-wrapper">

<style>
    /* Estilos existentes para la tabla */
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
    
    /* ⭐ ESTILOS COMPACTOS Y GENERALES ⭐ */
    
    /* Controles de formulario (input, select) */
    .compact-form-control {
        height: calc(1.9rem + 2px) !important; 
        padding: .25rem .5rem !important;     
        font-size: .875rem !important;        
        width: 100% !important; 
    }
    
    /* Etiquetas (Label): Optimizado para compacidad vertical */
    .card-body label {
        font-size: 0.85rem; /* Ligeramente más pequeño para ahorrar espacio */
        margin-bottom: .1rem !important; /* Margen muy reducido para pegar al input */
        display: block; 
        font-weight: 500; /* Hace que la etiqueta sea más visible */
    }
    
    /* Inputs de Edad */
    .compact-input-edad {
        width: 65px !important; 
        height: calc(1.9rem + 2px) !important;
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        display: inline-block;
        text-align: center; /* Centrar texto/números */
    }
    
    /* Ajuste de padding en columnas (evita el corte de texto en filas) */
    .row > [class*="col-"] { /* Se simplificó el selector, aplica a todas las filas */
        padding-right: 5px; 
        padding-left: 5px;
    }
    
    /* Ajuste específico para el select de Analistas (si se usa fuera de col-*) */
    .custom-select-compact {
        height: calc(1.9rem + 2px) !important; 
        padding: .25rem 1.75rem .25rem .75rem !important; 
        font-size: .875rem !important;
        width: 300px !important;
        display: inline-block !important;
        vertical-align: middle;
    }

    /* --- ESTILOS DATATABLES (Búsqueda y Botones) --- */
    
    /* 1. Reducir y alinear el campo de búsqueda (Search) de DataTables */
    div.dataTables_wrapper div.dataTables_filter input {
        height: calc(1.9rem + 2px) !important; 
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        max-width: 200px; /* Limita el ancho del campo */
        display: inline-block;
    }

    /* 2. Compactar y alinear los botones de exportación (btn-xs-xs) */
    div.dt-buttons .btn {
        padding: 0.1rem 0.3rem !important; /* Relleno ultra-compacto */
        font-size: 0.75rem !important;      /* Fuente muy pequeña */
        line-height: 1.5 !important;
        margin-right: 5px !important;    /* Espacio entre botones */
    }

    /* 3. Alinear verticalmente el contenedor de botones y el filtro de búsqueda */
    div.dataTables_wrapper div.row:first-child {
        align-items: center; /* Alineación vertical central */
    }
</style>
  
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card card-outline card-primary">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-primary align-self-center"><i class="fas fa-user-tie mr-2"></i> Reporte por Analistas 
                                <select class="custom-select custom-select-compact" id="usuarios" name="usuarios">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $usuarios; ?>
                                </select>
                              </h3>    
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2 mb-2">
                                <label for="desde">Desde</label>
                                <input type="date" class="form-control compact-form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label for="hasta">Hasta</label>
                                <input type="date" class="form-control compact-form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label for="sexo">Género</label>
                                <select class="form-control compact-form-control" id="sexo" name="sexo">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 mb-2">
                                <label for="tipo-pi">Tipo de Propiedad Intelectual</label>
                                <select class="form-control compact-form-control" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 mb-2">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="form-control compact-form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3 border-top pt-3">
                            <div class="form-group col-md-2 mb-2">
                                <label for="via-atencion">Vía de Atención</label>
                                <select class="form-control compact-form-control" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label for="tipo-atencion-usu">Tipo de Atención</label>
                                <select class="form-control compact-form-control" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            
                        <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                                <label for="direcciones_caso">Dirección Administrativa:</label>
                                <select class="form-control compact-form-control" id="direcciones_caso" name="direcciones_caso">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $direcciones; ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                                <label for="pais-caso">País</label>
                                <select id="pais-caso"  name=" pais-caso" class="form-control compact-form-control">
                                <option value="1" selected >Venezuela</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                            <label for="estado-caso">Estado</label>
                            <select id="estado-caso" name="estado-caso" class="form-control compact-form-control">
                                <option value="0" disabled>Seleccione Estado</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                            <label for="municipio-caso">Municipio</label>
                            <select id="municipio-caso" name="municipio-caso" class="form-control compact-form-control">
                            <option value="0" selected >Seleccione Municipio</option>
                            </select>
                        </div>
                        <div class="col-4 mb-2">
                            <label for="parroquia-caso">Parroquia</label>
                            <select id="parroquia-caso" name="parroquia-caso" class="form-control compact-form-control">
                            <option value="0">Seleccione Parroquia</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                                <label for="estatus">Estatus:</label>
                                <select class="form-control compact-form-control" id="estatus" name="estatus">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">Abierto</option>
                                    <option value="2">Cerrado</option>
                                </select>
                            </div>


                            <div class="col-lg-4 col-sm-4 col-md-4 org_pp mb-2">
                            <label for="organismo-caso">Organismo del Poder Poular</label>
                            <select id="organismo-caso" name="organismo-caso" class="form-control compact-form-control">
                            <option value="0">Seleccione Organismo</option>
                            </select>
                        </div>
                        
                        </div> <div class="row mt-3 border-top pt-3">
                            <div class="col-md-9">
                                <div class="d-flex align-items-center">
                                    <label for="estado-caso" class="pr-3 mb-0">Edad-> </label>
                                    
                                    <label for="edad_min" class="mb-0">Desde:</label>
                                    <input type="number" class="compact-input-edad mr-2" id="edad_min" min="0" name="edad_min">
                                    
                                    <label for="edad_max" class="mb-0">Hasta:</label>                                
                                    <input type="number" class="compact-input-edad" id="edad_max" min="0" name="edad_max">
                                </div>
                            </div>

                            <div class="col-md-3 text-md-right">
                                <button type="button" class="btn btn-sm btn-primary consultar mr-2"><i class="fas fa-search mr-1"></i> Consultar</button>
                                 <button type="button" class="btn btn-sm btn-secondary limpiar"><i class="fas fa-eraser mr-1"></i> Limpiar</button>
                            </div>
                        </div> </div>
                </div>
            </div>
        </div>
  

             
       
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">
            <div class="card-body">
              <table class="display table-responsive table-striped table-hover" id="table_casos" style="width:100%" style="margin-top: 20px">
                <thead>
                  <tr>
                    <td class="text-center" style="width: 1%;">N-Caso</td>
                    <td class="text-center" style="width: 1%;">Cédula</td>
                    <td class="text-center" style="width: 1%;">Tipo de Beneficiario</td>
                    <td class="text-center" style="width: 12%;">Beneficiario</td>
                    <td class="text-center" style="width: 3%;">Teléfono</td>
                    <td class="text-center" style="width: 6%;">Propiedad Intelectual</td>
                    <td class="text-center" style="width: 4%;">Tipo de Atención</td>
                    <td class="text-center" style="width: 1%;">Fecha</td>
                    <td class="text-center" style="width: 1%;">Estatus</td>
                    <td class="text-center" style="width: 12%;">Dirección Remitida</td>
                    <td class="text-center" style="width: 5%;">Operador</td>
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