<?php
$session = session();
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>
<script src="<?php echo base_url(); ?>/custom/js/tailwindcss.js"></script>
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
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Tipo de Atención
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-tipo-atencion">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-11 col-sm-11 col-md-11 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_direcciones" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 20%;">Descripción</td>
                              <td class="text-center" style="width: 1%;">Estatus</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_tipo_atencion">
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
   <div class="modal fade" id="add-tipo-atencion">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tipo de Atencion</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new-atencion" method="POST" role="form">
        <div class="modal-body">
          <div class="form-group">
            <label for="name-atencion">Nombre</label>
            <input type="text" name="name-atencion" id="name-atencion" class="form-control" placeholder="Ej: ASESORIA" autocomplete="off" required>
          </div>

          <div class="form-group space-y-3">
            <label>Permisos:</label>

            <div class="flex items-center space-x-2">
              <label for="acceso_pro_int" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="acceso_pro_int" name="borrado" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="acceso_pro_int" class="text-sm font-medium text-gray-700">Propiedad Intelectual</label>
            </div>

            <div class="flex items-center space-x-2">
              <label for="participantes" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="participantes" name="participantes" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="participantes" class="text-sm font-medium text-gray-700">Acceso a participantes</label>
            </div>

            <div class="flex items-center space-x-2">
              <label for="correo" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="correo" name="correo" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="correo" class="text-sm font-medium text-gray-700">Correo</label>
            </div>

            <div class="flex items-center space-x-2">
              <label for="organismo_pp" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="organismo_pp" name="correo" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="organismo_pp" class="text-sm font-medium text-gray-700">Org del poder popular</label>
            </div>

            <div class="flex items-center space-x-2">
              <label for="coordenadas" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="coordenadas" name="coordenadas" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="coordenadas" class="text-sm font-medium text-gray-700">Coordenadas</label>
            </div>

            <div class="flex items-center space-x-2">
              <label for="punto_cuenta" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="punto_cuenta" name="punto_cuenta" value='false' class="sr-only peer" />
                <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
              </label>
              <label for="punto_cuenta" class="text-sm font-medium text-gray-700">Punto de Cuenta</label>
            </div>

          </div>
        </div>

        <div class="modal-footer ">
          <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
          <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
    </div>
  </div>
      <div class="modal fade" id="editar">
        <div class="modal-dialog modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Tipo de Atencion</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="edit-atencion" method="POST" role="form">
              <div class="modal-body">
    <div class="form-group">
        <label for="editar-atencion">Nombre</label>
        <input type="hidden" name="id-atencion" id="id-atencion" class="form-control">
        <input type="text" name="name-atencion" id="editar-atencion" class="form-control" placeholder="Ej: Direccion de tecnología" autocomplete="off" required>
    </div>

    <div class="form-group space-y-3">
        <label>Permisos:</label>
        
        <div class="flex items-center space-x-2">
          <label for="edit_acceso_pro_int" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_acceso_pro_int" name="borrado" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_acceso_pro_int" class="text-sm font-medium text-gray-700">Propiedad Intelectual</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="edit_participantes" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_participantes" name="edit_participantes" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_participantes" class="text-sm font-medium text-gray-700">Participantes</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="edit_correo" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_correo" name="edit_correo" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_correo" class="text-sm font-medium text-gray-700">Correo</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="edit_organismo_pp" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_organismo_pp" name="correo" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_organismo_pp" class="text-sm font-medium text-gray-700">Org del poder popular</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="edit_coordenadas" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_coordenadas" name="coordenadas" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_coordenadas" class="text-sm font-medium text-gray-700">Coordenadas</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="edit_punto_cuenta" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="edit_punto_cuenta" name="punto_cuenta" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="edit_punto_cuenta" class="text-sm font-medium text-gray-700">Punto de Cuenta</label>
        </div>

        <div class="flex items-center space-x-2">
          <label for="borrado" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="borrado" name="borrado" value='false' class="sr-only peer" />
            <span class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></span>
          </label>
          <label for="borrado" class="text-sm font-medium text-gray-700">Activo</label>
        </div>

      </div>
    </div>
              <div class="modal-footer ">
                <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
                <button class="btn  btn-sm btn-primary" type="submit">Guardar</button>
                <button type="button" class="btn  btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
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