<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidado de Casos</title>
    <style>
        /* 3. COMPACTAR EL LOGO/CINTILLO (AJUSTADO) */
        .navbar img, 
        .cintillo-compacto { 
            height: 60px; 
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            display: block; 
        }
        
        /* ⭐ Estilos que hacen los campos más compactos y visibles (AJUSTADOS) ⭐ */
        .compact-form-control {
            height: calc(1.9rem + 2px) !important;
            padding: .25rem .5rem !important;     
            font-size: .875rem !important;        
            width: 100% !important; 
        }
        
        .card-body label {
            font-size: 0.9rem;
            margin-bottom: .1rem;
            display: block; 
        }
        
        .compact-input-edad {
            width: 65px !important; 
            height: calc(1.9rem + 2px) !important;
            padding: .25rem .5rem !important;
            font-size: .875rem !important;
            display: inline-block;
        }
        
        .col-compact {
            padding-right: 5px; 
            padding-left: 5px;
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            height: calc(1.9rem + 2px) !important; 
            padding: .25rem .5rem !important;
            font-size: .875rem !important;
            max-width: 200px; 
            display: inline-block; 
        }
        
        div.dataTables_wrapper div.dataTables_filter label {
            font-size: 0.9rem;
        }
        



        
        /* ESTILOS CORREGIDOS PARA EL MODAL */
        .modal {
            position: fixed;
            left: 59% !important; 
            top: 50;
            width: 80%;
            height: 80%;
            display: none;
            z-index: 1050;
            overflow-y: auto; /* Permite scroll en el modal si es necesario */
        }
        
 .modal-content {
  /* Anular el border-top y border-bottom fijos */
  border-top: 1px solid #dee2e6 !important; /* Estilo de borde Bootstrap estándar */
  border-bottom: 1px solid #dee2e6 !important; /* Estilo de borde Bootstrap estándar */
  
  /* Asegura que 15px se aplica sobre cualquier rounded-lg (8px) de Tailwind */
  border-radius: 15px !important; 
  
  text-decoration: none;
  font-size: 14px;
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
</head>

<body class="font-sans bg-gray-100">

<div class="content-wrapper">
  
  <div class="content">

    <div class="container-fluid p-4 lg:p-6">
        
        <div class="row">
            <div class="w-full p-2"> 
                <div class="card bg-white shadow-xl rounded-xl overflow-hidden border-t-4 border-primary-blue">
                    <div class="card-header border-b border-gray-200 p-3 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <h3 class="text-primary text-lg font-bold text-gray-500">
                                <i class="fas fa-filter mr-2"></i> Filtros de Consolidado de Casos
                            </h3>
                        </div>
                    </div>

                    <div class="card-body p-3 sm:p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-x-1">
                            
                            <div class="mb-2 col-compact"> 
                                <label for="desde">Desde:</label>
                                <input type="date" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="mb-2 col-compact">
                                <label for="hasta">Hasta:</label>
                                <input type="date" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="mb-2 col-compact">
                                <label for="sexo">Género:</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="sexo" name="sexo">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="mb-2 col-compact">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="mb-2 col-compact">
                                <label for="via-atencion">Via de Atención:</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>
                            <div class="mb-2 col-compact">
                                <label for="tipo-atencion-usu">Tipo de Atención:</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>

                            <div class="mb-2 col-compact detalle_atencion" style="display: none;">
                                <label for="edit_detelle_atencion">Detalle Atencion</label>
                                <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="edit_detelle_atencion" name="detalles_atencion">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2 pt-2 border-t border-gray-300">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-1">
                                
                                <div class="mb-2 col-compact">
                                    <label for="tipo-pi">Tipo de Propiedad Intelectual:</label>
                                    <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="tipo-pi" name="tipo-pi">
                                        <option value="0" selected disabled>seleccione</option>
                                    </select>
                                </div>
                            
                                <div class="mb-2 col-compact">
                                    <label for="estatus">Estatus:</label>
                                    <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="estatus" name="estatus">
                                        <option value="0" selected disabled>seleccione</option>
                                        <option value="1">Abierto</option>
                                        <option value="2">Cerrado</option>
                                    </select>
                                </div>

                                <div class="mb-2 col-compact">
                                    <label for="direcciones_caso">Dirección Administrativa:</label>
                                    <select class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue" id="direcciones_caso" name="direcciones_caso">
                                        <option value="0" selected disabled>Seleccione</option>
                                        <?php echo $direcciones; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-1">
                                <div class="mb-2 col-compact">
                                    <label for="pais-caso">País</label>
                                    <select id="pais-caso"  name=" pais-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                        <option value="1" selected >Venezuela</option>
                                    </select>
                                </div>

                                <div class="mb-2 col-compact">
                                    <label for="estado-caso">Estado</label>
                                    <select id="estado-caso" name="estado-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                        <option value="0" disabled>Seleccione Estado</option>
                                    </select>
                                </div>
                                <div class="mb-2 col-compact">
                                    <label for="municipio-caso">Municipio</label>
                                    <select id="municipio-caso" name="municipio-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                    <option value="0" selected >Seleccione Municipio</option>
                                    </select>
                                </div>
                                
                                <div class="mb-2 col-compact">
                                    <label for="parroquia-caso">Parroquia</label>
                                    <select id="parroquia-caso" name="parroquia-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                    <option value="0">Seleccione Parroquia</option>
                                    </select>
                                </div>  
                            </div>

                            <div class="flex flex-wrap items-end pt-2 border-t border-gray-300 mt-2">
                                
                                <div class="w-full lg:w-9/12 flex flex-wrap items-end gap-y-2"> <div class="w-full sm:w-1/2 md:w-1/3 pr-2 mb-2 org_pp col-compact">
                                        <label for="organismo-caso">Organismo del Poder Popular</label>
                                        <select id="organismo-caso" name="organismo-caso" class="compact-form-control border border-gray-300 rounded-lg focus:ring focus:ring-primary-blue">
                                        <option value="0">Seleccione Organismo</option>
                                        </select>
                                    </div>
                                                
                                    <div class="w-full sm:w-1/2 md:w-2/3 flex items-center mb-2">
                                        <label for="edad_min" class="pr-3 mb-0 text-sm font-medium text-gray-700">Edad:</label>
                                        
                                        <label for="edad_min" class="mb-0 text-sm font-normal mr-1">Desde:</label>
                                        <input type="number" class="compact-input-edad mr-3 border border-gray-300 rounded-lg focus:ring focus:ring-green-500" id="edad_min" min="0" name="edad_min">
                                        
                                        <label for="edad_max" class="mb-0 text-sm font-normal mr-1">Hasta:</label>                                
                                        <input type="number" class="compact-input-edad border border-gray-300 rounded-lg focus:ring focus:ring-green-500" id="edad_max" min="0" name="edad_max">
                                    </div>
                                </div>


                                <div class="w-full lg:w-3/12 flex justify-start lg:justify-end gap-2 mb-2">
                                    <button type="button" class="consultar inline-flex items-center px-4 py-2 font-semibold text-sm rounded-lg shadow-md bg-primary-blue text-white hover:bg-primary-dark transition duration-300 ease-in-out transform hover:scale-[1.02]">
                                        <i class="fas fa-search mr-1"></i> Consultar
                                    </button>
                                    <button type="button" class="limpiar inline-flex items-center px-4 py-2 font-semibold text-sm rounded-lg shadow-md bg-gray-200 text-gray-700 border border-gray-300 hover:bg-gray-300 transition duration-300 ease-in-out">
                                        <i class="fas fa-eraser mr-1"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
   
      
      <div class="row">
        <div class="w-full">
          <div class="card bg-white shadow-xl rounded-xl">
            <div class="card-body p-4 sm:p-6">
              <div class="overflow-x-auto">
                <table class="display min-w-full divide-y divide-gray-200" id="table_casos" style="width:100%; margin-top: 20px">
                  <thead class="bg-theme-gray text-white uppercase text-xs font-semibold tracking-wider">
                    <tr>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 1%;">Nº</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 1%;">Cédula</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 1%;">Tipo Ben</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 12%;">Beneficiario</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 3%;">Teléfono</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 6%;">Propiedad Intelectual</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 2%;">T.Atención</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 1%;">Fecha</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 1%;">Estatus</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 12%;">Dirección Remitida</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 5%;">Operador</td>
                      <td class="text-center py-3 px-3 whitespace-nowrap" style="width: 5%;">Detalle</td>
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

    <div class="modal fade" id="modal-detalle-seguimientos" tabindex="-1" role="dialog" 
     aria-labelledby="SeguimientosModalLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-xl max-w-7xl mx-auto modal-dialog-centered" role="document">
        <div class="modal-content bg-white shadow-2xl w-full transform transition-all duration-300 overflow-hidden"> 

            <div class="modal-header flex justify-between items-center p-2 border-b border-blue-100 bg-blue-700 text-white">
    <h5 class="text-lg font-bold tracking-tight" id="SeguimientosModalLabel">
        <i class="fas fa-angle-double-right mr-2 text-xl"></i> Seguimientos del Caso Nº
        <span class="text-blue-700 bg-white ml-2 px-1.5 py-0.5 text-base rounded-full shadow-sm font-mono" id="caso-id-titulo">
        </span>
    </h5>
    <button type="button" class="text-white opacity-90 hover:opacity-100 text-xl leading-none transition duration-150" data-dismiss="modal" aria-label="Cerrar">
        &times;
    </button>
</div>

            <div class="modal-body p-4">
                
                <div class="grid grid-cols-12 gap-4">
                    
                    <div class="col-span-12 lg:col-span-9 order-2 lg:order-1" id="tl" style="display: none;"> 
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">
                            <i class="fas fa-list-alt mr-2 text-blue-500"></i> Historial de Seguimientos
                        </h4>
                        
                        <div class="p-0">
                            <div class="overflow-x-auto shadow-md rounded-md border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200" id="table_seguimientos">
                                    <thead class="bg-blue-50">
                                        <tr>
                                            <td class="px-3 py-2 text-xs font-bold text-blue-800 uppercase tracking-wider text-center w-[1%]">Nº</td>
                                            <td class="px-3 py-2 text-xs font-bold text-blue-800 uppercase tracking-wider text-center w-[1%]">F_Seguimiento</td>
                                            <td class="px-3 py-2 text-xs font-bold text-blue-800 uppercase tracking-wider text-center w-[4%]">Estatus/llamada</td>
                                            <td class="px-3 py-2 text-xs font-bold text-blue-800 uppercase tracking-wider text-center w-[4%]">Usuario Operador</td>
                                            <td class="px-3 py-2 text-xs font-bold text-blue-800 uppercase tracking-wider text-center w-[7%]">Comentario</td>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100 text-sm" id="listar_seguimientos">
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-12 lg:col-span-3 order-1 lg:order-2 p-3 lg:border-l lg:border-l-0 border-gray-200 bg-gray-50 rounded-lg shadow-inner">
                        <h3 class="text-base font-bold text-blue-700 mb-3 border-b-2 border-gray-300 pb-1">
                            <i class="fas fa-info-circle mr-2"></i> Información General
                        </h3>
                        <input type="hidden" id="id-caso" name="id-caso">
                        <div class="text-xs text-gray-700 space-y-2">
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Fecha del caso:</b>
                                <span class="text-black font-medium" id="detalle-fecha-caso"></span>
                            </div>
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Nombre y Apellido:</b>
                                <span class="text-black font-medium" id="detalle-nombre"></span>
                            </div>
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Correo Beneficiario:</b>
                                <span class="text-black font-medium" id="detalle-correo"></span>
                            </div>
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Estado:</b>
                                <span class="text-black font-medium" id="detalle-estado"></span>
                            </div>
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Municipio: </b>
                                <span class="text-black font-medium" id="detalle-municipio"></span>
                            </div>
                            <div class="leading-snug border-b border-gray-200 pb-1">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Parroquia:</b>
                                <span class="text-black font-medium" id="detalle-parroquia"></span>
                            </div>
                            <div class="pt-2 leading-snug">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Descripción del caso:</b>
                                <span class="text-black font-medium" id="detalle-descripcion"></span>
                            </div>
                            <div class="leading-snug">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Caso Remitido a:</b>
                                <span class="text-black font-medium" id="detalle-unidad-adm"></span>
                            </div>
                            <div class="pt-2">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">DOCUMENTOS CASO:</b>
                                <select class="w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-1 text-xs" id="docu-casos" name="docu-casos">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="pt-2 leading-snug">
                                <b class="block font-semibold text-gray-900 text-xs uppercase">Detalles adicionales:</b>
                                <span class="text-black font-medium" id="detalle-usuario-operador"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer flex justify-end p-3 border-t border-gray-200 bg-gray-50"> 
                <button type="button" class="inline-flex justify-center rounded-lg shadow-sm px-4 py-1.5 bg-red-500 text-sm font-semibold text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
    </div>
  </div>
</div>