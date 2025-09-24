<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>



<!-- <link rel="stylesheet" href="<php echo base_url(); ?>/datatable_responsive/css/responsive.bootstrap4.css"> -->
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/pantalla_casos.css">


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content  fluid-->
  <div class="content">
    <div class="container-fluid">
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Pantalla de Casos <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar">Agregar</button></h3>
                <input type="hidden" name="" id="rol_usuario" value="<?php echo($session->get('userrol'));?>">
                </h3>
                <input type="hidden" name="" id="mensaje_documento" value="<?php echo $mensaje ?>">
<!--  -->
                
              </div>
              <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 ">
                    
                        <table class="display table-responsive" id="table_casos" style="width:100%" style="margin-top: 20px">
                        <thead>
                          <tr>
                            <td class="col" style="width: 1%;">Nº</td>
                            <td class="text-center" style="width: 1%;">Cédula</td>
                            <td class="text-center" style="width: 12%;">Beneficiario</td>
                            <td class="text-center" style="width: 3%;">Teléfono</td>
                            <td class="text-center" style="width: 8%;">Propiedad Intelectual</td>
                            <td class="text-center" style="width: 4%;">Tipo de Atención</td>
                            <td class="text-center" style="width: 3%;">Fecha</td>
                            <td class="text-center" style="width: 3%;">Estatus</td>
                            <td class="text-center" style="width: 6%;">Operador</td>
                            <td class="text-center" style="width: 10%;">Acciones</td>
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
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <style>
      #editCase {
      overflow-y: auto;
      max-height: auto; /* adjust the max-height value as needed */
    }
    </style>
 

    <!-- Modal para editar casos-->
    <div class="modal fade" id="editCase">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="text-secondary"><i class="fas fa-angle-double-right"></i> EDICION DE CASO</h4>

            <br>

          </div>
          <div class="card-body  ">
            <!--Form-->
            <div class="row">
              <div class="col-lg-12 col-sm-12 col-md-12 ">
                <div class="card">
                  <!-- <form role="form" id="editar_caso" name="editar_caso"> -->
                  <input type="hidden" id="id_caso">
                 
                    <div class="form-group">
                     
                        <div class="form-group">
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
                          <!-- CAMPOS PARA DE ASESORIA PARA VALIDAR SI FUERON MODIFICADOS -->
                          <input type="hidden" id="ente_anterior" name="" value="">
                          <input type="hidden" id="cgr_anterior" name="" value="">
                          <input type="hidden" id="azume_anterior" name="" value="">
                          <!-- CAMPOS PARA DE DENUNCIAS PARA VALIDAR SI FUERON MODIFICADOS -->
                          <input type="hidden" id="afecta_hechos_anterior" name="" value="" autocomplete="off">
                          <input type="hidden" id="fecha_hechos_anterior" name="" value="">
                          <input type="hidden" id="involucrados_anterior" name="" value="">
                          <input type="hidden" id="nombre_instancia_anterior" name="" value="">
                          <input type="hidden" id="rif_instancia_anterior" name="" value="">
                          <input type="hidden" id="ente_financiador_anterior" name="" value="">
                          <input type="hidden" id="nombre_proyecto_anterior" name="" value="">
                          <input type="hidden" id="monto_aprobado_anterior" name="" value="">
                          <div class="row">

                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="nombre-persona">Nombre</label>
                              <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-persona" id="nombre-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="apellido-persona">Apellido</label>
                              <input type="text" class="form-control" onkeyup="mayus(this);" name="apellido-persona" id="apellido-persona" onkeypress="noNumeros(event)" autocomplete="off" required>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="tipo-persona">Tipo Persona</label>
                              <select class="form-control" id="tipo-persona" name="tipo-persona">
                                <option value="V">V - Venezolano</option>
                                <option value="E">E - Extranjero</option>
                                <option value="J">J - Juridico</option>
                                <option value="G">G - Gobierno</option>
                              </select>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="cedula-persona">Nº cedula o Rif</label>
                              <input type="text" class="form-control" name="cedula-persona" min="7" id="cedula-persona" autocomplete="off" required>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-md-1">
                              <label for="edad">Edad</label>
                              <input type="text" disabled class="form-control" onkeyup="mayus(this);" name="edad" id="edad" onkeypress="return valideKey(event);" autocomplete="off" required>
                          </div>
                          
                          <div class="col-lg-2 col-sm-2 col-md-2">
                              <label for="fecha-nacimiento">Fecha de Nac.</label>
                              <input class="form-control" type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
                          </div>
                          <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="apellido-persona">Profesión</label>
                              <input type="text" class="form-control" onkeyup="mayus(this);" name="profesion" id="profesion" onkeypress="noNumeros(event)" autocomplete="off" required>
                          </div>


                            <div class="col-lg-3 col-sm-3 col-md-3">
                         
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" disabled>Seleccione</option>
                                </select>
                            
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="tipo-persona">Genero</label>
                              <select class="form-control" id="sexo" name="tipo-persona">
                                <option value="1">Masculino</option>
                                <option value="2">Femenino</option>
                              </select>
                            </div>



                            <div class="col-lg-3 col-sm-3 col-md-3">
                              <label for="telefono-persona">Teléfono</label>
                              <input type="text" class="form-control" onkeypress="return valideKey(event);" 
                              maxlength="12" pattern="\d{12}" title="Debe ingresar exactamente 12 dígitos" 
                              name="telefono" id="telefono" autocomplete="off">
                              </div>
                                                <div class="col-lg-2 col-sm-2 col-md-2">
                              <label for="fecha-recibido">Fecha de Recibido</label>
                              <input class="form-control" type="date" name="fecha-recibido" id="fecha-recibido" required>
                            </div>
                          <div class="col-lg-3 col-sm-3 col-md-3">
                          <label for="red-social">Via de Atencion</label>
                          <select class="form-control" name="red-social" id="red-social">
                            <option value="0" disabled>Seleccione</option>

                          </select>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4">
                          <label for="">Atención al Cuidadano</label>
                          <select class="form-control" name="office" id="office">
                            <option value="1">Dirección de Atención al Ciudadano</option>
                            <option value="2">Coordinador Estadal</option>
                          </select>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-md-5">
                          <label for="tipo-pi">Correo Electronico</label>
                          <input type="email" class="form-control" name="correo" id="correo" autocomplete="off" required>
                        </div>
                      

                        </div>   

                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                          <label for="direccion" style="display: none;">Dirección</label>
                          <input type="text" style="display: none;" class="form-control" name="direccion" id="direccion" autocomplete="off">
                        </div>
                      </div>
                      
                                    <div class="row">

                        <div class="col-4">
                          <label for="pais-caso">País</label>
                          <select id="pais-caso"  name="pais-caso" class="form-control">
                            <option value="1" selected >Venezuela</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="estado-caso">Estado</label>
                          <select id="estado-caso" name="estado-caso" class="form-control">
                            <option value="0" disabled>Seleccione Estado</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="municipio-caso">Municipio</label>
                          <select id="municipio-caso" name="municipio-caso" class="form-control">
                            <option value="0">Seleccione Municipio</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="parroquia-caso">Parroquia</label>
                          <select id="parroquia-caso" name="parroquia-caso" class="form-control">
                            <option value="0">Seleccione Parroquia</option>
                          </select>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4">
                          <label for="tipo-pi">Tipo de Atención</label>
                          <select class="form-control" id="tipo-atencion-usu" name="tipo-atencioni-usu">
                            <option value="0" disabled>Seleccione</option>
                          </select>
                        </div>  
                   

                        <div class="col-lg-4 col-sm-4 col-md-4 prop_int oculto">
                          <label for="tipo-pi">Tipo de Propiedad Intelectual </label>
                          <select disabled class="form-control " id="tipo-pi" name="tipo-pi">
                              <option value="0" disabled>Seleccione</option>
                          </select>
                      </div>

                      <div class="col-lg-3 col-sm-3 col-md-3 org_pp ">
                        <label for="organismo-caso">Organismo del Poder Poular</label>
                        <select id="organismo-caso" name="organismo-caso" class="form-control">
                        <option value="0">Seleccione Organismo</option>
                        </select>
                      </div>
<input type="hidden" id="actcoordenadas">
                      <div class="col-lg-4 col-sm-4 col-md-4 detalle_atencion oculto">
                          <label for="tipo-pi">Detalle Atencion</label>
                          <select disabled class="form-control" id="edit_detelle_atencion" name="detalles_atencion">
                              <option value="0" disabled>Seleccione</option>
                          </select>
                      </div>

                      
                        <input type="hidden"  class="form-control"  id="id_hijos_detalle_atencion" >
                      </div>
                    </div>

                    

          </div>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 mapa_ayuda" style="display: none;">
        <form id="guardar_ayudas" method="POST" role="form">
            <div class="col-lg-12 col-sm-12 col-md-12 modal-body">
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                      crossorigin=""/>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                        crossorigin=""></script>

                <style>
                    #map {
                        width: 100%;
                        height: 500px;
                        box-shadow: 5px 5px 5px #888;
                        margin-bottom: 20px;
                    }
                    .form-container {
                        width: 100%;
                        padding: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                        border-radius: 8px;
                        margin-bottom: 20px;
                    }
                    .form-container label, .form-container input {
                        display: block;
                        margin-bottom: 10px;
                    }
                    .form-container input[type="text"] {
                        width: 90%;
                        padding: 8px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }
                    .form-container button {
                        padding: 10px 15px;
                        background-color: #0078A8;
                        color: white;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        margin-right: 5px;
                    }
                    .form-container button:hover {
                        background-color: #005f88;
                    }
                </style>

                <div class="form-container">
                    <h2>Coordenadas de la ubicación</h2>
                    <div>
                        <label for="latitude">Latitud:</label>
                        <input type="text" id="latitude" name="latitude" placeholder="Ej: 10.4806">
                        <label for="longitude">Longitud:</label>
                        <input type="text" id="longitude" name="longitude" placeholder="Ej: -66.9036">
                        <label for="locationName">Nombre del lugar:</label>
                        <input type="text" id="locationName" name="locationName" placeholder="Ej: La Vega, Los Mangos">
                        <button id="ubicar-btn" type="button">Ubicar en el mapa</button>
                        <button id="limpiar-btn" type="button">Limpiar</button>
                    </div>
                </div>

                <div id='map'></div>

               
            </div>
        </form>
    </div>
</div>

                    <!-- FORMULARIO PARA EL CASO DE ASESORIA -->
                    <div class="row" id="cgr" style="display: block;">

                      <div class="col-lg-4 col-sm-4 col-md-4">
                        <label for="competancia-cgr">Ente asdcrito</label>
                        <select class="form-control" id="ente_adscrito_id" name="competencia-cgr" value="0">
                          <option value=" 0" selected disabled>Seleccione</option>
                        </select>
                      </div>
                      <div class="col-lg-3 col-sm-3 col-md-3">
                        <label for="competancia-cgr">Competencia de CGR</label>
                        <select class="form-control" id="competencia-cgr" name="competencia-cgr" value="0">
                          <option value="0" selected disabled>Seleccione</option>
                          <option value="1">Si</option>
                          <option value="2">No</option>
                        </select>
                      </div>
                      <div class="col-lg-3 col-sm-3 col-md-3">
                        <label for="asume-cgr">Asume CGR</label>
                        <select class="form-control" id="asume-cgr" name="asume-cgr" value="0">
                          <option value="0" selected disabled>Seleccione</option>
                          <option value="1">Si</option>
                          <option value="2">No</option>
                        </select>
                      </div>
                    </div>
                    <!-- FORMULARIO PARA EL CASO DE DENUNCIAS -->
                    <div class="row" id="denuncias" style="display: none;">
                      <div class="col-lg-6">
                        &nbsp;&nbsp; <label for="asume-cgr">A quien afecta el hecho:</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="option-personal" value="Personal" name="option">&nbsp;&nbsp;&nbsp;
                        <span>Personal</span>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="option-comunidad" value="Comunidad" name="option">&nbsp;&nbsp;&nbsp;
                        <span>Comunidad</span>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="option-terceros" value="Terceros" name="option">&nbsp;&nbsp;&nbsp;
                        <span>Terceros</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </div>
                      <label for="fecha-hechos">Fecha de los hechos</label>
                      <div class="col-lg-3">
                        <input class="form-control" type="date" name="fecha-hechos" id="fecha-hechos" value=" ">
                      </div>

                      <div class="col-10">
                        &nbsp;&nbsp;<label for="denu-involucrados">Indique personas , Organismos o Instituciones , Involucradas en los hechos :</label>
                        <textarea type="text" class="form-control" onkeyup="mayus(this);" name="denu-involucrados" id="denu-involucrados" required>
                                  </textarea>
                      </div>
                      <div class="col-11">
                        <br>
                        <label>EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE :</label>
                        <div class=" row">
                          <div class="col-lg-5 col-sm-5 col-md-5">
                            <label for="nombre-instancia">Nombre de la instancia del Poder Popular</label>
                            <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-instancia" id="nombre-instancia" autocomplete="off">
                          </div>
                          <div class="col-lg-3 col-sm-3 col-md-3">
                            <label for="rif-instancia">Rif:</label>
                            <input type="text" class="form-control" onkeyup="mayus(this);" name="rif-instancia" id="rif-instancia" autocomplete="off">
                          </div>
                          <div class="col-lg-4 col-sm-4 col-md-4">
                            <label for="ente-financiador">Ente Financiador:</label>
                            <input type="text" class="form-control" onkeyup="mayus(this);" value=" " name="ente-financiador" id="ente-financiador" autocomplete="off">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-5 col-sm-5 col-md-5">
                            <label for="nombre-proyecto">Nombre del Proyecto:</label>
                            <input type="text" class="form-control" onkeyup="mayus(this);" name="nombre-proyecto" id="nombre-proyecto" autocomplete="off">
                          </div>
                          <div class="col-lg-3 col-sm-3 col-md-3">
                            <label for="monto-aprovado">Monto Aprobado:</label>
                            <input type="text" class="form-control" onkeypress="return valideKey(event);" name="monto-aprovado" id="monto-aprovado" onkeypress="noNumeros(event)" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-12">
                        <label for="planteamiento-caso">Descripción del Caso</label>
                        <textarea type="text" class="form-control" name="requerimiento-usuario" id="requerimiento-usuario" required>
                          </textarea>
                      </div>
                    </div>

                   
                    <div class="row">
                    
                      <form id="miFormulario" enctype="multipart/form-data">
                     &nbsp;&nbsp; <input type="file" class="mi-estilo" id="archivo" name="archivo">
                        <input type="hidden" id="id_caso_pdf" name="id_caso_pdf">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" id="subir_archivos" enctype="multipart/form-data" class="btn btn-sm btn-primary" value="Subir archivo">
                      </form>&nbsp;&nbsp;&nbsp;&nbsp;
                      <label for="t-beneficiario">DOCUMENTOS CASO</label>
                      <select class="form-control" style="width: 350px;" id="docu-casos" name="docu-casos">
                        <option value="0" selected disabled>Seleccione</option>
                      </select>
                      <br />
                    </div>

                    </div>
<style>
.notification-card {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 80%; /* Cambia el ancho a un porcentaje */
    max-width: 600px; /* Establece un ancho máximo si es necesario */
}
.notification-card h2 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #333;
}
.notification-card p {
  margin: 0;
  font-size: 14px;
  color: #555;
}
.extensions {
    margin-top: 10px;
    font-weight: bold;
}

body {
    margin: 0;
    padding: 1em;
    font-family: Arial, sans-serif;
  }
.extensions2 {
    color: blue;
    text-align: center;
    font-size: 1.2rem;
    margin: 1em 0;
    white-space: nowrap;
  }
</style>
                    
                    <div class="notification-card">
                      <h2>Extensiones Permitidas</h2>
                      <p class="extensions">.jpg, .jpeg, .png, .pdf, .doc, .docx, .ods, .xls, .xlsx, .mp4, .mp3, .m4a, .m4v, .mov, .wmv, .avi, .mkv, .swf, .odt </p>
                      <p class="extensions2">Tamaño Maximo 10MB  </p>
                    </div>
                  
                  <div class="modal-footer ">
                    <!-- <button class="btn btn-light" type="reset">Limpiar</button> -->
                    <button class="btn  btn-sm btn-primary" id="editar_caso" type="submit">Guardar</button>
                    <button type="button" class="btn  btn-sm  btn-danger" data-dismiss="modal">Cerrar</button>
                  </div>
                  <!-- </form> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!--/.Remitir caso-->
    <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 5) { ?>
      <div class="modal fade" id="remitir_caso">
        <div class="modal-dialog  modal-dialog-centered modal-md">
          <div class="modal-content">
            <form id="caso-remitido" method="POST">
              <div class="modal-header">
                <h4 class="modal-title">Remitir Caso</h4>
                <input type="hidden" id="idcaso" name="" value="">
                <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="direcciones_caso">Direcciones administrativas</label>
                  <select id="direcciones_caso" name="direcciones_caso" class="form-control">
                    <?php echo $direcciones; ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="reset" class="btn btn-sm  btn-default" data-dismiss="modal">Cerrar</button>
                
                <button type="submit" class="btn  btn-sm  btn-primary">Guardar</button>
              <label id="mensaje" style="display: none;">Espere un momento, esta ventana se cerrará automáticamente</label>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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