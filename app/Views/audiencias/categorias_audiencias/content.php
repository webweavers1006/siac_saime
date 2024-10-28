<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/modal_permisos.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>
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
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Categorias Audiencias
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-categorias">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-11 col-sm-11 col-md-11 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_categorias" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 20%;">Descripcion</td>
                              <td class="text-center" style="width: 20%;">Departamento</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_categorias">
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
      <!-- /.content-wrapper -->
      <!-- Modal para añadir categorias-->
      <div class="modal fade" id="add-categorias">
        <div class="modal-dialog  modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Categoria</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="new-categoria" method="POST" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="text" onkeyup="mayus(this);" name="name-descripcion"  id="name-categoria" class="form-control" autocomplete="off" required>
                </div>

                <div class="form-group">
                  <label for="user-name">Departamento</label>
                  <select name="id_departamento" id="id_departamento">
                          <option value="0" selected>---Seleccione un Departamento---</option>
                          <option value="1" >Marcas</option>
                          <option value="2" >Patentes</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="user-name">Categoria de Cierre</label>
                  <select name="id_cierre" id="id_cierre">
                  <option value="0" selected>---Seleccione---</option>
                          <option value="1" >Si</option>
                          <option value="2" >No</option>
                  </select>
                </div>
                
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary" type="submit">Guardar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal para editar categorias-->
      <div class="modal fade" id="editar">
        <div class="modal-dialog  modal-dialog-centered modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Categorias</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="edit-categoria" method="POST" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Descripcion</label>
                  <input type="hidden" name="id-categoria" id="id-categoria" class="form-control">
                  <input type="text" onkeyup="mayus(this);" name="name-rol"  id="editar-categoria" class="form-control"  autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="user-name">Departamento</label>
                  <select name="edit_id_departamento" id="edit_id_departamento">
                          <option value="1" >Marcas</option>
                          <option value="2" >Patentes</option>
                      </select>
                </div>

                <div class="form-group">
                  <label for="user-name">Categoria de Cierre</label>
                  <select name="edit_id_cierre" id="edit_id_cierre">
                          <option value="2" >Si</option>
                          <option value="1" >No</option>
                  </select>
                </div>


                <label for="user-email">Activo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="terminos" id="id_condicion" class="form-check-input">
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary" type="submit">Actualizar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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