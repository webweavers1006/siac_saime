
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
  <style>
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
  </style>
  <!-- Main content -->
  <div class="content">

    <div class="container-fluid">

      <!--Form-->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">

        <div class="card-header">
              <div class="d-flex justify-content-between">
                <h3 class="text-primary"><i class="fas fa-angle-double-right"></i>Participantes Mediación

                </h3>
              </div>
            </div>
          <div class="card">
            
            <div class="card-body">
              <table class="display table-responsive" id="table_participantes_mediacion" style="width:100%" style="margin-top: 20px">
                <thead>
                  <tr>
                      <td class="text-center" style="width: 1%;">Nº</td>
                      <td class="text-center" style="width: 11%;">Nombres y Apellidos</td>
                      <td class="text-center" style="width: 11%;">Tipo</td>
                      <td class="text-center" style="width: 2%;">Cédula-Rif</td>
                      <td class="text-center" style="width: 1%;">Correo</td>
                      <td class="text-center" style="width: 2%;">telefono</td>
                      <td class="text-center" style="width: 1%;">Direccion</td>
                      <td class="text-center" style="width: 1%;">Acciones</td>
                     
                  </tr>
                </thead>
                <tbody id="listar_participantes_mediacion">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarModalLabel">
                    <i class="fas fa-edit mr-2"></i> Editar Información del Participante
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="form-editar-participante" method="POST" role="form">
                <div class="modal-body">

                    <input type="hidden" id="data-ter_id" name="ter_id"> 
                    
                    <h6 class="mb-3 text-primary">Datos Personales</h6>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="data-ter_nombre">Nombres y Apellidos:</label>
                            <input type="text"  onkeyup="mayus(this);" class="form-control" id="data-ter_nombre" name="ter_nombre" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="data-ter_tipo_per">Tipo de Persona:</label>
                            <select class="form-control" id="data-ter_tipo_per" name="ter_tipo_per">
                                <option value="V">V</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="data-ter_identificacion">Cédula/Rif:</label>
                            <input type="text"   onkeyup="mayus(this);" class="form-control" id="data-ter_identificacion" name="ter_identificacion">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="data-ter_telefono">Teléfono:</label>
                            <input type="text"  onkeypress="return valideKey(event);" class="form-control" id="data-ter_telefono" name="ter_telefono">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="data-ter_correo">Correo Electrónico:</label>
                            <input type="email"  onkeyup="mayus(this);" class="form-control" id="data-ter_correo" name="ter_correo">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="data-ter_direccion">Dirección:</label>
                            <input type="text"  onkeyup="mayus(this);" class="form-control" id="data-ter_direccion" name="ter_direccion">
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3 text-primary">Ubicación Detallada</h6>

                    <div class="form-row">
        <div class="col-3">
              <label for="pais-caso">País</label>
              <select id="pais-caso"  name=" pais-caso" class="form-control">
              <option value="1" selected >Venezuela</option>
              </select>
          </div>
          <div class="col-3">
              <label for="estado-caso">Estado</label>
              <select id="estado-caso" name="estado-caso" class="form-control">
              <option value="0" disabled>Seleccione Estado</option>

              </select>
          </div>
          <div class="col-3">
              <label for="municipio-caso">Municipio</label>
              <select id="municipio-caso" name="municipio-caso" class="form-control">
              <option value="0">Seleccione Municipio</option>
              </select>
          </div>

          <div class="col-3">
              <label for="parroquia-caso">Parroquia</label>
              <select id="parroquia-caso" name="parroquia-caso" class="form-control">
              <option value="0">Seleccione Parroquia</option>
              </select>
          </div>
                    </div>
           


                </div>
                <div class="modal-footer ">
                    <button type="reset" class="btn btn-sm btn-light">Limpiar</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="btn-cerrar-edicion">Cerrar</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn-guardar-edicion">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
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
  <!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>