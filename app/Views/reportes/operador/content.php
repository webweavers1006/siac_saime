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

.btn-xs-xs
{
    font-size: 12px;
}
</style>
<div class="content-wrapper">
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



    /* ⭐ ESTILOS COMPACTOS Y GENERALES ⭐ */
    
    /* 1. Controles de formulario (input, select) para mantener la altura compacta */
    .compact-form-control {
        height: calc(1.9rem + 2px) !important; 
        padding: .25rem .5rem !important;     
        font-size: .875rem !important;        
        width: 100% !important; 
    }
    
    /* 2. Etiquetas (Label): Optimizado para máxima compacidad vertical */
    .card-body label {
        font-size: 0.85rem; 
        margin-bottom: .05rem !important; /* MÁXIMA REDUCCIÓN DE MARGEN INFERIOR */
        display: block; 
        font-weight: 500; 
    }
    
    /* 3. Inputs de Edad compactos */
    .compact-input-edad {
        width: 65px !important; 
        height: calc(1.9rem + 2px) !important;
        padding: .25rem .5rem !important;
        font-size: .875rem !important;
        display: inline-block;
        text-align: center; 
    }
    
    /* 4. Ajuste de Padding de Card Body para reducir el espacio interno */
    .card-body-compact {
        padding: 0.75rem !important; 
    }

    /* 5. Estilo de encabezado para DataTables */
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
    
    /* 6. Ajuste específico para el select de Analistas en el encabezado */
    .custom-select-compact {
        height: calc(1.9rem + 2px) !important; 
        padding: .25rem 1.75rem .25rem .75rem !important; 
        font-size: .875rem !important;
        width: 300px !important;
        display: inline-block !important;
        vertical-align: middle;
    }
    
</style>
  
  <div class="content">
    <div class="container-fluid p-4"> 
        <div class="flex flex-wrap -mx-1">
            <div class="w-full p-1">
                <div class="bg-white shadow-xl rounded-xl overflow-hidden border-t-4 border-primary-blue"> 
                    
                    <div class="p-2 border-b border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 self-center">
                                <i class="fas fa-user-tie mr-2 text-primary-blue"></i> Reporte por Analistas 
                                <select class="custom-select custom-select-compact border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="usuarios" name="usuarios">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $usuarios; ?>
                                </select>
                            </h3>    
                        </div>
                    </div>
                    
                    <div class="card-body-compact">
                        <div class="flex flex-wrap -mx-1">
                            
                            <div class="w-full md:w-2/12 px-1 mb-1">
                                <label for="desde">Desde</label>
                                <input type="date" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="w-full md:w-2/12 px-1 mb-1">
                                <label for="hasta">Hasta</label>
                                <input type="date" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="w-full md:w-2/12 px-1 mb-1">
                                <label for="sexo">Género</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="sexo" name="sexo">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="w-full md:w-3/12 px-1 mb-1">
                                <label for="tipo-pi">Tipo de Propiedad Intelectual</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="w-full md:w-3/12 px-1 mb-1">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap -mx-1 mt-2 border-t pt-2 border-gray-300">
                            <div class="w-full md:w-2/12 px-1 mb-1">
                                <label for="via-atencion">Vía de Atención</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="w-full md:w-2/12 px-1 mb-1">
                                <label for="tipo-atencion-usu">Tipo de Atención</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            
                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="direcciones_caso">Dirección Administrativa:</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="direcciones_caso" name="direcciones_caso">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $direcciones; ?>
                                </select>
                            </div>
                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="pais-caso">País</label>
                                <select id="pais-caso"  name=" pais-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                <option value="1" selected >Venezuela</option>
                                </select>
                            </div>

                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="estado-caso">Estado</label>
                                <select id="estado-caso" name="estado-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                    <option value="0" disabled>Seleccione Estado</option>
                                </select>
                            </div>
                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="municipio-caso">Municipio</label>
                                <select id="municipio-caso" name="municipio-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                <option value="0" selected >Seleccione Municipio</option>
                                </select>
                            </div>
                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="parroquia-caso">Parroquia</label>
                                <select id="parroquia-caso" name="parroquia-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                <option value="0">Seleccione Parroquia</option>
                                </select>
                            </div>
                            <div class="w-full md:w-4/12 px-1 mb-1">
                                <label for="estatus">Estatus:</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="estatus" name="estatus">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">Abierto</option>
                                    <option value="2">Cerrado</option>
                                </select>
                            </div>

                            <div class="w-full md:w-4/12 px-1 mb-1 org_pp">
                                <label for="organismo-caso">Organismo del Poder Popular</label>
                                <select id="organismo-caso" name="organismo-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                <option value="0">Seleccione Organismo</option>
                                </select>
                            </div>
                        
                        </div> 
                        
                        <div class="flex flex-wrap -mx-1 mt-2 border-t pt-2 border-gray-300 items-end">
                            <div class="w-full md:w-9/12 px-1 mb-1">
                                <div class="flex items-center">
                                    <label for="estado-caso" class="pr-3 mb-0 font-medium text-sm">Edad-> </label>
                                    
                                    <label for="edad_min" class="mb-0 text-sm font-normal mr-1">Desde:</label>
                                    <input type="number" class="compact-input-edad mr-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-500" id="edad_min" min="0" name="edad_min">
                                    
                                    <label for="edad_max" class="mb-0 text-sm font-normal mr-1">Hasta:</label>                                
                                    <input type="number" class="compact-input-edad border border-gray-300 rounded-lg focus:ring focus:ring-green-500" id="edad_max" min="0" name="edad_max">
                                </div>
                            </div>

                            <div class="w-full md:w-3/12 px-1 text-right mb-1">
                                <button type="button" class="consultar inline-flex items-center px-3 py-1 font-semibold text-sm rounded-lg shadow-md bg-primary-blue text-white hover:bg-primary-dark transition duration-300 ease-in-out">
                                    <i class="fas fa-search mr-1"></i> Consultar
                                </button>
                                <button type="button" class="limpiar inline-flex items-center px-3 py-1 font-semibold text-sm rounded-lg shadow-md bg-gray-200 text-gray-700 border border-gray-300 hover:bg-gray-300 transition duration-300 ease-in-out">
                                    <i class="fas fa-eraser mr-1"></i> Limpiar
                                </button>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
  

       
      <div class="flex flex-wrap">
        <div class="w-full">
          <div class="card bg-white shadow-xl rounded-xl mt-4">
            <div class="card-body p-4"> 
              <div class="overflow-x-auto">
                <table class="display min-w-full divide-y divide-gray-200" id="table_casos" style="width:100%" style="margin-top: 20px">
                    <thead class="bg-theme-gray text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 1%;">N-Caso</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 1%;">Cédula</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 1%;">Tipo de Beneficiario</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 12%;">Beneficiario</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 3%;">Teléfono</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 6%;">Propiedad Intelectual</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 4%;">Tipo de Atención</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 1%;">Fecha</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 1%;">Estatus</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 12%;">Dirección Remitida</td>
                            <td class="text-center py-2 px-2 whitespace-nowrap" style="width: 5%;">Operador</td>
                        </tr>
                    </thead>
                <tbody id="listar_casos" class="divide-y divide-gray-200">
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
