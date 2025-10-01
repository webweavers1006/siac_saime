<div class="content-wrapper">
 
  <style>
    /* Estilos existentes para la tabla */
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
    
    /* ⭐ ESTILOS AGREGADOS/AJUSTADOS: Hacen los campos más compactos y visibles ⭐ */
    .compact-form-control {
        height: calc(1.9rem + 2px) !important; /* Ligeramente más alto */
        padding: .25rem .5rem !important;     
        font-size: .875rem !important;        
        width: 100% !important; /* Asegura que el select use todo el espacio de la columna */
    }
    .card-body label {
        font-size: 0.9rem;
        margin-bottom: .15rem; /* Margen inferior muy reducido */
        display: block; /* Asegura que la etiqueta use su propia línea */
    }
    .compact-input-edad {
        width: 65px !important; 
        height: calc(1.9rem + 2px) !important;
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        display: inline-block;
    }
    /* Ajuste específico para evitar el corte en las columnas col-md-2 */
    .row > [class*="col-"] {
        padding-right: 5px; /* Reduce el padding entre columnas */
        padding-left: 5px;
    }
    
    /* Reduce el tamaño del campo de texto de BÚSQUEDA (Search) de DataTables */
div.dataTables_wrapper div.dataTables_filter input {
    /* 1. Reduce la altura del campo */
    height: calc(1.9rem + 2px) !important; 
    /* 2. Hace el texto y el relleno más compactos */
    padding: .25rem .5rem !important;
    font-size: .875rem !important;
    /* 3. Opcional: Limita el ancho máximo para que no ocupe demasiado */
    max-width: 200px; 
    display: inline-block; /* Asegura el correcto flujo */
}

/* Opcional: Alinea verticalmente la etiqueta "Search:" y el campo */
div.dataTables_wrapper div.dataTables_filter label {
    font-size: 0.9rem;
}
  </style>
  
  <div class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card card-outline card-primary">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-primary"><i class="fas fa-filter mr-2"></i> **Filtros de Consolidado de Casos** </h3>
                           
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control compact-form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="hasta">Hasta:</label>
                                <input type="date" class="form-control compact-form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="sexo">Género:</label>
                                <select class="form-control compact-form-control" id="sexo" name="sexo">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="form-control compact-form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="via-atencion">Via de Atención:</label>
                                <select class="form-control compact-form-control" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>

                           
                            <div class="col-md-2 mb-2">
                                <label for="tipo-atencion-usu">Tipo de Atención:</label>
                                <select class="form-control compact-form-control" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-2 detalle_atencion" style="display: none;">
                                <label for="edit_detelle_atencion">Detalle Atencion</label>
                                <select class="form-control compact-form-control" id="edit_detelle_atencion" name="detalles_atencion">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mt-3 border-top pt-3">
                            <div class="col-lg-4 col-sm-4 col-md-4 mb-2">
                                <label for="tipo-pi">Tipo de Propiedad Intelectual:</label>
                                <select class="form-control compact-form-control" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>seleccione</option>
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
                        <div class="col-lg-4 col-sm-4 col-md-4 org_pp mb-2">
                            <label for="organismo-caso">Organismo del Poder Poular</label>
                            <select id="organismo-caso" name="organismo-caso" class="form-control compact-form-control">
                            <option value="0">Seleccione Organismo</option>
                            </select>
                        </div>
                                        
     <div class="col-md-9">
    <div class="d-flex align-items-center" style="height: 100%;">
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
                     

  
                        </div>
                        
                    </div>
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
                    <td class="text-center" style="width: 1%;">Nº</td>
                    <td class="text-center" style="width: 1%;">Cédula</td>
                    <td class="text-center" style="width: 1%;">Tipo Ben</td>
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